<?php
//Backend System
$lang['backend_system']		= "Zona Administrativa";

//Dashboard
$lang['dashboard_totalemail']	= "Todos los registros de email";
$lang['dashboard_totallink']	= "Todos los registros de estadisticas";
$lang['dashboard_totalmember']	= "Todos los miembros";
$lang['dashboard_viewdetail']	= "Ver detallles";
$lang['dashboard_linkrecent']	= "Registros recientes de estadisticas";
$lang['dashboard_emailrecent']	= "Registros recientes de los Correos Electronicos";
$lang['dashboard_toemail']	= "A";
$lang['dashboard_fromemail']	= "Desde";
$lang['dashboard_rssnews']	= "Noticias Recientes de CSZ CMS";

//Navigation Bar
$lang['nav_dash']		= "Centro de Control";
$lang['nav_view_site']		= "Ver Sitio";
$lang['nav_general_menu']       = "Menu General";
$lang['nav_content_menu']       = "Menu de Contenido";
$lang['nav_admin_users']	= "Usuarios";
$lang['nav_nav_header']         = "Navigación";
$lang['nav_logout']		= "Salir";
$lang['nav_gel_settings']	= "Menu General";
$lang['nav_analytics']		= "Analisis";

// Google Analytics
$lang['ga_last30']		= "Ultimos 30 dias de Google Analytics";
$lang['ga_maps']		= "Mapa de Google Analytics";
$lang['ga_sessions']            = "Sesiones de Google Analytics";
$lang['ga_devices']		= "Dispositivos en Google Analytics";
$lang['ga_sources']		= "Fuentes en Google Analytics";
$lang['ga_refer']               = "Referencias en Google Analytics";
$lang['ga_allpage']               = "Google Analytics All Pages Content";
$lang['ga_no_settings']         = 'Google Analytics no está configurado dirijase a <a href="'.get_instance()->Csz_model->base_link().'/'.'admin/settings#ga_client_id" title="Site Settings"><b>Site Settings</b></a>!';

//Users - All Users
$lang['user_header']			= "Todos los usuarios";
$lang['user_status']			= "Estado";
$lang['user_name']			= "Mostrar Nombre";
$lang['user_email']			= "Dirección de Correo Electronico";
$lang['user_delete_btn']		= "Eliminar";
$lang['user_edit_btn']                  = "Editar";
$lang['user_delete_message']            = "¿Esta seguro que desea eliminar este registro? Asegúrese de que ésta no sea la única cuenta de usuario.";
$lang['user_delete_myacc']              = "¡No elimine! Esta es su cuenta de usuario.";
$lang['user_addnew']			= "Nuevo usuario";

//Users - New User/Edit User
$lang['user_new_header']		= "Nuevo Usuario";
$lang['user_edit_header']		= "Editar Usuario";
$lang['user_new_name']                  = "Mostrar Nombre";
$lang['user_new_email']			= "Dirección de Correo Electronico";
$lang['user_cur_pass']			= "Contraseña Actual";
$lang['user_new_pass']			= "Nueva Contraseña";
$lang['user_new_confirm']		= "Confirmar Contraseña";
$lang['user_new_active']		= "Activo";
$lang['user_new_deactive']		= "Desactivado";
$lang['user_new_type']                  = "Tipos de Usuario";
$lang['user_first_name']                = "Primer Nombre";
$lang['user_last_name']                 = "Ultimo Apellido";
$lang['user_birthday']                  = "Fecha de Cumpleaños";
$lang['user_gender']                    = "Genero";
$lang['user_address']                   = "Dirección";
$lang['user_phone']                     = "Telefono";
$lang['user_picture']                   = "Imagen";
$lang['user_backend_visitor']           = "Visitante de zona administrativa";
$lang['user_not_allow_txt']             = "Es posible que no tenga permiso para acceder a esta sección.!";
$lang['user_notapply_member']           = "Don't apply to 'Member' type!";
$lang['user_member_txt']                = "Usuarios Miembros";
$lang['user_admin_txt']                 = "Admin Usuario";
$lang['user_group_txt']                 = "Usuario Grupos";
$lang['user_group_new']                 = "Nuevo Grupos";
$lang['user_group_edit']                = "Editar Grupos";
$lang['user_group_name']                = "Grupos Nombre";
$lang['user_group_definition']          = "Grupos Definición";
$lang['user_permission_txt']            = "Permiso";
$lang['user_backend_txt']               = "Backend";
$lang['user_frontend_txt']              = "Frontend";
$lang['user_perm_allow']                = "Permitir";
$lang['user_perm_deny']                 = "Denegar";

