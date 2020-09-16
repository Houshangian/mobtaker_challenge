<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Manager;
use App\Models\Student;
use App\Models\Teacher;
use App\Traits\ResponderTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;


class LessonController extends Controller
{
    use ResponderTrait;
    public function list()
    {
        if (Gate::allows('superadmin')) {
            return $this->successResponse(Lesson::all());
        }
        return $this->successResponse(Lesson::where(['user_id'=>Auth()->user()->id])->get());

    }

    public function readById($id)
    {
        if (Gate::allows('superadmin')) {
            return $this->successResponse(Lesson::findOrFail($id));
        }
        return $this->successResponse(Lesson::where(['id'=>$id,'user_id'=>Auth()->user()->id]));

    }

    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required|min:3',
        ]);

        $lesson = Lesson::create([
            'title' => $request->title,
            'user_id' => Auth()->user()->id
        ]);
        return $this->successResponse($lesson,Response::HTTP_CREATED);

    }

    public function update($id,Request $request)
    {

        $request->validate([
            'title'=>'required|min:3'
        ]);
        $lesson=Lesson::where('id', $id);
        if (Gate::denies('superadmin')) {
            $lesson->where(['user_id'=>Auth()->user()->id]);
        }
        $lesson->update(['title' => $request->title]);

        return $this->successResponse(Lesson::find($id));
    }

    public function delete($id)
    {
        $lesson = Lesson::where(['id'=>$id])git;

        if (Gate::denies('superadmin')) {
            $lesson->where(['user_id'=>Auth()->user()->id]);
        }

        $lesson->delete();

        return $this->successResponse($lesson);

    }
}
