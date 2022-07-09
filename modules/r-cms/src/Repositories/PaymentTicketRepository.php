<?php

namespace RSolution\RCms\Repositories;

use RSolution\RCms\Models\PaymentTicket;
use RSolution\RCms\Models\Plan;
use RSolution\RCms\Models\User;
use RSolution\RCms\Services\StripeService;
use RSolution\RCms\Services\TelegramService;

class PaymentTicketRepository extends EloquentRepository
{
    const MONTH = 30;
    const YEAR = 365;

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return PaymentTicket::class;
    }

    public function createTicket($user, $planId, $method, $type = 'monthly', $coupon = null)
    {
        $plan = (new PlanRepository)->find($planId);
        if ($plan) {
            $ticket = $this->create([
                'user_id' => $user->id,
                'value' => $this->buildTicket($method, $plan, $user, $type, 1, $coupon)
            ]);
            $message = $user->email . ' đã tạo yêu cầu thanh toán với số tiền ' . number_format($ticket->value['amount']) . 'VND. Hình thức thanh toán ' . $method;
            (new TelegramService)->sendMessage($message);
            //
            return $ticket->value;
        }
    }

    protected function buildTicket(string $method, Plan $plan, User $user, string $type, int $quantity = 1, string $coupon = null)
    {
        $price = $type == 'monthly' ? $plan->monthly_price : $plan->anual_price * 12;
        $discount = 0;
        $code = $user->email . "-" . $plan->name . "-" . rand(10000, 99999);

        return [
            'method' => $method,
            'plan' => $plan,
            'quantity' => $quantity,
            'code' => $code,
            'type' => $type,
            'coupon' => $coupon,
            'price' => $price,
            'discount' => $discount,
            'amount' => $price - $discount,
            //
            'transaction_type' => $user->plan == $plan['id'] ? 'renew' : 'upgrade',
            'user_id' => $user->id,
            'from_plan' => $user->plan,
            'to_plan' => $plan['id'],
            'plan_time' => $type == 'monthly' ? $quantity * self::MONTH : self::YEAR,
            'note' => 'Autopayment ' . $code
        ];
    }

    public function filter($request)
    {
        $query = $this->model::query();

        $query->with('member');

        $range = $this->formatRange($request);

        if ($range)
            $query->whereDate('created_at', '>=', $range[0])->whereDate('created_at', '<=', $range[1]);

        return $query->latest()->paginate($request->limit ? $request->limit : 10);
    }

    private function formatRange($request)
    {
        if (!empty($request->startDate) && !empty($request->endDate))
            return [$request->startDate, $request->endDate];
        else
            return null;
    }

    public function approve($manager, $id)
    {
        $ticket = $this->find($id);
        if (!empty($ticket)) {
            $result = $ticket->value['transaction_type'] == 'renew' ?
                (new ActivationRepository)->renew(
                    $manager,
                    $ticket->value
                ) : (new ActivationRepository)->upgrade(
                    $manager,
                    $ticket->value
                );

            if ($result) {
                $ticket->status = 1;
                $ticket->save();
            }
        }
    }
}
