<?php

namespace Database\Seeders\Production;

use App\Models\File;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $avatarUuid = Config::get('admin.avatar_uuid');
        $adminUuid  = Config::get('admin.uuid');

        $avatar = File::firstOrCreate(['uuid' => $avatarUuid], [
            'uuid' => $avatarUuid,
            'name' => 'admin_avatar',
            'path' => 'avatars/admin',
            'size' => '65535',
            'type' => 'image/jpeg',
        ]);

        User::updateOrCreate(['uuid' => $adminUuid], [
            'avatar_uuid'  => $avatar->uuid,
            'uuid'         => $adminUuid,
            'first_name'   => Config::get('admin.first_name', ''),
            'last_name'    => Config::get('admin.last_name', ''),
            'email'        => Config::get('admin.email'),
            'password'     => Hash::make(Config::get('admin.password')),
            'address'      => Config::get('admin.address', ''),
            'phone_number' => Config::get('admin.phone_number', ''),
            'is_admin'     => true,
        ]);
    }
}
