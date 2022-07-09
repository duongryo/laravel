<?php

namespace RSolution\RCms\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RSolution\RCms\Repositories\LimitRepository;

class LimitController extends Controller
{
    const PAGE_LIMIT = 20;

    private $limitRepository;


    public function __construct()
    {
        $this->limitRepository = new LimitRepository;
    }

    public function index()
    {
        $data = $this->limitRepository->getData();

        return view('rcms::pages.limits.index', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'limit' => 'required'
        ]);

        $this->limitRepository->updateOrCreate($request->limit);

        return redirect()->back()->with(['success' => 'Thành công']);
    }

    public function destroy($id)
    {
        $this->limitRepository->delete($id);

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $this->limitRepository->updateFillable(
            $id,
            $request
        );

        return redirect()->back();
    }
}
