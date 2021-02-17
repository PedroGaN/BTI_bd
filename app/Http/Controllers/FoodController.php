<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use App\Http\Controllers\SearchController;

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
            $food->nutritional_values = $data->nutritional_values;

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
            $encodedFoods = json_encode($foods);
            $response = $encodedFoods;

            $searchController->createSearch();
        }else{
            $response = "Incorrect Data";
        }

        print($response);
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
