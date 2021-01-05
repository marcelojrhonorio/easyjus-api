<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\StudyObject;
use Illuminate\Http\Request;

class StudyObjectsController extends Controller
{
    public function search()
    {
        $studyObjects = StudyObject::all();
        $studyObjectsArray = [];

        foreach($studyObjects as $so) {
            array_push($studyObjectsArray, [
                'id' => $so->id,
                'subject_id' => $so->subject_id,
                'ordering' => $so->ordering,
                'title' => $so->title,
                'description' => $so->description,
                'subject' => self::getSubjectTitle($so->subject_id),
            ]);
        }

        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'data' => $studyObjectsArray,
        ]); 
    }

    private static function getSubjectTitle ($subjectId) {
        $subject = Subject::find($subjectId);
        return $subject->title;
    }

    public function store (Request $request)
    {
        $studyObject = new StudyObject();
        $studyObject->subject_id = $request->input('subject');
        $studyObject->ordering = $request->input('ordering');
        $studyObject->title = $request->input('title');
        $studyObject->description = $request->input('description');
        $studyObject->save();

        return response()->json([
            'success' => true,
            'status' => 'success',
            'data' => $studyObject,
        ]);
    }

    public function edit ($id, Request $request)
    {
        $studyObject = StudyObject::find($id);
        $studyObject->subject_id = $request->input('subject');
        $studyObject->ordering = $request->input('ordering');
        $studyObject->title = $request->input('title');
        $studyObject->description = $request->input('description');
        $studyObject->save();

        return response()->json([
            'success' => true,
            'status' => 'success',
            'data' => $studyObject,
        ]);        
    }

    public function destroy ($id)
    {
        $studyObject = StudyObject::find($id);
        $studyObject->delete();

        return response()->json([
            'success' => true,
            'status' => 'success',
            'data' => []
        ]);
    }

    public function getFromSubjectId ($subjectId)
    {
        $studyObjects = StudyObject::where('subject_id', $subjectId)->get();

        return response()->json([
            'success' => true,
            'status' => 'success',
            'data' => $studyObjects
        ]);
    }
}
