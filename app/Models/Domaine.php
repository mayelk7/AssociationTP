<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domaine extends Model
{
    use HasFactory;

    protected $table = 'domaine';
    protected $primaryKey = 'id_domaine';
    protected $fillable = ['nom_domaine'];

    public $timestamps = false;

    public function associations()
    {
        return $this->hasMany(Association::class, 'domaine_id', 'id_domaine');
    }
}
