<?php

namespace App\Models;

use App\Models\Traits\CreatorTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends BaseModel
{
    use CreatorTrait;

    protected $fillable = ['name'];

    public function nutritionalValue(): BelongsTo
    {
        return $this->belongsTo(NutritionalValue::class);
    }

}
