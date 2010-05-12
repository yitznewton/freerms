<?php


/**
 * This class defines the structure of the 'access_infos' table.
 *
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Wed May 12 11:53:23 2010
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class AccessInfoTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.AccessInfoTableMap';

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
		$this->setName('access_infos');
		$this->setPhpName('AccessInfo');
		$this->setClassname('AccessInfo');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('ONSITE_ACCESS_URI', 'OnsiteAccessUri', 'VARCHAR', false, 255, null);
		$this->addColumn('OFFSITE_ACCESS_URI', 'OffsiteAccessUri', 'VARCHAR', false, 255, null);
		$this->addForeignKey('ONSITE_AUTH_METHOD_ID', 'OnsiteAuthMethodId', 'INTEGER', 'auth_methods', 'ID', false, null, null);
		$this->addForeignKey('OFFSITE_AUTH_METHOD_ID', 'OffsiteAuthMethodId', 'INTEGER', 'auth_methods', 'ID', false, null, null);
		$this->addColumn('ACCESS_USERNAME', 'AccessUsername', 'VARCHAR', false, 25, null);
		$this->addColumn('ACCESS_PASSWORD', 'AccessPassword', 'VARCHAR', false, 25, null);
		$this->addColumn('ACCESS_PASSWORD_NOTE', 'AccessPasswordNote', 'LONGVARCHAR', false, null, null);
		$this->addColumn('CONCURRENT_USERS', 'ConcurrentUsers', 'INTEGER', false, null, null);
		$this->addColumn('EZPROXY_CFG_ENTRY', 'EzproxyCfgEntry', 'LONGVARCHAR', false, null, null);
		$this->addColumn('REFERRAL_NOTE', 'ReferralNote', 'LONGVARCHAR', false, null, null);
		$this->addColumn('NOTE', 'Note', 'LONGVARCHAR', false, null, null);
		$this->addColumn('DELETED_AT', 'DeletedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('AuthMethodRelatedByOnsiteAuthMethodId', 'AuthMethod', RelationMap::MANY_TO_ONE, array('onsite_auth_method_id' => 'id', ), 'SET NULL', 'CASCADE');
    $this->addRelation('AuthMethodRelatedByOffsiteAuthMethodId', 'AuthMethod', RelationMap::MANY_TO_ONE, array('offsite_auth_method_id' => 'id', ), 'SET NULL', 'CASCADE');
    $this->addRelation('EResource', 'EResource', RelationMap::ONE_TO_MANY, array('id' => 'access_info_id', ), 'RESTRICT', 'CASCADE');
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

} // AccessInfoTableMap
