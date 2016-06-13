<?php

/*
 * Mysql database class - only one connection alowed
 */

class Database {

    private $_connection;
    private $_host;
    private $_username;
    private $_password;
    private $_database;

    // Constructor
    public function __construct($dbhost = '', $dbuser = '', $dbpass = '', $dbname = '') {
        $this->_host = $dbhost;
        $this->_username = $dbuser;
        $this->_password = $dbpass;
        $this->_database = $dbname;
        $this->_connection = new mysqli($this->_host, $this->_username, $this->_password, $this->_database);
        $this->_connection->set_charset('utf8');
        $this->_connection->query("SET collation_connection = utf8_general_ci");
        // Error handling
        if (mysqli_connect_error()) {
            trigger_error("Failed to conencto to MySQL: " . mysqli_connect_error(), E_USER_ERROR);
        }
    }

    // Get mysqli connection
    public function connectDB() {
        return $this->_connection;
    }

    public function closeDB() {
        $this->_connection->close();
    }

    public function mysqli_multi_query_file($mysqli, $filename) {
        error_reporting(E_ERROR | E_PARSE);
        $sql = file_get_contents($filename);
        // remove comments
        $sql = preg_replace('#/\*.*?\*/#s', '', $sql);
        $sql = preg_replace('/^-- .*[\r\n]*/m', '', $sql);
        if (preg_match_all('/^DELIMITER\s+(\S+)$/m', $sql, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE)) {
            $prev = null;
            $index = 0;
            foreach ($matches as $match) {
                $sqlPart = substr($sql, $index, $match[0][1] - $index);
                // move cursor after the delimiter
                $index = $match[0][1] + strlen($match[0][0]);
                if ($prev && $prev[1][0] != ';') {
                    $sqlPart = explode($prev[1][0], $sqlPart);
                    foreach ($sqlPart as $part) {
                        if (trim($part)) { // no empty queries
                            $mysqli->query($part);
                        }
                    }
                } else {
                    if (trim($sqlPart)) { // no empty queries
                        $mysqli->multi_query($sqlPart);
                        while ($mysqli->next_result()) {;}
                    }
                }
                $prev = $match;
            }
            // run the sql after the last delimiter
            $sqlPart = substr($sql, $index, strlen($sql) - $index);
            if ($prev && $prev[1][0] != ';') {
                $sqlPart = explode($prev[1][0], $sqlPart);
                foreach ($sqlPart as $part) {
                    if (trim($part)) {
                        $mysqli->query($part);
                    }
                }
            } else {
                if (trim($sqlPart)) {
                    $mysqli->multi_query($sqlPart);
                    while ($mysqli->next_result()) {;}
                }
            }
        } else {
            $mysqli->multi_query($sql);
            while ($mysqli->next_result()) {;}
        }
    }
    
}

class Version{
    public function getVersion($xml_url) {
        if ($xml_url) {
            $xml_file = $xml_url;
        }
        $xml = simplexml_load_file($xml_file) or die("Error: Cannot create object");
        if ($xml->version) {
            if ($xml->release == 'beta') {
                $beta = ' Beta';
            } else {
                $beta = '';
            }
            return $xml->version . $beta;
        } else {
            return FALSE;
        }
    }
}