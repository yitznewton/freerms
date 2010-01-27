<?php


/**
 * This class defines the structure of the 'eresource_db_subject_assoc' table.
 *
 *
 * This class was autogenerated by Propel 1.4.0 on:
 *
 * Tue Dec 29 23:36:40 2009
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class EResourceDbSubjectAssocTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.EResourceDbSubjectAssocTableMap';

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
		$this->setName('eresource_db_subject_assoc');
		$this->setPhpName('EResourceDbSubjectAssoc');
		$this->setClassname('EResourceDbSubjectAssoc');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addForeignPrimaryKey('ER_ID', 'ErId', 'INTEGER' , 'eresources', 'ID', true, null, null);
		$this->addForeignPrimaryKey('DB_SUBJECT_ID', 'DbSubjectId', 'INTEGER' , 'db_subjects', 'ID', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('EResource', 'EResource', RelationMap::MANY_TO_ONE, array('er_id' => 'id', ), 'CASCADE', 'CASCADE');
    $this->addRelation('DbSubject', 'DbSubject', RelationMap::MANY_TO_ONE, array('db_subject_id' => 'id', ), 'CASCADE', 'CASCADE');
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

} // EResourceDbSubjectAssocTableMap