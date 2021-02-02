<?php

namespace App\Http\Controllers;

use App\Models\Library;
use Illuminate\Http\Request;

class LibraryController extends Controller
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
    public function createLibrary(Request $request)
    {
        $response = "";

        $data = $request->getContent();

        $data = json_decode($data);

        if($data){

            $library = new Library();

            $library->name = $data->name;
            $library->region = $data->region;

            try{

                $user->save();

                $response = "New Library: ".$library->name." created succesfully";

            }catch(\Exception $e){
                $response = $e->getMessage();
            }
            
        }else{
            $response = "Incorrect Data";
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
     * @param  \App\Models\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function show(Library $library)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function updateLibrary(Request $request, $id)
    {
        $response = "";

		$library = Library::find($id);

		if($library){

			$data = $request->getContent();

			$data = json_decode($data);

			if($data){

				if(isset($data->name))
					$library->name = $data->name;
				if(isset($data->region))
                    $library->region = $data->region;
                    
				try{

					$library->save();

					$response = "Library with name:".$library->name." updated successfully";
				}catch(\Exception $e){
					$response = $e->getMessage();
				}
			}else{
				$response = "Incorrect Data";
			}
		}else{
			$response = "Library Not Found";
		}

		return response($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Library $library)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function destroy(Library $library)
    {
        //
    }
}
