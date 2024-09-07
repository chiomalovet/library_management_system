<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Resources\AuthorResource;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    public function index(){
        $authors = Author::get(); 
        if($authors->count() > 0)
        {
           return AuthorResource::collection($authors);
        }else
        {
            return response()->json(['message' => 'No Record Found'], 200);
        }
    }

    public function show(Author $id){
        
        if(!$id){
            return response()->json(['message' => 'Book Not Found'], 404);
        }else
        {
            return response()->json($id, 200);
        }
        
    }

    public function store(Request $request){
        
        $validator = Validator::make($request->all(),[
           'name' => 'required',
            'bio' => 'required',
            'birthdate' => 'required',
              
        ]);

         if($validator->fails()){
          return response()->json([
            "messages" => "All Fields are mandatory",
            "error" => $validator->messages()
          ], 422);
         }

         $authors= Author::create($validator);
         return response()->json([
            'message'=> 'Author created successfully',
            'data' => new AuthorResource($authors)
         ], 201);
    }
}
