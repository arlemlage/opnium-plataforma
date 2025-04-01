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
  # This is Ticket Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\Model\Tag;
use App\Model\User;
use App\Model\Ticket;
use App\Model\TicketFile;
use App\Model\TicketNote;
use App\Model\CustomField;
use App\Model\ArticleGroup;
use App\Model\CustomerNote;
use Illuminate\Support\Str;
use App\Model\CannedMessage;
use App\Model\Department;
use App\Model\TicketSetting;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Model\ProductCategory;
use App\Model\TicketReplyComment;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if(authUserRole() == 1) {
            $customers = User::customer()->live()->where('id', '!=', 3)->get();
            $product_categories = ProductCategory::live()->type()->get();
        } elseif(authUserRole() == 2) {
            $customer_ids = Ticket::type()->whereIn('id',auth()->user()->ticket_ids)->pluck('customer_id');
            $customers = User::whereIn('id',$customer_ids)->customer()->live()->get();
            if(auth()->user()->product_cat_ids == null) {
                $product_categories = ProductCategory::live()->type()->get();
            } else {
                $product_categories = ProductCategory::whereIn('id',explode(',',auth()->user()->product_cat_ids))->live()->type()->get(); 
            }
        } else {
            $customers = [];
            $product_categories = [];
        }

        $agents = DB::table('tbl_users')->select('id', DB::raw("CONCAT(tbl_users.first_name,' ',tbl_users.last_name) AS full_name"))
            ->where('role_id', 2)->where('del_status','Live')->get();

        $product_cat = ProductCategory::live()->type()->get();

        $key = request()->get('key');
        $email = request()->get('email');
        $customer_id = request()->get('customer_id');
        $agent_id = request()->get('agent_id');
        $product_category_id = request()->get('product_category_id');
        $department_id = request()->get('department_id');
        $purchase_code = request()->get('purchase_code');
        $fulltext_search = request()->get('full_text_search');
        if($product_category_id){
            $category_id = encrypt_decrypt($product_category_id, 'decrypt');
            $all_t = Ticket::ticketCondition()->type()->where('product_category_id', $category_id)->count();
            $all_t_open = Ticket::ticketCondition()->type()->where('product_category_id', $category_id)->where(function ($q)  {
                $q->where('status', 1);
                $q->OrWhere('status',3);
            })->count();
    
            $all_t_need_action = Ticket::ticketCondition()->type()->where('product_category_id', $category_id)->where('need_action', 1)->count();
            $all_t_flag = Ticket::ticketCondition()->type()->where('product_category_id', $category_id)->where('flag_status', 1)->count();
            $all_t_closed = Ticket::ticketCondition()->type()->where('product_category_id', $category_id)->where('status', 2)->count();
            $all_t_archived = Ticket::ticketCondition()->type()->where('product_category_id', $category_id)->where('archived_status', 1)->count();
        }else{
            $all_t = Ticket::ticketCondition()->type()->count();
            $all_t_open = Ticket::ticketCondition()->type()->where(function ($q)  {
                $q->where('status', 1);
                $q->OrWhere('status',3);
            })->count();
    
            $all_t_need_action = Ticket::ticketCondition()->type()->whereIn('id', needActionTicketIds())->count();
            $all_t_flag = Ticket::ticketCondition()->type()->where('flag_status', 1)->count();
            $all_t_closed = Ticket::ticketCondition()->type()->where('status', 2)->count();
            $all_t_archived = Ticket::ticketCondition()->type()->where('archived_status', 1)->count();
        }
    

        $data = [
            'all_t' => $all_t > 99 ? '99+' : $all_t,
            'all_t_open' => $all_t_open > 99 ? '99+' : $all_t_open,
            'all_t_need_action' => $all_t_need_action > 99 ? '99+' : $all_t_need_action,
            'all_t_flag' => $all_t_flag > 99 ? '99+' : $all_t_flag,
            'all_t_closed' => $all_t_closed > 99 ? '99+' : $all_t_closed,
            'all_t_archived' => $all_t_archived > 99 ? '99+' : $all_t_archived,
            'key' => $key,
            'email' => $email,
            'customer_id' => $customer_id,
            'agent_id' => $agent_id,
            'product_category_id' => $product_category_id,
            'department_id' => $department_id,
            'purchase_code' => $purchase_code,
            'fulltext_search' => $fulltext_search
        ];
        $departments = Department::live()->get();
        return view('ticket.ticket_list', $data, compact('customers', 'product_cat','product_categories', 'agents','departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $product_category = ProductCategory::live()->type()->select('title', 'id','verification')->get();
        $article_group = ArticleGroup::live()->pluck('title', 'id');
        $tag = Tag::live()->pluck('title', 'id');
        $ticket_setting_info = TicketSetting::first();
        $customers = User::customer()->where('id', '!=', 3)->live()->get();
        $departments = Department::live()->get();
        return view('ticket.add_edit', compact('product_category', 'article_group', 'tag', 'ticket_setting_info', 'customers', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'product_category_id' => 'required',
            'customer_id' => 'required',
            'title' => 'required|max:255',
            'priority' => 'required',
            'ticket_content' => 'required|max:5000',
        ],[
            'product_category_id.required' => __('index.product_category_id_required'),
            'customer_id.required' => __('index.customer_id_required'),
            'title.required' => __('index.title_required'),
            'title.max' => __('index.title.max'),
            'priority.required' => __('index.priority_required'),
            'ticket_content.required' => __('index.ticket_content_required'),
        ]);
        $get_assigned_agents = ProductCategory::assignedAgents($request->product_category_id);
        $product_category_info = ProductCategory::find($request->product_category_id);

        $ticket_count = Ticket::where('product_category_id',$product_category_info->id)->count();        
        $ticket_no = $product_category_info->product_code.' #'.($ticket_count + 1);

        $ticket = new Ticket();
        $ticket->ticket_no = $ticket_no;
        $ticket->product_category_id = $request->product_category_id;
        if($request->department_id) {
            $ticket->department_id = $request->department_id;
        }
        $ticket->customer_id = $request->customer_id;
        $ticket->envato_u_name = (!empty($request->envato_u_name) && ($product_category_info->verification==1))? $request->envato_u_name:null;
        $ticket->envato_p_code = (!empty($request->envato_p_code) && ($product_category_info->verification==1))? $request->envato_p_code:null;
        $ticket->title = empty($request->title)? null: getPlainText($request->title);
        $ticket->priority = empty($request->priority)? null:$request->priority;
        $ticket->assign_to_ids = empty($get_assigned_agents)? null:implode(',', $get_assigned_agents);
        $ticket->ticket_content = empty($request->ticket_content)? null:$request->ticket_content;
        if(CustomField::where('product_category_id',$request->product_category_id)->exists()) {
            $product_field = CustomField::where('product_category_id',$request->product_category_id)->firstOrFail();
            $ticket->custom_field_data = empty($request->custom_field_data)? null:json_encode($request->custom_field_data);
            $ticket->custom_field_type = empty($product_field->custom_field_type)? null:($product_field->custom_field_type);
            $ticket->custom_field_label = empty($product_field->custom_field_label)? null:($product_field->custom_field_label);
            $ticket->custom_field_option = empty($product_field->custom_field_option)? null:($product_field->custom_field_option);
            $ticket->custom_field_required = empty($product_field->custom_field_required)? null:($product_field->custom_field_required);
        }
        $ticket->status = 1;
        if ($ticket->save()){
            if(isset($request->file_title) AND sizeof($request->files) > 0){
                foreach($request->file('files') as $key=>$file){
                    $file_name = Str::slug($request->file_title[$key]);
                    $ticket_document = new TicketFile();
                    $ticket_document->ticket_id = $ticket->id;
                    $ticket_document->file_title = $request->file_title[$key] ?? "None";
                    $ticket_document->file_path = uploadFile($request->file('files')[$key],'tickets/ticket_attachments/',$file_name);
                    $ticket_document->save();
                }
            }
            if (aiInfo()['type'] == "Yes"){
                return redirect('ai-checking-instant-solution/'.encrypt_decrypt($ticket->id, 'encrypt'));
            }else{
                return redirect('ticket/'.encrypt_decrypt($ticket->id, 'encrypt'))->with(saveMessage());
            }
            
        } else{
            return redirect()->back()->with(waringMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $id = encrypt_decrypt($id, 'decrypt');
        $obj = Ticket::findOrFail($id);
        if(authUserRole() == 2) {
            if(! in_array($id,auth()->user()->ticket_ids)) {
                return redirect()->route('user-home')->with("error","You have no permission to access this ticket");
            }
        } elseif(authUserRole() == 3) {
            if(authUserId() != $obj->customer_id) {
                return redirect()->route('user-home')->with("error","You have no permission to access this ticket");        
            }
        }
        $last_response = TicketReplyComment::with('getCreatedBy')->where('ticket_id', $obj->id)->orderBy('id', 'DESC')->first();

        $custom_field_data = !empty($obj->custom_field_data)? json_decode($obj->custom_field_data): [];
        $custom_field_type = !empty($obj->custom_field_type)? json_decode($obj->custom_field_type):[];
        $custom_field_label = !empty($obj->custom_field_label)? json_decode($obj->custom_field_label):[];
        $custom_field_option = !empty($obj->custom_field_option)? json_decode($obj->custom_field_option):[];
        $custom_field_required = !empty($obj->custom_field_required)? json_decode($obj->custom_field_required):[];

        $customer = '';
        $notes = [];

        if (!empty($obj->customer_id)){
            $notes = CustomerNote::where('customer_id', $obj->customer_id)->live()->orderBy('created_at', 'DESC')->get();
        }

        $ticket_notes = [];
        if (!empty($obj->id)){
            $ticket_notes = TicketNote::where('ticket_id', $obj->id)->live()->orderBy('created_at', 'DESC')->get();
        }

        $canned_message = CannedMessage::live()->orderBy('id', 'DESC')->get();
        $reply_comments = TicketReplyComment::live()->where('ticket_id', $obj->id)->get();
        $all_agents = DB::table('tbl_users')->select('id', DB::raw("CONCAT(tbl_users.first_name,' ',tbl_users.last_name) AS full_name"))
            ->where('del_status','Live')->where('role_id', '!=',3)->get()->pluck('full_name', 'id');
        $all_agents_this_ticket = DB::table('tbl_users')
            ->select('id', DB::raw("CONCAT(tbl_users.first_name,' ',tbl_users.last_name) AS full_name"))
            ->where('del_status','Live')->where('role_id', 2)->whereIn('id', explode(',', $obj->assign_to_ids))->get();


        $data = [
            'custom_field_data' => $custom_field_data,
            'custom_field_type' => $custom_field_type,
            'custom_field_label' => $custom_field_label,
            'custom_field_option' => $custom_field_option,
            'custom_field_required' => $custom_field_required,
            'last_response' => $last_response,
            'all_agents' => $all_agents,
            'all_agents_this_ticket' => $all_agents_this_ticket,
        ];

        return view('ticket.ticket_details', $data, compact('obj', 'customer', 'notes', 'ticket_notes', 'canned_message', 'reply_comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $id = encrypt_decrypt($id, 'decrypt');
        $obj = Ticket::find($id);
        $product_verification_info = ProductCategory::find($obj->product_category_id);

        $product_category = ProductCategory::live()->type()->pluck('title', 'id');
        $article_group = ArticleGroup::live()->pluck('title', 'id');
        $tag = Tag::live()->pluck('title', 'id');
        $ticket_setting_info = TicketSetting::first();

        $customers = User::where('role_id',3)->where('id', '!=', 3)->where('del_status','Live')->get();

        $custom_field_data = !empty($obj->custom_field_data)? json_decode($obj->custom_field_data): [];
        $custom_field_type = !empty($obj->custom_field_type)? json_decode($obj->custom_field_type):[];
        $custom_field_label = !empty($obj->custom_field_label)? json_decode($obj->custom_field_label):[];
        $custom_field_option = !empty($obj->custom_field_option)? json_decode($obj->custom_field_option):[];
        $custom_field_required = !empty($obj->custom_field_required)? json_decode($obj->custom_field_required):[];

        $data = [
            'custom_field_data' => $custom_field_data,
            'custom_field_type' => $custom_field_type,
            'custom_field_label' => $custom_field_label,
            'custom_field_option' => $custom_field_option,
            'custom_field_required' => $custom_field_required,
        ];

        return view('ticket.addEditTicket', $data, compact('obj', 'product_verification_info', 'product_category', 'article_group', 'tag', 'ticket_setting_info', 'customers'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $id = encrypt_decrypt($id, 'decrypt');
        $obj = Ticket::find($id);
        $obj->del_status = "Deleted";
        $obj->save();
        return redirect('ticket')->with(deleteMessage());
    }
    
    /**
     * Convert ticket as article
     * @param int $ticket_id
     */
    public function ticketConvertToArticle($ticket_id){
        $id = encrypt_decrypt($ticket_id, 'decrypt');
        $obj = Ticket::find($id);
        $product_category = ProductCategory::live()->type()->pluck('title', 'id');
        $article_group = ArticleGroup::live()->pluck('title', 'id');
        $tag = Tag::live()->pluck('title', 'id');
        return view('ticket.convert_as_article', compact('product_category', 'article_group', 'tag', 'obj'));
    }
    
    /**
     * AI Checking Instant Solution for ticket.
     * @param int $ticket_id
     */
    public function aiCheckingInstantSolution($ticket_id){
        $id = encrypt_decrypt($ticket_id, 'decrypt');
        $obj = Ticket::find($id);
        return view('ticket.ai_reply_checker', compact('obj','ticket_id'));
    }
    

}
