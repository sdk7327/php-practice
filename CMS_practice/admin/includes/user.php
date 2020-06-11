<?php
class User {
    protected static $db_table = "users";
    protected static $db_fields = array('username','password','firstname', 'lastname');
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

    protected function properties() {
        //return get_object_vars($this);
        $properties = array();

        foreach(self::$db_fields as $db_field) {
            if(property_exists($this, $db_field)) {
                $properties[$db_field] = $this->$db_field;
            }
        }
        return $properties;
    }

    protected function clean_properties() {
        global $database;

        $clean_properties = array();
        foreach ($this->properties() as $key => $value) {
            $clean_properties[$key] = $database->escape_String($value);
        }
        return $clean_properties;
    }

    public function save() {
        return isset($this->user_id) ? $this->update() : $this->create();
    }

    public function create() {
        global $database;

        $properties = $this->clean_properties();

        $sql = "INSERT INTO " . self::$db_table . " ( " . implode(",", array_keys($properties)) . " )";
        $sql .= " VALUES ('" . implode("','", array_values($properties)) . "')";

        if($database->query($sql)) {
            $this->id = $database->insert_id();
            return true;
        } else {
            return false;
        }

    }// End of Create Method

    public function update() {
        global $database;

        $properties = $this->clean_properties();
        $property_pairs = array();

        foreach($properties as $key => $value) {
            $property_pairs[] = "{$key}='{$value}'";
        }

        $sql = "UPDATE " . self::$db_table . " SET ";
        $sql .= implode(", ", $property_pairs);
        $sql .= " WHERE user_id= " . $database->escape_string($this->user_id);

        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }// End of update method

    public function delete() {
        global $database;

        $sql = "DELETE FROM " . self::$db_table . " WHERE ";
        $sql .= "user_id = " . $database->escape_string($this->user_id);
        $sql .= " LIMIT 1";

        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }// End of delete method

} // End of Class User


?>
