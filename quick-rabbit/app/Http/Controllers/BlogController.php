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
  # This is Blog Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\Model\Tag;
use App\Model\Blog;
use App\Model\BlogCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Model\ProductCategory;
use App\Http\Controllers\Controller;


class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blog = Blog::with('category')->live();
        $category_id = request()->get('category');
        if(isset($category_id)) {
            $blog->where('category_id',encrypt_decrypt($category_id,'decrypt'));
        }
        $obj = $blog->orderBy('category_id', 'desc')->get();
        $categories = BlogCategory::all();
        return view('blog.index', compact('obj','categories','category_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tag = Tag::where('del_status', 'Live')->pluck('title', 'id');
        $categories = BlogCategory::live()->orderBy('title','asc')->get();
        $media_groups = ProductCategory::live()->type()->get();
        return view('blog.addEditBlog', compact('tag','categories','media_groups'));
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
            'title' => 'required|string|max:255',
            'category_id' => 'required',
            'blog_content' => 'required',
            'status' => 'required',
            'image' => 'mimes:jpg,jpeg,png|max:5120'
        ],[
            'title.required' => __('index.title_required'),
            'title.max' => __('index.title.max'),
            'category_id.required' => __('index.category_required'),
            'blog_content.required' => __('index.content_required'),
            'status.required' => __('index.status_required'),
            'image.max' => __('index.file_size_required'),
        ]);
        

        $obj = new Blog();
        $obj->title = getPlainText($request->title);
        $obj->slug = Str::slug($request->title);
        $obj->category_id = $request->category_id;
        $obj->blog_content = $request->blog_content;
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

        if(!empty($request->file('image'))) {
            $obj->image = uploadImage($request->file('image'),'blogs/');
            $obj->thumb_img = blogThumb($request->file('image'));
        }
        if ($obj->save()){
            return redirect('blog')->with(saveMessage());
        } else{
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
        $obj = Blog::find($id);
        $tags = Tag::whereIn('id', explode(',', $obj->tag_ids))->get();
        $data = [
            'tags' => $tags,
        ];

        return view('blog.view', $data, compact('obj'));
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
        $obj = Blog::find($id);
        $tag = Tag::where('del_status', 'Live')->pluck('title', 'id');
        $categories = BlogCategory::live()->orderBy('title','asc')->get();
        $media_groups = ProductCategory::live()->type()->get();
        return view('blog.addEditBlog', compact('tag', 'obj','categories','media_groups'));
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
            'title' => 'required|string|max:255',
            'category_id' => 'required',
            'image' => 'mimes:jpg,jpeg,png|max:5120',
            'blog_content' => 'required',
            'status' => 'required',
        ],[
            'title.required' => __('index.title_required'),
            'title.max' => __('index.title.max'),
            'category_id.required' => 'index.category_required',
            'blog_content.required' => __('index.content_required'),
            'status.required' => __('index.status_required'),
            'image.max' => __('index.file_size_required'),
        ]);

        $id = encrypt_decrypt($id, 'decrypt');
        $obj = Blog::find($id);
        $obj->title = getPlainText($request->title);
        $obj->slug = Str::slug($request->title);
        $obj->category_id = $request->category_id;
        $obj->blog_content = $request->blog_content;
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

        if(!empty($request->file('image'))) {
            $obj->image = uploadImage($request->file('image'),'blogs/');
            $obj->thumb_img = blogThumb($request->file('image'));
        }

        if ($obj->save()){
            return redirect('blog')->with(updateMessage());
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
        $obj = Blog::find($id);
        $obj->del_status = "Deleted";
        $obj->save();
        return redirect('blog')->with(deleteMessage());
    }
}
