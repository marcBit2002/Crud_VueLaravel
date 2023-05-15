<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curs extends Model
{
    use HasFactory;
    protected $table = 'cursos';
    //  protected $primaryKey = 'id';
    // protected $incrementing = true;
    public $timestamps = false;

    public function cicle()
    {
        return $this->belongsTo(Cicle::class, 'cicles_id');
    }

    public function moduls()
    {
        return $this->belongsToMany(Modul::class, 'moduls_has_cursos', 'cursos_id', 'moduls_id')->withPivot('curs_academic_id');
    }
}
