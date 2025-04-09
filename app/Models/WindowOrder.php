<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WindowOrder extends Model
{
    use HasFactory;

    protected $table = 'client_order';
    protected $primaryKey = 'Id'; 
    
    // Nonaktifkan timestamps jika tidak ada kolom created_at/updated_at
    public $timestamps = false;
}