// COMMON BUTTONS
$lang['btn_save']		= "Guardar";
$lang['btn_save_draft']		= "Save Draft";
$lang['btn_save_exit']		= "Save & Exit";
$lang['btn_cancel']		= "Cancelar";
$lang['btn_delete']		= "Eliminar";
$lang['btn_edit']		= "Editar";
$lang['btn_next']		= "Siguiente";
$lang['btn_back']		= "Atras";
$lang['btn_add']		= "Agregar";
$lang['btn_upload']		= "Subir";
$lang['btn_view']		= "Ver";
$lang['btn_refresh']			= "Actualizar Ahora";
$lang['option_choose']		= "-- Seleccione una Opción --";
$lang['option_all']		= "-- Todo --";
$lang['option_yes']		= "Si";
$lang['option_no']		= "No";
$lang['id_col_table']		= "ID#";
$lang['year_txt']		= "Año";
$lang['month_txt']		= "Mes";
$lang['day_txt']		= "Dia";
$lang['btn_ascopy']		= "Como Copia";

//Login Page
$lang['login_heading']		= "Iniciar Sesion en Zona administrativa";
$lang['login_email']		= "Dirección de Correo Electronico";
$lang['login_password']		= "Contraseña";
$lang['login_signin']		= "Iniciar Sesion";
$lang['login_forgetpwd']	= "Olvide mi contraseña";
$lang['login_incorrect']	= "Direccion de correo Electronico o la contraseña es incorrecta";

//Forgot Password
$lang['forgot_reset']		= "Reiniciar Contraseña";
$lang['forgot_email']		= "Email Address";
$lang['forgot_password']	= "Nueva contraseña";
$lang['forgot_confirm']		= "Confirmar Contraseña";
$lang['forgot_complete']	= "Operación Exitosa! Tu contraseña a sido reiniciada";
$lang['forgot_btn']		= "Reiniciar";
$lang['forgot_check_email']	= "Por favor revisa tu correctro electronico y pulsa click en el link para reiniciar tu contraseña.";

//Dashboard
$lang['dash_welcome']		= "Bienvenido al panel de control de CSZ CMS";
$lang['dash_cur_time']		= "Fecha y Hora Actual:";
$lang['dash_message']		= "Esta es una aplicación web de código abierto que permite crear aplicaciones web empresariales o administrar todo el contenido y la configuración en los sitios web. Fue construido sobre la base de Codeigniter y diseñar la estructura de Bootstrap, esto debería hacer que su sitio web responda plenamente con facilidad. Y basado en el servidor de lenguaje de script lado PHP y utiliza una base de datos MySQL o MariaDB para el almacenamiento de datos. <br> <br> Este es el sistema de gestión de contenido de código abierto. Y todo es gratuito bajo la Astian Develop Public License (ADPL).";
$lang['dash_cszcms_link']	= "El sitio oficial de CSZ CMS.";

// EMAILS FORGET PASSWORD
$lang['email_reset_subject']    = "Reiniciar tu contraseña CSZ-CMS";
$lang['email_reset_message']    = "Please click the link below within 30 minutes to reset your password.";

