<?php

namespace App\Enums;



enum InvoiceStatus: string
{
    case Draft = 'draft';
    case Processing = 'processing';
    case Cancelled = 'cancelled';
    case Paid = 'paid';
    case Completed = 'completed';

    public static function getStatuses()
    {
        return [
            self::Draft ,
            self::Processing,
            self::Cancelled ,
            self::Paid,
            self::Completed
        ];
    }
}
