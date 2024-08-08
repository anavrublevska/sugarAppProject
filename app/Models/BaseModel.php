<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected function serializeDate(\DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function scopeByCreator($query, $user)
    {
        return $query->where('created_by', $user->id);
    }

    public function scopeByDate($query, $date)
    {
        return $query->where('date', $date);
    }

}
