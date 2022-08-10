<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super_admin = Admin::firstOrCreate(['email' => 'mahmoudfaisal@gmail.com'],
        [
            'name' => 'محمود فيصل',
            'password' => '$2y$10$biU8dk10a8OR7.hf4HHpleWAfcU3wHZNg120FACRG3Fer9qOxWQrm',
        ]);

        $super_rule = Role::firstOrCreate(['name' => 'Super Admin']);

        $super_admin->assignRole($super_rule);
    }
}
