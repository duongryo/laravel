<?php

namespace RTech\Http\Controllers;

use App\Http\Controllers\Controller;
use RTech\Repositories\PostCategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostCategoryController extends Controller
{
    protected $attributes = [
        'slug' => 'Slug',
        'name' => 'Name',
    ];
    protected $messages = [
        'slug.without_spaces' => 'Slug must not have spaces.'
    ];

    private $postCategoryRepository;

    public function __construct()
    {
        $this->postCategoryRepository = new PostCategoryRepository;
    }

    public function index()
    {
        $data = $this->postCategoryRepository->getAll();
        return view('rtech::pages.categories.index', ['data' => $data]);
    }

    public function create()
    {
        return view('rtech::pages.categories.create');
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'bail|required|unique:tbl_r_tech_post_category|max:255',
            'slug' => 'bail|required|without_spaces|max:255|unique:tbl_r_tech_post_category',
        ];
        Validator::make($request->all(), $rules, $this->messages, $this->attributes)->validate();

        $status = $this->postCategoryRepository->create($request->all());

        if($status)
            return redirect('/rcms/category')->with('status', 'Successfully create category.');
    }

    public function edit($id)
    {
        $data = $this->postCategoryRepository->find($id);
        return view('rtech::pages.categories.edit', ['data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'bail|required|max:255|unique:tbl_r_tech_post_category,name,' .$id,
            'slug' => 'bail|required|without_spaces|max:255|unique:tbl_r_tech_post_category,slug,' .$id
        ];

        Validator::make($request->all(), $rules, $this->messages, $this->attributes)->validate();

        $update = $this->postCategoryRepository->update($id, $request->all());
        if($update)
            return redirect('/rcms/category')->with('status', 'Successfully updated category.');
    }

    public function destroy($id)
    {
        $deleteStatus = $this->postCategoryRepository->delete($id);
        if($deleteStatus)
            return redirect('/rcms/category')->with('status', 'Successfully delete category.');
    }

    public function updateField(Request $request)
    {
        
        $this->validate($request,[
            'field' => "required",
            'value' => "required"
        ]);

        $request->request->add([$request->field => $request->value]);
        $request->except(['field','value']);

        return $this->postCategoryRepository->updateFillable($request->id, $request );
    }
}