<?php

namespace App\Http\Controllers;

use App\Http\Resources\BorrowRecordResource;
use App\Models\BorrowRecord;
use Illuminate\Http\Request;

class BorrowRecordController extends Controller
{
    public function index(){
        $borrowrecords = BorrowRecord::get(); 
        if($borrowrecords->count() > 0)
        {
           return BorrowRecordResource::collection($borrowrecords);
        }else
        {
            return response()->json(['message' => 'No Record Found'], 200);
        }
    }

    public function show(BorrowRecord $id){
        
        if(!$id){
            return response()->json(['message' => 'Record Not Found'], 404);
        }else
        {
            return response()->json($id, 200);
        }
        
    }
}
