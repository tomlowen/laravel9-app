<?php

namespace Database\Seeders;

use App\Models\User;
use App\Services\CategoryService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! User::where('email', 'test@example.com')->exists()) {
            $user = User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => Hash::make('password'),
            ]);

            app(CategoryService::class)->createDefaultCategories($user);
        }

        $users = User::factory(5)->create();

        foreach ($users as $user) {
            app(CategoryService::class)->createDefaultCategories($user);
        }
    }
}
