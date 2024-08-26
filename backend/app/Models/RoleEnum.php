<?php

namespace App\Models;

enum RoleEnum: string
{
  case ADMIN = 'ADMIN';
  case VIEWER = 'VIEWER';
}
