<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 
use Illuminate\Database\Eloquent\Relations\HasOne; 
use App\Models\User;
use App\Models\Types;
use App\Models\Answers; 

class Applications extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'desc',
        'date',
        'status',
        'user_id',
        'type_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Types::class, 'type_id');
    }

    public function answers(): HasOne
    {
        return $this->hasOne(Answers::class);
    }
}
