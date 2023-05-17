<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Audience extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable =[
        'nama',
        'email',
        'telp',
        'jadwal',
        'cat',
        'tiket',
    ];
}
