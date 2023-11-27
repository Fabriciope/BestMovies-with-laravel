<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'synopsis',
        'duration',
        'poster',
        'trailer_link'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class, 'movie_id', 'id');
    }

    public function hours(): int
    {
        return explode(':', $this->duration)[0];
    }
    
    public function minutes(): int
    {
        return explode(':', $this->duration)[1];
    }

    public function shareLink(): string
    {
        $code = mb_substr($this->trailer_link, 30);
        return "https://youtu.be/{$code}";
    }

    //TODO: criar função para calcular a nota do filme
}
