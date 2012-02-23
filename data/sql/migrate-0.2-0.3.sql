ALTER TABLE eresources DROP FOREIGN KEY eresources_ibfk_1;
ALTER TABLE eresources DROP COLUMN admin_info_id;
ALTER TABLE eresources DROP COLUMN alt_title;
ALTER TABLE eresources DROP COLUMN `language`;
ALTER TABLE eresources DROP COLUMN subscription_number;
ALTER TABLE access_infos DROP FOREIGN KEY access_infos_FK_1;
ALTER TABLE access_infos DROP FOREIGN KEY access_infos_FK_2;
ALTER TABLE access_infos DROP COLUMN onsite_auth_method_id;
ALTER TABLE access_infos DROP COLUMN offsite_auth_method_id;

DROP TABLE IF EXISTS admin_infos;
DROP TABLE IF EXISTS contact_emails;
DROP TABLE IF EXISTS contact_phones;
DROP TABLE IF EXISTS contacts;
DROP TABLE IF EXISTS general_statuses;
DROP TABLE IF EXISTS info_exchange_methods;
DROP TABLE IF EXISTS organizations;
DROP TABLE IF EXISTS ip_reg_methods;
DROP TABLE IF EXISTS ip_reg_events;
DROP TABLE IF EXISTS usage_stats_formats;
DROP TABLE IF EXISTS usage_stats_freqs;
DROP TABLE IF EXISTS auth_methods;
DROP TABLE IF EXISTS library;
DROP TABLE IF EXISTS admin_infos;

ALTER TABLE libraries RENAME library;
ALTER TABLE ip_ranges RENAME ip_range;
ALTER TABLE usage_attempts RENAME database_usage;
ALTER TABLE eresources RENAME freerms_database;
ALTER TABLE db_subjects RENAME subject;
ALTER TABLE eresource_db_subject_assoc RENAME database_subject;

ALTER TABLE database_usage DROP COLUMN ip;
ALTER TABLE database_usage DROP COLUMN note;
ALTER TABLE database_usage DROP FOREIGN KEY usage_attempts_FK_1;
ALTER TABLE database_usage DROP FOREIGN KEY usage_attempts_FK_2;
ALTER TABLE database_usage DROP KEY usage_attempts_FI_1;
ALTER TABLE database_usage DROP KEY usage_attempts_FI_2;
ALTER TABLE database_usage CHANGE COLUMN er_id database_id INT NOT NULL;
ALTER TABLE database_usage CHANGE COLUMN lib_id library_id INT NOT NULL;
ALTER TABLE database_usage CHANGE COLUMN phpsessid sessionid VARCHAR(8) NOT NULL;
ALTER TABLE database_usage CHANGE COLUMN `date` timestamp DATETIME NOT NULL;
ALTER TABLE database_usage MODIFY COLUMN is_onsite TINYINT(1) NOT NULL;
DELETE FROM database_usage WHERE auth_successful != 1;
ALTER TABLE database_usage DROP COLUMN auth_successful;
ALTER TABLE database_usage CHANGE COLUMN additional_user_data additional_data VARCHAR(255) DEFAULT NULL;
ALTER TABLE database_usage MODIFY COLUMN id INT;
ALTER TABLE database_usage DROP PRIMARY KEY;
ALTER TABLE database_usage DROP COLUMN id;
ALTER TABLE database_usage ADD PRIMARY KEY (database_id, sessionid);
ALTER TABLE database_usage ADD FOREIGN KEY (library_id) REFERENCES library (id);
ALTER TABLE database_usage ADD FOREIGN KEY (database_id) REFERENCES freerms_database (id);

CREATE TABLE url_usage (sessionid VARCHAR(8),
 library_id INTEGER NOT NULL,
 timestamp DATETIME NOT NULL,
 is_onsite TINYINT(1) NOT NULL,
 additional_data VARCHAR(255),
 host VARCHAR(255),
 PRIMARY KEY(sessionid,
 host));

CREATE TABLE `usage` (sessionid VARCHAR(8),
 library_id BIGINT NOT NULL,
 timestamp DATETIME NOT NULL,
 is_onsite TINYINT(1) NOT NULL,
 additional_data VARCHAR(255),
 PRIMARY KEY(sessionid)) ENGINE = INNODB;

ALTER TABLE ip_range DROP COLUMN updated_at;
ALTER TABLE ip_range DROP COLUMN deleted_at;
ALTER TABLE ip_range DROP COLUMN start_ip_int;
ALTER TABLE ip_range DROP COLUMN end_ip_int;
ALTER TABLE ip_range MODIFY COLUMN note LONGTEXT;
ALTER TABLE ip_range CHANGE COLUMN active_indicator is_active TINYINT(1) NOT NULL DEFAULT 1;
ALTER TABLE ip_range DROP FOREIGN KEY ip_ranges_FK_1;
ALTER TABLE ip_range DROP KEY ip_ranges_FI_1;
ALTER TABLE ip_range CHANGE COLUMN lib_id library_id INT(11) NOT NULL;
ALTER TABLE ip_range ADD FOREIGN KEY (library_id) REFERENCES library (id);
ALTER TABLE ip_range ADD COLUMN is_excluded TINYINT(1) NOT NULL DEFAULT 0;
ALTER TABLE ip_range ADD COLUMN start_ip_sort VARCHAR(12) NOT NULL;
ALTER TABLE ip_range ADD COLUMN end_ip_sort VARCHAR(12) NOT NULL;