// EMAIL TEXT DEFAULT
$lang['email_dear']             = "Querido ";
$lang['email_footer']           = "Saludos,";

// ERROR MESSAGES
$lang['email_check']		= "This email address does not exist.";
$lang['required']			= "The %s field is required.";
$lang['isset']				= "The %s field must have a value.";
$lang['valid_email']		= "The %s field must contain a valid email address.";
$lang['valid_emails']		= "The %s field must contain all valid email addresses.";
$lang['valid_url']			= "The %s field must contain a valid URL.";
$lang['valid_ip']			= "The %s field must contain a valid IP.";
$lang['min_length']			= "The %s field must be at least %s characters in length.";
$lang['max_length']			= "The %s field can not exceed %s characters in length.";
$lang['exact_length']		= "The %s field must be exactly %s characters in length.";
$lang['alpha']				= "The %s field may only contain alphabetical characters.";
$lang['alpha_numeric']		= "The %s field may only contain alpha-numeric characters.";
$lang['alpha_dash']			= "The %s field may only contain alpha-numeric characters, underscores, and dashes.";
$lang['numeric']			= "The %s field must contain only numbers.";
$lang['is_numeric']			= "The %s field must contain only numeric characters.";
$lang['integer']			= "The %s field must contain an integer.";
$lang['regex_match']		= "The %s field is not in the correct format.";
$lang['matches']			= "The %s field does not match the %s field.";
$lang['is_unique'] 			= "This %s already exists.";
$lang['is_natural']			= "The %s field must contain only positive numbers.";
$lang['is_natural_no_zero']	= "The %s field must contain a number greater than zero.";
$lang['decimal']			= "The %s field must contain a decimal number.";
$lang['less_than']			= "The %s field must contain a number less than %s.";
$lang['greater_than']		= "The %s field must contain a number greater than %s.";
$lang['default_data_remark']		= "is default. You can't delete this.";
$lang['remark_header']		= "Remark";

//Social Page
$lang['social_header']			= "Config Social";
$lang['social_message']			= "Aquí puede configurar los vínculos para sus cuentas sociales diferentes. Estos enlaces aparecerán en el área especificada del tema.";
$lang['social_enable']			= "Para activar un icono, marque la casilla junto a ella.";
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
$lang['social_table_title']		= "Social Site";
$lang['social_table_link']		= "Profile Link";
$lang['social_table_active']            = "Activo";

