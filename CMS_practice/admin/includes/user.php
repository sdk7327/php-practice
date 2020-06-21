<?php
class User extends Db_object {
    protected static $db_table = "users";
    protected static $db_fields = array('filename','username','password','firstname', 'lastname');
    public $id;
    public $filename;
    public $username;
    public $firstname;
    public $lastname;
    public $password;
    public $upload_directory = "images";
    public $image_placeholder = "http://placehold.it/80x80&text=image";

    public function image_path_placeholder() {
        return empty($this->filename) ? $this->image_placeholder : $this->upload_directory.DS.$this->filename;
    }

    public static function verify_user($username, $password) {
        global $database;
        $username = $database->escape_string($username);
        $password = $database->escape_string($password);

        $sql = "SELECT * FROM users WHERE ";
        $sql .= "username = '{$username}' ";
        $sql .= "AND password = '{$password}' ";
        $sql .= "LIMIT 1";

        $the_result_array = self::find_by_query($sql);
        //turnery logic for if else
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }

} // End of Class User


?>
