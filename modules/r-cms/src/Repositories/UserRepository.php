<?php

namespace RSolution\RCms\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

use RSolution\RCms\Models\User;

class UserRepository extends EloquentRepository
{
    const ROLE_ADMIN = 1;
    const ROLE_MANAGER = 2;
    const ROLE_MEMBER = 3;
    const ROLE_TESTER = 4;
    const STATUS_ACTIVE = 1;

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return User::class;
    }

    public function createAdmin($email, $password)
    {
        $admin = new $this->model;
        $admin->name = $email;
        $admin->email = $email;
        $admin->password = bcrypt($password);
        $admin->role = self::ROLE_ADMIN;
        $admin->email_verified_at = Carbon::now();
        $admin->save();
    }

    public function getRoleName()
    {
        switch (Auth::user()->role) {
            case self::ROLE_ADMIN:
                return 'Admin';
            case self::ROLE_MANAGER:
                return 'Manager';
            default:
                return 'Member';
        }
    }

    public function getMembers($limit = 10)
    {
        return $this->model->where('role', self::ROLE_MEMBER)->whereNotNull('email_verified_at')->paginate($limit);
    }

    public function searchMember($email, $limit = 10)
    {
        return $this->model->where('email', 'like', '%' . $email . '%')->paginate($limit);
    }

    public function updatePassword($userId, $oldPass, $newPass)
    {
        $user = $this->model->find($userId);
        if ($user && Hash::check($oldPass, $user->password)) {
            Auth::logoutOtherDevices($oldPass);

            $user->forceFill([
                'password' => Hash::make($newPass)
            ])->setRememberToken(Str::random(60));

            $user->save();

            return true;
        }
        return false;
    }

    public function changePlan($userId, $plan)
    {
        $user = $this->find($userId);
        if ($user) {
            $user->plan = $plan;
            $user->save();
        }
        return $user;
    }

    public function getProfile($user)
    {
        return $this->model
            ->where('id', $user->id)
            ->with([
                'activation' => function ($query) {
                    $query->select('user_id', 'expiration_date', DB::raw('DATE_FORMAT(expiration_date, "%d/%m/%Y") as date'));
                },
                'planInfo'
            ])
            ->first();
    }

    public function countMembers($createdAt = null)
    {
        return $createdAt ?
            $this->model->where('role', '!=', self::ROLE_ADMIN)->whereNotNull('email_verified_at')->whereDate('created_at', $createdAt)->count() :
            $this->model->where('role', '!=', self::ROLE_ADMIN)->whereNotNull('email_verified_at')->count();
    }

    public function getAdmin()
    {
        return $this->model->where('role', self::ROLE_ADMIN)->first();
    }

    public function updateLastLogin($userId)
    {
        $lastLogin = Carbon::now()->format('Y-m-d H:i:s');
        $this->model->where('id', $userId)->update(['last_login' => $lastLogin]);
    }

    public function countMemberByPlan()
    {
        return $this->model->select('plan', DB::raw('count(*) as total'))
            ->groupBy('plan')
            ->with([
                'planInfo' => function ($query) {
                    return $query->select('name', 'id');
                }
            ])
            ->where('role', '!=', self::ROLE_ADMIN)
            ->whereNotNull('email_verified_at')
            ->get();
    }

    public function filter($request)
    {
        $query = $this->model::query();

        $query->with('activation', 'planInfo');

        if (!empty($request->role))
            $query->where('role', $request->role);

        if (!empty($request->search))
            $query->where('email', 'like', '%' . $request->search . '%');

        if (!empty($request->plan))
            $query->where('plan', $request->plan);


        if (!empty($request->last_login))
            $query->whereDate('last_login', '<=', $request->last_login);

        if (!empty($request->created_at))
            $query->whereDate('created_at', $request->created_at);

        return $query
            //->whereNotNull('email_verified_at')
            ->paginate($request->limit ? $request->limit : 10);
    }

    public function addCredit(int $id, int $credit)
    {
        $user = $this->find($id);
        if ($user) {
            $user->credit = $user->credit + $credit;
            $user->save();
        }
    }

    public function getReffererUser($id)
    {
        return $this->model->where('ref_id', $id)->select('id', 'name', 'email')->get();
    }

    public function findByMail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function getByCreatedAt($from = null, $to = null)
    {
        $query = $this->model->query();

        if ($from)
            $query->whereDate('created_at', '>=', $from);

        if ($to)
            $query->whereDate('created_at', '<=', $to);

        return $query->latest()->get();
    }

    public function addKeywordValue(int $id, int $value)
    {
        $user = $this->find($id);
        if ($user) {
            $user->keyword_value = $user->keyword_value + $value;
            $user->save();
            return true;
        }
        return false;
    }

    public function addContentValue(int $id, int $value)
    {
        $user = $this->find($id);
        if ($user) {
            $user->content_value = $user->content_value + $value;
            $user->save();
            return true;
        }
        return false;
    }
}
