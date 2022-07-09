<?php

namespace RSolution\RCms\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RSolution\RCms\Repositories\LimitRepository;
use RSolution\RCms\Repositories\ModuleRepository;

class ModuleController extends Controller
{
    const PAGE_LIMIT = 20;

    private $moduleRepository;

    public function __construct()
    {
        $this->moduleRepository = new ModuleRepository;
    }

    public function index()
    {
        $data = $this->moduleRepository->paginate(self::PAGE_LIMIT);
        return view('rcms::pages.modules.index', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'module' => 'required'
        ]);
        $this->moduleRepository->create($request->input());
        return redirect()->back();
    }

    public function destroy($id)
    {
        $this->moduleRepository->delete($id);
        (new LimitRepository)->deleteByKey('module_id', $id);
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $this->moduleRepository->updateFillable($id, $request);
        return redirect()->back();
    }
}
