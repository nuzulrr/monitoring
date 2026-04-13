<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Projek;

class Site extends Model
{
    protected $table = 'site'; //

    protected $primaryKey = 'id_site';

    protected $fillable = [
        'id_projek',
        'projek',
        'alamat',
        'kategori',
        'latitude',
        'longitude',
        'ip_address',
        'note',
        'tgl_instalasi'
    ];

  public function projek_ref()
    {
        return $this->belongsTo(\App\Models\Projek::class, 'id_projek');
    }
}
