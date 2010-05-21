<?php


/**
 * This class defines the structure of the 'admin_infos' table.
 *
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Fri May 21 11:06:41 2010
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class AdminInfoTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.AdminInfoTableMap';

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
		$this->setName('admin_infos');
		$this->setPhpName('AdminInfo');
		$this->setClassname('AdminInfo');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('UI_CONFIG_AVAILABLE', 'UiConfigAvailable', 'BOOLEAN', false, null, null);
		$this->addColumn('SUBSCRIBER_BRANDING_AVAILABLE', 'SubscriberBrandingAvailable', 'BOOLEAN', false, null, null);
		$this->addColumn('SUBSCRIBER_BRANDING_NOTE', 'SubscriberBrandingNote', 'LONGVARCHAR', false, null, null);
		$this->addColumn('PERSONALIZED_FEATURES_AVAILABLE', 'PersonalizedFeaturesAvailable', 'BOOLEAN', false, null, null);
		$this->addColumn('INBOUND_LINKING_AVAILABLE', 'InboundLinkingAvailable', 'BOOLEAN', false, null, null);
		$this->addColumn('OPEN_URL_COMPLIANCE_AVAILABLE', 'OpenUrlComplianceAvailable', 'BOOLEAN', false, null, null);
		$this->addColumn('LINKING_NOTE', 'LinkingNote', 'LONGVARCHAR', false, null, null);
		$this->addColumn('MARC_RECORDS_AVAILABLE', 'MarcRecordsAvailable', 'BOOLEAN', false, null, null);
		$this->addColumn('MARC_RECORD_NOTE', 'MarcRecordNote', 'LONGVARCHAR', false, null, null);
		$this->addColumn('SS_360_SEARCH_AVAILABLE', 'Ss360SearchAvailable', 'BOOLEAN', false, null, null);
		$this->addColumn('USAGE_STATS_AVAILABLE', 'UsageStatsAvailable', 'BOOLEAN', false, null, null);
		$this->addColumn('USAGE_STATS_STANDARDS_COMPLIANCE', 'UsageStatsStandardsCompliance', 'VARCHAR', false, 50, null);
		$this->addForeignKey('USAGE_STATS_DELIVERY_ID', 'UsageStatsDeliveryId', 'INTEGER', 'info_exchange_methods', 'ID', false, null, null);
		$this->addForeignKey('USAGE_STATS_FORMAT_ID', 'UsageStatsFormatId', 'INTEGER', 'usage_stats_formats', 'ID', false, null, null);
		$this->addForeignKey('USAGE_STATS_FREQ_ID', 'UsageStatsFreqId', 'INTEGER', 'usage_stats_freqs', 'ID', false, null, null);
		$this->addColumn('USAGE_STATS_URI', 'UsageStatsUri', 'VARCHAR', false, 255, null);
		$this->addColumn('USAGE_STATS_USERNAME', 'UsageStatsUsername', 'VARCHAR', false, 25, null);
		$this->addColumn('USAGE_STATS_PASSWORD', 'UsageStatsPassword', 'VARCHAR', false, 25, null);
		$this->addColumn('USAGE_STATS_NOTE', 'UsageStatsNote', 'LONGVARCHAR', false, null, null);
		$this->addColumn('SOFTWARE_REQUIREMENTS', 'SoftwareRequirements', 'LONGVARCHAR', false, null, null);
		$this->addColumn('SYSTEM_STATUS_URI', 'SystemStatusUri', 'VARCHAR', false, 255, null);
		$this->addColumn('PRODUCT_ADVISORY_NOTE', 'ProductAdvisoryNote', 'LONGVARCHAR', false, null, null);
		$this->addColumn('TRAINING_INFO', 'TrainingInfo', 'LONGVARCHAR', false, null, null);
		$this->addColumn('ADMIN_DOC_URI', 'AdminDocUri', 'VARCHAR', false, 255, null);
		$this->addColumn('USER_DOC_URI', 'UserDocUri', 'VARCHAR', false, 255, null);
		$this->addColumn('NOTE', 'Note', 'LONGVARCHAR', false, null, null);
		$this->addColumn('DELETED_AT', 'DeletedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('InfoExchangeMethod', 'InfoExchangeMethod', RelationMap::MANY_TO_ONE, array('usage_stats_delivery_id' => 'id', ), 'SET NULL', 'CASCADE');
    $this->addRelation('UsageStatsFormat', 'UsageStatsFormat', RelationMap::MANY_TO_ONE, array('usage_stats_format_id' => 'id', ), 'SET NULL', 'CASCADE');
    $this->addRelation('UsageStatsFreq', 'UsageStatsFreq', RelationMap::MANY_TO_ONE, array('usage_stats_freq_id' => 'id', ), 'SET NULL', 'CASCADE');
    $this->addRelation('EResource', 'EResource', RelationMap::ONE_TO_MANY, array('id' => 'admin_info_id', ), 'RESTRICT', 'CASCADE');
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

} // AdminInfoTableMap
