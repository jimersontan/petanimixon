<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AdminRegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_registration_page_is_accessible()
    {
        $response = $this->get(route('admin.register'));
        $response->assertStatus(200);
        $response->assertSee('Admin Sign Up');
    }

    /** @test */
    public function guest_can_request_admin_account()
    {
        $data = [
            'name' => 'Jane Admin',
            'email' => 'janadmin@example.com',
            'password' => 'Admin@1234',
            'password_confirmation' => 'Admin@1234',
        ];

        $response = $this->postJson(route('admin.register.submit'), $data);
        $response->assertStatus(200)->assertJson([
            'success' => true,
            'message' => 'Your request has been submitted and is awaiting approval.',
        ]);

        $this->assertDatabaseHas('admin_requests', [
            'email' => 'janadmin@example.com',
            'status' => 'pending',
        ]);
    }

    /** @test */
    public function admin_can_approve_request_and_it_creates_user()
    {
        // create pending request
        $req = \App\Models\AdminRequest::create([
            'name' => 'Joe Manager',
            'email' => 'joe@example.com',
            'password' => 'secret123',
            'status' => 'pending',
        ]);

        // simulate logged-in admin – create record without using factory to avoid 'name' issues
        $adminData = [
            'email' => 'existing-admin@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'is_admin' => true,
            'user_type' => 'admin',
            'email_verified_at' => now(),
        ];
        if (\Schema::hasColumn('users', 'first_name')) {
            $adminData['first_name'] = 'Existing';
            $adminData['last_name'] = 'Admin';
        } else {
            $adminData['name'] = 'Existing Admin';
        }
        $admin = \App\Models\User::create($adminData);
        $this->actingAs($admin);

        $response = $this->post(route('admin.requests.approve', $req->id));
        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['email' => 'joe@example.com', 'is_admin' => true]);
        $this->assertDatabaseHas('admin_requests', ['id' => $req->id, 'status' => 'approved']);
    }

    /** @test */
    public function login_shows_pending_message_if_request_exists()
    {
        \App\Models\AdminRequest::create([
            'name' => 'Awaiting Admin',
            'email' => 'await@example.com',
            'password' => 'pass1234',
            'status' => 'pending',
        ]);

        $response = $this->postJson(route('admin.login.submit'), [
            'email' => 'await@example.com',
            'password' => 'pass1234',
        ]);
        $response->assertStatus(401)
                 ->assertJson(['success' => false, 'message' => 'Admin account request is still pending approval']);
    }
}
