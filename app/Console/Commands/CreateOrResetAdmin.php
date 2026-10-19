<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateOrResetAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:manage 
                            {--email= : Email address of the admin} 
                            {--password= : New password for the admin} 
                            {--name= : Name of the admin}
                            {--list : List all existing administrator accounts}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Safely create or reset an administrator account without exposing secrets';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if ($this->option('list')) {
            $admins = User::where('role', 'admin')->get(['id', 'name', 'email', 'created_at']);
            if ($admins->isEmpty()) {
                $this->warn('No admin accounts found in the database.');
                return self::SUCCESS;
            }

            $this->info('Registered Administrator Accounts:');
            $this->table(
                ['ID', 'Name', 'Email', 'Created At'],
                $admins->map(fn ($u) => [$u->id, $u->name, $u->email, $u->created_at->format('Y-m-d H:i')])
            );
            return self::SUCCESS;
        }

        $email = $this->option('email');
        if (! $email) {
            $email = $this->ask('Enter admin email address (e.g. admin@newsportal.com)');
        }

        $validator = Validator::make(['email' => $email], [
            'email' => ['required', 'email'],
        ]);

        if ($validator->fails()) {
            $this->error('Invalid email address format.');
            return self::FAILURE;
        }

        $password = $this->option('password');
        if (! $password) {
            $password = $this->secret('Enter admin password (minimum 8 characters)');
        }

        if (strlen($password) < 8) {
            $this->error('Password must be at least 8 characters long.');
            return self::FAILURE;
        }

        $name = $this->option('name') ?: 'Administrator';

        $user = User::where('email', $email)->first();

        if ($user) {
            $user->update([
                'name' => $this->option('name') ?: $user->name,
                'password' => Hash::make($password),
                'role' => 'admin',
                'email_verified_at' => $user->email_verified_at ?? now(),
            ]);

            $this->info("Password and admin privileges updated successfully for [{$email}].");
        } else {
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);

            $this->info("New admin account created successfully for [{$email}].");
        }

        return self::SUCCESS;
    }
}
