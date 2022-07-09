<?php

namespace RSolution\RCms\Http\Controllers\Web\Config;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RSolution\RCms\Repositories\ConfigRepository;

abstract class ConfigController extends Controller
{
    const PAGE_LIMIT = 10;
    protected $configRepository;
    protected $view;
    protected $key;

    public function __construct()
    {
        $this->configRepository = new ConfigRepository;
        $this->setView();
        $this->setKey();
    }

    abstract public function getView();
    abstract public function getKey();

    public function setView()
    {
        $this->view = $this->getView();
    }

    public function setKey()
    {
        $this->key = $this->getKey();
    }

    public function index()
    {
        $data = $this->configRepository->getByKey($this->key, self::PAGE_LIMIT);

        return view($this->view, ['data' => $data]);
    }

    public function store(Request $request)
    {
        $this->configRepository->create([
            'key' => $this->key,
            'value' => $request->except('_token')
        ]);
        return redirect()->back()->with('success', 'Thành công');
    }

    public function destroy($id)
    {
        $this->configRepository->delete($id);
        return redirect()->back()->with('success', 'Thành công');
    }

    public function update(Request $request, $id)
    {
        $this->configRepository->update($id, [
            'value' => $request->except(['_token', '_method'])
        ]);
        return redirect()->back()->with('success', 'Thành công');
    }
}
