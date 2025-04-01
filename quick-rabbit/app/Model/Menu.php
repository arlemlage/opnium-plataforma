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
  # This is Menu Model
  ##############################################################################
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class Menu extends Model
{
    use HasFactory;
    protected $table = "tbl_menus";
    protected $guarded = [];

    /**
     * Static function to set menus
     */
    public static function setMenus() {
        $menus = array(
            [
                'title' => "User Home",
                'activities' => [
                    array('activity_name' => 'User Home','route_name' => 'user-home','is_dependant' => 'Yes','auto_select' => 'Yes')
                ]
            ],
            [
                'title' => "Dashboard",
                'activities' => [
                    array('activity_name' => 'Dashboard View','route_name' => 'dashboard','is_dependant' => 'No','auto_select' => 'Yes')
                ]
            ],
            [
                'title' => "Profile",
                'activities' => [
                    array('activity_name' => 'Change Password','route_name' => 'change-password','is_dependant' => 'No','auto_select' => 'Yes'),
                    array('activity_name' => 'Edit Profile','route_name' => 'edit-profile','is_dependant' => 'No','auto_select' => 'Yes'),
                    array('activity_name' => 'Set Security Question','route_name' => 'set-security-question','is_dependant' => 'No','auto_select' => 'Yes'),
                    array('activity_name' => 'Save Security Question','route_name' => 'save-security-question','is_dependant' => 'Yes','auto_select' => 'Yes'),
                    array('activity_name' => 'Update Profile','route_name' => 'update-profile','is_dependant' => 'Yes','auto_select' => 'Yes'),
                ]
            ],
            [
                'title' => "Tickets",
                'activities' => [
                    array('activity_name' => 'View Ticket List', 'route_name' => 'ticket.index','is_dependant' => 'No','auto_select' => 'Yes'),
                    array('activity_name' => 'Create Ticket', 'route_name' => 'ticket.create','is_dependant' => 'No','auto_select' => 'Yes'),
                    array('activity_name' => 'Store Ticket', 'route_name' => 'ticket.store','is_dependant' => 'Yes','auto_select' => 'Yes'),
                    array('activity_name' => 'Ticket Details', 'route_name' => 'ticket.Show','is_dependant' => 'No','auto_select' => 'Yes'),
                    array('activity_name' => 'Edit Ticket', 'route_name' => 'ticket.edit','is_dependant' => 'No','auto_select' => 'Yes'),
                    array('activity_name' => 'Update Ticket', 'route_name' => 'ticket.update','is_dependant' => 'No','auto_select' => 'Yes'),
                    array('activity_name' => 'Delete Ticket', 'route_name' => 'ticket.destroy','is_dependant' => 'No','auto_select' => 'Yes'),
                    array('activity_name' => 'Check Ticket Relevant Verification', 'route_name' => 'check-relevant-verification','is_dependant' => 'Yes','auto_select' => 'Yes'),
                    array('activity_name' => 'Get Editor Mentioned Data', 'route_name' => 'get-editor-mentioned-data','is_dependant' => 'No','auto_select' => 'Yes'),
                    array('activity_name' => 'Ticket Customer Note List', 'route_name' => 'get-customer-all-notes','is_dependant' => 'No','auto_select' => 'Yes'),
                    array('activity_name' => 'Get Article Searched Data', 'route_name' => 'get-article-searched-data','is_dependant' => 'Yes','auto_select' => 'Yes'),
                    array('activity_name' => 'Assign Agent To Ticket', 'route_name' => 'set-ticket-assign-priority','is_dependant' => 'No','auto_select' => 'Yes'),
                    array('activity_name' => 'Ticket Close/Reopen', 'route_name' => 'set-ticket-status-close-reopen','is_dependant' => 'No','auto_select' => 'Yes'),
                    array('activity_name' => 'Set Flag On Ticket', 'route_name' => 'flag-ticket','is_dependant' => 'No','auto_select' => 'Yes'),
                    array('activity_name' => 'Open Chat', 'route_name' => 'open-chat','is_dependant' => 'No','auto_select' => 'Yes'),
                    array('activity_name' => 'Ticket Archived', 'route_name' => 'ticket-archived','is_dependant' => 'No','auto_select' => 'Yes'),
                    array('activity_name' => 'Reply In Ticket', 'route_name' => 'posting-replay-in-ticket','is_dependant' => 'No','auto_select' => 'Yes'),
                    array('activity_name' => 'Add Customer Note', 'route_name' => 'add-customer-note','is_dependant' => 'No','auto_select' => 'Yes'),
                    array('activity_name' => 'Add Ticket Note', 'route_name' => 'add-ticket-note','is_dependant' => 'No','auto_select' => 'Yes'),
                    array('activity_name' => 'Set CC Mail On Ticket', 'route_name' => 'add-ticket-cc','is_dependant' => 'No','auto_select' => 'Yes'),
                    array('activity_name' => 'Ticket Comment Update', 'route_name' => 'update-reply-comment','is_dependant' => 'No','auto_select' => 'Yes'),
                    array('activity_name' => 'Convert Ticket Comment To Article', 'route_name' => 'ticket-convert-to-article','is_dependant' => 'No','auto_select' => 'Yes'),
                ]
            ],
            [
                'title' => "Customers",
                'activities' => [
                    array('activity_name' => 'View Customer List', 'route_name' => 'customer.index','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Create Customer', 'route_name' => 'customer.create','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Store Customer', 'route_name' => 'customer.store','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Customer Details', 'route_name' => 'customer.Show','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Edit Customer', 'route_name' => 'customer.edit','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update Customer', 'route_name' => 'customer.update','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Delete Customer', 'route_name' => 'customer.destroy','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Reset Customer Password', 'route_name' => 'reset-customer-password','is_dependant' => 'No','auto_select' => 'No'),
                ]
            ],
            [
                'title' => "Task and Calendar",
                'activities' => [
                    array('activity_name' => 'View Task List', 'route_name' => 'task-lists.index','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Create Task', 'route_name' => 'task-lists.create','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Store Task', 'route_name' => 'task-lists.store','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Task Details', 'route_name' => 'task-lists.Show','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Edit Task', 'route_name' => 'task-lists.edit','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update Task', 'route_name' => 'task-lists.update','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Delete Task', 'route_name' => 'task-lists.destroy','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'View Task Calander', 'route_name' => 'task-calendar','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update Task Status', 'route_name' => 'update-task-status','is_dependant' => 'No','auto_select' => 'No'),
                ]
            ],
            [
                'title' => "Article",
                'activities' => [
                    array('activity_name' => 'View Article List', 'route_name' => 'article.index','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Create Article', 'route_name' => 'article.create','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Store Article', 'route_name' => 'article.store','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Article Details', 'route_name' => 'article.Show','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Edit Article', 'route_name' => 'article.edit','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update Article', 'route_name' => 'article.update','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Delete Article', 'route_name' => 'article.destroy','is_dependant' => 'No','auto_select' => 'No'),
                ]
            ],
            [
                'title' => "Blog",
                'activities' => [
                    array('activity_name' => 'View Blog Category List', 'route_name' => 'blog-categories.index','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Create Blog Category', 'route_name' => 'blog-categories.create','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Store Blog Category', 'route_name' => 'blog-categories.store','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Blog Category Details', 'route_name' => 'blog-categories.Show','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Edit Blog Category', 'route_name' => 'blog-categories.edit','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update Blog Category', 'route_name' => 'blog-categories.update','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Delete Blog Category', 'route_name' => 'blog-categories.destroy','is_dependant' => 'No','auto_select' => 'No'),

                    array('activity_name' => 'View Blog List', 'route_name' => 'blog.index','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Create Blog', 'route_name' => 'blog.create','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Store Blog', 'route_name' => 'blog.store','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Blog Details', 'route_name' => 'blog.Show','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Edit Blog', 'route_name' => 'blog.edit','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update Blog', 'route_name' => 'blog.update','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Delete Blog', 'route_name' => 'blog.destroy','is_dependant' => 'No','auto_select' => 'No'),
                ]
            ],
            [
                'title' => "Notice",
                'activities' => [
                    array('activity_name' => 'View Notice List', 'route_name' => 'notices.index','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Create Notice', 'route_name' => 'notices.create','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Store Notice', 'route_name' => 'notices.store','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Notice Details', 'route_name' => 'notices.Show','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Edit Notice', 'route_name' => 'notices.edit','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update Notice', 'route_name' => 'notices.update','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Delete Notice', 'route_name' => 'notices.destroy','is_dependant' => 'No','auto_select' => 'No'),
                ]
            ],
            [
                'title' => "Report",
                'activities' => [
                    array('activity_name' => 'Agent Performance Report', 'route_name' => 'agent-report','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Support History Report', 'route_name' => 'support-history-report','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Customer Feedback Report', 'route_name' => 'customer-feedback-report','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Transaction Report', 'route_name' => 'transaction-report','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Attendance Report', 'route_name' => 'attendance-report','is_dependant' => 'No','auto_select' => 'No'),
                ]
            ],
            [
                'title' => "Recurring Payment",
                'activities' => [
                    array('activity_name' => 'View Recurring Payment List', 'route_name' => 'recurring-payments.index','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Create Recurring Payment', 'route_name' => 'recurring-payments.create','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Store Recurring Payment', 'route_name' => 'recurring-payments.store','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Recurring Payment Details', 'route_name' => 'recurring-payments.Show','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Edit Recurring Payment', 'route_name' => 'recurring-payments.edit','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update Recurring Payment', 'route_name' => 'recurring-payments.update','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Delete Recurring Payment', 'route_name' => 'recurring-payments.destroy','is_dependant' => 'No','auto_select' => 'No'),
                ]
            ],
            [
                'title' => "Canned Message",
                'activities' => [
                    array('activity_name' => 'View Canned Message List', 'route_name' => 'canned-message.index','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Create Canned Message', 'route_name' => 'canned-message.create','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Store Canned Message', 'route_name' => 'canned-message.store','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Canned Message Details', 'route_name' => 'canned-message.Show','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Edit Canned Message', 'route_name' => 'canned-message.edit','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update Canned Message', 'route_name' => 'canned-message.update','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Delete Canned Message', 'route_name' => 'canned-message.destroy','is_dependant' => 'No','auto_select' => 'No'),
                ]
            ],
            [
                'title' => "Media",
                'activities' => [
                    array('activity_name' => 'View Media List', 'route_name' => 'media.index','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Create Media', 'route_name' => 'media.create','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Store Media', 'route_name' => 'media.store','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Media Details', 'route_name' => 'media.Show','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Edit Media', 'route_name' => 'media.edit','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update Media', 'route_name' => 'media.update','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Delete Media', 'route_name' => 'media.destroy','is_dependant' => 'No','auto_select' => 'No'),
                ]
            ],
            [
                'title' => "Article Group",
                'activities' => [
                    array('activity_name' => 'View Article Group List', 'route_name' => 'article-group.index','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Create Article Group', 'route_name' => 'article-group.create','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Store Article Group', 'route_name' => 'article-group.store','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Article Group Details', 'route_name' => 'article-group.Show','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Edit Article Group', 'route_name' => 'article-group.edit','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update Article Group', 'route_name' => 'article-group.update','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Delete Article Group', 'route_name' => 'article-group.destroy','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Article Group Sorting', 'route_name' => 'article-group-sorting','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Sort Article Group', 'route_name' => 'sort-article-group','is_dependant' => 'Yes','auto_select' => 'No'),
                ]
            ],
            [
                'title' => "Product/Category",
                'activities' => [
                    array('activity_name' => 'View Product/Category List', 'route_name' => 'product-category.index','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Create Product/Category', 'route_name' => 'product-category.create','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Store Product/Category', 'route_name' => 'product-category.store','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Product/Category Details', 'route_name' => 'product-category.Show','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Edit Product/Category', 'route_name' => 'product-category.edit','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update Product/Category', 'route_name' => 'product-category.update','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Delete Product/Category', 'route_name' => 'product-category.destroy','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Sort Product/Category', 'route_name' => 'product-category-sorting','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Product/Category Sort', 'route_name' => 'sort-product-category','is_dependant' => 'Yes','auto_select' => 'No'),
                ]
            ],
            
            [
                'title' => "Tag",
                'activities' => [
                    array('activity_name' => 'View Tag List', 'route_name' => 'tag.index','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Create Tag', 'route_name' => 'tag.create','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Store Tag', 'route_name' => 'tag.store','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Tag Details', 'route_name' => 'tag.Show','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Edit Tag', 'route_name' => 'tag.edit','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update Tag', 'route_name' => 'tag.update','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Delete Tag', 'route_name' => 'tag.destroy','is_dependant' => 'No','auto_select' => 'No'),
                ]
            ],
            
            
            [
                'title' => "FAQ",
                'activities' => [
                    array('activity_name' => 'View FAQ List', 'route_name' => 'faq.index','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Create FAQ', 'route_name' => 'faq.create','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Store FAQ', 'route_name' => 'faq.store','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'FAQ Details', 'route_name' => 'faq.Show','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Edit FAQ', 'route_name' => 'faq.edit','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update FAQ', 'route_name' => 'faq.update','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Delete FAQ', 'route_name' => 'faq.destroy','is_dependant' => 'No','auto_select' => 'No'),
                ]
            ],
            [
                'title' => "Page",
                'activities' => [
                    array('activity_name' => 'View Page List', 'route_name' => 'pages.index','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Create Page', 'route_name' => 'pages.create','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Store Page', 'route_name' => 'pages.store','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Page Details', 'route_name' => 'pages.Show','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Edit Page', 'route_name' => 'pages.edit','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update Page', 'route_name' => 'pages.update','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Delete Page', 'route_name' => 'pages.destroy','is_dependant' => 'No','auto_select' => 'No'),
                ]
            ],
            
            
            [
                'title' => "Role",
                'activities' => [
                    array('activity_name' => 'View Role List', 'route_name' => 'role.index','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Create Role', 'route_name' => 'role.create','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Store Role', 'route_name' => 'role.store','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Role Details', 'route_name' => 'role.Show','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Edit Role', 'route_name' => 'role.edit','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update Role', 'route_name' => 'role.update','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Delete Role', 'route_name' => 'role.destroy','is_dependant' => 'No','auto_select' => 'No'),
                ]
            ],
            [
                'title' => "Agents",
                'activities' => [
                    array('activity_name' => 'View Agent List', 'route_name' => 'agent.index','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Create Agent', 'route_name' => 'agent.create','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Store Agent', 'route_name' => 'agent.store','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Agent Details', 'route_name' => 'agent.Show','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Edit Agent', 'route_name' => 'agent.edit','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update Agent', 'route_name' => 'agent.update','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Delete Agent', 'route_name' => 'agent.destroy','is_dependant' => 'No','auto_select' => 'No'),
                ]
            ],
            [
                'title' => "Attendance",
                'activities' => [
                    array('activity_name' => 'View Attendance List', 'route_name' => 'attendance.index','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Create Attendance', 'route_name' => 'attendance.create','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Store Attendance', 'route_name' => 'attendance.store','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Attendance Details', 'route_name' => 'attendance.Show','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Edit Attendance', 'route_name' => 'attendance.edit','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update Attendance', 'route_name' => 'attendance.update','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Delete Attendance', 'route_name' => 'attendance.destroy','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Check-In/Check-Out', 'route_name' => 'check-in-out','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Check-In', 'route_name' => 'in-attendance','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Check-Out', 'route_name' => 'out-attendance','is_dependant' => 'Yes','auto_select' => 'No'),
                ]
            ],
            
            [
                'title' => "Vacation",
                'activities' => [
                    array('activity_name' => 'View Vacation List', 'route_name' => 'vacations.index','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Create Vacation', 'route_name' => 'vacations.create','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Store Vacation', 'route_name' => 'vacations.store','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Vacation Details', 'route_name' => 'vacations.Show','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Edit Vacation', 'route_name' => 'vacations.edit','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update Vacation', 'route_name' => 'vacations.update','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Delete Vacation', 'route_name' => 'vacations.destroy','is_dependant' => 'No','auto_select' => 'No'),

                    array('activity_name' => 'View Holiday List', 'route_name' => 'holiday-setting.index','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Create Holiday', 'route_name' => 'holiday-setting.create','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Store Holiday', 'route_name' => 'holiday-setting.store','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Holiday Details', 'route_name' => 'holiday-setting.Show','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Edit Holiday', 'route_name' => 'holiday-setting.edit','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update Holiday', 'route_name' => 'holiday-setting.update','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Delete Holiday', 'route_name' => 'holiday-setting.destroy','is_dependant' => 'No','auto_select' => 'No'),
                ]
            ],
            
            
            [
                'title' =>  "Attendance",
                'activities' => [
                    array('activity_name' => 'Checkin Attendance', 'route_name' => 'in-attendance','is_dependant' => 'No','auto_select' => 'Yes'),
                    array('activity_name' => 'Checkout Attendance', 'route_name' => 'out-attendance','is_dependant' => 'No','auto_select' => 'Yes'),
                    array('activity_name' => 'View Attendance List', 'route_name' => 'attendance.index','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Create Attendance', 'route_name' => 'attendance.create','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Store Attendance', 'route_name' => 'attendance.store','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' =>  'Attendance Details', 'route_name' => 'attendance.Show','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Edit Attendance', 'route_name' => 'attendance.edit','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update Attendance', 'route_name' => 'attendance.update','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Delete Attendance', 'route_name' => 'attendance.destroy','is_dependant' => 'No','auto_select' => 'No'),
                ]
            ],
            
            [
                'title' => "Setting",
                'activities' => [
                    array('activity_name' => 'Site Setting', 'route_name' => 'site-setting','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update Site Setting', 'route_name' => 'update-site-setting','is_dependant' => 'Yes','auto_select' => 'No'),

                    array('activity_name' => 'Social Login Setting', 'route_name' => 'social-login-setting','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update Social Login Setting', 'route_name' => 'update-social-login-setting','is_dependant' => 'Yes','auto_select' => 'No'),

                    array('activity_name' => 'View Custom Field List', 'route_name' => 'custom-fields.index','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Create Custom Field', 'route_name' => 'custom-fields.create','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Store Custom Field', 'route_name' => 'custom-fields.store','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Custom Field Details', 'route_name' => 'custom-fields.Show','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Edit Custom Field', 'route_name' => 'custom-fields.edit','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update Custom Field', 'route_name' => 'custom-fields.update','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Delete Custom Field', 'route_name' => 'custom-fields.destroy','is_dependant' => 'No','auto_select' => 'No'),

                    array('activity_name' => 'Ticket Setting', 'route_name' => 'ticket-setting','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update Ticket Setting', 'route_name' => 'update-ticket-setting','is_dependant' => 'Yes','auto_select' => 'No'),

                    array('activity_name' => 'Chat Setting', 'route_name' => 'chat-setting','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update Chat Setting', 'route_name' => 'update-chat-setting','is_dependant' => 'Yes','auto_select' => 'No'),
                    
                    array('activity_name' => 'Chat Sequence Setting', 'route_name' => 'chat-sequence-setting','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Sort agent chat sequence', 'route_name' => 'sort-agent-chat-sequence','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Update chat sequence setting', 'route_name' => 'update-chat-sequence-setting','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Update chat agent', 'route_name' => 'update-chat-agent','is_dependant' => 'Yes','auto_select' => 'No'),

                    array('activity_name' => 'View Department List', 'route_name' => 'departments.index','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Create Department', 'route_name' => 'departments.create','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Store Department', 'route_name' => 'departments.store','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Department Details', 'route_name' => 'departments.Show','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Edit Department', 'route_name' => 'departments.edit','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update Department', 'route_name' => 'departments.update','is_dependant' => 'Yes','auto_select' => 'No'),
                    array('activity_name' => 'Delete Department', 'route_name' => 'departments.destroy','is_dependant' => 'No','auto_select' => 'No'),

                    array('activity_name' => 'Integration Setting', 'route_name' => 'integration-setting','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update Integration Setting', 'route_name' => 'update-integration-setting','is_dependant' => 'Yes','auto_select' => 'No'),

                    array('activity_name' => 'Mail Setting', 'route_name' => 'mail-setting','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update Mail Setting', 'route_name' => 'update-mail-setting','is_dependant' => 'Yes','auto_select' => 'No'),

                    array('activity_name' => 'Mail Template Setting', 'route_name' => 'mail-templates','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Edit Mail Template', 'route_name' => 'mail-templates-edit','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update Mail Template', 'route_name' => 'mail-template-update','is_dependant' => 'Yes','auto_select' => 'No'),

                    array('activity_name' => 'Notification Setting', 'route_name' => 'notification-setting','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update Notification Setting', 'route_name' => 'update-notification-setting','is_dependant' => 'Yes','auto_select' => 'No'),

                    array('activity_name' => 'Payment Gateway Setting', 'route_name' => 'payment-gateway-setting','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update Payment Gateway Setting', 'route_name' => 'update-payment-gateway-setting','is_dependant' => 'Yes','auto_select' => 'No'),

                    array('activity_name' => 'GDPR Setting', 'route_name' => 'gdpr-setting','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update GDPR Setting', 'route_name' => 'update-gdpr-setting','is_dependant' => 'Yes','auto_select' => 'No'),

                    array('activity_name' => 'About Us Setting', 'route_name' => 'about-us-setting','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update About Us Setting', 'route_name' => 'update-about-us-setting','is_dependant' => 'Yes','auto_select' => 'No'),

                    array('activity_name' => 'Our Services Setting', 'route_name' => 'our-services-setting','is_dependant' => 'No','auto_select' => 'No'),
                    array('activity_name' => 'Update Our Services Setting', 'route_name' => 'update-our-services-setting','is_dependant' => 'Yes','auto_select' => 'No'),
                ]
            ],
            
        );

        foreach ($menus as $menu) {
            $menu_data = ['title' => $menu['title']];
            Menu::updateOrInsert($menu_data,$menu_data);
            if(count($menu['activities'])) {
                foreach ($menu['activities'] as $activity) {
                    $menu_id = Menu::where('title',$menu)->first()->id;
                    $identify = [
                        'menu_id'=>$menu_id,
                        'route_name' => $activity['route_name']
                    ];
                    $activity_data = [
                        'menu_id'=>$menu_id,
                        'activity_name' => $activity['activity_name'],
                        'route_name' => $activity['route_name'],
                        'is_dependant' => $activity['is_dependant'],
                        'auto_select' => $activity['auto_select']
                    ];
                    MenuActivity::updateOrInsert($identify,$activity_data);
                }
            }
        }
    }
    /**
     * Define relation with MenuActivity table
     */
    public function activities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MenuActivity::class,'menu_id','id');
    }

}
