<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppTopPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'country_id',
        'date',
        'category',
        'position',
    ];

    public function scopeForDate(Builder $query, string $date): Builder
    {
        return $query->whereDate('date', $date);
    }

}
