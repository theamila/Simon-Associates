<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetails extends Model
{
    protected $fillable = [
        'description',
        'price',
        'discount',
        'Reimbursables',
        'invoiceNumber',
        'currancy',
        'dollerRate',
        'nom',
        'pom',
        'sdate',
        'remark',
        'convertToD',
        'secAddress',
    ];
}
