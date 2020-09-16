<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'family','teacher_id','user_id'];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
