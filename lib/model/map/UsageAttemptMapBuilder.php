<?php


/**
 * This class adds structure of 'usage_attempts' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Tue Jul 21 11:41:56 2009
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class UsageAttemptMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.UsageAttemptMapBuilder';

	/**
	 * The database map.
	 */
	private $dbMap;

	/**
	 * Tells us if this DatabaseMapBuilder is built so that we
	 * don't have to re-build it every time.
	 *
	 * @return     boolean true if this DatabaseMapBuilder is built, false otherwise.
	 */
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	/**
	 * Gets the databasemap this map builder built.
	 *
	 * @return     the databasemap
	 */
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	/**
	 * The doBuild() method builds the DatabaseMap
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap(UsageAttemptPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(UsageAttemptPeer::TABLE_NAME);
		$tMap->setPhpName('UsageAttempt');
		$tMap->setClassname('UsageAttempt');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'BIGINT', true, null);

		$tMap->addForeignKey('ER_ID', 'ErId', 'INTEGER', 'eresources', 'ID', true, null);

		$tMap->addForeignKey('LIB_ID', 'LibId', 'INTEGER', 'libraries', 'ID', false, null);

		$tMap->addColumn('PHPSESSID', 'Phpsessid', 'VARCHAR', true, 32);

		$tMap->addColumn('IP', 'Ip', 'VARCHAR', false, 15);

		$tMap->addColumn('DATE', 'Date', 'TIMESTAMP', true, null);

		$tMap->addColumn('AUTH_SUCCESSFUL', 'AuthSuccessful', 'BOOLEAN', true, null);

		$tMap->addColumn('ADDITIONAL_USER_DATA', 'AdditionalUserData', 'VARCHAR', false, 255);

		$tMap->addColumn('NOTE', 'Note', 'VARCHAR', true, 255);

	} // doBuild()

} // UsageAttemptMapBuilder
