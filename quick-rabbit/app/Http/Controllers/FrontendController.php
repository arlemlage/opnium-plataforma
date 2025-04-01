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
# This is Frontend Controller
##############################################################################
 */

namespace App\Http\Controllers;

use App\Events\GroupChat;
use App\Events\GuestMessage;
use App\Events\MakeSeen;
use App\Http\Controllers\MailSendController;
use App\Model\Article;
use App\Model\ArticleComment;
use App\Model\ArticleGroup;
use App\Model\Blog;
use App\Model\BlogCategory;
use App\Model\BlogComment;
use App\Model\ChatGroup;
use App\Model\ChatGroupMember;
use App\Model\Faq;
use App\Model\Forum;
use App\Model\ForumComment;
use App\Model\GroupChatMessage;
use App\Model\MailTemplate;
use App\Model\Pages;
use App\Model\ProductCategory;
use App\Model\Tag;
use App\Model\User;
use App\Model\UserVerify;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Mpdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PHPUnit\TextUI\XmlConfiguration\Group;

class FrontendController extends Controller
{
    /**
     * Redirect to home page
     *
     */
    public function index()
    {
        $is_valid = isset($_GET['is_valid']) && $_GET['is_valid'] ? $_GET['is_valid'] : '';
        if ($is_valid) {
            $data['is_valid'] = $is_valid;
            $data['base_url'] = baseUrl() . "/";
            echo json_encode($data);
        } else {
            $faq = Faq::statusActive()->general()->live()->latest('id')->get();
            $blogs = Blog::statusActive()->live()->orderBy('updated_at', 'desc')->take(12)->get();
            $products = ProductCategory::with([
                'article_groups' => function ($query) {
                    $query->live();
                    $query->with([
                        'articles' => function ($article) {
                            $article->live()->statusActive()->external();
                        },
                    ]);
                },
            ])->statusActive()->live()->type()->get();
            $testimonials = \App\Model\Testimonial::live()->get();

            $videoArticles = Article::whereNotNull('video_link')
                ->with('getArticleGroup')
                ->get()
                ->groupBy('article_group_id');

            // Most Discussed Topic
            $most_discussed_topic = Forum::mostCommentedForum();
            if (appTheme() == 'single') {
                return view('frontend.second_home', compact('faq', 'blogs', 'products', 'testimonials', 'most_discussed_topic'));
            } else {

                return view('frontend.home', compact('faq', 'blogs', 'products', 'videoArticles', 'testimonials'));
            }
        }
    }
    /**
     * Redirect to internal error page
     *
     */
    public function internalError()
    {
        $faq = Faq::statusActive()->live()->latest('id')->get();
        $blogs = Blog::statusActive()->live()->orderBy('updated_at', 'desc')->take(3)->get();
        $products = ProductCategory::with([
            'article_groups' => function ($query) {
                $query->live();
                $query->with([
                    'articles' => function ($article) {
                        $article->live()->statusActive()->external();
                    },
                ]);
            },
        ])->statusActive()->live()->type()->get();
        return view('frontend.internal_error', compact('faq', 'blogs', 'products'));
    }

    /**
     * Open ticket
     */
    public function openTicket()
    {
        if (Auth::check()) {
            return redirect()->route('ticket.create');
        } else {
            Session::put('redirect_link', route('ticket.create'));
            return redirect()->route('customer.login');
        }
    }

    /**
     * All blog
     */
    public function blogs()
    {
        $category_slug = request()->get('category');
        $tag_slug = request()->get('tag');
        $blog_data = Blog::live()->statusActive();
        $search = request()->get('search');
        if (isset($category_slug)) {
            $category_id = BlogCategory::where('slug', $category_slug)->live()->first()->id;
            $blog_data->where('category_id', $category_id);
        }
        if (isset($tag_slug)) {
            $blog_data->where('tag_titles', "LIKE", "%$tag_slug%");
        }

        if (isset($search)) {
            $blog_data->where('title', 'LIKE', "%$search%");
        }

        $blogs = $blog_data->paginate(6);
        return view('frontend.blogs', compact('blogs'));
    }

    /**
     * Blog Details
     */

    public function blogDetails($slug)
    {
        $id = Blog::where("slug", $slug)->firstOrFail()->id;
        $blog = Blog::find($id);
        $category = BlogCategory::query();
        $query = request()->get('query');
        if (isset($category_query)) {
            $category->where('title', "LIKE", "%$category_query%");
        }

        $categories = $category->latest('id')->live()->get();
        $search_route = route('blog-details', $slug);
        $blogs = Blog::statusActive()->latest()->live()->inRandomOrder()->take(5)->get();
        $blog_comments = BlogComment::where('blog_id', $id)->orderBy('id', 'desc')->get();
        $tag_ids = Blog::whereNotNull('tag_ids')->pluck('tag_ids')->toArray();
        $tags = Tag::whereIn('id', array_unique($tag_ids))->latest()->live()->inRandomOrder()->get();
        $post_tags = Tag::whereIn('id', explode(",", $blog->tag_ids))->get();
        $recentPosts = Blog::statusActive()->live()->latest()->take(3)->get();
        return view('frontend.blog_details', compact('blog', 'categories', 'search_route', 'blogs', 'tags', 'id', 'post_tags', 'blog_comments', 'recentPosts'));
    }

