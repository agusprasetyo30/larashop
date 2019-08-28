<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminstrator = new User;
        $adminstrator->name = "Site Adminstrator";
        $adminstrator->email = "administrator@larashop.test";
        $adminstrator->username = "administrator";
        $adminstrator->password = Hash::make("administrator");
        $adminstrator->roles = json_encode(["ADMIN"]);
        $adminstrator->address = "Tuban, Jawa Timur";
        $adminstrator->phone = "08166521275";
        $adminstrator->avatar = "saat-ini-tidak-ada-file-avatar.jpg";
        $adminstrator->status = "ACTIVE";

        $adminstrator->save();

        $this->command->info("User admin berhasil di insert");

    }
}
