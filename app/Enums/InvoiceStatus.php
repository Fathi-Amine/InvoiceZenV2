<?php

namespace App\Enums;



enum AddressType: string
{
    case Unpaid = 'unpaid';
    case Paid = 'paid';
}
