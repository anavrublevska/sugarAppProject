<?php

namespace App\Models;

use App\Models\Traits\CreatorTrait;

class SugarLog extends BaseModel
{
    use CreatorTrait;

    protected $fillable = ['level', 'date', 'hour'];

    protected $casts = ['level' => 'float', 'date' => 'date', 'hour' => 'timestamp'];

}
