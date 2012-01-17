<?php
require_once 'vfsStream/vfsStream.php';
require_once dirname(__FILE__).'/../../bootstrap/unit.php';

class unit_freermsAccessActionListerTest extends sfPHPUnitBaseTestCase
{
  public static function setUpBeforeClass()
  {
    $filesystem = array(
      'offsiteAccessAction.class.php' => <<<EOF
<?php
class offsiteAccessAction
{
  const IS_VALID_OFFSITE = true;
  const IS_VALID_ONSITE = false;
  const DESCRIPTION = 'Offsite';
}
EOF
,
      'onOffsiteAccessAction.class.php' => <<<EOF
<?php
class onOffsiteAccessAction
{
  const IS_VALID_OFFSITE = true;
  const IS_VALID_ONSITE = true;
  const DESCRIPTION = 'A On and offsite';
}
EOF
,
      'nonsensefile.php' => '<?php throw new Exception();',
      'otherTypeOf.class.php' => '<?php class otherTypeOf {}',
    );

    vfsStream::setup('actions', null, $filesystem);
  }

  public function testRetrieve_Offsite_RetrievesCorrectNumber()
  {
    $lister = new freermsAccessActionLister(vfsStream::url('actions'));

    $this->assertCount(2,
      $lister->retrieve(freermsAccessActionLister::OFFSITE));
  }

  public function testRetrieve_Onsite_RetrievesCorrectNumber()
  {
    $lister = new freermsAccessActionLister(vfsStream::url('actions'));

    $this->assertCount(1,
      $lister->retrieve(freermsAccessActionLister::ONSITE));
  }

  public function testRetrieve_Sorts()
  {
    $lister  = new freermsAccessActionLister(vfsStream::url('actions'));
    $actions = $lister->retrieve(freermsAccessActionLister::ONSITE);
    $keys    = array_keys($actions);

    $this->assertEquals('onOffsiteAccessAction', $keys[0]);
  }
}

