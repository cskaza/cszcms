DROP TABLE IF EXISTS `footer_social`;
CREATE TABLE IF NOT EXISTS `footer_social` (
  `footer_social_id` int(11) AUTO_INCREMENT,
  `social_name` varchar(255),
  `social_url` varchar(255),
  `active` int(11),
  `timestamp_update` datetime,
  PRIMARY KEY (`footer_social_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

INSERT INTO `footer_social` (`footer_social_id`, `social_name`, `social_url`, `active`, `timestamp_update`) VALUES
(1, 'twitter', '', 0, '2016-05-06 15:50:59'),
(2, 'facebook', '', 0, '2016-05-06 15:50:59'),
(3, 'linkedin', '', 0, '2016-05-06 15:50:59'),
(4, 'youtube', '', 0, '2016-05-06 15:50:59'),
(5, 'google', '', 0, '2016-05-06 15:50:59'),
(6, 'pinterest', '', 0, '2016-05-06 15:50:59'),
(7, 'foursquare', '', 0, '2016-05-06 15:50:59'),
(8, 'myspace', '', 0, '2016-05-06 15:50:59'),
(9, 'soundcloud', '', 0, '2016-05-06 15:50:59'),
(10, 'spotify', '', 0, '2016-05-06 15:50:59'),
(11, 'lastfm', '', 0, '2016-05-06 15:50:59'),
(12, 'vimeo', '', 0, '2016-05-06 15:50:59'),
(13, 'dailymotion', '', 0, '2016-05-06 15:50:59'),
(14, 'vine', '', 0, '2016-05-06 15:50:59'),
(15, 'flickr', '', 0, '2016-05-06 15:50:59'),
(16, 'instagram', '', 0, '2016-05-06 15:50:59'),
(17, 'tumblr', '', 0, '2016-05-06 15:50:59'),
(18, 'reddit', '', 0, '2016-05-06 15:50:59'),
(19, 'envato', '', 0, '2016-05-06 15:50:59'),
(20, 'github', '', 0, '2016-05-06 15:50:59'),
(21, 'tripadvisor', '', 0, '2016-05-06 15:50:59'),
(22, 'stackoverflow', '', 0, '2016-05-06 15:50:59'),
(23, 'persona', '', 0, '2016-05-06 15:50:59'),
(24, 'odnoklassniki', '', 0, '2016-05-06 15:50:59'),
(25, 'vk', '', 0, '2016-05-06 15:50:59'),
(26, 'gitlab', '', 0, '2016-05-06 15:50:59');

DROP TABLE IF EXISTS `form_contactus_en`;
CREATE TABLE IF NOT EXISTS `form_contactus_en` (
  `form_contactus_en_id` int(11) AUTO_INCREMENT,
  `name` varchar(255),
  `email` varchar(255),
  `contact_type` varchar(255),
  `message` text,
  `ip_address` varchar(255),
  `timestamp_create` datetime,
  PRIMARY KEY (`form_contactus_en_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `form_field`;
CREATE TABLE IF NOT EXISTS `form_field` (
  `form_field_id` int(11) AUTO_INCREMENT,
  `form_main_id` int(11),
  `field_type` varchar(100),
  `field_name` varchar(255),
  `field_id` varchar(255),
  `field_class` varchar(255),
  `field_placeholder` varchar(255),
  `field_value` varchar(255),
  `field_label` varchar(255),
  `sel_option_val` text,
  `field_required` int(11),
  `field_div_class` varchar(255),
  `arrange` int(11),
  `timestamp_create` datetime,
  `timestamp_update` datetime,
  PRIMARY KEY (`form_field_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

INSERT INTO `form_field` (`form_field_id`, `form_main_id`, `field_type`, `field_name`, `field_id`, `field_class`, `field_placeholder`, `field_value`, `field_label`, `sel_option_val`, `field_required`, `arrange`, `timestamp_create`, `timestamp_update`) VALUES
(1, 1, 'text', 'name', 'name', 'form-control', '', '', 'Name', '', 1, 1, '2016-05-02 19:15:50', '2016-05-02 19:15:50'),
(2, 1, 'email', 'email', 'email', 'form-control', '', '', 'Email Address', '', 1, 2, '2016-05-02 19:15:50', '2016-05-02 19:15:50'),
(3, 1, 'selectbox', 'contact_type', 'contact_type', 'form-control', '-- Choose Type --', '', 'Contact Type', 'question=>Question, contact us=>Contact Us, service=>Service', 1, 3, '2016-05-02 19:15:50', '2016-05-02 19:15:50'),
(4, 1, 'textarea', 'message', 'message', 'form-control', '', '', 'Message', '', 1, 4, '2016-05-02 19:15:50', '2016-05-02 19:15:50'),
(5, 1, 'submit', 'submit', 'submit', 'btn btn-primary', '', 'Send now', '', '', 0, 5, '2016-05-02 19:15:50', '2016-05-02 19:15:50'),
(6, 1, 'reset', 'reset', 'reset', 'btn btn-default', '', 'Reset', '', '', 0, 6, '2016-05-02 19:15:50', '2016-05-02 19:15:50');

DROP TABLE IF EXISTS `form_main`;
CREATE TABLE IF NOT EXISTS `form_main` (
  `form_main_id` int(11) AUTO_INCREMENT,
  `form_name` varchar(255),
  `form_enctype` varchar(255),
  `form_method` varchar(255),
  `success_txt` varchar(255),
  `captchaerror_txt` varchar(255),
  `error_txt` varchar(255),
  `sendmail` int(11),
  `email` varchar(255),
  `subject` varchar(255),
  `send_to_visitor` int(11),
  `email_field_id` int(11),
  `visitor_subject` varchar(255),
  `visitor_body` text,
  `active` int(11),
  `captcha` int(11),
  `save_to_db` int(11),
  `dont_repeat_field` varchar(255),
  `repeat_txt` varchar(255),
  `timestamp_create` datetime,
  `timestamp_update` datetime,
  PRIMARY KEY (`form_main_id`),
  KEY `form_name` (`form_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `form_main` (`form_main_id`, `form_name`, `form_enctype`, `form_method`, `success_txt`, `captchaerror_txt`, `error_txt`, `sendmail`, `email`, `subject`, `send_to_visitor`, `email_field_id`, `visitor_subject`, `visitor_body`, `active`, `captcha`, `save_to_db`, `dont_repeat_field`, `repeat_txt`, `timestamp_create`, `timestamp_update`) VALUES
(1, 'contactus_en', '', 'post', 'Successfully!', 'The Security Check was not input correctly. Please try again.', 'Error! Please try again.', 1, '', 'Contact us from the CSZ-CMS website', 0, 0, '', '', 1, 1, 1, '', 'Your data is duplicated in the system.', NOW(), NOW());

DROP TABLE IF EXISTS `lang_iso`;
CREATE TABLE IF NOT EXISTS `lang_iso` (
  `lang_iso_id` int(11) AUTO_INCREMENT,
  `lang_name` varchar(255),
  `lang_iso` varchar(10),
  `country` varchar(255),
  `country_iso` varchar(10),
  `active` int(2),
  `arrange` int(11),
  `timestamp_create` datetime,
  `timestamp_update` datetime,
  PRIMARY KEY (`lang_iso_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Language ISO' AUTO_INCREMENT=2 ;

INSERT INTO `lang_iso` (`lang_iso_id`, `lang_name`, `lang_iso`, `country`, `country_iso`, `active`, `arrange`, `timestamp_create`, `timestamp_update`) VALUES
(1, 'English', 'en', 'United Kingdom', 'gb', 1, 1, '2016-03-29 15:16:23', '2016-03-31 15:28:58');

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `pages_id` int(11) AUTO_INCREMENT,
  `page_name` varchar(255),
  `page_url` varchar(255),
  `lang_iso` varchar(10),
  `page_title` varchar(255),
  `page_keywords` varchar(255),
  `page_desc` text,
  `content` text,
  `more_metatag` text,
  `custom_css` text,
  `custom_js` text,
  `user_groups_idS` text,
  `active` int(11),
  `timestamp_create` datetime,
  `timestamp_update` datetime,
  PRIMARY KEY (`pages_id`),
  KEY `page_url` (`page_url`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

INSERT INTO `pages` (`pages_id`, `page_name`, `page_url`, `lang_iso`, `page_title`, `page_keywords`, `page_desc`, `content`, `custom_css`, `custom_js`, `active`, `timestamp_create`, `timestamp_update`) VALUES
(1, 'Home', 'home', 'en', 'CSZ Home', 'CMS, Contact Management System, HTML, CSS, JS, JavaScript, framework, bootstrap, web development, thai, english, homepage', 'CSKAZA Template for Bootstrap with CSZ-CMS', '<header>[?]{=carousel:1}[?]</header><!-- Start Jumbotron -->\r\n<div class="jumbotron">\r\n<div class="container">\r\n<h1>Hello, world!</h1>\r\n<p>This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>\r\n<p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more »</a></p>\r\n</div>\r\n</div>\r\n<div class="container">\r\n<div class="row">\r\n<div class="col-md-4">\r\n<h2>Heading</h2>\r\n<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>\r\n<p><a class="btn btn-default" href="#" role="button">View details »</a></p>\r\n</div>\r\n<div class="col-md-4">\r\n<h2>Heading</h2>\r\n<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>\r\n<p><a class="btn btn-default" href="#" role="button">View details »</a></p>\r\n</div>\r\n<div class="col-md-4">\r\n<h2>Heading</h2>\r\n<p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>\r\n<p><a class="btn btn-default" href="#" role="button">View details »</a></p>\r\n</div>\r\n</div>\r\n</div>\r\n', '', '', 1, '2016-03-08 10:12:56', '2016-05-09 11:00:51'),
(2, 'Abouts Us', 'abouts-us', 'en', 'CSZ-CMS About Us', 'CMS, Contact Management System, HTML, CSS, JS, JavaScript, framework, bootstrap, web development, thai, aboutus', 'CSKAZA Template for Bootstrap with CSZ-CMS', '<div class="jumbotron">\r\n<div class="container">\r\n<h1>About Us!</h1>\r\n<p>CSKAZA Template for Bootstrap with CSZ-CMS. CSZ-CMS build by CSKAZA.</p>\r\n<p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more »</a></p>\r\n</div>\r\n</div>\r\n<div class="container">\r\n<div class="row">\r\n<div class="col-md-6">\r\n<div class="panel panel-default">\r\n<div class="panel-heading">Panel heading</div>\r\n<div class="panel-body">\r\n<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>\r\n</div>\r\n</div>\r\n</div>\r\n<div class="col-md-6">\r\n<div class="panel panel-default">\r\n<div class="panel-heading">Panel heading</div>\r\n<div class="panel-body">\r\n<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n<div class="container"></div>\r\n<p></p>', '', '', 1, '2016-04-11 15:17:18', '2016-05-01 15:16:13'),
(3, 'Contact Us', 'contact-us', 'en', 'CSZ-CMS Contact us', 'CMS, Contact Management System, HTML, CSS, JS, JavaScript, framework, bootstrap, web development, thai, contact us', 'CSKAZA Template for Bootstrap with CSZ-CMS', '<div class="jumbotron">\r\n<div class="container">\r\n<h1>Contact us!</h1>\r\n<p>If you want to contact us please use this form below. Or send the email to <a href="mailto:info@cszcms.com">info[at]cszcms.com</a></p>\r\n</div>\r\n</div>\r\n<div class="container"></div>\r\n<div class="container">\r\n<div class="row">\r\n<div class="col-md-6">\r\n<h2>Google Map</h2>\r\n<p><iframe width="100%" height="315" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.168282092751!2d98.37285931425068!3d7.877454308128998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0:0x0!2zN8KwNTInMzguOCJOIDk4wrAyMiczMC4yIkU!5e0!3m2!1sen!2sth!4v1462104596003" frameborder="0" allowfullscreen="allowfullscreen"></iframe></p>\r\n</div>\r\n<div class="col-md-6">\r\n<h2>Contact Form</h2>\r\n<p>If you have any question please send this from.</p>\r\n<p>[?]{=forms:contactus_en}[?]</p>\r\n</div>\r\n</div>\r\n</div>\r\n<p></p>\r\n<p></p>', '', '', 1, '2016-04-30 16:57:16', '2016-05-12 17:59:41');

DROP TABLE IF EXISTS `page_menu`;
CREATE TABLE IF NOT EXISTS `page_menu` (
  `page_menu_id` int(11) AUTO_INCREMENT,
  `menu_name` varchar(255),
  `lang_iso` varchar(10),
  `pages_id` int(11),
  `other_link` varchar(512),
  `plugin_menu` varchar(255),
  `drop_menu` int(11),
  `drop_page_menu_id` int(11),
  `position` int(11),
  `new_windows` int(11),
  `active` int(11),
  `arrange` int(11),
  `timestamp_create` datetime,
  `timestamp_update` datetime,
  PRIMARY KEY (`page_menu_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

INSERT INTO `page_menu` (`page_menu_id`, `menu_name`, `lang_iso`, `pages_id`, `other_link`, `plugin_menu`, `drop_menu`, `drop_page_menu_id`, `position`, `new_windows`, `active`, `arrange`, `timestamp_create`, `timestamp_update`) VALUES
(1, 'Home', 'en', 1, '', '', 0, 0, 0, 0, 1, 1, '2016-03-25 13:00:08', '2016-04-30 16:58:07'),
(2, 'Abouts Us', 'en', 2, '', '', 0, 0, 0, 0, 1, 2, '2016-04-11 15:01:03', '2016-04-30 16:58:07'),
(3, 'Contact Us', 'en', 3, '', '', 0, 0, 0, 0, 1, 3, '2016-04-30 16:58:02', '2016-04-30 16:58:07'),
(4, 'Drop Menu', 'en', 0, '', '', 1, 0, 0, 0, 1, 4, '2016-03-27 15:54:15', '2016-04-30 16:58:07'),
(5, 'CSZ CMS Website', 'en', 0, 'https://www.cszcms.com', '', 0, 4, 0, 1, 1, 1, '2016-03-28 15:22:12', '2016-04-30 16:58:07');

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `settings_id` int(11) AUTO_INCREMENT,
  `site_name` varchar(255),
  `site_logo` varchar(255),
  `og_image` varchar(255),
  `fbapp_id` varchar(255),
  `site_footer` text,
  `default_email` varchar(255),
  `keywords` text,
  `themes_config` varchar(255),
  `admin_lang` varchar(255),
  `additional_js` text,
  `additional_metatag` text,
  `googlecapt_active` int(11),
  `googlecapt_sitekey` varchar(255),
  `googlecapt_secretkey` varchar(255),
  `pagecache_time` int(3),
  `email_protocal` varchar(20),
  `smtp_host` varchar(255),
  `smtp_user` varchar(255),
  `smtp_pass` varchar(255),
  `smtp_port` varchar(5),
  `sendmail_path` varchar(255),
  `member_confirm_enable` int(11),
  `member_close_regist` int(11),
  `gmaps_key` varchar(255),
  `gmaps_lat` varchar(100),
  `gmaps_lng` varchar(100),
  `ga_client_id` varchar(255),
  `ga_view_id` varchar(255),
  `gsearch_active` int(11),
  `gsearch_cxid` varchar(255),
  `maintenance_active` int(11),
  `html_optimize_disable` int(11),
  `adobe_cc_apikey` varchar(255),
  `facebook_page_id` varchar(255),
  `assets_static_active` int(11),
  `assets_static_domain` varchar(255),
  `fb_messenger` int(11),
  `email_logs` int(11),
  `title_setting` int(11),
  `cookieinfo_active` INT(11),
  `cookieinfo_bg` VARCHAR(7),
  `cookieinfo_fg` VARCHAR(7),
  `cookieinfo_link` VARCHAR(7),
  `cookieinfo_msg` VARCHAR(255),
  `cookieinfo_linkmsg` VARCHAR(100),
  `cookieinfo_moreinfo` VARCHAR(255),
  `cookieinfo_txtalign` VARCHAR(30),
  `cookieinfo_close` VARCHAR(100),
  `timestamp_update` datetime,
  PRIMARY KEY (`settings_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `settings` (`settings_id`, `site_name`, `site_logo`, `og_image`, `fbapp_id`, `site_footer`, `default_email`, `keywords`, `themes_config`, `admin_lang`, `additional_js`, `additional_metatag`, `googlecapt_active`, `googlecapt_sitekey`, `googlecapt_secretkey`, `pagecache_time`, `email_protocal`, `smtp_host`, `smtp_user`, `smtp_pass`, `smtp_port`, `sendmail_path`, `member_confirm_enable`, `member_close_regist`, `gmaps_key`, `gmaps_lat`, `gmaps_lng`, `ga_client_id`, `ga_view_id`, `gsearch_active`, `gsearch_cxid`, `maintenance_active`, `html_optimize_disable`, `email_logs`, `title_setting`, `timestamp_update`) VALUES
(1, 'CSZ CMS Starter', '', '', '', '&copy; %Y% CSZ CMS Starter', '', 'CMS, Contact Management System, HTML, CSS, JS, JavaScript, framework, bootstrap, web development, thai, english', 'cszdefault', 'english', '', '', 0, '', '', 0, '', '', '', '', '', '', 0, 0, '', '', '', '', '', 0, '', 0, 1, 1, 2, NOW());
UPDATE `settings` SET `cookieinfo_active`=0,`cookieinfo_bg`='#645862',`cookieinfo_fg`='#FFFFFF',`cookieinfo_link`='#F1D600',`cookieinfo_msg`='This website uses cookies to improve your user experience. By continuing to browse our site you accepted and agreed on our ',`cookieinfo_linkmsg`='Privacy Policy and terms.',`cookieinfo_moreinfo`='https://www.cszcms.com/LICENSE.md',`cookieinfo_txtalign`='left',`cookieinfo_close`='Got it!',`timestamp_update`= NOW() WHERE `settings_id` = 1;

DROP TABLE IF EXISTS `upload_file`;
CREATE TABLE IF NOT EXISTS `upload_file` (
  `upload_file_id` int(11) AUTO_INCREMENT,
  `year` varchar(10),
  `file_upload` varchar(255),
  `remark` TEXT,
  `timestamp_create` datetime,
  `timestamp_update` datetime,
  PRIMARY KEY (`upload_file_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `user_admin`;
CREATE TABLE IF NOT EXISTS `user_admin` (
  `user_admin_id` int(11) AUTO_INCREMENT,
  `name` varchar(255),
  `email` varchar(255),
  `password` varchar(255),
  `user_type` varchar(255),
  `first_name` varchar(255),
  `last_name` varchar(255),
  `birthday` date,
  `gender` varchar(10),
  `address` text,
  `phone` varchar(100),
  `picture` varchar(255),
  `active` int(11),
  `session_id` varchar(255),
  `md5_hash` varchar(255),
  `md5_lasttime` datetime,
  `pm_sendmail` int(11),
  `timestamp_login` datetime,
  `pass_change` int(11),
  `timestamp_create` datetime,
  `timestamp_update` datetime,
  PRIMARY KEY (`user_admin_id`),
  KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `link_statistic`;
CREATE TABLE IF NOT EXISTS `link_statistic` (
  `link_statistic_id` int(11) AUTO_INCREMENT,
  `link` varchar(255),
  `ip_address` varchar(255),
  `timestamp_create` datetime,
  PRIMARY KEY (`link_statistic_id`),
  KEY `link` (`link`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `general_label`;
CREATE TABLE IF NOT EXISTS `general_label` (
  `general_label_id` int(11) AUTO_INCREMENT,
  `name` varchar(255),
  `remark` text,
  `lang_en` text,
  `timestamp_update` datetime,
  PRIMARY KEY (`general_label_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=78 ;

INSERT INTO `general_label` (`general_label_id`, `name`, `remark`, `lang_en`, `timestamp_update`) VALUES
(1, 'login_heading', 'For member login Header text', 'Member Login', '2016-07-04 11:43:18'),
(2, 'login_incorrect', 'For member login incorrect', 'Email address/Password is incorrect', '2016-07-04 11:44:09'),
(3, 'captcha_wrong', 'For member login when wrong captcha', 'The Security Check was not input correctly. Please try again.', '2016-07-04 11:44:39'),
(4, 'login_email', 'For email address label', 'Email Address', '2016-06-23 23:34:45'),
(5, 'login_password', 'For password label', 'Your Password', '2016-06-23 23:35:22'),
(6, 'login_signin', 'For member login button', 'Log in', '2016-06-23 23:35:53'),
(7, 'login_forgetpwd', 'For member forget password button', 'Forgot Password', '2016-06-23 23:37:02'),
(8, 'login_register', 'For member register label', 'Register', '2016-06-24 16:41:07'),
(9, 'member_firstname', 'For member firstname label', 'First Name', '2016-06-24 16:58:09'),
(10, 'member_lastname', 'For member lastname label', 'Last Name', '2016-06-24 16:58:09'),
(11, 'member_address', 'For member address label', 'Address', '2016-06-24 16:58:09'),
(12, 'confirm_password', 'For confirm password label', 'Confirm Password', '2016-06-24 16:58:09'),
(13, 'member_forgot_complete', 'For forget password is successfully', 'Successfully! Your password has been reset', '2016-06-24 16:58:09'),
(14, 'member_reset_btn', 'For reset button', 'Reset', '2016-06-24 17:48:32'),
(15, 'member_forget_chkmail', 'For reset text email to inbox', 'Please check your email inbox and click the link to continue the process.', '2016-06-24 17:48:32'),
(16, 'email_reset_subject', 'For email subject when member forget password', 'Reset your member password', '2016-06-26 15:43:39'),
(17, 'email_reset_message', 'For email message when member forget password', 'Please click the link within 30 minutes to reset your password.', '2016-06-26 15:43:39'),
(18, 'email_dear', 'For email header', 'Dear ', '2016-06-26 15:43:39'),
(19, 'email_footer', 'For email footer', 'Regards,', '2016-06-26 15:43:39'),
(20, 'email_check', 'For email does not exist text', 'This email address does not exist', '2016-06-26 15:47:01'),
(21, 'btn_cancel', 'For cancel button', 'Cancel', '2016-06-26 15:52:28'),
(22, 'btn_back', 'For back button', 'Back', '2016-06-26 15:53:59'),
(23, 'email_already', 'For email has already', 'This email address has already', '2016-06-26 21:31:20'),
(24, 'email_confirm_subject', 'For email confirm subject text', 'Confirm your member register', '2016-06-27 18:00:10'),
(25, 'email_confirm_message', 'For email confirm message', 'Please click the link within 30 minutes to confirm your member.', '2016-06-28 10:28:20'),
(26, 'log_out', 'For log out text', 'Log out', '2016-07-01 16:25:24'),
(27, 'backend_system', 'For back-end system text', 'Admin System', '2016-07-01 16:25:24'),
(28, 'edit_profile', 'For edit profile text', 'Edit Profile', '2016-07-01 16:25:24'),
(29, 'member_dashboard_text', 'For member dashboard text', 'Welcome to Member Dashboard!', '2016-07-01 16:25:24'),
(30, 'your_profile', 'For your profile text', 'Your Profile', '2016-07-01 16:29:30'),
(31, 'member_menu', 'For member menu text', 'Member Menu', '2016-07-01 16:37:37'),
(32, 'display_name', 'For display name text', 'Display Name', '2016-07-01 16:45:41'),
(33, 'email_address', 'For email address text', 'Email Address', '2016-07-01 16:45:41'),
(34, 'user_type', 'For permission type text', 'Permission Type', '2016-07-01 16:45:41'),
(35, 'first_name', 'For first name text', 'First Name', '2016-07-01 16:45:41'),
(36, 'last_name', 'For last name text', 'Last Name', '2016-07-01 16:45:41'),
(37, 'birthday', 'For birthday text', 'Birth Day', '2016-07-01 16:45:41'),
(38, 'gender', 'For gender text', 'Gender', '2016-07-01 16:45:41'),
(39, 'phone', 'For phone text', 'Phone', '2016-07-01 16:45:41'),
(40, 'address', 'For address text', 'Address', '2016-07-01 16:45:41'),
(41, 'new_password', 'For new password text', 'New Password', '2016-07-02 18:01:57'),
(42, 'change_password', 'For change password text', 'Change Password', '2016-07-02 18:04:49'),
(43, 'picture', 'For picture text', 'Picture', '2016-07-02 18:18:58'),
(44, 'save_btn', 'For save button text', 'Save', '2016-07-02 18:35:11'),
(45, 'cancel_btn', 'For cancel button text', 'Cancel', '2016-07-02 18:35:11'),
(46, 'article_index_header', 'For article index page', 'List of Article', '2016-07-12 17:08:16'),
(47, 'article_category_menu', 'For category of article text', 'Category', '2016-07-12 17:23:40'),
(48, 'article_readmore_text', 'For read more button of article text', 'Read More', '2016-07-12 17:23:40'),
(49, 'article_not_found', 'For article not found text', 'Article not found!', '2016-07-12 17:33:20'),
(50, 'article_cat_not_found', 'For category of article not found text', 'Category not found!', '2016-07-12 17:54:29'),
(51, 'article_postdate', 'For date time of article text', 'Posted date', '2016-07-13 13:56:02'),
(52, 'article_postby', 'For post by text', 'Posted by', '2016-07-13 13:56:02'),
(53, 'gallery_header', 'For gallery header text', 'Gallery', '2016-07-15 13:47:17'),
(54, 'gallery_albumlist', 'For album list text', 'List of Album', '2016-07-15 13:47:17'),
(55, 'total_txt', 'For total text', 'Total:', '2016-07-15 15:24:11'),
(56, 'records_txt', 'For records text', 'Records', '2016-07-15 15:23:54'),
(57, 'gallery_not_found', 'for gallery not found text', 'Gallery not found!', '2016-07-15 15:33:35'),
(58, 'picture_not_found', 'For picture not found text', 'Picture not found!', '2016-07-15 15:35:40'),
(59, 'gellery_view_btn', 'For gallery view button', 'View Gallery', '2016-07-15 15:41:19'),
(60, 'article_archive', 'For article archive text', 'Archive', '2016-07-21 10:39:19'),
(61, 'article_updatedate', 'For article updatetime text', 'Updated date', '2016-07-21 10:39:19'),
(62, 'article_search_txt', 'For article search text', 'Article Search', '2016-09-26 10:53:09'),
(63, 'pm_txt', 'For private message header text', 'Private Message', '2017-02-27 10:53:09'),
(64, 'pm_to_txt', 'For private message (To) text', 'To', '2017-02-27 10:53:09'),
(65, 'pm_from_txt', 'For private message (From) text', 'From', '2017-02-27 10:53:09'),
(66, 'pm_subject_txt', 'For private message subject text', 'Subject', '2017-02-27 10:53:09'),
(67, 'pm_msg_txt', 'For private message text', 'Message', '2017-02-27 10:53:09'),
(68, 'pm_send_txt', 'For private message send text', 'Send', '2017-02-27 10:53:09'),
(69, 'pm_delete_txt', 'For private message delete text', 'Delete', '2017-02-27 10:53:09'),
(70, 'pm_inbox_txt', 'For private message inbox text', 'Inbox', '2017-02-27 10:53:09'),
(71, 'pm_newmsg_txt', 'For private message new message text', 'New Message', '2017-02-27 10:53:09'),
(72, 'users_list_txt', 'For users list text', 'Users List', '2017-02-28 10:53:09'),
(73, 'pm_datetime_txt', 'For date time text', 'Date/Time', '2017-02-28 10:53:09'),
(74, 'not_permission_txt', 'For not have permission text', 'You might not have permission to access this section!', '2017-02-28 10:53:09'),
(75, 'success_txt', 'For success text', 'Successfully!', '2017-03-02 10:53:09'),
(76, 'error_txt', 'For error text', 'Data not found! / Error! Please try again.', '2017-03-02 10:53:09'),
(77, 'plugin_member_menu', 'For plugin member menu text', 'Plugins Menu', '2017-03-02 10:53:09'),
(78, 'article_filedownload_text', 'For file download label', 'File Download', NOW()),
(79, 'article_download_link', 'For download label', 'Download', NOW()),
(80, 'form_doublesubmit_alert', 'For form double submit alert text', 'The form is being submitted, please wait a moment...', NOW()),
(81, 'form_submiting_btn', 'For form button been submitting text', 'Processing, Please wait...', NOW()),
(82, 'site_error_404_title', 'For page not found error 404 title', 'Error 404, The requested page not Found!', NOW()),
(83, 'site_error_404_text', 'For page not found error 404 text', 'Sorry! The page is broken or the page has been moved. Please back to home page.', NOW()),
(84, 'site_maintenance_title', 'For site maintenance title', 'Maintenance!', NOW()),
(85, 'site_maintenance_subtitle', 'For site maintenance sub title', 'We are undergoing a bit of scheduled maintenance.', NOW()),
(86, 'site_maintenance_text', 'For site maintenance body text', 'Sorry for the inconvenience and will be back online shortly. Please check back soon.', NOW());

DROP TABLE IF EXISTS `plugin_manager`;
CREATE TABLE IF NOT EXISTS `plugin_manager` (
  `plugin_manager_id` int(11) AUTO_INCREMENT,
  `plugin_config_filename` varchar(255),
  `plugin_active` int(11),
  `timestamp_create` datetime,
  `timestamp_update` datetime,
  PRIMARY KEY (`plugin_manager_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `plugin_manager` (`plugin_manager_id`, `plugin_config_filename`, `plugin_active`, `timestamp_create`, `timestamp_update`) VALUES
(1, 'article', 1, NOW(), NOW()),
(2, 'gallery', 1, NOW(), NOW());

DROP TABLE IF EXISTS `article_db`;
CREATE TABLE IF NOT EXISTS `article_db` (
  `article_db_id` int(11) AUTO_INCREMENT,
  `url_rewrite` varchar(255),
  `is_category` int(11),
  `category_name` varchar(255),
  `main_cat_id` int(11),
  `main_picture` varchar(255),
  `file_upload` varchar(255),
  `title` varchar(255),
  `keyword` varchar(255),
  `short_desc` varchar(255),
  `content` text,
  `user_admin_id` int(11),
  `cat_id` int(11),
  `lang_iso` varchar(10),
  `active` int(11),
  `fb_comment_active` int(11),
  `fb_comment_limit` int(11),
  `fb_comment_sort` varchar(20),
  `arrange` int(11),
  `user_groups_idS` text,
  `timestamp_create` datetime,
  `timestamp_update` datetime,
  PRIMARY KEY (`article_db_id`),
  KEY `url_rewrite` (`url_rewrite`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `article_db_downloadstat`;
CREATE TABLE IF NOT EXISTS `article_db_downloadstat` (
  `article_db_downloadstat_id` int(11) AUTO_INCREMENT,
  `article_db_id` int(11),
  `file_upload` varchar(255),
  `user_admin_id` int(11),
  `user_agent` varchar(255),
  `ip_address` varchar(100),
  `timestamp_create` datetime,
  PRIMARY KEY (`article_db_downloadstat_id`),
  KEY `article_db_id` (`article_db_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `email_logs`;
CREATE TABLE IF NOT EXISTS `email_logs` (
  `email_logs_id` int(11) AUTO_INCREMENT,
  `to_email` varchar(255),
  `from_email` varchar(255),
  `from_name` varchar(255),
  `subject` varchar(255),
  `message` text,
  `email_result` text,
  `user_agent` varchar(255),
  `ip_address` varchar(100),
  `timestamp_create` datetime,
  PRIMARY KEY (`email_logs_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `gallery_db`;
CREATE TABLE IF NOT EXISTS `gallery_db` (
  `gallery_db_id` int(11) AUTO_INCREMENT,
  `album_name` varchar(255),
  `url_rewrite` varchar(255),
  `keyword` varchar(255),
  `short_desc` text,
  `lang_iso` varchar(10),
  `active` int(11),
  `arrange` int(11),
  `user_groups_idS` text,
  `timestamp_create` datetime,
  `timestamp_update` datetime,
  PRIMARY KEY (`gallery_db_id`),
  KEY `url_rewrite` (`url_rewrite`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `gallery_picture`;
CREATE TABLE IF NOT EXISTS `gallery_picture` (
  `gallery_picture_id` int(11) AUTO_INCREMENT,
  `gallery_db_id` int(11),
  `file_upload` varchar(255),
  `caption` varchar(255),
  `arrange` int(11),
  `gallery_type` varchar(255),
  `youtube_url` varchar(255),
  `timestamp_create` datetime,
  `timestamp_update` datetime,
  PRIMARY KEY (`gallery_picture_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `login_logs`;
CREATE TABLE IF NOT EXISTS `login_logs` (
  `login_logs_id` int(11) AUTO_INCREMENT,
  `email_login` varchar(255),
  `user_agent` varchar(255),
  `ip_address` varchar(100),
  `note` text,
  `result` varchar(255),
  `timestamp_create` datetime,
  PRIMARY KEY (`login_logs_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `widget_xml`;
CREATE TABLE IF NOT EXISTS `widget_xml` (
  `widget_xml_id` int(11) AUTO_INCREMENT,
  `widget_name` varchar(255),
  `xml_url` varchar(255),
  `limit_view` int(11),
  `active` int(11),
  `widget_open` text,
  `widget_content` text,
  `widget_seemore` text,
  `widget_close` text,
  `timestamp_create` datetime,
  `timestamp_update` datetime,
  PRIMARY KEY (`widget_xml_id`),
  KEY `widget_name` (`widget_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `login_security_config`;
CREATE TABLE IF NOT EXISTS `login_security_config` (
  `login_security_config_id` int(11) AUTO_INCREMENT,
  `bf_protect_period` int(11),
  `max_failure` int(11),
  `bf_private_key` varchar(255),
  `timestamp_update` datetime,
  PRIMARY KEY (`login_security_config_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `login_security_config` (`login_security_config_id`, `bf_protect_period`, `max_failure`, `bf_private_key`, `timestamp_update`) VALUES
(1, 60, 20, '', NOW());

DROP TABLE IF EXISTS `blacklist_ip`;
CREATE TABLE IF NOT EXISTS `blacklist_ip` (
  `blacklist_ip_id` int(11) AUTO_INCREMENT,
  `ip_address` varchar(255),
  `note` text,
  `timestamp_create` datetime,
  PRIMARY KEY (`blacklist_ip_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `whitelist_ip`;
CREATE TABLE IF NOT EXISTS `whitelist_ip` (
  `whitelist_ip_id` int(11) AUTO_INCREMENT,
  `ip_address` varchar(255),
  `note` text,
  `timestamp_create` datetime,
  PRIMARY KEY (`whitelist_ip_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `link_stat_mgt`;
CREATE TABLE IF NOT EXISTS `link_stat_mgt` (
  `link_stat_mgt_id` int(11) AUTO_INCREMENT,
  `url` varchar(255),
  `timestamp_create` datetime,
  PRIMARY KEY (`link_stat_mgt_id`),
  KEY `url` (`url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `user_groups`;
CREATE TABLE `user_groups` (
  `user_groups_id` int(11) AUTO_INCREMENT,
  `name` varchar(100),
  `definition` text,
  PRIMARY KEY (`user_groups_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=5;

INSERT INTO `user_groups` VALUES ('1', 'Admin', 'Super Admin Group');
INSERT INTO `user_groups` VALUES ('2', 'Editor', 'Editor Access Group');
INSERT INTO `user_groups` VALUES ('3', 'Public', 'Public Access Group');
INSERT INTO `user_groups` VALUES ('4', 'Guest', 'Guest Access Group');

DROP TABLE IF EXISTS `user_perms`;
CREATE TABLE `user_perms` (
  `user_perms_id` int(11) AUTO_INCREMENT,
  `name` varchar(100),
  `definition` text,
  `permstype` varchar(100),
  PRIMARY KEY (`user_perms_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=34;

INSERT INTO `user_perms` (`user_perms_id`, `name`, `definition`, `permstype`) VALUES
(1, 'save', 'For save permission on backend', 'backend'),
(2, 'delete', 'For delete permission on backend', 'backend'),
(3, 'analytics', 'For analytics access permission on backend', 'backend'),
(4, 'forms builder', 'For forms builder access permission', 'backend'),
(5, 'plugin widget', 'For plugin widget access permission on backend', 'backend'),
(6, 'file upload', 'For file upload access permission on backend', 'backend'),
(7, 'pages content', 'For pages content access permission on backend', 'backend'),
(8, 'navigation', 'For navigation access permission on backend', 'backend'),
(9, 'linkstats', 'For statistic for links access permission on backend', 'backend'),
(10, 'language', 'For language access permission on backend', 'backend'),
(11, 'general label', 'For general label access permission on backend', 'backend'),
(12, 'site settings', 'For site settings access permission on backend', 'backend'),
(13, 'maintenance', 'For maintenance system access permission on backend', 'backend'),
(14, 'plugin manager', 'For plugin manager access permission on backend', 'backend'),
(15, 'admin users', 'For admin users access permission on backend', 'backend'),
(16, 'member users', 'For member users access permission on backend', 'backend'),
(17, 'user groups', 'For user groups access permission on backend', 'backend'),
(18, 'email logs', 'For email logs access permission on backend', 'backend'),
(19, 'login logs', 'For login logs access permission on backend', 'backend'),
(20, 'protection settings', 'For protection settings access permission on backend', 'backend'),
(21, 'gallery', 'For gallery plugin access permission on backend', 'backend'),
(22, 'article', 'For article plugin access permission on backend', 'backend'),
(23, 'social', 'For social settings access permission on backend', 'backend'),
(24, 'profile save', 'For user profile save permission on frontend', 'frontend'),
(25, 'pm', 'For private message access permission on frontend', 'frontend'),
(26, 'banner', 'For banner manager access permission on backend', 'backend'),
(27, 'file manager', 'For file manager access permission on backend', 'backend'),
(28, 'pages cssjs additional', 'For pages content css js metatag additional access permission on backend', 'backend'),
(29, 'export', 'For Import Export CSV access permission on backend', 'backend'),
(30, 'pm', 'For PM access permission on backend', 'backend'),
(31, 'carousel', 'For carousel access permission on backend', 'backend'),
(32, 'old plugin widget', 'For old plugin widget access permission on backend', 'backend'),
(33, 'server info', 'For server information access permission on backend', 'backend');

DROP TABLE IF EXISTS `user_perm_to_group`;
CREATE TABLE `user_perm_to_group` (
  `user_perms_id` int(11),
  `user_groups_id` int(11),
  PRIMARY KEY (`user_perms_id`,`user_groups_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `user_perm_to_group` (`user_perms_id`, `user_groups_id`) VALUES
(1, 2),
(3, 2),
(3, 4),
(4, 2),
(4, 4),
(5, 2),
(5, 4),
(6, 2),
(6, 4),
(7, 2),
(7, 4),
(8, 2),
(8, 4),
(9, 2),
(9, 4),
(10, 2),
(10, 4),
(11, 2),
(11, 4),
(12, 4),
(13, 2),
(13, 4),
(14, 4),
(21, 2),
(21, 4),
(22, 2),
(22, 4),
(23, 2),
(23, 4),
(24, 2),
(24, 3),
(25, 2),
(25, 3),
(25, 4),
(26, 2),
(26, 4),
(27, 2),
(30, 2),
(31, 2);

DROP TABLE IF EXISTS `user_to_group`;
CREATE TABLE `user_to_group` (
  `user_admin_id` int(11),
  `user_groups_id` int(11),
  PRIMARY KEY (`user_admin_id`,`user_groups_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `user_to_group` VALUES ('1', '1');

DROP TABLE IF EXISTS `user_pms`;
CREATE TABLE `user_pms` (
  `id` int(11) AUTO_INCREMENT,
  `sender_id` int(11),
  `receiver_id` int(11),
  `title` varchar(255),
  `message` text,
  `date_sent` datetime,
  `date_read` datetime,
  `pm_deleted_sender` int(1),
  `pm_deleted_receiver` int(1),
  PRIMARY KEY (`id`),
  KEY `full_index` (`id`,`sender_id`,`receiver_id`,`date_read`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `banner_mgt`;
CREATE TABLE `banner_mgt` (
  `banner_mgt_id` int(11) AUTO_INCREMENT,
  `name` varchar(255),
  `img_path` varchar(255),
  `width` int(5),
  `height` int(5),
  `link` varchar(255),
  `start_date` date,
  `end_date` date,
  `nofollow` int(11),
  `active` int(11),
  `note` text,
  `timestamp_create` datetime,
  `timestamp_update` datetime,
  PRIMARY KEY (`banner_mgt_id`),
  KEY `link` (`link`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `banner_statistic`;
CREATE TABLE `banner_statistic` (
  `banner_statistic_id` int(11) AUTO_INCREMENT,
  `banner_mgt_id` int(11),
  `ip_address` varchar(255),
  `timestamp_create` datetime,
  PRIMARY KEY (`banner_statistic_id`),
  KEY `banner_mgt_id` (`banner_mgt_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `actions_logs`;
CREATE TABLE `actions_logs` (
  `actions_logs_id` int(11) AUTO_INCREMENT,
  `email_login` varchar(255),
  `user_agent` varchar(255),
  `ip_address` varchar(100),
  `note` text,
  `url` varchar(255),
  `actions` varchar(255),
  `timestamp_create` datetime,
  PRIMARY KEY (`actions_logs_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `save_formdraft`;
CREATE TABLE `save_formdraft` (
  `id` int(11) AUTO_INCREMENT,
  `form_url` text,
  `submit_array` text,
  `user_admin_id` int(11),
  `timestamp_create` datetime,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE `ci_sessions` (
    `id` varchar(128),
    `ip_address` varchar(45),
    `timestamp` int(10) unsigned DEFAULT 0,
    `data` blob,
    PRIMARY KEY (`id`),
    KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `carousel_widget`;
CREATE TABLE IF NOT EXISTS `carousel_widget` (
  `carousel_widget_id` int(11) AUTO_INCREMENT,
  `name` varchar(255),
  `active` int(11),
  `custom_temp_active` int(11),
  `custom_template` text,
  `timestamp_create` datetime,
  `timestamp_update` datetime,
  PRIMARY KEY (`carousel_widget_id`),
  KEY `carousel_widget_id` (`carousel_widget_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `carousel_widget` (`carousel_widget_id`, `name`, `active`, `custom_temp_active`, `custom_template`, `timestamp_create`, `timestamp_update`) VALUES
(1, 'Home', 1, 0, '', NOW(), NOW());

DROP TABLE IF EXISTS `carousel_picture`;
CREATE TABLE IF NOT EXISTS `carousel_picture` (
  `carousel_picture_id` int(11) AUTO_INCREMENT,
  `carousel_widget_id` int(11),
  `file_upload` varchar(255),
  `photo_url` varchar(512),
  `caption` varchar(255),
  `arrange` int(11),
  `carousel_type` varchar(255),
  `youtube_url` varchar(255),
  `timestamp_create` datetime,
  `timestamp_update` datetime,
  PRIMARY KEY (`carousel_picture_id`),
  KEY `carousel_widget_id` (`carousel_widget_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `carousel_picture` (`carousel_picture_id`, `carousel_widget_id`, `file_upload`, `photo_url`, `caption`, `arrange`, `carousel_type`, `youtube_url`, `timestamp_create`, `timestamp_update`) VALUES
(1, 1, NULL, 'https://placehold.it/1900x540&text=Slide%20One', 'Caption One', 1, 'multiimages', NULL, NOW(), NOW()),
(2, 1, NULL, 'https://placehold.it/1900x540&text=Slide%20Two', 'Caption Two', 2, 'multiimages', NULL, NOW(), NOW()),
(3, 1, NULL, 'https://placehold.it/1900x540&text=Slide%20Three', 'Caption Three', 3, 'multiimages', NULL, NOW(), NOW());

DROP TABLE IF EXISTS `plugin_widget`;
CREATE TABLE IF NOT EXISTS `plugin_widget` (
  `plugin_widget_id` int(11) AUTO_INCREMENT,
  `name` varchar(255),
  `plugin_filename` varchar(255),
  `sort_by` varchar(255),
  `order_by` varchar(10),
  `data_limit` int(11),
  `view_id` int(11),
  `template_code` text,
  `lang_iso` varchar(10),
  `active` int(11),
  `timestamp_create` datetime,
  `timestamp_update` datetime,
  PRIMARY KEY (`plugin_widget_id`),
  KEY `plugin_widget_id` (`plugin_widget_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `gallery_config`;
CREATE TABLE IF NOT EXISTS `gallery_config` (
  `gallery_config_id` int(11) AUTO_INCREMENT,
  `gallery_sort` varchar(255),
  `user_admin_id` int(11),
  `timestamp_update` datetime,
  PRIMARY KEY (`gallery_config_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
INSERT INTO `gallery_config` (`gallery_config_id`, `gallery_sort`, `user_admin_id`, `timestamp_update`) VALUES (1, 'manually', '1', NOW());