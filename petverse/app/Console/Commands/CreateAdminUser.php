<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create
                            {--email= : Email address of the new admin}
                            {--password= : Password for the new admin}
                            {--name= : Full name of the admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new administrator user with full system access';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->option('email') ?: $this->ask('Email for the administrator');
        $password = $this->option('password') ?: $this->secret('Password');
        $name = $this->option('name') ?: $this->ask('Full name (first and last)');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('A valid email address is required.');
            return 1;
        }
        if (strlen($password) < 6) {
            $this->error('Password must be at least 6 characters.');
            return 1;
        }

        // create user record
        $userData = [
            'email' => $email,
            'password' => Hash::make($password),
            'is_admin' => true,
            'user_type' => 'admin',
            'email_verified_at' => now(),
        ];
        if (\Schema::hasColumn('users', 'first_name')) {
            $parts = preg_split('/\s+/', trim($name), 2);
            $userData['first_name'] = $parts[0] ?? '';
            $userData['last_name'] = $parts[1] ?? '';
            if (\Schema::hasColumn('users', 'name')) {
                $userData['name'] = $name;
            }
        } else {
            $userData['name'] = $name;
        }

        $user = User::create($userData);
        if ($user) {
            AdminUser::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'admin_user_id' => (string) $user->id,
                    'admin_type' => 'super_admin',
                    'permissions' => 'all',
                    'is_active' => true,
                ]
            );
        }

        $this->info("Admin user created: {$email}");
        return 0;
    }
}
