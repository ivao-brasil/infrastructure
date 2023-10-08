<?php

namespace IvaoBrasil\Infrastructure\Data\User;

enum PilotRating: int
{
    case NA = 0;
    case FS1 = 2;
    case FS2 = 3;
    case FS3 = 4;
    case PP = 5;
    case SPP = 6;
    case CP = 7;
    case ATP = 8;
    case SFI = 9;
    case CFI = 10;
}
