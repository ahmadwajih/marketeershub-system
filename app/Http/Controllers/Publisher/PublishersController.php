<?php

namespace App\Http\Controllers\Publisher;

use App\Models\User;
use App\Models\City;
use App\Models\Role;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Category;
use App\Models\DigitalAsset;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\SocialMediaLink;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PublisherNeedToUpdateHisInfo;

class PublishersController extends Controller
{
    public string $module_name = 'publishers';

    public function edit_profile()
    {
        $id = auth()->id();

        if (auth()->user()->id != $id && !in_array($id, auth()->user()->childrens()->pluck('id')->toArray())) {
            $this->authorize('update_publishers');
        }
        $accountManagers = User::where('position', 'account_manager')->get();
        $publisher = User::findOrFail($id);
        if ($publisher->position != 'publisher') {
            return redirect()->route('admin.users.edit', $id);
        }
        $publisher->traffic_sources = explode(',', $publisher->traffic_sources);
        return view('publishers.publishers.edit', [
            'publisher' => $publisher,
            'countries' => Country::all(),
            'cities' => City::whereCountryId($publisher->country_id)->get(),
            'users' => User::where('position', 'account_manager')->whereStatus('active')->get(),
            'categories' => Category::whereType($publisher->team)->get(),
            'roles' => Role::all(),
            'currencies' => Currency::all(),
            'accountManagers' => $accountManagers,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        // dd($id);
        if (auth()->user()->id != $id) {
            $this->authorize('update_publishers');
        }
        $data = $request->validate([
            'name'                      => 'required|max:255',
            // 'email'                     => 'required|max:255|email:rfc,filter|unique:users,email,' . $id,
            'phone'                     => 'required|numeric|min:1|unique:users,phone,' . $id,
            'password'                  => ['nullable', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
            'country_id'                => 'nullable|exists:countries,id',
            'city_id'                   => 'nullable|exists:cities,id',
            'gender'                    => 'required|in:male,female',
            'parent_id'                 => 'nullable|numeric|exists:users,id',
            'status'                    => 'nullable|in:active,pending,closed',
            'team'                      => 'nullable|in:management,digital_operation,finance,media_buying,influencer,affiliate,prepaid',
            'skype'                     => 'nullable|max:255',
            'address'                   => 'nullable|max:255',
            'category'                  => 'nullable|max:255',
            'years_of_experience'       => 'nullable|numeric',
            'affiliate_networks'        => 'nullable|max:255',
            'referral_account_manager'  => 'nullable|exists:users,id',
            'account_title'             => 'required|required_if:position,publisher|max:255',
            'bank_name'                 => 'required|required_if:position,publisher|max:255',
            'bank_branch_code'          => 'required|required_if:position,publisher|max:255',
            'swift_code'                => 'required|required_if:position,publisher|max:255',
            'iban'                      => 'required|required_if:position,publisher|max:255',
            'currency_id'               => 'nullable|required_if:position,publisher|exists:currencies,id',
            'categories'                => 'nullable|array|required_if:position,publisher|exists:categories,id',
            'social_media.*.link'       => 'required_if:team,influencer',
            'image'                     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'city'                      => 'required_if:team,influencer|max:255',
            'influencer_type'           => 'required_if:team,influencer|in:performance,prepaid,express',
            'influencer_rating'         => 'required_if:team,influencer|in:nano,micro,macro,mega,celebrity',
            'currency'                  => 'required|max:3',
        ]);
        if ($request->traffic_sources) {
            $data['traffic_sources'] = implode(",", $request->traffic_sources);
        }
        unset($data['password']);
        unset($data['social_media']);
        unset($data['categories']);
        unset($data['roles']);

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        // dd($data);
        $publisher = User::findOrFail($id);

        // Update Image
        $data['image'] = $publisher->image;
        if ($request->has("image")) {
            Storage::disk('public')->delete('Images/Users/' . $publisher->image);
            $image = time() . rand(11111, 99999) . '.' . $request->image->extension();
            $request->image->storeAs('Images/Users/', $image, 'public');
            $data['image'] = $image;
        }

        if ($publisher->socialMediaLinks) {
            $publisher->socialMediaLinks()->delete();
        }

        if ($publisher->digitalAssets) {
            $publisher->digitalAssets()->delete();
        }

        if (auth()->user()->position == 'account_manager' || auth()->user()->position == 'publisher') {
            userActivity('User', $publisher->id, 'update', $data, $publisher, null, false);
            $message = 'A request to update the data has been sent to your direct head';
            // Check if publisher have AM
            if ($publisher->parent_id != null) {
                // Get AM
                $accountManager = User::where('id', $publisher->parent_id)->first();
                // Check if AM exists
                if ($accountManager) {
                    // Send notification to AM
                    Notification::send($accountManager, new PublisherNeedToUpdateHisInfo($publisher));
                    // Check if AM has head
                    if ($accountManager->parent_id != null) {
                        // Get Head Info
                        $head = User::where('id', $accountManager->parent_id)->first();
                        // Check if head exists
                        if ($head) {
                            // Send notification to head
                            Notification::send($head, new PublisherNeedToUpdateHisInfo($publisher));
                        }
                    }
                }
            }
        } else {
            $message = __('Data updated successfully');
            userActivity('User', $publisher->id, 'update', $data, $publisher);
            $publisher->update($data);
        }

        if ($request->categories) {
            // detach categories
            $publisher->categories()->detach();
            // Assign Categories
            foreach ($request->categories as $categoryId) {
                $category = Category::findOrFail($categoryId);
                $publisher->assignCategory($category);
            }
        }

        // Asign Role
        if ($request['roles']) {
            $publisher->roles()->detach();
            foreach ($request['roles'] as $role_id) {
                $role = Role::findOrFail($role_id);
                $publisher->assignRole($role);
            }
        }

        if ($request->team == 'influencer' || $request->team == 'prepaid') {
            if ($request->social_media && count($request->social_media) > 0) {
                foreach ($request->social_media as $link) {
                    if ($link['link']) {
                        SocialMediaLink::create([
                            'link' => $link['link'],
                            'platform' => $link['platform'],
                            'followers' => $link['followers'],
                            'user_id' => $publisher->id,
                        ]);
                    }
                }
            }
        }

        if ($request->team == 'affiliate') {
            if ($request->digital_asset && count($request->digital_asset) > 0) {
                foreach ($request->digital_asset as $link) {
                    if ($link['link']) {
                        DigitalAsset::create([
                            'link' => $link['link'],
                            'platform' => $link['platform'],
                            // 'other_platform_name' => $link['other_platform_name'],
                            'user_id' => $publisher->id,
                        ]);
                    }
                }
            }
        }


        $notification = [
            'message' => $message,
            'alert-type' => 'success'
        ];
        if (auth()->user()->id == $id) {
            return redirect()->route('admin.publisher.profile')->with($notification);
        }
        return redirect()->route('admin.publishers.index')->with($notification);
    }
}
