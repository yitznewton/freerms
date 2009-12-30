<?php

interface freermsUserInterface
{
  public function checkPassword($password);
  public function getUserLibraryIds();
  public function getCredentials();
}
