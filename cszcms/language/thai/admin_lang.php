<?php
//Backend System
$lang['backend_system']		= "ระบบเบื้องหลัง";

//Dashboard
$lang['dashboard_totalemail']	= "รวมบันทึกอีเมล์";
$lang['dashboard_totallink']	= "รวมสถิติลิงค์";
$lang['dashboard_totalmember']	= "รวมสมาชิก";
$lang['dashboard_viewdetail']	= "ดูรายละเอียด";
$lang['dashboard_linkrecent']	= "สถิติลิงค์ล่าสุด 20 รายการ";
$lang['dashboard_emailrecent']	= "บันทึกอีเมล์ล่าสุด 10 รายการ";
$lang['dashboard_toemail']	= "ถึง";
$lang['dashboard_fromemail']	= "จาก";
$lang['dashboard_rssnews']	= "ข่าว CSZ CMS ล่าสุด";

//Navigation Bar
$lang['nav_dash']		= "แดชบอร์ด";
$lang['nav_view_site']		= "ดูเว็บไซต์";
$lang['nav_general_menu']       = "เมนูทั่วไป";
$lang['nav_content_menu']       = "เมนูเนื้อหา";
$lang['nav_admin_users']	= "ผู้ใช้งาน";
$lang['nav_nav_header']         = "แถบเมนู";
$lang['nav_logout']		= "ออกจากระบบ";
$lang['nav_gel_settings']	= "เมนูทั่วไป";
$lang['nav_analytics']		= "Analytics";

// Google Analytics
$lang['ga_last30']		= "Google Analytics";
$lang['ga_maps']		= "แผนที่ Google Analytics";
$lang['ga_sessions']            = "Google Analytics Sessions";
$lang['ga_devices']		= "Google Analytics อุปกรณ์";
$lang['ga_sources']		= "Google Analytics แหล่งที่มา";
$lang['ga_refer']               = "Google Analytics อ้างอิง";
$lang['ga_allpage']               = "Google Analytics หน้าเนื้อหาทั้งหมด";
$lang['ga_no_settings']         = 'Google Analytics ไม่ได้ถูกตั้งค่าบน <a href="'.get_instance()->Csz_model->base_link().'/'.'admin/settings#ga_client_id" title="การตั้งค่าเว็บไซต์"><b>การตั้งค่าเว็บไซต์</b></a>!';
$lang['ga_days']		= "วัน";
$lang['ga_last_txt']		= "ล่าสุด";

//Users - All Users
$lang['user_header']			= "ผู้ใช้งานทั้งหมด";
$lang['user_status']			= "สถานะ";
$lang['user_name']			= "ชื่อหน้าจอ";
$lang['user_email']			= "ที่อยู่อีเมล์";
$lang['user_delete_btn']		= "ลบ";
$lang['user_edit_btn']                  = "แก้ไข";
$lang['user_delete_message']            = "คุณแน่ใจที่จะดำเนินการสิ่งนี้? แน่ใจว่าชื่อผู้ใช้งานนี้ไม่ใช่ของคุณ.";
$lang['user_delete_myacc']              = "ไม่สามารถลบได้! ชื่อผู้ใช้งานนี้เป็นของคุณ.";
$lang['user_addnew']			= "เพิ่มผู้ใช้งาน";

//Users - New User/Edit User
$lang['user_new_header']		= "เพิ่มผู้ใช้งาน";
$lang['user_edit_header']		= "แก้ไขผู้ใช้งาน";
$lang['user_new_name']                  = "ชื่อหน้าจอ";
$lang['user_new_email']			= "ที่อยู่อีเมล์";
$lang['user_cur_pass']			= "รหัสผ่านปัจจุบัน";
$lang['user_new_pass']			= "รหัสผ่านใหม่";
$lang['user_new_confirm']		= "ยืนยันรหัสผ่าน";
$lang['user_new_active']		= "เปิดใช้งาน";
$lang['user_new_deactive']		= "ปิดการใช้งาน";
$lang['user_new_type']                  = "ประเภทของผู้ใช้งาน";
$lang['user_first_name']                = "ชื่อจริง";
$lang['user_last_name']                 = "นามสกุล";
$lang['user_birthday']                  = "วันเกิด";
$lang['user_gender']                    = "เพศ";
$lang['user_address']                   = "ที่อยู่";
$lang['user_phone']                     = "โทรศัพท์";
$lang['user_picture']                   = "รูปภาพ";
$lang['user_backend_visitor']           = "ผู้เยี่ยมชมสำหรับระบบเบื้องหลัง";
$lang['user_not_allow_txt']             = "คุณอาจไม่ได้รับอนุญาตให้ใช้งานในส่วนนี้!";
$lang['user_notapply_member']           = "ไม่สามารถใช้กับประเภทของ 'Member' ได้!";
$lang['user_member_txt']                = "ผู้ใช้งานสมาชิก";
$lang['user_admin_txt']                 = "ผู้ใช้งานแอดมิน";
$lang['user_group_txt']                 = "กลุ่มผู้ใช้";
$lang['user_group_new']                 = "เพิ่มกลุ่มใหม่";
$lang['user_group_edit']                = "แก้ไขกลุ่ม";
$lang['user_group_name']                = "ชื่อกลุ่ม";
$lang['user_group_definition']          = "คำนิยามของกลุ่ม";
$lang['user_permission_txt']            = "การอนุญาต";
$lang['user_backend_txt']               = "ระบบเบื้องหลัง";
$lang['user_frontend_txt']              = "ระบบเบื้องหน้า";
$lang['user_perm_allow']                = "อนุญาต";
$lang['user_perm_deny']                 = "ไม่อนุญาต";
$lang['user_req_changepwd']             = "จำเป็นต้องเปลี่ยนรหัสผ่าน";

// COMMON BUTTONS
$lang['btn_save']		= "บันทึก";
$lang['btn_save_draft']		= "บันทึกฉบับร่าง";
$lang['btn_save_exit']		= "บันทึก & ออก";
$lang['btn_cancel']		= "ยกเลิก";
$lang['btn_delete']		= "ลบ";
$lang['btn_edit']		= "แก้ไข";
$lang['btn_next']		= "ถัดไป";
$lang['btn_back']		= "กลับ";
$lang['btn_add']		= "เพิ่ม";
$lang['btn_upload']		= "อัพโหลด";
$lang['btn_view']		= "ดู";
$lang['btn_refresh']		= "รีเฟรชเดี๋ยวนี้";
$lang['option_choose']		= "-- กรุณาเลือก --";
$lang['option_all']		= "-- ทั้งหมด --";
$lang['option_yes']		= "ใช่";
$lang['option_no']		= "ไม่ใช่";
$lang['id_col_table']		= "ไอดี#";
$lang['year_txt']		= "ปี";
$lang['month_txt']		= "เดือน";
$lang['day_txt']		= "วัน";
$lang['btn_ascopy']		= "คัดลอกเป็น";

