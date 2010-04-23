<?php

class freermsAPIUser extends freermsBaseUser 
{
  public function checkPassword($password)
  {
    if ($this->isAuthenticated()) {
      return true;
    }
    
    if (! is_string($password) || strlen($password) < 1 ) {
      throw new Exception('Password must be a non-empty string');
    }
    
    if (! $this->getUsername() ) {
      throw new Exception('Username must be set first');
    }
    
    $username = $this->getUsername();
    $sha1password = sha1($password);
    
    $url = sprintf(sfConfig::get('app_user-api_url-mask'),
      $username, $sha1password);
    
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $json = curl_exec($curl);
    $curl_info = curl_getinfo($curl);
    curl_close($curl);
    
    if (!$json || $curl_info['http_code'] == 404) {
      $error_msg = 'Authentication server did not return a valid response';
      return new Exception($error_msg);
    }
    
    $result = json_decode($json);

    if (isset($result->sites)) {
      $this->setUserLibrarys($result->sites);
      $this->setUserGroups($result->groups);
      return true;
    } elseif (isset($result->error)) {
      $this->setFlash('loginError', $result->error);
      return false;
    } else {
      return false;
    }
  }
  
  protected function setUserLibrarys($codes)
  {
    $ids = array();
    foreach ($codes as $c) {
      if ($library = LibraryPeer::retrieveByCode($c)) {
        $ids[] = $library->getId();
      }
    }

    $this->setAttribute('userLibraryIds', $ids);
    return $ids;
  }
  
  protected function setUserGroups($groups)
  {
    foreach ($groups as $g) {
      if (! $prefix = sfConfig::get('app_user-api_credential-prefix') ) {
        $this->addCredential($g);
      } elseif (substr($g, 0, strpos($g, '_')) == $prefix) {
        $this->addCredential(substr($g, strpos($g, '_')+1));
      }
    }

    return $this->getCredentials();
  }

  public function getLibraryIds()
  {
    return $this->getAttribute('userLibraryIds');
  }
}
