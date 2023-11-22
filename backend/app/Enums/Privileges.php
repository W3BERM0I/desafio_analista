<?php

namespace App\Enums;

enum Privileges: string
{
    case COMMON = 'pv03';
    case ADMIN = 'pv02';
    case SUPER_ADMIN = 'pv01';
}