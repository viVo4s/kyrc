<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 
use App\Models\Applications;
use App\Models\User;

class Answers extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'application_id',
        'user_id'
    ];

    public function applications(): BelongsTo
    {
        return $this->belongsTo(Applications::class, 'application_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
