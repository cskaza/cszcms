<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Linenotify_lib Libraries Class
 *
 * Copyright (c) 2019, CSKAZA Web Development.
 *
 * Astian Develop Public License (ADPL)
 *
 * This Source Code Form is subject to the terms of the Astian Develop Public
 * License, v. 1.0. If a copy of the APL was not distributed with this
 * file, You can obtain one at http://astian.org/about-ADPL
 *
 * @author	CSKAZA
 * @copyright   Copyright (c) 2019, CSKAZA Web Development.
 * @license	http://astian.org/about-ADPL	ADPL License
 * @link	https://www.cszcms.com
 * @since	Version 1.0.0
 * 
 * How to use this?
 * 
 * $this->load->library('Linenotify_lib');
 * $this->linenotify_lib->lineNotify($token, $message);
 */
class Linenotify_lib {
    private $line_api_url = 'https://notify-api.line.me/api/notify'; /* Line API Url */
    
    /**
     * lineNotify
     *
     * Function for get the Line notify
     *
     * @param	string	$token    Line access tokens. Access Token from https://notify-bot.line.me/my
     * @param	string	$message    The message was send to Line Notify. Limited to 1,000 characters only.
     * @return  object or FALSE
     */
    public function lineNotify($token, $message){
        if (function_exists('ini_set')) {
            @ini_set('max_execution_time', 600);
            @ini_set("pcre.recursion_limit", "16777");
        }
        if (function_exists('curl_init')) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->line_api_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "message=".substr($message, 0, 1000),
                CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer ".$token,
                "Cache-Control: no-cache",
                "Content-type: application/x-www-form-urlencoded"
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $content = json_decode($response); /*{"status":200,"message":"ok"}*/
        } else if (ini_get('allow_url_fopen')) {
            $queryData1 = array('message' => substr($message, 0, 1000));
            $queryData = http_build_query($queryData1,'','&');
            $headerOptions = array( 
                    'http'=>array(
                       'method'=>'POST',
                       'header'=> "Content-Type: application/x-www-form-urlencoded\r\n"
                                 ."Authorization: Bearer ".$token."\r\n"
                                 ."Content-Length: ".strlen($queryData)."\r\n",
                       'content' => $queryData
                    ),
            );
            $context = stream_context_create($headerOptions);
            $result = file_get_contents($this->line_api_url,FALSE,$context);
            $content = json_decode($result); /*{"status":200,"message":"ok"}*/
        } else {
            log_message('error', 'You have neither cUrl installed and not allow_url_fopen activated. Please setup one of those!');
            $content = FALSE;
        }
        return $content;
    }

}
