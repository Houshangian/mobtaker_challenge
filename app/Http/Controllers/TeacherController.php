<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Traits\ResponderTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class TeacherController extends Controller
{
    use ResponderTrait;
    public function list()
    {
        if (Gate::allows('superadmin')) {
            return $this->successResponse(Teacher::all());
        }
        return $this->successResponse(Teacher::where(['user_id'=>Auth()->user()->id])->get());
    }

    public function readById($id)
    {
        if (Gate::allows('superadmin')) {
            return $this->successResponse(Teacher::find($id));
        }
        return $this->successResponse(Teacher::where(['id'=>$id,'user_id'=>Auth()->user()->id]));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|min:3',
            'family'=>'required|min:3',
            'manager_id'=>'required|exists:managers,id'
        ]);

        $teacher=Teacher::create([
            'name' => $request->name,
            'family' => $request->family,
            'manager_id' => $request->manager_id,
            'user_id' => Auth()->user()->id
        ]);
        return $this->successResponse($teacher,Response::HTTP_CREATED);

    }

    public function update($id,Request $request)
    {
        $request->validate([
            'name'=>'required|min:3',
            'family'=>'required|min:3',
            'manager_id'=>'required|exists:managers,id'
        ]);

        $teacher=Teacher::where('id', $id);

        if (Gate::denies('superadmin')) {
            $teacher->where(['user_id'=>Auth()->user()->id]);
        }

        $teacher->update(['name' => $request->name,'family'=>$request->family,'manager_id'=>$request->manager_id]);

        return $this->successResponse(Teacher::findOrFail($id));
    }

    public function delete($id)
    {
        $teacher = Teacher::where(['id'=>$id]);
        if (Gate::denies('superadmin')) {
            $teacher->where(['user_id'=>Auth()->user()->id]);
        }
        $teacher->delete();

        return $this->successResponse($teacher);

    }

    public function assignLesson(Request $request)
    {
        $request->validate([
            'teacher_id'=>'required|exists:teachers,id',
            'lesson_id'=>'required|exists:lessons,id',
        ]);

        $teacher=Teacher::find($request->teacher_id);
        $assign=$teacher ->lessons()->syncWithoutDetaching($request->lesson_id);
        return $this->successResponse($teacher->lessons);
    }

    public function detachLesson(Request $request)
    {
        $request->validate([
            'teacher_id'=>'required|exists:teachers,id',
            'lesson_id'=>'required|exists:lessons,id',
        ]);

        $teacher=Teacher::find($request->teacher_id);
        $detach=$teacher->lessons()->detach($request->lesson_id);
        return $this->successResponse($teacher->lessons);
    }


}
