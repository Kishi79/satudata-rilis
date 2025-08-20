<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $guarded = [];
    protected $casts = ['release_date' => 'date'];
    public function dataset()
    {
        return $this->belongsTo(Dataset::class);
    }
    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }
    // scope untuk highlight jadwal ≤ 7 hari
    public function scopeUpcoming($q)
    {
        return $q->whereDate('release_date', '>=', now())->whereDate('release_date', '<=', now()->addDays(7));
    }
}
