<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DowntimeLog extends Model
{
    protected $table = 'downtime_logs';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'id_site',
        'ip_address',
        'projek',
        'status',
        'down_at',
        'recovered_at',
        'durasi_menit',
        'alert_sent'
    ];

    protected $casts = [
        'down_at' => 'datetime',
        'recovered_at' => 'datetime',
        'alert_sent' => 'boolean',
    ];

    public function site()
    {
        return $this->belongsTo(\App\Models\Site::class, 'id_site', 'id_site');
    }

    public function scopeCurrentDowntime($query)
    {
        return $query->whereNull('recovered_at');
    }

    public function scopeRecovered($query)
    {
        return $query->whereNotNull('recovered_at');
    }
}
