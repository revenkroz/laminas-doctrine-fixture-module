<?php

namespace DoctrineFixtureModule\Command;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use DoctrineFixtureModule\Loader\ServiceLocatorAwareLoader;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCommand extends Command
{
    private const PURGE_MODE_TRUNCATE = 2;

    public function __construct(
        private ContainerInterface $container,
        private ?EntityManagerInterface $em = null,
        private array $paths = [],
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        parent::configure();

        $this->setName('data-fixture:import')
            ->setDescription('Import Data Fixtures')
            ->setHelp(
<<<EOT
The import command Imports data-fixtures
EOT
            )
            ->addOption('append', null, InputOption::VALUE_NONE, 'Append data to existing data.')
            ->addOption('purge-with-truncate', null, InputOption::VALUE_NONE, 'Truncate tables before inserting data');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $loader = new ServiceLocatorAwareLoader($this->container);
        $purger = new ORMPurger();

        if ($input->getOption('purge-with-truncate')) {
            $purger->setPurgeMode(self::PURGE_MODE_TRUNCATE);
        }

        $executor = new ORMExecutor($this->em, $purger);

        foreach ($this->paths as $key => $value) {
            $loader->loadFromDirectory($value);
        }

        $executor->execute($loader->getFixtures(), $input->getOption('append'));

        return Command::SUCCESS;
    }
}
