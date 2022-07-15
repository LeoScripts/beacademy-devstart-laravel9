<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user()
    {

        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => '123456',
            'image' => 'imagem_defalt'
        ]);

        $this->actingAs($user);

        $response = $this->get('/users');

        $response->assertStatus(200);
    }

    public function test_create_user()
    {
        $response = $this->post('/login/crate', [
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'password' => '123456789',
            'is_admin' => '1',
        ]);

        $response->assertStatus(200);
    }
}
