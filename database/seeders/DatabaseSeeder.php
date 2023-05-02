<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\UserPrefixnameEnum;
use App\Enums\UserTypeEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         \App\Models\User::create([
             'prefixname' => UserPrefixnameEnum::MR,
             'firstname' => 'Sami',
             'middlename' => 'John',
             'lastname' => 'Smith',
             'suffixname' => 'DD',
             'email' => 'admin@example.com',
             'password' => 'password',
             'type' => UserTypeEnum::USER
         ]);

        \App\Models\User::create([
            'prefixname' => UserPrefixnameEnum::MR,
            'firstname' => 'Sami',
            'middlename' => 'John',
            'lastname' => 'Smith',
            'suffixname' => 'DD',
            'email' => 'test@example.com',
            'password' => 'password',
            'type' => UserTypeEnum::USER
        ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
