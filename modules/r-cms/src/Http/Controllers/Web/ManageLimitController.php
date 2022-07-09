<?php

namespace RSolution\RCms\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RSolution\RCms\Repositories\LimitRepository;

class ManageLimitController extends Controller
{
    const PAGE_LIMIT = 20;

    private $limitRepository;

    public function __construct(LimitRepository $limitRepository)
    {
        $this->limitRepository = $limitRepository;
    }

    public function index()
    {
        $data = $this->limitRepository->paginate(self::PAGE_LIMIT);
        return view('rcms::pages.manage_limit.index', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'module' => 'required'
        ]);
        $this->limitRepository->create($request->input());
        return redirect()->back();
    }

    public function destroy($id)
    {
        $this->limitRepository->delete($id);
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $this->limitRepository->updateFillable($id, $request);
        return redirect()->back();
    }
}
