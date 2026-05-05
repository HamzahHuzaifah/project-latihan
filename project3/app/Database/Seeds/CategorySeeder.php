<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Teknologi', 'slug' => 'teknologi'],
            ['name' => 'Gaya Hidup', 'slug' => 'gaya-hidup'],
            ['name' => 'Pendidikan', 'slug' => 'pendidikan'],
            ['name' => 'Kesehatan', 'slug' => 'kesehatan'],
        ];

        // Using Query Builder
        $this->db->table('categories')->insertBatch($data);
    }
}
