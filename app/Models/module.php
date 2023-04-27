<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;
    protected $table = 'modules';
    protected $fillable = [
        'idFilliere',
        'idProf',
        'nom',
        'masseHorraire',
    ];

    function filliere() {
        return $this->belongsTo(Filiere::class, 'id');
    }

    function profs() {
        return $this->belongsTo(Prof::class, 'id');
    }
}
