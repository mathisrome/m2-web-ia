<?php

namespace App\Enum;

enum PriceCategory: string
{
    case LOW = "low";
    case NORMAL = "normal";
    case HIGH = "high";
    case SCAM = "scam";
}
