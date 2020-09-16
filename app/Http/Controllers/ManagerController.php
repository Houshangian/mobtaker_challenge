<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Manager;
use App\Traits\ResponderTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class ManagerController extends Controller
{
    use ResponderTrait;

    public function __construct()
    {
        if (Gate::denies('superadmin')) {
            throw new AuthorizationException();
        }
    }

    public function list()
    {
        return $this->successResponse(Manager::all());
    }

    public function readById($id)
    {
        return $this->successResponse(Manager::findOrFail($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|min:3',
            'family'=>'required|min:3'
        ]);

        $manager = Manager::create([
            'name' => $request->name,
            'family' => $request->family,
            'user_id' => Auth()->user()->id
        ]);
        return $this->successResponse($manager,Response::HTTP_CREATED);

    }

    public function update($id,Request $request)
    {

        $request->validate([
            'name'=>'required|min:3',
            'family'=>'required|min:3'
        ]);

        Manager::where('id', $id)
            ->update(['name' => $request->name,'family'=>$request->family]);

        return $this->successResponse(Manager::find($id));
    }


    public function delete($id)
    {
        $manager = Manager::find($id);

        $manager->delete();

        return $this->successResponse($manager);
    }
}
