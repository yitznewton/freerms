<?php

/**
 * IpRange form.
 *
 * @package    erms
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class IpRangeForm extends BaseIpRangeForm
{
  public function configure()
  {
    unset($this['updated_at']);
    $this->setWidget(
      'lib_id',
      new sfWidgetFormPropelChoice(array(
        'model' => 'Library',
        'add_empty' => false,
        'order_by' => array('Name', 'ASC')
      ))
    );
    $this['lib_id']->getWidget()->setLabel('Library');
    $this['start_ip']->getWidget()->setLabel('Starting IP');
    $this['end_ip']->getWidget()->setLabel('Ending IP');
    $this['active_indicator']->getWidget()->setLabel('Active');
    $this['proxy_indicator']->getWidget()->setLabel('Proxy');
    
    $decorator = new freermsWidgetFormatterDiv($this->widgetSchema); 
    $this->widgetSchema->addFormFormatter('div', $decorator); 
    $this->widgetSchema->setFormFormatterName('div');    
       
    $ip_pattern = '/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.';
    $ip_pattern .= '(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.';
    $ip_pattern .= '(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.';
    $ip_pattern .= '(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/';
    $this->setValidator('start_ip', new sfValidatorRegex(
      array('pattern' => $ip_pattern)));
    $this->setValidator('end_ip',new sfValidatorRegex(
      array('pattern' => $ip_pattern, 'required' => false))); 

    $this->validatorSchema->setPostValidator(
      new sfValidatorCallback(array('callback' => array($this, 'CheckIpRange')))
    );
}
  
  public function checkIpRange($validator, $values)
  {  
    if ( $values['end_ip'] && ip2long($values['end_ip']) < ip2long($values['start_ip']) ) {
      throw new sfValidatorError(
        $validator,
        'Ending IP cannot be lower than starting IP'
      );
    }
    
    if ($values['active_indicator']) {
      $c = new Criteria();
      $c->add(
        IpRangePeer::ID, $this->getObject()->getId(), Criteria::NOT_EQUAL
      );
      $c->add(IpRangePeer::ACTIVE_INDICATOR, 1);
      $active_ips = IpRangePeer::doSelect($c);    
    
      foreach ($active_ips as $aip) {   
        try {
          if (IpRangePeer::doRangesIntersect(       
            $values['start_ip'], $values['end_ip'],
            $aip->getStartIp(), $aip->getEndIp()
          )) {                        
            $conflicting_range = $aip->getStartIp();
            if ($aip->getEndIp()) {
              $conflicting_range .= ' - ' . $aip->getEndIp();
            }
            
            throw new sfValidatorError(
              $validator,
              "Range conflicts with an existing range, $conflicting_range"
            );        
          }
        } catch (ipException $e) {
          // ignore invalid-IP exception - we're handling in this function
        }
      }             
    }       
    
    return $values;
  }    
  
  public function save($con = null) 
  {
    $start = $this->values['start_ip'];
    $end   = $this->values['end_ip'];
    
    if (ip2long($start) == ip2long($end)) {
      $this->values['end_ip'] = '';
    }
    
    return parent::save($con);  
  } 
}
