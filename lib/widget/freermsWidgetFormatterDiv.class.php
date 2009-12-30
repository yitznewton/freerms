<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * 
 *
 * @package    symfony
 * @subpackage widget
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfWidgetFormSchemaFormatterList.class.php 5995 2007-11-13 15:50:03Z fabien $
 */
class freermsWidgetFormatterDiv extends sfWidgetFormSchemaFormatter
{
  protected
    $rowFormat       = "<div class=\"form-row\">\n  %error%%label%\n  %field%%help%\n%hidden_fields%</div>\n",
    $errorRowFormat  = "<div>\n%errors%</div>\n",       
    $errorListFormatInARow = "%errors%", 
    $errorRowFormatInARow = '<div class="ui-widget"><div class="ui-state-error ui-corner-all"><p><span class="ui-icon ui-icon-alert"></span><strong>Error: </strong>%error%<p></div></div>',    
    $helpFormat      = '<br />%help%',
    $decoratorFormat = '%content%';
}
