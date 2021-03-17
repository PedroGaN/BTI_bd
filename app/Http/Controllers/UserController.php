<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createUser(Request $request)
    {
        $response = [];

        $data = $request->getContent();

        $data = json_decode($data);

        if($data){

            $checkUser = User::where('email',$data->email)->first();

            if($checkUser){
                $response[] = [
                    "api_key" => "",
                    "status" => "email"
                ];

                return response($response);
            }

            $user = new User();

            $users = User::all()->toArray();

            $token = $user->createToken('btiLogged')->accessToken;
            $user->api_token = $token;

            $user->name = "User".count($users).random_int(100, 999);
            $user->email = $data->email;
            $user->password = Hash::make($data->password);

            try{

                $user->save();

                $response[] = [
                    "api_key" => $user->api_token,
                    "status" => "OK"
                ];

            }catch(\Exception $e){
                $response = $e->getMessage();
            }
            
        }else{
            $response[] = [
                "api_key" => "",
                "status" => "data"
            ];
        }

        return response($response);
    }

    public function loginUser(Request $request) {

        $response = [];

        $data = $request->getContent();

        $data = json_decode($data);

        if($data){

            $user = User::where('email', $data->email)->first();
            if($user){

                if(Hash::check($data->password,$user->password)){
                    
                    $token = $user->createToken('btiLogged')->accessToken;
                    $user->api_token = $token;
                    
                    try{
                        $user->save();

                        $response[] = [
                            "api_key" => $user->api_token,
                            "status" => "OK"
                        ];

                    }catch(\Exception $e){
                        $response = $e->getMessage();
                    }

                }else{
                    $response[] = [
                        "api_key" => "",
                        "status" => "password"
                    ];
                }
            }else{
                $response[] = [
                    "api_key" => "",
                    "status" => "user"
                ];
            }

        }else{
            $response[] = [
                "api_key" => "",
                "status" => "data"
            ];
        }

        return response($response);

    }

    public function confirmUserEmail(Request $request) {

        $response = "";

        $data = $request->getContent();

        $data = json_decode($data);

        if($data){

            $user = User::where('email', $data->email)->first();

            if($data->email_verified_at){

                $user->email_verified_at = $data->email_verified_at;

                try{

                    $user->save();

                    $response = "Email: ".$user->email." Verified Successfully.";
                }catch(\Exception $e){
                    $response = $e->getMessage();
                }
            }
        }

        return response($response);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Search  $search
     * @return \Illuminate\Http\Response
     */
    public function show(Search $search)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Search  $search
     * @return \Illuminate\Http\Response
     */
    public function updateUser(Request $request)
    {
        $response = "";

        $data = $request->getContent();

        $data = json_decode($data);

        if($data){

            $user = User::where('api_token', $data->api_key)->first();
            if(!Hash::check($data->password,$user->password)){
                $response = "WrongPassword";
                return response($response);
            }else{
                if($data->new_username != "" && $data->new_username != $user->name){
                    $user->name = $data->new_username;
                    $response .= "Username";
                }
                if($data->new_email != "" && $data->new_email != $user->email){
                    $user->email = $data->email;
                    $response .= "Email";
                }
                if($data->new_password != ""){
                    $user->password = Hash::make($data->new_password);
                    $response .= "Password";
                }
                
                try{

                    $user->save();
                    if($response == ""){
                        $response = "Missing Parameters";
                    }

                }catch(\Exception $e){
                    $response = "EmailOnUse";
                }
            }



        }else{
            $response = "Incorrect Data";
        }
		

		return response($response);
    }

    public function getUsername(Request $request){

        $response = "";

        $data = $request->getContent();

        $data = json_decode($data);

        if($data){

            $user = User::where('api_token', $data->api_key)->first();
            if($user){
                $response = $user->name;
            }



        }else{
            $response = "Incorrect Data";
        }

        return response($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Search  $search
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Search $search)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Search  $search
     * @return \Illuminate\Http\Response
     */
    public function destroy(Search $search)
    {
        //
    }


    //---------
    //TOKENS
    //---------
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

}
