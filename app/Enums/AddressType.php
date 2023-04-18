<?php

namespace App\Enums;



enum AddressType: string
{
    case Invoicing = 'invoicing';
    case Billing = 'billing';
}
