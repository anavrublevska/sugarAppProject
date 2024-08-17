<?php

namespace App\Models;

use App\Models\Traits\CreatorTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductLog extends BaseModel
{
    use CreatorTrait;

    protected $fillable = ['grams', 'date', 'hour', 'successful', 'comment'];

    protected $casts = ['grams' => 'integer', 'date' => 'date', 'hour' => 'timestamp', 'successful' => 'boolean'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function nutritionalValue(): BelongsTo
    {
        return $this->belongsTo(NutritionalValue::class);
    }

    public function insulinLog(): BelongsTo
    {
        return $this->belongsTo(InsulinLog::class);
    }

    public function sugarBefore(): BelongsTo
    {
        return $this->belongsTo(SugarLog::class, 'sugar_before_id');
    }

    public function sugarAfter(): BelongsTo
    {
        return $this->belongsTo(SugarLog::class, 'sugar_after_id');
    }

}
