<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_eeform1_tables extends CI_Migration {

    public function up()
    {
        // 1. Create eeform1_submissions table
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'member_id' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => TRUE
            ),
            'member_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            ),
            'form_filler_id' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => TRUE
            ),
            'form_filler_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE
            ),
            'birth_year' => array(
                'type' => 'SMALLINT',
                'constraint' => 5,
                'null' => FALSE
            ),
            'birth_month' => array(
                'type' => 'TINYINT',
                'constraint' => 3,
                'null' => FALSE
            ),
            'phone' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => FALSE
            ),
            'skin_type' => array(
                'type' => 'ENUM("normal","combination","oily","dry","sensitive")',
                'null' => TRUE
            ),
            'skin_age' => array(
                'type' => 'TINYINT',
                'constraint' => 3,
                'null' => TRUE
            ),
            'submission_date' => array(
                'type' => 'DATETIME',
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
                'type' => 'ENUM("draft","submitted","reviewed")',
                'default' => 'submitted',
                'null' => FALSE
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('member_id');
        $this->dbforge->add_key('member_name');
        $this->dbforge->add_key('phone');
        $this->dbforge->add_key('submission_date');
        $this->dbforge->add_key('status');
        $this->dbforge->add_key('created_at');
        $this->dbforge->create_table('eeform1_submissions');

        // 2. Create eeform1_occupations table
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
                'type' => 'ENUM("service","office","restaurant","housewife")',
                'null' => FALSE
            ),
            'is_selected' => array(
                'type' => 'BOOLEAN',
                'default' => TRUE
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('submission_id');
        $this->dbforge->add_key('occupation_type');
        $this->dbforge->create_table('eeform1_occupations');

        // 3. Create eeform1_lifestyle table
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
            'category' => array(
                'type' => 'ENUM("sunlight","aircondition","sleep")',
                'null' => FALSE
            ),
            'item_key' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => FALSE
            ),
            'item_value' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ),
            'is_selected' => array(
                'type' => 'BOOLEAN',
                'default' => TRUE
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('submission_id');
        $this->dbforge->add_key('category');
        $this->dbforge->add_key('item_key');
        $this->dbforge->create_table('eeform1_lifestyle');

        // 4. Create eeform1_products table
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
            'product_type' => array(
                'type' => 'ENUM("honey_soap","mud_mask","toner","serum","premium","sunscreen","other")',
                'null' => FALSE
            ),
            'product_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ),
            'is_selected' => array(
                'type' => 'BOOLEAN',
                'default' => TRUE
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('submission_id');
        $this->dbforge->add_key('product_type');
        $this->dbforge->create_table('eeform1_products');

        // 5. Create eeform1_skin_issues table
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
            'issue_type' => array(
                'type' => 'ENUM("elasticity","luster","dull","spots","pores","acne","wrinkles","rough","irritation","dry","makeup","other")',
                'null' => FALSE
            ),
            'issue_description' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'is_selected' => array(
                'type' => 'BOOLEAN',
                'default' => TRUE
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('submission_id');
        $this->dbforge->add_key('issue_type');
        $this->dbforge->create_table('eeform1_skin_issues');

        // 6. Create eeform1_allergies table
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
            'allergy_type' => array(
                'type' => 'ENUM("frequent","seasonal","never")',
                'null' => FALSE
            ),
            'is_selected' => array(
                'type' => 'BOOLEAN',
                'default' => TRUE
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('submission_id');
        $this->dbforge->add_key('allergy_type');
        $this->dbforge->create_table('eeform1_allergies');

        // 7. Create eeform1_skin_scores table
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
            'category' => array(
                'type' => 'ENUM("moisture","complexion","texture","sensitivity","oil","pigment","wrinkle","pore")',
                'null' => FALSE
            ),
            'score_type' => array(
                'type' => 'ENUM("severe","warning","healthy")',
                'null' => FALSE
            ),
            'score_value' => array(
                'type' => 'TINYINT',
                'constraint' => 3,
                'default' => 0,
                'null' => FALSE
            ),
            'measurement_date' => array(
                'type' => 'DATE',
                'null' => TRUE
            ),
            'measurement_number' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ),
            'notes' => array(
                'type' => 'TEXT',
                'null' => TRUE
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('submission_id');
        $this->dbforge->add_key('category');
        $this->dbforge->add_key('score_type');
        $this->dbforge->add_key('measurement_date');
        $this->dbforge->create_table('eeform1_skin_scores');

        // 8. Create eeform1_suggestions table
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
            'toner_suggestion' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ),
            'serum_suggestion' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ),
            'suggestion_content' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'created_by' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE
            ),
            'created_at' => array(
                'type' => 'TIMESTAMP',
                'null' => FALSE
            ),
            'updated_at' => array(
                'type' => 'TIMESTAMP',
                'null' => TRUE
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('submission_id');
        $this->dbforge->add_key('created_at');
        $this->dbforge->create_table('eeform1_suggestions');

        // Add foreign key constraints using raw SQL
        $this->db->query('ALTER TABLE eeform1_occupations ADD CONSTRAINT fk_eeform1_occupations_submission FOREIGN KEY (submission_id) REFERENCES eeform1_submissions(id) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE eeform1_lifestyle ADD CONSTRAINT fk_eeform1_lifestyle_submission FOREIGN KEY (submission_id) REFERENCES eeform1_submissions(id) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE eeform1_products ADD CONSTRAINT fk_eeform1_products_submission FOREIGN KEY (submission_id) REFERENCES eeform1_submissions(id) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE eeform1_skin_issues ADD CONSTRAINT fk_eeform1_skin_issues_submission FOREIGN KEY (submission_id) REFERENCES eeform1_submissions(id) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE eeform1_allergies ADD CONSTRAINT fk_eeform1_allergies_submission FOREIGN KEY (submission_id) REFERENCES eeform1_submissions(id) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE eeform1_skin_scores ADD CONSTRAINT fk_eeform1_skin_scores_submission FOREIGN KEY (submission_id) REFERENCES eeform1_submissions(id) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE eeform1_suggestions ADD CONSTRAINT fk_eeform1_suggestions_submission FOREIGN KEY (submission_id) REFERENCES eeform1_submissions(id) ON DELETE CASCADE');
    }

    public function down()
    {
        // Drop foreign key constraints first
        $this->db->query('ALTER TABLE eeform1_occupations DROP FOREIGN KEY fk_eeform1_occupations_submission');
        $this->db->query('ALTER TABLE eeform1_lifestyle DROP FOREIGN KEY fk_eeform1_lifestyle_submission');
        $this->db->query('ALTER TABLE eeform1_products DROP FOREIGN KEY fk_eeform1_products_submission');
        $this->db->query('ALTER TABLE eeform1_skin_issues DROP FOREIGN KEY fk_eeform1_skin_issues_submission');
        $this->db->query('ALTER TABLE eeform1_allergies DROP FOREIGN KEY fk_eeform1_allergies_submission');
        $this->db->query('ALTER TABLE eeform1_skin_scores DROP FOREIGN KEY fk_eeform1_skin_scores_submission');
        $this->db->query('ALTER TABLE eeform1_suggestions DROP FOREIGN KEY fk_eeform1_suggestions_submission');

        // Drop tables
        $this->dbforge->drop_table('eeform1_suggestions');
        $this->dbforge->drop_table('eeform1_skin_scores');
        $this->dbforge->drop_table('eeform1_allergies');
        $this->dbforge->drop_table('eeform1_skin_issues');
        $this->dbforge->drop_table('eeform1_products');
        $this->dbforge->drop_table('eeform1_lifestyle');
        $this->dbforge->drop_table('eeform1_occupations');
        $this->dbforge->drop_table('eeform1_submissions');
    }
}