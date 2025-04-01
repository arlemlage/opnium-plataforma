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
  # This is Calendar Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Vacation;

class CalendarController extends Controller
{
    /**
     * Calendar view
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $allVacations = [];
        $vacations = Vacation::where('del_status', 'Live')->get();

        foreach ($vacations as $key=>$value){
            $allVacations[$key]['id'] = $value->id;
            $allVacations[$key]['title'] = $value->title;
            $allVacations[$key]['start'] = !empty($value->start_date)? date('Y-m-d', strtotime($value->start_date)):'';
            $allVacations[$key]['end'] = !empty($value->end_date)? date('Y-m-d', strtotime($value->end_date)):'';
            $allVacations[$key]['backgroundColor'] = '#7468F0';
            $allVacations[$key]['textColor'] = '#FFF';
        }

        $allVacations = json_encode($allVacations);

        return view('calendar.index', compact('allVacations'));
    }

}
