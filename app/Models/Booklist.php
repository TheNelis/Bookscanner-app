<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booklist extends Model
{
    use HasFactory;

    protected $table = 'booklist';

    protected $fillable = [
        'title',
        'authors',
        'image'
    ];
}