    /**
     * Blog Details
     */
    public function pageDetails($slug)
    {
        $id = Pages::where("slug", $slug)->firstOrFail()->id;
        $page = Pages::findOrFail($id);
        return view('frontend.page_details', compact('page'));
    }

    /**
     * Get product wise article groups
     */
    public function productWiseArticleGroups($product_slug)
    {
        $id = ProductCategory::where('slug', $product_slug)->first()->id;
        $product = ProductCategory::findOrFail($id);
        if (appTheme() == 'single') {
            $product = ProductCategory::where('type', 'single')->first();
        }
        $groups = \App\Model\ArticleGroup::with([
            'articles' => function ($query) {
                $query->external()->live()->statusActive();
            },
        ])->where('product_category', $product->id)->live()->sort()->get();

        $relatedArticles = Article::where('product_category_id', $product->id)->inRandomOrder()->take(6)->get();

        return view('frontend.product_wise_article_groups', compact('groups', 'product', 'relatedArticles'));
    }

    /**
     * Articles
     */
    public function viewAll($group_slug)
    {
        $article_group = ArticleGroup::where('slug', $group_slug)->first();
        $title = request()->get('group_title');
        $group = ArticleGroup::where('product_category', $article_group->product_category);
        $group->with(['articles' => function ($query) {
            $query->external();
            $query->live();
        }]);
        $group->live();
        if (isset($title)) {
            $group->where('title', "LIKE", "%$title%");
        }
        $groups = $group->sort()->get();
        $search_route = route('viewAll', $group_slug);
        $articles = Article::where('article_group_id', $article_group->id)->live()->external()->statusActive()->paginate(15);
        $slug = $group_slug;
        $active_id = $article_group->id;
        $product_category_name = productCatName($article_group->product_category);
        $productCategory = ProductCategory::find($article_group->product_category);
        $product_slug = $productCategory->slug;
        $relatedArticles = Article::where('product_category_id', $article_group->product_category)->inRandomOrder()->take(6)->get();
        return view('frontend.articles', compact('articles', 'groups', 'slug', 'search_route', 'title', 'article_group', 'active_id', 'product_category_name', 'relatedArticles', 'product_slug'));
    }
    /**
     * Article Details
     */
    public function articleDetails($product_slug = null, $slug)
    {
        $id = Article::where('title_slug', $slug)->firstOrFail()->id;
        $article = Article::where('title_slug', $slug)->firstOrFail();

        $articleKey = 'article_' . $article->id;
        if (!Session::has($articleKey)) {
            $article->increment('view_count');
            Session::put($articleKey, 1);
        }

        $title = request()->get('group_title');
        $group = ArticleGroup::where('product_category', $article->product_category_id);
        $group->with(['articles' => function ($query) {
            $query->external();
            $query->live();
        }]);
        $group->live();
        if (isset($title)) {
            $group->where('title', "LIKE", "%$title%");
        }
        $groups = $group->sort()->get();
        $search_route = route('article-details', [$product_slug, $slug]);
        $active_id = $article->article_group_id;
        $product_category_name = productCatName($article->product_category_id);
        $product_slug = $product_slug ?? $article->product_category->slug;
        $comments = ArticleComment::with(['article', 'user', 'children', 'parent'])->where('article_id', $id)->whereNull('parent_id')->get();
        $relatedArticles = Article::where('product_category_id', $article->product_category_id)->inRandomOrder()->take(6)->get();
        return view('frontend.articles', compact('article', 'groups', 'search_route', 'slug', 'active_id', 'product_category_name', 'comments', 'relatedArticles', 'product_slug'));
    }

    /**
     * Store blog comment
     */
    public function storeBlogComment(Request $request)
    {

        $this->validate($request, [
            'blog_id' => 'required',
            'name' => 'required|max:100',
            'comment' => 'required|max:1000',
            'code' => 'required',
        ]);
        $comment = new BlogComment();
        $comment->blog_id = $request->blog_id;
        $comment->user_id = Auth::check() ? Auth::id() : null;
        $comment->name = $request->name;
        $comment->email = Auth::user()->email ?? $request->email ?? null;
        $comment->comment = $request->comment;
        $comment->save();
        return redirect()->route('blog-details', Blog::find($request->blog_id)->slug)->with(saveMessage());
    }

    /**
     * Store Article Comment
     */

