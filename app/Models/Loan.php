<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'loan_request_id',
        'total_amount',
        'monthly_installment',
        'remaining_balance',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function loanRequest()
    {
        return $this->belongsTo(LoanRequest::class);
    }

    public function installments()
    {
        return $this->hasMany(Installment::class);
    }
}
