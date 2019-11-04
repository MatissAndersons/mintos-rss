<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string word
 * @property int rank
 */
class CommonWords extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'word',
        'rank'
    ];
}
