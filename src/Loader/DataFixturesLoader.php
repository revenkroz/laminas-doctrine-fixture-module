<?php

namespace DoctrineFixtureModule\Loader;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\Loader;
use DoctrineFixtureModule\ContainerAwareInterface;
use Interop\Container\ContainerInterface;

/**
 * Class ServiceLocatorAwareLoader
 * @package DoctrineDataFixtureModule\Loader
 */
class DataFixturesLoader extends Loader
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * ServiceLocatorAwareLoader constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Add a fixture object instance to the loader.
     *
     * @param FixtureInterface $fixture
     */
    public function addFixture(FixtureInterface $fixture)
    {
        if ($fixture instanceof ContainerAwareInterface) {
            $fixture->setContainer($this->container);
        }
        parent::addFixture($fixture);
    }
}
