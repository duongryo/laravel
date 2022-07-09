<?php

namespace RSolution\RCms\Repositories;

class DashboardRepository
{
    public function getReport($request)
    {
        if (!isset($request->startDate) && !isset($request->endDate)) {
            $request->startDate = now()->format('Y-m-d');
            $request->endDate = now()->format('Y-m-d');
        }

        $userReport = (new UserRepository)->countMemberByPlan();

        $transactionReport = (new TransactionRepository)->getReportByType($request);

        $refund = (new TransactionRepository)->getReportByType($request, TransactionRepository::STATUS_CANCELLED);

        //Upgrade 
        $tRequest = $request;
        $tRequest->special_type = 'upgrade_deal';
        $userUpgradeDeal = (new TransactionRepository)->filter($tRequest, false);

        //Upgrade from trial
        $tRequest = $request;
        $tRequest->special_type = 'upgrade_deal_from_trial';
        $userUpgradeDealFromTrial = (new TransactionRepository)->filter($tRequest, false);


        //New users
        $newUsers = (new UserRepository)->getByCreatedAt(
            isset($request->startDate) ? $request->startDate : null,
            isset($request->endDate) ? $request->endDate : null,
        );

        return (object)[
            'user' => $userReport,
            'newUsers' => $newUsers,
            'transaction' => collect($transactionReport),
            'refund' => collect($refund),
            'userUpgradeDeal' => $userUpgradeDeal->count(),
            'userUpgradeDealFromTrial' => $userUpgradeDealFromTrial->count(),
        ];
    }
}
