<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cicle extends Model
{
    use HasFactory;
    protected $table = 'cicles';
    // protected $primaryKey = 'id';
    // protected $incrementing = true;
    public $timestamps = false;

    public function cursos()
    {
        return $this->hasMany(Curs::class, 'cicles_id');
    }
}
