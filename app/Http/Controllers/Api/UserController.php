<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Advertiser;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Role;
use App\Models\SocialMediaLink;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function registerAdvertiser(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'full_name'             => 'required|string',
            'mobile'                => 'required',
            'email'                 => 'required|email|unique:advertisers,email',
            'country'               => 'required|string',
            'city'                  => 'required|string',
            'company'               => 'required|string',
            'website'               => 'required|url',
            'account_manager'       => 'required|string',
            'orders_avg_monthly'    => 'required|string',
            'orders_avg_size'       => 'required|string',
            'business_full_name'    => 'required|string',
            'business_mobile'       => 'required|string',
            'business_industry'     => 'required|string',
        ]);

        $response = [];

        if ($validator->fails()) {

            $response['errors'] = $validator->messages();
            $response['success']  = false;
            return response()->json($response, 422);
        }

        $data = [
            'name'                  => $request->full_name,
            'phone'                 => $request->mobile,
            'email'                 => $request->email,
            'company_name_ar'       => $request->company,
            'company_name_en'       => $request->company,
            'website'               => $request->website,
            'city_id'               => getCityId($request->city)??null,
            'country_id'            => getCountryId($request->country)??null,
            'account_manager'       => $request->account_manager,
            'orders_avg_monthly'    => $request->orders_avg_monthly,
            'orders_avg_size'       => $request->orders_avg_size,
            'business_full_name'    => $request->business_full_name,
            'business_mobile'       => $request->business_mobile,
            'business_industry'     => $request->business_industry
        ];
        // return $data;
        $advertiser = Advertiser::create($data);
        if(getCategoryId($request->business_industry)){
            $advertiser->categories()->attach(getCategoryId($request->business_industry));
        }
        $response['success']  = true;
        return response()->json($response);

    }

    public function registerAffiliate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name'             => 'required|string',
            'mobile'                => 'required|string',
            'email'                 => 'required|email|unique:users,email',
            'gender'                => 'required|string',
            'country'               => 'required|string',
            'city'                  => 'required|string',
            'nationality'           => 'required|string',
            'account_manager'       => 'required|string',
            'experience'            => 'required|integer',
            'previous_network'      => 'required|string',
            'affiliate_networks'    => 'required|string',
            'digital_assets'        => 'required|string',
            'bank_country'          => 'required|string',
            'bank_address'          => 'required|string',
            'bank_account_title'    => 'required|string',
            'bank_swift'            => 'required|string',
            'currency'              => 'required|string',
            'iban'                  => 'required|string',
        ]);

 


        $response = [];

        if ($validator->fails()) {

            $response['errors'] = $validator->messages();
            $response['success']  = false;
            return response()->json($response, 422);
        }

        $data = [
            'name'                      => $request->full_name,
            'email'                     => $request->email,
            'phone'                     => $request->mobile,
            'country_id'                => getCountryId($request->country) ,
            'city_id'                   => getCityId($request->city),
            'gender'                    => $request->gender ? $request->gender : 'male',
            'years_of_experience'       => $request->experience,
            'referral_account_manager'  => $request->account_manager,
            'traffic_sources'           => $request->previous_network,
            'affiliate_networks'        => $request->affiliate_networks,
            'previous_network'          => $request->affiliate_networks,
            'owened_digital_assets'     => $request->digital_assets,
            'account_title'             => $request->bank_account_title,
            'bank_name'                 => $request->bank_name,
            'swift_code'                => $request->bank_swift,
            'iban'                      => $request->iban,
            'nationality'               => $request->nationality,
            'previous_network'          => $request->previous_network,
            'bank_country'              => $request->bank_country,
            'bank_address'              => $request->bank_address,
            'currency_id'               => getCurrency($request->currency),
            'team'                      => 'affiliate',
            'position'                  => 'publisher',
        ];

        $user = User::create($data);
        $user->roles()->attach(Role::findOrFail(4));

        if(getCategoryId($request->content_category)){
            $user->categories()->attach(getCategoryId($request->content_category));
        }

        $response['success']  = true;

        return response()->json($response);
    }

    public function registerInfluencer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name'             => 'required|string',
            'mobile'                => 'required|string',
            'email'                 => 'required|email|unique:users',
            'country'               => 'required|string',
            'city'                  => 'required|string',
            'nationality'           => 'required|string',
            'content_category'      => 'required|string',
            'account_manager'       => 'required|string',
            'bank_country'          => 'required|string',
            'bank_address'          => 'required|string',
            'bank_account_title'    => 'required|string',
            'bank_swift'            => 'required|string',
            'currency'              => 'required|string',
            'iban'                  => 'required|string',
        ]);
       

        $response = [];

        if ($validator->fails()) {
            $response['errors'] = $validator->messages();
            $response['success']  = false;
            return response()->json($response, 422);
        }

        $data = [
            'name'                      => $request->full_name,
            'email'                     => $request->email,
            'phone'                     => $request->mobile,
            'country_id'                => getCountryId($request->country) ,
            'city_id'                   => getCityId($request->city),
            'gender'                    => $request->gender ? $request->gender : 'male',
            'nationality'               => $request->nationality,
            'referral_account_manager'  => $request->account_manager,
            'owened_digital_assets'     => $request->digital_assets,
            'account_title'             => $request->bank_account_title,
            'bank_name'                 => $request->bank_name,
            'swift_code'                => $request->bank_swift,
            'iban'                      => $request->iban,
            'bank_country'              => $request->bank_country,
            'bank_address'              => $request->bank_address,
            'currency_id'               => getCurrency($request->currency),
            'team'                      => 'influencer',
            'position'                  => 'publisher',
        ];

        $user = User::create($data);

        $user->roles()->attach(Role::findOrFail(4));
        if(getCategoryId($request->content_category)){
            $user->categories()->attach(getCategoryId($request->content_category));
        }

        if($request->digital_platforms && count($request->digital_platforms) > 0){
            foreach($request->digital_platforms as $link){
                if(!is_null($link['link'])){
                    SocialMediaLink::create([
                        'link' => $link['link'],
                        'platform' => $link['platform'],
                        'followers' => $link['follower'],
                        'viewers' => $link['viewer'] ?? 0,
                        'user_id' => $user->id,
                    ]);
                }
                
            }

        }
        


        $response['success']  = true;

        return response()->json($response);
    }



}