//Login Page
$lang['login_heading']		= "เข้าสู่ระบบเบื้องหลัง";
$lang['login_email']		= "ที่อยู่อีเมล์";
$lang['login_password']		= "รหัสผ่าน";
$lang['login_signin']		= "เข้าสู่ระบบ";
$lang['login_forgetpwd']	= "ลืมรหัสผ่าน";
$lang['login_incorrect']	= "ที่อยู่อีเมล์/รหัสผ่าน ไม่ถูกต้อง";

//Forgot Password
$lang['forgot_reset']		= "รีเซ็ตรหัสผ่าน";
$lang['forgot_email']		= "ที่อยู่อีเมล์";
$lang['forgot_password']	= "รหัสผ่านใหม่";
$lang['forgot_confirm']		= "ยืนยันรหัสผ่าน";
$lang['forgot_complete']	= "สำเร็จ! รหัสผ่านของคุณเปลี่ยนแปลงเรียบร้อยแล้ว";
$lang['forgot_btn']		= "รีเซ็ตรหัสผ่าน";
$lang['forgot_check_email']	= "กรุณาเช็คอีเมล์ในกล่องขาเข้า. และคลิกลิงค์ที่แนบมาเพื่อทำการรีเซ็ตรหัสผ่าน";

//Dashboard
$lang['dash_welcome']		= "ยินดีต้อนรับเข้าสู่เบื้องหลัง CSZ CMS";
$lang['dash_cur_time']		= "วันที่/เวลา ณ ขณะนี้:";
$lang['dash_message']		= 'นี่คือระบบการจัดการสำหรับผู้ดูแลระบบ, ใช้เพื่อจัดการเนื้อหาทั้งหมดและค่าต่าง ๆ บนเว็บไซต์. ระบบเว็บสำเร็จรูปนี้สร้างอยู่บนพื้นฐานของ Codeigniter และ ออกแบบภายใต้โครงสร้างของ Bootstrap, ระบบนี้รองรับความเข้ากันได้กับทุกขนาดหน้าจอ. ระบบนี้นั้นตั้งอยู่บนพื้นฐานของภาษา PHP บนฝั่งของ Server และใช้ฐานข้อมูล MySQL หรือ MariaDB สำหรับจัดเก็บข้อมูล.<br><br>ระบบนี้คือโอเพนซอร์สสำหรับระบบการจัดการเนื้อหา และทั้งหมดเป็นอิสระภายใต้ใบอนุญาต Astian Develop Public License (ADPL) และ MIT.<br><br>แปลภาษาไทยโดย <a href="https://www.cskaza.com" target="_blank"><b>CSKAZA</b></a>';
$lang['dash_cszcms_link']	= "เว็บไซต์ CSZ CMS อย่างเป็นทางการ";

// EMAILS FORGET PASSWORD
$lang['email_reset_subject']    = "รีเซ็ตรหัสผ่านของคุณ CSZ-CMS";
$lang['email_reset_message']    = "กรุณาคลิกลิงค์ข้างล่างนี้ภายใน 30 นาทีเพื่อทำการรีเซ็ตรหัสผ่านของคุณ.";

// EMAIL TEXT DEFAULT
$lang['email_dear']             = "เรียน ";
$lang['email_footer']           = "ขอแสดงความนับถือ,";

// ERROR MESSAGES
$lang['email_check']		= "ที่อยู่อีเมล์นี้ไม่มีอยู่ในระบบ.";
$lang['required']			= "ฟิวล์ %s จำเป็นต้องใช้.";
$lang['isset']				= "ฟิวล์ %s จะต้องมีค่า.";
$lang['valid_email']		= "ฟิวล์ %s จะต้องมีที่อยู่อีเมลที่ถูกต้อง.";
$lang['valid_emails']		= "ฟิวล์ %s จะต้องมีที่อยู่อีเมลที่ถูกต้องทั้งหมด.";
$lang['valid_url']			= "ฟิวล์ %s จะต้องมี URL ที่ถูกต้อง.";
$lang['valid_ip']			= "ฟิวล์ %s จะต้องมี IP ที่ถูกต้อง.";
$lang['min_length']			= "ฟิวล์ %s จะต้องมีตัวอักษรอย่างน้อย %s ความยาวตัวอักษร.";
$lang['max_length']			= "ฟิวล์ %s จะต้องมีตัวอักษรไม่เกิน %s ความยาวตัวอักษร.";
$lang['exact_length']		= "ฟิวล์ %s ต้องเป็น %s ความยาวตัวอักษรเท่านั้น.";
$lang['alpha']				= "ฟิวล์ %s จะต้องมีตัวหนังสือเท่านั้น.";
$lang['alpha_numeric']		= "ฟิวล์ %s จะต้องมีตัวหนังสือและตัวเลขเท่านั้น.";
$lang['alpha_dash']			= "ฟิวล์ %s จะต้องมีตัวอักษร ตัวเลข, ขีดล่าง, และขีดกลางเท่านั้น.";
$lang['numeric']			= "ฟิวล์ %s จะต้องมีตัวเลขเท่านั้น.";
$lang['is_numeric']			= "ฟิวล์ %s จะต้องมีตัวอักษรที่เป็นตัวเลขเท่านั้น.";
$lang['integer']			= "ฟิวล์ %s จะต้องมีจำนวนเต็ม.";
$lang['regex_match']		= "ฟิวล์ %s ไม่ได้อยู่ในรูปแบบถูกต้อง.";
$lang['matches']			= "ฟิวล์ %s ข้อมูลไม่ตรงกับฟิวล์ %s.";
$lang['is_unique'] 			= "ฟิวล์ %s มีอยู่แล้ว.";
$lang['is_natural']			= "ฟิวล์ %s จะต้องมีตัวเลขบวกเท่านั้น.";
$lang['is_natural_no_zero']	= "ฟิวล์ %s จะต้องมีจำนวนมากกว่าศูนย์.";
$lang['decimal']			= "ฟิวล์ %s จะต้องมีตัวเลขทศนิยม.";
$lang['less_than']			= "ฟิวล์ %s จะต้องมีจำนวนน้อยกว่า %s เท่านั้น.";
$lang['greater_than']		= "ฟิวล์ %s จะต้องมีจำนวนมากกว่า %s เท่านั้น.";
$lang['default_data_remark']		= "คือค่าเริ่มต้นของระบบ. คุณไม่สามารถลบสิ่งนี้ได้.";
$lang['remark_header']		= "หมายเหตุ";

