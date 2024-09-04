<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FantomPoint extends BaseModel
{
    protected $fillable = ['date', 'coord_x', 'coord_y', 'description', 'color'];

    protected $casts = ['date' => 'date', 'coord_x' => 'integer', 'coord_y' => 'integer'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeByUser($query, User $user)
    {
        return $query->where('user_id', $user->id);
    }
}
