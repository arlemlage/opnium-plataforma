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
  # This is Role Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Menu;
use App\Model\MenuActivity;
use App\Model\Role;
use App\Model\RolePermission;
use App\Model\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = __('index.role_list');
        $results = Role::oldest('id')->get();
        return view('role.index',compact('title','results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = __('index.add_role');
        $menus = Menu::with([
            'activities' => function($query) {
                $query->where('is_dependant',"No");
            }
        ])->get();
        return view('role.add_edit',compact('title','menus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
        [
            'title'=>'required|max:191'
        ],
        [
            'title.required' => __('index.role_name_required'),
            'title.max' => __('index.role_name_max_191')
        ]);
        $role = new Role();
        $role->title = $request->title;
        $role->save();
        $activity_ids = $request->activity_id;

        if(isset($activity_ids)) {
           foreach ($activity_ids as $activity_id) {
               $menu_id = MenuActivity::find($activity_id)->menu_id;
               $request_activity = [
                   'role_id' => $role->id,
                   'menu_id' => $menu_id,
                   'activity_id' => $activity_id
               ];
               RolePermission::updateOrInsert($request_activity,$request_activity);
           }

           foreach (MenuActivity::where('is_dependant',"Yes")->get() as $activity) {
               $menu_id = MenuActivity::find($activity->id)->menu_id;
               $dependant_activity = [
                   'role_id' => $role->id,
                   'menu_id' => $menu_id,
                   'activity_id' => $activity->id
               ];
               RolePermission::updateOrInsert($dependant_activity,$dependant_activity);
           }
        }
        return redirect()->route('role.index')->with(saveMessage());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = __('index.edit_role');
        $data = Role::findOrFail(encrypt_decrypt($id,'decrypt'));
        $menus = Menu::with([
            'activities' => function($query) {
                $query->where('is_dependant',"No");
            }
        ])->get();
        return view('role.add_edit',compact('title','data','menus'));
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
        $this->validate($request,
        [
            'title'=>'required|max:191'
        ],
        [
            'title.required' => __('index.role_name_required'),
            'title.max' => __('index.role_name_max_191')
        ]);
        $role = Role::findOrFail(encrypt_decrypt($id,'decrypt'));
        $role->title = $request->title;
        $role->save();
        $activity_ids = $request->activity_id;
        if(isset($activity_ids)) {
            RolePermission::whereIn('role_id',array($role->id))->delete();
            foreach ($activity_ids as $activity_id) {
                $menu_id = MenuActivity::find($activity_id)->menu_id;
                $request_activity = [
                    'role_id' => $role->id,
                    'menu_id' => $menu_id,
                    'activity_id' => $activity_id
                ];
                RolePermission::updateOrInsert($request_activity,$request_activity);
            }

           foreach (MenuActivity::where('is_dependant',"Yes")->get() as $activity) {
               $menu_id = MenuActivity::find($activity->id)->menu_id;
               $dependant_activity = [
                   'role_id' => $role->id,
                   'menu_id' => $menu_id,
                   'activity_id' => $activity->id
               ];
               RolePermission::updateOrInsert($dependant_activity,$dependant_activity);
           }
        }
        return redirect()->route('role.index')->with(updateMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail(encrypt_decrypt($id,'decrypt'));
        if(User::where('permission_role',$role->id)->exists()) {
            return redirect()->route('role.index')->with(errorMessage($role->title." has been assigned to an agent.update first"));
        }else {
            RolePermission::whereIn('role_id',array($role->id))->delete();
            $role->delete();
            return redirect()->route('role.index')->with(errorMessage());
        }
    }
}
