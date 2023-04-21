<?php

namespace App\Enums;



enum InvoiceStatus: string
{
    case Draft = 'draft';
    case Processing = 'processing';
    case Paid = 'paid';
    case Completed = 'completed';
}
