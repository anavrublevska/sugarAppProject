<?php

namespace App\Models;

use App\Models\Traits\CreatorTrait;

class Product extends BaseModel
{
    use CreatorTrait;

    protected $fillable = ['name'];

}
