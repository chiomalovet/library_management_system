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
            $borrowRecords = BorrowRecord::paginate(10);
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

    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date',
            'return_date' => 'nullable|date|after:borrow_date'
        ]);

        // Create borrow record
        $borrowRecord = BorrowRecord::create($validated);

        return response()->json(['message' => 'Borrow record created successfully', 'record' => $borrowRecord], 201);
    }

    public function update(Request $request, $id)
    {
        // Validate input
        $validated = $request->validate([
            'book_id' => 'sometimes|exists:books,id',
            'user_id' => 'sometimes|exists:users,id',
            'borrow_date' => 'sometimes|date',
            'due_date' => 'required|date',
            'return_date' => 'nullable|date|after:borrow_date'
        ]);

        // Find borrow record and update
        $borrowRecord = BorrowRecord::findOrFail($id);
        $borrowRecord->update($validated);

        return response()->json(['message' => 'Borrow record updated successfully', 'record' => $borrowRecord]);
    }
}
