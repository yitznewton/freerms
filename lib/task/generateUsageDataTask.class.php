<?php

class generateUsageDataTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addArguments(array(
      new sfCommandArgument('number_of_entries', sfCommandArgument::OPTIONAL, 'Number of entries', 1000),
    ));

    $this->addOptions(array(
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'generate';
    $this->name             = 'usage-data';
    $this->briefDescription = 'Generate random database usage data';
    $this->detailedDescription = <<<EOF
The [generate:usage-data|INFO] task generates random database usage data.
Call it with:

  [php symfony generate:usage-data|INFO] number_of_entries
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $this->logSection('generate', 'Generating random usage data');

    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    $startDate = '2011-01-01';
    $endDate   = '2012-12-31';

    $startDateUnix = strtotime($startDate);
    $endDateUnix   = strtotime($endDate);

    $timeDifference = $endDateUnix - $startDateUnix;

    $databaseIds = array_map(function($database) {
      return $database['id']; 
    }, Doctrine_Core::getTable('Database')->findAll()->toArray());

    $libraryIds = array_map(function($library) {
      return $library['id']; 
    }, Doctrine_Core::getTable('Library')->findAll()->toArray());

    $databaseIds = array_flip($databaseIds);
    $libraryIds = array_flip($libraryIds);

    $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
    $st = $pdo->prepare('INSERT INTO database_usage (database_id, library_id, '
      . 'is_onsite, is_mobile, timestamp, sessionid) VALUES '
      . '(:database_id, :library_id, :is_onsite, :is_mobile, :timestamp, '
      . ':sessionid)');

    for ($i = 0; $i < $arguments['number_of_entries']; $i++) {
      $st->execute(array(
        ':database_id' => array_rand($databaseIds),
        ':library_id' => array_rand($libraryIds),
        ':is_onsite' => rand(0,100) % 4 === 0 ? 0 : 1,
        ':is_mobile' => rand(0,100) % 5 === 0 ? 1 : 0,
        ':timestamp' => date('Y-m-d', $startDateUnix + rand(0, $timeDifference)),
        ':sessionid' => md5($i),
      ));
    }
  }
}

