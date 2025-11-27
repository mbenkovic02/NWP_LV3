<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'naziv_projekta',
        'opis_projekta',
        'cijena_projekta',
        'obavljeni_poslovi',
        'datum_pocetka',
        'datum_zavrsetka',
    ];

    // voditelj projekta
    public function leader()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // članovi tima
    public function members()
    {
        return $this->belongsToMany(User::class, 'project_user');
    }
}