//Social Page
$lang['social_header']			= "การตั้งค่าสังคมออนไลน์";
$lang['social_message']			= "ที่นี่คุณสามารถตั้งค่าการเชื่อมโยงสำหรับบัญชีทางสังคมต่างๆของคุณ เชื่อมโยงเหล่านี้จะปรากฏในพื้นที่ที่ระบุของธีมของคุณ";
$lang['social_enable']			= "ต้องการเปิดใช้งานไอคอน ให้ทำเครื่องหมายในช่องด้านข้าง";
$lang['social_twitter']			= "Twitter";
$lang['social_facebook']		= "Facebook";
$lang['social_google']			= "Google+";
$lang['social_pinterest']		= "Pinterest";
$lang['social_foursquare']		= "Foursquare";
$lang['social_linkedin']		= "LinkedIn";
$lang['social_myspace']			= "Myspace";
$lang['social_soundcloud']		= "Soundcloud";
$lang['social_spotify']			= "Spotify";
$lang['social_lastfm']			= "LastFM";
$lang['social_youtube']			= "YouTube";
$lang['social_vimeo']			= "Vimeo";
$lang['social_dailymotion']		= "DailyMotion";
$lang['social_vine']			= "Vine";
$lang['social_flickr']			= "Flickr";
$lang['social_instagram']		= "Instagram";
$lang['social_tumblr']			= "Tumblr";
$lang['social_reddit']			= "Reddit";
$lang['social_envato']			= "Envato";
$lang['social_github']			= "Github";
$lang['social_tripadvisor']		= "TripAdvisor";
$lang['social_stackoverflow']           = "Stack Overflow";
$lang['social_persona']			= "Mozilla Persona";
$lang['social_odnoklassniki']		= "Odnoklassniki";
$lang['social_vk']                      = "VKontakte";
$lang['social_gitlab']                  = "GitLab";
$lang['social_table_title']		= "เว็บไซต์สังคมออนไลน์";
$lang['social_table_link']		= "ลิงค์ของหน้าโปรไฟล์ของคุณ";
$lang['social_table_active']            = "เปิดใช้งาน";

