<?php

/**
 * @param Database $database
 * @param array $options
 * @return string
 */
function link_to_database(Database $database, array $options = array())
{
  return link_to($database->getTitle(), '@database_access?id='
    . $database->getId(), $options); 
}

