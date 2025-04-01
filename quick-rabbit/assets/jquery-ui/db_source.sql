CREATE TABLE `article_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `article_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `comment` text NOT NULL,
  `del_status` varchar(50) DEFAULT 'Live',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` longtext DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(30) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ticket_id` varchar(11) DEFAULT NULL,
  `activity` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(7) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_admin_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(191) DEFAULT NULL COMMENT '"Create, Close, Reopen,Mentioned,Comment,Flag"',
  `from` varchar(191) DEFAULT NULL COMMENT 'Agent,Customer:Use created_by to catch',
  `ticket_id` int(11) DEFAULT NULL,
  `reply_comment_id` int(11) DEFAULT NULL,
  `message` varchar(191) DEFAULT NULL,
  `redirect_link` varchar(191) DEFAULT NULL,
  `mark_as_read_status` tinyint(4) DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(7) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_agent_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(191) DEFAULT NULL COMMENT '"Create, Close, Reopen,Mentioned,Comment,Flag"',
  `from` varchar(191) DEFAULT NULL COMMENT 'Admin,Customer:Use created_by to catch',
  `agent_for` int(11) DEFAULT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `reply_comment_id` int(11) DEFAULT NULL,
  `message` varchar(191) DEFAULT NULL,
  `redirect_link` varchar(191) DEFAULT NULL,
  `mark_as_read_status` tinyint(4) DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(7) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_ai_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'Yes',
  `api_key` tinytext DEFAULT NULL,
  `organization_key` tinytext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(7) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tbl_ai_settings` (`id`, `type`, `api_key`, `organization_key`, `created_at`, `updated_at`, `del_status`) VALUES
(1, 'Yes', 'xxxxxx', 'xxxxxx', NULL, '2024-05-16 07:18:19', 'Live');

CREATE TABLE `tbl_articles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `title_slug` varchar(255) DEFAULT NULL,
  `product_category_id` smallint(6) DEFAULT NULL,
  `article_group_id` smallint(6) DEFAULT NULL,
  `convert_from_ticket_id` smallint(6) DEFAULT NULL,
  `internal_external` tinyint(4) DEFAULT NULL,
  `tag_ids` text DEFAULT NULL,
  `tag_titles` text DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `page_content` longtext DEFAULT NULL,
  `sort_id` int(11) NOT NULL DEFAULT 1,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(7) NOT NULL DEFAULT 'Live',
  `vote_yes` int(11) NOT NULL DEFAULT 0,
  `vote_no` int(11) NOT NULL DEFAULT 0,
  `video_link` text DEFAULT NULL,
  `video_thumbnail` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_article_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `slug` varchar(191) NOT NULL,
  `tag_titles` text DEFAULT NULL,
  `product_category` smallint(6) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `sort_id` int(11) NOT NULL DEFAULT 1,
  `icon` varchar(100) DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(7) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference` varchar(191) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `attendance_date` varchar(191) NOT NULL,
  `in_time` varchar(191) NOT NULL,
  `out_time` varchar(191) DEFAULT NULL,
  `work_hour` varchar(191) NOT NULL DEFAULT '0',
  `note` text DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_auto_replies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT 0,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `department_id` int(11) DEFAULT 0,
  `question` varchar(250) DEFAULT NULL,
  `answer` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(7) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `blog_content` longtext DEFAULT NULL,
  `image` varchar(300) DEFAULT NULL,
  `thumb_img` varchar(250) DEFAULT NULL,
  `tag_ids` text DEFAULT NULL,
  `tag_titles` text DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(7) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_blog_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(7) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_blog_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `blog_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `comment` longtext NOT NULL,
  `del_status` varchar(191) NOT NULL DEFAULT 'Live',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_canned_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `canned_msg_slug` varchar(100) DEFAULT NULL,
  `canned_msg_content` longtext DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(7) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_chat_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_by` varchar(191) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `code` varchar(191) DEFAULT NULL,
  `user_type` varchar(191) DEFAULT 'customer',
  `guest_user_name` varchar(191) DEFAULT NULL,
  `guest_user_email` varchar(191) DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `status` varchar(191) NOT NULL DEFAULT 'Active',
  `last_message_at` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_chat_group_members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_chat_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `chat_widget_show` varchar(7) DEFAULT NULL,
  `chat_schedule_days` varchar(191) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `auto_reply_out_of_schedule` varchar(191) NOT NULL DEFAULT 'off',
  `out_of_schedule_time_message` longtext DEFAULT NULL,
  `pusher_info` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tbl_chat_settings` (`id`, `chat_widget_show`, `chat_schedule_days`, `start_time`, `end_time`, `auto_reply_out_of_schedule`, `out_of_schedule_time_message`, `pusher_info`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'on', '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Sunday\"]', '10:00:00', '15:00:00', 'on', 'Out of office! Your inquiry received outside our support hours. We\'ll get back during our next available time. Thank you!', '{\n    \"channel_name\": \"xxxxxx\",\n    \"app_id\": \"xxxxxx\",\n    \"app_key\": \"xxxxxx\",\n    \"app_secret\": \"xxxxxx\",\n    \"app_cluster\": \"xxxxxx\"\n}', 1, 1, '2023-03-14 21:55:48', '2025-01-02 04:27:01');

