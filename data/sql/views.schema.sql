DROP VIEW IF EXISTS auto_email_ip_reg_contacts;

CREATE VIEW auto_email_ip_reg_contacts AS (
  SELECT DISTINCT c.id, c.last_name, c.first_name, c.email
  FROM contacts c
  JOIN acquisitions a ON a.vendor_org_id = c.org_id
  JOIN acq_lib_assoc al ON al.acq_id = a.id
  JOIN eresources e ON a.id = e.acq_id
  JOIN libraries l ON al.lib_id = l.id
  JOIN ip_ranges ipr ON ipr.lib_id = l.id
  JOIN ip_reg_events ipre ON ipre.ip_range_id = ipr.id
  JOIN organizations o ON c.org_id = o.id
  JOIN ip_reg_methods iprm ON o.ip_reg_method_id = iprm.id
  WHERE e.deleted_at IS NULL
  AND o.ip_reg_force_manual = 0
  AND c.email IS NOT NULL
  AND iprm.label = 'email'
)
;

DROP VIEW IF EXISTS auto_email_ip_reg_events;

CREATE VIEW auto_email_ip_reg_events as (
  SELECT DISTINCT ipre.ip_range_id, ipre.old_start_ip, ipre.old_end_ip, ipre.new_start_ip, ipre.new_end_ip, c.id as contact_id  -- can/should we eliminate the c.id from this?
  FROM ip_reg_events ipre
  JOIN ip_ranges ipr ON ipre.ip_range_id = ipr.id
  JOIN libraries l ON ipr.lib_id = l.id
  JOIN acq_lib_assoc al ON al.lib_id = l.id
  JOIN acquisitions a ON al.acq_id = a.id
  JOIN organizations o ON a.vendor_org_id = o.id
  JOIN contacts c on c.org_id = o.id
  WHERE EXISTS ( SELECT * FROM auto_email_ip_reg_contacts m WHERE c.id = m.id )
)
;

DROP VIEW IF EXISTS manual_email_ip_reg_contacts;

CREATE VIEW manual_email_ip_reg_contacts AS (
  SELECT DISTINCT c.id, c.last_name, c.first_name, c.email
  FROM contacts c
  JOIN acquisitions a ON a.vendor_org_id = c.org_id
  JOIN acq_lib_assoc al ON al.acq_id = a.id
  JOIN eresources e ON a.id = e.acq_id
  JOIN libraries l ON al.lib_id = l.id
  JOIN ip_ranges ipr ON ipr.lib_id = l.id
  JOIN ip_reg_events ipre ON ipre.ip_range_id = ipr.id
  JOIN organizations o ON c.org_id = o.id
  JOIN ip_reg_methods iprm ON o.ip_reg_method_id = iprm.id
  WHERE e.deleted_at IS NULL
  AND o.ip_reg_force_manual = 1
  AND c.email IS NOT NULL
  AND iprm.label = 'email'
)
;

DROP VIEW IF EXISTS manual_email_ip_reg_events;

CREATE VIEW manual_email_ip_reg_events as (
  SELECT DISTINCT ipre.ip_range_id, ipre.old_start_ip, ipre.old_end_ip, ipre.new_start_ip, ipre.new_end_ip, c.id as contact_id  -- can/should we eliminate the c.id from this?
  FROM ip_reg_events ipre
  JOIN ip_ranges ipr ON ipre.ip_range_id = ipr.id
  JOIN libraries l ON ipr.lib_id = l.id
  JOIN acq_lib_assoc al ON al.lib_id = l.id
  JOIN acquisitions a ON al.acq_id = a.id
  JOIN organizations o ON a.vendor_org_id = o.id
  JOIN contacts c on c.org_id = o.id
  WHERE EXISTS ( SELECT * FROM manual_email_ip_reg_contacts m WHERE c.id = m.id )
  OR
)
;
