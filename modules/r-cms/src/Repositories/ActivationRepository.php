<?php

namespace RSolution\RCms\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use RSolution\RCms\Events\UserActivationExpired;
use RSolution\RCms\Events\UserActivationRenew;
use RSolution\RCms\Events\UserActivationUpgrade;
use RSolution\RCms\Models\Activation;
use RSolution\RCms\Models\User;

class ActivationRepository extends EloquentRepository
{
    public function getModel()
    {
        return Activation::class;
    }

    /**
     * Create upgrade activation
     *
     * @param [type] $data [            
     * 'user_id' => 'required',
     * 'price' => 'required',
     * 'from_plan' => 'required',
     * 'to_plan' => 'required',
     * 'plan_time' => 'required',
     * 'note' => string|no required ]
     * @return mixed
     */
    public function upgrade(User $manager, array $data)
    {
        /*
        $currentActivation = $this->model->where('user_id', $data['user_id'])->first();
        if ($currentActivation)
            $this->downgrade($currentActivation->id);
        */
        //Delete current Activation
        $this->model->where('user_id', $data['user_id'])->delete();
        //
        $activation = $this->create([
            'user_id' => $data['user_id'],
            'plan_id' => $data['to_plan'],
            'expiration_date' => $this->calculateExpirationDate($data['plan_time'])
        ]);
        if ($activation) {
            $data = array_merge($data, [
                'type' => 'upgrade',
                'activation_id' => $activation->id,
                'manager_id' => $manager->id,
            ]);

            $user = (new UserRepository)->changePlan($data['user_id'],  $data['to_plan']);

            $transaction = $this->createTransaction($data, 'upgrade', $activation, $manager);

            event(new UserActivationUpgrade($user, $transaction));

            return $transaction;
        }
    }

    /**
     * Create renew activation
     *
     * @param [type] $data [            
     * 'user_id' => 'required',
     * 'price' => 'required',
     * 'from_plan' => 'required',
     * 'to_plan' => 'required',
     * 'plan_time' => 'required',
     * 'note' => string|no required ]
     * @return mixed
     */
    public function renew(User $manager, array $data)
    {
        $activation = $this->model->where('user_id', $data['user_id'])->first();
        if ($activation && $activation->plan_id == $data['to_plan']) {
            //
            $activation->expiration_date = $this->calculateNewExpirationDate(
                $activation->expiration_date,
                $data['plan_time']
            );
            $activation->save();

            $user = (new UserRepository)->changePlan($data['user_id'],  $data['to_plan']);

            $transaction = $this->createTransaction($data, 'renew', $activation, $manager);

            event(new UserActivationRenew($user, $transaction));

            return $transaction;
        }
    }

    private function createTransaction($data, $type, $activation, $manager)
    {
        if (!isset($data['amount']))
            $amount = !empty($data['discount']) ? $data['price'] - $data['discount'] : $data['price'];
        else
            $amount = $data['amount'];

        $data = array_merge($data, [
            'type' => $type,
            'activation_id' => $activation->id,
            'manager_id' => $manager->id,
            'amount' => $amount
        ]);

        return (new TransactionRepository)->create($data);
    }

    private function calculateExpirationDate($planTime)
    {
        return Carbon::now()->addDays($planTime)->format('Y-m-d');
    }

    private function calculateNewExpirationDate($currentExpirationDate, $planTime)
    {
        return Carbon::parse($currentExpirationDate)->addDays($planTime)->format('Y-m-d');
    }

    public function getExpired($date = null)
    {
        return $date ?
            $this->model->whereDate('expiration_date', $date)->get() :
            $this->model->whereDate('expiration_date', '<', Carbon::now())->get();
    }

    /**
     * Downgrade activation 
     *
     * @param integer $id activation ID
     * @return void
     */
    public function downgrade(int $id, bool $isRefund = false)
    {
        $userRepository = new UserRepository;
        $expiredActivation = $this->find($id);
        $expiredPlan = $expiredActivation->member->plan;
        $user = $userRepository->changePlan($expiredActivation->user_id, PlanRepository::PLAN_FREE);
        $expiredActivation->delete();
        if ($user)
            event(new UserActivationExpired($user, $expiredPlan, $isRefund));
    }

    /**
     * get all Nearly Expired Members
     * Input : startDate, endDate
     * return array userIds
     */
    public function getNearlyExpiredMembers($startDate, $endDate)
    {
        return $this->model->whereBetween('expiration_date', [$startDate, $endDate])->distinct()->pluck('user_id')->toArray();
    }

    /**
     * get all Expired Members
     * return array userIds
     */
    public function getExpiredMembers()
    {
        $today = Carbon::now()->format('Y-m-d');
        return $this->model->where('expiration_date', '<', $today)->distinct()->pluck('user_id')->toArray();
    }
}
