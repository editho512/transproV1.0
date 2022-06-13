<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrajetRemorque extends Model
{
    use HasFactory;

    protected $fillable = ["remorque_id", "trajet_id"];

    public $timestamps = false;

    public function remorque(){
        return $this->hasOne(Remorque::class, 'remorque_id', 'id');
    }

    public function trajet(){
                
        return $this->hasOne(Trajet::class, 'trajet_id', 'id');
    }
}
