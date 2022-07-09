<?php

namespace RSolution\RCms\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RSolution\RCms\Events\SubscriptionWebhook;
use RSolution\RCms\Repositories\StripePlanRepository;
use RSolution\RCms\Repositories\SubscriptionRepository;
use RSolution\RCms\Services\StripeService;

class SubscriptionController extends ApiController
{
    private $subscriptionRepository;

    public function __construct()
    {
        $this->subscriptionRepository = new SubscriptionRepository;
    }

    public function create(Request $request)
    {
        $this->validateRequest($request, [
            'code' => 'required'
        ]);

        $result = $this->subscriptionRepository->createHostedPage(
            Auth::user(),
            $request->code,
            $request->cancel_url
        );

        return response()->json([
            'status' => $result ? 200 : 500,
            'data' => $result
        ]);
    }

    public function callback(Request $request)
    {
        $this->validateRequest($request, [
            'id' => 'required'
        ]);

        $result = $this->subscriptionRepository->callback(
            $request->id
        );

        if ($result) {
            return $result['aff'] && $result['transaction'] ?
                redirect()->route('rcms.thankyou')->with(['transaction' => $result['transaction']]) :
                redirect()->route('rcms.thankyou');
        } else
            return redirect()->route('rcms.404');
    }

    public function webhook(Request $request)
    {
        event(new SubscriptionWebhook(
            json_decode($request->getContent())
        ));

        return response()->json([
            'status' => 200
        ]);
    }

    public function index()
    {
        $data = $this->subscriptionRepository->getByUser(Auth::user()->id)->first();

        return response()->json([
            'status' => $data ? 200 : 500,
            'data' =>  $data
        ]);
    }

    public function createBillingPortal()
    {
        $data = $this->subscriptionRepository->createBillingPortal(Auth::user());

        return response()->json([
            'status' => $data ? 200 : 500,
            'data' =>  $data
        ]);
    }

    public function getPricing()
    {
        $data = (new StripePlanRepository)->getAllWithPlan(0, false);

        return response()->json([
            'status' => $data ? 200 : 500,
            'data' =>  $data
        ]);
    }

    public function scheduleCancel(Request $request)
    {
        $data = $this->subscriptionRepository->sheduleToCancel(
            Auth::user(),
            $request->cancel_at_period_end
        );

        return response()->json([
            'status' => $data ? 200 : 500,
            'data' =>  $data
        ]);
    }
}
