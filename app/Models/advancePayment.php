<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class advancePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'currency',
        'payment_date',
        'amount',
        'invoiceId',
        'receiptNo',
        'payment_method',
        'description',
        'is_applied',
    ];

    public function customer()
    {
        return $this->belongsTo(CompanyDetails::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoiceId', 'id');
    }

}
