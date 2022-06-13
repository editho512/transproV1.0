<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemorquePapier extends Model
{
    use HasFactory;

    protected $fillable = ['remorque_id', 'designation', 'type', 'date', 'date_echeance', 'photo'];
}
