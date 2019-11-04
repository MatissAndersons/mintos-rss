<?php

use App\Http\Controllers\Api\User\CheckEmail;
use App\Models\User;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CheckEmailTest extends TestCase
{
    use DatabaseTransactions;

    public function testCanBeInitialized()
    {
        $this->assertInstanceOf(CheckEmail::class, new CheckEmail());
    }

    public function testUserExists()
    {
        $email = 'test-info123@example.com';

        if (!User::where('email', $email)->exists()) {
            factory(User::class)->create([
                'email' => $email,
            ]);
        }

        $response = $this->post(env('MIX_API_URL') . '/check-email', ['email' => $email])->response->getContent();
        $data = json_decode($response, true);

        $this->assertEquals(true, $data['exists']);
    }

    public function testUserDoesNotExist()
    {
        $email = 'test-info123@example.com';
        $shouldBe = false;

        if (User::where('email', $email)->exists()) {
            $shouldBe = true;
        }

        $response = $this->post(env('MIX_API_URL') . '/check-email', ['email' => $email])->response->getContent();
        $data = json_decode($response, true);

        $this->assertEquals($shouldBe, $data['exists']);
    }
}
