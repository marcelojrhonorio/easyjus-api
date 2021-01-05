<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\StudyObject;
use Illuminate\Http\Request;

class SubjectsController extends Controller
{
    public function search ()
    {
        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'data' => Subject::all(),
        ]);        
    }

    public function searchWithStudyObject ()
    {
        $subjects = Subject::all();
        $subjectsArray = [];

        foreach ($subjects as $subject) {
            $studyObjects = StudyObject::where('subject_id', $subject->id)->get();
            
            if (count($studyObjects) > 0) {
                array_push($subjectsArray, [
                    'id' => $subject->id,
                    'title' => $subject->title
                ]);
            }
        }

        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'data' => $subjectsArray,
        ]);        
    }    

    public function store (Request $request)
    {
        $subject = new Subject();
        $subject->title = $request->input('title');
        $subject->save();

        return response()->json([
            'success' => true,
            'status' => 'success',
            'data' => $subject
        ]);
    }

    public function destroy ($id) 
    {
        $subject = Subject::find($id);
        $subject->delete();

        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'data' => [],
        ]);
    }

    public function edit ($id, Request $request)
    {
        $subject = Subject::find($id);
        $subject->title = $request->input('title');
        $subject->save();

        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'data' => [],
        ]);
    }
}
