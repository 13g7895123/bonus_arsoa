<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_eeform5_tables extends CI_Migration {

    public function up()
    {
        // 1. Create eeform5_submissions table
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
            'birth_year' => array(
                'type' => 'SMALLINT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'null' => FALSE
            ),
            'birth_month' => array(
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
            'has_medication_habit' => array(
                'type' => 'BOOLEAN',
                'default' => FALSE
            ),
            'medication_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ),
            'has_family_disease_history' => array(
                'type' => 'BOOLEAN',
                'default' => FALSE
            ),
            'disease_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ),
            'microcirculation_test' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'dietary_advice' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'submission_date' => array(
                'type' => 'DATE',
                'null' => FALSE
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
                'type' => 'ENUM("draft","submitted","reviewed","completed")',
                'default' => 'submitted',
                'null' => FALSE
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('member_name');
        $this->dbforge->add_key(array('birth_year', 'birth_month'));
        $this->dbforge->add_key('submission_date');
        $this->dbforge->add_key('status');
        $this->dbforge->add_key('created_at');
        $this->dbforge->create_table('eeform5_submissions');

        // 2. Create eeform5_occupations table
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
            'occupation_type' => array(
                'type' => 'ENUM("service","office","restaurant","freelance","other")',
                'null' => FALSE
            ),
            'occupation_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('submission_id');
        $this->dbforge->add_key('occupation_type');
        $this->dbforge->create_table('eeform5_occupations');

        // 3. Create eeform5_health_issues table
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
            'issue_code' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => FALSE
            ),
            'issue_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            ),
            'other_description' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ),
            'severity' => array(
                'type' => 'ENUM("mild","moderate","severe")',
                'null' => TRUE
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('submission_id');
        $this->dbforge->add_key('issue_code');
        $this->dbforge->create_table('eeform5_health_issues');

        // 4. Create eeform5_health_issues_master table
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'issue_code' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => FALSE,
                'unique' => TRUE
            ),
            'issue_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            ),
            'issue_category' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => TRUE
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
        $this->dbforge->add_key('issue_code');
        $this->dbforge->add_key('issue_category');
        $this->dbforge->add_key('is_active');
        $this->dbforge->add_key('sort_order');
        $this->dbforge->create_table('eeform5_health_issues_master');

        // 5. Create eeform5_product_recommendations table
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
            'product_code' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => FALSE
            ),
            'product_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            ),
            'recommended_dosage' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE
            ),
            'usage_timing' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE
            ),
            'notes' => array(
                'type' => 'TEXT',
                'null' => TRUE
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('submission_id');
        $this->dbforge->add_key('product_code');
        $this->dbforge->create_table('eeform5_product_recommendations');

        // 6. Create eeform5_product_master table
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'product_code' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => FALSE,
                'unique' => TRUE
            ),
            'product_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            ),
            'product_type' => array(
                'type' => 'ENUM("supplement","tea","other")',
                'default' => 'supplement',
                'null' => FALSE
            ),
            'default_dosage' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE
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
        $this->dbforge->add_key('product_code');
        $this->dbforge->add_key('product_type');
        $this->dbforge->add_key('is_active');
        $this->dbforge->add_key('sort_order');
        $this->dbforge->create_table('eeform5_product_master');

        // 7. Create eeform5_consultation_records table
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
            'consultation_date' => array(
                'type' => 'DATE',
                'null' => FALSE
            ),
            'consultant_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE
            ),
            'consultation_type' => array(
                'type' => 'ENUM("initial","follow_up","review")',
                'default' => 'initial',
                'null' => FALSE
            ),
            'consultation_notes' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'health_assessment' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'recommendations' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'next_consultation_date' => array(
                'type' => 'DATE',
                'null' => TRUE
            ),
            'created_at' => array(
                'type' => 'TIMESTAMP',
                'null' => FALSE
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('submission_id');
        $this->dbforge->add_key('consultation_date');
        $this->dbforge->add_key('consultation_type');
        $this->dbforge->add_key('next_consultation_date');
        $this->dbforge->create_table('eeform5_consultation_records');

        // Add foreign key constraints using raw SQL
        $this->db->query('ALTER TABLE eeform5_occupations ADD CONSTRAINT fk_eeform5_occupations_submission FOREIGN KEY (submission_id) REFERENCES eeform5_submissions(id) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE eeform5_health_issues ADD CONSTRAINT fk_eeform5_health_issues_submission FOREIGN KEY (submission_id) REFERENCES eeform5_submissions(id) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE eeform5_product_recommendations ADD CONSTRAINT fk_eeform5_product_recommendations_submission FOREIGN KEY (submission_id) REFERENCES eeform5_submissions(id) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE eeform5_consultation_records ADD CONSTRAINT fk_eeform5_consultation_records_submission FOREIGN KEY (submission_id) REFERENCES eeform5_submissions(id) ON DELETE CASCADE');

        // Insert default health issues
        $health_issues = array(
            array('issue_code' => 'HEADACHE', 'issue_name' => '經常頭痛', 'issue_category' => 'neurological', 'sort_order' => 1),
            array('issue_code' => 'ALLERGY', 'issue_name' => '過敏問題', 'issue_category' => 'immune', 'sort_order' => 2),
            array('issue_code' => 'SLEEP', 'issue_name' => '睡眠不佳', 'issue_category' => 'mental', 'sort_order' => 3),
            array('issue_code' => 'JOINT', 'issue_name' => '骨關節問題', 'issue_category' => 'musculoskeletal', 'sort_order' => 4),
            array('issue_code' => 'METABOLIC', 'issue_name' => '三高問題(血糖/血脂肪/血壓)', 'issue_category' => 'metabolic', 'sort_order' => 5),
            array('issue_code' => 'DIGESTIVE', 'issue_name' => '腸胃健康問題', 'issue_category' => 'digestive', 'sort_order' => 6),
            array('issue_code' => 'VISION', 'issue_name' => '視力問題', 'issue_category' => 'sensory', 'sort_order' => 7),
            array('issue_code' => 'IMMUNITY', 'issue_name' => '免疫力', 'issue_category' => 'immune', 'sort_order' => 8),
            array('issue_code' => 'WEIGHT', 'issue_name' => '體重困擾', 'issue_category' => 'metabolic', 'sort_order' => 9),
            array('issue_code' => 'OTHER', 'issue_name' => '其他', 'issue_category' => 'other', 'sort_order' => 10)
        );

        foreach ($health_issues as $issue) {
            $issue['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('eeform5_health_issues_master', $issue);
        }

        // Insert default product data
        $products = array(
            array('product_code' => 'VITAL001', 'product_name' => '活力精萃', 'product_type' => 'supplement', 'default_dosage' => '每日2次，每次1包', 'sort_order' => 1),
            array('product_code' => 'LINGZHI001', 'product_name' => '白鶴靈芝EX', 'product_type' => 'supplement', 'default_dosage' => '每日1-2次，每次2粒', 'sort_order' => 2),
            array('product_code' => 'VITC001', 'product_name' => '美力C錠', 'product_type' => 'supplement', 'default_dosage' => '每日1次，每次2錠', 'sort_order' => 3),
            array('product_code' => 'CRYSTAL001', 'product_name' => '鶴力晶', 'product_type' => 'supplement', 'default_dosage' => '每日1次，每次1包', 'sort_order' => 4),
            array('product_code' => 'TEA001', 'product_name' => '白鶴靈芝茶', 'product_type' => 'tea', 'default_dosage' => '每日1-2包', 'sort_order' => 5)
        );

        foreach ($products as $product) {
            $product['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('eeform5_product_master', $product);
        }
    }

    public function down()
    {
        // Drop foreign key constraints first
        $this->db->query('ALTER TABLE eeform5_occupations DROP FOREIGN KEY fk_eeform5_occupations_submission');
        $this->db->query('ALTER TABLE eeform5_health_issues DROP FOREIGN KEY fk_eeform5_health_issues_submission');
        $this->db->query('ALTER TABLE eeform5_product_recommendations DROP FOREIGN KEY fk_eeform5_product_recommendations_submission');
        $this->db->query('ALTER TABLE eeform5_consultation_records DROP FOREIGN KEY fk_eeform5_consultation_records_submission');

        // Drop tables
        $this->dbforge->drop_table('eeform5_consultation_records');
        $this->dbforge->drop_table('eeform5_product_recommendations');
        $this->dbforge->drop_table('eeform5_product_master');
        $this->dbforge->drop_table('eeform5_health_issues');
        $this->dbforge->drop_table('eeform5_health_issues_master');
        $this->dbforge->drop_table('eeform5_occupations');
        $this->dbforge->drop_table('eeform5_submissions');
    }
}