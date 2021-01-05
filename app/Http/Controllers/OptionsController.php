<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Illuminate\Http\Request;

class OptionsController extends Controller
{
    public function getFromQuestionId ($questionId)
    {
        return response()->json([
            'success' => true,
            'status' => 'success',
            'data' => Option::where('question_id', $questionId)->get()
        ]);
    }

    public function store (Request $request)
    {
        $option = new Option();
        $option->description = $request->input('description');
        $option->question_id = $request->input('question_id');
        $option->is_correct = $request->input('is_correct');
        $option->save();

        return response()->json([
            'success' => true,
            'status' => 'success',
            'data' => $option
        ]);
    }

    public function destroy ($id)
    {
        $option = Option::find($id);
        $questionId = $option->question_id;
        $option->delete();

        return response()->json([
            'success' => true,
            'status' => 'success',
            'data' => Option::where('question_id', $questionId)->get()
        ]);
    }

    public function edit ($id, Request $request)
    {
        $option = Option::find($id);
        $option->description = $request->input('description');
        $option->question_id = $request->input('question_id');
        $option->is_correct = $request->input('is_correct');
        $option->save();

        return response()->json([
            'success' => true,
            'status' => 'success',
            'data' => $option
        ]);        
    }
}
