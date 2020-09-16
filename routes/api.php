<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['middleware' => 'auth:api'], function ($router) {

    Route::get('managers',[ManagerController::class,'list']);
    Route::get('manager/{id}',[ManagerController::class,'readById']);
    Route::post('manager',[ManagerController::class,'store']);
    Route::post('manager/{id}',[ManagerController::class,'update']);
    Route::delete('manager/{id}',[ManagerController::class,'delete']);

    Route::get('teachers',[TeacherController::class,'list']);
    Route::get('teacher/{id}',[TeacherController::class,'readById']);
    Route::post('teacher',[TeacherController::class,'store']);
    Route::post('teacher/{id}',[TeacherController::class,'update']);
    Route::delete('teacher/{id}',[TeacherController::class,'delete']);

    Route::get('students',[StudentController::class,'list']);
    Route::get('student/{id}',[StudentController::class,'readById']);
    Route::post('student',[StudentController::class,'store']);
    Route::post('student/{id}',[StudentController::class,'update']);
    Route::delete('student/{id}',[StudentController::class,'delete']);


    Route::get('lessons',[LessonController::class,'list']);
    Route::get('lesson/{id}',[LessonController::class,'readById']);
    Route::post('lesson',[LessonController::class,'store']);
    Route::post('lesson/{id}',[LessonController::class,'update']);
    Route::delete('lesson/{id}',[LessonController::class,'delete']);


    Route::post('assign/teacher/lesson',[TeacherController::class,'assignLesson']);
    Route::post('assign/student/lesson',[StudentController::class,'assignLesson']);


    Route::post('detach/teacher/lesson',[TeacherController::class,'detachLesson']);
    Route::post('detach/student/lesson',[StudentController::class,'detachLesson']);



});

Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {

    Route::post('login', [AuthController::class,'login'])->name('login');
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);

});
