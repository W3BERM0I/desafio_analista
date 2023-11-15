<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mongodb\Laravel\Eloquent\Model;

class TotaisDias extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';

    protected $collection = 'totais_dias';

    protected $fillable = [
        'data',
        'debito',
        'credito',
        'lctos',
    ];
}
