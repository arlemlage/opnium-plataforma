<?php
/*
##############################################################################
# AI Powered Customer Support Portal and Knowledgebase System
##############################################################################
# AUTHOR:        Door Soft
##############################################################################
# EMAIL:        info@doorsoft.co
##############################################################################
# COPYRIGHT:        RESERVED BY Door Soft
##############################################################################
# WEBSITE:        https://www.doorsoft.co
##############################################################################
# This is Article Controller
##############################################################################
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Article;
use App\Model\ArticleGroup;
use App\Model\ArticleReview;
use App\Model\ProductCategory;
use App\Model\Tag;
use App\Model\Ticket;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (appTheme() == 'multiple') {
            $article = Article::live();
            $product_id = request()->get('product');
            $article_groups = null;
        }

        if (appTheme() == 'single') {
            $product_id = ProductCategory::live()->where('type', 'single')->first()->id;
            $article = Article::live();
            $article_groups = ArticleGroup::live()->where('product_category', $product_id)->get();
        }

        $article_group_id = request()->get('article_group');
        if (isset($product_id)) {
            $article->where('product_category_id', $product_id);
        }
        if (isset($article_group_id)) {
            $article->where('article_group_id', $article_group_id);
        }
        $article->oldest();
        $obj = $article->get();
        return view('article.index', compact('obj', 'product_id', 'article_group_id', 'article_groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product_category = ProductCategory::live()->type()->pluck('title', 'id');
        $media_groups = ProductCategory::live()->type()->get();
        $product_id = ProductCategory::live()->where('type', 'single')->first()->id;
        if (appTheme() == 'multiple') {
            $article_group = ArticleGroup::live()->pluck('title', 'id');
        } else {
            $article_group = ArticleGroup::live()->where('product_category', $product_id)->get();
        }
        $tag = Tag::live()->pluck('title', 'id');
        return view('article.add_edit', compact('product_category', 'article_group', 'tag', 'media_groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'product_category_id' => 'required',
            'article_group_id' => 'required',
            'internal_external' => 'required',
            'status' => 'required',
            'page_content' => 'required',
        ], [
            'title.required' => __('index.title_required'),
            'title.max' => __('index.title.max'),
            'product_category_id.required' => __('index.product_category_required'),
            'article_group_id.required' => __('index.article_group_id_required'),
            'internal_external.required' => __('index.internal_external_required'),
            'status.required' => __('index.status_required'),
            'page_content.required' => __('index.content_required'),
        ]);

        $obj = new Article();
        $obj->title = getPlainText($request->title);
        $product_name = productCatName($request->product_category_id);
        $slug = $product_name . '-' . $request->title;
        $obj->title_slug = Str::slug($slug);
        $obj->product_category_id = !empty($request->product_category_id) ? $request->product_category_id : null;
        $obj->article_group_id = !empty($request->article_group_id) ? $request->article_group_id : null;
        $obj->convert_from_ticket_id = !empty($request->ticket_id) ? encrypt_decrypt($request->ticket_id, 'decrypt') : null;
        $obj->internal_external = !empty($request->internal_external) ? $request->internal_external : null;
        $obj->tag_ids = empty($request->tag_ids) ? null : implode(',', $request->tag_ids);
        $obj->video_link = !empty($request->video_link) ? $request->video_link : null;
        if(!empty($request->image_url)) {
            $obj->video_thumbnail = bas64ToImage($request->image_url,'article_videos/');
        }
        if (isset($request->tag_ids)) {
            $tag_text = [];
            foreach ($request->tag_ids as $tag_id) {
                array_push($tag_text, Tag::find($tag_id)->title);
            }
            $obj->tag_titles = empty($tag_text) ? null : implode(',', $tag_text);
        } else {
            $obj->tag_titles = null;
        }

        $obj->status = !empty($request->status) ? $request->status : null;
        $obj->page_content = !empty($request->page_content) ? $request->page_content : null;

        if (isset($request->ticket_id)) {
            $ticket_info = Ticket::find(encrypt_decrypt($request->ticket_id, 'decrypt'));
            $ticket_info->converted_to_article = 1;
            $ticket_info->save();
        }

        if ($obj->save()) {
            return redirect('articles')->with(saveMessage());
        } else {
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
        $obj = Article::find($id);
        $product_category = ProductCategory::find($obj->product_category_id);
        $article_group = ArticleGroup::find($obj->article_group_id);
        $tags = Tag::whereIn('id', explode(',', $obj->tag_ids))->get();

        $data = [
            'product_category' => $product_category,
            'article_group' => $article_group,
            'tags' => $tags,
        ];
        return view('article.view', $data, compact('obj'));
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
        $obj = Article::find($id);
        $product_category = ProductCategory::live()->type()->pluck('title', 'id');
        $product_id = ProductCategory::live()->where('type', 'single')->first()->id;
        if (appTheme() == 'multiple') {
            $article_group = ArticleGroup::live()->pluck('title', 'id');
        } else {
            $article_group = ArticleGroup::live()->where('product_category', $product_id)->get();
        }
        $media_groups = ProductCategory::live()->type()->get();
        $tag = Tag::live()->pluck('title', 'id');
        return view('article.add_edit', compact('product_category', 'article_group', 'tag', 'obj', 'media_groups'));
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
        if (appMode() == "demo") {
            abort(405);
        }
        $this->validate($request, [
            'title' => 'required|string',
            'product_category_id' => 'required',
            'article_group_id' => 'required',
            'internal_external' => 'required',
            'status' => 'required',
            'page_content' => 'required',
        ], [
            'title.required' => __('index.title_required'),
            'product_category_id.required' => __('index.product_category_required'),
            'article_group_id.required' => __('index.article_group_id_required'),
            'internal_external.required' => __('index.internal_external_required'),
            'status.required' => __('index.status_required'),
            'page_content.required' => __('index.content_required'),
        ]);

        $id = encrypt_decrypt($id, 'decrypt');
        $obj = Article::find($id);
        $obj->title = getPlainText($request->title);
        $product_name = productCatName($request->product_category_id);
        $slug = $product_name . '-' . $request->title;
        $obj->title_slug = Str::slug($slug);
        $obj->product_category_id = $request->product_category_id;
        $obj->article_group_id = $request->article_group_id;
        $obj->internal_external = $request->internal_external;
        $obj->tag_ids = empty($request->tag_ids) ? null : implode(',', $request->tag_ids);
        $obj->video_link = !empty($request->video_link) ? $request->video_link : null;
        if(!empty($request->image_url)) {
            $obj->video_thumbnail = bas64ToImage($request->image_url,'article_videos/');
        }
        if (isset($request->tag_ids)) {
            $tag_text = [];
            foreach ($request->tag_ids as $tag_id) {
                array_push($tag_text, Tag::find($tag_id)->title);
            }
            $obj->tag_titles = empty($tag_text) ? null : implode(',', $tag_text);
        } else {
            $obj->tag_titles = null;
        }

        $obj->status = $request->status;
        $obj->page_content = $request->page_content;

        if ($obj->save()) {
            return redirect('articles')->with(updateMessage());
        } else {
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
        $obj = Article::find($id);
        $obj->del_status = "Deleted";
        $obj->save();
        return redirect('articles')->with(deleteMessage());
    }

    /**
     * Customer article view
     * @return Application|Factory|View
     */
    public function customerArticleList()
    {
        $obj = Article::query()->live();
        $obj->orderBy('id', 'DESC');
        $obj = $obj->get();
        return view('customer-activity.article.index', compact('obj'));
    }

    /**
     * Customer article view by id
     */
    public function customerArticleView($id)
    {
        $id = encrypt_decrypt($id, 'decrypt');
        $obj = Article::find($id);
        $product_category = ProductCategory::find($obj->product_category_id);
        $article_group = ArticleGroup::find($obj->article_group_id);
        $tags = Tag::whereIn('id', explode(',', $obj->tag_ids))->get();

        //Rating count
        $review_info = ArticleReview::where('article_id', $id);
        $total_rating = $review_info->sum('rating');
        $total_rating_count = $review_info->count();
        $rating = 0;
        if (($total_rating > 0) && ($total_rating_count > 0)) {
            $rating = $total_rating / $total_rating_count;
        }

        $data = [
            'product_category' => $product_category,
            'article_group' => $article_group,
            'tags' => $tags,
        ];
        return view('customer-activity.article.view', $data, compact('obj', 'rating'));
    }

    /**
     * Customer Article review
     */
    public function customerArticleReview(Request $request, $id)
    {
        $id = encrypt_decrypt($id, 'decrypt');
        $obj = Article::find($id);
        $create_review = new ArticleReview();
        $create_review->user_id = Auth::user()->id;
        $create_review->article_id = $id;
        $create_review->rating = $request->rating;
        $create_review->review = $request->review;

        if ($create_review->save()) {
            return redirect()->route('customer-article-list')->with(saveMessage());
        } else {
            return redirect()->back()->with(waringMessage());
        }

    }

    /**
     * Sorting page
     */
    public function shortPage()
    {
        $products = ProductCategory::live()->type()->get();
        return view('article.sort_article', compact('products'));
    }

    /**
     * Sort Data
     */
    public function sortData(Request $request)
    {
        if ($request->has('ids')) {
            $arr = explode(',', $request->input('ids'));
            foreach ($arr as $sortOrder => $id) {
                $row = Article::find($id);
                $row->sort_id = $sortOrder + 1;
                $row->save();
            }
            return ['success' => true, 'message' => 'Updated'];
        }
    }
}
