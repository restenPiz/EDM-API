<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    protected $table = 'boards';

    protected $fillable = [
        'board_name'
    ];

    //*Start with the relationship methods
}
