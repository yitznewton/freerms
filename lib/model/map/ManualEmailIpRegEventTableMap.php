<?php


/**
 * This class defines the structure of the 'manual_email_ip_reg_events' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 06/04/10 10:21:47
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class ManualEmailIpRegEventTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.ManualEmailIpRegEventTableMap';

	/**
	 * Initialize the table attributes, columns and validators
	 * Relations are not initialized by this method since they are lazy loaded
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function initialize()
	{
	  // attributes
		$this->setName('manual_email_ip_reg_events');
		$this->setPhpName('ManualEmailIpRegEvent');
		$this->setClassname('ManualEmailIpRegEvent');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addForeignPrimaryKey('IP_RANGE_ID', 'IpRangeId', 'INTEGER' , 'ip_ranges', 'ID', true, null, null);
		$this->addColumn('OLD_START_IP', 'OldStartIp', 'VARCHAR', false, 15, null);
		$this->addColumn('OLD_END_IP', 'OldEndIp', 'VARCHAR', false, 15, null);
		$this->addColumn('NEW_START_IP', 'NewStartIp', 'VARCHAR', false, 15, null);
		$this->addColumn('NEW_END_IP', 'NewEndIp', 'VARCHAR', false, 15, null);
		$this->addForeignPrimaryKey('CONTACT_ID', 'ContactId', 'INTEGER' , 'contacts', 'ID', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('IpRange', 'IpRange', RelationMap::MANY_TO_ONE, array('ip_range_id' => 'id', ), null, null);
    $this->addRelation('Contact', 'Contact', RelationMap::MANY_TO_ONE, array('contact_id' => 'id', ), null, null);
	} // buildRelations()

	/**
	 * 
	 * Gets the list of behaviors registered for this table
	 * 
	 * @return array Associative array (name => parameters) of behaviors
	 */
	public function getBehaviors()
	{
		return array(
			'symfony' => array('form' => 'true', 'filter' => 'true', ),
			'symfony_behaviors' => array(),
		);
	} // getBehaviors()

} // ManualEmailIpRegEventTableMap
