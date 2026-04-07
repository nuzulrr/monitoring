<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projek extends Model
{
    protected $table = 'projek';

    protected $primaryKey = 'id_projek';

    protected $fillable = [
        'nama_projek',
        
    ];
}