<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 
use App\Models\Types;

class Docs extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'file',
        'type_id'
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(Types::class , 'type_id');
    }
}
