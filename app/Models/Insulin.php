<?php

namespace App\Models;

use App\Models\Traits\CreatorTrait;

class Insulin extends BaseModel
{
    use CreatorTrait;

    protected $fillable = ['name'];

}
