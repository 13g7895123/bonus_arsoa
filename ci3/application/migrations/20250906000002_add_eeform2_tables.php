<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_eeform2_tables extends CI_Migration {

    public function up()
    {
        // 1. Create eeform2_submissions table
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
            'join_date' => array(
                'type' => 'DATE',
                'null' => FALSE
            ),
            'gender' => array(
                'type' => 'ENUM("男","女")',
                'null' => FALSE
            ),
            'age' => array(
                'type' => 'TINYINT',
                'constraint' => 3,
                'unsigned' => TRUE,
                'null' => FALSE
            ),
            'skin_health_condition' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'line_contact' => array(
                'type' => 'VARCHAR',
                'constraint' => '300',
                'null' => TRUE
            ),
            'tel_contact' => array(
                'type' => 'VARCHAR',
                'constraint' => '300',
                'null' => TRUE
            ),
            'meeting_date' => array(
                'type' => 'DATE',
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
                'type' => 'ENUM("draft","submitted","reviewed")',
                'default' => 'submitted',
                'null' => FALSE
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('member_name');
        $this->dbforge->add_key('join_date');
        $this->dbforge->add_key('submission_date');
        $this->dbforge->add_key('meeting_date');
        $this->dbforge->add_key('status');
        $this->dbforge->add_key('created_at');
        $this->dbforge->create_table('eeform2_submissions');

        // 2. Create eeform2_products table
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
            'quantity' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'default' => 0,
                'null' => TRUE
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('submission_id');
        $this->dbforge->add_key('product_code');
        $this->dbforge->create_table('eeform2_products');

        // 3. Create eeform2_product_master table
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
            'product_category' => array(
                'type' => 'ENUM("soap","toner","serum","lotion","foundation","other")',
                'default' => 'other',
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
        $this->dbforge->add_key('product_code');
        $this->dbforge->add_key('product_category');
        $this->dbforge->add_key('is_active');
        $this->dbforge->add_key('sort_order');
        $this->dbforge->create_table('eeform2_product_master');

        // 4. Create eeform2_contact_history table
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
            'contact_type' => array(
                'type' => 'ENUM("LINE","TEL","MEETING","OTHER")',
                'null' => FALSE
            ),
            'contact_date' => array(
                'type' => 'DATE',
                'null' => FALSE
            ),
            'contact_time' => array(
                'type' => 'TIME',
                'null' => TRUE
            ),
            'contact_content' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'contact_result' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'follow_up_date' => array(
                'type' => 'DATE',
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
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('submission_id');
        $this->dbforge->add_key('contact_type');
        $this->dbforge->add_key('contact_date');
        $this->dbforge->add_key('follow_up_date');
        $this->dbforge->create_table('eeform2_contact_history');

        // Add foreign key constraints using raw SQL
        $this->db->query('ALTER TABLE eeform2_products ADD CONSTRAINT fk_eeform2_products_submission FOREIGN KEY (submission_id) REFERENCES eeform2_submissions(id) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE eeform2_contact_history ADD CONSTRAINT fk_eeform2_contact_history_submission FOREIGN KEY (submission_id) REFERENCES eeform2_submissions(id) ON DELETE CASCADE');

        // Insert default product data
        $products = array(
            array('product_code' => 'SOAP001', 'product_name' => '淨白活膚蜜皂', 'product_category' => 'soap', 'sort_order' => 1),
            array('product_code' => 'SOAP002', 'product_name' => 'AP柔敏潔顏皂', 'product_category' => 'soap', 'sort_order' => 2),
            array('product_code' => 'MASK001', 'product_name' => '活顏泥膜', 'product_category' => 'other', 'sort_order' => 3),
            array('product_code' => 'TONER001', 'product_name' => '安露莎化粧水I', 'product_category' => 'toner', 'sort_order' => 4),
            array('product_code' => 'TONER002', 'product_name' => '安露莎化粧水II', 'product_category' => 'toner', 'sort_order' => 5),
            array('product_code' => 'TONER003', 'product_name' => '安露莎活膚化粧水', 'product_category' => 'toner', 'sort_order' => 6),
            array('product_code' => 'TONER004', 'product_name' => '柔敏化粧水', 'product_category' => 'toner', 'sort_order' => 7),
            array('product_code' => 'SERUM001', 'product_name' => '安露莎精華液I', 'product_category' => 'serum', 'sort_order' => 8),
            array('product_code' => 'SERUM002', 'product_name' => '安露莎精華液II', 'product_category' => 'serum', 'sort_order' => 9),
            array('product_code' => 'SERUM003', 'product_name' => '安露莎活膚精華液', 'product_category' => 'serum', 'sort_order' => 10),
            array('product_code' => 'SERUM004', 'product_name' => '美白精華液', 'product_category' => 'serum', 'sort_order' => 11),
            array('product_code' => 'LOTION001', 'product_name' => '保濕潤膚液', 'product_category' => 'lotion', 'sort_order' => 12),
            array('product_code' => 'OIL001', 'product_name' => '美容防皺油', 'product_category' => 'other', 'sort_order' => 13),
            array('product_code' => 'GEL001', 'product_name' => '保濕凝膠', 'product_category' => 'other', 'sort_order' => 14),
            array('product_code' => 'ESSENCE001', 'product_name' => '亮采晶萃', 'product_category' => 'other', 'sort_order' => 15),
            array('product_code' => 'SUNSCREEN001', 'product_name' => '防曬隔離液', 'product_category' => 'other', 'sort_order' => 16),
            array('product_code' => 'FOUNDATION001', 'product_name' => '保濕粉底液', 'product_category' => 'foundation', 'sort_order' => 17),
            array('product_code' => 'POWDER001', 'product_name' => '絲柔粉餅', 'product_category' => 'foundation', 'sort_order' => 18)
        );
        
        foreach ($products as $product) {
            $product['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('eeform2_product_master', $product);
        }
    }

    public function down()
    {
        // Drop foreign key constraints first
        $this->db->query('ALTER TABLE eeform2_products DROP FOREIGN KEY fk_eeform2_products_submission');
        $this->db->query('ALTER TABLE eeform2_contact_history DROP FOREIGN KEY fk_eeform2_contact_history_submission');

        // Drop tables
        $this->dbforge->drop_table('eeform2_contact_history');
        $this->dbforge->drop_table('eeform2_products');
        $this->dbforge->drop_table('eeform2_product_master');
        $this->dbforge->drop_table('eeform2_submissions');
    }
}