//Settings Page
$lang['settings_header']		= "Config Sitio";
$lang['settings_name']			= "Nombre del Sitio*";
$lang['settings_email']			= "Correo Electronico Predeterminado";
$lang['settings_keyword']		= "Palabras Claves";
$lang['settings_footer']		= "Mensaje de Pie de Pagina";
$lang['settings_theme']			= "Plantilla Predeterminada";
$lang['settings_lang']			= "Lenguaje zona administrativa";
$lang['settings_add_js']		= "Javascript Adicional";
$lang['settings_add_js_remark']		= "Javascript only for frontpage. Don't include &lt;script&gt;&lt;/script&gt; tag";
$lang['settings_add_meta']		= "Meta Tag adicionales";
$lang['settings_add_meta_remark']	= "Meta tag only for frontpage.";
$lang['settings_googlecapt_active']	= "reCaptcha Habilitado";
$lang['settings_googlecapt_sitekey']	= "reCaptcha Site Key";
$lang['settings_googlecapt_secretkey']	= "reCaptcha Secret Key";
$lang['settings_googlecapt_remark']	= 'You can get key of reCaptcha at <a href="https://www.google.com/recaptcha" target="_blank">https://www.google.com/recaptcha</a>';
$lang['settings_logo']			= "Logo";
$lang['settings_logo_remark']		= "Site logo has height not exceeding 50 px for default template.";
$lang['settings_pagecache_time']	= "Pages cache time control";
$lang['settings_pagecache_time_min']	= "Minutos";
$lang['settings_pagecache_time_off']	= "Off";
$lang['settings_pagecache_time_remark']	= "Less time for websites change frequently.<br>If more than for website change not frequently and want to page load performance.";
$lang['settings_email_header']          = "Configuracion de correo electronico";
$lang['settings_email_protocal']        = "Protocolo de Correo Electronico";
$lang['settings_smtp_host']             = "SMTP Host";
$lang['settings_smtp_user']             = "SMTP Username";
$lang['settings_smtp_pass']             = "SMTP Password";
$lang['settings_smtp_port']             = "SMTP Port";
$lang['settings_sendmail_path']         = "Sendmail Path";
$lang['settings_sitemap_header']        = "Generador de Sitemaps";
$lang['settings_sitemap_runnow']        = "Iniciar Ahora";
$lang['settings_sitemap_lasttime']      = "Ultima Actualizacion";
$lang['settings_member_header']          = "Config Miembros";
$lang['settings_member_confirm_active']	= "Confirmar via correo electronico los nuevos usuarios";
$lang['settings_member_close_regist']	= "Registro de usuario cerrado";
$lang['settings_og_image']		= "Image of og metatag (og:image)";
$lang['settings_fbappid_header']	= "Config de Facebook";
$lang['settings_fbapp_id']		= "FB App ID";
$lang['settings_fbappid_remark']	= 'Tu puedes crear la FB App ID en <a href="https://developers.facebook.com/apps" target="_blank">https://developers.facebook.com/apps</a>';
$lang['settings_google_config']		= "Config de Google API";
$lang['settings_ga_client_id']		= "Google API Client ID";
$lang['settings_ga_client_id_remark']	= 'How to Creating a Google API Console project and client ID? <a href="https://developers.google.com/identity/sign-in/web/devconsole-project" target="_blank"><b>See here</b></a>';
$lang['settings_ga_view_id']		= "Google Analytics View ID";
$lang['settings_ga_view_id_remark']	= 'You can see view ID at <a href="https://ga-dev-tools.appspot.com/query-explorer/" target="_blank"><b>Click Here</b></a>. After you "Access Google Analytics" and choose your site analytics. Please see your view ID at "ids"';
$lang['settings_gsearch_active']	= "Google Custom Search Enable";
$lang['settings_gsearch_cxid']          = "ID de su motor de búsqueda (cx ID)";
$lang['settings_gsearch_remark']	= 'You can see at <a href="https://developers.google.com/custom-search/docs/tutorial/introduction" target="_blank"><b>Custom Search Tutorial</b></a>.';
$lang['settings_maintenance_active']    = "Habilitar el modo de mantenimiento";
$lang['settings_html_optimize_disable']    = "Disable HTML Optimization";
$lang['settings_gmaps_key']		= "Google Maps API Key";
$lang['settings_gmaps_key_remark']	= 'How to getting a Google API key? <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank"><b>See here</b></a>';
$lang['settings_gmaps_lat']		= "Default Latitude";
$lang['settings_gmaps_lng']		= "Default Longitude";

//Navigation Page
$lang['navpage_header']                 = "Menu Principal";
$lang['navpage_dropmenu']                 = "Drop Down Menu";
$lang['navpage_new_header']		= "Nuevo Menu";
$lang['navpage_edit_header']		= "Editar Menu Principal";
$lang['navpage_menulang']		= "Menu Language";
$lang['navpage_menuname']		= "Menu Name";
$lang['navpage_type']			= "Menu Type";
$lang['navpage_pagelink']		= "Page Link";
$lang['navpage_pluginmenu']		= "Plugin Menu";
$lang['navpage_link']			= "Otro Link";
$lang['navpage_delete_btn']		= "Eliminar";
$lang['navpage_edit_btn']                  = "Editar";
$lang['delete_message']            = "Esta seguro que quiere realizar esto ?";
$lang['navpage_addnew']			= "Nuevo Menu";
$lang['navpagesub_header']                 = "Sub Menu";
$lang['navpagesub_desc']                 = "Sub Menu for drop down menu";
$lang['navpage_new_windows']            = "Nuevas Windows";
$lang['navpage_position']            = "Position";
$lang['navpage_index_remark_txt']       = "First menu of list is default for frontend page (Only top position).";

