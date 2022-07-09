<?php

namespace RTech\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RTech\Repositories\TeamMembersRepository;

class TeamMembersController extends Controller
{
    protected $attributes = [
        'description' => 'Description',
        'name' => 'Name'
    ];

    private $teamMembersRepository;

    public function __construct()
    {
        $this->teamMembersRepository = new TeamMembersRepository;
    }

    public function index(Request $request)
    {
        $data = $this->teamMembersRepository->filter($request);
        return view('rtech::pages.team_members.index', ['data' => $data]);
    }

    public function create()
    {
        return view('rtech::pages.team_members.create');
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'bail|required|max:255',
            'images' => 'bail|required',
            'description'  => 'bail|required'
        ];
        Validator::make($request->all(), $rules, [], $this->attributes)->validate();
        
        $status = $this->teamMembersRepository->create($request->all());

        if($status)
            return redirect('/rcms/team-members')->with('status', 'Successfully create member.');
    }

    public function edit($id)
    {
        $data = $this->teamMembersRepository->find($id);
        return view('rtech::pages.team_members.edit', [
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'bail|required|max:255',
            'images' => 'bail|required',
            'description' => 'bail|required'
        ];
        Validator::make($request->all(), $rules, [], $this->attributes)->validate();

        $update = $this->teamMembersRepository->update($id, $request->all());
        if($update)
            return redirect('/rcms/team-members')->with('status', 'Successfully updated member.');
    }

    public function destroy($id)
    {
        $deleteStatus = $this->teamMembersRepository->delete($id);
        if($deleteStatus)
            return redirect('/rcms/team-members')->with('status', 'Successfully delete member.');
    }

    public function updateField(Request $request)
    {
        if(isset($request->created_at))
            $this->validate($request,[
                'created_at' => "required|date"
            ]);

        if(isset($request->status))
            $this->validate($request,[
                'status' => "required|in:".$this->teamMembersRepository::STATUS_ACTIVE.",".$this->teamMembersRepository::STATUS_INACTIVE
            ]);
        
        return  $this->teamMembersRepository->updateFillable($request->id,$request);
    }

    public function updateFieldCustom(Request $request)
    {
        
        $this->validate($request,[
            'field' => "required",
            'value' => "required"
        ]);

        $request->request->add([$request->field => $request->value]);
        $request->except(['field','value']);

        return $this->teamMembersRepository->updateFillable($request->id, $request );
    }
}