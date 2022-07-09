<?php

namespace RSolution\RCms\Console\Commands;

use Illuminate\Console\Command;
use RSolution\RCms\Repositories\UserRepository;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rcms:createadmin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create admin for RCms';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        if ($this->confirm('Do you wanna create Admin?')) {
            $email = $this->ask('Email: ');
            $password = $this->ask('Password: ');
            if ($email && $password) {
                (new UserRepository)->createAdmin($email, $password);
                $this->info('Login information');
                $this->line('Email: ' . $email . ' and Password: ' . $password);
            } else
                $this->info('Email and Password are required');
        }
    }
}
