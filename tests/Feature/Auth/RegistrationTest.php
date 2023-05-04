<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $this->seed(RoleSeeder::class);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function testRegistrationEmployerScreenCanBeRendered(): void
    {
        $response = $this->get('/register-employer');

        $response->assertStatus(200);
    }

    public function testEmployerUsersCanRegister(): void
    {
        $this->seed(RoleSeeder::class);

        $response = $this->post('/register-employer', [
            'name' => 'Employer Employer',
            'email' => 'employer@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'phone' => '123456789',
            'company_name' => 'ExampleCompany',
            'vat_number' => '1234567890'
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function testEmployerCannotBeRegisterWithInvalidConfirmPassword(): void
    {
        $this->seed(RoleSeeder::class);


        $response = $this->post('/register-employer', [
            'name' => 'Employer Employer',
            'email' => 'employer@example.com',
            'password' => 'password',
            'password_confirmation' => 'passwordConfirm',
            'phone' => '123456789',
            'company_name' => 'ExampleCompany',
            'vat_number' => '1234567890'
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors();
    }

    public function testEmployerRegisterCannotBeRegisterWithEmptyPhone(): void
    {
        $this->seed(RoleSeeder::class);


        $response = $this->post('/register-employer', [
            'name' => 'Employer Employer',
            'email' => 'employer@example.com',
            'password' => 'password',
            'password_confirmation' => 'passwordConfirm',
            'phone' => '',
            'company_name' => 'ExampleCompany',
            'vat_number' => '1234567890'
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors();
    }
}
