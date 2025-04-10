<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\WindowOrder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClientLimit extends Model
{
    use HasFactory;
    protected $table = 'client_limit';

    protected $fillable = [
        'Client','ClientLimit'
    ];

    public $timestamps = false;

     /**
     * Relasi ke ClientOrder
     */
    public function orders(): HasMany
    {
        return $this->hasMany(WindowOrder::class, 'Client', 'Client');
    }
}
