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
        $result_set = self::find_this_query("SELECT * FROM users WHERE user_id = $user_id LIMIT 1");
        $found_user = mysqli_fetch_array($result_set);
        return $found_user;
    }

    public static function find_this_query($sql) {
        global $database;
        $result_set = $database->query($sql);
        return $result_set;
    }

    public static function instantiation($found_user) {
        $object = new self;

        //manually instantiating the variables
        //$object->user_id = $found_user['user_id'];
        //$object->username = $found_user['username'];
        //$object->firstname = $found_user['firstname'];
        //$object->lastname = $found_user['lastname'];
        //$object->password = $found_user['password'];

        //automatically instantiating the variables
        foreach ($the_record as $attribute => $value) {
            if($the_object->$has_attribute($attribute)) {
                $the_object->$attribute = $value;
            }
        }

        return $object;
    }

    private function $has_attribute($attribute) {
        $object_properties = get_object_vars($this);
        return array_key_exists($attribute, $object_properties);
    }
}

?>
