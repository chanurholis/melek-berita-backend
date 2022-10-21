<?php

namespace Database\Seeders;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payload = [
            'name' => 'Chacha Nurholis',
            'email' => 'chachanurholis29@gmail.com',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password' => 'password',
            'remember_token' => Str::random(10)
        ];
        try {
            DB::connection('pgsql')->transaction(function () use ($payload) {
                $email = Arr::get($payload, 'email');
                User::updateOrCreate(['email' => $email], $payload);
            });
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
