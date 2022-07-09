<?php

namespace RSolution\RCms\Console\Commands;

use Illuminate\Console\Command;
use RSolution\RCms\Models\Transaction;
use RSolution\RCms\Models\User;
use RSolution\RCms\Repositories\ActivationRepository;
use RSolution\RCms\Repositories\PlanRepository;


class CheckInvalidUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rcms:checkinvaliduser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check invalid user ';

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
        $activations = (new ActivationRepository())->getAll();
        $invalids = User::where('plan', '!=', PlanRepository::PLAN_FREE)->whereNotIn('id', $activations->pluck('user_id')->toArray());
        foreach ($invalids as $invalid) {
            $this->info($invalid->email);
        }
        $this->info('Total invalids:' . $invalids->count());
        //
        $transactions = Transaction::groupBy('activation_id')->get();
        $activationIds = $transactions->pluck('activation_id')->toArray();
        $this->info('Total transactions:' . count($activationIds));
        //
        $totalActivationWithoutTransaction = $activations->whereNotIn('id', $activationIds);
        $this->info('Total activations without transaction:' . $totalActivationWithoutTransaction->count());
        //
        foreach ($totalActivationWithoutTransaction as $item) {
            $this->info('activation id:' . $item->id . ' expiration_date: ' . $item->expiration_date . ' - user:' . $item->member->email);
        }
    }
}
