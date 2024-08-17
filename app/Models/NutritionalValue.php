<?php

namespace App\Models;

class NutritionalValue extends BaseModel
{
    protected $fillable = ['carbohydrates', 'proteins', 'fats'];

    protected $casts = ['carbohydrates' => 'float', 'proteins' => 'float', 'fats' => 'float'];

}