//Settings Page
$lang['settings_header']		= "การตั้งค่าเว็บไซต์";
$lang['settings_name']			= "ชื่อเว็บไซต์";
$lang['settings_email']			= "อีเมล์ค่าเริ่มต้น";
$lang['settings_keyword']		= "คีย์เวิร์ดค่าเริ่มต้น";
$lang['settings_footer']		= "ข้อความส่วนท้ายของเว็บไซต์";
$lang['settings_theme']			= "ธีมเว็บไซต์";
$lang['settings_lang']			= "ภาษาของระบบเบื้องหลัง";
$lang['settings_add_js']		= "Javascript เพิ่มเติม";
$lang['settings_add_js_remark']		= "Javascript เท่านั้นสำหรับเว็บไซต์ด้านหน้า. ไม่รวม &lt;script&gt;&lt;/script&gt;";
$lang['settings_add_meta']		= "Meta Tag เพิ่มเติม";
$lang['settings_add_meta_remark']	= "Meta เท่านั้นสำหรับเว็บไซต์ด้านหน้า.";
$lang['settings_googlecapt_active']	= "เปิดใช้งาน reCaptcha";
$lang['settings_googlecapt_sitekey']	= "reCaptcha Site Key";
$lang['settings_googlecapt_secretkey']	= "reCaptcha Secret Key";
$lang['settings_googlecapt_remark']	= 'คุณสามารถรับคีย์ของ reCaptcha ได้ที่ <a href="https://www.google.com/recaptcha" target="_blank">https://www.google.com/recaptcha</a>';
$lang['settings_logo']			= "เว็บโลโก้";
$lang['settings_logo_remark']		= "เว็บโลโก้มีความสูงไม่เกิน 50 พิกเซลสำหรับแม่แบบเริ่มต้น";
$lang['settings_pagecache_time']	= "ควบคุมเวลาหน้าแคช";
$lang['settings_pagecache_time_min']	= "นาที";
$lang['settings_pagecache_time_off']	= "ปิด";
$lang['settings_pagecache_time_remark']	= "ใช้ค่าน้อย สำหรับเว็บไซต์ที่มีการเปลี่ยนแปลงบ่อย<br>หากใช้ค่ามาก สำหรับการเปลี่ยนแปลงเว็บไซต์ไม่บ่อยนักและต้องการประสิทธิภาพในการโหลดหน้าเว็บ";
$lang['settings_email_header']          = "การตั้งค่าอีเมล์";
$lang['settings_email_protocal']        = "Email Protocal";
$lang['settings_smtp_host']             = "SMTP Host";
$lang['settings_smtp_user']             = "SMTP Username";
$lang['settings_smtp_pass']             = "SMTP Password";
$lang['settings_smtp_port']             = "SMTP Port";
$lang['settings_sendmail_path']         = "Sendmail Path";
$lang['settings_email_testbtn']          = "ทดสอบส่ง!";
$lang['settings_sitemap_header']        = "สร้างไฟล์ Sitemaps";
$lang['settings_sitemap_runnow']        = "เริ่มเดี๋ยวนี้";
$lang['settings_sitemap_lasttime']      = "อัพเดทล่าสุด";
$lang['settings_member_header']          = "การตั้งค่าสมาชิก";
$lang['settings_member_confirm_active']	= "เปิดใช้งานอีเมล์ยืนยันการสมัครสมาชิกใหม่";
$lang['settings_member_close_regist']	= "ปิดการสมัครสมาชิก";
$lang['settings_og_image']		= "รูปภาพของ og metatag (og:image)";
$lang['settings_fbappid_header']	= "การตั้งค่า Facebook";
$lang['settings_fbapp_id']		= "FB App ID";
$lang['settings_fbappid_remark']	= 'คุณสามารถรับ FB App ID ได้ที่ <a href="https://developers.facebook.com/apps" target="_blank">https://developers.facebook.com/apps</a>';
$lang['settings_google_config']		= "การตั้งค่า Google API";
$lang['settings_ga_client_id']		= "Google API Client ID";
$lang['settings_ga_client_id_remark']	= 'จะสร้าง Google API Console project และ client ID ได้อย่างไร? <a href="https://developers.google.com/identity/sign-in/web/devconsole-project" target="_blank"><b>ดูที่นี่</b></a>';
$lang['settings_ga_view_id']		= "Google Analytics View ID";
$lang['settings_ga_view_id_remark']	= 'คุณสามารถดู view ID ได้ที่ <a href="https://ga-dev-tools.appspot.com/query-explorer/" target="_blank"><b>คลิกที่นี่</b></a>. หลังจากคุณ "Access Google Analytics" และเลือกข้อมูล analytics ของเว็บไซต์คุณ. กรุณาดู view ID ของคุณได้ที่ "ids"';
$lang['settings_gsearch_active']	= "เปิดใช้งาน Google Custom Search";
$lang['settings_gsearch_cxid']          = "ไอดี search engine ของคุณ (cx ID)";
$lang['settings_gsearch_remark']	= 'คุณสามารถดูได้ที่ <a href="https://developers.google.com/custom-search/docs/tutorial/introduction" target="_blank"><b>เรียนรู้ Google Custom Search</b></a>.';
$lang['settings_maintenance_active']    = "เปิดการทำงานโหมดบำรุงรักษา";
$lang['settings_html_optimize_disable']    = "ปิดการใช้งานการเพิ่มประสิทธิภาพ html";
$lang['settings_gmaps_key']		= "Google Maps API Key";
$lang['settings_gmaps_key_remark']	= 'จะสามารถสร้าง Google API key ได้อย่างไร? <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank"><b>See here</b></a>';
$lang['settings_gmaps_lat']		= "ละติจูดค่าเริ่มต้น";
$lang['settings_gmaps_lng']		= "ลองจิจูดค่าเริ่มต้น";
$lang['settings_facebook_page_id']	= "Facebook Pages ID";
$lang['settings_facebook_page_id_remark']	= "คุณสามารถรับ Facebook Pages ID ได้ที่ส่วน 'Page ID' ในหน้า 'About' จาก Facebook Pages ของคุณ";
$lang['settings_assets_static_domain']	= "แหล่งข้อมูลแบบคงที่จากโดเมน cdn อื่นสำหรับ asset";
$lang['settings_assets_static_domain_remark']	= "(ตัวอย่าง: https://cdn.cszcms.com) โดเมนแบบคงที่นี้ต้องใช้เส้นทางเดียวกับโดเมนต้นทาง";
$lang['settings_fb_messenger']		= "เปิดใช้งาน Facebook Messenger";
$lang['settings_fb_messenger_remark']	= 'วิธีการเพิ่มโดเมนของเว็บไซต์ของคุณไว้ในหน้า Facebook ของคุณ? <a href="https://developers.facebook.com/docs/messenger-platform/discovery/customer-chat-plugin#steps" target="_blank"><b>คลิกที่นี่</b></a>';
$lang['settings_email_logs']		= "เปิดการใช้งานบันทึกของอีเมล์";
$lang['settings_titlesetting']		= "การตั้งค่าชื่อเว็บไซต์";
$lang['settings_titlesetting_first']		= "ก่อน";
$lang['settings_titlesetting_last']		= "หลัง";
$lang['settings_cookie_info_text']		= "Cookie Privacy Info";
$lang['settings_cookie_info_active']		= "เปิดใช้งาน Cookie Privacy Info";
$lang['settings_cookie_info_bg']		= "สีพื้นหลัง Cookie Info";
$lang['settings_cookie_info_fg']		= "สีตัวหนังสือด้านหน้า Cookie Info";
$lang['settings_cookie_info_link']		= "สีลิงค์ข้อความ Cookie Info";
$lang['settings_cookie_info_msg']		= "ข้อความ Cookie Info";
$lang['settings_cookie_info_linkmsg']		= "ข้อความลิงค์ Cookie Info";
$lang['settings_cookie_info_linkurl']		= "ลิงค์นโยบายความเป็นส่วนตัว Cookie Info";
$lang['settings_cookie_info_txtalign']		= "ตำแหน่งตัวหนังสือ Cookie Info";
$lang['settings_cookie_info_txtalign_left']		= "ชิดซ้าย";
$lang['settings_cookie_info_txtalign_center']		= "กึ่งกลาง";
$lang['settings_cookie_info_txtalign_right']		= "ชิดขวา";
$lang['settings_cookie_info_closetxt']		= "ข้อความปุ่มปิด Cookie Info";

//Navigation Page
$lang['navpage_header']                 = "เมนูหลัก";
$lang['navpage_dropmenu']                 = "เมนูแบบเลื่อนลง";
$lang['navpage_new_header']		= "เมนูใหม่";
$lang['navpage_edit_header']		= "แก้ไขเมนูหลัก";
$lang['navpage_menulang']		= "ภาษาของเมนู";
$lang['navpage_menuname']		= "ชื่อเมนู";
$lang['navpage_type']			= "ประเภทเมนู";
$lang['navpage_pagelink']		= "ลิงค์หน้า";
$lang['navpage_pluginmenu']		= "เมนูปลั๊กอิน";
$lang['navpage_link']			= "ลิงค์อื่น ๆ";
$lang['navpage_delete_btn']		= "ลบ";
$lang['navpage_edit_btn']                  = "แก้ไข";
$lang['delete_message']            = "คุณแน่ใจที่จะดำเนินการสิ่งนี้?";
$lang['navpage_addnew']			= "เมนูใหม่";
$lang['navpagesub_header']                 = "เมนูย่อย";
$lang['navpagesub_desc']                 = "เมนูย่อยสำหรับเมนูแบบเลื่อนลง";
$lang['navpage_new_windows']            = "หน้าต่างใหม่";
$lang['navpage_position']            = "ตำแหน่ง";
$lang['navpage_index_remark_txt']       = "เมนูแรกของรายการเป็นค่าเริ่มต้นสำหรับหน้า (เฉพาะตำแหน่งบนสุดเท่านั้น).";

//Navigation Position
$lang['navpage_position_top']            = "ด้านบนสุด";
$lang['navpage_position_bottom']            = "ด้านล่างสุด";

