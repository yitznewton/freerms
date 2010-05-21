<?php


/**
 * This class defines the structure of the 'eresources' table.
 *
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Fri May 21 12:09:44 2010
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class EResourceTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.EResourceTableMap';

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
		$this->setName('eresources');
		$this->setPhpName('EResource');
		$this->setClassname('EResource');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('ALT_ID', 'AltId', 'VARCHAR', false, 3, null);
		$this->addColumn('SUBSCRIPTION_NUMBER', 'SubscriptionNumber', 'VARCHAR', false, 50, null);
		$this->addColumn('TITLE', 'Title', 'VARCHAR', true, 255, null);
		$this->addColumn('SORT_TITLE', 'SortTitle', 'VARCHAR', true, 255, null);
		$this->addColumn('ALT_TITLE', 'AltTitle', 'VARCHAR', false, 255, null);
		$this->addColumn('LANGUAGE', 'Language', 'VARCHAR', true, 25, 'eng');
		$this->addColumn('DESCRIPTION', 'Description', 'LONGVARCHAR', false, null, null);
		$this->addColumn('PUBLIC_NOTE', 'PublicNote', 'LONGVARCHAR', false, null, null);
		$this->addColumn('SUPPRESSION', 'Suppression', 'BOOLEAN', true, null, false);
		$this->addColumn('PRODUCT_UNAVAILABLE', 'ProductUnavailable', 'BOOLEAN', true, null, false);
		$this->addForeignKey('ACQ_ID', 'AcqId', 'INTEGER', 'acquisitions', 'ID', false, null, null);
		$this->addForeignKey('ACCESS_INFO_ID', 'AccessInfoId', 'INTEGER', 'access_infos', 'ID', false, null, null);
		$this->addForeignKey('ADMIN_INFO_ID', 'AdminInfoId', 'INTEGER', 'admin_infos', 'ID', false, null, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', true, null, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', true, null, null);
		$this->addColumn('DELETED_AT', 'DeletedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Acquisition', 'Acquisition', RelationMap::MANY_TO_ONE, array('acq_id' => 'id', ), 'RESTRICT', 'CASCADE');
    $this->addRelation('AccessInfo', 'AccessInfo', RelationMap::MANY_TO_ONE, array('access_info_id' => 'id', ), 'RESTRICT', 'CASCADE');
    $this->addRelation('AdminInfo', 'AdminInfo', RelationMap::MANY_TO_ONE, array('admin_info_id' => 'id', ), 'RESTRICT', 'CASCADE');
    $this->addRelation('EResourceDbSubjectAssoc', 'EResourceDbSubjectAssoc', RelationMap::ONE_TO_MANY, array('id' => 'er_id', ), 'CASCADE', 'CASCADE');
    $this->addRelation('UsageAttempt', 'UsageAttempt', RelationMap::ONE_TO_MANY, array('id' => 'er_id', ), 'CASCADE', 'CASCADE');
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
			'symfony_timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', ),
		);
	} // getBehaviors()

} // EResourceTableMap