//Navigation Position
$lang['navpage_position_top']            = "Top";
$lang['navpage_position_bottom']            = "Bottom";

//Langs - All Langs
$lang['lang_header']			= "Lenguaje";
$lang['lang_name']			= "Nombre del Lenguage";
$lang['lang_iso']			= "Codigo del Lenguage";
$lang['lang_country']			= "Pais";
$lang['lang_country_iso']		= "Codigo del Pais (Bandera)";
$lang['lang_delete_message']            = "¿Quieres hacer esto ? Asegúrese de que este no es el idioma predeterminado.";
$lang['lang_delete_default']              = "No puedes realizar esta operación! Este es el lenguaje predeterminado.";
$lang['lang_addnew']			= "Nuevo Language";
$lang['lang_index_remark_txt']              = "is system language. You can't delete this!<br>First language of list is default for frontend.";

//Langs - New Lang/Edit Lang
$lang['lang_new_header']		= "Nuevo Lenguage";
$lang['lang_edit_header']		= "Editar Lenguage";
$lang['lang_active']                    = "Activoo";
$lang['lang_countryiso_remark']		= 'You can see country ISO code list (2 letters long) at - <a href="http://www.nationsonline.org/oneworld/country_code_list.htm" target="_blank" rel="nofollow external">CLICK AQUÍ</a>';
$lang['lang_iso_remark']		= 'You can see language ISO code list (2 letters long) at - <a href="https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes" target="_blank" rel="nofollow external">CLICK AQUÍ</a>';

//Pages - All Pages
$lang['pages_header']			= "Paginas";
$lang['pages_name']			= "Nombre de Pagina";
$lang['pages_title']                    = "Titulo de Pagina";
$lang['pages_lang']                     = "Lenguaje";
$lang['pages_delete_message']            = "Do you want to do this ? Make sure this is not defualt page.";
$lang['pages_delete_default']              = "Don't delete! This is defualt page.";
$lang['pages_addnew']			= "Nueva Pagina";

//Pages - New Pages/Edit Pages
$lang['pages_new_header']		= "Nueva Pagina";
$lang['pages_edit_header']		= "Editar Pagina";
$lang['pages_active']                    = "Activa";
$lang['pages_keywords']                    = "Palabras Clave";
$lang['pages_desc']                    = "Descripción de Pagina";
$lang['pages_content']                    = "Contenido de Pagina";
$lang['pages_custom_css']                    = "CSS personalizado";
$lang['pages_custom_js']                    = "JS personalizado";

//Captcha
$lang['captcha_text']             = "Verificación de Seguridad (Por favor ingrese el carácter mostrado en la imagen)";
$lang['captcha_wrong']             = "La comprobación de seguridad no se introdujo correctamente. Por favor, inténtelo de nuevo.";

//Uploadfile Page
$lang['uploadfile_header']                 = "Gestor de Archivos";
$lang['uploadfile_filenotfound']           = "Archivo no encontrado. Por favor use la herramienta para subir archivos.";
$lang['uploadfile_thumbnail']           = "Thumbnail";
$lang['uploadfile_download']           = "Descargar";
$lang['uploadfile_filename']           = "Nombre de Archivo";
$lang['uploadfile_urlpath']           = "Url de ubicación:";
$lang['uploadfile_uploadtime']           = "Upload Date/Time";
$lang['uploadfile_uploadtools']           = "Herramientas de subida";
$lang['uploadfile_add_file']           = "Agregar Archivos";
$lang['uploadfile_fileallow']           = "Solo archivos (jpg, jpeg, png, gif, pdf, doc, docx, odt, txt, odg, odp, ods, zip, rar, psv, xls, xlsx, ppt, pptx, mp3, wav, mp4, wma, flv, avi, mov, m4v, wmv, m3u, pls) are allowed. Image size is not over 1900px on width or height.";

