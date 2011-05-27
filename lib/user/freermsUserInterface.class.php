<?php

interface freermsUserInterface
{
  public function checkPassword($password);
  public function getLibraryIds();
  public function getCredentials();
}
