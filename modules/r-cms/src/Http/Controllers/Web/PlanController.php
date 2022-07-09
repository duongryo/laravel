<?php

namespace RSolution\RCms\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RSolution\RCms\Repositories\PlanRepository;
use RSolution\RCms\Repositories\LimitRepository;

class PlanController extends Controller
{
    const PAGE_LIMIT = 20;

    private $planRepository;

    public function __construct()
    {
        $this->planRepository = new PlanRepository;
    }

    public function index()
    {
        $data = $this->planRepository->paginate(self::PAGE_LIMIT);
        return view('rcms::pages.plans.index', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $this->planRepository->create($request->input());
        return redirect()->back();
    }

    public function destroy($id)
    {
        $this->planRepository->delete($id);
        (new LimitRepository)->deleteByKey('plan_id', $id);
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $this->planRepository->updateFillable($id, $request);
        return redirect()->back();
    }
}
