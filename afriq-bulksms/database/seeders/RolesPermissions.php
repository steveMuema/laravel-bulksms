<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrRoles = [
            'Super Admin',
            'Admin'

        ];

        $arrPermissions = [
            'view address books',
            'view address books details',
            'create address books',
            'update address books',
            'delete address books',
            'restore address books',
            'force delete address books',

            'view contacts',
            'vew contacts details',
            'edit contacts',
            'update contacts',
            'delete contacts',
            'restore contacts',
            'force delete contacts',

            'view credit plans',
            'vew credit plans details',
            'edit credit plans',
            'update credit plans',
            'delete credit plans',
            'restore credit plans',
            'force delete credit plans',

            'view sms',
            'vew sms details',
            'edit sms',
            'update sms',
            'delete sms',
            'restore sms',
            'force delete sms',

            'view users',
            'vew users details',
            'edit users',
            'update users',
            'delete users',
            'restore users',
            'force delete users',
        ];

        $permissions = collect($arrPermissions)->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'web'];
        });

        Permission::insert($permissions->toArray());

        $arrolesarroles = collect($arrRoles)->map(function ($roles) {
            return ['name' => $roles, 'guard_name' => 'web'];
        });
        Role::insert($arrolesarroles->toArray());
    }
}
