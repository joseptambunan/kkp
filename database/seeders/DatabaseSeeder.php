<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $defaultPassword = "1234";
        $permissionRegisterKapal = Permission::create(['name' => 'tambah kapal']);
        $permissionEditKapal = Permission::create(['name' => 'edit kapal']);
        $permissionHapusKapal = Permission::create(['name' => 'hapus kapal']);
        $permissionApproveKapal = Permission::create(['name' => 'approve kapal']);

        $permissionEditUser = Permission::create(['name' => 'edit user']);
        $permissionAddUser = Permission::create(['name' => 'tambah user']);
        $permissionApproveUser = Permission::create(['name' => 'approve user']);
        $permissionHapusUser = Permission::create(['name' => 'hapus user']);

        $roleAdmin = Role::create(['name' => 'admin'])
            ->givePermissionTo($permissionEditUser)
            ->givePermissionTo($permissionAddUser)
            ->givePermissionTo($permissionApproveUser)
            ->givePermissionTo($permissionHapusUser)
            ->givePermissionTo($permissionEditKapal)
            ->givePermissionTo($permissionHapusKapal)
            ->givePermissionTo($permissionApproveKapal);

        $roleUser = Role::create(['name' => 'member'])
            ->givePermissionTo($permissionRegisterKapal)
            ->givePermissionTo($permissionEditKapal)
            ->givePermissionTo($permissionEditUser);

        $user = new User;
        $user->email = "admin@email.com";
        $user->name = "Admin";
        $user->password = Hash::make($defaultPassword);
        $user->approved_at = date("Y-m-d H:i:s");
        $user->save();
        $user->assignRole('admin');

        echo "User :  ". $user->email ." \n";
        echo "Password : ".$defaultPassword ."\n";

    }
}
