<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDetails extends Model
{
    protected $fillable = [
        'to',
        'email',
        'companyName',
        'address',
        'handleBy',
        'outstanding',
    ];

    public function payments()
{
    return $this->hasMany(advancePayment::class);
}

}
