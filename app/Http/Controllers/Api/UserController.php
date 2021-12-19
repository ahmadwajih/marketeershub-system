<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Advertiser;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function registerAdvertiser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'mobile' => 'required|numeric',
            'email' => 'required|email|unique:advertisers,email',
            'country' => 'required|string',
            'city' => 'required|string',
            'company' => 'required|string',
            'website' => 'required|url',
        ], [
            'first_name.required' => __('First name is required'),
            'mobile.required' => __('Mobile number is required'),
            'email.required' => __('Email is required'),
            'country.required' => __('Country name is required'),
            'city.required' => __('City name is required'),
            'company.required' => __('Company name is required'),
            'website.required' => __('Website URL is required'),
        ]);

        $response = [];

        if ($validator->fails()) {

            $response['errors'] = $validator->messages();
            $response['success']  = false;
            return $response;
        } 

        $data = [
            'name' => $request->first_name . ' ' . $request->last_name,
            'phone' => $request->mobile,
            'email' => $request->email,
            'company_name_ar' => $request->company,
            'company_name_en' => $request->company,
            'website' => $request->website,
            'country_id' => getCountryId($request->country) ,
            'city_id' => getCityId($request->city),
        ];

        Advertiser::create($data);
        $response['success']  = true;
        return $response;

    }

    public function registerAffiliate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'mobile' => 'required|numeric',
            'email' => 'required|email|unique:users,email',
            'experience' => 'required|integer',
            'traffic_sources_used' => 'required|string',
            'affiliate_networks' => 'required|string',
            'digital_assets' => 'required|string',
            'skype' => 'nullable|string',
            'bank_account_title' => 'required|string',
            'bank_name' => 'required|string',
            'iban' => 'required|string',
            'currency' => 'required|string',
        ], [
            'first_name.required' => __('First name is required'),
            'mobile.required' => __('Mobile number is required'),
            'email.required' => __('Email is required'),
            'experience.required' => __('Enter the number of years. eg: 1,2 '),
        ]);

        $response = [];

        if ($validator->fails()) {

            $response['errors'] = $validator->messages();
            $response['success']  = false;
            return $response;
        }
        
        $data = [
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'phone' => $request->mobile,
            'country_id' => getCountryId($request->nationality) ,
            'city_id' => getCityId($request->city),
            'gender' => $request->gender ? $request->gender : 'male',
            'years_of_experience' => $request->experience,
            'traffic_sources' => $request->traffic_sources_used,
            'affiliate_networks' => $request->affiliate_networks,
            'owened_digital_assets' => $request->digital_assets,
            'account_title' => $request->account_title,
            'bank_name' => $request->bank_name,
            'iban' => $request->iban,
            'currency_id' => getCurrency($request->currency),
            'team' => 'affiliate',
            'position' => 'publisher',
        ];

        $user = User::create($data);
        $user->roles()->attach(Role::findOrFail(4));
        $response['success']  = true;

        return $response;
    }

    public function registerInfluencer(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'mobile' => 'required|numeric',
            'email' => 'required|email|unique:users',
            'experience' => 'required|integer',
            'traffic_sources_used' => 'required|string',
            'affiliate_networks' => 'required|string',
            'digital_assets' => 'required|string',
            'skype' => 'nullable|string',
            'bank_account_title' => 'required|string',
            'bank_name' => 'required|string',
            'iban' => 'required|string',
            'currency' => 'required|string',
        ], [
            'first_name.required' => __('First name is required'),
            'mobile.required' => __('Mobile number is required'),
            'email.required' => __('Email is required'),
            'experience.required' => __('Enter the number of years. eg: 1,2 '),
        ]);
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'mobile' => 'required|numeric',
            'email' => 'required|email|unique:users,email',
            'country' => 'required|string',
            'city' => 'required|string',
            'nationality' => 'required|string',
            'bank_account_title' => 'required|string',
            'bank_name' => 'required|string',
            'iban' => 'required|string',
            'promotion' => 'array',
            'promotion.*' => 'required'
        ], [
            'first_name.required' => __('First name is required'),
            'mobile.required' => __('Mobile number is required'),
            'email.required' => __('Email is required'),
            'country.required' => __('Country name is required'),
            'nationality.required' => __('Nationality required'),
        ]);

        $response = [];

        if ($validator->fails()) {
            $response['errors'] = $validator->messages();
            $response['success']  = false;
            return $response;
        }

        $data = [
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'phone' => $request->mobile,
            'country_id' => getCountryId($request->nationality) ,
            'city_id' => getCityId($request->city),
            'gender' => $request->gender ? $request->gender : 'male',
            'years_of_experience' => $request->experience,
            'traffic_sources' => $request->traffic_sources_used,
            'affiliate_networks' => $request->affiliate_networks,
            'owened_digital_assets' => $request->digital_assets,
            'account_title' => $request->account_title,
            'bank_name' => $request->bank_name,
            'iban' => $request->iban,
            'currency_id' => getCurrency($request->currency),
            'team' => 'influencer',
            'position' => 'publisher',
        ];

        $user = User::create($data);
        $user->roles()->attach(Role::findOrFail(4));
        $response['success']  = true;

        return $response;
    }



}
