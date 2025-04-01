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
  # This is Pages Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\ArticleGroup;
use App\Model\Pages;
use App\Model\ProductCategory;
use App\Model\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $obj = Pages::live()->oldest()->get();
        return view('pages.index', compact('obj'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tag = Tag::where('del_status', 'Live')->pluck('title', 'id');
        $media_groups = ProductCategory::live()->type()->get();
        return view('pages.addEditPages', compact('tag','media_groups'));
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
            'title' => 'required|string|max:100',
            'page_content' => 'required',
            'status' => 'required',
        ],[
            'title.required' => __('index.title_required'),
            'title.max' => __('index.title_max_100'),
            'page_content.required' => __('index.content_required'),
            'status.required' => __('index.status_required'),
        ]);

        $obj = new Pages();
        $obj->title = getPlainText($request->title);
        $obj->slug = Str::slug($request->title);
        $obj->page_content = $request->page_content;
        $obj->tag_ids = empty($request->tag_ids)?null:implode(',', $request->tag_ids);
        $obj->status = !empty($request->status)? $request->status:null;
        if(isset($request->tag_ids)) {
            $tag_text = [];
            foreach($request->tag_ids as $tag_id) {
                array_push($tag_text,Tag::find($tag_id)->title);
            }
            $obj->tag_titles = empty($tag_text) ? null : implode(',',$tag_text);
        } else {
            $obj->tag_titles = Null;
        }

        if ($obj->save()){
            return redirect('pages')->with(saveMessage());
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
        $id = encrypt_decrypt($id, 'decrypt');
        $obj = Pages::find($id);
        $all_tags = \App\Model\Tag::whereIn('id', explode(',', $obj->tag_ids))->where('del_status', 'Live')->get();
        return view('pages.view', compact('obj', 'all_tags'));
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
        $obj = Pages::find($id);
        $tag = Tag::where('del_status', 'Live')->pluck('title', 'id');
        $media_groups = ProductCategory::live()->type()->get();
        return view('pages.addEditPages', compact( 'tag', 'obj','media_groups'));
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
        if(appMode() == "demo") {
            abort(405);
        }
        $this->validate($request,[
            'title' => 'required|string|max:100',
            'page_content' => 'required',
            'status' => 'required',
        ],[
            'title.required' => __('index.title_required'),
            'title.max' => __('index.title_max_100'),
            'page_content.required' => __('index.content_required'),
            'status.required' => __('index.status_required'),
        ]);

        $id = encrypt_decrypt($id, 'decrypt');
        $obj = Pages::find($id);
        $obj->title = getPlainText($request->title);
        $obj->slug = Str::slug($request->title);
        $obj->page_content = $request->page_content;
        $obj->tag_ids = empty($request->tag_ids)?null:implode(',', $request->tag_ids);
        $obj->status = !empty($request->status)? $request->status:null;
        if(isset($request->tag_ids)) {
            $tag_text = [];
            foreach($request->tag_ids as $tag_id) {
                array_push($tag_text,Tag::find($tag_id)->title);
            }
            $obj->tag_titles = empty($tag_text) ? null : implode(',',$tag_text);
        } else {
            $obj->tag_titles = Null;
        }

        if ($obj->save()){
            return redirect('pages')->with(updateMessage());
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
        $obj = Pages::find($id);
        $obj->del_status = "Deleted";
        $obj->save();
        return redirect('pages')->with(deleteMessage());
    }
}
