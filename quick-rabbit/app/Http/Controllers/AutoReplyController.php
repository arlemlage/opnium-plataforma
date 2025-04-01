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
  # This is Auto Reply Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\Model\AutoReply;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Model\ProductCategory;
use App\Http\Controllers\Controller;
use App\Model\Department;

class AutoReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product_id = request()->get('product');
        $department_id = request()->get('department');

        if(appTheme() == 'multiple'){
            $obj = AutoReply::live();   
        }else{
            $product_id = ProductCategory::live()->where('type', 'single')->pluck('id');
            $obj = AutoReply::live()->whereIn('category_id', $product_id);
        }

        
        if(isset($product_id)) {
            $obj->where('category_id',$product_id);
        }
        if(isset($department_id)) {
            $obj->where('department_id',$department_id);
        }
        $obj->latest('category_id');
        $obj = $obj->get();
        return view('auto-reply.index', compact('obj','product_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product_category = ProductCategory::live()->type()->pluck('title', 'id');
        $department = Department::live()->pluck('name', 'id');
        return view('auto-reply.addEditAutoReply',compact('product_category', 'department'));
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
            'question' => 'required|string|max:250',
            'answer' => 'max:2000'
        ],[
            'title.required' => __('index.question_required'),
            'answer.required' => __('index.answer_required.required'),
        ]);
        $obj = new AutoReply();
        $obj->question = getPlainText($request->question);
        $obj->category_id = $request->category_id;
        $obj->answer = $request->answer;
        if($request->department_id){
            $obj->department_id = $request->department_id;
        }
        if ($obj->save()){
            return redirect('ai_replies')->with(updateMessage());
        }else{
            return redirect()->back()->with(waringMessage());
        }
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
        $obj = AutoReply::find($id);
        $product_category = ProductCategory::live()->type()->pluck('title', 'id');
        $department = Department::live()->pluck('name', 'id');

        return view('auto-reply.addEditAutoReply', compact('obj','product_category', 'department'));
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
            'question' => 'required|string|max:250',
            'answer' => 'max:2000'
        ],[
            'title.required' => __('index.question_required'),
            'answer.required' => __('index.answer_required.required'),
        ]);

        $id = encrypt_decrypt($id, 'decrypt');
        $obj = AutoReply::find($id);
        $obj->question = getPlainText($request->question);
        $obj->category_id = $request->category_id;
        $obj->answer = $request->answer;
        if($request->department_id){
            $obj->department_id = $request->department_id;
        } 
        if ($obj->save()){
            return redirect('ai_replies')->with(updateMessage());
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
        $obj = AutoReply::find($id);
        $obj->del_status = "Deleted";
        $obj->save();
        return redirect('ai_replies')->with(deleteMessage());
    }
}
