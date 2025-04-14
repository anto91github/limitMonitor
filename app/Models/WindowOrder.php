<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WindowOrder extends Model
{
    use HasFactory;

    protected $table = 'client_order';
    protected $primaryKey = 'Id'; 

    protected $fillable = [
        'Id','TrxDate', 'SettleDate', 'BorS', 'Client', 'Obligasi', 'Nominal', 'Harga',
        'Amount', 'Uid', 'Status', 'ApprovedBy', 'ApprovedDate', 'RejectedDate', 'RejectedBy', 'Note', 'OverLimit', 'CreatedAt'
    ];
    
    // Nonaktifkan timestamps jika tidak ada kolom created_at/updated_at
    public $timestamps = false;

}
