<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->makeRoles();
    }

    private function makeRoles()
    {
        echo "[+] add roles\n";

        Role::create(['name' => 'ADMINISTRATOR']);
        Role::create(['name' => 'STAFF']);
        Role::create(['name' => 'CUSTOMER']);
    }
}
