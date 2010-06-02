<?php


/**
 * This class defines the structure of the 'ip_reg_events' table.
 *
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Wed Jun  2 17:32:57 2010
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class IpRegEventTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.IpRegEventTableMap';

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
		$this->setName('ip_reg_events');
		$this->setPhpName('IpRegEvent');
		$this->setClassname('IpRegEvent');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addForeignPrimaryKey('IP_RANGE_ID', 'IpRangeId', 'INTEGER' , 'ip_ranges', 'ID', true, null, null);
		$this->addColumn('OLD_START_IP', 'OldStartIp', 'VARCHAR', false, 15, null);
		$this->addColumn('OLD_END_IP', 'OldEndIp', 'VARCHAR', false, 15, null);
		$this->addColumn('NEW_START_IP', 'NewStartIp', 'VARCHAR', false, 15, null);
		$this->addColumn('NEW_END_IP', 'NewEndIp', 'VARCHAR', false, 15, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('IpRange', 'IpRange', RelationMap::MANY_TO_ONE, array('ip_range_id' => 'id', ), 'CASCADE', 'CASCADE');
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
			'symfony_timestampable' => array('update_column' => 'updated_at', ),
		);
	} // getBehaviors()

} // IpRegEventTableMap
