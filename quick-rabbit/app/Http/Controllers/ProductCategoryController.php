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
# This is Product Category Controller
##############################################################################
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $obj = ProductCategory::live()->type();
        if (appTheme() == 'multiple') {
            $obj->latest('sort_id');
            $obj = $obj->get();
            return view('product-category.index', compact('obj'));
        }

        if (appTheme() == 'single') {
            $obj = $obj->first();
            return view('product-category.addEditProductCat', compact('obj'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product-category.addEditProductCat');
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
            'title' => 'required|string|max:191',
            'verification' => 'required',
            'photo_thumb' => 'mimes:jpg,jpeg,png|max:1024|dimensions:max_width=80,max_height=80',
            'description' => 'max:2000',
        ], [
            'title.required' => __('index.title_required'),
            'title.max' => __('index.title_max_191'),
            'verification.required' => __('index.verification.required'),
        ]);

        $obj = new ProductCategory();
        $obj->title = getPlainText($request->title);
        $obj->product_code = $request->product_code;
        $obj->slug = Str::slug($request->title);
        $obj->verification = $request->verification;
        $obj->envato_product_code = ($request->verification == 1) ? $request->envato_product_code : null;
        $obj->status = $request->status;
        $obj->short_description = $request->short_description;
        $obj->description = $request->description;

        if (isset($request->photo_thumb) && $request->hasFile('photo_thumb')) {
            $image = $request->file('photo_thumb');
            if (!isImage($image)) {
                return redirect()->back()->with('photo_thumb', 'The Photo Thumbnail should be valid image');
            }
            $image_info = imageInfo($image);

            $allowed_extension = array('jpg', 'jpeg', 'png');

            if (!in_array($image_info['extension'], $allowed_extension)) {
                return redirect()->back()->with('photo_thumb', 'The Photo Thumbnail should be type of jpg, jpeg or png.');
            }

            if ($image_info['width'] > 80 or $image_info['height'] > 80) {
                return redirect()->back()->with('photo_thumb', 'The Photo Thumbnail should be size of width: 80px and height: 80px');
            }

            if (uploadedFileSizeInMb($image->getSize()) > 1) {
                return redirect()->back()->with('photo_thumb', 'The Photo Thumbnail should be size of 1MB');
            }

            $obj->photo_thumb = uploadImage($image, 'product_category_thumbs/');
        }
        if ($obj->save()) {
            return redirect('product-category')->with(updateMessage());
        } else {
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
        $obj = ProductCategory::find($id);
        return view('product-category.addEditProductCat', compact('obj'));
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
        $this->validate($request, [
            'title' => 'required|string|max:191',
            'verification' => 'required',
            'photo_thumb' => 'mimes:jpg,jpeg,png|max:1024|dimensions:max_width=80,max_height=80',
            'description' => 'max:2000',
        ], [
            'title.required' => __('index.title_required'),
            'title.max' => __('index.title_max_191'),
            'verification.required' => __('index.verification.required'),
        ]);

        $id = encrypt_decrypt($id, 'decrypt');
        $obj = ProductCategory::find($id);
        $obj->title = getPlainText($request->title);
        $obj->product_code = $request->product_code;
        $obj->slug = Str::slug($request->title);
        $obj->verification = $request->verification;
        $obj->envato_product_code = ($request->verification == 1) ? $request->envato_product_code : null;
        $obj->status = $request->status;
        $obj->short_description = $request->short_description;
        $obj->description = $request->description;

        if (isset($request->photo_thumb) && $request->hasFile('photo_thumb')) {
            $image = $request->file('photo_thumb');
            if (!isImage($image)) {
                return redirect()->back()->with('photo_thumb', 'The Photo Thumbnail should be valid image');
            }
            $image_info = imageInfo($image);

            $allowed_extension = array('jpg', 'jpeg', 'png');

            if (!in_array($image_info['extension'], $allowed_extension)) {
                return redirect()->back()->with('photo_thumb', 'The Photo Thumbnail should be type of jpg, jpeg or png.');
            }

            if ($image_info['width'] > 80 or $image_info['height'] > 80) {
                return redirect()->back()->with('photo_thumb', 'The Photo Thumbnail should be size of width: 80px and height: 80px');
            }

            if (uploadedFileSizeInMb($image->getSize()) > 1) {
                return redirect()->back()->with('photo_thumb', 'The Photo Thumbnail should be size of 1MB');
            }

            $obj->photo_thumb = uploadImage($image, 'product_category_thumbs/');
        }
        if ($obj->save()) {
            return redirect('product-category')->with(updateMessage());
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
        $obj = ProductCategory::find($id);
        $obj->del_status = "Deleted";
        $obj->save();
        return redirect('product-category')->with(deleteMessage());
    }

    /**
     * Product/Category sorting page
     */
    public function shortPage()
    {
        $products = ProductCategory::live()->type()->get();
        return view('product-category.sort_product_category', compact('products'));
    }

    /**
     * Sort product category
     */
    public function sortProductCategory(Request $request)
    {
        if ($request->has('ids')) {
            $arr = explode(',', $request->input('ids'));
            foreach ($arr as $sortOrder => $id) {
                $product = ProductCategory::find($id);
                $product->sort_id = $sortOrder + 1;
                $product->save();
            }
            return ['success' => true, 'message' => 'Updated'];
        }
    }
}
