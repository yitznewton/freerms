<?php


/**
 * This class defines the structure of the 'usage_attempts' table.
 *
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Tue May 11 17:37:55 2010
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class UsageAttemptTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.UsageAttemptTableMap';

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
		$this->setName('usage_attempts');
		$this->setPhpName('UsageAttempt');
		$this->setClassname('UsageAttempt');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'BIGINT', true, null, null);
		$this->addForeignKey('ER_ID', 'ErId', 'INTEGER', 'eresources', 'ID', true, null, null);
		$this->addForeignKey('LIB_ID', 'LibId', 'INTEGER', 'libraries', 'ID', false, null, null);
		$this->addColumn('PHPSESSID', 'Phpsessid', 'VARCHAR', true, 32, null);
		$this->addColumn('IP', 'Ip', 'VARCHAR', false, 15, null);
		$this->addColumn('DATE', 'Date', 'TIMESTAMP', true, null, null);
		$this->addColumn('AUTH_SUCCESSFUL', 'AuthSuccessful', 'BOOLEAN', true, null, null);
		$this->addColumn('ADDITIONAL_USER_DATA', 'AdditionalUserData', 'VARCHAR', false, 255, null);
		$this->addColumn('NOTE', 'Note', 'VARCHAR', true, 255, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('EResource', 'EResource', RelationMap::MANY_TO_ONE, array('er_id' => 'id', ), 'CASCADE', 'CASCADE');
    $this->addRelation('Library', 'Library', RelationMap::MANY_TO_ONE, array('lib_id' => 'id', ), 'SET NULL', 'CASCADE');
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

} // UsageAttemptTableMap
