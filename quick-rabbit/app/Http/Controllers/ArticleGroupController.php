<?php
/*
  ##############################################################################
  # AI Powered Customer Support Portal and Knowledgebase System
  ##############################################################################
  # AUTHOR:		Door Soft
  ##############################################################################
  # EMAIL:		info@doorsoft.co
  ##############################################################################
  # COPYRIGHT:		RESERVED BY Door Soft
  ##############################################################################
  # WEBSITE:		https://www.doorsoft.co
  ##############################################################################
  # This is Article Group Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\ArticleGroup;
use App\Model\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(appTheme() == 'multiple'){
            $obj = ArticleGroup::live()->latest('sort_id')->get();
        }else{
            $product_id = ProductCategory::live()->where('type', 'single')->pluck('id');
            $obj = ArticleGroup::live()->whereIn('product_category', $product_id)->latest('sort_id')->get();
        }
        return view('article-group.index', compact('obj'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product_category = ProductCategory::where('del_status', 'Live')->type()->pluck('title', 'id');
        return view('article-group.addEditArticleGroup', compact('product_category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required|string|max:191',
            'product_category' => 'required',
            'image' => 'mimes:jpg,jpeg,png|max:5120'
        ],[
            'title.required' => __('index.title_required'),
            'title.max' => __('index.title.max_191'),
            'product_category.required' => __('index.product_category_required'),
            'image.max' => __('index.file_size_required'),
        ]);

        $obj = new ArticleGroup();
        $obj->title = $request->title;
        $product_name = productCatName($request->product_category);
        $slug = $product_name.'-'.$request->title;
        $obj->slug = Str::slug($slug);
        $obj->product_category = $request->product_category;
        $obj->description = $request->description;
        $obj->sort_id = ProductCategory::max('sort_id') + 1;

        if(!empty($request->file('image'))) {
            $obj->icon = uploadImage($request->file('image'),'article_group/');
        }

        if ($obj->save()){
            return redirect('article-group')->with(saveMessage());
        }else{
            return redirect()->back()->with(waringMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Code here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = encrypt_decrypt($id, 'decrypt');
        $obj = ArticleGroup::find($id);
        $product_category = ProductCategory::where('del_status', 'Live')->type()->pluck('title', 'id');
        return view('article-group.addEditArticleGroup', compact('product_category', 'obj'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'title' => 'required|string|max:191',
            'product_category' => 'required',
            'image' => 'mimes:jpg,jpeg,png|max:5120',
        ],[
            'title.required' => __('index.title_required'),
            'title.max' => __('index.title.max_191'),
            'product_category.required' => __('index.product_category_required'),
        ]);

        $id = encrypt_decrypt($id, 'decrypt');
        $obj = ArticleGroup::find($id);
        $obj->title = $request->title;
        $product_name = productCatName($request->product_category);
        $slug = $product_name.'-'.$request->title;
        $obj->slug = Str::slug($slug);
        $obj->product_category = $request->product_category;
        $obj->description = $request->description;

        if(!empty($request->file('image'))) {
            $obj->icon = uploadImage($request->file('image'),'article_group/');
        }

        if ($obj->save()){
            return redirect('article-group')->with(updateMessage());
        }else{
            return redirect()->back()->with(waringMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = encrypt_decrypt($id, 'decrypt');
        $obj = ArticleGroup::find($id);
        $obj->del_status = "Deleted";
        $obj->save();
        return redirect('article-group')->with(deleteMessage());
    }

    /**
     * Sorting page
     */
    public function shortPage () {
        $results = ArticleGroup::live()->get();
        $products = ProductCategory::live()->type()->get();
        return view('article-group.sort_article_group',compact('products','results'));
    }

    /**
     * Sort Data
     */
    public function sortData(Request $request) {
        if($request->has('ids')){
            $arr = explode(',',$request->input('ids'));
            foreach($arr as $sortOrder => $id){
                $row = ArticleGroup::find($id);
                $row->sort_id = $sortOrder+1;
                $row->save();
            }
            return ['success'=>true,'message'=>'Updated'];
        }
    }
}
