<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateAdminUser extends Command
{
    protected $signature = 'gmac:create-admin
                            {email : The admin email address}
                            {--password= : Plain password (default: password)}
                            {--name=Admin : Display name}';

    protected $description = 'Create a new admin user or promote an existing user and set their password';

    public function handle(): int
    {
        $email = strtolower(trim($this->argument('email')));
        $plain = $this->option('password') ?: 'password';
        $name = $this->option('name') ?: 'Admin';

        if (strlen($plain) < 8) {
            $this->error('Password must be at least 8 characters (Laravel default).');

            return self::FAILURE;
        }

        $user = User::query()->where('email', $email)->first();

        if ($user) {
            $user->name = $name;
            $user->password = $plain;
            $user->is_admin = true;
            $user->email_verified_at = $user->email_verified_at ?? now();
            $user->save();
            $this->info("Updated existing user [{$email}] — password reset and is_admin = true.");
        } else {
            User::query()->create([
                'name' => $name,
                'email' => $email,
                'password' => $plain,
                'is_admin' => true,
                'email_verified_at' => now(),
            ]);
            $this->info("Created admin [{$email}] with the password you provided.");
        }

        $this->line('You can log in at /login');

        return self::SUCCESS;
    }
}
