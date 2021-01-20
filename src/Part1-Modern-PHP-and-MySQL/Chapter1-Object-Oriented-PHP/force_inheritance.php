<?php

declare(strict_types=1);

namespace Book;

use Book\ForceInheritance\FrontEndUser;
use Book\ForceInheritance\AdminUser;
use Book\ForceInheritance\AdminPermission;

require __DIR__ . '/../../../vendor/autoload.php';

$frontEndUser = new FrontEndUser(
    2, 'Steve', 'http://php.com', 'http://something.com'
);
echo $frontEndUser;

$adminUser = new AdminUser(
    1,
    'Joseph',
    new AdminPermission(permName: AdminPermission::CAN_VIEW, can: true),
    new AdminPermission(permName: AdminPermission::CAN_EDIT, can: true)
);

echo $adminUser;