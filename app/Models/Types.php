<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Docs;
use App\Models\Applications;

class Types extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function docs(): HasOne
    {
        return $this->hasOne(Docs::class);
    }

    public function Applications(): HasOne
    {
        return $this->hasOne(Applications::class);
    }
}