ALTER TABLE library DROP COLUMN alt_name;
ALTER TABLE library DROP COLUMN address; 
ALTER TABLE library DROP COLUMN cost_center_no;
ALTER TABLE library DROP COLUMN fte;
ALTER TABLE library ADD COLUMN ezproxy_algorithm VARCHAR(255);
ALTER TABLE library ADD COLUMN created_at DATETIME NOT NULL;
ALTER TABLE library ADD COLUMN deleted_at DATETIME;
ALTER TABLE library CHANGE COLUMN show_featured_subjects show_featured TINYINT(1) NOT NULL DEFAULT 1;
ALTER TABLE library MODIFY COLUMN name VARCHAR(255) NOT NULL;
ALTER TABLE library MODIFY COLUMN ezproxy_host VARCHAR(255);
ALTER TABLE library MODIFY COLUMN ezproxy_key VARCHAR(255);

ALTER TABLE subject CHANGE COLUMN label name VARCHAR(255) NOT NULL;
ALTER TABLE subject MODIFY COLUMN slug VARCHAR(255);

ALTER TABLE freerms_database MODIFY COLUMN featured_weight INT NOT NULL DEFAULT 999;
ALTER TABLE freerms_database MODIFY COLUMN alt_id VARCHAR(10);
ALTER TABLE freerms_database CHANGE COLUMN suppression is_hidden TINYINT(1) NOT NULL DEFAULT 0;
ALTER TABLE freerms_database CHANGE COLUMN product_unavailable is_unavailable TINYINT(1) NOT NULL DEFAULT 0;
ALTER TABLE freerms_database ADD COLUMN access_action_onsite VARCHAR(255) DEFAULT 'baseAccess' NOT NULL;
ALTER TABLE freerms_database ADD COLUMN access_action_offsite VARCHAR(255) DEFAULT 'baseAccess' NOT NULL;
ALTER TABLE freerms_database ADD COLUMN access_url VARCHAR(255) NOT NULL;
ALTER TABLE freerms_database ADD COLUMN referral_note LONGTEXT;
ALTER TABLE freerms_database ADD COLUMN access_control VARCHAR(255);
ALTER TABLE freerms_database ADD COLUMN additional_fields LONGTEXT;
ALTER TABLE freerms_database ADD COLUMN note LONGTEXT;
ALTER TABLE freerms_database DROP FOREIGN KEY eresources_FK_1;
ALTER TABLE freerms_database DROP KEY eresources_FI_1;
ALTER TABLE freerms_database DROP FOREIGN KEY eresources_FK_2;
ALTER TABLE freerms_database DROP KEY eresources_FI_2;

UPDATE freerms_database d JOIN access_infos a ON d.access_info_id=a.id
 SET d.access_url=a.onsite_access_uri,
 d.referral_note=a.referral_note,
 d.note=CONCAT(d.note, a.note),
 d.access_action_onsite=REPLACE(a.onsite_access_handler, 'Handler', ''),
 d.access_action_offsite=REPLACE(a.offsite_access_handler, 'Handler', '');

UPDATE freerms_database SET access_action_onsite =
 CONCAT(LOWER(SUBSTR(access_action_onsite, 1, 1)), SUBSTR(access_action_onsite, 2));
UPDATE freerms_database SET access_action_offsite =
 CONCAT(LOWER(SUBSTR(access_action_offsite, 1, 1)), SUBSTR(access_action_offsite, 2));

UPDATE freerms_database SET access_info_id = NULL;
DROP TABLE access_infos;

ALTER TABLE acq_lib_assoc DROP FOREIGN KEY acq_lib_assoc_FK_1;
ALTER TABLE acq_lib_assoc DROP FOREIGN KEY acq_lib_assoc_FK_2;
ALTER TABLE acq_lib_assoc DROP KEY acq_lib_assoc_FI_2;
ALTER TABLE acq_lib_assoc DROP PRIMARY KEY;
ALTER TABLE acq_lib_assoc RENAME database_library;
ALTER TABLE database_library ADD COLUMN database_id INT NOT NULL;
ALTER TABLE database_library CHANGE COLUMN lib_id library_id INT(11) NOT NULL;
UPDATE database_library dl JOIN freerms_database d ON d.acq_id=dl.acq_id SET dl.database_id=d.id;
ALTER TABLE database_library DROP COLUMN acq_id;
ALTER TABLE database_library ADD FOREIGN KEY (library_id) REFERENCES library (id);
-- make sure this isn't deleting too much
DELETE FROM database_library WHERE database_id=0;
ALTER TABLE database_library ADD FOREIGN KEY (database_id) REFERENCES freerms_database (id);
ALTER TABLE database_library ADD PRIMARY KEY (library_id, database_id);

DROP TABLE acquisitions;

ALTER TABLE freerms_database DROP COLUMN acq_id;
ALTER TABLE freerms_database DROP COLUMN access_info_id;

ALTER TABLE database_subject DROP FOREIGN KEY eresource_db_subject_assoc_FK_1;
ALTER TABLE database_subject DROP FOREIGN KEY eresource_db_subject_assoc_FK_2;
ALTER TABLE database_subject DROP KEY eresource_db_subject_assoc_FI_2;
ALTER TABLE database_subject DROP PRIMARY KEY;
ALTER TABLE database_subject CHANGE COLUMN er_id database_id INT NOT NULL;
ALTER TABLE database_subject CHANGE COLUMN db_subject_id subject_id INT NOT NULL;
ALTER TABLE database_subject ADD PRIMARY KEY (database_id, subject_id);
ALTER TABLE database_subject ADD FOREIGN KEY (database_id) REFERENCES freerms_database (id);
ALTER TABLE database_subject ADD FOREIGN KEY (subject_id) REFERENCES subject (id);

