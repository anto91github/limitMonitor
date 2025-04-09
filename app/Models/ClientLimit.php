<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientLimit extends Model
{
    use HasFactory;
    protected $table = 'client_limit';

    protected $fillable = [
        'Client','ClientLimit'
    ];

    public $timestamps = false;
}
