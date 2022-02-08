<?php 

namespace App\Facades;

use App\Models\Offer;
use Illuminate\Support\Facades\Facade;
use App\Models\SallaInfo;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class SallaFacade extends Facade{

    // Get Registerd name of the component

    protected static function getFacadeAccessor()
    {
        return 'salla-class';
    }

    

    /**
     * Store salla auth data
    */

    static function storeAuthData($code){  
      
        try {
            $response = Http::asForm()->post('https://accounts.salla.sa/oauth2/token', [
                'client_id' => env('SALLA_CLIENT_ID'),
                'client_secret' => env('SALLA_CLIENT_SECRET'),
                'grant_type' => env('SALLA_GRANT_TYPE'),
                'redirect_uri' => env('SALLA_REDIRECT_URI'),
                'scope' => env('SALLA_SCOPE'),
                'code' => $code,
            ]);
            
            $data = $response->json();
            if(array_key_exists('access_token', $data)){
                $salla = SallaInfo::create([
                    'access_token' => $data['access_token'],
                    'expires_in' => $data['expires_in'],
                    'refresh_token' => $data['refresh_token'],
                    'scope' => $data['scope'],
                    'token_type' => $data['token_type'],
                ]);
                return $salla; 
            }
            Log::error($data);

           
        } catch (\Throwable $th) {
            Log::error($th);
        }
          
    }
    

    static function storeUserInfo(int $id){
        try {

            $salla = SallaInfo::findOrFail($id);
            // Get Store info
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $salla->access_token,
                'Content-Type' => 'application/json',
                'CF-Access-Client-Id' => env('SALLA_CLIENT_ID'),
                'CF-Access-Client-Secret' => env('SALLA_CLIENT_SECRET'),
            ])->get('https://accounts.salla.sa/oauth2/user/info');

            // Complete Salla info 
            $data = $response->json()['data'];

            $salla->update([
                // User Data
                'user_id' => $data['id'] ?? null,
                'user_name' => $data['name'] ?? null,
                'email' => $data['email'] ?? null,
                'mobile' => $data['mobile'] ?? null,
                'role' => $data['role'] ?? null,
                // Store Data 
                'store_id' => $data['store']['id'] ?? null,
                'owner_id' => $data['store']['owner_id'] ?? null,
                'username' => $data['store']['username'] ?? null,
                'store_name' => $data['store']['name'] ?? null,
                'avatar' => $data['store']['avatar'] ?? null,
                'plan' => $data['store']['plan'] ?? null,
                'status' => $data['store']['status'] ?? null,
                'domain' => $data['store']['domain'] ?? null,
                'subscribed_at' => $data['store']['created_at'] ?? null,
            ]);

            return $salla;
        } catch (\Throwable $th) {
            Log::error($th);
        }
        
    }

    static function assignSalaInfoToOffer(string $email, int $offerId){
        $salla = SallaInfo::whereEmail($email)->first();

        if($salla){
            $salla->offer_id = $offerId;
            $salla->save();
            return true;
        }

        Log::error([
            'Case' => 'Update offer id', 
            'salla' => 'Info not exists'
        ]);
        return false;
    }

}