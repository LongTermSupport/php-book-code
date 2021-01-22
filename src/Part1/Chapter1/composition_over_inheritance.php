<?php

declare(strict_types=1);

namespace Book\Part1\Chapter1;

use Book\Part1\Chapter1\Composition\AdminPermission\CanEditPermission;
use Book\Part1\Chapter1\Composition\AdminPermission\CanViewPermission;
use Book\Part1\Chapter1\Composition\Person;
use Book\Part1\Chapter1\Composition\UrlCollection;
use Book\Part1\Chapter1\Composition\User\AdminUser;
use Book\Part1\Chapter1\Composition\User\FrontEndUser;
use Book\Part1\Chapter1\Composition\User\UserData;

$frontEndUser = new FrontEndUser(
    new UserData(id: 2, person: new Person(name: 'Steve')),
    new UrlCollection('http://php.com', 'http://something.com')
);
echo $frontEndUser;

$adminUser = new AdminUser(
    new UserData(id: 1, person: new Person(name: 'Joseph')),
    new CanEditPermission(allowed: true),
    new CanViewPermission(allowed: true)
);
echo $adminUser;
