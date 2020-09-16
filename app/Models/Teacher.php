<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'family','manager_id','user_id'];

    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
