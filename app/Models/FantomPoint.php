<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FantomPoint extends BaseModel
{
    protected $fillable = ['date', 'coord_x', 'coord_y', 'description'];

    protected $casts = ['date' => 'date', 'coord_x' => 'integer', 'coord_y' => 'integer'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
