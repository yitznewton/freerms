<?php


/**
 * This class defines the structure of the 'ip_ranges' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Tue Aug 17 16:51:22 2010
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class IpRangeTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.IpRangeTableMap';

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
		$this->setName('ip_ranges');
		$this->setPhpName('IpRange');
		$this->setClassname('IpRange');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('LIB_ID', 'LibId', 'INTEGER', 'libraries', 'ID', true, null, null);
		$this->addColumn('START_IP', 'StartIp', 'VARCHAR', true, 15, null);
		$this->addColumn('START_IP_INT', 'StartIpInt', 'INTEGER', true, null, null);
		$this->addColumn('END_IP', 'EndIp', 'VARCHAR', false, 15, null);
		$this->addColumn('END_IP_INT', 'EndIpInt', 'INTEGER', false, null, null);
		$this->addColumn('ACTIVE_INDICATOR', 'ActiveIndicator', 'BOOLEAN', true, null, true);
		$this->addColumn('PROXY_INDICATOR', 'ProxyIndicator', 'BOOLEAN', true, null, false);
		$this->addColumn('NOTE', 'Note', 'VARCHAR', false, 255, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', true, null, null);
		$this->addColumn('DELETED_AT', 'DeletedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Library', 'Library', RelationMap::MANY_TO_ONE, array('lib_id' => 'id', ), 'CASCADE', 'CASCADE');
    $this->addRelation('IpRegEvent', 'IpRegEvent', RelationMap::ONE_TO_MANY, array('id' => 'ip_range_id', ), 'CASCADE', 'CASCADE');
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

} // IpRangeTableMap
