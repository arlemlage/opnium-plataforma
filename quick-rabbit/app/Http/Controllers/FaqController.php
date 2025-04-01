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
  # This is Faq Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\ArticleGroup;
use App\Model\Faq;
use App\Model\ProductCategory;
use App\Model\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $obj = Faq::query()->where('del_status', 'Live');
        $obj->orderBy('id','DESC');
        $obj = $obj->get();
        return view('faq.index', compact('obj'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product_category = ProductCategory::where('del_status', 'Live')->type()->pluck('title', 'id');
        $tag = Tag::where('del_status', 'Live')->pluck('title', 'id');
        $obj = '';
        return view('faq.addEditFaq', compact('product_category', 'tag','obj'));

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
            'question' => 'required|string|max:100',
            'answer' => 'required',
            'status' => 'required',
        ],[
            'question.required' => __('index.question_required'),
            'question.max' => __('index.question_max_100'),
            'answer.required' => __('index.answer_required'),
            'status.required' => __('index.status_required'),
        ]);

        $obj = new Faq();
        $obj->question = getPlainText($request->question);
        $obj->answer = $request->answer;
        $obj->product_category_id = !empty($request->product_category_id)? $request->product_category_id:null;
        $obj->tag_ids = empty($request->tag_ids)?null:implode(',', $request->tag_ids);
        if(isset($request->tag_ids)) {
            $tag_text = [];
            foreach($request->tag_ids as $tag_id) {
                array_push($tag_text,Tag::find($tag_id)->title);
            }
            $obj->tag_titles = empty($tag_text) ? null : implode(',',$tag_text);
        } else {
            $obj->tag_titles = Null;
        }
        $obj->status = !empty($request->status)? $request->status:null;

        if ($obj->save()){
            return redirect('faq')->with(saveMessage());
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
        $obj = Faq::find($id);
        $all_tags = \App\Model\Tag::whereIn('id', explode(',', $obj->tag_ids))->where('del_status', 'Live')->get();
        return view('faq.view', compact('obj', 'all_tags'));
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
        $obj = Faq::find($id);
        $product_category = ProductCategory::where('del_status', 'Live')->type()->pluck('title', 'id');
        $tag = Tag::where('del_status', 'Live')->pluck('title', 'id');
        return view('faq.addEditFaq', compact('product_category','tag', 'obj'));
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
            'question' => 'required|string|max:100',
            'answer' => 'required',
            'status' => 'required',
        ],[
            'question.required' => __('index.question_required'),
            'question.max' => __('index.question_max_100'),
            'answer.required' => __('index.question_required'),
            'status.required' => __('index.status_required'),
        ]);

        $id = encrypt_decrypt($id, 'decrypt');
        $obj = Faq::find($id);
        $obj->question = getPlainText($request->question);
        $obj->answer = $request->answer;
        $obj->product_category_id = !empty($request->product_category_id)? $request->product_category_id:null;
        $obj->tag_ids = empty($request->tag_ids)?null:implode(',', $request->tag_ids);
        if(isset($request->tag_ids)) {
            $tag_text = [];
            foreach($request->tag_ids as $tag_id) {
                array_push($tag_text,Tag::find($tag_id)->title);
            }
            $obj->tag_titles = empty($tag_text) ? null : implode(',',$tag_text);
        } else {
            $obj->tag_titles = Null;
        }
        $obj->status = !empty($request->status)? $request->status:null;

        if ($obj->save()){
            return redirect('faq')->with(updateMessage());
        }else{
            return redirect()->back()->with(deleteMessage());
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
        $obj = Faq::find($id);
        $obj->del_status = "Deleted";
        $obj->save();
        return redirect('faq')->with(deleteMessage());
    }
}
