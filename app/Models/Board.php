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
    public function occurrences(): HasMany
    {
        return $this->hasMany(Occurrence::class, 'board_id', 'id');
    }
}
