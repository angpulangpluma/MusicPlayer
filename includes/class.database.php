<?php

/* * ***************************************
 * Database PDO Wrapper class
 *
 * Created by HTech Dev Team on 2014/03/31.
 * *************************************** */

class Database extends PDO {

    protected $conn;
    public $conn_status = false;
    private $conn_err;
    private $trans_status = 0;
    private $exec_queries = array();
    private $query_cnt = 0;
    protected $error_report = true; //TRUE for development, FALSE for production
    private $enable_log = true;

    /**
     * Instantiates the PDO.
     * @param string $db_type Type of database (e.g. MySQL, PostgreSQL, SQLite, etc.)
     * @param string $host The address of the database server.
     * @param string $db_name The name of the database to be used.
     * @param string $user The username to access the database.
     * @param string $pwd The password to access the database.
     * @return array The status of the connection.
     * */
    function __construct($db_type, $host, $db_name, $user, $pwd) {
        try {
            $this->conn = new PDO("$db_type:host=$host;dbname=$db_name", $user, $pwd, array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ));

            $this->conn_status = true;
        } catch (PDOException $e) {
            $this->log("[" . date("H:i:s") . "] Connection error: " . $e->getMessage() . PHP_EOL);
            $this->set_connection_error($e->getMessage());
        }
    }

    /**
     * Initiates a database transaction.
     * */
    function beginTransaction() {
        if ($this->trans_status == 0) {
            $this->conn->beginTransaction();
            $this->trans_status = 1;
        }
    }

    /**
     * Commits into the database the changes made in the transaction.
     * */
    function commit() {
        if ($this->trans_status == 1) {
            $this->conn->commit();
            $this->trans_status = 0;
        }
    }

    /**
     * Disregards the changes made in the transaction.
     * */
    function rollBack() {
        if ($this->trans_status == 1) {
            $this->conn->rollBack();
            $this->trans_status = 0;
        }
    }

    /**
     * Performs the prepare, bind, execute, and fetch functions of PDO.
     * @param string $type The type of query to be performed (SELECT, INSERT, INSERT_ID, UPDATE, DELETE)
     * @param string $stmt The query statement to be executed.
     * @param array  $data_array (optional) The values that should be binded with the query statement, if there's any.
     * @return array Returns the status of the query and -- if the query type is SELECT -- the fetched data.
     * */
    function query($type, $stmt, $data_array = false) {
        if (strlen($stmt) > 0) {
            try {
                $query = $this->conn->prepare($stmt);

                if (is_array($data_array)) {
                    foreach ($data_array as $key => $val) {
                        if (is_int($key)) $key++;

                        if (is_int($val)):
                            $query->bindValue($key, $val, PDO::PARAM_INT);
                        elseif ($val === NULL):
                            $query->bindValue($key, NULL, PDO::PARAM_NULL);
                        elseif (is_string($val)):
                            $query->bindValue($key, $val, PDO::PARAM_STR);
                        else:
                            $query->bindValue($key, $val);
                        endif;

                    }
                }

                $query->execute();

                $this->populate_query_log(date("Y-m-d H:i:s"), $stmt, $data_array);

                $return['status'] = true;

                if ($type === "SELECT"):
                    $return['data'] = $query->fetchAll(PDO::FETCH_ASSOC);
                    $return['count'] = count($return['data']);
                elseif ($type === "INSERT_ID"):
                    $return['data'] = $this->conn->lastInsertId();
                endif;

                return $return;
            } catch (PDOException $e) {
                $this->log("[" . date("H:i:s") . "] Query error: " . $e->getMessage() . PHP_EOL);

                $return['status'] = false;
                if ($this->error_report)
                    $return['error'] = $e->getMessage();
                else
                    $return['error'] = NULL;

                return $return;
            }
        }
    }

    /**
     * Stores all the executed queries.
     * @param datetime $query_time The timestamp when the query was executed.
     * @param string $stmt The query statement executed.
     * @param array $data The array of values binded to the query statement.
     * */
    private function populate_query_log($query_time, $stmt, $data) {
        $this->exec_queries[$this->query_cnt]['exec_time'] = $query_time;
        $this->exec_queries[$this->query_cnt]['statement'] = $stmt;
        $this->exec_queries[$this->query_cnt]['bind_val'] = $data;
        $this->query_cnt += 1;
    }

    /**
     * Log the error message (or any other log message) 
     * @param string $msg The log message.
     * */
    private function log($msg) {
        if ($this->enable_log === TRUE) {
            $log_name = date("Ymd") . "_log.log";
            $root = str_replace("includes", "", __DIR__);
            //Change to the directory where the log file should be created.
            $log_dir = $root . 'logs/mysql/';


            /**
             * NOTE: The default directory points to the "app/logs" directory of the project.
             * You may change the directory path if you want.
             * */
            if (!is_dir($log_dir)) {
                mkdir($log_dir);
            }

            $file = fopen("$log_dir/$log_name", 'a'); //or die("Cannot open file: $log_dir/$log_name");
            if ($file) {
                fwrite($file, $msg);
                fclose($file);
            }
        }
    }

    /**
     * Getter function - Retrieve the exec_queries array.
     * @return array $exec_queries;
     * */
    function get_query_log() {
        if ($this->error_report)
            return $this->exec_queries;
    }

    /**
     * Getter function - Retrieve the connection error.
     * @return string The connection error message;
     * */
    function get_connection_error() {
        if ($this->error_report)
            return $this->conn_err;
    }

    /**
     * Setter function - Assigns the error message into $conn_err.
     * @param string $err The error message.
     * */
    private function set_connection_error($err) {
        $this->conn_err = $err;
    }

}

?>