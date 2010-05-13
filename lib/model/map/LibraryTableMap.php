<?php


/**
 * This class defines the structure of the 'libraries' table.
 *
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Thu May 13 10:55:28 2010
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class LibraryTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.LibraryTableMap';

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
		$this->setName('libraries');
		$this->setPhpName('Library');
		$this->setClassname('Library');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('NAME', 'Name', 'VARCHAR', true, 100, null);
		$this->addColumn('CODE', 'Code', 'VARCHAR', true, 10, null);
		$this->addColumn('ALT_NAME', 'AltName', 'VARCHAR', false, 255, null);
		$this->addColumn('ADDRESS', 'Address', 'LONGVARCHAR', false, null, null);
		$this->addColumn('EZPROXY_HOST', 'EzproxyHost', 'VARCHAR', false, 50, null);
		$this->addColumn('EZPROXY_KEY', 'EzproxyKey', 'VARCHAR', false, 50, null);
		$this->addColumn('COST_CENTER_NO', 'CostCenterNo', 'INTEGER', false, null, null);
		$this->addColumn('FTE', 'Fte', 'INTEGER', false, null, null);
		$this->addColumn('NOTE', 'Note', 'LONGVARCHAR', false, null, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('AcqLibAssoc', 'AcqLibAssoc', RelationMap::ONE_TO_MANY, array('id' => 'lib_id', ), 'CASCADE', 'CASCADE');
    $this->addRelation('IpRange', 'IpRange', RelationMap::ONE_TO_MANY, array('id' => 'lib_id', ), 'CASCADE', 'CASCADE');
    $this->addRelation('UsageAttempt', 'UsageAttempt', RelationMap::ONE_TO_MANY, array('id' => 'lib_id', ), 'SET NULL', 'CASCADE');
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

} // LibraryTableMap
