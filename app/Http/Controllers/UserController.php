<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            $response = "Incorrect Data";
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
                    
                    //$user->api_token = self::randomToken(8,"auth");

                    /*try{

                        $user->save();*/
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

 
                    /*}catch(\Exception $e){
                        $response = $e->getMessage();
                    }*/
                }else{
                    $response[] = [
                        "api_key" => $user->api_token,
                        "status" => "password"
                    ];
                }
            }else{
                $response[] = [
                    "api_key" => $user->api_token,
                    "status" => "user"
                ];
            }

        }else{
            $response = "Incorrect Data";
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
    public function updateUser(Request $request, $id)
    {
        $response = "";

		$user = User::find($id);

		if($user){

			$data = $request->getContent();

			$data = json_decode($data);

			if($data){

				if(isset($data->name))
					$user->name = $data->name;
				if(isset($data->email))
                    $user->email = $data->email;
                    $user->email_verified_at = NULL;
                if(isset($data->password))
                    $user->password = Hash::make($data->password);
                    
				try{

					$user->save();

					$response = "User with name:".$user->name." updated successfully";
				}catch(\Exception $e){
					$response = $e->getMessage();
				}
			}else{
				$response = "Incorrect Data";
			}
		}else{
			$response = "User Not Found";
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
