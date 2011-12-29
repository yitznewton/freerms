<?php

class LibrarySfGuardListener extends Doctrine_Record_Listener
{
  /**
   * Check on save to see whether an sfGuardGroup exists to represent this
   * Library, and add if not
   *
   * @param Doctrine_Event $event
   */
  public function preSave(Doctrine_Event $event)
  {
    Doctrine_Core::getTable('sfGuardGroup')->syncLibrary(
      $event->getInvoker());
  }
}

