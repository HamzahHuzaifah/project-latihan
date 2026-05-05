<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBlogFeatures extends Migration
{
    public function up()
    {
        // 1. Create categories table
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'slug'        => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('categories', true);

        // 2. Modify posts table
        $this->forge->addColumn('posts', [
            'category_id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'null' => true, 'after' => 'id'],
            'likes'       => ['type' => 'INT', 'constraint' => 11, 'default' => 0, 'after' => 'status'],
        ]);

        // 3. Create comments table
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'post_id'    => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true],
            'name'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'comment'    => ['type' => 'TEXT'],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('post_id', 'posts', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('comments', true);
    }

    public function down()
    {
        $this->forge->dropTable('comments', true);
        $this->forge->dropColumn('posts', ['category_id', 'likes']);
        $this->forge->dropTable('categories', true);
    }
}
