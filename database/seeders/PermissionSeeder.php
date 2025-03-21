<?php

namespace Database\Seeders;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (PermissionEnum::cases() as $permission) {
            Permission::create([
                'name'          => $permission
            ]);
        }

        foreach (RoleEnum::cases() as $role) {
            Role::create([
                'name'          => $role
            ]);
        }

        $role = Role::findByName(RoleEnum::STUDENT->value);
        $role->givePermissionTo([
            PermissionEnum::VIEW_OWN_STUDENT,
            PermissionEnum::UPDATE_OWN_STUDENT,
        ]);

        $virith             = User::create([
            'name'          => 'Heang Virith',
            'email'         => 'virith@gmail.com',
            'password'      => bcrypt('12345678'),
        ]);

        $sophannarith       = User::create([
            'name'          => 'Chea Sophannarith',
            'email'         => 'sophannarith@gmail.com',
            'password'      => bcrypt('12345678'),
        ]);

        $soriya             = User::create([
            'name'          => 'Chann Soriya',
            'email'         => 'soriya@gmail.com',
            'password'      => bcrypt('12345678'),
        ]);

        $panha             = User::create([
            'name'          => 'Thorn Panha',
            'email'         => 'panha@gmail.com',
            'password'      => bcrypt('12345678'),
        ]);

        $bona               = User::create([
            'name'          => 'Vorn Bona',
            'email'         => 'bona@gmail.com',
            'password'      => bcrypt('12345678'),
        ]);

        $thou               = User::create([
            'name'          => 'Chev Thou',
            'email'         => 'thou@gmail.com',
            'password'      => bcrypt('12345678'),
        ]);

        $vathana            = User::create([
            'name'          => 'Sroeun Vathana',
            'email'         => 'vathana@gmail.com',
            'password'      => bcrypt('12345678'),
        ]);

        $broseth        = User::create([
            'name'          => 'Kung Broseth',
            'email'         => 'broseth@gmail.com',
            'password'      => bcrypt('12345678'),
        ]);

        $chamroeun          = User::create([
            'name'          => 'Sok Chamroeun',
            'email'         => 'chamroeun@gmail.com',
            'password'      => bcrypt('12345678'),
        ]);

        $rathana            = User::create([
            'name'          => 'Vin Rathana',
            'email'         => 'rathana@gmail.com',
            'password'      => bcrypt('12345678'),
        ]);

        $virith->assignRole(RoleEnum::ADMIN);
        $sophannarith->assignRole(RoleEnum::ADMIN);
        $soriya->assignRole(RoleEnum::ADMIN);
        $panha->assignRole(RoleEnum::ADMIN);
        $bona->assignRole(RoleEnum::ADMIN);
        $thou->assignRole(RoleEnum::ADMIN);
        $vathana->assignRole(RoleEnum::ADMIN);
        $broseth->assignRole(RoleEnum::ADMIN);
        $chamroeun->assignRole(RoleEnum::ADMIN);
        $rathana->assignRole(RoleEnum::ADMIN);
    }
}