//Langs - All Langs
$lang['lang_header']			= "ภาษา";
$lang['lang_name']			= "ชื่อภาษา";
$lang['lang_iso']			= "ตัวย่อภาษา";
$lang['lang_country']			= "ชื่อประเทศ";
$lang['lang_country_iso']		= "ตัวย่อประเทศ (ธง)";
$lang['lang_delete_message']            = "คุณแน่ใจที่จะดำเนินการสิ่งนี้? แน่ใจว่าไม่ใช่ภาษาเริ่มต้นของระบบ.";
$lang['lang_delete_default']              = "ไม่สามารถลบได้! นี้คือภาษาเริ่มต้นของระบบ.";
$lang['lang_addnew']			= "เพิ่มภาษาใหม่";
$lang['lang_index_remark_txt']              = "คือภาษาพื้นฐานของระบบ. คุณไม่สามารถลบได้!<br>ภาษาแรกสุดของรายการคือภาษาเริ่มต้นสำหรับส่วนด้านหน้าเว็บ.";

//Langs - New Lang/Edit Lang
$lang['lang_new_header']		= "เพิ่มภาษาใหม่";
$lang['lang_edit_header']		= "แก้ไขภาษา";
$lang['lang_active']                    = "เปิดใช้งาน";
$lang['lang_countryiso_remark']		= 'คุณสามารถดูรายการตัวย่อ ISO ของประเทศ (ความยาว 2 ตัวอักษร) ได้ที่ - <a href="http://www.nationsonline.org/oneworld/country_code_list.htm" target="_blank" rel="nofollow external">คลิกที่นี่</a>';
$lang['lang_iso_remark']		= 'คุณสามารถดูรายการตัวย่อ ISO ของภาษา (ความยาว 2 ตัวอักษร) ได้ที่ - <a href="https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes" target="_blank" rel="nofollow external">คลิกที่นี่</a>';

//Pages - All Pages
$lang['pages_header']			= "หน้าเนื้อหา";
$lang['pages_name']			= "ชื่อของหน้า";
$lang['pages_title']                    = "Title ของหน้า";
$lang['pages_lang']                     = "ภาษา";
$lang['pages_delete_message']            = "คุณแน่ใจที่จะดำเนินการสิ่งนี้? แน่ใจว่าไม่ใช่หน้าเริ่มต้นของระบบ.";
$lang['pages_delete_default']              = "ไม่สามารถลบได้! นี้คือหน้าเริ่มต้นของระบบ..";
$lang['pages_addnew']			= "เพิ่มหน้าใหม่";

//Pages - New Pages/Edit Pages
$lang['pages_new_header']		= "เพิ่มหน้าใหม่";
$lang['pages_edit_header']		= "แก้ไขหน้า";
$lang['pages_active']                    = "เปิดใช้งาน";
$lang['pages_keywords']                    = "คีย์เวิร์ดสำหรับหน้า";
$lang['pages_desc']                    = "รายละเอียดสำหรับหน้า";
$lang['pages_content']                    = "เนื้อหาของหน้า";
$lang['pages_custom_css']                    = "CSS ที่กำหนดเอง";
$lang['pages_custom_js']                    = "JS ที่กำหนดเอง";
$lang['pages_user_groups_id']                    = "กลุ่มผู้ใช้สามารถเข้าถึงหน้านี้เท่านั้น";

//Captcha
$lang['captcha_text']             = "ตรวจสอบความปลอดภัย (กรุณาระบุตัวอักษรที่เห็นบนรูปภาพ)";
$lang['captcha_wrong']             = "การตรวจสอบความปลอดภัยที่ระบุไม่ถูกต้อง. กรุณาเริ่มใหม่.";

//Uploadfile Page
$lang['uploadfile_header']                 = "อัพโหลดไฟล์";
$lang['uploadfile_filenotfound']           = "ไม่พบไฟล์. กรุณาใช้เครื่องมืออัพโหลด.";
$lang['uploadfile_thumbnail']           = "รูปขนาดย่อ";
$lang['uploadfile_download']           = "ดาวน์โหลด";
$lang['uploadfile_filename']           = "ชื่อไฟล์";
$lang['uploadfile_urlpath']           = "ที่อยู่ไฟล์:";
$lang['uploadfile_uploadtime']           = "วันที่/เวลา อัพโหลด";
$lang['uploadfile_uploadtools']           = "เครื่องมืออัพโหลด";
$lang['uploadfile_add_file']           = "เพิ่มไฟล์";
$lang['uploadfile_fileallow']           = "สำหรับไฟล์ (jpg, jpeg, png, gif, pdf, doc, docx, odt, txt, odg, odp, ods, zip, rar, psv, xls, xlsx, ppt, pptx, mp3, wav, mp4, wma, flv, avi, mov, m4v, wmv, m3u, pls) เท่านั้นจะได้รับอนุญาต. ขนาดของภาพไม่เกิน 1900px กับความกว้างหรือความสูง.";

//Forms Builder Index
$lang['forms_header']                   = "สร้างแบบฟอร์ม";
$lang['forms_notfound']                 = "ไม่พบแบบฟอร์ม. กรุณาสร้างแบบฟอร์ม.";
$lang['forms_addnew']			= "แบบฟอร์มใหม่";
$lang['forms_edit']			= "แก้ไขแบบฟอร์ม";
$lang['forms_name']			= "ชื่อฟอร์ม";
$lang['forms_method']			= "ฟอร์ม Method";
$lang['forms_enctype']			= "ฟอร์ม enctype";
$lang['forms_delete_msg']            = "คุณแน่ใจที่จะดำเนินการสิ่งนี้?";
$lang['forms_sendmail']			= "เปิดการส่งอีเมล์";
$lang['forms_captcha']			= "เปิดการตรวจสอบความปลอดภัย";
$lang['forms_email']			= "ที่อยู่อีเมล์ที่จะส่งถึง";
$lang['forms_subject']			= "หัวข้ออีเมล์";
$lang['forms_indexremark']		= "<i>กรุณาใช้ Tag นี้ในการเพิ่มแบบฟอร์มเข้าไปยังหน้าเนื้อหา. กรุณาดูที่ชื่อฟอร์ม<br><b>Tag:</b></i> [?]{=forms:<b>forms_name</b>}[?]<br><b>หมายเหตุสำคัญ: สามารถใช้ได้หนึ่งฟอร์มต่อหนึ่งหน้าเท่านั้น!</b>";
$lang['forms_view']			= "ดูแบบฟอร์มที่โพสต์";
$lang['forms_success_txt']		= "ข้อความแสดงว่าสำเร็จ";
$lang['forms_captchaerror_txt']		= "ข้อความแสดงว่า Captcha ผิด";
$lang['forms_error_txt']		= "ข้อความแสดงข้อผิดพลาด";
$lang['forms_send_to_visitor']		= "ส่งอีเมล์ถึงผู้เยี่ยมชม";
$lang['forms_email_field_name']		= "อีเมล์ถึง ฟิล name";
$lang['forms_visitor_subject']		= "หัวข้ออีเมล์";
$lang['forms_visitor_body']		= "เนื้อหาอีเมล์";
$lang['forms_visitor_newtxt']		= "ส่งอีเมล์ถึงผู้เยี่ยมชม. กรุณาแก้ไขแบบฟอร์มนี้";
$lang['forms_save_to_db']		= "เปิดการใช้งาน บันทึกลง DB";
$lang['forms_dont_repeat_field']		= "อย่าทำซ้ำในชื่อฟิลด์นี้";
$lang['forms_repeat_txt']		= "ข้อความแจ้งเตือนการซ้ำ";

