<?php

namespace IvaoBrasil\Infrastructure\Data\User;

enum AtcRating: int
{
    case NA = 0;
    case AS1 = 2;
    case AS2 = 3;
    case AS3 = 4;
    case ADC = 5;
    case APC = 6;
    case ACC = 7;
    case SEC = 8;
    case SAI = 9;
    case CAI = 10;
}
