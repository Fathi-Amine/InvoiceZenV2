<?php

namespace App\Models;

use App\Enums\InvoiceStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = ['serial_number', 'invoice_Date', 'due_date', 'customer_id', 'product_id', 'status', 'gross_price', 'discount', 'TVA', 'TVA_rate', 'total', 'note', 'payment_date','created_by', 'updated_by', 'deleted_at'];


    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function isPaid()
    {
        return $this->status === InvoiceStatus::Paid->value;
    }

    public function payment() :HasOne
    {
        return $this->hasOne(Payment::class);
    }
    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

}
