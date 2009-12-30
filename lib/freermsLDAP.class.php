<?php

class freermsLDAP
{
  static $conn;
  
  public static function getConnection()
  {
    if (freermsLDAP::$conn && is_resource(freermsLDAP::$conn)
      && get_resource_type(freermsLDAP::$conn) == 'ldap link') {
      
      // LDAP connection already initialized
      
      return freermsLDAP::$conn;
    }
    
    if (! extension_loaded('ldap') && !@dl('ldap.' . PHP_SHLIB_SUFFIX)) {
      throw new Exception('PHP LDAP module not loaded');
    }
    
    if (! sfConfig::get('app_ldap_host') ) {
      throw new Exception('LDAP host not set in configuration');
    }
    
    $conn = @ldap_connect(sfConfig::get('app_ldap_host'));
    if (! $conn ) {
      throw new Exception('LDAP error: ' . @ldap_error($conn));
    }
    
    @ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);
    
    return freermsLDAP::$conn = $conn;
  }
  
  public static function bind($dn, $password)
  {
    if ( !is_string($dn) || strlen($dn) < 1 ) {
      throw new Exception('DN must be a non-empty string');
    }

    if ( !is_string($password) || strlen($password) < 1 ) {
      throw new Exception('Password must be a non-empty string');
    }

    $conn = freermsLDAP::getConnection();

    // if bind fails, this function throws warning, so let's suppress
    // and use our own error-handling
    $bind_attempt = @ldap_bind($conn, $dn, $password);

    if ($bind_attempt) {
      // Successful authentication
      return true;
      
    } elseif ( @ldap_errno($conn) == 49 ) {
      // Invalid credentials
      return false;
      
    } else {
      // Some other error
      throw new Exception('LDAP error: ' . @ldap_error($conn));
    }
  }
  
  public static function getSearchResults
    ($filter, $return_attrs = null, $base_dn = null)
  {
    // sanity checks
    
    if ( !is_string($filter) || strlen($filter) < 1 ) {
      throw new Exception('Search filter must be a non-empty string');
    }

    if (
         ( !is_string($base_dn) || strlen($base_dn) < 1 )
         && $base_dn !== null
    ) {
      throw new Exception('If provided, base DN must be a non-empty string');
    }

    if (
         ( !is_array($return_attrs) || count($return_attrs) == 0 )
         && $return_attrs !== null
       ) {
      throw new Exception('If provided, attributes to return must be an array');
    }

    if ($base_dn === null) {
      $base_dn = sfConfig::get('app_ldap_base-dn');
    }
      
    if (!$base_dn) {
      throw new Exception('No base DN provided');
    }
    
    // sanity confirmed; attempt to bind using admin creds
    
    if (!sfConfig::get('app_ldap_admin-dn')
      || !sfConfig::get('app_ldap_admin-pw')
    ) {
      throw new Exception ('Could not retrieve LDAP admin credentials');
    }
    
    $conn = freermsLDAP::getConnection();
    $bind = @ldap_bind(
      $conn,
      sfConfig::get('app_ldap_admin-dn'),
      sfConfig::get('app_ldap_admin-pw')
    );

    if (!$bind) {
      throw new Exception('Could not bind using admin credentials');
    }
    
    // now perform search
    
    $search = @ldap_search($conn, $base_dn, $filter, $return_attrs);
    if (@ldap_errno($conn)) {
      throw new Exception('LDAP error: ' . @ldap_error($conn));
    }

    $result = @ldap_get_entries($conn, $search);
    if (@ldap_errno($conn)) {
      throw new Exception('LDAP error: ' . @ldap_error($conn));
    }
  
    return $result;
  }
}
