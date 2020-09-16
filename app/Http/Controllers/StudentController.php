<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Models\Student;
use App\Models\Teacher;
use App\Traits\ResponderTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class StudentController extends Controller
{
    use ResponderTrait;

    public function list()
    {
        if (Gate::allows('superadmin')) {
            return $this->successResponse(Student::all());
        }

        return $this->successResponse(Student::where(['user_id'=>Auth()->user()->id])->get());

    }

    public function readById($id)
    {
        if (Gate::allows('superadmin')) {
            return $this->successResponse(Student::findOrFail($id));
        }
        return $this->successResponse(Student::where(['id'=>$id,'user_id'=>Auth()->user()->id]));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'family' => 'required|min:3',
            'teacher_id' => 'required|exists:teachers,id'
        ]);

        $student = Student::create([
            'name' => $request->name,
            'family' => $request->family,
            'teacher_id' => $request->teacher_id,
            'user_id' => Auth()->user()->id
        ]);
        return $this->successResponse($student, Response::HTTP_CREATED);

    }

    public function update($id, Request $request)
    {

        $request->validate([
            'name' => 'required|min:3',
            'family' => 'required|min:3',
            'teacher_id' => 'required|exists:teachers,id'
        ]);

        $student=Student::where('id', $id);
        if (Gate::denies('superadmin')) {
            $student->where(['user_id'=>Auth()->user()->id]);
        }
        $student->update(['name' => $request->name, 'family' => $request->family, 'teacher_id' => $request->teacher_id]);

        return $this->successResponse(Student::find($id));
    }

    public function delete($id)
    {
        $student = Student::where(['id'=>$id]);

        if (Gate::denies('superadmin')) {
            $student->where(['user_id'=>Auth()->user()->id]);
        }

        $student->delete();

        return $this->successResponse($student);

    }

    public function assignLesson(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'lesson_id' => 'required|exists:lessons,id',
        ]);

        $student = $assign = Student::find($request->student_id);
        $assign = $student->lessons()->syncWithoutDetaching($request->lesson_id);
        return $this->successResponse($student->lessons);
    }

    public function detachLesson(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'lesson_id' => 'required|exists:lessons,id',
        ]);

        $student = Student::find($request->student_id);
        $detach = $student->lessons()->detach($request->lesson_id);
        return $this->successResponse($student->lessons);
    }
}
