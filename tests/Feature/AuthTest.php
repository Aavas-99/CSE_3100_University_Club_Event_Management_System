<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_page_is_accessible(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_student_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Ayesha Rahman',
            'email' => 'ayesha@kuet.ac.bd',
            'student_id' => '1804001',
            'department' => 'CSE',
            'phone' => '01700000000',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'role' => 'student',
        ]);

        $response->assertRedirect('/login/student');
        $this->assertDatabaseHas('users', ['email' => 'ayesha@kuet.ac.bd']);
        $this->assertTrue(User::where('email', 'ayesha@kuet.ac.bd')->exists());
    }
}
