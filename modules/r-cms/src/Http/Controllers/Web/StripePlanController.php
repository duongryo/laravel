<?php

namespace RSolution\RCms\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RSolution\RCms\Repositories\PlanRepository;
use RSolution\RCms\Repositories\StripePlanRepository;

class StripePlanController extends Controller
{
    const PAGE_LIMIT = 20;

    private $stripePlanRepository;

    public function __construct()
    {
        $this->stripePlanRepository = new StripePlanRepository;
    }

    public function index()
    {
        $data = $this->stripePlanRepository->getAllWithPlan(self::PAGE_LIMIT);
        $plans =  (new PlanRepository)->getAll();

        return view('rcms::pages.stripe_plans.index', ['data' => $data, 'plans' => $plans]);
    }

    public function store(Request $request)
    {
        try {
            $this->stripePlanRepository->create($request->input());
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['Stripe code đã tồn tại']);
        }

        return redirect()->back()->with('success', 'Thành công');
    }

    public function destroy($id)
    {
        $this->stripePlanRepository->delete($id);
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $this->stripePlanRepository->updateFillable($id, $request);
        return redirect()->back();
    }
}
