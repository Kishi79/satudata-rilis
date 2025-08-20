<?php

namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\{Role,Permission};
use App\Models\User;

class RoleSeeder extends Seeder{
  public function run(): void {
    $admin = Role::firstOrCreate(['name'=>'Admin']);
    $kontributor = Role::firstOrCreate(['name'=>'Kontributor']);

    $user = User::firstOrCreate(['email'=>'admin@satudata.local'],[
      'name'=>'Admin','password'=>bcrypt('password')
    ]);
    $user->assignRole($admin);
  }
}

