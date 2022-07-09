<?php

namespace RSolution\RCms\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use RSolution\RCms\Repositories\ActivationRepository;
use RSolution\RCms\Repositories\DailyReportRepository;
use RSolution\RCms\Services\TelegramService;

class DailyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rcms:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily Update RCMS';

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
        try {
            $this->createSystemReport();
        } catch (\Exception $e) {
            (new TelegramService)->sendLog($e->getMessage());
        }

        $this->downgrade();
    }

    private function createSystemReport()
    {
        $date = Carbon::now()->subDay();

        $dailyReportRepository = (new DailyReportRepository);
        $dailyReportRepository->createReport($date);
        $dailyReportRepository->sendTelegramReport($date);
    }

    private function downgrade()
    {
        $activationRepository = new ActivationRepository;
        $expireds = $activationRepository->getExpired();
        $telegramService = (new TelegramService);
        foreach ($expireds as $expired) {
            try {
                $activationRepository->downgrade($expired->id);
            } catch (\Exception $e) {
                $telegramService->sendLog("User downgrade error:" . $expired->user_id);
                $expired->delete();
            }
        }
    }
}
