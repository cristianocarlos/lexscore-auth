<?php

namespace App\Enums;

enum YiiEnum: int
{
    case STATUS_OK = 2;
    case USER_TOKEN_EMAIL_CHANGE = 8011;
    case USER_TOKEN_PASSWORD_RESET = 8012;
}
