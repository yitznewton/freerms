ALTER TABLE eresources DROP FOREIGN KEY eresources_ibfk_1;
ALTER TABLE eresources DROP COLUMN admin_info_id;
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

