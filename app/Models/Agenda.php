<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'id',
        'title',
        'amount',
        'id_client',
        'id_user',
        'date'
    ];
}
