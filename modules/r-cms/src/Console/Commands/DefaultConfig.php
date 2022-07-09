<?php

namespace RSolution\RCms\Console\Commands;

use Illuminate\Console\Command;
use RSolution\RCms\Repositories\PlanRepository;

class DefaultConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rcms:config:default';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set up default config for RCMS';

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
        (new PlanRepository)->create([
            'name' => 'Free'
        ]);
    }
}
