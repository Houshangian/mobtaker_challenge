<?php

use App\Models\Lesson;
use App\Models\Manager;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

        $user=new \App\Models\User();
        $user->name="yasha";
        $user->email="yasha@gmail.com";
        $user->password=bcrypt('123');
        $user->role='superadmin';
        $user->save();
        exit;
   /* $user = App\Models\User::find(1);

    $user->roles()->attach($roleId);*/




    //->whereIn('id', [1, 2, 3])
//    $lesson = Lesson::where(['id'=>4])->get();
//    dd($lesson);
//    $user->roles()->attach($roleId);



    $student=Student::find(3);
    $res=$student->lessons()->sync(4);
  dd($res);
});
