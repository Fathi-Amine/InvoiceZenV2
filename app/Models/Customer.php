<?php

namespace App\Models;

use App\Enums\AddressType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    use HasFactory;
    protected $primaryKey = 'user_id';

    protected $fillable = ['first_name', 'last_name', 'phone', 'status',];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    private function _getAddresses(): HasOne
    {
        return $this->hasOne(CustomerAddress::class, 'customer_id', 'user_id');
    }

    public function invoicingAddress(): HasOne
    {
        return $this->_getAddresses()->where('type', '=', AddressType::Invoicing->value);
    }

    public function billingAddress(): HasOne
    {
        return $this->_getAddresses()->where('type', '=', AddressType::Billing->value);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'customer_id', 'user_id');
    }
}
