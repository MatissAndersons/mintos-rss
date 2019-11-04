<?php

use App\User;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\Seeder;

class TestUserSeeder extends Seeder
{
    /**
     * @var Hasher
     */
    protected $hasher;

    /**
     * TestUserSeeder constructor.
     *
     * @param Hasher $hasher
     */
    public function __construct(Hasher $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrNew([
            'email' => 'info@example.com',
        ]);

        if (!$user->exists()) {
            $user->password = $this->hasher->make('test123');
        }

        $user->save();
    }
}
