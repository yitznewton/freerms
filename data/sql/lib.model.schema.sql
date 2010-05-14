
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- access_infos
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `access_infos`;


CREATE TABLE `access_infos`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`onsite_access_uri` VARCHAR(255),
	`offsite_access_uri` VARCHAR(255),
	`onsite_auth_method_id` INTEGER,
	`offsite_auth_method_id` INTEGER,
	`access_username` VARCHAR(25),
	`access_password` VARCHAR(25),
	`access_password_note` TEXT,
	`concurrent_users` INTEGER,
	`ezproxy_cfg_entry` TEXT,
	`referral_note` TEXT,
	`note` TEXT,
	`deleted_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `access_infos_FI_1` (`onsite_auth_method_id`),
	CONSTRAINT `access_infos_FK_1`
		FOREIGN KEY (`onsite_auth_method_id`)
		REFERENCES `auth_methods` (`id`)
		ON UPDATE CASCADE
		ON DELETE SET NULL,
	INDEX `access_infos_FI_2` (`offsite_auth_method_id`),
	CONSTRAINT `access_infos_FK_2`
		FOREIGN KEY (`offsite_auth_method_id`)
		REFERENCES `auth_methods` (`id`)
		ON UPDATE CASCADE
		ON DELETE SET NULL
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- acq_lib_assoc
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `acq_lib_assoc`;


CREATE TABLE `acq_lib_assoc`
(
	`lib_id` INTEGER  NOT NULL,
	`acq_id` INTEGER  NOT NULL,
	PRIMARY KEY (`lib_id`,`acq_id`),
	CONSTRAINT `acq_lib_assoc_FK_1`
		FOREIGN KEY (`lib_id`)
		REFERENCES `libraries` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	INDEX `acq_lib_assoc_FI_2` (`acq_id`),
	CONSTRAINT `acq_lib_assoc_FK_2`
		FOREIGN KEY (`acq_id`)
		REFERENCES `acquisitions` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- acquisitions
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `acquisitions`;


CREATE TABLE `acquisitions`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`note` TEXT,
	`vendor_org_id` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `acquisitions_FI_1` (`vendor_org_id`),
	CONSTRAINT `acquisitions_FK_1`
		FOREIGN KEY (`vendor_org_id`)
		REFERENCES `organizations` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- admin_infos
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `admin_infos`;


CREATE TABLE `admin_infos`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`ui_config_available` TINYINT,
	`subscriber_branding_available` TINYINT,
	`subscriber_branding_note` TEXT,
	`personalized_features_available` TINYINT,
	`inbound_linking_available` TINYINT,
	`open_url_compliance_available` TINYINT,
	`linking_note` TEXT,
	`marc_records_available` TINYINT,
	`marc_record_note` TEXT,
	`ss_360_search_available` TINYINT,
	`usage_stats_available` TINYINT,
	`usage_stats_standards_compliance` VARCHAR(50),
	`usage_stats_delivery_id` INTEGER,
	`usage_stats_format_id` INTEGER,
	`usage_stats_freq_id` INTEGER,
	`usage_stats_uri` VARCHAR(255),
	`usage_stats_username` VARCHAR(25),
	`usage_stats_password` VARCHAR(25),
	`usage_stats_note` TEXT,
	`software_requirements` TEXT,
	`system_status_uri` VARCHAR(255),
	`product_advisory_note` TEXT,
	`training_info` TEXT,
	`admin_doc_uri` VARCHAR(255),
	`user_doc_uri` VARCHAR(255),
	`note` TEXT,
	`deleted_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `admin_infos_FI_1` (`usage_stats_delivery_id`),
	CONSTRAINT `admin_infos_FK_1`
		FOREIGN KEY (`usage_stats_delivery_id`)
		REFERENCES `info_exchange_methods` (`id`)
		ON UPDATE CASCADE
		ON DELETE SET NULL,
	INDEX `admin_infos_FI_2` (`usage_stats_format_id`),
	CONSTRAINT `admin_infos_FK_2`
		FOREIGN KEY (`usage_stats_format_id`)
		REFERENCES `usage_stats_formats` (`id`)
		ON UPDATE CASCADE
		ON DELETE SET NULL,
	INDEX `admin_infos_FI_3` (`usage_stats_freq_id`),
	CONSTRAINT `admin_infos_FK_3`
		FOREIGN KEY (`usage_stats_freq_id`)
		REFERENCES `usage_stats_freqs` (`id`)
		ON UPDATE CASCADE
		ON DELETE SET NULL
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- auth_methods
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `auth_methods`;


