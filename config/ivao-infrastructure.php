<?php

use IvaoBrasil\Infrastructure\Data\Auth\UserRoles;

return [
    'auth' => [
        'division_code' => 'BR',
        'super_admin_roles' => [
            UserRoles::WEB_COORDINATOR,
            UserRoles::WEB_ADVISOR,
            UserRoles::DIRECTOR
        ],
        'role_mapping' => [
            // XX-DIR, XX-ADIR
            '/-A?DIR$/' => UserRoles::DIRECTOR,
            // XX-SOA, XX-SOAC
            '/-SOA?C$/' => UserRoles::SPEC_OPS_COORDINATOR,
            // XX-SOA1
            '/-SOA\d+$/' => UserRoles::SPEC_OPS_ADVISOR,
            // XX-FOC, XX-FOAC
            '/-FOA?C$/' => UserRoles::FLIGHT_OPS_COORDINATOR,
            // XX-FOA1
            '/-FOA\d+$/' => UserRoles::FLIGHT_OPS_ADVISOR,
            // XX-AOC, XX-AOAC
            '/-AOA?C$/' => UserRoles::ATC_OPS_COORDINATOR,
            // XX-AOA1
            '/-AOA\d+$/' => UserRoles::ATC_OPS_ADVISOR,
            // XX-TC, XX-TAC
            '/-TA?C$/' => UserRoles::TRAINING_COORDINATOR,
            // XX-TA1
            '/-TA\d+$/' => UserRoles::TRAINING_ADVISOR,
            // XX-T01
            '/-T\d+$/' => UserRoles::TRAINER,
            // XX-MC, XX-MAC
            '/-MA?C$/' => UserRoles::MEMBERS_COORDINATOR,
            // XX-MA1
            '/-MA\d+$/' => UserRoles::MEMBERS_ADVISOR,
            // XX-EC, XX-EAC
            '/-EA?C$/' => UserRoles::EVENTS_COORDINATOR,
            // XX-EA1
            '/-EA\d+$/' => UserRoles::EVENTS_ADVISOR,
            // XX-PRC, XX-PRAC
            '/-PRA?C$/' => UserRoles::PUBLIC_RELATIONS_COORDINATOR,
            // XX-PRA1
            '/-PRA\d+$/' => UserRoles::PUBLIC_RELATIONS_ADVISOR,
            // XX-WM, XX-AWM
            '/-A?WM$/' => UserRoles::WEB_COORDINATOR,
            // XX-WMA1
            '/-WMA\d+$/' => UserRoles::WEB_ADVISOR,
            // XXXX-CH, XXXX-ACH
            '/-A?CH/' => UserRoles::FIR_CHIEF,
            // XXXX-ST1
            '/-ST\d+$/' => UserRoles::FIR_SERVICE
        ]
    ]
];
