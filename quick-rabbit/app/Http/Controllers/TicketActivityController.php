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
# This is Ticket Activity Controller
##############################################################################
 */

namespace App\Http\Controllers;

use App\Http\Controllers\MailSendController;
use App\Model\Article;
use App\Model\ArticleGroup;
use App\Model\ChatGroup;
use App\Model\ChatGroupMember;
use App\Model\CustomerNote;
use App\Model\GroupChatMessage;
use App\Model\MailTemplate;
use App\Model\ProductCategory;
use App\Model\Ticket;
use App\Model\TicketNote;
use App\Model\TicketReplyComment;
use App\Model\User;
use App\TicketCommentFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TicketActivityController extends Controller
{

    /**
     * Get Tickets
     */
    public function getTickets(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length");

        $key = request()->get('key');
        $email = request()->get('email');
        $customer_id = str_replace(" ", "+", request()->get('customer_id'));
        $agent_id = request()->get('agent_id');
        if (appTheme() == 'multiple') {
            $product_category_id = request()->get('product_category_id');
        } else {
            $product_category_id = ProductCategory::where('type', 'single')->first()->id;
        }
        $department_id = request()->get('department_id');

        $purchase_code = request()->get('purchase_code');
        $fulltext_search = request()->get('full_text_search');

        $obj = Ticket::ticketCondition()->type();
        $total_object = Ticket::ticketCondition()->type();

        $obj->skip($start);
        $obj->take($rowperpage);

        if (!empty($fulltext_search)) {
            $obj->where(function ($q) use ($fulltext_search) {
                $q->where('title', "LIKE", "%{$fulltext_search}%");
                $q->orWhere('ticket_no', "LIKE", "%{$fulltext_search}%");
                $q->orWhere('envato_u_name', "LIKE", "%{$fulltext_search}%");
            });

            $total_object->where(function ($q) use ($fulltext_search) {
                $q->where('title', "LIKE", "%{$fulltext_search}%");
                $q->orWhere('ticket_no', "LIKE", "%{$fulltext_search}%");
                $q->orWhere('envato_u_name', "LIKE", "%{$fulltext_search}%");
            });
        }
        if (!empty($key) && ($key == 'all')) {
            $obj->whereNotNull('tbl_tickets.status');
            $total_object->whereNotNull('tbl_tickets.status');
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
        if (!empty($key) && ($key == 'flagged')) {
            $obj->whereNotNull('tbl_tickets.flag_status');
            $total_object->whereNotNull('tbl_tickets.flag_status');
        }
        if (!empty($key) && ($key == 'closed')) {
            $obj->where('tbl_tickets.status', 2);
            $total_object->where('tbl_tickets.status', 2);
        }
        if (!empty($key) && ($key == 'archived')) {
            $obj->where('tbl_tickets.archived_status', 1);
            $total_object->where('tbl_tickets.archived_status', 1);
        }

        if (!empty($email)) {
            $obj->where('customer_id', User::where('email', $email)->first()->id ?? '');
            $total_object->where('customer_id', User::where('email', $email)->first()->id ?? '');
        }

        if (!empty($purchase_code)) {
            $obj->where('tbl_tickets.envato_p_code', $purchase_code);
            $total_object->where('tbl_tickets.envato_p_code', $purchase_code);
        }
        if (!empty($customer_id)) {
            $obj->where('tbl_tickets.customer_id', encrypt_decrypt($customer_id, 'decrypt'));
            $total_object->where('tbl_tickets.customer_id', encrypt_decrypt($customer_id, 'decrypt'));
        }

        if (!empty($agent_id)) {
            $id_agent = encrypt_decrypt($agent_id, 'decrypt');
            $obj->whereRaw('FIND_IN_SET("' . $id_agent . '", tbl_tickets.assign_to_ids)');
            $total_object->whereRaw('FIND_IN_SET("' . $id_agent . '", tbl_tickets.assign_to_ids)');
        }

        if ($product_category_id) {
            if (appTheme() == 'multiple') {
                $obj->where('product_category_id', encrypt_decrypt($product_category_id, 'decrypt'));
                $total_object->where('product_category_id', encrypt_decrypt($product_category_id, 'decrypt'));
            } else {
                $obj->where('product_category_id', $product_category_id);
                $total_object->where('product_category_id', $product_category_id);
            }
        }

        if (!empty($department_id)) {
            $obj->where('tbl_tickets.department_id', $department_id);
            $total_object->where('tbl_tickets.department_id', $department_id);
        }

        $obj->orderBy('created_at', 'DESC');
        $tickets = $obj->get();

        $data_arr = array();
        foreach ($tickets as $value) {

            $html_action = '<div class="d-flex gap8">';

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

            // Table data
            $ticket_number = '<a class="gray-color text-decoration-none ' . (needAction($value->id) ? "text-bold" : '') . '" target="_blank" href="' . (url('ticket/' . encrypt_decrypt($value->id, 'encrypt'))) . '">' . $value->ticket_no . '</a>';

            $ticket_title = '<a class="gray-color text-decoration-none ' . (needAction($value->id) ? "text-bold" : '') . '" target="_blank" href="' . (url('ticket/' . encrypt_decrypt($value->id, 'encrypt'))) . '" title="' . $value->title . '">' . substr($value->title, 0, 30) . '</a>';

            if (appTheme() == 'multiple') {
                $product_category = $value->getProductCategory->title ?? "";
            } else {
                $product_category = $value->getDepartment->name ?? "";
            }

            $created_at = $value->created_at->format('M d, y h:i:s');
            $updated_at = $value->updated_at->format('M d, y h:i:s');
            $status = badgeShow(getTicketStatus($value->status), getTicketStatusColor($value->status));
            $last_commented_by = $value->last_comment;
            if (isset($value->getCustomer->mobile) && $value->getCustomer->mobile != null) {
                $customer_name = $value->getCustomer->full_name ?? '' . '<br>' . '(' . ($value->getCustomer->mobile ?? "") . ')';
                $url = url('ticket?key=' . $key . '&customer_id=' . encrypt_decrypt($value->customer_id, 'encrypt'));
                $customer_tickets = '<a class="gray-color text-decoration-none" href="' . $url . '">' . $customer_name . '</a>';
            } else {
                $customer_name = $value->getCustomer->full_name ?? '';
                $url = url('ticket?key=' . $key . '&customer_id=' . encrypt_decrypt($value->customer_id, 'encrypt'));
                $customer_tickets = '<a class="gray-color text-decoration-none" href="' . $url . '">' . $customer_name . '</a>';
            }

            $flag_link = '<a href="' . (url('flag-ticket/' . encrypt_decrypt($value->id, 'encrypt'))) . '"><i class="fa fa-flag ' . (($value->flag_status == 1) ? 'text-danger' : '') . '" aria-hidden="true"></i></a>';

            if (authUserRole() == 3) {
                $data_arr[] = array(
                    "ticket_number" => $ticket_number,
                    "title" => $ticket_title,
                    "product_category" => $product_category,
                    "created_at" => $created_at,
                    "updated_at" => $updated_at,
                    "last_commented_by" => $last_commented_by,
                    "status" => $status,
                    "action" => $html_action,
                );
            } else {
                $data_arr[] = array(
                    "ticket_number" => $ticket_number,
                    "title" => $ticket_title,
                    "product_category" => $product_category,
                    "customer" => $customer_tickets,
                    "created_at" => $created_at,
                    "updated_at" => $updated_at,
                    "last_commented_by" => $last_commented_by,
                    "flag" => $flag_link,
                    "status" => $status,
                    "action" => $html_action,
                );
            }
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => $total_object->count(),
            "aaData" => $data_arr,
        );
        echo json_encode($response);
    }

    /**
     * Store reply on a ticket
     */
    public function postingReplayInTicket(Request $request)
    {

        $this->validate($request, ['ticket_id' => 'required', 'ticket_comment' => 'required']);

        $ticket_id = encrypt_decrypt($request->ticket_id, 'decrypt');

        if (!empty($request->ticket_id)) {
            $ticket_info = Ticket::findOrFail($ticket_id);
            if ($ticket_info->need_action == null) {
                $ticket_info->need_action = (Auth::user()->role_id == 3) ? '1' : null;
                $ticket_info->is_menual_assist = $request->is_menual_assist;
                $ticket_info->save();
            }
        }

        $replay_comment = new TicketReplyComment();
        $replay_comment->ticket_id = !empty($request->ticket_id) ? $ticket_id : null;
        $replay_comment->ticket_comment = !empty($request->ticket_comment) ? $request->ticket_comment : null;
        $replay_comment->ticket_close = !empty($request->ticket_close) ? $request->ticket_close : null;

        if ($replay_comment->save()) {
            Ticket::findOrFail(encrypt_decrypt($request->ticket_id, 'decrypt'))->update(['last_comment_at' => now()]);

            //Check mail address have
            $pattern = '/\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,}\b/';
            preg_match_all($pattern, $request->ticket_comment, $matches);
            if (isset($matches[0]) && count($matches[0]) > 0) {
                $subject = MailTemplate::assignAgentMailSubject($matches[0], $ticket_id);
                $body = MailTemplate::assignAgentMailBody($matches[0], $ticket_id);
                $mail_data = [
                    'to' => $matches[0],
                    'subject' => $subject,
                    'user_name' => $ticket_info->getCustomer->full_name,
                    'body' => $body,
                    'ticket_id' => $ticket_id,
                    'view' => 'ticket_related_template',
                ];
                MailSendController::sendMailToUser($mail_data);
            }

            if (isset($request->file_title) and sizeof($request->files) > 0) {
                foreach ($request->file('files') as $key => $file) {
                    $file_name = Str::slug($request->file_title[$key]);
                    $ticket_document = new TicketCommentFile();
                    $ticket_document->ticket_id = $replay_comment->ticket_id;
                    $ticket_document->comment_id = $replay_comment->id;
                    $ticket_document->file_title = $request->file_title[$key] ?? "None";
                    $ticket_document->file_path = uploadFile($request->file('files')[$key], 'tickets/comment_attachments/', $file_name);
                    $ticket_document->save();
                }
            }

            if (!empty($request->ticket_close && $request->ticket_close == 2)) {
                $ticket_info = Ticket::find($ticket_id);
                $closing_date = now();
                $ticket_info->status = 2;
                $ticket_info->closing_date = $closing_date;
                $from = $ticket_info->created_at;
                $to = $closing_date;
                $duration = $from->diff($to)->format('%H.%I');
                $ticket_info->duration = $duration;
                $ticket_info->save();
                $ticket_info->closeTicket();
                if ($request->is_helpful) {

                    $ticketComment = TicketReplyComment::find($request->is_helpful);
                    $ticketComment->is_helpful = 1;
                    $ticketComment->save();

                }
            }

            return redirect()->back()->with(saveMessage());
        } else {
            return redirect()->back()->with(waringMessage());
        }
    }

    /**
     * Update replied comment
     */
    public function updateReplyComment(Request $request, $comment_id)
    {
        if ($comment_id) {
            $r_comment_info = TicketReplyComment::find($comment_id);
            $r_comment_info->ticket_comment = $request->ticket_comment_update;

            if ($r_comment_info->save()) {
                $ticket = Ticket::findOrFail($r_comment_info->ticket_id);
                $ticket->update(['last_comment_at' => now()]);

                //Check mail address have
                $pattern = '/\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,}\b/';
                preg_match_all($pattern, $request->ticket_comment_update, $matches);
                if (isset($matches[0]) && count($matches[0]) > 0) {
                    $subject = MailTemplate::assignAgentMailSubject($matches[0], $r_comment_info->ticket_id);
                    $body = MailTemplate::assignAgentMailBody($matches[0], $r_comment_info->ticket_id);
                    $mail_data = [
                        'to' => $matches[0],
                        'subject' => $subject,
                        'user_name' => $ticket->getCustomer->full_name,
                        'body' => $body,
                        'ticket_id' => $r_comment_info->ticket_id,
                        'view' => 'ticket_related_template',
                    ];
                    MailSendController::sendMailToUser($mail_data);
                }

                $currentDocs = TicketCommentFile::where('comment_id', $r_comment_info->id)->select('id')->pluck('id')->toArray();
                $requestDocs = $request->file_id;
                if (isset($requestDocs)) {
                    $deletedRows = array_merge(array_diff($currentDocs, $requestDocs), array_diff($requestDocs, $currentDocs));
                    if (count($deletedRows)) {
                        TicketCommentFile::whereIn('id', $deletedRows)->delete();
                    }
                } else {
                    TicketCommentFile::whereIn('id', $currentDocs)->delete();
                }
                if (isset($request->file_title) and sizeof($request->files) > 0) {
                    foreach ($request->file('files') as $key => $file) {
                        $file_name = Str::slug($request->file_title[$key]);
                        $ticket_document = new TicketCommentFile();
                        $ticket_document->ticket_id = $r_comment_info->ticket_id;
                        $ticket_document->comment_id = $r_comment_info->id;
                        $ticket_document->file_title = $request->file_title[$key] ?? "None";
                        $ticket_document->file_path = uploadFile($request->file('files')[$key], 'tickets/comment_attachments/', $file_name);
                        $ticket_document->save();
                    }
                }
                return redirect()->back()->with(updateMessage("Comment has been updated successfully"));
            }
        } else {
            return redirect()->back()->with(waringMessage());
        }
    }

    /**
     * Set flagged on ticket
     */
    public function flagTicket($ticket_id)
    {
        if (!empty($ticket_id)) {
            $id = encrypt_decrypt($ticket_id, 'decrypt');
            $obj = Ticket::find($id);
            $obj->flag_status = ($obj->flag_status == 1) ? null : 1;
            if ($obj->save()) {
                return redirect()->back()->with(updateMessage());
            } else {
                return redirect()->back()->with(waringMessage());
            }
        }
    }

    /**
     * Get editor mentioned data
     */
    public function getEditorMentionedData()
    {
        $category_id = request()->category_id;
        $agent_customer_list = [];
        $agent_customers = DB::table('tbl_users')->select('id', 'email', DB::raw("CONCAT(tbl_users.first_name,' ',tbl_users.last_name) AS full_name"))
            ->where('role_id', 2)
            ->whereRaw("FIND_IN_SET(?, product_cat_ids)", [$category_id])
            ->where('del_status', 'Live')->get();

        foreach ($agent_customers as $key => $value) {
            $agent_customer_list[$key]['id'] = $value->id;
            $agent_customer_list[$key]['fullname'] = $value->full_name;
            $agent_customer_list[$key]['email'] = $value->email;
        }

        return json_encode($agent_customer_list);
    }

    /**
     * Set ticket assigned person or priority
     */
    public function setTicketAssignPriority(Request $request)
    {
        if ($request->ajax() && !empty($request->assign_to_val)) {
            $ticket_id = $request->ticket_id;
            $ticket_info = Ticket::find($ticket_id);
            $running = explode(',', $ticket_info->assign_to_ids);
            $new_assigned = implode(',', $request->assign_to_val);
            $ticket_info->assign_to_ids = $new_assigned;
            $ticket_info->priority = $request->priority_val;
            $new_agent_ids = array_diff_key(explode(',', $new_assigned), $running);

            if ($ticket_info->save()) {

                if (count($new_agent_ids)) {
                    Ticket::newAssignedAgents($new_agent_ids, $ticket_info->id);
                }

                if (authUserRole() == 2) {
                    Ticket::newAssignedAgents($new_agent_ids, $ticket_info->id);
                }

                $data = [
                    'msg' => 'Data has been updated successfully',
                    'get_agents_names_this_ticket' => $ticket_info->assign_agent_names,
                    'status' => 1,
                ];
                return $data;
            } else {
                $data = [
                    'msg' => __('index.select_agent_field_required'),
                    'status' => 0,
                ];
                return $data;
            }
        }
        $data = [
            'msg' => __('index.select_agent_field_required'),
            'status' => 0,
        ];
        return $data;
    }

    /**
     * Set ticket status close or reopen
     */
    public function ticketCloseReopen($ticket_id, $ticket_status)
    {
        if (!empty($ticket_id) && !empty($ticket_status)) {
            $closing_date = now();
            $ticket_info = Ticket::with(['getCustomer', 'getAssignToTicketUser'])->find($ticket_id);
            $ticket_info->status = $ticket_status;
            $ticket_info->closing_date = ($ticket_status == 2) ? $closing_date : null;
            $from = $ticket_info->created_at;
            $to = $closing_date;
            $duration = $from->diff($to)->format('%H.%I');
            $ticket_info->duration = $ticket_status == 2 ? $duration : null;
            if ($ticket_info->save()) {
                // Ticket close
                if ($ticket_status == 2) {
                    $ticket_info->closeTicket();
                } elseif ($ticket_status == 3) {
                    $ticket_info->reopenTicket();
                }

                return redirect()->back()->with(updateMessage());
            } else {
                return redirect()->back()->with(waringMessage());
            }
        } else {
            return redirect()->back()->with(waringMessage());
        }

    }
    public function ticketCloseReopenList($ticket_id, $ticket_status)
    {
        $ticket_id = encrypt_decrypt($ticket_id, 'decrypt');
        if (!empty($ticket_id) && !empty($ticket_status)) {
            $closing_date = now();
            $ticket_info = Ticket::with(['getCustomer', 'getAssignToTicketUser'])->find($ticket_id);
            $ticket_info->status = $ticket_status;
            $ticket_info->closing_date = ($ticket_status == 2) ? $closing_date : null;
            $from = $ticket_info->created_at;
            $to = $closing_date;
            $duration = $from->diff($to)->format('%H.%I');
            $ticket_info->duration = $ticket_status == 2 ? $duration : null;
            if ($ticket_info->save()) {
                // Ticket close
                if ($ticket_status == 2) {
                    $ticket_info->closeTicket();
                } elseif ($ticket_status == 3) {
                    $ticket_info->reopenTicket();
                }

                return redirect()->back()->with(updateMessage());
            } else {
                return redirect()->back()->with(waringMessage());
            }
        } else {
            return redirect()->back()->with(waringMessage());
        }

    }

    /**
     * Archived a ticket
     */
    public function archivedTicket($ticket_id)
    {
        if (!empty($ticket_id)) {
            $id = encrypt_decrypt($ticket_id, 'decrypt');
            $obj = Ticket::find($id);
            $obj->status = 2;
            $obj->archived_status = ($obj->archived_status == 1) ? null : 1;
            if ($obj->save()) {
                return redirect()->back()->with(updateMessage());
            } else {
                return redirect()->back()->with(waringMessage());
            }
        } else {
            return redirect()->back()->with(waringMessage());
        }
    }

    /**
     * Get customer note list in a ticket
     */
    public function addCustomerNote(Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->customer_note) && !empty($request->customer_id)) {
                $obj = new CustomerNote();
                $obj->customer_id = $request->customer_id;
                $obj->note = $request->customer_note;
                $obj->save();
                $notes = '';
                if (!empty($obj->customer_id)) {
                    $notes = CustomerNote::where('customer_id', $request->customer_id)->where('del_status', 'Live')->orderBy('id', 'DESC')->get();
                    foreach ($notes as $key => $note) {
                        $notes .= '<tr>' .
                        '<td>' . ++$key . '</td>' .
                        '<td>' .
                        orgDateFormat($note->created_at) .
                        ' ' . date('h:i A', strtotime($note->created_at)) .
                        '</td>' .
                        '<td>' . $note->note . '</td>' .
                            '</tr>';
                    }
                }
                $data = [
                    'notes' => $notes,
                    'msg' => __('index.customer_note_added_msg'),
                    'status' => 1,
                ];
                return $data;
            } else {
                $data = [
                    'msg' => __('index.customer_note_error_msg'),
                    'status' => 0,
                ];
                return $data;
            }
        } else {
            $data = [
                'msg' => __('index.customer_note_error_msg'),
                'status' => 0,
            ];
            return $data;
        }
    }

    /**
     * Add new note on specific ticket
     */
    public function addTicketNote(Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->ticket_note) && !empty($request->ticket_id)) {
                $obj = new TicketNote();
                $obj->ticket_id = $request->ticket_id;
                $obj->ticket_note = $request->ticket_note;
                $obj->save();
                $notes = '';
                if (!empty($obj->ticket_id)) {
                    $notes = TicketNote::where('ticket_id', $request->ticket_id)->where('del_status', 'Live')->orderBy('id', 'DESC')->get();
                    foreach ($notes as $key => $note) {
                        $notes .= '<tr>' .
                        '<td>' . ++$key . '</td>' .
                        '<td>' .
                        (isset($note->created_at) ? orgDateFormat($note->created_at) : '') .
                        '<br>' . (isset($note->created_at) ? date('h:i A', strtotime($note->created_at)) : '') .
                        '</td>' .
                        '<td>' . $note->ticket_note . '</td>' .
                            '</tr>';
                    }
                }
                $data = [
                    'notes' => $notes,
                    'msg' => __('index.ticket_note_added_msg'),
                    'status' => 1,
                ];
                return $data;
            } else {
                $data = [
                    'msg' => __('index.ticket_note_error_msg'),
                    'status' => 0,
                ];
                return $data;
            }
        } else {
            $data = [
                'msg' => __('index.ticket_note_error_msg'),
                'status' => 0,
            ];
            return $data;
        }
    }

    /**
     * Add ticket cc
     */
    public function addTicketCC(Request $request)
    {
        $ticket = Ticket::find($request->ticket_id);
        $ticket->ticket_cc = $request->cc_email;
        $ticket->save();
        return response()->json(array('status' => true, 'ticket_cc' => Ticket::find($request->ticket_id)->ticket_cc));
    }

    /**
     * Get article search data
     */
    public function getArticleSearchedData(Request $request)
    {
        $title = $request->title;
        $category_id = $request->category;
        $all_articles = '';
        if (!empty($title)) {
            $articles = Article::live()->category($category_id)->where('title', 'LIKE', "%{$title}%")->limit(10)->get();
            foreach ($articles as $title => $article) {
                $product_cat = ProductCategory::find($article->product_category_id);
                $product_slug = $product_cat->slug;
                $url = route('article-details', [$product_slug, $article->title_slug]);
                $all_articles .= '<li class="matched_article bg-article p-2 mb-2 me-2" data-id="' . $article->id . '" data-url="' . $url . '">' . $article->title . '</li>';
            }
            $data = [
                'all_articles' => $all_articles,
                'status' => 1,
            ];
            return $data;
        } else {
            $data = [
                'all_articles' => '',
                'status' => 0,
            ];
            return $data;
        }
    }

    /**
     * Check relevant verification of a product category
     */
    public function checkRelevantVerificationOfProductCat(Request $request)
    {
        if (!empty($request->product_cat_id)) {
            $product_cat = ProductCategory::find($request->product_cat_id);
            return $product_cat;
        } else {
            return 0;
        }
    }

    /**
     * Fetch auto complete data
     */
    public function autocompleteData()
    {
        $query = request()->get('query');
        $lan = auth()->user()->language;
        $product_id = request()->get('product_id');

        if (isset($query)) {
            $query_length = Str::length($query);
            $article = \App\Model\Article::live()->statusActive()->external();
            $faq = \App\Model\Faq::live()->statusActive();
            $blog = \App\Model\Blog::query();
            $page = \App\Model\Pages::query();

            //for full text search
            $article->whereRaw("MATCH(title) AGAINST(? IN NATURAL LANGUAGE MODE)", [$query]);
            if (!empty($product_id)) {
                $article->where('product_category_id', $product_id);
            }

            $article->take(10);
            $article->select('id', 'title', 'title_slug', 'product_category_id', 'article_group_id');
            $articles = $article->get();

            if ($article->count() <= 0) {
                $articleGroup = ArticleGroup::where('title', "LIKE", "%$query%")->live()->pluck('id');
                $article = \App\Model\Article::live()->statusActive()->external();
                $article->whereIn('article_group_id', $articleGroup);
                $article->take(10);
                $article->live();
                $article->select('id', 'title', 'title_slug', 'product_category_id', 'article_group_id');
                $articles = $article->get();
            }

            //for full text search
            $faq->whereRaw("MATCH(question) AGAINST(? IN NATURAL LANGUAGE MODE)", [$query]);
            if (!empty($product_id)) {
                $faq->where('product_category_id', $product_id);
            }
            $faq->take(10);
            $faq->select('id', 'question', 'answer');
            $faqs = $faq->get();

            //for full text search
            $blog->whereRaw("MATCH(title) AGAINST(? IN NATURAL LANGUAGE MODE)", [$query]);
            $blog->live();
            $blog->take(15);
            $blogs = $blog->select('id', 'title', 'slug')->get();

            //for full text search
            $page->whereRaw("MATCH(title) AGAINST(? IN NATURAL LANGUAGE MODE)", [$query]);
            $page->live()->statusActive();
            $page->take(15);
            $pages = $page->select('id', 'title', 'slug')->get();

            $aiData = getAIDatabaseSearch($query);

            return view('ticket.auto_complete_data', compact('articles', 'blogs', 'pages', 'faqs', 'lan', 'query_length', 'aiData'));	

        }

    }

    /**
     * Search ticket title
     */
    public function ticketTitleSearch()
    {
        $key = escapeOutput($_GET["key"]);
        $result = '';
        if (!empty($key)) {
            $tickets = Ticket::ticketCondition()
                ->where(function ($q) use ($key) {
                    $q->where('title', 'LIKE', "%{$key}%");
                    $q->orWhere('ticket_no', 'LIKE', "%{$key}%");
                })

                ->limit(10)->get(['id', 'ticket_no', 'title'])
                ->map(function ($row) use ($key) {
                    $row->highlight_title = preg_replace('/(' . $key . ')/i', "<b>$1</b>", $row->title);
                    return $row;
                });

            foreach ($tickets as $a_key => $ticket) {
                $off_white = ($a_key % 2 == 1) ? '' : 'off_white';
                $result .= '<li class="result_li ' . $off_white . '">
                                <div class=" mx_c_10 ">
                                    <a href="' . url("ticket/" . encrypt_decrypt($ticket->id, 'encrypt')) . '" target="_blank" class="">' . $ticket->ticket_no . ': ' . $ticket->highlight_title . '</a>
                                </div>
                            </li>';
                $off_white = '';
            }
        }
        $data = [
            'result' => $result,
        ];
        return $data;
    }

    /**
     * Send payment request to customer
     */
    public function sendPaymentRequest(Request $request)
    {
        $this->validate($request, ['ticket_id' => 'required', 'amount' => 'required']);
        $ticket = Ticket::findOrFail($request->ticket_id);
        $ticket->paid_support = $request->is_paid;
        $ticket->amount = $request->is_paid == "Yes" ? $request->amount : 0;
        $ticket->save();
        if ($request->is_paid == "Yes") {
            $ticket_title = $ticket->title;
            $mail_data = [
                'to' => array($ticket->getCustomer->email),
                'subject' => "Ticket marked as paid support",
                'user_name' => $ticket->getCustomer->full_name,
                'body' => 'Your ticket ' . $ticket->ticket_id . ' has been marked as paid support and charge amount is $' . $request->amount . '.',
                'payment_url' => url('make-payment', encrypt_decrypt($ticket->id, 'encrypt')),
                'view' => 'paid_support_mail_template',
            ];
            MailSendController::sendMailToUser($mail_data);
        }

        return redirect()->back()->with(updateMessage());
    }

    /**
     * Create a new group by admin/agent
     */
    public function createChatGroup($id)
    {
        $ticket = Ticket::findOrFail(encrypt_decrypt($id, 'decrypt'));
        $condition = [
            'ticket_id' => $ticket->id,
            'product_id' => $ticket->product_category_id,
        ];
        if (ChatGroup::where($condition)->exists()) {
            return redirect()->back()->with(waringMessage("A chat has been already opened for this ticket"));
        }
        $group = new ChatGroup();
        $group->created_by = Auth::id();
        $group->product_id = $ticket->product_category_id;
        $group->ticket_id = $ticket->id;
        $group_code = ChatGroup::getGroupCode();
        if (ChatGroup::where('code', $group_code)->exists()) {
            $group_code = ChatGroup::getGroupCode();
        }
        $group->code = $group_code;
        $group->name = ProductCategory::find($ticket->product_category_id)->title . ' - ' . Auth::user()->full_name . ' - ' . $ticket->ticket_no;
        $group->status = "Active";
        $group->save();

        $group_members = [];
        array_push($group_members, Auth::id());
        array_push($group_members, $ticket->customer_id);

        foreach ($group_members as $user) {
            $group_member = new ChatGroupMember();
            $group_member->group_id = $group->id;
            $group_member->user_id = $user;
            $group_member->save();
        }
        GroupChatMessage::insert([
            'from_id' => Auth::id(),
            'user_type' => "forward",
            'group_id' => $group->id,
            'message' => getUserName(authUserId()) . ' open a chat to ' . getUserName($ticket->customer_id),
            'created_at' => now(),
        ]);

        GroupChatMessage::insert([
            'from_id' => Auth::id(),
            'user_type' => Auth::user()->type,
            'group_id' => $group->id,
            'message' => getUserName(authUserId()) . ' open a chat to ' . getUserName($ticket->customer_id),
            'created_at' => now(),
        ]);

        ChatGroup::findOrFail($group->id)->update(['last_message_at' => now()]);
        $email = User::where('id', $ticket->customer_id)->first()->email;
        $mail_data = [
            'to' => array($email),
            'subject' => "A new chat has been open.",
            'body' => "An admin/agent has been open a new chat " . $group->name . ' for you.Please login to the site and check your inbox',
            'view' => 'cc-mail-template',
        ];
        MailSendController::sendMailToUser($mail_data);

        return redirect()->route('live-chat')->with(updateMessage("Chat request has been sent to customer successfully!"));
    }

    public function setAiReply(Request $request)
    {
        $ticket_id = $request->ticket_id;
        $p_id = $request->p_id;
        $ticket_id_tmp = $ticket_id;
        $ticket_id = encrypt_decrypt($ticket_id, 'decrypt');
        $ticket = Ticket::find($ticket_id);
        $return['msg'] = '';
        if ($ticket && $ticket->is_ai_replay_generate != 1) {
            $ai_return_data = getFullTextDataForAI($ticket->title, $ticket_id, $p_id);
            if ($ai_return_data) {
                $return['msg'] = 'AI found some solution for you and responded you via reply, please <a href="' . baseURL() . '/ticket/' . $ticket_id_tmp . '" class="set_replay_btns">Click Here</a> to see the reply';

                $obj = Ticket::find($ticket_id);
                $obj->is_ai_replay_generate = 1;
                $obj->save();

                $replay_comment = new TicketReplyComment();
                $replay_comment->ticket_id = $ticket_id;
                $replay_comment->ticket_comment = $ai_return_data;
                $replay_comment->ticket_close = null;
                $replay_comment->is_customer = 2;
                $replay_comment->is_ai_replied = 1;
                $replay_comment->save();

            } else {
                $return['msg'] = 'Sorry that the AI could not find any instant solution, please wait for an Agent to reply you. You will be notified via email. <a href="' . baseURL() . '/ticket/' . $ticket_id_tmp . '" class="set_replay_btns">Click Here</a> to see your ticket';
            }
        } else {
            $return['msg'] = 'AI found some solution for you and responded you via reply, please <a href="' . baseURL() . '/ticket/' . $ticket_id_tmp . '" class="set_replay_btns">Click Here</a> to see the reply';
        }
        echo json_encode($return);
    }

}