    public function storeArticleComment(Request $request)
    {
        $this->validate($request, [
            'article_id' => 'required',
            'comment' => 'required|max:1000',
            'code' => 'required',
        ]);
        $user = auth()->user();
        ArticleComment::create([
            'article_id' => $request->article_id,
            'user_id' => $user->id,
            'parent_id' => $request->parent_id ?? null,
            'name' => $user->full_name,
            'email' => $user->email,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with(saveMessage());
    }

    /**
     * Registration form
     */
    public function registrationForm()
    {
        if(Auth::check()){
            return redirect()->route('user-home')->with('message', __('index.login_logout_instruction'));
        }

        $previous_url = url()->previous() ?? route('home');
        if (Str::contains($previous_url, 'customer/login')) {
            $button_text = __('index.back_to_login');
        } else {
            $button_text = __('index.back_to_home');
        }
        return view('frontend.register', compact('previous_url', 'button_text'));
    }

    /**
     * User registration
     */
    public function userRegister(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:191',
            'last_name' => 'required',
            'email' => 'required|email|max:50|unique:tbl_users',
            'password' => 'required|min:6|max:10',
            'confirm_password' => 'required|same:password',
            'terms_and_policy' => 'required',
        ],
            [
                'first_name.required' => __('index.first_name_required'),
                'first_name.max' => __('index.first_name_max_191'),
                'last_name.required' => __('index.last_name_required'),
                'last_name.max' => __('index.last_name_max_191'),
                'email.required' => __('index.email_required'),
                'email.email' => __('index.email.email'),
                'email.max' => __('index.email_max_50'),
                'email.unique' => __('index.email.unique'),
                'password' => __('index.password_required'),
                'password.min' => __('index.pass_min_6'),
                'password.max' => __('index.password_max_10'),
                'confirm_password.required' => __('index.confirm_password_required'),
                'confirm_password.same' => __('index.confirm_password_same_password'),
                'terms_and_policy.required' => __('index.terms_and_policy_required'),
            ]);

        $user = new User();
        $user->role_id = 3;
        $user->type = "Customer";
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $token = Str::random(64);
        $user->save();

        UserVerify::updateOrInsert(['user_id' => $user->id], ['user_id' => $user->id, 'token' => $token]);

        $mail_data = [
            'to' => [$user->email],
            'title' => "You're almost there!",
            'subject' => 'Email verification link',
            'user_name' => $user->full_name,
            'token' => $token,
            'view' => 'email-verification-template',
        ];

        MailSendController::sendMailToUser($mail_data);
        return redirect()->route('customer.login')->with([
            'resend-message' => __('index.verification_link_sent'),
            'email' => $request->email,
        ]);
    }

    /**
     * Verify email acount
     */
    public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();
        if (!is_null($verifyUser)) {
            $user = $verifyUser->user;
            if (!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->save();
                $message = [
                    'message' => "Your account has been verified successfully.",
                    'type' => 'success',
                ];
            } else {
                $message = [
                    'message' => "Your e-mail is already verified.",
                    'type' => 'info',
                ];
            }
        } else {
            $message = [
                'message' => 'Sorry your email cannot be identified.',
                'type' => 'danger',
            ];
        }

