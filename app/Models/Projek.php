<?php

namespace App\Models;
use App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Projek extends Model
{
    protected $table = 'projek';

    protected $primaryKey = 'id_projek';

    protected $fillable = [
        'nama_projek',
        
    ];
    public function sites()
    {
        // Parameter kedua adalah foreign key di tabel 'site'
        return $this->hasMany(Site::class, 'id_projek', 'id_projek');
    }
}