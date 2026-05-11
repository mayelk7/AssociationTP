<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Association extends Model
{
    use HasFactory;

    protected $table = 'associations';

    protected $primaryKey = 'id_asso';

    protected $fillable = ['nom_asso', 'email_asso', 'ville_asso', 'description_asso','domaine_id'];

    public function domaine()
    {
        return $this->belongsTo(Domaine::class, 'domaine_id', 'id_domaine');
    }

}