//Field Text
$lang['field_header']                   = "เพิ่มฟิล";
$lang['field_editheader']               = "แก้ไขฟิล";
$lang['field_type']			= "ประเภทของฟิล";
$lang['field_name']			= "ฟิล Name";
$lang['field_id']			= "ฟิล ID";
$lang['field_class']			= "ฟิล Class";
$lang['field_placeholder']		= "ฟิล Placeholder";
$lang['field_value']                    = "ฟิล Value";
$lang['field_label']                    = "ฟิล Label";
$lang['sel_option_val']                 = "Value สำหรับ Select/Option";
$lang['sel_option_val_info']            = "ตัวอย่าง, ถ้าคุณต้องการระบุค่าสำหรับตัวเลือก คือ 'value' และโชว์ตัวเลือก คือ 'Show' คุณสามารถระบุได้ดังตัวอย่างนี้ ตัวอย่าง value1=>Show1, value2=>Show2. ถ้าประเภทของฟิลคือ 'file' คุณสามารถใส่สกุลไฟล์ที่อนุญาตได้ที่นี่. (ตัวอย่าง .txt, .docx). ถ้าประเภทของฟิลคือ 'number' คุณสามารถใส่ max=>min";
$lang['field_require']                  = "ฟิล Required";
$lang['field_addtxtinfo']               = '<span class="remark">กด <i class="glyphicon glyphicon-plus"></i> เพื่อสร้างฟิลเพิ่มเติม.</span>';
$lang['field_div_class']                  = "Div Class";

//Form Post Data
$lang['formpost_notfound']                 = "ไม่พบฟอร์มโพสต์.";
$lang['formpost_ipaddress']                 = "ที่อยู่ไอพี";

//Upgrade
$lang['upgrade_header']			= "ระบบการอัพเกรดอัตโนมัติ";
$lang['btn_upgrade']			= "เริ่มการอัพเกรด";
$lang['upgrade_curver']			= "เวอร์ชั่นปัจจุบัน:";
$lang['upgrade_lastver']		= "เวอร์ชั่นล่าสุด:";
$lang['upgrade_newlast_alert']          = "CSZ-CMS มีเวอร์ชั่นอัพเกรดมาใหม่. กรุณาอัพเกรดเดี๋ยวนี้!";
$lang['upgrade_lastver_alert']          = "CSZ-CMS ของคุณคือเวอร์ชั่นล่าสุดแล้ว!";
$lang['upgrade_success_alert']          = "อัพเกรดเสร็จสมบูรณ์!";
$lang['upgrade_error_alert']            = "อัพเกรดผิดพลาด!";
$lang['upgrade_text']                   = "<b>สำคัญมาก!</b> กรุณาสำรองฐานข้อมูลและไฟล์ที่คุณแก้ไข ก่อนที่จะทำการอัพโหลด! กรุณาอัพเกรดทันทีสำหรับเวอร์ชั่นล่าสุด";
$lang['manual_upgrade']			= "ระบบการอัพเกรดด้วยตนเอง";
$lang['logs_download_header']		= "Error Logs ดาวน์โหลด";
$lang['btn_logs_download']		= "ดาวน์โหลด!";
$lang['btn_clear_logs']                 = "ล้าง Error Logs ทั้งหมด";

//Optimize Database
$lang['maintenance_header']             = "ระบบบำรุงรักษา";
$lang['btn_clearallcache']              = "ล้างแคชของหน้าทั้งหมด";
$lang['btn_clearalldbcache']              = "ล้างแคชของ DB ทั้งหมด";
$lang['database_maintain_header']	= "บำรุงรักษาฐานข้อมูล";
$lang['optimize_success_alert']         = "เพิ่มประสิทธิภาพฐานข้อมูลเรียบร้อยแล้ว!";
$lang['optimize_error_alert']           = "เพิ่มประสิทธิภาพฐานข้อมูลมีข้อผิดพลาด!";
$lang['btn_optimize_db']		= "เพิ่มประสิทธิภาพฐานข้อมูล";
$lang['btn_backup_db']			= "การสำรองฐานข้อมูล";
$lang['clearallcache_success_alert']    = "ล้างแคชของหน้าทั้งหมดเรียบร้อยแล้ว!";
$lang['clearalldbcache_success_alert']    = "ล้างแคชของ DB ทั้งหมดเรียบร้อยแล้ว!";
$lang['btn_clear_sess']                 = "ล้าง Session ทั้งหมด";
$lang['clear_sess_message']            = "หลังจากที่เซสชั่นได้รับการล้างแล้ว กรุณาเข้าสู่ระบบอีกครั้ง คุณต้องการที่จะทำเช่นนี้?";
$lang['btn_backup_file']		= "การสำรองไฟล์สำคัญ";
$lang['btn_backup_photo']		= "การสำรองอัพโหลดรูปภาพ";

//Link Statistic
$lang['linkstats_header']             = "สถิติสำหรับลิงค์";
$lang['linkstats_newbtn']               = "สร้างลิงค์ใหม่";
$lang['linkstats_url']                 = "URL";
$lang['linkstats_dateime']              = "วันที่/เวลา";
$lang['linkstats_count']                = "จำนวนคลิก";
$lang['ip_address']                      = "ที่อยู่ไอพี";
$lang['data_notfound']                 = "ไม่พบข้อมูล.";
$lang['startdate_field']                = "เริ่มต้นวันที่";
$lang['enddate_field']                = "สิ้นสุดวันที่";
$lang['search']                         = "ค้นหา";
$lang['total']                         = "ทั้งหมด:";
$lang['records']                         = "รายการ";

//General Label
$lang['genlabel_header']             = "ฉลากทั่วไป";
$lang['genlabel_name']			= "ชื่อฉลาก";
$lang['genlabel_lang']			= "ภาษาของส่วนหน้าเว็บ";
$lang['genlabel_synclang_success']	= "ภาษาฉลากตรงกันเรียบร้อยแล้ว!";
$lang['btn_label_synclang']             = "ปรับภาษาให้ตรงกัน";

