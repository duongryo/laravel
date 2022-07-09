<?php

namespace RTech\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RTech\Repositories\ProductRepository;

class ProductController extends Controller
{
    protected $attributes = [
        'description' => 'Description',
        'link' => 'Link',
        'name' => 'Name',
        'label' => 'Label',
    ];
    protected $messages = [
        'link.url' => 'The link is not a valid URL'
    ];

    private $productRepository;

    public function __construct()
    {
        $this->productRepository = new ProductRepository;
    }

    public function index(Request $request)
    {
        $data = $this->productRepository->filter($request);
        return view('rtech::pages.products.index', ['data' => $data]);
    }

    public function create()
    {
        return view('rtech::pages.products.create');
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'bail|required|max:255|unique:tbl_r_tech_product',
            'link' => 'bail|required|url',
            'logo' => 'bail|required',
            'images' => 'bail|required',
            'label' => 'bail|required|max:255',
            'description'  => 'bail|required'
        ];
        Validator::make($request->all(), $rules, $this->messages, $this->attributes)->validate();
        
        $status = $this->productRepository->create($request->all());

        if($status)
            return redirect('/rcms/product')->with('status', 'Successfully create product.');
    }

    public function edit($id)
    {
        $data = $this->productRepository->find($id);
        return view('rtech::pages.products.edit', [
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'bail|required|max:255|unique:tbl_r_tech_product,name,' .$id,
            'link' => 'bail|required|url',
            'logo' => 'bail|required',
            'images' => 'bail|required',
            'label' => 'bail|required|max:255',
            'description' => 'bail|required'
        ];
        Validator::make($request->all(), $rules, $this->messages, $this->attributes)->validate();

        $update = $this->productRepository->update($id, $request->all());
        if($update)
            return redirect('/rcms/product')->with('status', 'Successfully updated product.');
    }

    public function destroy($id)
    {
        $deleteStatus = $this->productRepository->delete($id);
        if($deleteStatus)
            return redirect('/rcms/product')->with('status', 'Successfully delete product.');
    }

    public function updateField(Request $request)
    {
        if(isset($request->created_at))
            $this->validate($request,[
                'created_at' => "required|date"
            ]);

        if(isset($request->status))
            $this->validate($request,[
                'status' => "required|in:".$this->productRepository::STATUS_ACTIVE.",".$this->productRepository::STATUS_INACTIVE
            ]);
        
        return  $this->productRepository->updateFillable($request->id,$request);
    }

    public function updateFieldCustom(Request $request)
    {
        
        $this->validate($request,[
            'field' => "required",
            'value' => "required"
        ]);

        $request->request->add([$request->field => $request->value]);
        $request->except(['field','value']);

        return $this->productRepository->updateFillable($request->id, $request );
    }
}