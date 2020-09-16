<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function Sodium\crypto_box_publickey_from_secretkey;

class Manager extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'family','user_id'];

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
