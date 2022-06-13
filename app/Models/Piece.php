<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Piece extends Model
{
    use HasFactory;

    protected $fillable = [
        'designation',
    ];

    protected $with = ['fournisseur'];


    /**
     * Recuperer le fournisseur du piece
     *
     * @return BelongsToMany
     */
    public function fournisseur() : BelongsToMany
    {
        return $this->belongsToMany(Fournisseur::class, 'maintenance_piece_frs', 'piece', 'fournisseur');
    }
}
