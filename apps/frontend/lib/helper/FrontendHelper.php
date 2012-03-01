<?php

/**
 * @param Database $database
 * @param array $options
 * @return string
 */
function link_to_database(Database $database, array $options = array())
{
  if ($database->getIsUnavailable()) {
    return $database->getTitle();
  }
  else {
    return link_to($database->getTitle(), '@database_access?id='
      . $database->getId(), $options); 
  }
}

/**
 * @param sfOutputEscaperObjectDecorator $subject
 * @param sfOutputEscaperArrayDecorator $libraryIds
 * @return string
 */
function cache_key($subject, $libraryIds)
{
  return sprintf('%s-%s', $subject ? $subject->getId() : 'x',
    implode(',', $libraryIds->getRawValue()));
}

