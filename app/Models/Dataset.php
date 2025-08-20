<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dataset extends Model
{
    protected $guarded = [];
    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
