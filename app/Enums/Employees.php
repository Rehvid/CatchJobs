<?php

namespace App\Enums;

enum Employees: String
{
    case EMPLOYEE_1_TO_5 = '1 - 5';
    case EMPLOYEE_5_TO_10 = '5 - 10';
    case EMPLOYEE_10_TO_25 = '10 - 25';
    case EMPLOYEE_25_TO_50 = '25 - 50';
    case EMPLOYEE_50_TO_100 = '50 - 100';
    case EMPLOYEE_100_TO_500 = '100 - 500';
    case EMPLOYEE_ABOVE_500 = '500 +';
}
