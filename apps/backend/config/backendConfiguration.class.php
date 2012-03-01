<?php

class backendConfiguration extends sfApplicationConfiguration
{
  public function configure()
  {
    // when updating a Database or Subject, or featured, clear frontend
    // cache
    $this->dispatcher->connect('admin.save_object', function($event) {
      switch (get_class($event->offsetGet('object'))) {
        case 'Database':
        case 'Subject':
          $frontendCache = new sfFileCache(array(
            'cache_dir' => sfConfig::get('sf_cache_dir') . '/frontend/'
                           . sfConfig::get('sf_environment') . '/template'));

          $frontendCache->clean();
          return;

        default:
          // do nothing
          return;
      }
    });
  }
}
