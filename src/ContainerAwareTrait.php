<?php

namespace DoctrineFixtureModule;

use Psr\Container\ContainerInterface;

trait ContainerAwareTrait
{
    protected ?ContainerInterface $container = null;

    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }
}
