<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;

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
            'avatar_id'  => $avatar->getKey(),
            'uuid'       => $adminUuid,
            'first_name' => Config::get('admin.first_name', ''),
            'last_name'  => Config::get('admin.last_name', ''),
            'email'      => $this->email(),
            'password'   => Hash::make(Config::get('admin.password')),
            'is_admin'   => true,
        ]);
    }

    private function email(): string
    {
        if ($email = Config::get('admin.email')) {
            return $email;
        }

        $host = Request::instance()->getHost();

        return "admin@{$host}";
    }
}