//Forms Builder Index
$lang['forms_header']                   = "Constructor de Formularios";
$lang['forms_notfound']                 = "Formulario no encontrado. Por favor crear un nuevo formulario.";
$lang['forms_addnew']			= "Nuevo Formulario";
$lang['forms_edit']			= "Editar Formulario";
$lang['forms_name']			= "Nombre del Formulario";
$lang['forms_method']			= "Forms Method";
$lang['forms_enctype']			= "Forms enctype";
$lang['forms_delete_msg']            = "Do you want to do this ?";
$lang['forms_sendmail']			= "Sendmail Enable";
$lang['forms_captcha']			= "Captcha Enable";
$lang['forms_email']			= "Send to Email";
$lang['forms_subject']			= "Email Subject";
$lang['forms_indexremark']		= "<i>Please use this tag for insert the forms into the content. Please see Forms Name<br><b>Tag:</b></i> [?]{=forms:<b>forms_name</b>}[?]<br><b>Important Remark: Can use one form per page only!</b>";
$lang['forms_view']			= "View Form Post";
$lang['forms_success_txt']		= "Success Text";
$lang['forms_captchaerror_txt']		= "Captcha Wrong Text";
$lang['forms_error_txt']		= "Error Text";
$lang['forms_send_to_visitor']		= "Sendmail to visitor";
$lang['forms_email_field_name']		= "Email to field name";
$lang['forms_visitor_subject']		= "Email subject";
$lang['forms_visitor_body']		= "Email body";
$lang['forms_visitor_newtxt']		= "Sendmail to visitor. Please edit this form";

//Field Text
$lang['field_header']                   = "Field Insert";
$lang['field_editheader']               = "Field Edit";
$lang['field_type']			= "Field Type";
$lang['field_name']			= "Field Name";
$lang['field_id']			= "Field ID";
$lang['field_class']			= "Field Class";
$lang['field_placeholder']		= "Field Placeholder";
$lang['field_value']                    = "Field Value";
$lang['field_label']                    = "Field Label";
$lang['sel_option_val']                 = "Select Option Value";
$lang['sel_option_val_info']            = "Example, If you want option value is 'value' and label is 'Show' you can put like this. Ex. value1=>Show1, value2=>Show2";
$lang['field_require']                  = "Field Require";
$lang['field_addtxtinfo']               = '<span class="remark">Press <i class="glyphicon glyphicon-plus"></i> to add more fields.</span>';

//Form Post Data
$lang['formpost_notfound']                 = "Form post not found.";
$lang['formpost_ipaddress']                 = "Dirección IP";

//Upgrade
$lang['upgrade_header']			= "Sistema de actualización automatico";
$lang['btn_upgrade']			= "Iniciar actualización";
$lang['upgrade_curver']			= "Version Actual:";
$lang['upgrade_lastver']		= "Ultima version:";
$lang['upgrade_newlast_alert']          = "CSZ-CMS tiene una nueva version disponible. Actualizar ahora!";
$lang['upgrade_lastver_alert']          = "Su CSZ-CMS ah sido actualizada!";
$lang['upgrade_success_alert']          = "Actualización exitosa!";
$lang['upgrade_error_alert']            = "Error tratando de actualizar!";
$lang['upgrade_text']                   = "<b>Importante!</b> Por favor, backup the database and your modified file before upgrade! Please immediately upgrade for latest version.";
$lang['manual_upgrade']			= "Sistema de actualización manual";
$lang['logs_download_header']		= "Descargar registro de errores";
$lang['btn_logs_download']		= "Descargar!";
$lang['btn_clear_logs']                 = "Limpiar todos los registros de errores";

