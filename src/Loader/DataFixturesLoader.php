<?php

namespace DoctrineFixtureModule\Loader;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\Loader;
use DoctrineFixtureModule\ContainerAwareInterface;
use Psr\Container\ContainerInterface;

class DataFixturesLoader extends Loader
{
    public function __construct(
        private ContainerInterface $container,
    ) {
    }

    /**
     * Add a fixture object instance to the loader
     */
    public function addFixture(FixtureInterface $fixture): void
    {
        if ($fixture instanceof ContainerAwareInterface) {
            $fixture->setContainer($this->container);
        }

        parent::addFixture($fixture);
    }
}
