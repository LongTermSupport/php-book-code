<?php

declare(strict_types=1);

namespace Book\Part1\Chapter1;

use Book\Part1\Chapter1\ForceInheritance\AdminPermission;
use Book\Part1\Chapter1\ForceInheritance\AdminUser;
use Book\Part1\Chapter1\ForceInheritance\FrontEndUser;

require __DIR__ . '/../../../vendor/autoload.php';

$frontEndUser = new FrontEndUser(
    2,
    'Steve',
    'http://php.com',
    'http://something.com'
);
echo $frontEndUser;

$adminUser = new AdminUser(
    1,
    'Joseph',
    new AdminPermission(permName: AdminPermission::CAN_VIEW, allowed: true),
    new AdminPermission(permName: AdminPermission::CAN_EDIT, allowed: true)
);

echo $adminUser;
