<?php

namespace RSolution\RCms\Listeners;

use Illuminate\Auth\Events\Verified;
use RSolution\RCms\Repositories\ActivationRepository;
use RSolution\RCms\Repositories\ConfigRepository;
use RSolution\RCms\Repositories\PlanRepository;
use RSolution\RCms\Repositories\UserRepository;
use RSolution\RCms\Services\TelegramService;

class FreeTrial
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Verified  $event
     * @return void
     */
    public function handle(Verified $event)
    {
        $configuration = (new ConfigRepository)->findByKey('free_trial');
        $manager = (new UserRepository)->getAdmin();
        if (
            $manager &&
            $configuration &&
            $configuration->value['plan_id'] &&
            $configuration->value['plan_time'] &&
            $event->user->plan == PlanRepository::PLAN_FREE
        ) {
            (new ActivationRepository)->upgrade($manager, $this->buildData($event->user, $configuration));
        }
    }

    private function buildData($user, $configuration)
    {
        $note = 'FreeTrial ' . $configuration->value['plan_time'] . ' ngày.';
        if (!empty($user->agent))
            $note = $note . ' Người giới thiệu: ' . $user->agent->email;
        return [
            'user_id' => $user->id,
            'amount' => 0,
            'price' => 0,
            'from_plan' => PlanRepository::PLAN_FREE,
            'to_plan' => $configuration->value['plan_id'],
            'plan_time' => $configuration->value['plan_time'],
            'method' => 'free_trial',
            'note' => $note
        ];
    }
}
