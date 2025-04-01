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
  # This is Media Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Media;
use App\Model\ProductCategory;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $media = Media::live();
        $group_id = request()->get('group');
        if(!empty($group_id)) {
            $media->where('group',encrypt_decrypt($group_id,'decrypt'));
        }
        if(appTheme() == 'single'){
            $product = ProductCategory::where('del_status', 'Live')->type()->pluck('id')->toArray();
            array_merge($product, ['blog', 'page']);
            $media->whereIn('group',$product);
        }
        $obj = $media->oldest('id')->get();
        $product_category = ProductCategory::where('del_status', 'Live')->type()->get();
        return view('media.index', compact('obj','product_category','group_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product_category = ProductCategory::where('del_status', 'Live')->type()->get();
        return view('media.addEditMedia', compact('product_category'));
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
            'title' => 'required|string|max:50',
            'group' => 'required',
            'media_path' => 'required',
        ],[
            'title.required' => __('index.title_required'),
            'title.max' => __('index.title_max_50'),
            'group.required' => __('index.group_required'),
            'media_path.required' => __('index.title_media_path'),
        ]);

        $obj = new Media();
        $obj->title = $request->title;
        $obj->group = $request->group;

        //generate png files from base_64 data
            $data = escape_output($request->media_path);
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            $imageName = time().'.png';
            file_put_contents(rootFilePath().'media/media_images/'.$imageName, $data);
            $media_path = $imageName;
        //end

        $obj->media_path = $media_path;
        $obj->thumb_img = mediaThumb(rootFilePath().'media/media_images/'.$imageName);

        if ($obj->save()){
            return redirect('media?group='.(encrypt_decrypt($request->group, 'encrypt')))->with(saveMessage());
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
        $product_category = ProductCategory::where('del_status', 'Live')->type()->get();
        $obj = Media::findOrFail(encrypt_decrypt($id,'decrypt'));
        return view('media.addEditMedia', compact('product_category','obj'));
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
            'group' => 'required',
            'media_path' => 'required',
        ],[
            'title.required' => __('index.title_required'),
            'title.max' => __('index.title_max_50'),
            'group.required' => __('index.group_required'),
            'media_path.required' => __('index.title_media_path'),
        ]);

        $obj = Media::findOrFail(encrypt_decrypt($id,'decrypt'));
        $obj->title = $request->title;
        $obj->group = $request->group;

        if($request->media_path) {
        //generate png files from base_64 data
            $data = escape_output($request->media_path);
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            $imageName = time().'.png';
            file_put_contents(rootFilePath().'media/media_images/'.$imageName, $data);
            $media_path = $imageName;
        //end
            $obj->media_path = $media_path;
            $obj->thumb_img = mediaThumb(rootFilePath().'media/media_images/'.$imageName);
        }


        if ($obj->save()){
            return redirect('media?group='.(encrypt_decrypt($request->group, 'encrypt')))->with(updateMessage());
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
        $obj = Media::find($id);
        $obj->del_status = "Deleted";
        $obj->save();
        return redirect('media')->with(deleteMessage());
    }
}