//Optimize Database
$lang['maintenance_header']             = "Sistema de Mantenimiento";
$lang['btn_clearallcache']              = "Limpiar el cache de las paginas";
$lang['btn_clearalldbcache']              = "Limpiar todo el cache de la base de datos";
$lang['database_maintain_header']	= "Mantenimiento de la base de datos";
$lang['optimize_success_alert']         = "La optimización de la base de datos a sido exitosa!";
$lang['optimize_error_alert']           = "Ah ocurrido un error tratando de optimizar la base de datos!";
$lang['btn_optimize_db']		= "Optimizar la base de datos";
$lang['btn_backup_db']			= "Copia de seguridad de la base de datos";
$lang['clearallcache_success_alert']    = "La limpieza de todo el cache de las paginas a sido exitoso!";
$lang['clearalldbcache_success_alert']    = "La limpieza de todo el cache de la base de datos a sido exitoso!";
$lang['btn_clear_sess']                 = "Limpiar todas las sesiones";
$lang['clear_sess_message']            = "Despues de limpiar todas las sesiones. Por favor iniciar sesion otra vez. Quieres realizar esto?";
$lang['btn_backup_file']		= "Archivo de la copia de seguridad";
$lang['btn_backup_photo']		= "Photo/Upload Backup";

//Link Statistic
$lang['linkstats_header']             = "Statistic for link";
$lang['linkstats_newbtn']             = "Nuevo Link";
$lang['linkstats_url']                 = "URL";
$lang['linkstats_dateime']              = "Date/Time";
$lang['linkstats_count']                = "Click Count";
$lang['ip_address']                      = "IP Address";
$lang['data_notfound']                 = "Data not found.";
$lang['startdate_field']                = "Start Date";
$lang['enddate_field']                = "End Date";
$lang['search']                         = "Search";
$lang['total']                         = "Total:";
$lang['records']                         = "Records";

//General Label
$lang['genlabel_header']             = "General Label";
$lang['genlabel_name']			= "Label Name";
$lang['genlabel_lang']			= "Language of Frontend";
$lang['genlabel_synclang_success']	= "Label language synchronized successfully!";
$lang['btn_label_synclang']             = "Language Sync";

//Langs - New Lang/Edit Lang
$lang['genlabel_edit_header']		= "Edit General Label";
$lang['genlabel_plssync_alert']             = "Please click 'Language Sync' now!";

// Messages Alert
$lang['success_message_alert']		= "Exitosamente!";
$lang['error_message_alert']		= "Ah ocurrido un error! Por favor intentarlo nuevamente.";

// Plugin Manager
$lang['pluginmgr_header']               = "Administrador de Plugins";
$lang['pluginmgr_name']                 = "Nombre del plugin";
$lang['pluginmgr_version']                 = "Version";
$lang['pluginmgr_owner']                 = "Plugin Owner";
$lang['pluginmgr_install']              = "Plugin Install";
$lang['btn_install']                    = "Instalar";
$lang['pluginmgr_zip_remark']              = "solo archivos (zip) estan permitidos.";
$lang['pluginmgr_status']              = "Plugin Status";
$lang['pluginmgr_enable']               = "Habilitado";
$lang['pluginmgr_disable']               = "Deshabilitado";
$lang['pluginmgr_manage']               = "Manage";
$lang['pluginmgr_store']               = "Plugins Store";
$lang['pluginmgr_config_filename']                 = "Config File Name";
$lang['pluginmgr_desc']               = "Description";
$lang['pluginmgr_upgrade']               = "Upgrade";
$lang['pluginmgr_latest_version']                 = "Latest Version";
$lang['pluginmgr_latest_already']                 = "Your plugin is latest version!";

