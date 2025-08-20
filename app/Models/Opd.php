<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opd extends Model
{
    protected $guarded = [];
    public function datasets()
    {
        return $this->hasMany(Dataset::class);
    }
}