//Langs - New Lang/Edit Lang
$lang['genlabel_edit_header']		= "แก้ไขฉลากทั่วไป";
$lang['genlabel_plssync_alert']             = "กรุณาคลิก 'ปรับภาษาให้ตรงกัน' เดี๋ยวนี้!";

// Messages Alert
$lang['success_message_alert']		= "สำเร็จเรียบร้อยแล้ว!";
$lang['error_message_alert']		= "มีข้อผิดพลาด! กรุณาเริ่มใหม่อีกครั้ง.";

// Plugin Manager
$lang['pluginmgr_header']               = "จัดการปลั๊กอิน";
$lang['pluginmgr_name']                 = "ชื่อปลั๊กอิน";
$lang['pluginmgr_version']                 = "เวอร์ชั่นปลั๊กอิน";
$lang['pluginmgr_owner']                 = "ผู้ผลิตปลั๊กอิน";
$lang['pluginmgr_install']              = "ติดตั้งปลั๊กอิน";
$lang['btn_install']                    = "ติดตั้ง";
$lang['pluginmgr_zip_remark']              = "เฉพาะไฟล์ zip เท่านั้น ที่อนุญาต.";
$lang['pluginmgr_status']              = "สถานะปลั๊กอิน";
$lang['pluginmgr_enable']               = "เปิดการใช้งาน";
$lang['pluginmgr_disable']               = "ปิดการใช้งาน";
$lang['pluginmgr_manage']               = "จัดการ";
$lang['pluginmgr_store']               = "ศูนย์รวมปลั๊กอิน";
$lang['pluginmgr_config_filename']                 = "ชื่อไฟล์ปลั๊กอิน";
$lang['pluginmgr_desc']               = "รายละเอียด";
$lang['pluginmgr_upgrade']               = "อัพเกรด";
$lang['pluginmgr_latest_version']                 = "เวอร์ชั่นล่าสุด";
$lang['pluginmgr_latest_already']                 = "ปลั๊กอินของคุณเป็นเวอร์ชันล่าสุดแล้ว!";

// Widget Builder
$lang['widget_header']               = "Widgets ปลั๊กอิน ด้วย XML";
$lang['widget_new_header']		= "สร้าง Widget";
$lang['widget_edit_header']		= "แก้ไข Widget";
$lang['widget_active']                    = "เปิดการใช้งาน";
$lang['widget_name']                 = "ชื่อ Widget";
$lang['widget_xml_url']                 = "Widget XML URL";
$lang['widget_limit_view']                 = "จำกัดการแสดงผล";
$lang['widget_widget_open']                 = "HTML ส่วนเปิด";
$lang['widget_widget_content']                 = "HTML ส่วนเนื้อหา";
$lang['widget_widget_seemore']                 = "HTML ปุ่มดูเพิ่มเติม";
$lang['widget_widget_close']                 = "HTML ส่วนปิด";
    $lang['widget_indexremark']		= "<i>กรุณาใช้ Tag นี้ในการเพิ่ม widget ปลั๊กอินเข้าไปยังหน้าเนื้อหา. กรุณาดูที่ไอดี widget<br><b>Tag:</b></i> [?]{=widget:<b>widget_ID</b>}[?]";

// Facebook Comments
$lang['fb_comment_active']               = "เปิดใช้งาน Facebook Comments";
$lang['fb_comment_limit']               = "จำกัด Comments ที่แสดง";
$lang['fb_comment_sort']                = "การจัดเรียง Facebook Comment";
$lang['fb_comment_sort_top']                = "ยอดนิยม";
$lang['fb_comment_sort_newest']                = "ล่าสุด";
$lang['fb_comment_sort_oldest']                = "เก่าสุด";

// Brute force login protection
$lang['bf_protection_header']                = "การป้องกัน Brute Force";
$lang['bf_period_time']                = "ระยะเวลาในการป้องกัน Brute Force (เป็นนาที)";
$lang['bf_max_fail']                    = "ความล้มเหลวเข้าสู่ระบบสูงสุด (ในระยะเวลา)";
$lang['bf_white_list']                    = "Whitelist IP Address";
$lang['bf_black_list']                    = "Blacklist IP Address";
$lang['bf_note']                    = "หมายเหตุ";
$lang['bf_ip_banned_alert']           = "ที่อยู่ไอพีของคุณถูกสั่งห้าม!";
$lang['bf_settings']                    = "การตั้งค่าการป้องกัน";
$lang['loginlogs_header']	= "บันทึกการเข้าสู่ระบบ";
$lang['actionslogs_header']               = "บันทึกการกระทำ";
$lang['loginlogs_result']                    = "ผลลัพธ์";
$lang['emaillogs_header']               = "บันทึกระบบอีเมล์";
$lang['bf_private_key']               = "กุญแจส่วนตัว";
$lang['bf_gen_private_key']               = "สร้างกุญแจส่วนตัว";
$lang['bf_gen_private_key_confirm']            = "คุณต้องการดำเนินการสิ่งนี้หรือไม่? โปรดเปลี่ยนคีย์ส่วนตัวทุกที่ที่จำเป็นหลังจากสร้างคีย์ส่วนตัวแล้ว.";

// Private Message
$lang['pm_header']                = "ข้อความส่วนตัว";
$lang['pm_nomsg_alert']                = "ไม่มีข้อความ!";
$lang['pm_unread_txt']                    = "คุณมี %d ข้อความที่ไม่ได้อ่าน";
$lang['pm_seeall_msg']                    = "ดูข้อความทั้งหมด";
$lang['pm_to']                    = "ถึง";
$lang['pm_from']                    = "จาก";
$lang['pm_subject']                    = "หัวข้อ";
$lang['pm_message']                    = "ข้อความ";
$lang['pm_send']                    = "ส่ง";
$lang['pm_inbox']                    = "กล่องขาเข้า";
$lang['pm_new_msg']                    = "เขียนข้อความใหม่";

