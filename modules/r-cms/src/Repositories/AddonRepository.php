<?php

namespace RSolution\RCms\Repositories;

use RSolution\RCms\Models\Addon;

class AddonRepository extends EloquentRepository
{
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return Addon::class;
    }

    public function updateAddons($rcmsSubscription, $addons)
    {
        $this->model->where('subscription_id', $rcmsSubscription->id)->delete();
        if ($rcmsSubscription->status == SubscriptionRepository::STATUS_LIVE) {
            $temp = [];
            foreach ($addons as $item) {
                $temp[] = [
                    'subscription_id' => $rcmsSubscription->id,
                    'addon' => $item->addon,
                    'quantity' => $item->quantity,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            };
            $this->insert($temp);
        }
    }

    public function checkEnableAddon($user, $addon)
    {
        if (
            $user->subscription &&
            $user->subscription->status == SubscriptionRepository::STATUS_LIVE
        ) {
            $flag = $user->subscription->addons->where('addon', $addon)->isNotEmpty();
            return $flag;
        } else
            return false;
    }
}
