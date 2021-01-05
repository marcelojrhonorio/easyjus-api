<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentsController extends Controller
{
    public function search()
    {
        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'data' => Student::all(),
        ]);
    }

    public function store (Request $request)
    {
        $student = new Student();
        $student->fullname = $request->input('fullname');
        $student->email = $request->input('email');
        $student->phone = $request->input('phone');
        $student->birthdate = $request->input('birthdate');
        $student->password = Hash::make($request->input('password'));
        $student->save();

        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'data' => $student,
        ]);        
    }

    public function destroy ($id)
    {
        $student = Student::find($id);
        $student->delete();

        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'data' => [],
        ]);   
    }

    public function edit (Request $request, $id)
    {
        $student = Student::find($id);
        $student->fullname = $request->input('fullname');
        $student->email = $request->input('email');
        $student->phone = $request->input('phone');
        $student->birthdate = $request->input('birthdate');

        if ((null != $request->input('password') && null != $request->input('password_repeat')) && ($request->input('password') === $request->input('password_repeat'))) {
            $student->password = Hash::make($request->input('password'));
        }

        $student->save();

        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'data' => $student,
        ]);  
    }

    public function getRecoveryPasswordToken (Request $request)
    {
        $email = $request->input('email');

        $student = Student::where('email', $email)->first();
        $student->token = md5(uniqid(rand(), true));
        $student->save();

        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'data' => $student,
        ]);
    }

    public function blockStudent ($id)
    {
        $student = Student::find($id);
        $student->enabled = false;
        $student->save();

        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'data' => [],
        ]);
    }

}
