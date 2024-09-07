<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        $users = User::get(); 
        if($users->count() > 0)
        {
           return UserResource::collection($users);
        }else
        {
            return response()->json(['message' => 'No Record Found'], 200);
        }
    }
    

    public function show(User $id){
        
        if(!$id){
            return response()->json(['message' => 'User Not Found'], 404);
        }else
        {
            return response()->json($id, 200);
        }
        
    }

    public function store(Request $request){
        try{
        $validator = Validator::make($request->all(),[
           'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role' => 'required',
              
        ]);

         if($validator->fails()){
          return response()->json([
            "status" => false,
            "messages" => "All Fields are mandatory",
            "error" => $validator->messages()
          ], 422);
         }

         $users= User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role')
         ]);
         return response()->json([
            "status" => true,
            'message'=> 'User created successfully',
            // 'data' => new UserResource($users),
            "token" => $users->createToken("API TOKEN")->plainTextToken
         ], 201);

        }catch(\Throwable $th){
            return response()->json([
                "status" => false,
                "message" => $th->getmessage()
            ], 500);
        }
    }

    public function update(Request $request, User $id){
      
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role' => 'required', 
         ]);
 
          if($validator->fails()){
           return response()->json([
            "status" => false,
             "messages" => "All Fields are mandatory",
             "error" => $validator->messages()
           ], 422);
          }
 
          $id->update([$validator]);

          return response()->json([
            "status" => true,
             'message'=> 'User Updated successfully',
            //  'data' =>new UserResource($id),
             "token" => $id->createToken("API TOKEN")->plainTextToken
          ], 201);
      
    }

    public function destory(User $id){
        $id->delete();

        return response()->json([
            'message'=> 'User Deleted successfully',
            'data' =>new UserResource($id)
         ], 200);
    }

    public function loginUser(Request $request)
    {
        try{
      $validator =validator::make($request->all(),
      [
            'email' => 'required',
            'password' => 'required',
      ]);

      if($validator->fails())
      {
        return response()->json([
        'status' => false,
        'message' => 'validation error',
        'errors' => $validator->errors()
        ], 401);
      }

      if(!Auth::attempt($request->only(['email', 'password']))){
           return response()->json([
            'status' => false,
             'message' => 'Email and Password does not match with our record',
           ], 401);
      }

        $user = User::where('email', $request->email)->first();

        return response()->json([
         'status' => true,
         'message' => "User Login Successfully",
         'token' => $user->createToken("API TOKEN")->plainTextToken,
        ], 200);
    }catch(\Throwable $th){
        return response()->json([
            "status" => false,
            "message" => $th->getmessage()
        ], 500);
    }
    }
}