        return redirect()->route('customer.login')->with($message);
    }

    /**
     * Resend Verification link
     */
    public function resendLink($email)
    {
        if (User::where('email', $email)->exists()) {
            User::sendVerificationEmail($email);
            return redirect()->route('customer.login')->with([
                'message' => 'We have sent a verification link to your email. Please check and verify your account.',
                'type' => 'info',
            ]);
        } else {
            return redirect()->route('customer.login')->with([
                'message' => 'Sorry your email cannot be identified.',
                'type' => 'danger',
            ]);
        }

    }

    /**
     * Contact Page
     */
    public function contact()
    {
        return view('frontend.contact');
    }
    /**
     * supportPolicy  Page
     */
    public function supportPolicy()
    {
        return view('frontend.support_policy');
    }
    /**
     * aboutUs   Page
     */
    public function aboutUs()
    {
        $testimonials = \App\Model\Testimonial::live()->get();
        $faq = Faq::statusActive()->general()->live()->latest('id')->get();
        $products = ProductCategory::with([
            'article_groups' => function ($query) {
                $query->live();
                $query->with([
                    'articles' => function ($article) {
                        $article->live()->statusActive()->external();
                    },
                ]);
            },
        ])->statusActive()->live()->type()->get();
        return view('frontend.about_us', compact('testimonials', 'faq', 'products'));
    }
    /**
     * ourServices    Page
     */
    public function ourServices()
    {
        return view('frontend.our_services');
    }

    /**
     * Store frontend message
     */
    public function storeMessage(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|max:50',
            'subject' => 'required|max:100',
            'message' => 'required|max:1000',
        ], [
            'name.required' => __('index.full_name_required'),
            'email.required' => __('index.email_required'),
            'subject.required' => __('index.subject_required'),
            'message.required' => __('index.message_required'),
        ]);

        $mail_data = [
            'to' => array(siteSetting()->email),
            'subject' => $request->subject . " (" . smtpInfo()['from_name'] . ")",
            'reply_to' => $request->email,
            'from_name' => $request->name,
            'body' => $request->message,
            'view' => 'contact_us_email_body',
        ];
        MailSendController::sendMailToUser($mail_data);
        return redirect()->back()->with('message', "Your information has been sent successfully!");
    }

    /**
     * Redirect customer login page if unauthenticated
     * @return RedirectResponse
     */
    public function askQuestion()
    {
        if (!Auth::check()) {
            Session::put('comment', "");
            Session::put('redirect_link', route('forum'));
            return redirect()->route('customer.login');
        } else {
            $products = ProductCategory::live()->type()->get();
            $departments = \App\Model\Department::live()->get();
            if (appTheme() == 'single') {
                $product = ProductCategory::live()->where('type', 'single')->first();
            } else {
                $product = null;
            }
            return view('frontend.ask_question', compact('products', 'departments', 'product'));
        }
    }

    /**
     * Redirect login from forum
     */
    public function loginFromForum()
    {
        Session::put('redirect_link', route('forum'));
        return redirect()->route('customer.login');
    }

    /**
     * Forum page
     */
    public function forum()
    {
        $title = request()->get('title');
        $product_id = request()->get('product-category');
        $user_id = request()->get('user');
        $tags = request()->get('tags');
        $department = request()->get('department');
        $data = Forum::query();
        if (appTheme() == 'single') {
            $data->where('product_id', ProductCategory::where('type', 'single')->first()->id);
            $questions = Forum::live()->where('product_id', ProductCategory::where('type', 'single')->first()->id)->orderBy('view_count', 'desc')->take(10)->get();
        } else {
            $productId = ProductCategory::where('type', 'multiple')->pluck('id')->toArray();
            $data->whereIn('product_id', $productId);
            $questions = Forum::live()->whereIn('product_id', $productId)->orderBy('view_count', 'desc')->take(10)->get();
        }
        if (isset($product_id)) {
            if ($product_id !== "all") {
                $data->where('product_id', encrypt_decrypt($product_id, 'decrypt'));
            }
        }
        if (isset($department)) {
            if ($department !== "all") {
                $data->where('department_id', encrypt_decrypt($department, 'decrypt'));
            }
        }
        if (isset($tags)) {
            $tag_id = encrypt_decrypt($tags, 'decrypt');
            $tag = Tag::find($tag_id);
            $data->where('subject', 'like', "%$tag->title%")
                ->orWhere('description', 'like', "%$tag->title%");
        }
        if (isset($user_id)) {
            $data->where('user_id', encrypt_decrypt($user_id, 'decrypt'));
        }

        if(isset($title)){
            $data->where('subject', 'like', '%' . $title . '%');
        }
        $forums = $data->latest('id')->paginate(6);
        $products = ProductCategory::live()->type()->get();
        $departments = \App\Model\Department::live()->get();
        $top_cateogries = ProductCategory::live()->inRandomOrder()->type()->take(10)->get();
        $users = User::all();
        $latestForums = $data->latest('id')->paginate(6);
        $tags = Tag::live()->inRandomOrder()->take(10)->get();
        return view('frontend.forums', compact('forums', 'products', 'product_id', 'users', 'user_id', 'questions', 'top_cateogries', 'latestForums', 'tags', 'departments'));
    }

    /**
     * Post a forum question
     */
    public function postForum(Request $request)
    {
        if (Auth::check()) {
            $this->validate($request, [
                'subject' => 'required|max:191',
                'product_id' => 'required',
                'description' => 'required|max:5000',
            ]);

            
            $forum = new Forum();
            $forum->user_id = Auth::id() ?? null;
            $forum->product_id = $request->product_id;
            if ($request->department_id) {
                $forum->department_id = $request->department_id;
            }
            $forum->subject = $request->subject;
            $forum->slug = Str::slug($request->subject) . '-' . time();
            $forum->description = $request->description;
            $forum->save();
            return redirect()->route('forum')->with(saveMessage());
        } else {
            return redirect()->route('customer.login');
        }
    }

    /**
     * Forum comments
     */
    public function forumComment($slug)
    {
        $forum = Forum::where('slug', $slug)->first();
        $forumKey = 'forum_' . $forum->id;
        if (!Session::has($forumKey)) {
            $forum->increment('view_count');
            Session::put($forumKey, 1);
        }
        $questions = Forum::live()->orderBy('view_count', 'desc')->take(10)->get();
        $top_cateogries = ProductCategory::live()->type()->inRandomOrder()->take(10)->get();
        $products = ProductCategory::all();
        return view('frontend.forum_comments', compact('forum', 'questions', 'top_cateogries', 'products'));
    }

    /**
     * Post comment on forum
     */
    public function postComment(Request $request)
    {
        if (!Auth::check()) {
            Session::put('comment', $request->comment ?? "");
            Session::put('redirect_link', route('forum-comment', Forum::find($request->forum_id)->slug));
            return redirect()->route('customer.login');
        }
        $this->validate($request, [
            'forum_id' => 'required',
            'comment' => 'required|max:1000',
            'attachment' => 'max:5120|mimes:png,jpg,pdf,docx,doc,zip',
        ]);

        $commentedData = $request->comment;
        $replying_to = $request->replying_to;
        if($replying_to){
            $replaceableText = "<em>".$replying_to."</em>";
            $commentedData = str_replace($replying_to, $replaceableText, $commentedData);
        }
        if (!empty($request->file('attachment'))) {
            $attachment = uploadFile($request->file('attachment'), 'forum/');
        } else {
            $attachment = null;
        }
        $comment = new ForumComment();
        $comment->forum_id = $request->forum_id;
        $comment->user_id = Auth::id();
        $comment->comment = $commentedData;
        $comment->attachment = $attachment;
        $comment->save();
        Session::forget('redirect_link');
        return redirect()->back()->with(saveMessage());
    }
    /**
     * send default message to recever from ai response
     */
    public function sendPreSaleAiResponse($group_id, $message, $product_id, $skip = '')
    {
        $from_id = 3;
        $from_type = "Agent";
        $row = new GroupChatMessage();
        $row->from_id = $from_id;
        $row->user_type = $from_type;
        $row->group_id = $group_id;
        $ai_message = '';
        if ($skip == '') {
            $ai_message = getAIPreSaleChatResponse($message, $product_id);
        } else {
            $status = true;
            $ai_message = $message;
        }

        $domain_lis = getDomainExtensions();
        if (Str::endsWith($ai_message, $domain_lis) && !Str::startsWith($ai_message, 'http')) {
            $row->message = "https://" . $ai_message;
        } else {
            $row->message = $ai_message;
        }
        $row->save();
        ChatGroup::findOrFail($group_id)->update(['last_message_at' => now()]);
        $this->callEventInGroupMessage($from_id, $row);
        $this->callGuestEventIn($from_id, $row);
    }
    /**
     * send default message to recever from ai response
     */
    public function sendAfterSaleAiResponse($group_id, $message, $product_id, $skip = '')
    {
        $from_id = 3;
        $from_type = "Agent";
        $row = new GroupChatMessage();
        $row->from_id = $from_id;
        $row->user_type = $from_type;
        $row->group_id = $group_id;
        $ai_message = '';
        if ($skip == '') {
            $ai_message = sendAfterSaleAiResponse($message, $product_id);
        } else {
            $status = true;
            $ai_message = $message;
        }

        $domain_lis = getDomainExtensions();
        if (Str::endsWith($ai_message, $domain_lis) && !Str::startsWith($ai_message, 'http')) {
            $row->message = "https://" . $ai_message;
        } else {
            $row->message = $ai_message;
        }
        $row->save();
        ChatGroup::findOrFail($group_id)->update(['last_message_at' => now()]);
        $this->callEventInGroupMessage($from_id, $row);
        $this->callGuestEventIn($from_id, $row);
    }
    /**
     * send default message to recever from ai response
     */
    public function sendPreSaleAiResponseDefault($group_id)
    {
        $from_id = 3;
        $from_type = "Agent";
        $row = new GroupChatMessage();
        $row->from_id = $from_id;
        $row->user_type = $from_type;
        $row->group_id = $group_id;

        $ai_message = 'Hello! How can I assist you today?';

        $domain_lis = getDomainExtensions();
        if (Str::endsWith($ai_message, $domain_lis) && !Str::startsWith($ai_message, 'http')) {
            $row->message = "https://" . $ai_message;
        } else {
            $row->message = $ai_message;
        }
        $row->save();
        ChatGroup::findOrFail($group_id)->update(['last_message_at' => now()]);
        $this->callEventInGroupMessage($from_id, $row);
        $this->callGuestEventIn($from_id, $row);
    }

    /**
     * Send message to admin/agent
     */
    public function sendMessage(Request $request)
    {
        $client_ip = userIp();
        $product_id = $request->product_id;
        $message_from = $request->message_from;
        $created_by = $client_ip;
        $user_type = 'guest';

        $need_validation = false;
        $need_close_chat = false;
        $is_verified = session('is_verified');
        $need_show_agent_button = true;
        $group_code = ChatGroup::getGroupCode();
        if (ChatGroup::where('code', $group_code)->exists()) {
            $group_code = ChatGroup::getGroupCode();
        }

        $group_condition = [
            'created_by' => $created_by,
            'product_id' => $product_id,
        ];
        $client_name = $request->guest_user_name ?? $client_ip;
        $group_name = ProductCategory::find($request->product_id)->title . '-' . $client_name;

        if (ChatGroup::where($group_condition)->exists()) {
            $group_id = ChatGroup::where($group_condition)->first()->id;
        } else {
            $group = new ChatGroup();
            $group->created_by = $created_by;
            $group->product_id = $product_id;
            $group->user_type = $user_type;
            $group->guest_user_name = $request->guest_user_name ?? null;
            $group->guest_user_email = $request->guest_user_email ?? null;
            $group->code = $group_code;
            $group->name = $group_name;
            $group->status = "Active";
            $group->save();
            $group_id = $group->id;

            $notification_message = "A new chat has been opened by guest for " . ProductCategory::find($request->product_id)->title . " on " . currentDate() . " at " . currentTime();

            $group_members = [];
            if (ProductCategory::where('id', $request->product_id)->whereNotNull('first_chat_agent_id')->exists()) {
                $agent_id = ProductCategory::find($request->product_id)->first_chat_agent_id;
            } else {
                $agent_id = adminId();
                $admin_notification = new \App\Model\AdminNotification();
                $admin_notification->type = "chat opened";
                $admin_notification->from = authUserType();
                $admin_notification->message = $notification_message;
                $admin_notification->redirect_link = '/live-chat';
                $admin_notification->mark_as_read_status = null;
                $admin_notification->created_by = Auth::id();
                $admin_notification->save();
                event(new \App\Events\AdminNotification($notification_message));
            }
            array_push($group_members, $agent_id);
            foreach ($group_members as $user) {
                $group_member = new ChatGroupMember();
                $group_member->group_id = $group_id;
                $group_member->user_id = $user;
                $group_member->save();
                $agent_notification = new \App\Model\AgentNotification();
                $agent_notification->type = "chat opened";
                $agent_notification->from = "guest";
                $agent_notification->message = $notification_message;
                $agent_notification->agent_for = $user;
                $agent_notification->redirect_link = '/live-chat';
                $agent_notification->mark_as_read_status = null;
                $agent_notification->created_by = Auth::id();
                $agent_notification->save();
            }
            event(new \App\Events\AgentNotification($group_members, $notification_message));
        }

        if (isset($request->message)) {
            $from_id = Auth::id() ?? 0;
            $from_type = Auth::user()->type ?? $message_from;
            $row = new GroupChatMessage();
            $row->from_id = $from_id;
            $row->user_type = $from_type;
            $row->group_id = $group_id;

            if (isset($request->message)) {
                $domain_lis = getDomainExtensions();
                if (Str::endsWith($request->message, $domain_lis) && !Str::startsWith($request->message, 'http')) {
                    $row->message = "https://" . $request->message;
                } else {
                    $row->message = $request->message;
                }

                $row->save();
                ChatGroup::findOrFail($group_id)->update(['last_message_at' => now()]);

                $this->callEventInGroupMessage($from_id, $row);
            }

            if (aiInfo()['type'] == "Yes") {
                if ($request->message == "After Sale Support" || $request->message == "Pre Sale Query") {
                    $need_show_agent_button = false;
                    $message = session('new_message');
                    $request->session()->put('chat_type', $request->message);
                    if ($request->message == "After Sale Support") {
                        $product_details = \App\Model\ProductCategory::find($product_id)->verification;
                        if ($product_details == 1 && $is_verified != "Yes") {
                            $need_validation = true;
                        } else {
                            $request->session()->put('is_verified', "Yes");
                            $need_show_agent_button = true;
                            $chat_type = 'skip';
                            $this->sendAfterSaleAiResponse($group_id, $message, $product_id, '');
                        }
                        return response()->json(['status' => true, 'is_verified' => ($is_verified), 'need_validation' => ($need_validation), 'chat_type' => ($request->message), 'need_show_agent_button' => $need_show_agent_button, 'need_close_chat' => $need_close_chat, 'message' => $message, 'product' => ProductCategory::find($request->product_id)->title, 'product_id' => $request->product_id, 'group_id' => $group_id]);
                    } else {
                        $need_show_agent_button = true;
                        $chat_type = 'skip';
                        $this->sendPreSaleAiResponse($group_id, $message, $product_id, '');
                    }
                } else {
                    $request->session()->put('new_message', $request->message);
                    if (customResponse($request->message)) {
                        $need_show_agent_button = false;
                        $chat_type = 'skip';
                        //custom text provide in chat.
                        $this->sendPreSaleAiResponse($group_id, customResponse($request->message), $product_id, '1');
                    } else {
                        $chat_type = session('chat_type');
                        $is_agent_connected = session('is_agent_connected');
                        if (!$is_agent_connected) {
                            if ($chat_type == "Pre Sale Query") {
                                if ($request->message == "Yes, I got that answer.") {
                                    $need_close_chat = true;
                                } else if ($request->message == "No, I need agent support.") {
                                    if(chatScheduleAutoResponse() && !isChatScheduleTimeAndDate()){
                                        $need_show_agent_button = false;
                                        $request->session()->put('is_agent_connected', "No");
                                        $responseText = autoResponseText();
                                        $this->sendPreSaleAiResponse($group_id, $responseText, $product_id, '1');
                                    }else{
                                        $need_show_agent_button = false;
                                        $request->session()->put('is_agent_connected', "Yes");
                                        $this->sendPreSaleAiResponse($group_id, "Please wait we are assigning an agent for you.", $product_id, '1');
                                    }
                                    
                                } else {
                                    $this->sendPreSaleAiResponse($group_id, $request->message, $product_id, '');
                                }
                            } else if ($chat_type == "After Sale Support") {
                                if ($is_verified == "Yes") {
                                    if ($request->message == "Yes, I got that answer.") {
                                        $need_close_chat = true;
                                    } else if ($request->message == "No, I need agent support.") {
                                        if(chatScheduleAutoResponse() && !isChatScheduleTimeAndDate()){
                                            $need_show_agent_button = false;
                                            $request->session()->put('is_agent_connected', "No");
                                            $responseText = autoResponseText();
                                            $this->sendPreSaleAiResponse($group_id, $responseText, $product_id, '1');
                                        }else{
                                            $need_show_agent_button = false;
                                            $request->session()->put('is_agent_connected', "Yes");
                                            $this->sendPreSaleAiResponse($group_id, "Please wait we are assigning an agent for you.", $product_id, '1');
                                        }
                                    } else {
                                        $this->sendAfterSaleAiResponse($group_id, $request->message, $product_id, '');
                                    }
                                } else {
                                    $need_validation = true;
                                }

                            }
                        } else {
                            if ($request->message == "Yes, I got that answer.") {
                                $need_close_chat = true;
                            } else {
                                if (!GroupChatMessage::where('group_id', $group_id)->where('user_type', "Agent")->exists()) {
                                    $template_info = MailTemplate::where('event_key', 'chat_message_by_customer')->first();
                                    $members = ChatGroupMember::where('group_id', $group_id)->pluck('user_id');
                                    $emails = User::whereIn('id', $members)->agent()->pluck('email')->toArray();
                                    if (isset($template_info) && $template_info->mail_notification == "on") {
                                        $mail_data = [
                                            'to' => $emails,
                                            'subject' => MailTemplate::singleStringConvert('chat_message_by_customer', 'subject', 'admin_agent', $from_type),
                                            'body' => MailTemplate::singleStringConvert('chat_message_by_customer', 'body', 'admin_agent', $from_type),
                                            'chat_message' => $row->message,
                                            'view' => 'cc-mail-template',
                                        ];
                                        MailSendController::sendMailToUser($mail_data);
                                    }
                                }
                            }
                            $need_show_agent_button = false;
                        }
                    }

                }
            } else {
                $this->sendPreSaleAiResponseDefault($group_id);
                return response()->json(['status' => true, 'is_verified' => ($is_verified), 'need_validation' => ($need_validation), 'chat_type' => ($request->message), 'need_show_agent_button' => $need_show_agent_button, 'need_close_chat' => $need_close_chat, 'message' => $request->message, 'product' => ProductCategory::find($request->product_id)->title, 'product_id' => $request->product_id, 'group_id' => $group_id]);
            }

            return response()->json(['status' => true, 'is_verified' => ($is_verified), 'need_validation' => ($need_validation), 'chat_type' => ($chat_type), 'need_show_agent_button' => $need_show_agent_button, 'need_close_chat' => $need_close_chat, 'message' => $request->message, 'product' => ProductCategory::find($request->product_id)->title, 'product_id' => $request->product_id, 'group_id' => $group_id]);
        } else {
            return response()->json(array('status' => false, 'message' => 'Message not sent!'));
        }
    }

    /**
     * Send message to admin/agent
     */
    public function successValidation(Request $request)
    {
        $group_id = request()->post('verify_group_id');
        $product_id = request()->post('product_id');
        $message = session('new_message');
        $this->sendAfterSaleAiResponse($group_id, $message, $product_id, '');
        $request->session()->put('is_verified', "Yes");
        return response()->json(['status' => true]);
    }

    /**
     * Call event for guest
     */
    public function callGuestEventIn($from_id, $row)
    {
        $message_type = "incoming_message";
        $sender = [
            'id' => $row->sender['id'],
            'name' => $row->sender['full_name'],
            'image' => $row->sender['image'],
        ];

        $group = [
            'id' => $row->group->id,
            'name' => $row->group->name,
            'created_by' => $row->group->created_by,
        ];

        $message = [
            'text' => $row->message,
            'file' => $row->file,
            'message_time' => $row->message_time,
            'is_link' => $row->is_link,
            'is_file' => $row->is_file,
            'is_image' => $row->is_file,
            'seen_status' => $row->seen_status,
        ];
        if (pusherConnection()) {
            event(new GuestMessage($message_type, $sender, $group, $message));
        }
    }
    /**
     * Call event in group chat
     * @param $from_id
     * @param $row
     * @return void
     */

    public function callEventInGroupMessage($from_id, $row)
    {
        $message_type = 'incoming_message';
        $client_ip = userIp();

        $sender = [
            'id' => $client_ip,
            'name' => $row->sender['full_name'],
            'image' => $row->sender['image'],
        ];

        $group = [
            'id' => $row->group->id,
            'name' => $row->group->name,
            'receiver_id' => ChatGroupMember::where('group_id', $row->group_id)->where('user_id', '!=', Auth::id())->first()->user_id,
        ];

        $message = [
            'text' => $row->message,
            'file' => $row->file,
            'message_time' => $row->message_time,
            'is_link' => $row->is_link,
            'is_file' => $row->is_file,
            'is_image' => $row->is_file,
            'seen_status' => $row->seen_status,
        ];
        if (pusherConnection()) {
            event(new GroupChat($message_type, $sender, $group, $message));
        }

    }

    /**
     * Update message seen status
     */

    public function updateSeenStatus()
    {
        $condition = [
            'group_id' => request()->get('group_id'),
            'seen_status' => 0,
        ];
        $count = GroupChatMessage::where($condition)->count();
        $target_user = GroupChatMessage::where('group_id', request()->get('group_id'))->where('from_id', '!=', 0)->orderBy('created_at', 'DESC')->first();
        if (isset($target_user)) {
            $from_id = $target_user->from_id;
            event(new MakeSeen("group", $from_id));
            GroupChatMessage::where($condition)->where('from_id', '!=', 0)->update(array('seen_status' => 1));
            return response()->json(['total' => $count, 'status' => true]);
        }

    }

    /**
     * Close chat
     */
    public function closeChat($group_id)
    {
        $group = ChatGroup::findOrFail($group_id);
        $chat_history = GroupChatMessage::where('group_id', $group->id)->where('user_type', '!=', 'forward')->orderBy('created_at', 'asc')->get();
        $file_name = $group->created_by + '' + time();

        if (count($chat_history)) {
            $data_array[] = array('User Type', 'Message', 'Time');

            foreach ($chat_history as $chat) {
                $data_array[] = array(
                    'User Type' => $chat->user_type,
                    'Message' => $chat->message,
                    'Time' => $chat->created_at->format('Y-m-d h:i A'),
                );
            }
            $this->saveExcel($data_array, $file_name);

            $template_info = MailTemplate::where('event_key', 'chat_close')->first();
            if (isset($template_info) && $template_info->mail_notification == "on") {
                $group_members = ChatGroupMember::where('group_id', $group->id)->pluck('user_id');
                // Send mail to customer
                if ($group->user_type != 'guest') {
                    $customer_email = User::whereIn('id', $group_members)->where('type', 'Customer')->first();
                    if (isset($customer)) {
                        $mail_data = [
                            'to' => array($customer->email),
                            'subject' => MailTemplate::chatMailData('customer', $customer_email, 'subject', $group_id),
                            'body' => MailTemplate::chatMailData('customer', $customer_email, 'body', $group_id),
                            'file_name' => $file_name . '.xls',
                            'file_path' => 'assets/chat_files/' . $file_name . '.xls',
                            'view' => 'cc-mail-template',
                        ];
                        MailSendController::sendMailToUser($mail_data);
                    }
                }

                // Send mail to admin/agent
                $admin_agent_emails = User::whereIn('id', $group_members)->where('type', '!=', 'Customer')->pluck('email');
                foreach ($admin_agent_emails as $email) {
                    $mail_data = [
                        'to' => array($email),
                        'subject' => MailTemplate::chatMailData('admin_agent', $email, 'subject', $group_id),
                        'body' => MailTemplate::chatMailData('admin_agent', $email, 'body', $group_id),
                        'file_name' => $file_name . '.xls',
                        'file_path' => 'assets/chat_files/' . $file_name . '.xls',
                        'view' => 'cc-mail-template',
                    ];
                    MailSendController::sendMailToUser($mail_data);
                }
            }
            // Send mail to guest email
            if ($group->user_type == 'guest' && $group->guest_user_email != null) {
                $mail_data = [
                    'to' => array($group->guest_user_email),
                    'subject' => "Your chat transcript from " . siteSetting()->company_name ?? '',
                    'body' => "A chat has been closed on " . siteSetting()->company_name . " by " . authUserType() . " on " . currentDate() . " at " . currentTime() . " You can open another chat if you have further query.",
                    'file_name' => $file_name . '.xls',
                    'file_path' => 'assets/chat_files/' . $file_name . '.xls',
                    'view' => 'cc-mail-template',
                ];
                MailSendController::sendMailToUser($mail_data);
            }

        }
        Session::forget('chat_type');
        Session::forget('is_agent_connected');
        Session::forget('is_verified');
        GroupChatMessage::whereIn('group_id', array($group_id))->delete();
        $group->delete();
        return redirect()->route('home');
    }

    /**
     * Save xl file
     */
    public function saveExcel($customer_data, $file_name)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');
        try {
            $spreadSheet = new Spreadsheet();
            $spreadSheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
            $spreadSheet->getActiveSheet()->fromArray($customer_data);
            $Excel_writer = new Xls($spreadSheet);
            $Excel_writer->save('assets/chat_files/' . $file_name . '.xls');
        } catch (Exception $e) {
            return;
        }
    }

    /**
     * export xl file
     */
    public function exportExcel($customer_data, $file_name)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');
        try {
            $spreadSheet = new Spreadsheet();
            $spreadSheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
            $spreadSheet->getActiveSheet()->fromArray($customer_data);
            $Excel_writer = new Xls($spreadSheet);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename=' . '"' . $file_name . '.xls.' . '"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $Excel_writer->save('php://output');
            exit();
        } catch (Exception $e) {
            return;
        }
    }

    /**
     * Download Pdf
     */

    public function pdfDownload(Request $request)
    {
        $article_id = $request->post('article_id');
        $blogId = $request->post('blog_id');
        if($article_id){
            $article = Article::where('id', $article_id)->first();
            $articleCategory = $article->getProductCategory->title;
            $articleGroup = $article->getArticleGroup->title;
            $title = $articleCategory . '-'. $articleGroup . '-'. $article->title;
            
            if(!is_dir(base_path().'/uploads/article_pdf/')){
                mkdir(base_path().'/uploads/article_pdf/', 0777, true);
            }
            if(file_exists(base_path().'/uploads/article_pdf/'.$title.'.pdf')){
                return response()->json([
                    'pdf_link' => baseUrl().'/uploads/article_pdf/'.$title.'.pdf',
                ]);
            }

            $pageContent = $article->page_content;
            $outputPath = base_path().'/uploads/article_pdf/'.$title.'.pdf';
            $pdf_link = baseUrl().'/uploads/article_pdf/'.$title.'.pdf';
        }

        if($blogId){
            $blog = Blog::find($blogId);
            $title = $blog->title;

            if(!is_dir(base_path().'/uploads/blog_pdf/')){
                mkdir(base_path().'/uploads/blog_pdf/', 0777, true);
            }
            if(file_exists(base_path().'/uploads/blog_pdf/'.$title.'.pdf')){
                return response()->json([
                    'pdf_link' => baseUrl().'/uploads/blog_pdf/'.$title.'.pdf',
                ]);
            }
            $pageContent = $blog->blog_content;
            $outputPath = base_path().'/uploads/blog_pdf/'.$title.'.pdf';
            $pdf_link = baseUrl().'/uploads/blog_pdf/'.$title.'.pdf';
        }
        
        $mpdf = new Mpdf();
        $mpdf->SetHeader([$title]);
        $mpdf->WriteHTML($pageContent);
        $mpdf->Output($outputPath, 'F');

        return response()->json([
            'pdf_link' => $pdf_link,
        ]);
    }

}
