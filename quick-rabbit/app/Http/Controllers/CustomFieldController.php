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
# This is Custom Field Controller
##############################################################################
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\CustomField;
use App\Model\Department;
use App\Model\ProductCategory;
use Illuminate\Http\Request;

class CustomFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = CustomField::live();
        $product_category_id = request()->get('product_category_id');
        if (isset($product_category_id)) {
            $data->where('product_category_id', $product_category_id);
        }
        if (appTheme() == 'single') {
            $productId = ProductCategory::live()->where('type', 'single')->first();
            $data->where('product_category_id', $productId->id);
        }
        $results = $data->oldest()->get();
        return view('setting.custom_fields', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $running_product_categories = CustomField::live()->pluck('product_category_id');
        $product_categories = ProductCategory::live()->whereNotIn('id', $running_product_categories)->get();
        if (appTheme() == 'single') {
            $product_category = ProductCategory::live()->where('type', 'single')->first();
            $running_product_department = CustomField::live()->pluck('department_id');
            $departments = Department::live()->whereNotIn('id', $running_product_department)->get();
        } else {
            $product_category = null;
            $departments = Department::live()->get();
        }

        $title = __('index.add_custom_field');
        return view('setting.custom_field_add_edit', compact('product_categories', 'title', 'departments', 'product_category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['product_category_id' => 'required', 'status' => 'required']);
        $row = new CustomField();
        if ($request->product_category_id) {
            $row->product_category_id = $request->product_category_id;
        }

        if ($request->department_id) {
            $row->department_id = $request->department_id;
        }

        $row->status = $request->status;
        $row->custom_field_type = empty($request->custom_field_type) ? null : json_encode($request->custom_field_type);
        $row->custom_field_label = empty($request->custom_field_label) ? null : json_encode($request->custom_field_label);
        $row->custom_field_option = empty($request->custom_field_option) ? null : json_encode($request->custom_field_option);
        $row->custom_field_required = empty($request->custom_field_required_val) ? null : json_encode($request->custom_field_required_val);
        $row->save();
        return redirect()->route('custom-fields.index')->with(saveMessage());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product_categories = ProductCategory::live()->type()->get();
        $title = __('index.edit_custom_field');
        $obj = CustomField::findOrFail(encrypt_decrypt($id, 'decrypt'));
        if (appTheme() == 'single') {
            $product_category = ProductCategory::live()->where('type', 'single')->first();
            $departments =  Department::live()->get();
        } else {
            $product_category = null;
            $departments = Department::live()->get();
        }

        return view('setting.custom_field_add_edit', compact('product_categories', 'title', 'obj', 'product_category', 'departments'));
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
        $this->validate($request, ['product_category_id' => 'required', 'status' => 'required']);
        $row = CustomField::findOrFail($id);
         if ($request->product_category_id) {
            $row->product_category_id = $request->product_category_id;
        }

        if ($request->department_id) {
            $row->department_id = $request->department_id;
        }
        $row->status = $request->status;
        $row->custom_field_type = empty($request->custom_field_type) ? null : json_encode($request->custom_field_type);
        $row->custom_field_label = empty($request->custom_field_label) ? null : json_encode($request->custom_field_label);
        $row->custom_field_option = empty($request->custom_field_option) ? null : json_encode($request->custom_field_option);
        $row->custom_field_required = empty($request->custom_field_required_val) ? null : json_encode($request->custom_field_required_val);
        $row->save();
        return redirect()->route('custom-fields.index')->with(updateMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CustomField::findOrFail(encrypt_decrypt($id, 'decrypt'))->update(array('del_status' => 'DELETED'));
        return redirect()->route('custom-fields.index')->with(deleteMessage());
    }
}
