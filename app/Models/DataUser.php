<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataUser extends Model
{
    use HasFactory;
    public $table = "data_user";
    protected $fillable = [
            'user_id',
            'user_name',
            'user_email',
            'user_password',
            'user_gender',
            'user_photo',
            'role_id',
            'user_token'
    ];
}
