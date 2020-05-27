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
        if(!empty($the_result_array)) {
            $first_item = array_shift($the_Result_array);
            return $first_item;
        } else {
            return false;
        }
        return $found_user;
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
}

?>