CREATE TABLE `auth_methods`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`label` VARCHAR(50)  NOT NULL,
	`is_valid_onsite` TINYINT default 1 NOT NULL,
	`is_valid_offsite` TINYINT default 1 NOT NULL,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- contacts
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `contacts`;


CREATE TABLE `contacts`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`last_name` VARCHAR(50),
	`first_name` VARCHAR(50),
	`title` VARCHAR(50),
	`role` VARCHAR(255),
	`address` TEXT,
	`email` VARCHAR(100),
	`phone` VARCHAR(40),
	`fax` VARCHAR(40),
	`note` TEXT,
	`org_id` INTEGER,
	`updated_at` DATETIME  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `contacts_FI_1` (`org_id`),
	CONSTRAINT `contacts_FK_1`
		FOREIGN KEY (`org_id`)
		REFERENCES `organizations` (`id`)
		ON UPDATE CASCADE
		ON DELETE SET NULL
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- eresources
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `eresources`;


CREATE TABLE `eresources`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`alt_id` VARCHAR(3),
	`subscription_number` VARCHAR(50),
	`title` VARCHAR(255)  NOT NULL,
	`sort_title` VARCHAR(255)  NOT NULL,
	`alt_title` VARCHAR(255),
	`language` VARCHAR(25) default 'eng' NOT NULL,
	`description` TEXT,
	`public_note` TEXT,
	`suppression` TINYINT default 0 NOT NULL,
	`product_unavailable` TINYINT default 0 NOT NULL,
	`acq_id` INTEGER,
	`access_info_id` INTEGER,
	`admin_info_id` INTEGER,
	`created_at` DATETIME  NOT NULL,
	`updated_at` DATETIME  NOT NULL,
	`deleted_at` DATETIME,
	PRIMARY KEY (`id`),
	UNIQUE KEY `eresources_U_1` (`alt_id`),
	INDEX `eresources_FI_1` (`acq_id`),
	CONSTRAINT `eresources_FK_1`
		FOREIGN KEY (`acq_id`)
		REFERENCES `acquisitions` (`id`)
		ON UPDATE CASCADE
		ON DELETE RESTRICT,
	INDEX `eresources_FI_2` (`access_info_id`),
	CONSTRAINT `eresources_FK_2`
		FOREIGN KEY (`access_info_id`)
		REFERENCES `access_infos` (`id`)
		ON UPDATE CASCADE
		ON DELETE RESTRICT,
	INDEX `eresources_FI_3` (`admin_info_id`),
	CONSTRAINT `eresources_FK_3`
		FOREIGN KEY (`admin_info_id`)
		REFERENCES `admin_infos` (`id`)
		ON UPDATE CASCADE
		ON DELETE RESTRICT
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- eresource_db_subject_assoc
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `eresource_db_subject_assoc`;


