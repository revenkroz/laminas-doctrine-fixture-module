# Laminas Doctrine Fixture module

## Introduction

This is fork from [Houndog/DoctrineDataFixtureModule](https://github.com/Hounddog/DoctrineDataFixtureModule).

The DoctrineDataFixtureModule module intends to integrate [Doctrine2 ORM Data Fixtures](https://github.com/doctrine/data-fixtures) with Zend Framework 3.

## Installation

Add this project in your repositories in composer.json:

```json
"repositories": [
    {
      "type": "git",
      "url": "https://github.com/revenkroz/laminas-doctrine-fixture-module"
    }
]
```

Install package:
```sh
composer req revenkroz/laminas-doctrine-fixture-module:dev-main
```

Add `DoctrineFixtureModule` to your `modules`.

#### Register Fixtures

To register fixtures with Doctrine module add the fixtures in your configuration.

```php
<?php

return [
    'doctrine' => [
        'fixture' => [
            'ModuleName' => __DIR__ . '/../src/ModuleName/Fixture',
        ],
    ],
];
```

## Usage

#### Default
```sh
./vendor/bin/doctrine-module orm:fixtures:load 
```

#### Purge with truncate and without confirmation
```sh
./vendor/bin/doctrine-module orm:fixtures:load -n --purge-with-truncate 
```

#### Append data instead of delete
```sh
./vendor/bin/doctrine-module orm:fixtures:load -n --append
```

## How to inject container into fixtures file


```php
<?php

namespace Application\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineDataFixtureModule\ContainerAwareInterface;
use DoctrineDataFixtureModule\ContainerAwareTrait;

class LoadUser implements FixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $myService = $this->container->get('my_service');        
    }
}

```
