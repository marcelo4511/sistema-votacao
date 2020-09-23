<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $table = 'survey';

    protected $fillable = [
        'id',
        'title',
        'dateinicial',
        'datefinal',
        'option1',
        'option2',
        'option3',
        'totaloption1',
        'totaloption2',
        'totaloption3',
        'status',
    ];
}
