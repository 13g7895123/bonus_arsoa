<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_member_id_to_eeform2 extends CI_Migration {

    public function up()
    {
        // Add missing fields to eeform2_submissions table
        $fields = array(
            'member_id' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => TRUE,
                'after' => 'id'
            ),
            'form_filler_id' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => TRUE,
                'after' => 'member_name'
            ),
            'form_filler_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE,
                'after' => 'form_filler_id'
            ),
            'birth_year_month' => array(
                'type' => 'DATE',
                'null' => TRUE,
                'after' => 'age'
            )
        );

        $this->dbforge->add_column('eeform2_submissions', $fields);

        // Add indexes for better query performance
        $this->db->query('ALTER TABLE eeform2_submissions ADD INDEX idx_member_id (member_id)');
        $this->db->query('ALTER TABLE eeform2_submissions ADD INDEX idx_form_filler_id (form_filler_id)');
        $this->db->query('ALTER TABLE eeform2_submissions ADD INDEX idx_birth_year_month (birth_year_month)');
    }

    public function down()
    {
        // Remove indexes first
        $this->db->query('ALTER TABLE eeform2_submissions DROP INDEX idx_member_id');
        $this->db->query('ALTER TABLE eeform2_submissions DROP INDEX idx_form_filler_id');
        $this->db->query('ALTER TABLE eeform2_submissions DROP INDEX idx_birth_year_month');

        // Remove fields
        $this->dbforge->drop_column('eeform2_submissions', 'member_id');
        $this->dbforge->drop_column('eeform2_submissions', 'form_filler_id');
        $this->dbforge->drop_column('eeform2_submissions', 'form_filler_name');
        $this->dbforge->drop_column('eeform2_submissions', 'birth_year_month');
    }
}