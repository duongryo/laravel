<?php

namespace RTech\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RTech\Repositories\SystemConfigRepository;

class SystemConfigController extends Controller
{
    public function __construct()
    {
        $this->systemRepository = new SystemConfigRepository;
    }

    protected $attributes = [
        'field_name' => 'Field Name',
        'key_name' => 'Key Name',
    ];
    protected $messages = [
        'key_name.without_spaces' => 'Key Name must not have spaces.'
    ];

    private $systemRepository;

    public function index()
    {
        $data = $this->systemRepository->getAll();
        return view('rtech::pages.system_config.index', ['data' => $data]);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::extend('without_spaces', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
        });

        $rules = [
            'field_name' => 'bail|required|max:255|unique:tbl_r_tech_system_config',
            'key_name' => 'bail|required|without_spaces|max:255|unique:tbl_r_tech_system_config'
        ];
        Validator::make($request->all(), $rules, $this->messages, $this->attributes)->validate();
        
        $status = $this->systemRepository->create($request->all());

        if($status)
            return redirect('/rcms/system-config')->with('status', 'Successfully create config.');
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'value' => 'bail|required'
        ];
        Validator::make($request->all(), $rules, $this->messages, $this->attributes)->validate();

        $update = $this->systemRepository->update($id, $request->all());
        if($update)
            return redirect('/rcms/system-config')->with('status', 'Successfully updated.');
    }
}