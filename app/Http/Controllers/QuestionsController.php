<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Subject;
use App\Models\Question;
use App\Models\StudyObject;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function search ()
    {
        $questions = Question::all();
        $questionsArray = [];

        foreach($questions as $q) {
            array_push($questionsArray, [
                'id' => $q->id,
                'description' => $q->description,
                'subject_id' => $q->subject_id,
                'study_object_id' => $q->study_object_id,
                'subject' => self::getSubjectNameById($q->subject_id),
                'study_object' => self::getStudyObjectNameById($q->study_object_id),
                'options' => self::getCountOptions($q->id)
            ]);
        }

        return response()->json([
            'success' => true,
            'status' => 'success',
            'data' => $questionsArray,
        ]);

    }

    private static function getSubjectNameById ($id) {
        $subject = Subject::find($id);
        return $subject->title;
    }

    private static function getStudyObjectNameById ($id) {
        $studyObject = StudyObject::find($id);
        return $studyObject->title;
    }

    private static function getCountOptions ($id) {
        $options = Option::where('question_id', $id)->get();
        return count($options);
    }

    public function store (Request $request)
    {
        $question = new Question();
        $question->description = $request->input('description');
        $question->subject_id = $request->input('subject_id');
        $question->study_object_id = $request->input('study_object_id');
        $question->save();

        return response()->json([
            'success' => true,
            'status' => 'success',
            'data' => $question,
        ]);
    }

    public function destroy ($id)
    {
        $question = Question::find($id);
        $question->delete();

        return response()->json([
            'success' => true,
            'status' => 'success',
            'data' => [],
        ]);
    }

    public function edit ($id, Request $request)
    {
        $question = Question::find($id);
        $question->description = $request->input('description');
        $question->subject_id = $request->input('subject_id');
        $question->study_object_id = $request->input('study_object_id');
        $question->save();

        return response()->json([
            'success' => true,
            'status' => 'success',
            'data' => $question,
        ]);
    }
}
