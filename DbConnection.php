<?php
ini_set('display_errors', 1);

class DbConnection {

    private $_host = "localhost";
    private $_username = "server_username";
    private $_password = "server_password";
    private $_database = "database_name";
    public $connection;

    function __construct() {
        // creating db connection
        $this->connection = mysqli_connect($this->_host, $this->_username, $this->_password, $this->_database);
        // error check
        if (mysqli_connect_error()) {
            trigger_error("Failed to conenct to MySQL: " . mysql_connect_error(), E_USER_ERROR);
        }
    }


    // set function
    public function setData($query) {
        $result = mysqli_query($this->connection, $query) or die(mysqli_error());
        if ($result)
            return true;
        else
            return false;
    }

    // get function
    public function getData($query) {
        $result = $this->connection->query($query) or die(mysqli_error($this->connection));
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }


}