// Banner Mgt
$lang['banner_header']                = "การจัดการแบนเนอร์";
$lang['banner_new']             = "แบนเนอร์ใหม่";
$lang['banner_edit']             = "แก้ไขแบนเนอร์";
$lang['banner_name']                 = "ชื่อแบนเนอร์";
$lang['banner_img']                 = "รูปแบนเนอร์";
$lang['banner_width']                 = "กว้าง";
$lang['banner_height']                 = "ยาว";
$lang['banner_link']                 = "ลิงค์";
$lang['banner_count']                = "จำนวนคลิ๊ก";
$lang['banner_date_period']            = "ช่วงของวันที่";
$lang['banner_nofollow']            = "ลิงค์ No-Follow";
$lang['banner_expired']            = "แบนเนอร์หมดอายุ";
$lang['banner_indexremark']		= "<i>กรุณาใช้แท็กนี้เพื่อเพิ่มลงไปในเนื้อหา. กรุณาดูที่แบนเนอร์ไอดี#<br><b>แท็ก:</b></i> [?]{=banner:<b>banner_id</b>}[?]";

// Export CSV
$lang['export_csv_header']                = "ส่งออก CSV";
$lang['db_table_name']                = "ชื่อตาราง";
$lang['export_csv_field_sel']                = "เลือกฟิลด์";
$lang['export_csv_field_sel_remark']                = "หากต้องการส่งออกข้อมูลทั้งหมด โปรดเว้นช่อง 'เลือกฟิลด์' นี้ไว้ และคลิกที่ปุ่มเพื่อส่งออก";
$lang['export_csv_orderby']                = "จัดเรียงตาม";
$lang['export_csv_btn']                = "ส่งออกเป็น CSV";
$lang['export_import_csv_btn']                = "ส่งออก/นำเข้า CSV";

// Import CSV
$lang['import_csv_header']                = "นำเข้า CSV";
$lang['import_csv_upload']                = "อัพโหลด CSV";
$lang['import_csv_btn']                = "นำเข้าเดี๋ยวนี้";
$lang['import_csv_upload_remark']            = 'ไฟล์ CSV สามารถนำเข้าเฉพาะประเภท UTF-8 เท่านั้น. สามารถใช้ตัวคั่น (,) และอักขระ Newline (\\n) และ Enclosure (") เท่านั้น';
$lang['import_csv_ignore']            = "การตรวจสอบคีย์หลักสำหรับการแทรก (ข้อมูลถูกแทรกลงในฐานข้อมูลโดยไม่ต้องป้อนคีย์หลัก)";

// File Manager
$lang['filemanager_header']                = "การจัดการไฟล์";
$lang['settings_other_api']                = "API อื่น ๆ";
$lang['filemanager_cc_apikey']                = "Adobe Creative Cloud API Key";
$lang['filemanager_cc_apikey_remark']                = 'ตั้งค่าคีย์ API เพื่อเปิดใช้งานโปรแกรมแก้ไขรูปภาพ Creative Cloud สำหรับตัวจัดการไฟล์ elFinder. ดูรายละเอียดเพิ่มเติมได้ที่ <a href="https://console.adobe.io/" target="_blank" rel="nofollow external">https://console.adobe.io/</a>';
$lang['filemanager_template_name']                = "ชื่อเทมเพลท";
$lang['filemanager_template_create']                = "สร้างเทมเพลท";

// Server Status
$lang['serverstatus_header']                = "สถานะเซิร์ฟเวอร์";
$lang['serverstatus_phpmem_use']                = "การใช้หน่วยความจำ PHP";
$lang['serverstatus_disk_use']                = "การใช้พื้นที่ดิสก์";
$lang['serverstatus_os']                = "OS";
$lang['serverstatus_php_version']                = "เวอร์ชั่น PHP";
$lang['serverstatus_php_disabled']                = "ฟังก์ชัน PHP ที่ปิดการใช้งาน";

// Carousel Widget
$lang['carousel_header']                = "Widget ของ Carousel";
$lang['carousel_new']             = "Carousel ใหม่";
$lang['carousel_edit']             = "แก้ไข Carousel";
$lang['carousel_name']                 = "ชื่อ Carousel";
$lang['carousel_picture']                = "อัพโหลดรูปภาพ";
$lang['carousel_fileallow']              = "สำหรับไฟล์ (jpg, jpeg, png, gif) เท่านั้นจะได้รับอนุญาต. ขนาดของภาพไม่เกิน 1900px กับความกว้างหรือความสูง.";
$lang['carousel_caption']                = "คำอธิบายภาพ";
$lang['carousel_indexremark']		= "<i>กรุณาใช้ Tag นี้ในการเพิ่ม Carousel เข้าไปยังหน้าเนื้อหา. กรุณาดูที่ไอดี Carousel<br><b>Tag:</b></i> [?]{=carousel:<b>carousel_id</b>}[?]";
$lang['carousel_addremark']                = "อัปโหลดภาพ โปรดแก้ไข carousel นี้.";
$lang['carousel_youtube_head']            = "เพิ่ม Youtube ใหม่";
$lang['carousel_youtube_url']            = "Youtube URL";
$lang['carousel_url_head']            = "เพิ่ม URL รูปภาพใหม่";
$lang['carousel_photo_url']            = "URL รูปภาพ";
$lang['carousel_customtemp_active']            = "เปิดใช้งานเทมเพลตที่กำหนดเอง";
$lang['carousel_customtemp_txt']            = "HTML เทมเพลตที่กำหนดเอง";

// PLugin Widget
$lang['pwidget_header']               = "วิดเจ็ตปลั๊กอิน";
$lang['pwidget_new_header']		= "เพิ่มวิดเจ็ตใหม่";
$lang['pwidget_edit_header']		= "แก้ไขวิดเจ็ด";
$lang['pwidget_active']                    = "เปิดใช้งาน";
$lang['pwidget_name']                    = "ชื่อ";
$lang['pwidget_plugin']                    = "ชื่อปลั๊กอิน";
$lang['pwidget_limit_view']                    = "จำกัดการแสดงผล";
$lang['pwidget_main_short_code']                    = "โค๊ดสั้นหลัก";
$lang['pwidget_loop_short_code']                    = "โค๊ดสั้น ๆ สำหรับภายในลูปเท่านั้น";
$lang['pwidget_gen_short_code']                    = "สร้างโค๊ดสั้น!";
$lang['pwidget_sort_by']                    = "เรียงโดย";
$lang['pwidget_body']                    = "เนื้อหาของเทมเพลต";
$lang['pwidget_indexremark']		= "<i>โปรดใช้แท็กนี้เพื่อแทรกวิดเจ็ตปลั๊กอินลงในเนื้อหา โปรดมอง ID#<br><b>แท็ค:</b></i> [?]{=pwidget:<b>ID#</b>}[?]";
$lang['pwidget_plugin_view_id']                    = "ID หน้าวิวของปลั๊กอิน";
