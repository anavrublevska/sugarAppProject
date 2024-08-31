<?php

namespace App\Models;

use App\Models\Traits\CreatorTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends BaseModel
{
    use CreatorTrait;

    protected $fillable = ['name', 'carbohydrates', 'proteins', 'fats'];

    protected $casts = ['carbohydrates' => 'float', 'proteins' => 'float', 'fats' => 'float'];

}
