<?php

namespace App\Models\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

trait CreatorTrait
{
    private static string $createdByColumn = 'created_by';

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, self::getCreatedByColumn());
    }

    protected static function bootCreatorTrait(): void
    {
        static::creating(static function ($model) {
            $model->creator()->associate(self::getLoggedId());
        });
    }

    public static function getLoggedId(): ?int
    {
        return Auth::id();
    }


    /**
     * Get the name of the "created by" column.
     */
    public static function getCreatedByColumn(): string
    {
        return self::$createdByColumn;
    }

}
