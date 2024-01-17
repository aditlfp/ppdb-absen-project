<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arr = ['guru', 'admin', 'siswa'];

        foreach ($arr as $i => $value)
        {
            $role = new Role();
            $role->name = $value;
            $role->save();
        }
    }
}
