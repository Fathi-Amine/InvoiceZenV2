<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = ['serial_number', 'invoice_Date', 'due_date', 'customer_id', 'product_id', 'status', 'gross_price', 'discount', 'TVA', 'TVA_rate', 'total', 'note', 'payment_date','created_by', 'updated_by', 'deleted_at'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'user_id', 'id');
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
