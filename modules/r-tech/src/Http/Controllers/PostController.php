<?php

namespace RTech\Http\Controllers;

use App\Http\Controllers\Controller;
use RTech\Repositories\PostCategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RTech\Repositories\PostRepository;

class PostController extends Controller
{
    protected $attributes = [
        'meta_desc' => 'Meta Description',
        'slug' => 'Slug',
        'name' => 'Name',
        'content' => 'Content'
    ];
    protected $messages = [
        'slug.without_spaces' => 'Slug must not have spaces.'
    ];

    private $postRepository;
    private $postCategoryRepository;

    public function __construct()
    {
        $this->postRepository = new PostRepository;
        $this->postCategoryRepository = new PostCategoryRepository;
    }

    public function index(Request $request)
    {
        $data = $this->postRepository->filter($request);
        return view('rtech::pages.posts.index', ['data' => $data]);
    }

    public function create()
    {
        $listCategory = $this->postCategoryRepository->getListCategory();
        return view('rtech::pages.posts.create', [
            'listCategory' => $listCategory
        ]);
    }

    /**
     * Store a new blog post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'bail|required|max:255|unique:tbl_r_tech_post',
            'slug' => 'bail|required|without_spaces|max:255|unique:tbl_r_tech_post',
            'images' => 'bail|required',
            'meta_desc'  => 'bail|required',
            'content' => 'bail|required'
        ];
        Validator::make($request->all(), $rules, $this->messages, $this->attributes)->validate();
        
        $status = $this->postRepository->create($request->all());

        if($status)
            return redirect('/rcms/post')->with('status', 'Successfully create post.');
    }

    public function edit($id)
    {
        $data = $this->postRepository->find($id);
        return view('rtech::pages.posts.edit', [
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'bail|required|max:255|unique:tbl_r_tech_post,name,' .$id,
            'slug' => 'bail|required|without_spaces|max:255|unique:tbl_r_tech_post,slug,' .$id,
            'meta_desc'  => 'bail|required',
            'images' => 'bail|required',
            'content' => 'bail|required'
        ];
        Validator::make($request->all(), $rules, $this->messages, $this->attributes)->validate();

        $update = $this->postRepository->update($id, $request->all());
        if($update)
            return redirect('/rcms/post')->with('status', 'Successfully updated post.');
    }

    public function destroy($id)
    {
        $deleteStatus = $this->postRepository->delete($id);
        if($deleteStatus)
            return redirect('/rcms/post')->with('status', 'Successfully delete post.');
    }

    public function updateField(Request $request)
    {
        if(isset($request->created_at))
            $this->validate($request,[
                'created_at' => "required|date"
            ]);

        if(isset($request->status))
            $this->validate($request,[
                'status' => "required|in:".$this->postRepository::STATUS_ACTIVE.",".$this->postRepository::STATUS_INACTIVE
            ]);
        
        return  $this->postRepository->updateFillable($request->id,$request);
    }

    public function updateFieldCustom(Request $request)
    {
        
        $this->validate($request,[
            'field' => "required",
            'value' => "required"
        ]);

        $request->request->add([$request->field => $request->value]);
        $request->except(['field','value']);

        return $this->postRepository->updateFillable($request->id, $request );
    }
}