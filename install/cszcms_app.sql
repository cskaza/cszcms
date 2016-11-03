CREATE TABLE IF NOT EXISTS `footer_social` (
  `footer_social_id` int(11) NOT NULL AUTO_INCREMENT,
  `social_name` varchar(255) NOT NULL,
  `social_url` varchar(255) NOT NULL,
  `active` int(11) NOT NULL,
  `timestamp_update` datetime NOT NULL,
  PRIMARY KEY (`footer_social_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

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
(25, 'vk', '', 0, '2016-05-06 15:50:59');

CREATE TABLE IF NOT EXISTS `form_contactus_en` (
  `form_contactus_en_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_type` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `timestamp_create` datetime NOT NULL,
  PRIMARY KEY (`form_contactus_en_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `form_field` (
  `form_field_id` int(11) NOT NULL AUTO_INCREMENT,
  `form_main_id` int(11) NOT NULL,
  `field_type` varchar(100) NOT NULL,
  `field_name` varchar(255) NOT NULL,
  `field_id` varchar(255) NOT NULL,
  `field_class` varchar(255) NOT NULL,
  `field_placeholder` varchar(255) NOT NULL,
  `field_value` varchar(255) NOT NULL,
  `field_label` varchar(255) NOT NULL,
  `sel_option_val` text NOT NULL,
  `field_required` int(11) NOT NULL,
  `timestamp_create` datetime NOT NULL,
  `timestamp_update` datetime NOT NULL,
  PRIMARY KEY (`form_field_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

INSERT INTO `form_field` (`form_field_id`, `form_main_id`, `field_type`, `field_name`, `field_id`, `field_class`, `field_placeholder`, `field_value`, `field_label`, `sel_option_val`, `field_required`, `timestamp_create`, `timestamp_update`) VALUES
(1, 1, 'text', 'name', 'name', 'form-control', '', '', 'Name', '', 1, '2016-05-02 19:15:50', '2016-05-02 19:15:50'),
(2, 1, 'email', 'email', 'email', 'form-control', '', '', 'Email Address', '', 1, '2016-05-02 19:15:50', '2016-05-02 19:15:50'),
(3, 1, 'selectbox', 'contact_type', 'contact_type', 'form-control', '-- Choose Type --', '', 'Contact Type', 'question=>Question, contact us=>Contact Us, service=>Service', 1, '2016-05-02 19:15:50', '2016-05-02 19:15:50'),
(4, 1, 'textarea', 'message', 'message', 'form-control', '', '', 'Message', '', 1, '2016-05-02 19:15:50', '2016-05-02 19:15:50'),
(5, 1, 'submit', 'submit', 'submit', 'btn btn-primary', '', 'Send now', '', '', 0, '2016-05-02 19:15:50', '2016-05-02 19:15:50'),
(6, 1, 'reset', 'reset', 'reset', 'btn btn-default', '', 'Reset', '', '', 0, '2016-05-02 19:15:50', '2016-05-02 19:15:50');

CREATE TABLE IF NOT EXISTS `form_main` (
  `form_main_id` int(11) NOT NULL AUTO_INCREMENT,
  `form_name` varchar(255) NOT NULL,
  `form_enctype` varchar(255) NOT NULL,
  `form_method` varchar(255) NOT NULL,
  `success_txt` varchar(255) NOT NULL,
  `captchaerror_txt` varchar(255) NOT NULL,
  `error_txt` varchar(255) NOT NULL,
  `sendmail` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `send_to_visitor` int(11) NOT NULL,
  `email_field_id` int(11) NOT NULL,
  `visitor_subject` varchar(255) NOT NULL,
  `visitor_body` text NOT NULL,
  `active` int(11) NOT NULL,
  `captcha` int(11) NOT NULL,
  `timestamp_create` datetime NOT NULL,
  `timestamp_update` datetime NOT NULL,
  PRIMARY KEY (`form_main_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `form_main` (`form_main_id`, `form_name`, `form_enctype`, `form_method`, `success_txt`, `captchaerror_txt`, `error_txt`, `sendmail`, `email`, `subject`, `send_to_visitor`, `email_field_id`, `visitor_subject`, `visitor_body`, `active`, `captcha`, `timestamp_create`, `timestamp_update`) VALUES
(1, 'contactus_en', '', 'post', 'Successfully!', 'The Security Check was not input correctly. Please try again.', 'Error! Please try again.', 1, '', 'Contact us from the CSZ-CMS website', 0, 0, '', '', 1, 1, '2016-05-02 19:15:50', '2016-05-02 19:15:50');

CREATE TABLE IF NOT EXISTS `lang_iso` (
  `lang_iso_id` int(11) NOT NULL AUTO_INCREMENT,
  `lang_name` varchar(255) NOT NULL,
  `lang_iso` varchar(10) NOT NULL,
  `country` varchar(255) NOT NULL,
  `country_iso` varchar(10) NOT NULL,
  `active` int(2) NOT NULL,
  `timestamp_create` datetime NOT NULL,
  `timestamp_update` datetime NOT NULL,
  PRIMARY KEY (`lang_iso_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Language ISO' AUTO_INCREMENT=2 ;

INSERT INTO `lang_iso` (`lang_iso_id`, `lang_name`, `lang_iso`, `country`, `country_iso`, `active`, `timestamp_create`, `timestamp_update`) VALUES
(1, 'English', 'en', 'United Kingdom', 'gb', 1, '2016-03-29 15:16:23', '2016-03-31 15:28:58');

CREATE TABLE IF NOT EXISTS `pages` (
  `pages_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(255) NOT NULL,
  `page_url` varchar(255) NOT NULL,
  `lang_iso` varchar(10) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_keywords` varchar(255) NOT NULL,
  `page_desc` text NOT NULL,
  `content` text NOT NULL,
  `active` int(11) NOT NULL,
  `timestamp_create` datetime NOT NULL,
  `timestamp_update` datetime NOT NULL,
  PRIMARY KEY (`pages_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

INSERT INTO `pages` (`pages_id`, `page_name`, `page_url`, `lang_iso`, `page_title`, `page_keywords`, `page_desc`, `content`, `active`, `timestamp_create`, `timestamp_update`) VALUES
(1, 'Home', 'home', 'en', 'CSZ Home', 'CMS, Contact Management System, HTML, CSS, JS, JavaScript, framework, bootstrap, web development, thai, english, homepage', 'CSKAZA Template for Bootstrap with CSZ-CMS', '<header id="myCarousel" class="carousel slide">\r\n<ol class="carousel-indicators">\r\n<li data-target="#myCarousel" data-slide-to="0" class="active"></li>\r\n<li data-target="#myCarousel" data-slide-to="1"></li>\r\n<li data-target="#myCarousel" data-slide-to="2"></li>\r\n</ol>\r\n<!-- Wrapper for slides -->\r\n<div class="carousel-inner">\r\n<div class="item active">\r\n<div class="fill"><img src="http://placehold.it/1900x540&text=Slide One" class="img-responsive" width="100%"></div>\r\n<div class="carousel-caption">\r\n<h2>Caption 1</h2>\r\n</div>\r\n</div>\r\n<div class="item">\r\n<div class="fill"><img src="http://placehold.it/1900x540&text=Slide Two" class="img-responsive" width="100%"></div>\r\n<div class="carousel-caption">\r\n<h2>Caption 2</h2>\r\n</div>\r\n</div>\r\n<div class="item">\r\n<div class="fill"><img src="http://placehold.it/1900x540&text=Slide Three" class="img-responsive" width="100%"></div>\r\n<div class="carousel-caption">\r\n<h2>Caption 3</h2>\r\n</div>\r\n</div>\r\n</div>\r\n<!-- Controls --> <a class="left carousel-control" href="#myCarousel" data-slide="prev"> <span class="icon-prev"></span> </a> <a class="right carousel-control" href="#myCarousel" data-slide="next"> <span class="icon-next"></span> </a></header><!-- Start Jumbotron -->\r\n<div class="jumbotron">\r\n<div class="container">\r\n<h1>Hello, world!</h1>\r\n<p>This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>\r\n<p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more »</a></p>\r\n</div>\r\n</div>\r\n<div class="container">\r\n<div class="row">\r\n<div class="col-md-4">\r\n<h2>Heading</h2>\r\n<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>\r\n<p><a class="btn btn-default" href="#" role="button">View details »</a></p>\r\n</div>\r\n<div class="col-md-4">\r\n<h2>Heading</h2>\r\n<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>\r\n<p><a class="btn btn-default" href="#" role="button">View details »</a></p>\r\n</div>\r\n<div class="col-md-4">\r\n<h2>Heading</h2>\r\n<p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>\r\n<p><a class="btn btn-default" href="#" role="button">View details »</a></p>\r\n</div>\r\n</div>\r\n</div>\r\n<!-- /container -->', 1, '2016-03-08 10:12:56', '2016-05-09 11:00:51'),
(2, 'About Us', 'about-us', 'en', 'CSZ-CMS About Us', 'CMS, Contact Management System, HTML, CSS, JS, JavaScript, framework, bootstrap, web development, thai, aboutus', 'CSKAZA Template for Bootstrap with CSZ-CMS', '<div class="jumbotron">\r\n<div class="container">\r\n<h1>About Us!</h1>\r\n<p>CSKAZA Template for Bootstrap with CSZ-CMS. CSZ-CMS build by CSKAZA.</p>\r\n<p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more »</a></p>\r\n</div>\r\n</div>\r\n<div class="container">\r\n<div class="row">\r\n<div class="col-md-6">\r\n<div class="panel panel-default">\r\n<div class="panel-heading">Panel heading</div>\r\n<div class="panel-body">\r\n<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>\r\n</div>\r\n</div>\r\n</div>\r\n<div class="col-md-6">\r\n<div class="panel panel-default">\r\n<div class="panel-heading">Panel heading</div>\r\n<div class="panel-body">\r\n<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n<div class="container"></div>\r\n<p></p>', 1, '2016-04-11 15:17:18', '2016-05-01 15:16:13'),
(3, 'Contact Us', 'contact-us', 'en', 'CSZ-CMS Contact us', 'CMS, Contact Management System, HTML, CSS, JS, JavaScript, framework, bootstrap, web development, thai, contact us', 'CSKAZA Template for Bootstrap with CSZ-CMS', '<div class="jumbotron">\r\n<div class="container">\r\n<h1>Contact us!</h1>\r\n<p>If you want to contact us please use this form below. Or send the email to <a href="mailto:info@cszcms.com">info@cszcms.com</a></p>\r\n</div>\r\n</div>\r\n<div class="container"></div>\r\n<div class="container">\r\n<div class="row">\r\n<div class="col-md-6">\r\n<h2>Google Map</h2>\r\n<p><iframe width="100%" height="315" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.168282092751!2d98.37285931425068!3d7.877454308128998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0:0x0!2zN8KwNTInMzguOCJOIDk4wrAyMiczMC4yIkU!5e0!3m2!1sen!2sth!4v1462104596003" frameborder="0" allowfullscreen="allowfullscreen"></iframe></p>\r\n</div>\r\n<div class="col-md-6">\r\n<h2>Contact Form</h2>\r\n<p>If you have any question please send this from.</p>\r\n<p>[?]{=forms:contactus_en}[?]</p>\r\n</div>\r\n</div>\r\n</div>\r\n<p></p>\r\n<p></p>', 1, '2016-04-30 16:57:16', '2016-05-12 17:59:41');

CREATE TABLE IF NOT EXISTS `page_menu` (
  `page_menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(255) NOT NULL,
  `lang_iso` varchar(10) NOT NULL,
  `pages_id` int(11) NOT NULL,
  `other_link` varchar(512) NOT NULL,
  `plugin_menu` varchar(255) NOT NULL,
  `drop_menu` int(11) NOT NULL,
  `drop_page_menu_id` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  `arrange` int(11) NOT NULL,
  `timestamp_create` datetime NOT NULL,
  `timestamp_update` datetime NOT NULL,
  PRIMARY KEY (`page_menu_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

INSERT INTO `page_menu` (`page_menu_id`, `menu_name`, `lang_iso`, `pages_id`, `other_link`, `plugin_menu`, `drop_menu`, `drop_page_menu_id`, `active`, `arrange`, `timestamp_create`, `timestamp_update`) VALUES
(1, 'Home', 'en', 1, '', '', 0, 0, 1, 1, '2016-03-25 13:00:08', '2016-04-30 16:58:07'),
(2, 'About Us', 'en', 2, '', '', 0, 0, 1, 2, '2016-04-11 15:01:03', '2016-04-30 16:58:07'),
(3, 'Contact Us', 'en', 3, '', '', 0, 0, 1, 3, '2016-04-30 16:58:02', '2016-04-30 16:58:07'),
(4, 'Drop Menu', 'en', 0, '', '', 1, 0, 1, 4, '2016-03-27 15:54:15', '2016-04-30 16:58:07'),
(5, 'CSZ-CMS Website', 'en', 0, 'http://www.cszcms.com', '', 0, 4, 1, 1, '2016-03-28 15:22:12', '2016-04-30 16:58:07');

CREATE TABLE IF NOT EXISTS `settings` (
  `settings_id` int(11) NOT NULL AUTO_INCREMENT,
  `site_name` varchar(255) NOT NULL,
  `site_logo` varchar(255) NOT NULL,
  `og_image` varchar(255) NOT NULL,
  `fbapp_id` varchar(255) NOT NULL,
  `site_footer` text NOT NULL,
  `default_email` varchar(255) NOT NULL,
  `keywords` text NOT NULL,
  `themes_config` varchar(255) NOT NULL,
  `admin_lang` varchar(255) NOT NULL,
  `additional_js` text NOT NULL,
  `additional_metatag` text NOT NULL,
  `googlecapt_active` int(11) NOT NULL,
  `googlecapt_sitekey` varchar(255) NOT NULL,
  `googlecapt_secretkey` varchar(255) NOT NULL,
  `link_statistic_active` int(11) NOT NULL,
  `pagecache_time` int(3) NOT NULL,
  `email_protocal` varchar(20) NOT NULL,
  `smtp_host` varchar(255) NOT NULL,
  `smtp_user` varchar(255) NOT NULL,
  `smtp_pass` varchar(255) NOT NULL,
  `smtp_port` varchar(5) NOT NULL,
  `sendmail_path` varchar(255) NOT NULL,
  `member_confirm_enable` int(11) NOT NULL,
  `member_close_regist` int(11) NOT NULL,
  `timestamp_update` datetime NOT NULL,
  PRIMARY KEY (`settings_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `settings` (`settings_id`, `site_name`, `site_logo`, `og_image`, `fbapp_id`, `site_footer`, `default_email`, `keywords`, `themes_config`, `admin_lang`, `additional_js`, `additional_metatag`, `googlecapt_active`, `googlecapt_sitekey`, `googlecapt_secretkey`, `link_statistic_active`, `pagecache_time`, `email_protocal`, `smtp_host`, `smtp_user`, `smtp_pass`, `smtp_port`, `sendmail_path`, `member_confirm_enable`, `member_close_regist`, `timestamp_update`) VALUES
(1, 'CSZ-CMS Starter', '', '', '', '&copy; %YEAR CSZ-CMS Starter', '', 'CMS, Contact Management System, HTML, CSS, JS, JavaScript, framework, bootstrap, web development, thai, english', 'cszdefault', 'english', '', '', 0, '', '', 0, 0, '', '', '', '', '', '', 0, 0, '2016-05-19 15:08:31');

CREATE TABLE IF NOT EXISTS `upload_file` (
  `upload_file_id` int(11) NOT NULL AUTO_INCREMENT,
  `year` varchar(10) NOT NULL,
  `file_upload` varchar(255) NOT NULL,
  `remark` TEXT NOT NULL,
  `timestamp_create` datetime NOT NULL,
  `timestamp_update` datetime NOT NULL,
  PRIMARY KEY (`upload_file_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `user_admin` (
  `user_admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(100) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `backend_visitor` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `md5_hash` varchar(255) NOT NULL,
  `md5_lasttime` datetime NOT NULL,
  `timestamp_create` datetime NOT NULL,
  `timestamp_update` datetime NOT NULL,
  PRIMARY KEY (`user_admin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `link_statistic` (
  `link_statistic_id` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `timestamp_create` datetime NOT NULL,
  PRIMARY KEY (`link_statistic_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `general_label` (
  `general_label_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `remark` text NOT NULL,
  `lang_en` text NOT NULL,
  `timestamp_update` datetime NOT NULL,
  PRIMARY KEY (`general_label_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=93 ;

INSERT INTO `general_label` (`general_label_id`, `name`, `remark`, `lang_en`, `timestamp_update`) VALUES
(1, 'login_heading', 'For member login Header text', 'Member Login', '2016-07-04 11:43:18'),
(2, 'login_incorrect', 'For member login incorrect', 'Email address/Password is incorrect', '2016-07-04 11:44:09'),
(3, 'captcha_wrong', 'For member login when wrong captcha', 'The Security Check was not input correctly. Please try again.', '2016-07-04 11:44:39'),
(4, 'login_email', 'For email address label', 'Email Address', '2016-06-23 23:34:45'),
(5, 'login_password', 'For password label', 'Your Password', '2016-06-23 23:35:22'),
(6, 'login_signin', 'For member login button', 'Log in', '2016-06-23 23:35:53'),
(7, 'login_forgetpwd', 'For member forget password button', 'Forgot Password', '2016-06-23 23:37:02'),
(8, 'login_register', 'For member register label', 'Register', '2016-06-24 16:41:07'),
(9, 'mamber_firstname', 'For member firstname label', 'First Name', '2016-06-24 16:58:09'),
(10, 'member_lastname', 'For member lastname label', 'Last Name', '2016-06-24 16:58:09'),
(11, 'member_address', 'For member address label', 'Address', '2016-06-24 16:58:09'),
(12, 'confirm_password', 'For confirm password label', 'Confirm Password', '2016-06-24 16:58:09'),
(13, 'member_forgot_complete', 'For forget password is successfully', 'Successfully! Your password has been reset', '2016-06-24 16:58:09'),
(14, 'member_reset_btn', 'For reset button', 'Reset', '2016-06-24 17:48:32'),
(15, 'member_forget_chkmail', 'For reset text email to inbox', 'Please check your email inbox and click the link to reset your password.', '2016-06-24 17:48:32'),
(16, 'email_reset_subject', 'For email subject when member forget password', 'Reset your member password', '2016-06-26 15:43:39'),
(17, 'email_reset_message', 'For email message when member forget password', 'Please click the link below within 30 minutes to reset your password.', '2016-06-26 15:43:39'),
(18, 'email_dear', 'For email header', 'Dear ', '2016-06-26 15:43:39'),
(19, 'email_footer', 'For email footer', 'Regards,<br>', '2016-06-26 15:43:39'),
(20, 'email_check', 'For email does not exist text', 'This email address does not exist', '2016-06-26 15:47:01'),
(21, 'btn_cancel', 'For cancel button', 'Cancel', '2016-06-26 15:52:28'),
(22, 'btn_back', 'For back button', 'Back', '2016-06-26 15:53:59'),
(23, 'email_already', 'For email has already', 'This email address has already', '2016-06-26 21:31:20'),
(24, 'email_confirm_subject', 'For email confirm subject text', 'Confirm your mamber register', '2016-06-27 18:00:10'),
(25, 'email_confirm_message', 'For email confirm message', 'Please click the link below within 30 minutes to confirm your member.', '2016-06-28 10:28:20'),
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
(43, 'picture', 'For picture text', 'You Picture', '2016-07-02 18:18:58'),
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
(62, 'shop_new_product', 'For new product label', 'New Products', '2016-09-19 16:26:59'),
(63, 'shop_hot_product', 'For hot product label', 'Hot Products', '2016-09-19 16:26:59'),
(64, 'shop_bestseller_product', 'For beset seller label', 'Best Seller', '2016-09-19 16:26:59'),
(65, 'shop_soldout_product', 'For soldout label', 'Sold Out', '2016-09-19 16:26:59'),
(66, 'shop_see_more', 'For see more button', 'See More', '2016-09-19 16:28:41'),
(67, 'shop_product_category', 'For product category label', 'Products Category', '2016-09-19 16:28:41'),
(68, 'shop_cart_text', 'For cart text', 'Shopping Cart', '2016-09-19 16:44:00'),
(69, 'shop_notfound', 'For data not found', 'Data not found!', '2016-09-19 17:31:26'),
(70, 'shop_view_btn', 'For view button', 'View', '2016-09-20 17:17:59'),
(71, 'shop_price_txt', 'For price text.', 'Price', '2016-09-21 17:53:25'),
(72, 'shop_add_to_cart_btn', 'For Add to cart button', 'Add to Cart', '2016-09-21 17:53:25'),
(73, 'shop_option_txt', 'For option text', 'Additional Option', '2016-09-22 10:51:25'),
(74, 'shop_product_code_txt', 'For product code text', 'Product Code', '2016-09-22 11:00:53'),
(75, 'shop_home_txt', 'For home text', 'Home', '2016-09-22 15:24:07'),
(76, 'shop_product_search_txt', 'For product search text', 'Products Search', '2016-09-22 15:47:27'),
(77, 'shop_qty_txt', 'For quantity text', 'Qty', '2016-09-22 16:02:59'),
(78, 'shop_product_name_txt', 'For product name text', 'Product Name', '2016-09-22 17:56:16'),
(79, 'shop_amount_txt', 'For amount text', 'Amount', '2016-09-22 17:56:16'),
(80, 'shop_clear_cart_txt', 'For clear cart text', 'Clear Cart', '2016-09-22 17:56:16'),
(81, 'shop_place_order_txt', 'For place order text', 'Place Order', '2016-09-22 17:56:16'),
(82, 'shop_order_total_txt', 'For order total text', 'Total', '2016-09-22 17:56:16'),
(83, 'shop_delete_alert', 'For delete alert text', 'Do you want to do this ?', '2016-09-22 18:07:39'),
(84, 'shop_payment_btn', 'For payment button text', 'Payment Now', '2016-09-23 15:23:48'),
(85, 'shop_contact_detail_txt', 'For contact detail text', 'Contact Detail', '2016-09-23 15:27:55'),
(86, 'shop_your_email_login', 'For your email logged in as text', 'Your email logged in as', '2016-09-23 16:55:09'),
(87, 'shop_payment_methods', 'For payment methods text', 'Payment Methods', '2016-09-23 17:31:37'),
(88, 'shop_bank_transfer', 'For bank transfer text', 'Bank Transfer', '2016-09-23 17:31:37'),
(89, 'shop_special_price', 'For special price text', 'Special Price', '2016-09-25 19:51:06'),
(90, 'shop_cancel_order_txt', 'For order cancel text', 'We are sorry! Your last transaction was cancelled.', '2016-09-26 10:53:09'),
(91, 'shop_success_order_txt', 'For order success text', 'Your payment was successful! Thank you for purchase.', '2016-09-26 10:53:09'),
(92, 'shop_all_product_txt', 'For all product text', 'All Products', '2016-09-26 10:53:09');

CREATE TABLE IF NOT EXISTS `plugin_manager` (
  `plugin_manager_id` int(11) NOT NULL AUTO_INCREMENT,
  `plugin_name` varchar(255) NOT NULL,
  `plugin_urlrewrite` varchar(255) NOT NULL,
  `plugin_version` varchar(10) NOT NULL,
  `plugin_owner` varchar(255) NOT NULL,
  `plugin_db_table` text NOT NULL,
  `plugin_active` int(11) NOT NULL,
  `timestamp_create` datetime NOT NULL,
  `timestamp_update` datetime NOT NULL,
  PRIMARY KEY (`plugin_manager_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO `plugin_manager` (`plugin_manager_id`, `plugin_name`, `plugin_urlrewrite`, `plugin_version`, `plugin_owner`, `plugin_db_table`, `plugin_active`, `timestamp_create`, `timestamp_update`) VALUES
(1, 'Article', 'article', '1.0.2', 'CSKAZA', 'article_db', 1, '2016-07-21 09:59:53', '2016-08-23 15:28:25'),
(2, 'Gallery', 'gallery', '1.0.2', 'CSKAZA', 'gallery_db,gallery_picture', 1, '2016-07-21 09:59:53', '2016-08-23 15:28:25'),
(3, 'Shopping', 'shop', '1.0.1', 'CSKAZA', 'shop_product,shop_category,shop_config,shop_payment,shop_product_imgs,shop_product_option,shop_shipping', 1, NOW(), NOW());

CREATE TABLE IF NOT EXISTS `article_db` (
  `article_db_id` int(11) NOT NULL AUTO_INCREMENT,
  `url_rewrite` varchar(255) NOT NULL,
  `is_category` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `main_cat_id` int(11) NOT NULL,
  `main_picture` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `short_desc` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `user_admin_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `lang_iso` varchar(10) NOT NULL,
  `active` int(11) NOT NULL,
  `fb_comment_active` int(11) NOT NULL,
  `fb_comment_limit` int(11) NOT NULL,
  `fb_comment_sort` varchar(20) NOT NULL,
  `timestamp_create` datetime NOT NULL,
  `timestamp_update` datetime NOT NULL,
  PRIMARY KEY (`article_db_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `email_logs` (
  `email_logs_id` int(11) NOT NULL AUTO_INCREMENT,
  `to_email` varchar(255) NOT NULL,
  `from_email` varchar(255) NOT NULL,
  `from_name` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `email_result` text NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  `timestamp_create` datetime NOT NULL,
  PRIMARY KEY (`email_logs_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `gallery_db` (
  `gallery_db_id` int(11) NOT NULL AUTO_INCREMENT,
  `album_name` varchar(255) NOT NULL,
  `url_rewrite` varchar(255) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `short_desc` varchar(255) NOT NULL,
  `lang_iso` varchar(10) NOT NULL,
  `active` int(11) NOT NULL,
  `timestamp_create` datetime NOT NULL,
  `timestamp_update` datetime NOT NULL,
  PRIMARY KEY (`gallery_db_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `gallery_picture` (
  `gallery_picture_id` int(11) NOT NULL AUTO_INCREMENT,
  `gallery_db_id` int(11) NOT NULL,
  `file_upload` varchar(255) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `arrange` int(11) NOT NULL,
  `gallery_type` varchar(255) NOT NULL,
  `youtube_url` varchar(255) NOT NULL,
  `timestamp_create` datetime NOT NULL,
  `timestamp_update` datetime NOT NULL,
  PRIMARY KEY (`gallery_picture_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `login_logs` (
  `login_logs_id` int(11) NOT NULL AUTO_INCREMENT,
  `email_login` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  `note` text NOT NULL,
  `result` varchar(255) NOT NULL,
  `timestamp_create` datetime NOT NULL,
  PRIMARY KEY (`login_logs_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `shop_category` (
  `shop_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_category_main_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `url_rewrite` varchar(255) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `short_desc` varchar(255) NOT NULL,
  `active` int(11) NOT NULL,
  `timestamp_create` datetime NOT NULL,
  `timestamp_update` datetime NOT NULL,
  PRIMARY KEY (`shop_category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `shop_config` (
  `shop_config_id` int(11) NOT NULL AUTO_INCREMENT,
  `stat_new_show` int(11) NOT NULL,
  `stat_hot_show` int(11) NOT NULL,
  `stat_bestseller_show` int(11) NOT NULL,
  `stat_soldout_show` int(11) NOT NULL,
  `paypal_active` int(11) NOT NULL,
  `sanbox_active` int(11) NOT NULL,
  `paypal_email` varchar(255) NOT NULL,
  `paysbuy_active` int(11) NOT NULL,
  `paysbuy_email` varchar(255) NOT NULL,
  `bank_detail` text NOT NULL,
  `currency_code` varchar(10) NOT NULL,
  `seller_email` varchar(255) NOT NULL,
  `order_subject` varchar(255) NOT NULL,
  `order_body` text NOT NULL,
  `payment_subject` varchar(255) NOT NULL,
  `payment_body` text NOT NULL,
  `signature` text NOT NULL,
  `timestamp_update` datetime NOT NULL,
  PRIMARY KEY (`shop_config_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT IGNORE INTO `shop_config` (`shop_config_id`, `stat_new_show`, `stat_hot_show`, `stat_bestseller_show`, `stat_soldout_show`, `paypal_active`, `sanbox_active`, `paypal_email`, `paysbuy_active`, `paysbuy_email`, `bank_detail`, `currency_code`, `seller_email`, `order_subject`, `order_body`, `payment_subject`, `payment_body`, `signature`, `timestamp_update`) VALUES
(1, 1, 1, 1, 0, 0, 0, '', 0, '', '<h2>Bank Detail:</h2><h4><strong>Example Bank (Test Branch)</strong></h4><p><strong>ACC ID :</strong> 857-1531-19-9<br /> <strong>ACC Name :</strong> Example Tester</p><p><em>After transfer the payment. Please send the payslip to test@example.com</em></p>', 'USD', '', 'Thank you for your order!', '<p><strong>Dear Valued Customer,</strong></p><p><strong></strong><br /></p><p>Thank you very much for your order. After payment successed. Your order is being processed and will be shipped to you.</p><p><strong></strong></p>', 'Your payment has now been confirmed!', '<p><strong>Dear Valued Customer,</strong></p><p><strong></strong><br /></p><p>Thank you for your order. Your payment has now been confirmed. Your order is already being processed and will be shipped to you.</p>', '<p><strong>Regards,</strong></p><p><strong>Shopping Web Team</strong><br /><strong>Tel: (001) 234 567 8910</strong><br /><strong>Email: test@example.com</strong></p>', '2016-09-27 12:59:09');

CREATE TABLE IF NOT EXISTS `shop_payment` (
  `shop_payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `sha1_hash` varchar(255) NOT NULL,
  `inv_id` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `payment_methods` varchar(100) NOT NULL,
  `price_total` double NOT NULL,
  `order_detail` text NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  `payment_status` varchar(100) NOT NULL,
  `shipping` int(11) NOT NULL,
  `timestamp_create` datetime NOT NULL,
  `timestamp_update` datetime NOT NULL,
  PRIMARY KEY (`shop_payment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `shop_product` (
  `shop_product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL,
  `url_rewrite` varchar(255) NOT NULL,
  `shop_category_id` int(11) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `short_desc` varchar(255) NOT NULL,
  `full_desc` text NOT NULL,
  `price` double NOT NULL,
  `discount` double NOT NULL,
  `stock` int(11) NOT NULL,
  `product_code` varchar(100) NOT NULL,
  `product_status` varchar(255) NOT NULL,
  `active` int(11) NOT NULL,
  `timestamp_create` datetime NOT NULL,
  `timestamp_update` datetime NOT NULL,
  PRIMARY KEY (`shop_product_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `shop_product_imgs` (
  `shop_product_imgs_id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_product_id` int(11) NOT NULL,
  `file_upload` varchar(255) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `arrange` int(11) NOT NULL,
  `timestamp_create` datetime NOT NULL,
  `timestamp_update` datetime NOT NULL,
  PRIMARY KEY (`shop_product_imgs_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `shop_product_option` (
  `shop_product_option_id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_product_id` int(11) NOT NULL,
  `field_type` varchar(100) NOT NULL,
  `field_name` varchar(255) NOT NULL,
  `field_placeholder` varchar(255) NOT NULL,
  `field_value` varchar(255) NOT NULL,
  `field_label` varchar(255) NOT NULL,
  `field_sel_value` text NOT NULL,
  `timestamp_create` datetime NOT NULL,
  `timestamp_update` datetime NOT NULL,
  PRIMARY KEY (`shop_product_option_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `shop_shipping` (
  `shop_shipping_id` int(11) NOT NULL AUTO_INCREMENT,
  `inv_id` varchar(100) NOT NULL,
  `shipping_name` varchar(255) NOT NULL,
  `shipping_id` varchar(100) NOT NULL,
  `note` text NOT NULL,
  `timestamp_create` datetime NOT NULL,
  `timestamp_update` datetime NOT NULL,
  PRIMARY KEY (`shop_shipping_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `widget_xml` (
  `widget_xml_id` int(11) NOT NULL AUTO_INCREMENT,
  `widget_name` varchar(255) NOT NULL,
  `xml_url` varchar(255) NOT NULL,
  `limit_view` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  `timestamp_create` datetime NOT NULL,
  `timestamp_update` datetime NOT NULL,
  PRIMARY KEY (`widget_xml_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;