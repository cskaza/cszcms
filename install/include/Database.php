<?php
/**
 * CSZ CMS Installer
 *
 * An open source content management system application with development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2016 by CSKAZA for CSZ CMS
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CSZCMS_Installer
 * @author	CSKAZA Dev Team
 * @copyright   Copyright (c) 2016, CSKAZA for CSZ CMS. (https://www.cszcms.com)
 * @link	https://www.cszcms.com
 * @since	Version 1.0.0
 */
/*
 * Mysql database with MySQLi class - only one connection alowed
 */

class Database{

    private $_connection;
    private $_host;
    private $_username;
    private $_password;
    private $_database;

    // Constructor
    public function __construct($dbhost = '', $dbuser = '', $dbpass = '', $dbname = ''){
        $this->_host = $dbhost;
        $this->_username = $dbuser;
        $this->_password = $dbpass;
        $this->_database = $dbname;
        $this->_connection = new mysqli($this->_host, $this->_username, $this->_password, $this->_database);
        $this->_connection->set_charset('utf8');
        $this->_connection->query("SET collation_connection = utf8_general_ci");
        // Error handling
        if(mysqli_connect_error()){
            trigger_error("Failed to conencto to MySQL: ".mysqli_connect_error(), E_USER_ERROR);
        }
    }

    // Get mysqli connection
    public function connectDB(){
        return $this->_connection;
    }

    public function numrow($result){
        $result->execute();
        $result->store_result();
        return $result->num_rows;
    }

    public function closeDB(){
        $this->_connection->close();
    }

    public function mysqli_multi_query_file($mysqli, $filename){
        error_reporting(E_ERROR | E_PARSE);
        $sql = file_get_contents($filename);
        // remove comments
        $sql = preg_replace('#/\*.*?\*/#s', '', $sql);
        $sql = preg_replace('/^-- .*[\r\n]*/m', '', $sql);
        if(preg_match_all('/^DELIMITER\s+(\S+)$/m', $sql, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE)){
            $prev = null;
            $index = 0;
            foreach($matches as $match){
                $sqlPart = substr($sql, $index, $match[0][1] - $index);
                // move cursor after the delimiter
                $index = $match[0][1] + strlen($match[0][0]);
                if($prev && $prev[1][0] != ';'){
                    $sqlPart = explode($prev[1][0], $sqlPart);
                    foreach($sqlPart as $part){
                        if(trim($part)){ // no empty queries
                            $mysqli->query($part);
                        }
                    }
                }else{
                    if(trim($sqlPart)){ // no empty queries
                        $mysqli->multi_query($sqlPart);
                        while($mysqli->next_result()){
;
                        }
                    }
                }
                $prev = $match;
            }
            // run the sql after the last delimiter
            $sqlPart = substr($sql, $index, strlen($sql) - $index);
            if($prev && $prev[1][0] != ';'){
                $sqlPart = explode($prev[1][0], $sqlPart);
                foreach($sqlPart as $part){
                    if(trim($part)){
                        $mysqli->query($part);
                    }
                }
            }else{
                if(trim($sqlPart)){
                    $mysqli->multi_query($sqlPart);
                    while($mysqli->next_result()){
;
                    }
                }
            }
        }else{
            $mysqli->multi_query($sql);
            while($mysqli->next_result()){
;
            }
        }
    }

}

class Version{
    private $version = '1.1.4'; /* For CMS Version */
    private $release = 'release'; /* For release or beta */

    public function getVersion(){
        $version = '';

        if($this->release == 'beta'){
            $version = $this->version.' Beta';
        }else{
            $version = $this->version;
        }
        return $version;
    }
    
    public function setTimezone($timezone){
        if(!$timezone) $timezone = 'Asia/Bangkok';
        if (function_exists('ini_set')) {
            ini_set('max_execution_time', 300);
            ini_set('date.timezone', $timezone);
        }
    }
}
