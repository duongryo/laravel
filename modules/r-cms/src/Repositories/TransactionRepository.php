<?php

namespace RSolution\RCms\Repositories;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use RSolution\RCms\Events\TransactionCreated;
use RSolution\RCms\Events\TransactionDestroyed;
use RSolution\RCms\Models\Transaction;
use RSolution\RCms\Services\TelegramService;

class TransactionRepository extends EloquentRepository
{
    const STATUS_LIVE = 1;
    const STATUS_CANCELLED = 0;
    const TYPE_UPGRADE = 'upgrade';
    const TYPE_RENEW = 'renew';

    public function getModel()
    {
        return Transaction::class;
    }

    public function create($data)
    {
        $transaction = $this->model->create($data);
        event(new TransactionCreated(
            $this->find($transaction->id)
        ));

        return $transaction;
    }

    public function destroy($id)
    {
        $transaction = $this->find($id);
        if ($transaction && $transaction->activation) {
            (new ActivationRepository)->downgrade($transaction->activation->id, true);
            $transaction->status = self::STATUS_CANCELLED;
            $transaction->save();
            event(new TransactionDestroyed($transaction));
            //
            return true;
        }
        return false;
    }

    public function filter($request, $paginate = true)
    {
        $query = $this->model::query();

        $query->with(['member', 'manager', 'activation', 'toPlanInfo', 'fromPlanInfo']);

        $range = $this->formatRange($request);

        if (isset($request->special_type)) {
            if ($request->type == 'first_upgrade')
                $query->groupBy('user_id')->select('*', DB::raw('count(*) as total'))->having('total', 1);

            if ($request->special_type == 'expired_soon' && $range)
                $query->whereHas('activation', function ($q) use ($range) {
                    return $q->whereDate('expiration_date', '>=', $range[0])->whereDate('expiration_date', '<=', $range[1]);
                });

            if ($request->special_type == 'upgrade_deal')
                $query->where('method', '!=', 'free_trial')->where('status', self::STATUS_LIVE);

            if ($request->special_type == 'upgrade_deal_from_trial') {
                $configuration = (new ConfigRepository)->findByKey('free_trial');
                if (
                    $configuration &&
                    $configuration->value['plan_id']
                )
                    $query
                        ->where('method', '!=', 'free_trial')
                        ->where('from_plan', $configuration->value['plan_id'])
                        ->where('status', self::STATUS_LIVE);
            }
        } else {
            if (isset($request->from_plan))
                $query->where('from_plan', $request->from_plan);

            if (isset($request->to_plan))
                $query->where('to_plan', $request->to_plan);

            if (isset($request->method))
                $query->where('method', $request->method);

            if (isset($request->status)) {
                $query->where('status', $request->status);
            }

            if (isset($request->note)) {
                $query->where('note', 'like', '%' . $request->note . '%');
            }
        }

        if ($range)
            $query->whereDate('created_at', '>=', $range[0])->whereDate('created_at', '<=', $range[1]);


        $query->latest();

        return $paginate ? $query->paginate($request->limit ? $request->limit : 10) : $query->get();
    }

    private function formatRange($request)
    {
        if (!empty($request->startDate) && !empty($request->endDate))
            return [$request->startDate, $request->endDate];
        else
            return null;
    }

    public function getDataOverview()
    {
        $data = $this->model->latest()->get();

        $user = $this->model->groupBy('user_id')
            ->selectRaw('*, sum(amount) as totalAmount, count(*) as totalTransaction')
            ->get();

        $plan = $this->model->groupBy('to_plan')
            ->selectRaw('to_plan, count(*) as totalActived')
            ->get();

        $coupon = $this->model->groupBy('coupon')
            ->selectRaw('coupon, count(*) as totalUsedCoupon')
            ->whereNotNull('coupon')
            ->get();

        return (object) [
            'totalAmount'         => $data->sum('amount'),
            'totalTransaction'    => $data->count(),
            'userPayMost'         => $user->sortByDesc('totalAmount')->first(),
            'userMostTransaction' => $user->sortByDesc('totalTransaction')->first(),
            'mostUsedPlan'        => $plan->sortByDesc('totalActived')->first(),
            'leastUsedPlan'       => $plan->sortBy('totalActived')->first(),
            'mostUsedCoupon'      => $coupon->sortByDesc('totalUsedCoupon')->first(),
            'chartTransaction'    => $this->getDataChartTransaction($data)
        ];
    }

    private function getDataChartTransaction($data, $limit = 7)
    {
        return $data->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->toDateString();
        })->map->sum('amount')->take($limit)->reverse()->toArray();
    }

    public function findByInvoiceId($invoiceId)
    {
        return $this->model->where('invoice_id', $invoiceId)->first();
    }

    public function getBySubscriptionId($subscriptionId, $onlyRoot = false)
    {
        return $onlyRoot ?
            $this->model->where('subscription_id', $subscriptionId)->first() :
            $this->model->where('subscription_id', $subscriptionId)->get();
    }

    public function getReportByType($request, $status = self::STATUS_LIVE)
    {
        $query = $this->model->query();

        $range = $this->formatRange($request);

        if ($range)
            $query->whereDate('created_at', '>=', $range[0])->whereDate('created_at', '<=', $range[1]);

        $query->groupBy('method');

        $query->select('method', DB::raw('count(*) as total'));

        $query->where('status', $status);

        return $query->latest()->get();
    }

    public function getByUserWithPlan($userId)
    {
        return $this->model->where('user_id', $userId)->with([
            'fromPlanInfo' => function ($q) {
                return $q->select('id', 'name')->get();
            },
            'toPlanInfo' => function ($q) {
                return $q->select('id', 'name')->get();
            }
        ])->latest()->get();
    }
}
