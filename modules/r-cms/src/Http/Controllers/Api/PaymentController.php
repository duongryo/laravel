<?php

namespace RSolution\RCms\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RSolution\RCms\Repositories\ActivationRepository;
use RSolution\RCms\Repositories\ConfigRepository;
use RSolution\RCms\Repositories\LimitRepository;
use RSolution\RCms\Repositories\PaymentTicketRepository;
use RSolution\RCms\Repositories\UserRepository;

class PaymentController extends ApiController
{
    private $configRepository;

    public function __construct()
    {
        $this->configRepository = new ConfigRepository;
    }

    public function submit(request $request)
    {
        $this->validateRequest($request, [
            'key' => 'required',
            'total' => 'required',
        ]);

        $result = $this->checkAndUpgrade($request->key, Auth::user());

        return response()->json([
            'status' => $result ? 200 : 500,
            'data' => $result
        ]);
    }

    private function checkAndUpgrade($key, $user)
    {
        $plan = $this->getPlanInfo($key);
        if ($plan) {
            $credit = $plan['monthly']['credit'];
            if ($credit <= $user->credit) {
                $data = $this->buildData($user, $plan['plan'], 30);
                $manager = (new UserRepository)->getAdmin();
                //
                $result = $user->plan == $plan['plan']
                    ? (new ActivationRepository)->renew($manager, $data)
                    : (new ActivationRepository)->upgrade($manager, $data);
                //
                if ($result) {
                    (new UserRepository)->addCredit($user->id, -1 * $credit);
                    return true;
                }
            }
        }
        return false;
    }

    private function getPlanInfo($key, $type = 'monthly')
    {
        $data = $this->configRepository->findByKey('plan_price');
        if (!empty($data->value)) {
            $temp = collect($data->value);
            return $temp->where('key', $key)->first();
        }
    }

    private function createPlan()
    {
        $temp = [
            [
                'title' => 'Premium',
                'key' => 'premium',
                'plan' => 2,
                'monthly' => [
                    'credit' => 5,
                    'vnd' => 150000,
                    'usd' => 7,
                ]
            ],
            [
                'title' => 'Platinum',
                'key' => 'platinum',
                'plan' => 3,
                'monthly' => [
                    'credit' => 15,
                    'vnd' => 450000,
                    'usd' => 10,
                ]
            ]
        ];
        $this->configRepository->create([
            'key' => 'plan_price',
            'value' => json_encode($temp)
        ]);
    }

    private function buildData($user, $plan, $time = 30)
    {
        return [
            'user_id' => $user->id,
            'price' => 0,
            'from_plan' => $user->plan,
            'to_plan' => $plan,
            'plan_time' => $time,
            'note' => 'Credit'
        ];
    }

    public function info()
    {
        return response()->json([
            'status' => 200,
            'data' =>  $this->configRepository->findByKey('plan_price')->value
        ]);
    }

    public function getPlans()
    {
        $data = (new LimitRepository)->getData();

        return response()->json([
            'status' => 200,
            'data' =>  $data
        ]);
    }

    public function createTicket(request $request)
    {
        $this->validateRequest($request, [
            'plan_id' => 'required',
            'method' => 'required',
            'type' => 'required'
        ]);

        $result = (new PaymentTicketRepository)->createTicket(
            Auth::user(),
            $request->plan_id,
            $request->method,
            $request->type,
            $request->coupon
        );

        return response()->json([
            'status' => $result ? 200 : 500,
            'data' => $result
        ]);
    }
}
