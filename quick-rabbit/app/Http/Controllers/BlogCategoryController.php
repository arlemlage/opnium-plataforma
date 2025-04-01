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
  # This is Blog Category Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = __('index.category_list');
        $results = BlogCategory::live()->oldest('id')->get();
        return view('blog.category_list',compact('results','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = __('index.add_category');
        return view('blog.category_add_edit',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
        [
            'title' => 'required|max:100',
            'description' => 'max:100'
        ],
        [
            'title.required' => __('index.title_required'),
        ]);
        $row = new BlogCategory();
        $row->title = $request->title;
        $row->slug = Str::slug($request->title);
        $row->description = $request->description;
        $row->created_by = Auth::id();
        $row->save();
        return redirect()->route('blog-categories.index')->with(saveMessage());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = __('index.edit_category');
        $data = BlogCategory::findOrFail(encrypt_decrypt($id,'decrypt'));
        return view('blog.category_add_edit',compact('title','data'));
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
        $this->validate($request,
        ['title' => 'required|max:100',
        'description' => 'max:100'],[
            'title.required' => __('index.title_required')
        ]);
        $row = BlogCategory::findOrFail(encrypt_decrypt($id,'decrypt'));
        $row->title = $request->title;
        $row->slug = Str::slug($request->title);
        $row->description = $request->description;
        $row->created_by = Auth::id();
        $row->save();
        return redirect()->route('blog-categories.index')->with(updateMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BlogCategory::findOrFail(encrypt_decrypt($id,'decrypt'))->update(['del_status' => 'DELETED']);
        return redirect()->route('blog-categories.index')->with(updateMessage("Information has been deleted successfully !"));
    }
}
