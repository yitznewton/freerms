<?php

class generateUsageDataTask extends sfDoctrineBaseTask
{
  protected function configure()
  {
    $this->addArguments(array(
      new sfCommandArgument('number_of_entries', sfCommandArgument::OPTIONAL, 'Number of entries', 1000),
    ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The connection name', true),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
    ));

    $this->namespace        = 'doctrine';
    $this->name             = 'generate-usage-data';
    $this->briefDescription = 'Generate random database usage data';
    $this->detailedDescription = <<<EOF
The [doctrine:generate-usage-data|INFO] task generates random database usage data.
Call it with:

  [php symfony doctrine:generate-usage-data|INFO] number_of_entries
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $this->logSection('doctrine', 'Generating random usage data');

    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);

    $this->generateDatabaseData($arguments['number_of_entries']);
    $this->generateUrlData($arguments['number_of_entries']);
  }

  protected function generateDatabaseData($howMany)
  {
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

    for ($i = 0; $i < $howMany; $i++) {
      $st->execute(array(
        ':database_id' => array_rand($databaseIds),
        ':library_id' => array_rand($libraryIds),
        ':is_onsite' => rand(0,100) % 4 === 0 ? 0 : 1,
        ':is_mobile' => rand(0,100) % 5 === 0 ? 1 : 0,
        ':timestamp' => $this->getRandomTime(),
        ':sessionid' => md5($i),
      ));
    }
  }

  protected function generateUrlData($howMany)
  {
    $libraryIds = array_map(function($library) {
      return $library['id']; 
    }, Doctrine_Core::getTable('Library')->findAll()->toArray());

    $libraryIds = array_flip($libraryIds);

    $hosts = array();

    for ($i = 0; $i < 7; $i++) {
      $hosts[] = $this->getRandomHost();
    }

    $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
    $st = $pdo->prepare('INSERT INTO url_usage (host, library_id, '
      . 'is_onsite, is_mobile, timestamp, sessionid) VALUES '
      . '(:host, :library_id, :is_onsite, :is_mobile, :timestamp, '
      . ':sessionid)');

    for ($i = 0; $i < $howMany; $i++) {
      $st->execute(array(
        ':host'      => $hosts[rand(0, count($hosts) - 1)],
        ':library_id' => array_rand($libraryIds),
        ':is_onsite' => rand(0,100) % 4 === 0 ? 0 : 1,
        ':is_mobile' => rand(0,100) % 5 === 0 ? 1 : 0,
        ':timestamp' => $this->getRandomTime(),
        ':sessionid' => md5($i),
      ));
    }
  }

  protected function getRandomTime()
  {
    static $startDate, $endDate, $startDateUnix, $endDateUnix, $timeDifference;

    if (!isset($startDate)) {
      $startDate = '2011-01-01';
      $endDate   = '2012-12-31';

      $startDateUnix = strtotime($startDate);
      $endDateUnix   = strtotime($endDate);

      $timeDifference = $endDateUnix - $startDateUnix;
    }

    return date('Y-m-d', $startDateUnix + rand(0, $timeDifference));
  }

  protected function getRandomHost()
  {
    static $chars;
    
    if (!isset($chars)) {
      $chars = range('a', 'z');
    }

    $host = 'www.';

    for ($i = 0; $i < 8; $i++) {
      $host .= $chars[rand(0, 25)];
    }

    $host .= '.com';

    return $host;
  }
}

