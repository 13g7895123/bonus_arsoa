<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_eeform3_tables extends CI_Migration {

    public function up()
    {
        // 1. Create eeform3_submissions table (fixed from eeeform3_submissions)
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'member_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            ),
            'member_id' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => FALSE
            ),
            'age' => array(
                'type' => 'TINYINT',
                'constraint' => 3,
                'unsigned' => TRUE,
                'null' => FALSE
            ),
            'height' => array(
                'type' => 'SMALLINT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'null' => FALSE
            ),
            'goal' => array(
                'type' => 'TEXT',
                'null' => FALSE
            ),
            'action_plan_1' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'action_plan_2' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'created_at' => array(
                'type' => 'TIMESTAMP',
                'null' => FALSE
            ),
            'updated_at' => array(
                'type' => 'TIMESTAMP',
                'null' => TRUE
            ),
            'status' => array(
                'type' => 'ENUM("draft","submitted","reviewed")',
                'default' => 'submitted',
                'null' => FALSE
            ),
            'submission_date' => array(
                'type' => 'DATE',
                'null' => FALSE
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('member_id');
        $this->dbforge->add_key('submission_date');
        $this->dbforge->add_key('status');
        $this->dbforge->add_key('created_at');
        $this->dbforge->create_table('eeform3_submissions');

        // 2. Create eeform3_body_data table
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'submission_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => FALSE
            ),
            'weight' => array(
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => TRUE
            ),
            'blood_pressure_high' => array(
                'type' => 'SMALLINT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'null' => TRUE
            ),
            'blood_pressure_low' => array(
                'type' => 'SMALLINT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'null' => TRUE
            ),
            'waist' => array(
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => TRUE
            ),
            'measurement_time' => array(
                'type' => 'TIMESTAMP',
                'null' => FALSE
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('submission_id');
        $this->dbforge->add_key('measurement_time');
        $this->dbforge->create_table('eeform3_body_data');

        // 3. Create eeform3_activity_items table
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'item_key' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => FALSE,
                'unique' => TRUE
            ),
            'item_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            ),
            'description' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'is_active' => array(
                'type' => 'BOOLEAN',
                'default' => TRUE
            ),
            'sort_order' => array(
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
            ),
            'created_at' => array(
                'type' => 'TIMESTAMP',
                'null' => FALSE
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('item_key');
        $this->dbforge->add_key('is_active');
        $this->dbforge->add_key('sort_order');
        $this->dbforge->create_table('eeform3_activity_items');

        // 4. Create eeform3_activity_records table
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'submission_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => FALSE
            ),
            'activity_item_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => FALSE
            ),
            'is_completed' => array(
                'type' => 'BOOLEAN',
                'default' => FALSE
            ),
            'completion_time' => array(
                'type' => 'TIMESTAMP',
                'null' => TRUE
            ),
            'notes' => array(
                'type' => 'TEXT',
                'null' => TRUE
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('submission_id');
        $this->dbforge->add_key('activity_item_id');
        $this->dbforge->add_key('is_completed');
        $this->dbforge->create_table('eeform3_activity_records');

        // 5. Create eeform3_plans table
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'submission_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => FALSE
            ),
            'plan_type' => array(
                'type' => 'ENUM("plan_a","plan_b","other")',
                'null' => FALSE
            ),
            'plan_content' => array(
                'type' => 'TEXT',
                'null' => FALSE
            ),
            'priority' => array(
                'type' => 'TINYINT',
                'constraint' => 3,
                'default' => 1
            ),
            'status' => array(
                'type' => 'ENUM("pending","in_progress","completed","cancelled")',
                'default' => 'pending',
                'null' => FALSE
            ),
            'target_date' => array(
                'type' => 'DATE',
                'null' => TRUE
            ),
            'actual_completion_date' => array(
                'type' => 'DATE',
                'null' => TRUE
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('submission_id');
        $this->dbforge->add_key('plan_type');
        $this->dbforge->add_key('status');
        $this->dbforge->add_key('target_date');
        $this->dbforge->create_table('eeform3_plans');

        // Add foreign key constraints using raw SQL
        $this->db->query('ALTER TABLE eeform3_body_data ADD CONSTRAINT fk_eeform3_body_data_submission FOREIGN KEY (submission_id) REFERENCES eeform3_submissions(id) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE eeform3_activity_records ADD CONSTRAINT fk_eeform3_activity_records_submission FOREIGN KEY (submission_id) REFERENCES eeform3_submissions(id) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE eeform3_activity_records ADD CONSTRAINT fk_eeform3_activity_records_activity FOREIGN KEY (activity_item_id) REFERENCES eeform3_activity_items(id) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE eeform3_plans ADD CONSTRAINT fk_eeform3_plans_submission FOREIGN KEY (submission_id) REFERENCES eeform3_submissions(id) ON DELETE CASCADE');

        // Insert default activity items
        $activities = array(
            array('item_key' => 'hand_measure', 'item_name' => '用手測量', 'description' => '使用手部測量飲食份量', 'sort_order' => 1),
            array('item_key' => 'exercise', 'item_name' => '運動(30分)', 'description' => '每日至少30分鐘運動', 'sort_order' => 2),
            array('item_key' => 'health_supplement', 'item_name' => '保健食品', 'description' => '按時服用保健食品', 'sort_order' => 3),
            array('item_key' => 'weika', 'item_name' => '微微卡', 'description' => '微微卡產品使用', 'sort_order' => 4),
            array('item_key' => 'water_intake', 'item_name' => '飲水量', 'description' => '每日飲水量記錄', 'sort_order' => 5)
        );
        
        foreach ($activities as $activity) {
            $activity['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('eeform3_activity_items', $activity);
        }
    }

    public function down()
    {
        // Drop foreign key constraints first
        $this->db->query('ALTER TABLE eeform3_body_data DROP FOREIGN KEY fk_eeform3_body_data_submission');
        $this->db->query('ALTER TABLE eeform3_activity_records DROP FOREIGN KEY fk_eeform3_activity_records_submission');
        $this->db->query('ALTER TABLE eeform3_activity_records DROP FOREIGN KEY fk_eeform3_activity_records_activity');
        $this->db->query('ALTER TABLE eeform3_plans DROP FOREIGN KEY fk_eeform3_plans_submission');

        // Drop tables
        $this->dbforge->drop_table('eeform3_plans');
        $this->dbforge->drop_table('eeform3_activity_records');
        $this->dbforge->drop_table('eeform3_activity_items');
        $this->dbforge->drop_table('eeform3_body_data');
        $this->dbforge->drop_table('eeform3_submissions');
    }
}