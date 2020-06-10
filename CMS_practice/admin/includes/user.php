<?php
class User {
    public $user_id;
    public $username;
    public $firstname;
    public $lastname;
    public $password;

    public static function find_all_users() {
        return self::find_this_query("SELECT * FROM users");
    }

    public static function find_user_by_id($user_id) {
        global $database;
        $the_result_array = self::find_this_query("SELECT * FROM users WHERE user_id = $user_id LIMIT 1");
        //turnery logic for if else
        return !empty($the_result_array) ? array_shift($the_result_array):false;
    }

    public static function find_this_query($sql) {
        global $database;
        $result_set = $database->query($sql);
        $object_array = array();

        while($row = mysqli_fetch_array($result_set)) {
            $object_array[] = self::instantiation($row);
        }

        return $object_array;
    }

    public static function verify_user($username, $password) {
        global $database;
        $username = $database->escape_string($username);
        $password = $database->escape_string($password);

        $sql = "SELECT * FROM users WHERE ";
        $sql .= "username = '{$username}' ";
        $sql .= "AND password = '{$password}' ";
        $sql .= "LIMIT 1";

        $the_result_array = self::find_this_query($sql);
        //turnery logic for if else
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }


    public static function instantiation($the_record) {
        $object = new self;


        //automatically instantiating the variables
        foreach ($the_record as $attribute => $value) {
            if($object->has_attribute($attribute)) {
                $object->$attribute = $value;
            }
        }

        return $object;
    }

    private function has_attribute($attribute) {
        $object_properties = get_object_vars($this);
        return array_key_exists($attribute, $object_properties);
    }

    public function create() {
        global $database;
        $sql = "INSERT INTO users (username, password, firstname, lastname)";
        $sql .= " VALUES ('";
        $sql .= $database->escape_string($this->username) . "', '";
        $sql .= $database->escape_string($this->password) . "', '";
        $sql .= $database->escape_string($this->firstname) . "', '";
        $sql .= $database->escape_string($this->lastname) . "')";

        if($database->query($sql)) {
            $this->id = $database->insert_id();
            return true;
        } else {
            return false;
        }

    }// End of Create Method

    public function update() {
        global $database;

        $sql = "UPDATE users SET ";
        $sql .= "username= '" . $database->escape_string($this->username) . "', ";
        $sql .= "password= '" . $database->escape_string($this->password) . "', ";
        $sql .= "firstname= '" . $database->escape_string($this->firstname) . "', ";
        $sql .= "lastname= '" . $database->escape_string($this->lastname) . "' ";
        $sql .= " WHERE user_id= " . $database->escape_string($this->user_id);

        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }// End of update method

    public function delete() {
        global $database;

        $sql = "DELETE FROM users WHERE ";
        $sql .= "user_id = " . $database->escape_string($this->user_id);
        $sql .= " LIMIT 1";

        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }// End of delete method

} // End of Class User


?>