CREATE TABLE `tbl_configuration_settings` (
  `id` bigint(20) NOT NULL,
  `facebook_login` tinyint(1) NOT NULL DEFAULT 0,
  `inerest_facebook_login` tinyint(1) NOT NULL DEFAULT 1,
  `google_login` tinyint(1) NOT NULL DEFAULT 0,
  `inerest_google_login` tinyint(1) NOT NULL DEFAULT 1,
  `github_login` tinyint(1) NOT NULL DEFAULT 0,
  `inerest_github_login` tinyint(1) NOT NULL DEFAULT 1,
  `linkedin_login` tinyint(1) NOT NULL DEFAULT 0,
  `inerest_linkedin_login` tinyint(1) NOT NULL DEFAULT 1,
  `envato_login` tinyint(1) NOT NULL DEFAULT 0,
  `inerest_envato_login` tinyint(1) NOT NULL DEFAULT 1,
  `chat_setting` tinyint(1) NOT NULL DEFAULT 0,
  `inerest_chat_setting` tinyint(1) NOT NULL DEFAULT 1,
  `notification_setting` tinyint(1) NOT NULL DEFAULT 0,
  `inerest_notification_setting` tinyint(1) NOT NULL DEFAULT 1,
  `mail_setting` tinyint(1) NOT NULL DEFAULT 0,
  `inerest_mail_setting` tinyint(1) NOT NULL DEFAULT 1,
  `payment_gateway_setting` tinyint(1) NOT NULL DEFAULT 0,
  `inerest_payment_gateway_setting` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tbl_configuration_settings` (`id`, `facebook_login`, `inerest_facebook_login`, `google_login`, `inerest_google_login`, `github_login`, `inerest_github_login`, `linkedin_login`, `inerest_linkedin_login`, `envato_login`, `inerest_envato_login`, `chat_setting`, `inerest_chat_setting`, `notification_setting`, `inerest_notification_setting`, `mail_setting`, `inerest_mail_setting`, `payment_gateway_setting`, `inerest_payment_gateway_setting`) VALUES
(1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

CREATE TABLE `tbl_customer_notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` smallint(6) DEFAULT NULL,
  `note` longtext DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(7) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_customer_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(191) DEFAULT NULL COMMENT '"Create, Close, Reopen,Mentioned,Comment,Flag"',
  `from` varchar(191) DEFAULT NULL COMMENT 'Admin,Agent:Use created_by to catch',
  `customer_for` int(11) DEFAULT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `reply_comment_id` int(11) DEFAULT NULL,
  `message` varchar(191) DEFAULT NULL,
  `redirect_link` varchar(191) DEFAULT NULL,
  `mark_as_read_status` tinyint(4) DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(7) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_custom_fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_category_id` int(11) NOT NULL,
  `department_id` int(11) DEFAULT 0,
  `status` varchar(191) NOT NULL DEFAULT 'Active',
  `custom_field_type` longtext DEFAULT NULL,
  `custom_field_label` longtext DEFAULT NULL,
  `custom_field_option` longtext DEFAULT NULL,
  `custom_field_required` longtext DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(7) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `leader` varchar(50) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(7) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(100) DEFAULT NULL,
  `answer` longtext DEFAULT NULL,
  `product_category_id` smallint(6) DEFAULT NULL,
  `tag_ids` text DEFAULT NULL,
  `tag_titles` text DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(7) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_feedbacks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `rating` double(8,2) DEFAULT NULL,
  `review` longtext DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(7) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_forums` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` varchar(191) NOT NULL,
  `department_id` int(11) DEFAULT 0,
  `subject` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `description` longtext NOT NULL,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `total_like_counter` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(191) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_forum_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `forum_id` int(11) NOT NULL,
  `comment` longtext NOT NULL,
  `total_like_counter` int(11) DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_forum_likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `forum_id` int(11) DEFAULT 0,
  `forum_comment_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `del_status` varchar(20) DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_group_chat_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_id` int(11) NOT NULL,
  `user_type` varchar(191) DEFAULT NULL,
  `group_id` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `file` varchar(191) DEFAULT NULL,
  `seen_status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_g_d_p_r_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `enable_gdpr` varchar(191) NOT NULL DEFAULT 'off',
  `view_cookie_notification_bar` varchar(191) NOT NULL DEFAULT 'off',
  `cookie_message_title` varchar(255) DEFAULT NULL,
  `cookie_message` text DEFAULT NULL,
  `policy_message_on_reg_form` varchar(191) NOT NULL DEFAULT 'off',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_holiday_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `day` varchar(10) NOT NULL,
  `start_time` varchar(191) DEFAULT NULL,
  `end_time` varchar(191) DEFAULT NULL,
  `auto_response` varchar(3) DEFAULT NULL,
  `mail_subject` varchar(191) DEFAULT NULL,
  `mail_body` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_integration_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `envato_set_up` varchar(7) DEFAULT NULL,
  `envato_api_key` varchar(50) DEFAULT NULL,
  `ticket_submit_on_support_period_expired` varchar(7) NOT NULL DEFAULT 'No',
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tbl_integration_settings` (`id`, `envato_set_up`, `envato_api_key`, `ticket_submit_on_support_period_expired`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'on', 'xxxxxx', 'No', 1, 1, '2023-02-17 19:51:02', '2024-04-21 00:05:30');

CREATE TABLE `tbl_mail_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mail_driver` varchar(50) DEFAULT NULL,
  `mail_host` varchar(100) DEFAULT NULL,
  `mail_port` smallint(6) DEFAULT NULL,
  `mail_encryption` varchar(50) DEFAULT NULL,
  `mail_username` varchar(100) DEFAULT NULL,
  `mail_password` varchar(100) DEFAULT NULL,
  `mail_from` varchar(100) DEFAULT NULL,
  `from_name` varchar(100) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tbl_mail_settings` (`id`, `mail_driver`, `mail_host`, `mail_port`, `mail_encryption`, `mail_username`, `mail_password`, `mail_from`, `from_name`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'smtp', 'xxxxxx', 587, 'tls', 'xxxxxx', 'xxxxxx', 'no-reply@doorsoft.co', 'Quick Rabbit', 1, 1, 1, '2023-01-23 00:19:20', '2024-03-08 22:25:33');

CREATE TABLE `tbl_mail_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_key` varchar(191) DEFAULT NULL,
  `event` varchar(400) DEFAULT NULL,
  `customer_mail_subject` varchar(500) DEFAULT NULL,
  `admin_agent_mail_subject` varchar(500) DEFAULT NULL,
  `customer_mail_body` longtext DEFAULT NULL,
  `admin_agent_mail_body` longtext DEFAULT NULL,
  `mail_to` varchar(500) DEFAULT NULL,
  `web_push_notification` varchar(191) NOT NULL DEFAULT 'off',
  `mail_notification` varchar(191) NOT NULL DEFAULT 'off',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tbl_mail_templates` (`id`, `event_key`, `event`, `customer_mail_subject`, `admin_agent_mail_subject`, `customer_mail_body`, `admin_agent_mail_body`, `mail_to`, `web_push_notification`, `mail_notification`, `created_at`, `updated_at`) VALUES
(1, 'open_ticket', 'Open Ticket', 'New Ticket [ticket_no] - [product_name] - [ticket_subject]', 'New Ticket [ticket_no] - [product_name] - [ticket_subject]', '<p>Dear&nbsp;[customer_name],<br />\r\n<br />\r\nYour ticket [ticket_no] has been opened successfully for product&nbsp;[product_name]. Our agents will replay you soon.<br />\r\n<br />\r\nThanks for your patience!<br />\r\n<br />\r\nRegards,<br />\r\n<br />\r\n[site_name]</p>\r\n\r\n<p>[date_time]</p>', '<p>Hello,</p>\r\n\r\n<p>A new ticket has been opened for&nbsp;[customer_name] [ticket_no] of the product&nbsp;[product_name] on [date_time].</p>\r\n\r\n<p>Ticket Description: [ticket_description]</p>\r\n\r\n<p>Priority: [priority] Please act based on priority.</p>', NULL, 'on', 'on', '2023-03-26 22:43:05', '2024-03-10 04:07:11'),
(2, 'auto_email_reply', 'Auto Email Reply On Ticket Open', 'Thanks for create ticket - [ticket_no]', '', '<p>[ticket_description]</p>\r\n\r\n<p>[date_time]</p>', NULL, NULL, 'on', 'on', '2023-03-26 22:43:05', '2024-04-29 20:59:39'),
(3, 'reply_ticket_by_customer', 'Reply By Customer On Ticket', '', 'Customer replied on ticket [ticket_no] - [product_name] - [ticket_subject]', NULL, '<p>Hello,</p>\r\n\r\n<p>Customer posted a reply on [ticket_no] of the product [product_name] on [date_time].</p>\r\n\r\n<p><strong>Reply:</strong> [reply]</p>\r\n\r\n<p>Please act based on priority.</p>', NULL, 'on', 'on', '2023-03-26 22:43:05', '2023-05-02 13:03:31'),
(4, 'reply_ticket_by_admin_agent', 'Reply By Admin/Agent On Ticket', 'Agent/Admin replied on Ticket [ticket_no] - [product_name] - [ticket_subject]', '', '<p>Dear [customer_name],</p>\r\n\r\n<p>An agent/admin posted a reply on [ticket_no] of the product [product_name] on [date_time].<br />\r\n<strong>Reply: </strong>[reply]<br />\r\nPlease act based on priority.</p>', NULL, NULL, 'on', 'on', '2023-03-26 22:43:05', '2023-06-21 19:41:53'),
(5, 'assign_agent', 'Assign Agent On Ticket', '', 'You have been assigned to a Ticket [ticket_no]', NULL, '<p>Hello&nbsp;[agent_name],</p>\r\n\r\n<p>You have been assigned to a ticket [ticket_no] of the product [product_name] on [date_time].</p>\r\n\r\n<p>Now you can follow this ticket.</p>', NULL, 'on', 'on', '2023-03-26 22:43:05', '2023-05-02 13:03:31'),
(6, 'close_ticket', 'Close Ticket', 'Ticket has been closed [ticket_no] - [product_name] - [ticket_subject]', 'Ticket has been closed  [ticket_no] - [product_name] - [ticket_subject]', '<p>Dear&nbsp;[customer_name],</p>\r\n\r\n<p>An [user_type] has been closed the ticket [ticket_no] of the product [product_name] on [date_time].</p>\r\n\r\n<p>You can re-open the ticket if you still have any query.</p>', '<p>Hello [site_name],</p>\r\n\r\n<p>An [user_type] has been closed the ticket [ticket_no] of the product [product_name] on [date_time].</p>', NULL, 'on', 'on', '2023-03-26 22:43:05', '2023-06-22 05:10:04'),
(7, 'reopen_ticket', 'Reopen Ticket', 'Ticket [ticket_no] has been re-opened by [user_type]', 'Ticket [ticket_no] has been re-opened by [user_type]', '<p>Hello&nbsp;[customer_name],</p>\r\n\r\n<p>Ticket [ticket_no] has been re-opened by [user_type]</p>', '<p>Hello&nbsp;[site_name],</p>\r\n\r\n<p>Ticket [ticket_no] has been re-opened by [user_type].</p>', NULL, 'on', 'on', '2023-03-26 22:43:05', '2023-06-22 05:10:34'),
(8, 'chat_message_by_customer', 'Chat Message by Customer', '', 'New chat message on [site_name]', NULL, '<p>There is a new chat message on [site_name] by [user_type] on [date_time]. Please login to the site and check your inbox.</p>', NULL, 'on', 'on', '2023-03-26 22:43:05', '2023-05-02 13:03:31'),
(9, 'chat_message_by_admin_agent', 'Chat Message by Admin/Agent', 'New chat message on [site_name]', '', '<p>There is a new chat message on [site_name] by [user_type] on [date_time]. Please login to the site and check your inbox.</p>', NULL, NULL, 'on', 'on', '2023-03-26 22:43:05', '2023-05-02 13:03:31'),
(10, 'chat_close', 'Chat Close', 'Your chat transcript from [site_name]', 'Your chat transcript from [site_name]', '<p>Hello&nbsp;[customer_name]</p>\r\n\r\n<p>A chat has been closed on [site_name] by [user_type] on [date_time]. You can open another chat if you have further query.</p>', '<p>A chat has been closed on [site_name] by [user_type] on [date_time].</p>', NULL, 'on', 'on', '2023-03-26 22:43:05', '2023-06-17 22:37:12'),
(11, 'assign_cc_on_ticket', 'Assigned CC Email On Ticket', '', 'Something happened on the ticket [ticket_no]', NULL, '<p>Hello&nbsp;EMAIL_ADDRESS,</p>\r\n\r\n<p>Something happened on the ticket [ticket_no] of the product [product_name] on [date_time]. Where the agent/admin/customer of the ticket wants to keep you updated about that.</p>\r\n\r\n<p>You can follow the ticket time to time from the ticket link.</p>\r\n\r\n<p><strong>Ticket Title:</strong>&nbsp;[ticket_subject]</p>\r\n\r\n<p><strong>Ticket Description:</strong> [ticket_description]</p>\r\n\r\n<p><strong>Last Reply:</strong> By [user_type] [reply]</p>', NULL, 'on', 'on', '2023-03-26 22:43:05', '2023-05-05 06:13:10');

CREATE TABLE `tbl_medias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(250) DEFAULT NULL,
  `media_path` text DEFAULT NULL,
  `thumb_img` varchar(191) DEFAULT NULL,
  `group` varchar(20) DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(7) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `description` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tbl_menus` (`id`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 'User Home', NULL, NULL, NULL),
(2, 'Dashboard', NULL, NULL, NULL),
(3, 'Profile', NULL, NULL, NULL),
(4, 'Tickets', NULL, NULL, NULL),
(5, 'Customers', NULL, NULL, NULL),
(6, 'Task and Calendar', NULL, NULL, NULL),
(7, 'Article', NULL, NULL, NULL),
(8, 'Blog', NULL, NULL, NULL),
(9, 'Notice', NULL, NULL, NULL),
(10, 'Report', NULL, NULL, NULL),
(11, 'Recurring Payment', NULL, NULL, NULL),
(12, 'Canned Message', NULL, NULL, NULL),
(13, 'Media', NULL, NULL, NULL),
(14, 'Article Group', NULL, NULL, NULL),
(15, 'Product/Category', NULL, NULL, NULL),
(16, 'Tag', NULL, NULL, NULL),
(17, 'FAQ', NULL, NULL, NULL),
(18, 'Page', NULL, NULL, NULL),
(19, 'Role', NULL, NULL, NULL),
(20, 'Agents', NULL, NULL, NULL),
(21, 'Attendance', NULL, NULL, NULL),
(22, 'Vacation', NULL, NULL, NULL),
(23, 'Setting', NULL, NULL, NULL),
(24, 'Testimonial', NULL, NULL, NULL);

CREATE TABLE `tbl_menu_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` int(11) NOT NULL,
  `activity_name` varchar(191) NOT NULL,
  `route_name` varchar(191) NOT NULL,
  `is_dependant` varchar(191) NOT NULL DEFAULT 'No',
  `auto_select` varchar(191) NOT NULL DEFAULT 'No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tbl_menu_activities` (`id`, `menu_id`, `activity_name`, `route_name`, `is_dependant`, `auto_select`, `created_at`, `updated_at`) VALUES
(1, 1, 'User Home', 'user-home', 'Yes', 'Yes', NULL, NULL),
(2, 2, 'Dashboard View', 'dashboard', 'No', 'Yes', NULL, NULL),
(3, 3, 'Change Password', 'change-password', 'No', 'Yes', NULL, NULL),
(4, 3, 'Edit Profile', 'edit-profile', 'No', 'Yes', NULL, NULL),
(5, 3, 'Set Security Question', 'set-security-question', 'No', 'Yes', NULL, NULL),
(6, 3, 'Save Security Question', 'save-security-question', 'Yes', 'Yes', NULL, NULL),
(7, 3, 'Update Profile', 'update-profile', 'Yes', 'Yes', NULL, NULL),
(8, 4, 'View Ticket List', 'ticket.index', 'No', 'Yes', NULL, NULL),
(9, 4, 'Create Ticket', 'ticket.create', 'No', 'Yes', NULL, NULL),
(10, 4, 'Store Ticket', 'ticket.store', 'No', 'Yes', NULL, NULL),
(11, 4, 'Ticket Details', 'ticket.Show', 'No', 'Yes', NULL, NULL),
(12, 4, 'Edit Ticket', 'ticket.edit', 'No', 'Yes', NULL, NULL),
(13, 4, 'Update Ticket', 'ticket.update', 'No', 'Yes', NULL, NULL),
(14, 4, 'Delete Ticket', 'ticket.destroy', 'No', 'Yes', NULL, NULL),
(15, 4, 'Check Ticket Relevant Verification', 'check-relevant-verification', 'Yes', 'Yes', NULL, NULL),
(16, 4, 'Get Editor Mentioned Data', 'get-editor-mentioned-data', 'No', 'Yes', NULL, NULL),
(17, 4, 'Ticket Customer Note List', 'get-customer-all-notes', 'No', 'Yes', NULL, NULL),
(18, 4, 'Get Article Searched Data', 'get-article-searched-data', 'Yes', 'Yes', NULL, NULL),
(19, 4, 'Assign Agent To Ticket', 'set-ticket-assign-priority', 'No', 'Yes', NULL, NULL),
(20, 4, 'Ticket Close/Reopen', 'set-ticket-status-close-reopen', 'No', 'Yes', NULL, NULL),
(21, 4, 'Set Flag On Ticket', 'flag-ticket', 'No', 'Yes', NULL, NULL),
(22, 4, 'Ticket Archived', 'ticket-archived', 'No', 'Yes', NULL, NULL),
(23, 4, 'Reply In Ticket', 'posting-replay-in-ticket', 'No', 'Yes', NULL, NULL),
(24, 4, 'Add Customer Note', 'add-customer-note', 'No', 'Yes', NULL, NULL),
(25, 4, 'Add Ticket Note', 'add-ticket-note', 'No', 'Yes', NULL, NULL),
(26, 4, 'Set CC Mail On Ticket', 'add-ticket-cc', 'No', 'Yes', NULL, NULL),
(27, 4, 'Ticket Comment Update', 'update-reply-comment', 'No', 'Yes', NULL, NULL),
(28, 4, 'Convert Ticket Comment To Article', 'ticket-convert-to-article', 'No', 'Yes', NULL, NULL),
(29, 5, 'View Customer List', 'customer.index', 'No', 'No', NULL, NULL),
(30, 5, 'Create Customer', 'customer.create', 'No', 'No', NULL, NULL),
(31, 5, 'Store Customer', 'customer.store', 'Yes', 'No', NULL, NULL),
(32, 5, 'Customer Details', 'customer.Show', 'No', 'No', NULL, NULL),
(33, 5, 'Edit Customer', 'customer.edit', 'No', 'No', NULL, NULL),
(34, 5, 'Update Customer', 'customer.update', 'Yes', 'No', NULL, NULL),
(35, 5, 'Delete Customer', 'customer.destroy', 'No', 'No', NULL, NULL),
(36, 5, 'Reset Customer Password', 'reset-customer-password', 'No', 'No', NULL, NULL),
(37, 6, 'View Task List', 'task-lists.index', 'No', 'No', NULL, NULL),
(38, 6, 'Create Task', 'task-lists.create', 'No', 'No', NULL, NULL),
(39, 6, 'Store Task', 'task-lists.store', 'Yes', 'No', NULL, NULL),
(40, 6, 'Task Details', 'task-lists.Show', 'No', 'No', NULL, NULL),
(41, 6, 'Edit Task', 'task-lists.edit', 'No', 'No', NULL, NULL),
(42, 6, 'Update Task', 'task-lists.update', 'Yes', 'No', NULL, NULL),
(43, 6, 'Delete Task', 'task-lists.destroy', 'No', 'No', NULL, NULL),
(44, 6, 'View Task Calander', 'task-calendar', 'No', 'No', NULL, NULL),
(45, 6, 'Update Task Status', 'update-task-status', 'No', 'No', NULL, NULL),
(46, 7, 'View Article List', 'article.index', 'No', 'No', NULL, NULL),
(47, 7, 'Create Article', 'article.create', 'No', 'No', NULL, NULL),
(48, 7, 'Store Article', 'article.store', 'Yes', 'No', NULL, NULL),
(49, 7, 'Article Details', 'article.Show', 'No', 'No', NULL, NULL),
(50, 7, 'Edit Article', 'article.edit', 'No', 'No', NULL, NULL),
(51, 7, 'Update Article', 'article.update', 'Yes', 'No', NULL, NULL),
(52, 7, 'Delete Article', 'article.destroy', 'No', 'No', NULL, NULL),
(53, 8, 'View Blog Category List', 'blog-categories.index', 'No', 'No', NULL, NULL),
(54, 8, 'Create Blog Category', 'blog-categories.create', 'No', 'No', NULL, NULL),
(55, 8, 'Store Blog Category', 'blog-categories.store', 'Yes', 'No', NULL, NULL),
(56, 8, 'Blog Category Details', 'blog-categories.Show', 'Yes', 'No', NULL, NULL),
(57, 8, 'Edit Blog Category', 'blog-categories.edit', 'No', 'No', NULL, NULL),
(58, 8, 'Update Blog Category', 'blog-categories.update', 'Yes', 'No', NULL, NULL),
(59, 8, 'Delete Blog Category', 'blog-categories.destroy', 'No', 'No', NULL, NULL),
(60, 8, 'View Blog List', 'blog.index', 'No', 'No', NULL, NULL),
(61, 8, 'Create Blog', 'blog.create', 'No', 'No', NULL, NULL),
(62, 8, 'Store Blog', 'blog.store', 'Yes', 'No', NULL, NULL),
(63, 8, 'Blog Details', 'blog.Show', 'No', 'No', NULL, NULL),
(64, 8, 'Edit Blog', 'blog.edit', 'No', 'No', NULL, NULL),
(65, 8, 'Update Blog', 'blog.update', 'Yes', 'No', NULL, NULL),
(66, 8, 'Delete Blog', 'blog.destroy', 'No', 'No', NULL, NULL),
(67, 9, 'View Notice List', 'notices.index', 'No', 'No', NULL, NULL),
(68, 9, 'Create Notice', 'notices.create', 'No', 'No', NULL, NULL),
(69, 9, 'Store Notice', 'notices.store', 'Yes', 'No', NULL, NULL),
(70, 9, 'Notice Details', 'notices.Show', 'No', 'No', NULL, NULL),
(71, 9, 'Edit Notice', 'notices.edit', 'No', 'No', NULL, NULL),
(72, 9, 'Update Notice', 'notices.update', 'Yes', 'No', NULL, NULL),
(73, 9, 'Delete Notice', 'notices.destroy', 'No', 'No', NULL, NULL),
(74, 10, 'Agent Performance Report', 'agent-report', 'No', 'No', NULL, NULL),
(75, 10, 'Support History Report', 'support-history-report', 'No', 'No', NULL, NULL),
(76, 10, 'Customer Feedback Report', 'customer-feedback-report', 'No', 'No', NULL, NULL),
(77, 10, 'Transaction Report', 'transaction-report', 'No', 'No', NULL, NULL),
(78, 10, 'Attendance Report', 'attendance-report', 'No', 'No', NULL, NULL),
(79, 11, 'View Recurring Payment List', 'recurring-payments.index', 'No', 'No', NULL, NULL),
(80, 11, 'Create Recurring Payment', 'recurring-payments.create', 'No', 'No', NULL, NULL),
(81, 11, 'Store Recurring Payment', 'recurring-payments.store', 'Yes', 'No', NULL, NULL),
(82, 11, 'Recurring Payment Details', 'recurring-payments.Show', 'No', 'No', NULL, NULL),
(83, 11, 'Edit Recurring Payment', 'recurring-payments.edit', 'No', 'No', NULL, NULL),
(84, 11, 'Update Recurring Payment', 'recurring-payments.update', 'Yes', 'No', NULL, NULL),
(85, 11, 'Delete Recurring Payment', 'recurring-payments.destroy', 'No', 'No', NULL, NULL),
(86, 12, 'View Canned Message List', 'canned-message.index', 'No', 'No', NULL, NULL),
(87, 12, 'Create Canned Message', 'canned-message.create', 'No', 'No', NULL, NULL),
(88, 12, 'Store Canned Message', 'canned-message.store', 'Yes', 'No', NULL, NULL),
(89, 12, 'Canned Message Details', 'canned-message.Show', 'No', 'No', NULL, NULL),
(90, 12, 'Edit Canned Message', 'canned-message.edit', 'No', 'No', NULL, NULL),
(91, 12, 'Update Canned Message', 'canned-message.update', 'Yes', 'No', NULL, NULL),
(92, 12, 'Delete Canned Message', 'canned-message.destroy', 'No', 'No', NULL, NULL),
(93, 13, 'View Media List', 'media.index', 'No', 'No', NULL, NULL),
(94, 13, 'Create Media', 'media.create', 'No', 'No', NULL, NULL),
(95, 13, 'Store Media', 'media.store', 'Yes', 'No', NULL, NULL),
(96, 13, 'Media Details', 'media.Show', 'No', 'No', NULL, NULL),
(97, 13, 'Edit Media', 'media.edit', 'No', 'No', NULL, NULL),
(98, 13, 'Update Media', 'media.update', 'Yes', 'No', NULL, NULL),
(99, 13, 'Delete Media', 'media.destroy', 'No', 'No', NULL, NULL),
(100, 14, 'View Article Group List', 'article-group.index', 'No', 'No', NULL, NULL),
(101, 14, 'Create Article Group', 'article-group.create', 'No', 'No', NULL, NULL),
(102, 14, 'Store Article Group', 'article-group.store', 'Yes', 'No', NULL, NULL),
(103, 14, 'Article Group Details', 'article-group.Show', 'No', 'No', NULL, NULL),
(104, 14, 'Edit Article Group', 'article-group.edit', 'No', 'No', NULL, NULL),
(105, 14, 'Update Article Group', 'article-group.update', 'Yes', 'No', NULL, NULL),
(106, 14, 'Delete Article Group', 'article-group.destroy', 'No', 'No', NULL, NULL),
(107, 15, 'View Product/Category List', 'product-category.index', 'No', 'No', NULL, NULL),
(108, 15, 'Create Product/Category', 'product-category.create', 'No', 'No', NULL, NULL),
(109, 15, 'Store Product/Category', 'product-category.store', 'Yes', 'No', NULL, NULL),
(110, 15, 'Product/Category Details', 'product-category.Show', 'No', 'No', NULL, NULL),
(111, 15, 'Edit Product/Category', 'product-category.edit', 'No', 'No', NULL, NULL),
(112, 15, 'Update Product/Category', 'product-category.update', 'Yes', 'No', NULL, NULL),
(113, 15, 'Delete Product/Category', 'product-category.destroy', 'No', 'No', NULL, NULL),
(114, 15, 'Sort Product/Category', 'product-category-sorting', 'No', 'No', NULL, NULL),
(115, 15, 'Product/Category Sort', 'sort-product-category', 'Yes', 'No', NULL, NULL),
(116, 16, 'View Tag List', 'tag.index', 'No', 'No', NULL, NULL),
(117, 16, 'Create Tag', 'tag.create', 'No', 'No', NULL, NULL),
(118, 16, 'Store Tag', 'tag.store', 'Yes', 'No', NULL, NULL),
(119, 16, 'Tag Details', 'tag.Show', 'No', 'No', NULL, NULL),
(120, 16, 'Edit Tag', 'tag.edit', 'No', 'No', NULL, NULL),
(121, 16, 'Update Tag', 'tag.update', 'Yes', 'No', NULL, NULL),
(122, 16, 'Delete Tag', 'tag.destroy', 'No', 'No', NULL, NULL),
(123, 17, 'View FAQ List', 'faq.index', 'No', 'No', NULL, NULL),
(124, 17, 'Create FAQ', 'faq.create', 'No', 'No', NULL, NULL),
(125, 17, 'Store FAQ', 'faq.store', 'Yes', 'No', NULL, NULL),
(126, 17, 'FAQ Details', 'faq.Show', 'No', 'No', NULL, NULL),
(127, 17, 'Edit FAQ', 'faq.edit', 'No', 'No', NULL, NULL),
(128, 17, 'Update FAQ', 'faq.update', 'Yes', 'No', NULL, NULL),
(129, 17, 'Delete FAQ', 'faq.destroy', 'No', 'No', NULL, NULL),
(130, 18, 'View Page List', 'pages.index', 'No', 'No', NULL, NULL),
(131, 18, 'Create Page', 'pages.create', 'No', 'No', NULL, NULL),
(132, 18, 'Store Page', 'pages.store', 'Yes', 'No', NULL, NULL),
(133, 18, 'Page Details', 'pages.Show', 'No', 'No', NULL, NULL),
(134, 18, 'Edit Page', 'pages.edit', 'No', 'No', NULL, NULL),
(135, 18, 'Update Page', 'pages.update', 'Yes', 'No', NULL, NULL),
(136, 18, 'Delete Page', 'pages.destroy', 'No', 'No', NULL, NULL),
(137, 19, 'View Role List', 'role.index', 'No', 'No', NULL, NULL),
(138, 19, 'Create Role', 'role.create', 'No', 'No', NULL, NULL),
(139, 19, 'Store Role', 'role.store', 'Yes', 'No', NULL, NULL),
(140, 19, 'Role Details', 'role.Show', 'No', 'No', NULL, NULL),
(141, 19, 'Edit Role', 'role.edit', 'No', 'No', NULL, NULL),
(142, 19, 'Update Role', 'role.update', 'Yes', 'No', NULL, NULL),
(143, 19, 'Delete Role', 'role.destroy', 'No', 'No', NULL, NULL),
(144, 20, 'View Agent List', 'agent.index', 'No', 'No', NULL, NULL),
(145, 20, 'Create Agent', 'agent.create', 'No', 'No', NULL, NULL),
(146, 20, 'Store Agent', 'agent.store', 'Yes', 'No', NULL, NULL),
(147, 20, 'Agent Details', 'agent.Show', 'No', 'No', NULL, NULL),
(148, 20, 'Edit Agent', 'agent.edit', 'No', 'No', NULL, NULL),
(149, 20, 'Update Agent', 'agent.update', 'Yes', 'No', NULL, NULL),
(150, 20, 'Delete Agent', 'agent.destroy', 'No', 'No', NULL, NULL),
(151, 21, 'View Attendance List', 'attendance.index', 'No', 'No', NULL, NULL),
(152, 21, 'Create Attendance', 'attendance.create', 'No', 'No', NULL, NULL),
(153, 21, 'Store Attendance', 'attendance.store', 'Yes', 'No', NULL, NULL),
(154, 21, 'Attendance Details', 'attendance.Show', 'No', 'No', NULL, NULL),
(155, 21, 'Edit Attendance', 'attendance.edit', 'No', 'No', NULL, NULL),
(156, 21, 'Update Attendance', 'attendance.update', 'Yes', 'No', NULL, NULL),
(157, 21, 'Delete Attendance', 'attendance.destroy', 'No', 'No', NULL, NULL),
(158, 21, 'Check-In/Check-Out', 'check-in-out', 'No', 'No', NULL, NULL),
(159, 21, 'Checkin Attendance', 'in-attendance', 'No', 'Yes', NULL, NULL),
(160, 21, 'Checkout Attendance', 'out-attendance', 'No', 'Yes', NULL, NULL),
(161, 22, 'View Vacation List', 'vacations.index', 'No', 'No', NULL, NULL),
(162, 22, 'Create Vacation', 'vacations.create', 'No', 'No', NULL, NULL),
(163, 22, 'Store Vacation', 'vacations.store', 'Yes', 'No', NULL, NULL),
(164, 22, 'Vacation Details', 'vacations.Show', 'No', 'No', NULL, NULL),
(165, 22, 'Edit Vacation', 'vacations.edit', 'No', 'No', NULL, NULL),
(166, 22, 'Update Vacation', 'vacations.update', 'Yes', 'No', NULL, NULL),
(167, 22, 'Delete Vacation', 'vacations.destroy', 'No', 'No', NULL, NULL),
(168, 22, 'View Holiday List', 'holiday-setting.index', 'No', 'No', NULL, NULL),
(169, 22, 'Create Holiday', 'holiday-setting.create', 'No', 'No', NULL, NULL),
(170, 22, 'Store Holiday', 'holiday-setting.store', 'Yes', 'No', NULL, NULL),
(171, 22, 'Holiday Details', 'holiday-setting.Show', 'No', 'No', NULL, NULL),
(172, 22, 'Edit Holiday', 'holiday-setting.edit', 'No', 'No', NULL, NULL),
(173, 22, 'Update Holiday', 'holiday-setting.update', 'Yes', 'No', NULL, NULL),
(174, 22, 'Delete Holiday', 'holiday-setting.destroy', 'No', 'No', NULL, NULL),
(175, 23, 'Site Setting', 'site-setting', 'No', 'No', NULL, NULL),
(176, 23, 'Update Site Setting', 'update-site-setting', 'Yes', 'No', NULL, NULL),
(177, 23, 'Social Login Setting', 'social-login-setting', 'No', 'No', NULL, NULL),
(178, 23, 'Update Social Login Setting', 'update-social-login-setting', 'Yes', 'No', NULL, NULL),
(179, 23, 'View Custom Field List', 'custom-fields.index', 'No', 'No', NULL, NULL),
(180, 23, 'Create Custom Field', 'custom-fields.create', 'No', 'No', NULL, NULL),
(181, 23, 'Store Custom Field', 'custom-fields.store', 'Yes', 'No', NULL, NULL),
(182, 23, 'Custom Field Details', 'custom-fields.Show', 'No', 'No', NULL, NULL),
(183, 23, 'Edit Custom Field', 'custom-fields.edit', 'No', 'No', NULL, NULL),
(184, 23, 'Update Custom Field', 'custom-fields.update', 'Yes', 'No', NULL, NULL),
(185, 23, 'Delete Custom Field', 'custom-fields.destroy', 'No', 'No', NULL, NULL),
(186, 23, 'Ticket Setting', 'ticket-setting', 'No', 'No', NULL, NULL),
(187, 23, 'Update Ticket Setting', 'update-ticket-setting', 'Yes', 'No', NULL, NULL),
(188, 23, 'Chat Setting', 'chat-setting', 'No', 'No', NULL, NULL),
(189, 23, 'Update Chat Setting', 'update-chat-setting', 'Yes', 'No', NULL, NULL),
(190, 23, 'Chat Sequence Setting', 'chat-sequence-setting', 'No', 'No', NULL, NULL),
(191, 23, 'Sort agent chat sequence', 'sort-agent-chat-sequence', 'Yes', 'No', NULL, NULL),
(192, 23, 'Update chat sequence setting', 'update-chat-sequence-setting', 'Yes', 'No', NULL, NULL),
(193, 23, 'Update chat agent', 'update-chat-agent', 'Yes', 'No', NULL, NULL),
(194, 23, 'View Department List', 'departments.index', 'No', 'No', NULL, NULL),
(195, 23, 'Create Department', 'departments.create', 'No', 'No', NULL, NULL),
(196, 23, 'Store Department', 'departments.store', 'Yes', 'No', NULL, NULL),
(197, 23, 'Department Details', 'departments.Show', 'No', 'No', NULL, NULL),
(198, 23, 'Edit Department', 'departments.edit', 'No', 'No', NULL, NULL),
(199, 23, 'Update Department', 'departments.update', 'Yes', 'No', NULL, NULL),
(200, 23, 'Delete Department', 'departments.destroy', 'No', 'No', NULL, NULL),
(201, 23, 'Integration Setting', 'integration-setting', 'No', 'No', NULL, NULL),
(202, 23, 'Update Integration Setting', 'update-integration-setting', 'Yes', 'No', NULL, NULL),
(203, 23, 'Mail Setting', 'mail-setting', 'No', 'No', NULL, NULL),
(204, 23, 'Update Mail Setting', 'update-mail-setting', 'Yes', 'No', NULL, NULL),
(205, 23, 'Mail Template Setting', 'mail-templates', 'No', 'No', NULL, NULL),
(206, 23, 'Edit Mail Template', 'mail-templates-edit', 'No', 'No', NULL, NULL),
(207, 23, 'Update Mail Template', 'mail-template-update', 'Yes', 'No', NULL, NULL),
(208, 23, 'Notification Setting', 'notification-setting', 'No', 'No', NULL, NULL),
(209, 23, 'Update Notification Setting', 'update-notification-setting', 'Yes', 'No', NULL, NULL),
(210, 23, 'Payment Gateway Setting', 'payment-gateway-setting', 'No', 'No', NULL, NULL),
(211, 23, 'Update Payment Gateway Setting', 'update-payment-gateway-setting', 'Yes', 'No', NULL, NULL),
(212, 23, 'GDPR Setting', 'gdpr-setting', 'No', 'No', NULL, NULL),
(213, 23, 'Update GDPR Setting', 'update-gdpr-setting', 'Yes', 'No', NULL, NULL),
(214, 4, 'Open Chat', 'open-chat', 'No', 'Yes', NULL, NULL),
(215, 23, 'About Us Setting', 'about-us-setting', 'No', 'No', NULL, NULL),
(216, 23, 'Update About Us Setting', 'update-about-us-setting', 'Yes', 'No', NULL, NULL),
(217, 23, 'Our Services Setting', 'our-services-setting', 'No', 'No', NULL, NULL),
(218, 23, 'Update Our Services Setting', 'update-our-services-setting', 'Yes', 'No', NULL, NULL),
(219, 14, 'Article Group Sorting', 'article-group-sorting', 'No', 'No', NULL, NULL),
(220, 14, 'Sort Article Group', 'sort-article-group', 'Yes', 'No', NULL, NULL),
(221, 23, 'AI Setting', 'ai-setting', 'No', 'No', NULL, NULL),
(222, 23, 'Auto Reply List', 'ai_replies.index', 'No', 'No', NULL, NULL),
(223, 23, 'Create AI Auto Reply', 'ai_replies.create', 'No', 'No', NULL, NULL),
(224, 23, 'Store AI Auto Reply', 'ai_replies.store', 'Yes', 'No', NULL, NULL),
(225, 23, 'Edit AI Auto Reply', 'ai_replies.edit', 'No', 'No', NULL, NULL),
(226, 23, 'Update AI Auto Reply', 'ai_replies.update', 'Yes', 'No', NULL, NULL),
(227, 23, 'Delete AI Auto Reply', 'ai_replies.destroy', 'No', 'No', NULL, NULL),
(228, 24, 'View Testimonial List', 'testimonial.index', 'No', 'No', NULL, NULL),
(229, 24, 'Create Testimonial', 'testimonial.create', 'No', 'No', NULL, NULL),
(230, 24, 'Store Testimonial', 'testimonial.store', 'Yes', 'No', NULL, NULL),
(231, 24, 'Testimonial Details', 'testimonial.Show', 'No', 'No', NULL, NULL),
(232, 24, 'Edit Testimonial', 'testimonial.edit', 'No', 'No', NULL, NULL),
(233, 24, 'Update Testimonial', 'testimonial.update', 'Yes', 'No', NULL, NULL),
(234, 24, 'Delete Testimonial', 'testimonial.destroy', 'No', 'No', NULL, NULL);

CREATE TABLE `tbl_notices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `notice` text DEFAULT NULL,
  `start_date` varchar(191) DEFAULT NULL,
  `end_date` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `slug` varchar(191) NOT NULL,
  `page_content` longtext DEFAULT NULL,
  `tag_ids` text DEFAULT NULL,
  `tag_titles` text DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(7) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_payment_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `paypal_active` varchar(191) NOT NULL DEFAULT 'Active' COMMENT 'Active,Inactive',
  `paypal_client_id` varchar(191) DEFAULT NULL,
  `paypal_client_secret` varchar(191) DEFAULT NULL,
  `paypal_app_id` varchar(191) DEFAULT NULL,
  `paypal_active_mode` varchar(191) NOT NULL DEFAULT 'sanbox' COMMENT 'sanbox,live',
  `stripe_active` varchar(191) NOT NULL DEFAULT 'Active' COMMENT 'Active,Inactive',
  `stripe_key` varchar(191) DEFAULT NULL,
  `stripe_secret` varchar(191) DEFAULT NULL,
  `stripe_active_mode` varchar(191) NOT NULL DEFAULT 'sanbox' COMMENT 'sanbox,live',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tbl_payment_settings` (`id`, `paypal_active`, `paypal_client_id`, `paypal_client_secret`, `paypal_app_id`, `paypal_active_mode`, `stripe_active`, `stripe_key`, `stripe_secret`, `stripe_active_mode`, `created_at`, `updated_at`) VALUES
(1, 'Active', 'xxxxxx', 'xxxxxx', NULL, 'sandbox', 'Active', 'xxxxxx', 'xxxxxx', 'sandbox', '2023-02-14 17:31:05', '2024-03-06 19:43:11');

CREATE TABLE `tbl_product_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `product_code` varchar(10) DEFAULT NULL,
  `slug` varchar(191) DEFAULT NULL,
  `tag_titles` text DEFAULT NULL,
  `envato_product_code` varchar(100) DEFAULT NULL,
  `photo_thumb` varchar(100) DEFAULT NULL,
  `verification` tinyint(4) DEFAULT NULL COMMENT '0=>None,1=>Envato,2=>Woocommerce,3=>Shopify,4=>Easy Digital Downloads,5=>Themely Marketplace',
  `status` tinyint(4) DEFAULT NULL,
  `short_description` mediumtext DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `first_chat_agent_id` int(11) DEFAULT NULL,
  `sort_id` int(11) NOT NULL DEFAULT 1,
  `type` enum('single','multiple') NOT NULL DEFAULT 'multiple',
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(7) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_recurring_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` int(11) NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `product_cat_ids` varchar(191) DEFAULT NULL,
  `start_date` varchar(191) NOT NULL,
  `end_date` varchar(191) NOT NULL,
  `payment_period_in_days` int(11) NOT NULL DEFAULT 0,
  `amount` double(8,2) NOT NULL DEFAULT 0.00,
  `description` varchar(191) DEFAULT NULL,
  `contract_attachment` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_recurring_payment_dates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `recurring_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `recurring_payment_date` varchar(191) NOT NULL,
  `payment_method` varchar(191) DEFAULT NULL,
  `payment_amount` double(8,2) NOT NULL,
  `currency` varchar(191) NOT NULL DEFAULT 'USD',
  `transaction_id` varchar(191) DEFAULT NULL,
  `payment_status` varchar(191) DEFAULT NULL COMMENT 'Paid,Unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_role_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `activity_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `tbl_single_chat_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `file` varchar(191) DEFAULT NULL,
  `seen_status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `skype` varchar(200) DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  `g_map_url` varchar(400) DEFAULT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `footer_text` varchar(255) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `footer` varchar(300) DEFAULT NULL,
  `banner_text` varchar(200) DEFAULT NULL,
  `banner_slogan` varchar(200) DEFAULT NULL,
  `banner_img` varchar(100) DEFAULT NULL,
  `date_format` varchar(20) DEFAULT NULL,
  `timezone` varchar(20) DEFAULT NULL,
  `language` varchar(20) DEFAULT NULL,
  `website_url` varchar(100) DEFAULT NULL,
  `facebook_url` varchar(100) DEFAULT NULL,
  `linked_in_url` varchar(100) DEFAULT NULL,
  `twitter_url` varchar(100) DEFAULT NULL,
  `dribble_url` varchar(100) DEFAULT NULL,
  `instagram_url` varchar(100) DEFAULT NULL,
  `pinterest_url` varchar(100) DEFAULT NULL,
  `support_policy` longtext DEFAULT NULL,
  `browser_notification` varchar(191) NOT NULL DEFAULT 'No',
  `theme_type` enum('single','multiple') NOT NULL DEFAULT 'multiple',
  `is_captcha` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(7) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tbl_site_settings` (`id`, `company_name`, `title`, `email`, `phone`, `skype`, `address`, `g_map_url`, `logo`, `footer_text`, `icon`, `footer`, `banner_text`, `banner_slogan`, `banner_img`, `date_format`, `timezone`, `language`, `website_url`, `facebook_url`, `linked_in_url`, `twitter_url`, `dribble_url`, `instagram_url`, `pinterest_url`, `support_policy`, `browser_notification`, `theme_type`, `is_captcha`, `created_by`, `updated_by`, `created_at`, `updated_at`, `del_status`) VALUES
(1, 'Door Soft', 'Quick Rabbit - AI Powered Support Ticketing with Knowledgebase and Live Chat', 'info@doorsoft.co', '+8801812391633', 'nazmul.hosan24', 'House No: 5, Road No: 4, Nikunja 2, Khilkhet, Dhaka.', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3649.6835052673628!2d90.41590137605985!3d23.829850985720164!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c65e93000db3%3A0x53377a56daa4e74e!2sDoor%20Soft!5e0!3m2!1sen!2sbd!4v1685683657329!5m2!1sen!2sbd', '1716010131quick_rabbit_final_logo_siz.png', 'Quick Rabbit - Support Ticketing, Knowledgebase, Live Chat and CRM', '1715599125.ico', 'Copyright © 2023 All rights reserved by Door Soft', 'We Are Ready to <span>Help And Support</span> You.', 'We’re here for you, search for articles to go your thing done!', '-16915744701689573906banner.png', 'd/m/Y', 'Asia/Dhaka', 'en', 'https://doorsoft.co', 'https://www.facebook.com/doorsoft.co', NULL, 'https://twitter.com/soft_door', 'https://www.pinterest.com/', 'https://www.linkedin.com/', NULL, '<h2 data-sider-select-id=\"f8b8402d-d7ae-4042-a066-56798248ee42\">Introduction</h2>\r\n\r\n<p>Welcome to our AI-Based Support Ticketing System. This policy outlines the procedures, standards, and expectations for using our support system to ensure efficient, effective, and timely assistance for all users. Our goal is to provide high-quality support that leverages artificial intelligence to resolve issues promptly and accurately.</p>\r\n\r\n<h2>Scope</h2>\r\n\r\n<p>This policy applies to all users of our AI-Based Support Ticketing System, including internal staff, customers, and partners. It covers the submission, handling, resolution, and feedback processes of support tickets.</p>\r\n\r\n<h2>Support Hours</h2>\r\n\r\n<p>Our AI support system operates 24/7, offering round-the-clock assistance. Human support agents are available to handle escalated tickets during the following hours:</p>\r\n\r\n<ul>\r\n	<li>Sunday to Thrusday: 10:00 AM - 6:00 PM (Local Time)</li>\r\n</ul>\r\n\r\n<h2>Submitting a Ticket</h2>\r\n\r\n<ol>\r\n	<li><strong>Accessing the System</strong>: Users can submit a ticket through our online portal, mobile app, or via email.</li>\r\n	<li><strong>Ticket Information</strong>: Provide detailed information about the issue, including:\r\n	<ul>\r\n		<li>Description of the problem</li>\r\n		<li>Steps to reproduce the issue</li>\r\n		<li>Screenshots or error messages (if applicable)</li>\r\n		<li>Contact information</li>\r\n	</ul>\r\n	</li>\r\n	<li><strong>Categorization</strong>: Select the appropriate category and priority level for the issue. Categories include but are not limited to:\r\n	<ul>\r\n		<li>Technical Issues</li>\r\n		<li>Account and Billing</li>\r\n		<li>Feature Requests</li>\r\n		<li>General Inquiries</li>\r\n	</ul>\r\n	</li>\r\n</ol>\r\n\r\n<h2>Ticket Handling Process</h2>\r\n\r\n<ol>\r\n	<li><strong>Acknowledgment</strong>: Upon submission, the system will automatically acknowledge receipt of the ticket and provide a unique ticket ID for tracking.</li>\r\n	<li><strong>Initial Response</strong>: The AI system will analyze the ticket and attempt to provide an immediate solution or workaround. This may include:\r\n	<ul>\r\n		<li>Automated troubleshooting steps</li>\r\n		<li>Knowledge base articles</li>\r\n		<li>FAQ responses</li>\r\n	</ul>\r\n	</li>\r\n	<li><strong>Escalation</strong>: If the AI system cannot resolve the issue, the ticket will be escalated to a human support agent for further investigation.</li>\r\n	<li><strong>Assignment</strong>: Human agents will review and assign the ticket to the appropriate team based on expertise and priority.</li>\r\n	<li><strong>Resolution</strong>: The assigned agent will work on resolving the ticket, keeping the user informed of progress through regular updates.</li>\r\n	<li><strong>Closure</strong>: Once the issue is resolved, the ticket will be closed. Users will receive a summary of the resolution and an option to provide feedback.</li>\r\n</ol>\r\n\r\n<h2>Response and Resolution Times</h2>\r\n\r\n<ul>\r\n	<li><strong>Low Priority</strong>: Initial response within 4 hours, resolution within 72 hours</li>\r\n	<li><strong>Medium Priority</strong>: Initial response within 2 hours, resolution within 48 hours</li>\r\n	<li><strong>High Priority</strong>: Initial response within 1 hour, resolution within 24 hours</li>\r\n	<li><strong>Critical Priority</strong>: Immediate response, resolution as soon as possible</li>\r\n</ul>\r\n\r\n<h2>User Responsibilities</h2>\r\n\r\n<ul>\r\n	<li><strong>Accurate Information</strong>: Provide complete and accurate information when submitting a ticket.</li>\r\n	<li><strong>Collaboration</strong>: Cooperate with support agents by providing additional information or performing troubleshooting steps as requested.</li>\r\n	<li><strong>Feedback</strong>: Offer feedback on the support experience to help us improve our services.</li>\r\n</ul>\r\n\r\n<h2>Data Privacy and Security</h2>\r\n\r\n<p>We are committed to protecting your privacy and ensuring the security of your data. All information submitted through our support system is handled in accordance with our Privacy Policy and relevant data protection regulations.</p>\r\n\r\n<h2>Monitoring and Continuous Improvement</h2>\r\n\r\n<p>We continuously monitor the performance of our AI-based support system and make improvements based on user feedback and technological advancements. Regular audits and reviews are conducted to ensure compliance with this policy and to enhance support quality.</p>\r\n\r\n<h2>Contact Information</h2>\r\n\r\n<p>For any questions or concerns regarding this policy or our support system, please contact our support team at:</p>\r\n\r\n<ul>\r\n	<li>Email: <a href=\"mailto:info@doorsoft.co\" rel=\"noreferrer\" target=\"_new\">info@d</a><a href=\"mailto:info@doorsoft.co\">oorsoft.co</a></li>\r\n	<li>Phone: <a data-sider-select-id=\"7d326958-647a-4b63-a061-44cb9076a6d0\" href=\"tel:+8801812391633\">&nbsp;+8801812391633</a></li>\r\n	<li>Online Portal: https://quick-rabbit.doorsoft-demo.com/</li>\r\n</ul>\r\n\r\n<h2>Conclusion</h2>\r\n\r\n<p>Our AI-Based Support Ticketing System is designed to provide efficient and effective support. By following this policy, we aim to deliver a high standard of service to all users. Thank you for using our support system.</p>', 'Yes', 'multiple', 1, NULL, 1, NULL, '2025-01-02 09:25:46', 'Live');

CREATE TABLE `tbl_social_login_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `redirect_base_url` tinytext DEFAULT NULL,
  `google_login` varchar(191) NOT NULL DEFAULT 'Active' COMMENT 'Active,Inactive',
  `google_client_id` tinytext DEFAULT NULL,
  `google_client_secret` tinytext DEFAULT NULL,
  `github_login` varchar(191) NOT NULL DEFAULT 'Active' COMMENT 'Active,Inactive',
  `github_client_id` tinytext DEFAULT NULL,
  `github_client_secret` tinytext DEFAULT NULL,
  `linkedin_login` varchar(191) NOT NULL DEFAULT 'Active' COMMENT 'Active,Inactive',
  `linkedin_client_id` tinytext DEFAULT NULL,
  `linkedin_client_secret` tinytext DEFAULT NULL,
  `envato_login` varchar(191) NOT NULL DEFAULT 'Active' COMMENT 'Active,Inactive',
  `envato_client_id` tinytext DEFAULT NULL,
  `envato_client_secret` tinytext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tbl_social_login_settings` (`id`, `redirect_base_url`, `google_login`, `google_client_id`, `google_client_secret`, `github_login`, `github_client_id`, `github_client_secret`, `linkedin_login`, `linkedin_client_id`, `linkedin_client_secret`, `envato_login`, `envato_client_id`, `envato_client_secret`, `created_at`, `updated_at`) VALUES
(1, 'https://quick-rabbit.doorsoft-demo.com', 'Active', 'xxxxxx', 'xxxxxx', 'Active', 'xxxxxx', 'xxxxxx', 'Inactive', 'linkedin_client_id', 'linkedin_client_secret', 'Active', 'xxxxxx', 'xxxxxx', '2023-02-15 21:57:31', '2024-05-21 10:06:40');

CREATE TABLE `tbl_subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(7) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_title` varchar(191) NOT NULL,
  `work_date` varchar(191) DEFAULT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `assigned_person` int(11) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `file` varchar(191) DEFAULT NULL,
  `status` varchar(191) NOT NULL DEFAULT 'Pending' COMMENT 'Pending,In-progress,Done',
  `done_date` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(7) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_testimonials` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `review` mediumtext NOT NULL,
  `rating` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `del_status` enum('Live','Deleted') NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_no` varchar(9) DEFAULT NULL,
  `product_category_id` smallint(6) DEFAULT NULL,
  `customer_id` smallint(6) DEFAULT NULL,
  `department_id` int(11) NOT NULL DEFAULT 0,
  `assign_to_ids` varchar(150) DEFAULT NULL,
  `envato_u_name` varchar(100) DEFAULT NULL,
  `envato_p_code` varchar(100) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `priority` tinyint(4) DEFAULT NULL COMMENT '1=>High,2=>Medium,3=>Low',
  `ticket_content` longtext DEFAULT NULL,
  `custom_field_data` longtext DEFAULT NULL,
  `custom_field_type` longtext DEFAULT NULL,
  `custom_field_label` longtext DEFAULT NULL,
  `custom_field_option` longtext DEFAULT NULL,
  `custom_field_required` longtext DEFAULT NULL,
  `attachment` longtext DEFAULT NULL,
  `uploaded_file_titles` longtext DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL COMMENT '1=>open,2=>closed,3=>Re-open',
  `closing_date` datetime DEFAULT NULL,
  `duration` time DEFAULT NULL,
  `flag_status` tinyint(4) DEFAULT NULL,
  `archived_status` tinyint(4) DEFAULT NULL,
  `converted_to_article` tinyint(4) DEFAULT NULL,
  `need_action` tinyint(4) DEFAULT NULL,
  `ticket_cc` longtext DEFAULT NULL,
  `paid_support` varchar(191) NOT NULL DEFAULT 'No',
  `amount` double(8,2) NOT NULL DEFAULT 0.00,
  `payment_status` varchar(191) NOT NULL DEFAULT 'Unpaid' COMMENT 'Paid,Unpaid',
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_comment_at` varchar(191) DEFAULT NULL,
  `is_menual_assist` int(11) NOT NULL DEFAULT 0,
  `is_ai_replay_generate` int(11) NOT NULL DEFAULT 0,
  `del_status` varchar(7) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_ticket_comment_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `file_title` varchar(191) NOT NULL,
  `file_path` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_ticket_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `file_title` varchar(191) NOT NULL,
  `file_path` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_ticket_notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` smallint(6) DEFAULT NULL,
  `ticket_note` longtext DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(7) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_ticket_reply_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `ticket_comment` longtext DEFAULT NULL,
  `ticket_attachment` longtext DEFAULT NULL,
  `ticket_close` tinyint(4) DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `is_customer` int(11) DEFAULT 2,
  `is_ai_replied` int(11) DEFAULT 0,
  `updated_by` smallint(6) DEFAULT NULL,
  `is_helpful` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(7) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_ticket_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `allow_s_ticket` varchar(5) DEFAULT NULL,
  `closed_ticket_rating` varchar(191) NOT NULL DEFAULT 'on',
  `auto_email_reply` varchar(5) NOT NULL DEFAULT 'off',
  `default_sign` varchar(100) DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tbl_ticket_settings` (`id`, `allow_s_ticket`, `closed_ticket_rating`, `auto_email_reply`, `default_sign`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'off', 'on', 'off', 'Regards,\r\nDoor Soft Support Team', 1, 1, '2023-01-24 12:16:23', '2024-05-21 14:36:03');

CREATE TABLE `tbl_time_zone` (
  `id` int(11) NOT NULL,
  `country_code` varchar(2) DEFAULT NULL,
  `zone_name` varchar(35) DEFAULT NULL,
  `del_status` varchar(10) DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_general_ci;

INSERT INTO `tbl_time_zone` (`id`, `country_code`, `zone_name`, `del_status`) VALUES
(1, 'AD', 'Europe/Andorra', 'Live'),
(2, 'AE', 'Asia/Dubai', 'Live'),
(3, 'AF', 'Asia/Kabul', 'Live'),
(4, 'AG', 'America/Antigua', 'Live'),
(5, 'AI', 'America/Anguilla', 'Live'),
(6, 'AL', 'Europe/Tirane', 'Live'),
(7, 'AM', 'Asia/Yerevan', 'Live'),
(8, 'AO', 'Africa/Luanda', 'Live'),
(9, 'AQ', 'Antarctica/McMurdo', 'Live'),
(10, 'AQ', 'Antarctica/Casey', 'Live'),
(11, 'AQ', 'Antarctica/Davis', 'Live'),
(12, 'AQ', 'Antarctica/DumontDUrville', 'Live'),
(13, 'AQ', 'Antarctica/Mawson', 'Live'),
(14, 'AQ', 'Antarctica/Palmer', 'Live'),
(15, 'AQ', 'Antarctica/Rothera', 'Live'),
(16, 'AQ', 'Antarctica/Syowa', 'Live'),
(17, 'AQ', 'Antarctica/Troll', 'Live'),
(18, 'AQ', 'Antarctica/Vostok', 'Live'),
(19, 'AR', 'America/Argentina/Buenos_Aires', 'Live'),
(20, 'AR', 'America/Argentina/Cordoba', 'Live'),
(21, 'AR', 'America/Argentina/Salta', 'Live'),
(22, 'AR', 'America/Argentina/Jujuy', 'Live'),
(23, 'AR', 'America/Argentina/Tucuman', 'Live'),
(24, 'AR', 'America/Argentina/Catamarca', 'Live'),
(25, 'AR', 'America/Argentina/La_Rioja', 'Live'),
(26, 'AR', 'America/Argentina/San_Juan', 'Live'),
(27, 'AR', 'America/Argentina/Mendoza', 'Live'),
(28, 'AR', 'America/Argentina/San_Luis', 'Live'),
(29, 'AR', 'America/Argentina/Rio_Gallegos', 'Live'),
(30, 'AR', 'America/Argentina/Ushuaia', 'Live'),
(31, 'AS', 'Pacific/Pago_Pago', 'Live'),
(32, 'AT', 'Europe/Vienna', 'Live'),
(33, 'AU', 'Australia/Lord_Howe', 'Live'),
(34, 'AU', 'Antarctica/Macquarie', 'Live'),
(35, 'AU', 'Australia/Hobart', 'Live'),
(36, 'AU', 'Australia/Currie', 'Live'),
(37, 'AU', 'Australia/Melbourne', 'Live'),
(38, 'AU', 'Australia/Sydney', 'Live'),
(39, 'AU', 'Australia/Broken_Hill', 'Live'),
(40, 'AU', 'Australia/Brisbane', 'Live'),
(41, 'AU', 'Australia/Lindeman', 'Live'),
(42, 'AU', 'Australia/Adelaide', 'Live'),
(43, 'AU', 'Australia/Darwin', 'Live'),
(44, 'AU', 'Australia/Perth', 'Live'),
(45, 'AU', 'Australia/Eucla', 'Live'),
(46, 'AW', 'America/Aruba', 'Live'),
(47, 'AX', 'Europe/Mariehamn', 'Live'),
(48, 'AZ', 'Asia/Baku', 'Live'),
(49, 'BA', 'Europe/Sarajevo', 'Live'),
(50, 'BB', 'America/Barbados', 'Live'),
(51, 'BD', 'Asia/Dhaka', 'Live'),
(52, 'BE', 'Europe/Brussels', 'Live'),
(53, 'BF', 'Africa/Ouagadougou', 'Live'),
(54, 'BG', 'Europe/Sofia', 'Live'),
(55, 'BH', 'Asia/Bahrain', 'Live'),
(56, 'BI', 'Africa/Bujumbura', 'Live'),
(57, 'BJ', 'Africa/Porto-Novo', 'Live'),
(58, 'BL', 'America/St_Barthelemy', 'Live'),
(59, 'BM', 'Atlantic/Bermuda', 'Live'),
(60, 'BN', 'Asia/Brunei', 'Live'),
(61, 'BO', 'America/La_Paz', 'Live'),
(62, 'BQ', 'America/Kralendijk', 'Live'),
(63, 'BR', 'America/Noronha', 'Live'),
(64, 'BR', 'America/Belem', 'Live'),
(65, 'BR', 'America/Fortaleza', 'Live'),
(66, 'BR', 'America/Recife', 'Live'),
(67, 'BR', 'America/Araguaina', 'Live'),
(68, 'BR', 'America/Maceio', 'Live'),
(69, 'BR', 'America/Bahia', 'Live'),
(70, 'BR', 'America/Sao_Paulo', 'Live'),
(71, 'BR', 'America/Campo_Grande', 'Live'),
(72, 'BR', 'America/Cuiaba', 'Live'),
(73, 'BR', 'America/Santarem', 'Live'),
(74, 'BR', 'America/Porto_Velho', 'Live'),
(75, 'BR', 'America/Boa_Vista', 'Live'),
(76, 'BR', 'America/Manaus', 'Live'),
(77, 'BR', 'America/Eirunepe', 'Live'),
(78, 'BR', 'America/Rio_Branco', 'Live'),
(79, 'BS', 'America/Nassau', 'Live'),
(80, 'BT', 'Asia/Thimphu', 'Live'),
(81, 'BW', 'Africa/Gaborone', 'Live'),
(82, 'BY', 'Europe/Minsk', 'Live'),
(83, 'BZ', 'America/Belize', 'Live'),
(84, 'CA', 'America/St_Johns', 'Live'),
(85, 'CA', 'America/Halifax', 'Live'),
(86, 'CA', 'America/Glace_Bay', 'Live'),
(87, 'CA', 'America/Moncton', 'Live'),
(88, 'CA', 'America/Goose_Bay', 'Live'),
(89, 'CA', 'America/Blanc-Sablon', 'Live'),
(90, 'CA', 'America/Toronto', 'Live'),
(91, 'CA', 'America/Nipigon', 'Live'),
(92, 'CA', 'America/Thunder_Bay', 'Live'),
(93, 'CA', 'America/Iqaluit', 'Live'),
(94, 'CA', 'America/Pangnirtung', 'Live'),
(95, 'CA', 'America/Atikokan', 'Live'),
(96, 'CA', 'America/Winnipeg', 'Live'),
(97, 'CA', 'America/Rainy_River', 'Live'),
(98, 'CA', 'America/Resolute', 'Live'),
(99, 'CA', 'America/Rankin_Inlet', 'Live'),
(100, 'CA', 'America/Regina', 'Live'),
(101, 'CA', 'America/Swift_Current', 'Live'),
(102, 'CA', 'America/Edmonton', 'Live'),
(103, 'CA', 'America/Cambridge_Bay', 'Live'),
(104, 'CA', 'America/Yellowknife', 'Live'),
(105, 'CA', 'America/Inuvik', 'Live'),
(106, 'CA', 'America/Creston', 'Live'),
(107, 'CA', 'America/Dawson_Creek', 'Live'),
(108, 'CA', 'America/Fort_Nelson', 'Live'),
(109, 'CA', 'America/Vancouver', 'Live'),
(110, 'CA', 'America/Whitehorse', 'Live'),
(111, 'CA', 'America/Dawson', 'Live'),
(112, 'CC', 'Indian/Cocos', 'Live'),
(113, 'CD', 'Africa/Kinshasa', 'Live'),
(114, 'CD', 'Africa/Lubumbashi', 'Live'),
(115, 'CF', 'Africa/Bangui', 'Live'),
(116, 'CG', 'Africa/Brazzaville', 'Live'),
(117, 'CH', 'Europe/Zurich', 'Live'),
(118, 'CI', 'Africa/Abidjan', 'Live'),
(119, 'CK', 'Pacific/Rarotonga', 'Live'),
(120, 'CL', 'America/Santiago', 'Live'),
(121, 'CL', 'America/Punta_Arenas', 'Live'),
(122, 'CL', 'Pacific/Easter', 'Live'),
(123, 'CM', 'Africa/Douala', 'Live'),
(124, 'CN', 'Asia/Shanghai', 'Live'),
(125, 'CN', 'Asia/Urumqi', 'Live'),
(126, 'CO', 'America/Bogota', 'Live'),
(127, 'CR', 'America/Costa_Rica', 'Live'),
(128, 'CU', 'America/Havana', 'Live'),
(129, 'CV', 'Atlantic/Cape_Verde', 'Live'),
(130, 'CW', 'America/Curacao', 'Live'),
(131, 'CX', 'Indian/Christmas', 'Live'),
(132, 'CY', 'Asia/Nicosia', 'Live'),
(133, 'CY', 'Asia/Famagusta', 'Live'),
(134, 'CZ', 'Europe/Prague', 'Live'),
(135, 'DE', 'Europe/Berlin', 'Live'),
(136, 'DE', 'Europe/Busingen', 'Live'),
(137, 'DJ', 'Africa/Djibouti', 'Live'),
(138, 'DK', 'Europe/Copenhagen', 'Live'),
(139, 'DM', 'America/Dominica', 'Live'),
(140, 'DO', 'America/Santo_Domingo', 'Live'),
(141, 'DZ', 'Africa/Algiers', 'Live'),
(142, 'EC', 'America/Guayaquil', 'Live'),
(143, 'EC', 'Pacific/Galapagos', 'Live'),
(144, 'EE', 'Europe/Tallinn', 'Live'),
(145, 'EG', 'Africa/Cairo', 'Live'),
(146, 'EH', 'Africa/El_Aaiun', 'Live'),
(147, 'ER', 'Africa/Asmara', 'Live'),
(148, 'ES', 'Europe/Madrid', 'Live'),
(149, 'ES', 'Africa/Ceuta', 'Live'),
(150, 'ES', 'Atlantic/Canary', 'Live'),
(151, 'ET', 'Africa/Addis_Ababa', 'Live'),
(152, 'FI', 'Europe/Helsinki', 'Live'),
(153, 'FJ', 'Pacific/Fiji', 'Live'),
(154, 'FK', 'Atlantic/Stanley', 'Live'),
(155, 'FM', 'Pacific/Chuuk', 'Live'),
(156, 'FM', 'Pacific/Pohnpei', 'Live'),
(157, 'FM', 'Pacific/Kosrae', 'Live'),
(158, 'FO', 'Atlantic/Faroe', 'Live'),
(159, 'FR', 'Europe/Paris', 'Live'),
(160, 'GA', 'Africa/Libreville', 'Live'),
(161, 'GB', 'Europe/London', 'Live'),
(162, 'GD', 'America/Grenada', 'Live'),
(163, 'GE', 'Asia/Tbilisi', 'Live'),
(164, 'GF', 'America/Cayenne', 'Live'),
(165, 'GG', 'Europe/Guernsey', 'Live'),
(166, 'GH', 'Africa/Accra', 'Live'),
(167, 'GI', 'Europe/Gibraltar', 'Live'),
(168, 'GL', 'America/Godthab', 'Live'),
(169, 'GL', 'America/Danmarkshavn', 'Live'),
(170, 'GL', 'America/Scoresbysund', 'Live'),
(171, 'GL', 'America/Thule', 'Live'),
(172, 'GM', 'Africa/Banjul', 'Live'),
(173, 'GN', 'Africa/Conakry', 'Live'),
(174, 'GP', 'America/Guadeloupe', 'Live'),
(175, 'GQ', 'Africa/Malabo', 'Live'),
(176, 'GR', 'Europe/Athens', 'Live'),
(177, 'GS', 'Atlantic/South_Georgia', 'Live'),
(178, 'GT', 'America/Guatemala', 'Live'),
(179, 'GU', 'Pacific/Guam', 'Live'),
(180, 'GW', 'Africa/Bissau', 'Live'),
(181, 'GY', 'America/Guyana', 'Live'),
(182, 'HK', 'Asia/Hong_Kong', 'Live'),
(183, 'HN', 'America/Tegucigalpa', 'Live'),
(184, 'HR', 'Europe/Zagreb', 'Live'),
(185, 'HT', 'America/Port-au-Prince', 'Live'),
(186, 'HU', 'Europe/Budapest', 'Live'),
(187, 'ID', 'Asia/Jakarta', 'Live'),
(188, 'ID', 'Asia/Pontianak', 'Live'),
(189, 'ID', 'Asia/Makassar', 'Live'),
(190, 'ID', 'Asia/Jayapura', 'Live'),
(191, 'IE', 'Europe/Dublin', 'Live'),
(192, 'IL', 'Asia/Jerusalem', 'Live'),
(193, 'IM', 'Europe/Isle_of_Man', 'Live'),
(194, 'IN', 'Asia/Kolkata', 'Live'),
(195, 'IO', 'Indian/Chagos', 'Live'),
(196, 'IQ', 'Asia/Baghdad', 'Live'),
(197, 'IR', 'Asia/Tehran', 'Live'),
(198, 'IS', 'Atlantic/Reykjavik', 'Live'),
(199, 'IT', 'Europe/Rome', 'Live'),
(200, 'JE', 'Europe/Jersey', 'Live'),
(201, 'JM', 'America/Jamaica', 'Live'),
(202, 'JO', 'Asia/Amman', 'Live'),
(203, 'JP', 'Asia/Tokyo', 'Live'),
(204, 'KE', 'Africa/Nairobi', 'Live'),
(205, 'KG', 'Asia/Bishkek', 'Live'),
(206, 'KH', 'Asia/Phnom_Penh', 'Live'),
(207, 'KI', 'Pacific/Tarawa', 'Live'),
(208, 'KI', 'Pacific/Enderbury', 'Live'),
(209, 'KI', 'Pacific/Kiritimati', 'Live'),
(210, 'KM', 'Indian/Comoro', 'Live'),
(211, 'KN', 'America/St_Kitts', 'Live'),
(212, 'KP', 'Asia/Pyongyang', 'Live'),
(213, 'KR', 'Asia/Seoul', 'Live'),
(214, 'KW', 'Asia/Kuwait', 'Live'),
(215, 'KY', 'America/Cayman', 'Live'),
(216, 'KZ', 'Asia/Almaty', 'Live'),
(217, 'KZ', 'Asia/Qyzylorda', 'Live'),
(218, 'KZ', 'Asia/Aqtobe', 'Live'),
(219, 'KZ', 'Asia/Aqtau', 'Live'),
(220, 'KZ', 'Asia/Atyrau', 'Live'),
(221, 'KZ', 'Asia/Oral', 'Live'),
(222, 'LA', 'Asia/Vientiane', 'Live'),
(223, 'LB', 'Asia/Beirut', 'Live'),
(224, 'LC', 'America/St_Lucia', 'Live'),
(225, 'LI', 'Europe/Vaduz', 'Live'),
(226, 'LK', 'Asia/Colombo', 'Live'),
(227, 'LR', 'Africa/Monrovia', 'Live'),
(228, 'LS', 'Africa/Maseru', 'Live'),
(229, 'LT', 'Europe/Vilnius', 'Live'),
(230, 'LU', 'Europe/Luxembourg', 'Live'),
(231, 'LV', 'Europe/Riga', 'Live'),
(232, 'LY', 'Africa/Tripoli', 'Live'),
(233, 'MA', 'Africa/Casablanca', 'Live'),
(234, 'MC', 'Europe/Monaco', 'Live'),
(235, 'MD', 'Europe/Chisinau', 'Live'),
(236, 'ME', 'Europe/Podgorica', 'Live'),
(237, 'MF', 'America/Marigot', 'Live'),
(238, 'MG', 'Indian/Antananarivo', 'Live'),
(239, 'MH', 'Pacific/Majuro', 'Live'),
(240, 'MH', 'Pacific/Kwajalein', 'Live'),
(241, 'MK', 'Europe/Skopje', 'Live'),
(242, 'ML', 'Africa/Bamako', 'Live'),
(243, 'MM', 'Asia/Yangon', 'Live'),
(244, 'MN', 'Asia/Ulaanbaatar', 'Live'),
(245, 'MN', 'Asia/Hovd', 'Live'),
(246, 'MN', 'Asia/Choibalsan', 'Live'),
(247, 'MO', 'Asia/Macau', 'Live'),
(248, 'MP', 'Pacific/Saipan', 'Live'),
(249, 'MQ', 'America/Martinique', 'Live'),
(250, 'MR', 'Africa/Nouakchott', 'Live'),
(251, 'MS', 'America/Montserrat', 'Live'),
(252, 'MT', 'Europe/Malta', 'Live'),
(253, 'MU', 'Indian/Mauritius', 'Live'),
(254, 'MV', 'Indian/Maldives', 'Live'),
(255, 'MW', 'Africa/Blantyre', 'Live'),
(256, 'MX', 'America/Mexico_City', 'Live'),
(257, 'MX', 'America/Cancun', 'Live'),
(258, 'MX', 'America/Merida', 'Live'),
(259, 'MX', 'America/Monterrey', 'Live'),
(260, 'MX', 'America/Matamoros', 'Live'),
(261, 'MX', 'America/Mazatlan', 'Live'),
(262, 'MX', 'America/Chihuahua', 'Live'),
(263, 'MX', 'America/Ojinaga', 'Live'),
(264, 'MX', 'America/Hermosillo', 'Live'),
(265, 'MX', 'America/Tijuana', 'Live'),
(266, 'MX', 'America/Bahia_Banderas', 'Live'),
(267, 'MY', 'Asia/Kuala_Lumpur', 'Live'),
(268, 'MY', 'Asia/Kuching', 'Live'),
(269, 'MZ', 'Africa/Maputo', 'Live'),
(270, 'NA', 'Africa/Windhoek', 'Live'),
(271, 'NC', 'Pacific/Noumea', 'Live'),
(272, 'NE', 'Africa/Niamey', 'Live'),
(273, 'NF', 'Pacific/Norfolk', 'Live'),
(274, 'NG', 'Africa/Lagos', 'Live'),
(275, 'NI', 'America/Managua', 'Live'),
(276, 'NL', 'Europe/Amsterdam', 'Live'),
(277, 'NO', 'Europe/Oslo', 'Live'),
(278, 'NP', 'Asia/Kathmandu', 'Live'),
(279, 'NR', 'Pacific/Nauru', 'Live'),
(280, 'NU', 'Pacific/Niue', 'Live'),
(281, 'NZ', 'Pacific/Auckland', 'Live'),
(282, 'NZ', 'Pacific/Chatham', 'Live'),
(283, 'OM', 'Asia/Muscat', 'Live'),
(284, 'PA', 'America/Panama', 'Live'),
(285, 'PE', 'America/Lima', 'Live'),
(286, 'PF', 'Pacific/Tahiti', 'Live'),
(287, 'PF', 'Pacific/Marquesas', 'Live'),
(288, 'PF', 'Pacific/Gambier', 'Live'),
(289, 'PG', 'Pacific/Port_Moresby', 'Live'),
(290, 'PG', 'Pacific/Bougainville', 'Live'),
(291, 'PH', 'Asia/Manila', 'Live'),
(292, 'PK', 'Asia/Karachi', 'Live'),
(293, 'PL', 'Europe/Warsaw', 'Live'),
(294, 'PM', 'America/Miquelon', 'Live'),
(295, 'PN', 'Pacific/Pitcairn', 'Live'),
(296, 'PR', 'America/Puerto_Rico', 'Live'),
(297, 'PS', 'Asia/Gaza', 'Live'),
(298, 'PS', 'Asia/Hebron', 'Live'),
(299, 'PT', 'Europe/Lisbon', 'Live'),
(300, 'PT', 'Atlantic/Madeira', 'Live'),
(301, 'PT', 'Atlantic/Azores', 'Live'),
(302, 'PW', 'Pacific/Palau', 'Live'),
(303, 'PY', 'America/Asuncion', 'Live'),
(304, 'QA', 'Asia/Qatar', 'Live'),
(305, 'RE', 'Indian/Reunion', 'Live'),
(306, 'RO', 'Europe/Bucharest', 'Live'),
(307, 'RS', 'Europe/Belgrade', 'Live'),
(308, 'RU', 'Europe/Kaliningrad', 'Live'),
(309, 'RU', 'Europe/Moscow', 'Live'),
(310, 'RU', 'Europe/Simferopol', 'Live'),
(311, 'RU', 'Europe/Volgograd', 'Live'),
(312, 'RU', 'Europe/Kirov', 'Live'),
(313, 'RU', 'Europe/Astrakhan', 'Live'),
(314, 'RU', 'Europe/Saratov', 'Live'),
(315, 'RU', 'Europe/Ulyanovsk', 'Live'),
(316, 'RU', 'Europe/Samara', 'Live'),
(317, 'RU', 'Asia/Yekaterinburg', 'Live'),
(318, 'RU', 'Asia/Omsk', 'Live'),
(319, 'RU', 'Asia/Novosibirsk', 'Live'),
(320, 'RU', 'Asia/Barnaul', 'Live'),
(321, 'RU', 'Asia/Tomsk', 'Live'),
(322, 'RU', 'Asia/Novokuznetsk', 'Live'),
(323, 'RU', 'Asia/Krasnoyarsk', 'Live'),
(324, 'RU', 'Asia/Irkutsk', 'Live'),
(325, 'RU', 'Asia/Chita', 'Live'),
(326, 'RU', 'Asia/Yakutsk', 'Live'),
(327, 'RU', 'Asia/Khandyga', 'Live'),
(328, 'RU', 'Asia/Vladivostok', 'Live'),
(329, 'RU', 'Asia/Ust-Nera', 'Live'),
(330, 'RU', 'Asia/Magadan', 'Live'),
(331, 'RU', 'Asia/Sakhalin', 'Live'),
(332, 'RU', 'Asia/Srednekolymsk', 'Live'),
(333, 'RU', 'Asia/Kamchatka', 'Live'),
(334, 'RU', 'Asia/Anadyr', 'Live'),
(335, 'RW', 'Africa/Kigali', 'Live'),
(336, 'SA', 'Asia/Riyadh', 'Live'),
(337, 'SB', 'Pacific/Guadalcanal', 'Live'),
(338, 'SC', 'Indian/Mahe', 'Live'),
(339, 'SD', 'Africa/Khartoum', 'Live'),
(340, 'SE', 'Europe/Stockholm', 'Live'),
(341, 'SG', 'Asia/Singapore', 'Live'),
(342, 'SH', 'Atlantic/St_Helena', 'Live'),
(343, 'SI', 'Europe/Ljubljana', 'Live'),
(344, 'SJ', 'Arctic/Longyearbyen', 'Live'),
(345, 'SK', 'Europe/Bratislava', 'Live'),
(346, 'SL', 'Africa/Freetown', 'Live'),
(347, 'SM', 'Europe/San_Marino', 'Live'),
(348, 'SN', 'Africa/Dakar', 'Live'),
(349, 'SO', 'Africa/Mogadishu', 'Live'),
(350, 'SR', 'America/Paramaribo', 'Live'),
(351, 'SS', 'Africa/Juba', 'Live'),
(352, 'ST', 'Africa/Sao_Tome', 'Live'),
(353, 'SV', 'America/El_Salvador', 'Live'),
(354, 'SX', 'America/Lower_Princes', 'Live'),
(355, 'SY', 'Asia/Damascus', 'Live'),
(356, 'SZ', 'Africa/Mbabane', 'Live'),
(357, 'TC', 'America/Grand_Turk', 'Live'),
(358, 'TD', 'Africa/Ndjamena', 'Live'),
(359, 'TF', 'Indian/Kerguelen', 'Live'),
(360, 'TG', 'Africa/Lome', 'Live'),
(361, 'TH', 'Asia/Bangkok', 'Live'),
(362, 'TJ', 'Asia/Dushanbe', 'Live'),
(363, 'TK', 'Pacific/Fakaofo', 'Live'),
(364, 'TL', 'Asia/Dili', 'Live'),
(365, 'TM', 'Asia/Ashgabat', 'Live'),
(366, 'TN', 'Africa/Tunis', 'Live'),
(367, 'TO', 'Pacific/Tongatapu', 'Live'),
(368, 'TR', 'Europe/Istanbul', 'Live'),
(369, 'TT', 'America/Port_of_Spain', 'Live'),
(370, 'TV', 'Pacific/Funafuti', 'Live'),
(371, 'TW', 'Asia/Taipei', 'Live'),
(372, 'TZ', 'Africa/Dar_es_Salaam', 'Live'),
(373, 'UA', 'Europe/Kiev', 'Live'),
(374, 'UA', 'Europe/Uzhgorod', 'Live'),
(375, 'UA', 'Europe/Zaporozhye', 'Live'),
(376, 'UG', 'Africa/Kampala', 'Live'),
(377, 'UM', 'Pacific/Midway', 'Live'),
(378, 'UM', 'Pacific/Wake', 'Live'),
(379, 'US', 'America/New_York', 'Live'),
(380, 'US', 'America/Detroit', 'Live'),
(381, 'US', 'America/Kentucky/Louisville', 'Live'),
(382, 'US', 'America/Kentucky/Monticello', 'Live'),
(383, 'US', 'America/Indiana/Indianapolis', 'Live'),
(384, 'US', 'America/Indiana/Vincennes', 'Live'),
(385, 'US', 'America/Indiana/Winamac', 'Live'),
(386, 'US', 'America/Indiana/Marengo', 'Live'),
(387, 'US', 'America/Indiana/Petersburg', 'Live'),
(388, 'US', 'America/Indiana/Vevay', 'Live'),
(389, 'US', 'America/Chicago', 'Live'),
(390, 'US', 'America/Indiana/Tell_City', 'Live'),
(391, 'US', 'America/Indiana/Knox', 'Live'),
(392, 'US', 'America/Menominee', 'Live'),
(393, 'US', 'America/North_Dakota/Center', 'Live'),
(394, 'US', 'America/North_Dakota/New_Salem', 'Live'),
(395, 'US', 'America/North_Dakota/Beulah', 'Live'),
(396, 'US', 'America/Denver', 'Live'),
(397, 'US', 'America/Boise', 'Live'),
(398, 'US', 'America/Phoenix', 'Live'),
(399, 'US', 'America/Los_Angeles', 'Live'),
(400, 'US', 'America/Anchorage', 'Live'),
(401, 'US', 'America/Juneau', 'Live'),
(402, 'US', 'America/Sitka', 'Live'),
(403, 'US', 'America/Metlakatla', 'Live'),
(404, 'US', 'America/Yakutat', 'Live'),
(405, 'US', 'America/Nome', 'Live'),
(406, 'US', 'America/Adak', 'Live'),
(407, 'US', 'Pacific/Honolulu', 'Live'),
(408, 'UY', 'America/Montevideo', 'Live'),
(409, 'UZ', 'Asia/Samarkand', 'Live'),
(410, 'UZ', 'Asia/Tashkent', 'Live'),
(411, 'VA', 'Europe/Vatican', 'Live'),
(412, 'VC', 'America/St_Vincent', 'Live'),
(413, 'VE', 'America/Caracas', 'Live'),
(414, 'VG', 'America/Tortola', 'Live'),
(415, 'VI', 'America/St_Thomas', 'Live'),
(416, 'VN', 'Asia/Ho_Chi_Minh', 'Live'),
(417, 'VU', 'Pacific/Efate', 'Live'),
(418, 'WF', 'Pacific/Wallis', 'Live'),
(419, 'WS', 'Pacific/Apia', 'Live'),
(420, 'YE', 'Asia/Aden', 'Live'),
(421, 'YT', 'Indian/Mayotte', 'Live'),
(422, 'ZA', 'Africa/Johannesburg', 'Live'),
(423, 'ZM', 'Africa/Lusaka', 'Live'),
(424, 'ZW', 'Africa/Harare', 'Live');

CREATE TABLE `tbl_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `payment_method` varchar(191) DEFAULT NULL,
  `payment_amount` double(8,2) NOT NULL,
  `currency` varchar(191) NOT NULL DEFAULT 'USD',
  `transaction_id` varchar(191) DEFAULT NULL,
  `transaction_time` varchar(191) DEFAULT NULL,
  `payment_status` varchar(191) DEFAULT NULL COMMENT 'Paid,Unpaid',
  `transaction_status` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `setting_id` int(11) NOT NULL DEFAULT 1,
  `registered_from` varchar(191) NOT NULL DEFAULT 'web',
  `role_id` tinyint(4) NOT NULL DEFAULT 2 COMMENT '1=>Admin,2=>Agent,3=>Customer',
  `type` varchar(10) NOT NULL DEFAULT 'Agent' COMMENT 'Admin,Agent,Customer',
  `first_name` varchar(191) NOT NULL,
  `last_name` varchar(191) NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `is_email_verified` tinyint(1) NOT NULL DEFAULT 0,
  `mobile` varchar(191) DEFAULT NULL,
  `permission_role` int(11) DEFAULT NULL,
  `product_cat_ids` varchar(150) DEFAULT NULL,
  `department_id` smallint(6) DEFAULT NULL,
  `signature` longtext DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `password` varchar(191) DEFAULT NULL,
  `plain_password` varchar(191) DEFAULT NULL,
  `need_change_password` tinyint(1) NOT NULL DEFAULT 0,
  `question` varchar(191) DEFAULT NULL,
  `answer` varchar(191) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `online_status` tinyint(4) NOT NULL DEFAULT 1,
  `last_logout_time` varchar(191) DEFAULT NULL,
  `browser_notification` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` longtext DEFAULT NULL,
  `language` varchar(191) NOT NULL DEFAULT 'en',
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(191) NOT NULL DEFAULT 'Live',
  `device_key` varchar(191) DEFAULT NULL,
  `browser_id` varchar(191) DEFAULT NULL,
  `chat_sound` tinyint(1) DEFAULT 1,
  `user_ip` varchar(191) DEFAULT NULL,
  `gdpr_setting` tinyint(1) NOT NULL DEFAULT 0,
  `auth_type` varchar(191) DEFAULT NULL,
  `facebook_id` varchar(191) DEFAULT NULL,
  `github_id` varchar(191) DEFAULT NULL,
  `linkedin_id` varchar(191) DEFAULT NULL,
  `google_id` varchar(191) DEFAULT NULL,
  `envato_id` varchar(191) DEFAULT NULL,
  `twitter_id` varchar(191) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `api_token` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tbl_users` (`id`, `setting_id`, `registered_from`, `role_id`, `type`, `first_name`, `last_name`, `email`, `is_email_verified`, `mobile`, `permission_role`, `product_cat_ids`, `department_id`, `signature`, `image`, `password`, `plain_password`, `need_change_password`, `question`, `answer`, `status`, `online_status`, `last_logout_time`, `browser_notification`, `remember_token`, `language`, `created_by`, `updated_by`, `created_at`, `updated_at`, `del_status`, `device_key`, `browser_id`, `chat_sound`, `user_ip`, `gdpr_setting`, `auth_type`, `facebook_id`, `github_id`, `linkedin_id`, `google_id`, `envato_id`, `twitter_id`, `deleted_at`, `api_token`) VALUES
(1, 1, 'web', 1, 'Admin', 'Support', 'Admin', 'admin@doorsoft.co', 0, '+8801812391633', NULL, NULL, NULL, NULL, '1716494171.png', '$2y$10$VTyCHCp9q2NIYS4z0gbg8uctPWKae1uwPBRaqV1g5NHkM0dJdlvE2', NULL, 0, 'What is the name of the town you were born?', 'rangpur', 1, 1, '2025-01-02 21:26:51', 0, 'EQwJFtYZJ1Vx4iLWP5F7R7BRYKmPxj7z0HoYuA2jRb2qodpYd8PkZpH5Jmkq', 'en', NULL, NULL, NULL, '2025-01-02 12:44:26', 'Live', 'dbLQpjNdxsyrGrfhJAiWct:APA91bF6J93sKoSM8LJQAY1eVg4CvI3iKbXwlZwn9I740ZOsbz-ILaEUBJB90XG7PuJbJgqGdBTibwjjnI18wlBj7ygFO49ke968ZbbTk2OyjqNtNrmRhDXh6VX7lo9ZPAkd86Yra_fG', '2814697936', 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '32|Aj3j0fCCtTZmqFr7myBUpv59PsKOEPbKSzNOx6EH'),
(2, 1, 'web', 2, 'Agent', 'James', 'William', 'agent@doorsoft.co', 1, '3152835255', 4, '1,2,6,8,10,15', 1, 'Mr Zakir\r\nDoor Soft', '1716497226.png', '$2y$10$kOJeZt9Y6gg1uRWgD9eBcuS6UqgLPwq8t1jJGVj.F4Pz3wnhja24G', 'cb2a16', 0, 'What was the first company that you worked for?', 'doorsoft', 1, 0, '2024-11-18 18:19:42', 0, '4EErA4kTaeLwDdF0vopPPircmQ5fF8oLu8atuQ1fa27yFBa8OdDFbjtHjuQv', 'en', 1, NULL, '2023-04-03 14:33:27', '2024-11-18 06:19:42', 'Live', 'dbLQpjNdxsyrGrfhJAiWct:APA91bF6J93sKoSM8LJQAY1eVg4CvI3iKbXwlZwn9I740ZOsbz-ILaEUBJB90XG7PuJbJgqGdBTibwjjnI18wlBj7ygFO49ke968ZbbTk2OyjqNtNrmRhDXh6VX7lo9ZPAkd86Yra_fG', '0624535186', 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 1, 'web', 3, 'Customer', 'AI', 'Replying', 'ai@doorsoft.co', 1, '', 4, '', 1, NULL, NULL, '', NULL, 0, '', '', 1, 0, '', 0, '', 'en', NULL, NULL, '2023-04-04 16:05:14', '2024-05-16 08:53:58', 'Live', '', '', 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

CREATE TABLE `tbl_users_verify` (
  `user_id` int(11) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_vacations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `auto_response` varchar(3) DEFAULT NULL,
  `mail_subject` varchar(400) DEFAULT NULL,
  `mail_body` longtext DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `del_status` varchar(7) NOT NULL DEFAULT 'Live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE `article_comments` ADD PRIMARY KEY (`id`);
ALTER TABLE `migrations` ADD PRIMARY KEY (`id`);
ALTER TABLE `password_resets` ADD KEY `password_resets_email_index` (`email`);
ALTER TABLE `personal_access_tokens` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`), ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);
ALTER TABLE `tbl_activity_logs` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_admin_notifications` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_agent_notifications` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_ai_settings` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_articles` ADD PRIMARY KEY (`id`), ADD KEY `home_page_indexing` (`product_category_id`,`article_group_id`,`internal_external`,`status`,`del_status`);
ALTER TABLE `tbl_articles` ADD FULLTEXT KEY `idx_your_column` (`title`);
ALTER TABLE `tbl_article_groups` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_attendances` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_auto_replies` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_auto_replies` ADD FULLTEXT KEY `idx_your_column` (`question`);
ALTER TABLE `tbl_blogs` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_blogs` ADD FULLTEXT KEY `idx_your_column` (`title`);
ALTER TABLE `tbl_blog_categories` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_blog_comments` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_canned_messages` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_chat_groups` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_chat_group_members` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_chat_settings` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_configuration_settings` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_customer_notes` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_customer_notifications` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_custom_fields` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_departments` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_faqs` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_faqs` ADD FULLTEXT KEY `idx_your_column` (`question`);
ALTER TABLE `tbl_feedbacks` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_forums` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_forum_comments` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_forum_likes` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_group_chat_messages` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_g_d_p_r_settings` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_holiday_settings` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_integration_settings` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_mail_settings` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_mail_templates` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_medias` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_menus` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_menu_activities` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_notices` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_pages` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_pages` ADD FULLTEXT KEY `idx_your_column` (`title`);
ALTER TABLE `tbl_payment_settings` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_product_categories` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_recurring_payments` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_recurring_payment_dates` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_roles` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_role_permissions` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_single_chat_messages` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_site_settings` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_social_login_settings` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_subscribers` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_tags` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_tasks` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_testimonials` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_tickets` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_tickets` ADD FULLTEXT KEY `idx_your_column` (`title`);
ALTER TABLE `tbl_ticket_comment_files` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_ticket_files` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_ticket_notes` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_ticket_reply_comments` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_ticket_reply_comments` ADD FULLTEXT KEY `idx_your_column` (`ticket_comment`);
ALTER TABLE `tbl_ticket_settings` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_transactions` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_users` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `tbl_users_email_unique` (`email`);
ALTER TABLE `tbl_vacations` ADD PRIMARY KEY (`id`);
ALTER TABLE `article_comments`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `migrations`  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `personal_access_tokens`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_activity_logs`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_admin_notifications`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_agent_notifications`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_ai_settings`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `tbl_articles`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_article_groups`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_attendances`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_auto_replies`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_blogs`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_blog_categories`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_blog_comments`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_canned_messages`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_chat_groups`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_chat_group_members`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_chat_settings`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE `tbl_configuration_settings`  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `tbl_customer_notes`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_customer_notifications`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_custom_fields`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_departments`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_faqs`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_feedbacks`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_forums`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_forum_comments`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_forum_likes`  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_group_chat_messages`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_g_d_p_r_settings`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_holiday_settings`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_integration_settings`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `tbl_mail_settings`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE `tbl_mail_templates`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
ALTER TABLE `tbl_medias`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_menus`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
ALTER TABLE `tbl_menu_activities`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=235;
ALTER TABLE `tbl_notices`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_pages`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_payment_settings`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `tbl_product_categories`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_recurring_payments`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_recurring_payment_dates`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_roles`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
ALTER TABLE `tbl_role_permissions`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5024;
ALTER TABLE `tbl_single_chat_messages`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_site_settings`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `tbl_social_login_settings`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `tbl_subscribers`  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_tags`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_tasks`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_testimonials`  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_tickets`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_ticket_comment_files`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_ticket_files`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_ticket_notes`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_ticket_reply_comments`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_ticket_settings`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `tbl_transactions`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `tbl_users`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;
ALTER TABLE `tbl_vacations`  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT; 
