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
# This is Dashboard Controller
##############################################################################
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\ChatGroup;
use App\Model\Ticket;
use App\Model\TicketReplyComment;
use App\Model\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Redirect to dashboard
     */
    public function index()
    {
        if (authUserRole() == 3) {
            return view('customer_dashboard');
        } else {
            $today = Carbon::today();
            $key = request()->get('key');
            $customer_id = request()->get('customer_id');
            $purchase_code = request()->get('purchase_code');

            $data = Ticket::ticketCondition()->type();
            if (!empty($key) && ($key == 'all')) {
                $data->whereNotNull('tbl_tickets.status');
            }
            if (!empty($key) && ($key == 'open')) {
                $data->where('tbl_tickets.status', 1);
            }
            if (!empty($key) && ($key == 'open_seven_plus_d')) {
                $data->where('tbl_tickets.status', 1);
                $data->where('tbl_tickets.created_at', '<=', now()->subDays(7));
            }
            if (!empty($key) && ($key == 'n_action')) {
                $data->whereIn('id', needActionTicketIds());
                $data->orderBy('id', 'DESC');
                $data->orderBy('last_comment_at', 'DESC');
            }
            if (!empty($purchase_code)) {
                $data->where('tbl_tickets.envato_p_code', $purchase_code);
            }
            if (!empty($key) && ($key == 'flagged')) {
                $data->whereNotNull('tbl_tickets.flag_status');
            }
            if (!empty($key) && ($key == 'closed')) {
                $data->where('tbl_tickets.status', 2);
            }
            if (!empty($key) && ($key == 'archived')) {
                $data->where('tbl_tickets.archived_status', 1);
            }

            if (!empty($customer_id)) {
                $data->where('tbl_tickets.customer_id', encrypt_decrypt($customer_id, 'decrypt'));
                $totalRecords = $data->count();
            }

            $tickets = $data->oldest('id')->paginate(30);

            $open_tickets = Ticket::ticketCondition()->type()->where('del_status', 'Live')->where('status', 1)->orWhere('status', 3)->count();
            $closed_tickets = Ticket::ticketCondition()->where('del_status', 'Live')->type()->where('status', 2)->count();
            $open_chats = Ticket::ticketCondition()->where('del_status', 'Live')->type()->where('status', 1)->count();
            $total_agents = User::where('del_status', 'Live')->where('role_id', 2)->count();

            $ticket_need_actions = Ticket::ticketCondition()->where('del_status', 'Live')->type()->where('need_action', 1)->get();
            $recent_chats = TicketReplyComment::with(['get_ticket_info', 'getCreatedBy'])->where('del_status', 'Live')->orderBy('id', 'DESC')->get();

            $all_t = Ticket::ticketCondition()->type()->count();
            $all_t_open = Ticket::ticketCondition()->type()->where(function ($q) {
                $q->where('status', 1);
                $q->OrWhere('status', 3);
            })->count();

            $all_t_need_action = Ticket::ticketCondition()->type()->whereIn('id', needActionTicketIds())->count();
            $all_t_flag = Ticket::ticketCondition()->type()->where('flag_status', 1)->count();
            $all_t_closed = Ticket::ticketCondition()->type()->where('status', 2)->count();
            $all_t_archived = Ticket::ticketCondition()->type()->where('archived_status', 1)->count();

            $previous_month_open_ticket = Ticket::ticketCondition()->type()->where('status', 1)->whereMonth('created_at', now()->subMonth()->month)->count();
            $current_month_open_ticket = Ticket::ticketCondition()->type()->where('status', 1)->whereMonth('created_at', now()->month)->count();
            $percentage_open_ticket = calculatePercentageIncrease($previous_month_open_ticket, $current_month_open_ticket);

            $previous_month_closed_ticket = Ticket::ticketCondition()->type()->where('status', 2)->whereMonth('created_at', now()->subMonth()->month)->count();
            $current_month_closed_ticket = Ticket::ticketCondition()->type()->where('status', 2)->whereMonth('created_at', now()->month)->count();
            $percentage_closed_ticket = calculatePercentageIncrease($previous_month_closed_ticket, $current_month_closed_ticket);

            $previous_month_open_chat = ChatGroup::where('status', 'Active')->whereMonth('created_at', now()->subMonth()->month)->count();
            $current_month_open_chat = ChatGroup::where('status', 'Active')->whereMonth('created_at', now()->month)->count();
            $percentage_open_chat = calculatePercentageIncrease($previous_month_open_chat, $current_month_open_chat);

            $previous_month_agents = User::where('role_id', 2)->whereMonth('created_at', now()->subMonth()->month)->count();
            $current_month_agents = User::where('role_id', 2)->whereMonth('created_at', now()->month)->count();
            $percentage_agents = calculatePercentageIncrease($previous_month_agents, $current_month_agents);

            $open_for_seven_d = Ticket::ticketCondition()->where('tbl_tickets.status', 1)->type()->where('del_status', 'Live')
                ->where('tbl_tickets.created_at', '<=', now()->subDays(7))->count();

            $data = [
                'open_tickets' => $open_tickets,
                'closed_tickets' => $closed_tickets,
                'open_chats' => $open_chats,
                'total_agents' => $total_agents,
                'ticket_need_actions' => $ticket_need_actions,
                'recent_chats' => $recent_chats,
                'all_t' => $all_t > 99 ? '99+' : $all_t,
                'all_t_open' => $all_t_open > 99 ? '99+' : $all_t_open,
                'all_t_need_action' => $all_t_need_action > 99 ? '99+' : $all_t_need_action,
                'purchase_code' => $purchase_code,
                'all_t_flag' => $all_t_flag > 99 ? '99+' : $all_t_flag,
                'all_t_closed' => $all_t_closed > 99 ? '99+' : $all_t_closed,
                'all_t_archived' => $all_t_archived > 99 ? '99+' : $all_t_archived,
                'open_for_seven_d' => $open_for_seven_d > 99 ? '99+' : $open_for_seven_d,
                'percentage_open_ticket' => $percentage_open_ticket,
                'percentage_closed_ticket' => $percentage_closed_ticket,
                'percentage_open_chat' => $percentage_open_chat,
                'percentage_agents' => $percentage_agents,
            ];
            return view('dashboard', $data, compact('today', 'tickets', 'key'));
        }
    }

    /**
     * Get Tickets
     */
    public function getTickets(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length");
        $key = request()->get('key');
        $obj = Ticket::ticketCondition()->type();
        $total_object = Ticket::ticketCondition()->type();
        $obj->skip($start);
        $obj->take($rowperpage);

        if (!empty($key) && ($key == 'open_seven_plus_d')) {
            $obj->where('tbl_tickets.status', 1)->where('tbl_tickets.created_at', '<=', now()->subDays(7));
            $total_object->where('tbl_tickets.status', 1)->where('tbl_tickets.created_at', '<=', now()->subDays(7));
        }

        if (!empty($key) && ($key == 'open')) {
            $obj->where(function ($q) {
                $q->where('status', 1);
                $q->OrWhere('status', 3);
            });
            $total_object->where(function ($q) {
                $q->where('status', 1);
                $q->OrWhere('status', 3);
            });
        }

        if (!empty($key) && ($key == 'n_action')) {
            $obj->whereIn('id', needActionTicketIds());
            $obj->orderBy('id', 'DESC');
            $obj->orderBy('last_comment_at', 'DESC');
            $total_object->whereIn('id', needActionTicketIds());
        }

        $obj->orderBy('created_at', 'DESC');
        $tickets = $obj->get()
            ->map(function ($row) {
                return $row;
            });

        $data_arr = array();
        foreach ($tickets as $key => $value) {

            $html_action = '<div class="d-flex action_flex">';

            $html_action .= '<a href="' . (url('ticket/' . encrypt_decrypt($value->id, 'encrypt'))) . '" class="edit" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Details">
                                            <i class="fa fa-eye"></i>
                                        </a>';
            if (authUserRole() != 3) {
                if (($value->status == 1) || ($value->status == 3)) {
                    $html_action .= '<a href="' . (url('ticket-close-directly/' . encrypt_decrypt($value->id, 'encrypt'))) . '/2" class="edit closeBtn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Close">
                                        <i class="fa fa-times"></i>
                                    </a>';
                }
                $html_action .= '<a href="' . (url('ticket-archived/' . encrypt_decrypt($value->id, 'encrypt'))) . '" class="edit closeBtn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Archived">
                                    <i class="fa fa-archive"></i>
                                </a>';

            }
            if (authUserRole() != 3) {
                $html_action .= '<a href="' . (url('ticket-convert-to-article/' . encrypt_decrypt($value->id, 'encrypt'))) . '" class="edit" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Convert as article">
                                    <i class="fa fa-tasks"></i>
                                </a>';
            }

            $html_action .= '<a href="' . (url('ticket-edit/' . encrypt_decrypt($value->id, 'encrypt'))) . '" class="edit displayNone" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a>';
            $html_action .= '<a href="' . (url('ticket-delete/' . encrypt_decrypt($value->id, 'encrypt'))) . '" class="delete displayNone" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Delete">
                                <i class="fa fa-trash"></i>
                            </a>';

            $html_action .= '</div>';

            $ticket_number = '<a class="gray-color text-decoration-none ' . (needAction($value->id) ? "text-bold" : '') . '" target="_blank" href="' . (url('ticket/' . encrypt_decrypt($value->id, 'encrypt'))) . '">' . $value->ticket_no . '</a>';

            $ticket_title = '<a class="gray-color text-decoration-none ' . (needAction($value->id) ? "text-bold" : '') . '" target="_blank" href="' . (url('ticket/' . encrypt_decrypt($value->id, 'encrypt'))) . '">' . $value->title . '</a>';
            if (appTheme() == 'single') {
                $product_category = $value->getDepartment->name ?? "";
            } else {
                $product_category = $value->getProductCategory->title ?? "";
            }

            $customer_name = '';
            if ($value->getCustomer->mobile != null) {
                $customer_name = $value->getCustomer->full_name . '<br>' . '(' . $value->getCustomer->mobile . ')';
                $url = url('ticket?key=' . $key . '&customer_id=' . encrypt_decrypt($value->customer_id, 'encrypt'));
                $customer_tickets = '<a class="gray-color text-decoration-none" href="' . $url . '">' . $customer_name . '</a>';
            } else {
                $customer_name = $value->getCustomer->full_name;
                $url = url('ticket?key=' . $key . '&customer_id=' . encrypt_decrypt($value->customer_id, 'encrypt'));
                $customer_tickets = '<a class="gray-color text-decoration-none" href="' . $url . '">' . $customer_name . '</a>';
            }

            $created_at = $value->created_at->format('M d, y h:i:s');
            $updated_at = $value->updated_at->format('M d, y h:i:s');
            $last_commented_by = $value->last_comment;

            $data_arr[] = array(
                "sn" => $key + 1,
                "ticket_id" => $ticket_number,
                "title" => $ticket_title,
                "product_category" => $product_category,
                "customer" => $customer_tickets,
                "created_at" => $created_at,
                "updated_at" => $updated_at,
                "last_commented_by" => $last_commented_by,
                "action" => $html_action,
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => $total_object->count(),
            "aaData" => $data_arr,
        );

        echo json_encode($response);
    }

    public function chartData()
    {
        $getMonth = request('month') ?? 6;
        $current_month = date('m');
        $previous_six_month = getPreviousMonthName($getMonth);
        $totalTicket = [];
        $openTicket = [];
        $closeTicket = [];

        $months = [];
        for ($i = 0, $iMax = count($previous_six_month); $i < $iMax; $i++) {
            $value = explode("-", $previous_six_month[$i]);
            $month = $value[0];
            $year = $value[1];
            
            $totalTicket[] = Ticket::ticketCondition()->whereMonth('created_at', $month)->whereYear('created_at', $year)->type()->count();
            $openTicket[] = Ticket::ticketCondition()->where('status', 1)->whereMonth('created_at', $month)->whereYear('created_at', $year)->type()->count();
            $closeTicket[] = Ticket::ticketCondition()->where('status', 2)->whereMonth('closing_date', $month)->whereYear('closing_date', $year)->type()->count();

            $months[] = date('F', mktime(0, 0, 0, $month, 10));
        }
        return response()->json([
            'total_ticket' => $totalTicket,
            'open_ticket' => $openTicket,
            'close_ticket' => $closeTicket,
            'months' => $months,
        ]);
    }

    public function ticketByCategory()
    {
        if (appTheme() == 'multiple') {
            $ticketByCategory = Ticket::ticketCondition()->type()->selectRaw('count(*) as count, product_category_id')
                ->groupBy('product_category_id')
                ->get();
            $categories = [];
            $totalTickets = [];
            foreach ($ticketByCategory as $key => $value) {
                $categories[] = $value->getProductCategory->title;
                $totalTickets[] = $value->count;
            }
        }

        if (appTheme() == 'single') {
            $ticketByCategory = Ticket::type()->selectRaw('count(*) as count, department_id')
                ->groupBy('department_id')
                ->get();
            $categories = [];
            $totalTickets = [];
            foreach ($ticketByCategory as $key => $value) {
                $categories[] = $value->getDepartment->name;
                $totalTickets[] = $value->count;
            }
        }

        return response()->json([
            'categories' => $categories,
            'total_tickets' => $totalTickets,
        ]);
    }
}
