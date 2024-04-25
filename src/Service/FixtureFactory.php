<?php

namespace DoctrineFixtureModule\Service;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

/**
 * Factory for Fixtures
 *
 * @license MIT
 * @link    www.doctrine-project.org
 * @author  Martin Shwalbe <martin.shwalbe@gmail.com>
 */
class FixtureFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return $this->getOptions($container);
    }

    /**
     * Gets options from configuration based on name
     */
    public function getOptions(ContainerInterface $sl)
    {
        $options = $sl->get('config');
        if (!isset($options['doctrine']['fixture'])) {
            return [];
        }

        return $options['doctrine']['fixture'];
    }
}
