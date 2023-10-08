<?php

namespace IvaoBrasil\Infrastructure\Data\Auth;

enum UserRoles: string
{
    case DIRECTOR = 'director';

    case SPEC_OPS_COORDINATOR = 'spec-ops-coord';
    case SPEC_OPS_ADVISOR = 'spec-ops-advisor';

    case FLIGHT_OPS_COORDINATOR = 'flight-ops-coord';
    case FLIGHT_OPS_ADVISOR = 'flight-ops-advisor';

    case ATC_OPS_COORDINATOR = 'atc-ops-coord';
    case ATC_OPS_ADVISOR = 'atc-ops-advisor';

    case TRAINING_COORDINATOR = 'training-coord';
    case TRAINING_ADVISOR = 'training-advisor';
    case TRAINER = 'trainer';

    case MEMBERS_COORDINATOR = 'members-coord';
    case MEMBERS_ADVISOR = 'members-advisor';

    case EVENTS_COORDINATOR = 'events-coord';
    case EVENTS_ADVISOR = 'events-advisor';

    case PUBLIC_RELATIONS_COORDINATOR = 'pr-coord';
    case PUBLIC_RELATIONS_ADVISOR = 'pr-advisor';

    case WEB_COORDINATOR = 'web-coord';
    case WEB_ADVISOR = 'web-advisor';

    case FIR_CHIEF = 'fir-chief';
    case FIR_SERVICE = 'fir-service';

    case STAFF = 'staff';
}
