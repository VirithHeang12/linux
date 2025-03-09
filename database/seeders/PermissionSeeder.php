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
            Permission::create(['name' => $permission]);
        }

        foreach (RoleEnum::cases() as $role) {
            Role::create(['name' => $role]);
        }

        $role = Role::findByName(RoleEnum::ADMIN->value);
        $role->givePermissionTo(PermissionEnum::cases());

        $role = Role::findByName(RoleEnum::STUDENT->value);
        $role->givePermissionTo([
            PermissionEnum::READ_STUDENT->value,
        ]);

        $virith = User::create([
            'name'          => 'Heang Virith',
            'email'         => 'virith@gmail.com',
            'password'      => bcrypt('12345678'),
        ]);

        $sophannarith = User::create([
            'name'          => 'Chea Sophannarith',
            'email'         => 'sophannarith@gmail.com',
            'password'      => bcrypt('12345678'),
        ]);

        $virith->assignRole(RoleEnum::ADMIN->value);
        $sophannarith->assignRole(RoleEnum::ADMIN->value);
    }
}
