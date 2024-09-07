<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index(){
        $books = Book::get(); 
        if($books->count() > 0)
        {
        //    return BookResource::collection($books);
           $books = Book::paginate(10);
           return BookResource::collection($books);
        }else
        {
            return response()->json(['message' => 'No Record Found'], 200);
        }
    }

    public function store(Request $request){
        
        $validator = Validator::make($request->all(),[
           'title' => 'required',
            'isbn' => 'required',
            'published_date' => 'required',
            'author_id' => 'required|exists:authors,id',
            'status' => 'required|in:Available,Borrowed',  
        ]);

         if($validator->fails()){
          return response()->json([
            "messages" => "All Fields are mandatory",
            "error" => $validator->messages()
          ], 422);
         }

         $books= Book::create($validator);
         return response()->json([
            'message'=> 'Book created successfully',
            'data' => new BookResource($books)
         ], 201);
    }

    public function show($id){
        $books = Book::find($id);
        
        if(!$books){
            return response()->json(['message' => 'Book Not Found'], 404);
        }else
        {
            return response()->json($books, 200);
        }
        
    }

    public function update(Request $request, Book $id){
      
        $validator = Validator::make($request->all(),[
            'title' => 'required',
             'isbn' => 'required',
             'published_date' => 'required',
             'author_id' => 'required|exists:authors,id',
             'status' => 'required|in:Available,Borrowed',  
         ]);
 
          if($validator->fails()){
           return response()->json([
             "messages" => "All Fields are mandatory",
             "error" => $validator->messages()
           ], 422);
          }
 
          $id->update([$validator]);

          return response()->json([
             'message'=> 'Book Updated successfully',
             'data' =>new BookResource($id)
          ], 201);
      
    }

    public function destory(Book $id){
        $id->delete();

        return response()->json([
            'message'=> 'Book Deleted successfully',
            'data' =>new BookResource($id)
         ], 200);
    }

    // Search books by title, author, or ISBN
    public function search(Request $request)
    {
        $query = $request->input('query');  // Get the search query from the request

        // Query the books table, search by title, author, or ISBN
        $books = Book::where('title', 'LIKE', "%{$query}%")
                    ->orWhere('author', 'LIKE', "%{$query}%")
                    ->orWhere('isbn', 'LIKE', "%{$query}%")
                    ->get();

        return response()->json($books);
    }

}
