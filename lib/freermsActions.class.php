<?php

class freermsActions
{
  public static function embedForm( sfForm $parent_form, $child_field )
  {
    if ( ! class_exists( $child_field ) ) {
      throw new Exception('Invalid child field class');
    }
    
    // set up method and class names for this instance
    $getter = "get$child_field";
    $setter = "set$child_field";
    $child_form_class = $child_field . 'Form';
    
    if ( ! ($child = $parent_form->getObject()->$getter()) ) {
      // there is no child object, need to create
      $child = new $child_field();
      $parent_form->getObject()->$setter( $child );
      $child_form = new $child_form_class( $child );
    } else {
      // there is already a child object, bind to form
      $child_form = new $child_form_class($child);
    }
    
    $parent_form->embedForm( $child_field, $child_form );
  }
  
  public static function sendNotifyEmail($recipient, $body, $subject = null)
  {
    if ( $subject && ! is_string( $subject ) ) {
      throw new Exception ('Subject must be a string');
    }
    
    if ( ! is_string( $recipient ) ) {
      throw new Exception ('Recipient must be a string');
    }
    
    if ( ! is_string( $body ) ) {
      throw new Exception ('Body must be a string');
    }
    
    if ( ! $subject ) {
      $subject = 'Notification of FreERMS event';
    }
    
    $sender = sfConfig::get('app_support-email');
    
    if ( ! $sender ) {
      throw new RuntimeException('No support email specified');
    }
    
    $freerms_name = sfConfig::get('app_freerms-local-name', 'FreERMS');
    
    $full_body = "Greetings:\n\n$freerms_name would like to notify you of the "
      ."following:\n\n$body";

    $msg = new Swift_Message();
    $msg->setCharset( 'UTF-8'    );
    $msg->setSubject( $subject   );
    $msg->setFrom(    $sender    );
    $msg->setTo(      $recipient );
    $msg->setBody(    $full_body );
    
    $mailer = new Swift( new Swift_Connection_Sendmail() );
    return $mailer->send( $msg, $recipient, $sender );
  }
}
