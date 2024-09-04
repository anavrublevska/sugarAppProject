<?php

namespace App\Models;

use App\Models\Traits\CreatorTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InsulinLog extends BaseModel
{
    use CreatorTrait;

    protected $fillable = ['quantity', 'date', 'hour'];

    protected $casts = ['quantity' => 'float', 'date' => 'date'];

    public function insulin(): BelongsTo
    {
        return $this->belongsTo(Insulin::class);
    }
}
