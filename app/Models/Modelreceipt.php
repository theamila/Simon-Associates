<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelreceipt extends Model
{

    protected $fillable = [
        'invoiceNumber',
        'additional',
        'payedDate',
        'receiptNumber',
        'offline',
    ];
}
