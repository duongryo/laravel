<?php

namespace RSolution\RCms\Repositories;

use Carbon\Carbon;
use RSolution\RCms\Models\DailyReport;
use RSolution\RCms\Services\TelegramService;

class DailyReportRepository extends EloquentRepository
{
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return DailyReport::class;
    }

    public function createReport(Carbon $date)
    {
        $usage = $this->buildUsageReport($date);
        $system = $this->buildSystemReport($date);
        return $this->model->updateOrcreate(
            [
                'date' => $date->format('Y-m-d'),
            ],
            [
                'usage' => $usage,
                'system' => $system
            ]
        );
    }

    private function buildUsageReport($date)
    {
        $temp = (new ModuleRepository)->getDailyReport($date);
        $report = [];
        foreach ($temp as $item) {
            $report[] = [
                'key' => $item->module,
                'value' => $item->total
            ];
        }

        return $report;
    }

    private function buildSystemReport($date)
    {
        $userRepository = new UserRepository;
        $report = [];
        $report[] = [
            'key' => 'new_users',
            'value' => $userRepository->countMembers($date)
        ];
        $overview = (new UserRepository)->countMemberByPlan()->toArray();
        foreach ($overview as $item) {
            $planName = str_replace(" ", "_", $item['plan_info']['name'] . "_users");
            $report[] = [
                'key' => strtolower($planName),
                'value' => $item['total']
            ];
        }
        $report[] = [
            'key' => 'expired_users',
            'value' => count((new ActivationRepository)->getExpired())
        ];
        $report[] = [
            'key' => 'total_user',
            'value' => $userRepository->countMembers()
        ];

        return $report;
    }

    public function sendTelegramReport(Carbon $date, bool $compare = true)
    {
        $report = $this->model->where('date', $date->format('Y-m-d'))->first();

        if ($compare)
            $comparision = $this->model->where('date', $date->copy()->subDay()->format('Y-m-d'))->first();

        $usage = $this->buildReportMessage(
            'DAILY USAGE',
            $date,
            $report->usage,
            !empty($comparision) ? $comparision->usage : null
        );
        $system = $this->buildReportMessage(
            'ACCUMULATIVE REPORT',
            $date,
            $report->system,
            !empty($comparision) ? $comparision->system : null
        );
        $telegramService = new TelegramService;
        $telegramService->sendDailyReport($usage);
        $telegramService->sendDailyReport($system);
    }

    private function buildReportMessage($title, $date, $report, $comparision = null)
    {
        if ($comparision)
            $comparision = collect($comparision);

        $msg = "<b>{$title}</b>\n";
        $msg .= "<b>Date: {$date->format('Y-m-d')} </b>\n\n";
        foreach ($report as $item) {
            $title = ucfirst(str_replace("_", " ", $item['key']));
            $total = number_format($item['value']);
            if ($comparision) {
                $preItem = $comparision->where('key', $item['key'])->first();
                $growth = $preItem && $preItem['value'] ? round(($item['value'] - $preItem['value']) / $preItem['value'] * 100, 2) : 100;
                $msg .= "<b>{$title}</b> : {$total} ({$growth}%)\n";
            } else {
                $msg .= "<b>{$title}</b> : {$total}\n";
            }
        }

        return $msg;
    }
}