// Widget Builder
$lang['widget_header']               = "Plugin Widgets";
$lang['widget_new_header']		= "Nuevo Widget";
$lang['widget_edit_header']		= "Editar Widget";
$lang['widget_active']                    = "Activo";
$lang['widget_name']                 = "Widget Name";
$lang['widget_xml_url']                 = "Widget XML URL";
$lang['widget_limit_view']                 = "Show Limit";
$lang['widget_widget_open']                 = "HTML Open";
$lang['widget_widget_content']                 = "HTML Content";
$lang['widget_widget_seemore']                 = "HTML See more Button";
$lang['widget_widget_close']                 = "HTML Close";
$lang['widget_indexremark']		= "<i>Utilice esta etiqueta para insertar el widget de complemento en el contenido. Vea el nombre del widget<br><b>Tag:</b></i> [?]{=widget:<b>widget_name</b>}[?]";

// Facebook Comments
$lang['fb_comment_active']               = "Comentarios de Facebook";
$lang['fb_comment_limit']               = "Limite de comentario";
$lang['fb_comment_sort']                = "Comentarios de Facebook Ordenar";
$lang['fb_comment_sort_top']                = "Top";
$lang['fb_comment_sort_newest']                = "El más nuevo";
$lang['fb_comment_sort_oldest']                = "Más antiguo";

// Brute force login protection
$lang['bf_protection_header']                = "Proteccion de fuerza bruta";
$lang['bf_period_time']                = "Protección de fuerza bruta por periodo (en minutos)";
$lang['bf_max_fail']                    = "Maximo inicios de sesion fallidos (en periodos)";
$lang['bf_white_list']                    = "Lista Blanca Direcciones IP";
$lang['bf_black_list']                    = "Lista Negra Direcciones IP";
$lang['bf_note']                    = "Nota";
$lang['bf_ip_banned_alert']           = "Tu dirección IP a sido bloqueada!";
$lang['bf_settings']                    = "Config de protección";
$lang['loginlogs_header']               = "Registro de inicios de sesion";
$lang['actionslogs_header']               = "Registros de acciones";
$lang['loginlogs_result']                    = "Resultados";
$lang['emaillogs_header']               = "Registros de correo electronico";
$lang['bf_private_key']               = "Private Key";
$lang['bf_gen_private_key']               = "Private Key Generator";
$lang['bf_gen_private_key_confirm']            = "Do you want to do this? Please change the private key anywhere been required. After private key generate.";

// Private Message
$lang['pm_header']                = "Mensaje privado";
$lang['pm_nomsg_alert']                = "¡No hay mensaje nuevo!";
$lang['pm_unread_txt']                    = "Tiene %d mensajes no leídos";
$lang['pm_seeall_msg']                    = "Ver todos los mensajes";
$lang['pm_to']                    = "A";
$lang['pm_from']                    = "De";
$lang['pm_subject']                    = "Tema";
$lang['pm_message']                    = "Mensaje";
$lang['pm_send']                    = "Enviar";
$lang['pm_inbox']                    = "Bandeja de entrada";
$lang['pm_new_msg']                    = "Nuevo mensaje";

// Banner Mgt
$lang['banner_header']                = "Administrador de Banner";
$lang['banner_new']             = "Nueva Banner";
$lang['banner_name']                 = "Nombre de Banner";
$lang['banner_img']                 = "Banner Image";
$lang['banner_width']                 = "Ancho";
$lang['banner_height']                 = "Alto";
$lang['banner_link']                 = "Enlazar";
$lang['banner_count']                = "Clicks";
$lang['banner_date_period']            = "Período de la fecha";
$lang['banner_nofollow']            = "Nofollow Enlace";
$lang['banner_expired']            = "Banner Expired";
$lang['banner_indexremark']		= "<i>Utilice esta etiqueta para insertar el banner en el contenido. Por favor, vea Banner ID #<br><b>Etiqueta:</b></i> [?]{=banner:<b>banner_id</b>}[?]";