CREATE TABLE `eresource_db_subject_assoc`
(
	`er_id` INTEGER  NOT NULL,
	`db_subject_id` INTEGER  NOT NULL,
	PRIMARY KEY (`er_id`,`db_subject_id`),
	CONSTRAINT `eresource_db_subject_assoc_FK_1`
		FOREIGN KEY (`er_id`)
		REFERENCES `eresources` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	INDEX `eresource_db_subject_assoc_FI_2` (`db_subject_id`),
	CONSTRAINT `eresource_db_subject_assoc_FK_2`
		FOREIGN KEY (`db_subject_id`)
		REFERENCES `db_subjects` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- db_subjects
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `db_subjects`;


CREATE TABLE `db_subjects`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`label` VARCHAR(100)  NOT NULL,
	`slug` VARCHAR(100),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- general_statuses
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `general_statuses`;


CREATE TABLE `general_statuses`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`label` VARCHAR(25)  NOT NULL,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- info_exchange_methods
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `info_exchange_methods`;


CREATE TABLE `info_exchange_methods`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`label` VARCHAR(25)  NOT NULL,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- ip_reg_methods
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ip_reg_methods`;


CREATE TABLE `ip_reg_methods`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`label` VARCHAR(25)  NOT NULL,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- ip_ranges
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ip_ranges`;


CREATE TABLE `ip_ranges`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`lib_id` INTEGER  NOT NULL,
	`start_ip` VARCHAR(15)  NOT NULL,
	`end_ip` VARCHAR(15),
	`active_indicator` TINYINT default 1 NOT NULL,
	`proxy_indicator` TINYINT default 0 NOT NULL,
	`note` VARCHAR(255),
	`updated_at` DATETIME  NOT NULL,
	`deleted_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `ip_ranges_FI_1` (`lib_id`),
	CONSTRAINT `ip_ranges_FK_1`
		FOREIGN KEY (`lib_id`)
		REFERENCES `libraries` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- ip_reg_events
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ip_reg_events`;


CREATE TABLE `ip_reg_events`
(
	`ip_range_id` INTEGER  NOT NULL,
	`old_start_ip` VARCHAR(15),
	`old_end_ip` VARCHAR(15),
	`new_start_ip` VARCHAR(15),
	`new_end_ip` VARCHAR(15),
	`updated_at` DATETIME  NOT NULL,
	PRIMARY KEY (`ip_range_id`),
	CONSTRAINT `ip_reg_events_FK_1`
		FOREIGN KEY (`ip_range_id`)
		REFERENCES `ip_ranges` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- libraries
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `libraries`;


CREATE TABLE `libraries`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(100)  NOT NULL,
	`code` VARCHAR(10)  NOT NULL,
	`alt_name` VARCHAR(255),
	`address` TEXT,
	`ezproxy_host` VARCHAR(50),
	`ezproxy_key` VARCHAR(50),
	`cost_center_no` INTEGER,
	`fte` INTEGER,
	`note` TEXT,
	`updated_at` DATETIME  NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `libraries_U_1` (`code`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- organizations
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `organizations`;


CREATE TABLE `organizations`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255)  NOT NULL,
	`alt_name` VARCHAR(255),
	`account_number` VARCHAR(40),
	`address` TEXT,
	`phone` VARCHAR(40),
	`fax` VARCHAR(40),
	`notice_address_licensor` TEXT,
	`ip_reg_method_id` INTEGER,
	`ip_reg_uri` VARCHAR(255),
	`ip_reg_username` VARCHAR(50),
	`ip_reg_password` VARCHAR(50),
	`ip_reg_contact_id` INTEGER,
	`ip_reg_force_manual` TINYINT,
	`note` TEXT,
	`updated_at` DATETIME  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `organizations_FI_1` (`ip_reg_method_id`),
	CONSTRAINT `organizations_FK_1`
		FOREIGN KEY (`ip_reg_method_id`)
		REFERENCES `ip_reg_methods` (`id`)
		ON UPDATE CASCADE
		ON DELETE SET NULL,
	INDEX `organizations_FI_2` (`ip_reg_contact_id`),
	CONSTRAINT `organizations_FK_2`
		FOREIGN KEY (`ip_reg_contact_id`)
		REFERENCES `contacts` (`id`)
		ON UPDATE CASCADE
		ON DELETE SET NULL
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- usage_attempts
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `usage_attempts`;


CREATE TABLE `usage_attempts`
(
	`id` BIGINT  NOT NULL AUTO_INCREMENT,
	`er_id` INTEGER  NOT NULL,
	`lib_id` INTEGER,
	`phpsessid` VARCHAR(32)  NOT NULL,
	`ip` VARCHAR(15),
	`date` DATETIME  NOT NULL,
	`auth_successful` TINYINT  NOT NULL,
	`additional_user_data` VARCHAR(255),
	`note` VARCHAR(255)  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `usage_attempts_FI_1` (`er_id`),
	CONSTRAINT `usage_attempts_FK_1`
		FOREIGN KEY (`er_id`)
		REFERENCES `eresources` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	INDEX `usage_attempts_FI_2` (`lib_id`),
	CONSTRAINT `usage_attempts_FK_2`
		FOREIGN KEY (`lib_id`)
		REFERENCES `libraries` (`id`)
		ON UPDATE CASCADE
		ON DELETE SET NULL
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- usage_stats_formats
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `usage_stats_formats`;


CREATE TABLE `usage_stats_formats`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`label` VARCHAR(10)  NOT NULL,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- usage_stats_freqs
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `usage_stats_freqs`;


CREATE TABLE `usage_stats_freqs`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`label` VARCHAR(25)  NOT NULL,
	PRIMARY KEY (`id`)
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
