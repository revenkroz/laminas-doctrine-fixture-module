<?php

namespace DoctrineFixtureModule;

use DoctrineFixtureModule\Command\FixturesLoadCommand;
use Laminas\EventManager\EventInterface;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ModuleManager\ModuleManager;
use Psr\Container\ContainerInterface;

class Module implements ConfigProviderInterface
{
    public function init(ModuleManager $moduleManager): void
    {
        $events = $moduleManager->getEventManager()->getSharedManager();
        $events?->attach('doctrine', 'loadCli.post', [$this, 'addFixturesLoadCommand']);
    }

    public function getConfig(): array
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function addFixturesLoadCommand(EventInterface $event): void
    {
        /* @var \Symfony\Component\Console\Application $application */
        $application = $event->getTarget();

        /* @var ContainerInterface $container */
        $container = $event->getParam('ServiceManager');
        $fixturesLoadCommand = new FixturesLoadCommand($container);
        $application->add($fixturesLoadCommand);
    }
}
