<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeatureController extends Controller
{

    /**
     * Display Feature Setting Page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index()
    {
        $data = featureSetting();
        return view('setting.feature_setting', compact('data'));
    }

    /**
     * Update Feature Setting
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function update(Request $request)
    {
        $request->validate([
            'icon.*' => 'image|mimes:jpeg,png,jpg,svg|max:2048|dimensions:max_width=30,max_height=30',
            'feature_title.*' => 'required',
            'feature_description.*' => 'required',
        ]);
        $data = [];
        foreach ($request->feature_title as $key => $item) {
            $data[$key]['title'] = $item;
            $data[$key]['description'] = $request->feature_description[$key];
            if(isset($request->icon[$key])){
                $data[$key]['icon'] = uploadFile($request->icon[$key],'settings/','feature_'.$key);
            }else{
                $data[$key]['icon'] = $request->old_icon[$key];
            }
            $data[$key]['id'] = $key + 1;
        }
        $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents(base_path('assets/json/feature.json'), stripslashes($newJsonString));
        return redirect()->route('feature-setting')->with(updateMessage());
    }
}
