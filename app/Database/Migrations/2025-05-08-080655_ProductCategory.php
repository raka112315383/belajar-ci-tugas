<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProductCategory extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'nama_kategori' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => TRUE,
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => TRUE
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => TRUE
            ]
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('ProductCategory');
    }

    public function down()
    {
        $this->forge->dropTable('ProductCategory');
    }
}