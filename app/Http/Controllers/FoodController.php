<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;

class FoodController extends Controller
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
    public function createFood(Request $request)
    {
        $response = "";

        $data = $request->getContent();

        $data = json_decode($data);

        if($data){

            $food = new Food();

            $food->name = $data->name;
            $encoded_nutritional_values = json_encode($data->nutritional_values);
            $food->nutritional_values = $encoded_nutritional_values;

            try{

                $food->save();

                $response = "New Food: ".$food->name." saved succesfully";

            }catch(\Exception $e){
                $response = $e->getMessage();
            }
            
        }else{
            $response = "Incorrect Data";
        }

        return response($response);
    }

    public function searchFood(Request $request)
    {

        $searchController = new SearchController;

        $response = "";

        $data = $request->getContent();

        $data = json_decode($data);

        if($data){

            $foods = Food::where('name','like','%'.$data->search.'%')->get()->toArray();
            $user = User::where('api_token', $data->api_key)->first();

            /*foreach ($foods as $food) {
                $food->nutritional_values = json_decode($food->nutritional_values);
            }*/

            $encodedFoods = json_encode($foods);
            $response = $foods;

            $searchController->createSearch($user->id, $data->search);
        }else{
            $response = "Incorrect Data";
        }

        //print($response);
        return response($response);
    }


    public function fetchFood()
    {

        $response = "";

        $foods = Food::all()->toArray();
        $encodedFoods = json_encode($foods);
        $response = $encodedFoods;

        //print($response);
        return response($foods);
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
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function show(Food $food)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function edit(Food $food)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function updateFood(Request $request, $id)
    {
        $response = "";

		$food = Food::find($id);

		if($food){

			$data = $request->getContent();

			$data = json_decode($data);

			if($data){

				if(isset($data->name))
					$food->name = $data->name;
                if(isset($data->password))
                    $food->nutritional_values = $data->nutritional_values;
                    
				try{

					$food->save();

					$response = "Food with name:".$food->name." updated successfully";
				}catch(\Exception $e){
					$response = $e->getMessage();
				}
			}else{
				$response = "Incorrect Data";
			}
		}else{
			$response = "Food Not Found";
		}

		return response($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function destroy(Food $food)
    {
        //
    }


    //TEST PARA EL TOKEN
    public function testToken(Request $request){

        $response = "Ok";

        return response($response);

    }
}
