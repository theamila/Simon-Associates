<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'status',
        'to',
        'email',
        'companyName',
        'address',
        'invoiceNumber',
        'currency',
        'dollerRate',
        'date',
        'handleBy',
        'refID',
        'customerRefId',
        'debtor',
    ];
}
