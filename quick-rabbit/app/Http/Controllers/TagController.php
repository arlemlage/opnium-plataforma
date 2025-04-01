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
  # This is Tag Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $obj = Tag::live()->oldest()->get();
        return  view('tag.index', compact('obj'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tag.addEditTag');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax()){
            if(!empty($request->title)){
                $obj = new Tag();
                $obj->title = $request->title;
                $obj->description = $request->description;
                $obj->save();

                $ob_id = $obj->id;
                $selected_tag_ids = empty($request->selected_tag_ids)? []:explode(',', $request->selected_tag_ids);
                array_push($selected_tag_ids, $ob_id);
                $tag = Tag::where('del_status', 'Live')->get();

                $all_tag_options = '';
                foreach ($tag as $t){
                    $selected = (in_array($t->id, $selected_tag_ids))?"selected":"";
                    $all_tag_options .= '<option value="'.$t->id.'" '.$selected.'>'.$t->title.'</option></br>';
                }
                $all_tag_options = explode('</br>', $all_tag_options);

                $data = ['msg'=>'Tag has been stored successfully', 'status'=>1, 'all_tag_options'=>$all_tag_options, 'selected_tag_ids'=>$selected_tag_ids];
                return  $data;
            }else{
                $data = ['msg'=>__('index.title_required'), 'status'=>0];
                return  $data;
            }
        } else{
            $this->validate($request,[
                'title' => 'required|string|max:50',
                'description' => 'max:1000'
            ],[
                'title.required' => __('index.title_required'),
                'title.max' => __('index.title_max_50'),
                'description.max' => __('index.description_max_1000')
            ]);

            $obj = new Tag();
            $obj->title = $request->title;
            $obj->description = $request->description;
            if ($obj->save()){
                return redirect('tag')->with(saveMessage());
            }else{
                return redirect()->back()->with(waringMessage());
            }
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
        $obj = Tag::find($id);
        return view('tag.addEditTag', compact('obj'));
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
            'title' => 'required|string|max:50',
            'description' => 'max:1000'
        ],[
            'title.required' => __('index.title_required'),
            'title.max' => __('index.title_max_50'),
            'description.max' => __('index.description_max_1000')
        ]);

        $id = encrypt_decrypt($id, 'decrypt');
        $obj = Tag::find($id);
        $obj->title = $request->title;
        $obj->description = $request->description;

        if ($obj->save()){
            return redirect('tag')->with(updateMessage());
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
        $obj = Tag::find($id);
        $obj->del_status = "Deleted";
        $obj->save();
        return redirect('tag')->with(deleteMessage());
    }
}
