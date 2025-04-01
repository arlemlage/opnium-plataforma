<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SectionTitleController extends Controller
{
    public function index()
    {
        $data = sectionTitle();
        return view('setting.section-title', compact('data'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'section_title.*' => 'required',
            'section_sub_title.*' => 'required',
        ]);
        $data = [];
        foreach ($request->section_title as $key => $item) {
            $data[$key]['title'] = $item;
            $data[$key]['sub-title'] = $request->section_sub_title[$key];
            $data[$key]['section'] = $request->section[$key];
        }
        $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents(base_path('assets/json/section_title.json'), stripslashes($newJsonString));
        return redirect()->route('section-title')->with(updateMessage());
    }
}
