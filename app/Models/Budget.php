<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'budgets';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'title',
        'amount',
        'id_client',
        'id_user',
        'size',
        'body_part'
    ];
}
