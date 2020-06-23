<?php

class Db_object {

    public $errors = array();
    public $upload_errors_array = array(
        UPLOAD_ERR_OK => "There is no error, the file uploaded with success.",
        UPLOAD_ERR_INI_SIZE => "The uploaded file exceeds the upload_max_filesize directive in php.ini.",
        UPLOAD_ERR_FORM_SIZE => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.",
        UPLOAD_ERR_PARTIAL => "The upload file was only partially uploaded.",
        UPLOAD_ERR_NO_FILE => "No file was uploaded.",
        UPLOAD_ERR_NO_TMP_DIR => "Missing a temporary folder.",
        UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk.",
        UPLOAD_ERR_EXTENSION => "A PHP extension stopped the file upload."
    );

    //this passes the $_FILES['upload_file'] super global as an argument
    public function set_file($file) {
        if(empty($file) || !$file || !is_array($file)) {
            $this->errors[] = "There was no file uploaded.";
            return false;
        }elseif($file['error'] !=0) {
            $this->errors[] = $this->upload_errors_array[$file['error']];
            return false;
        } else {
            $this->filename = basename($file['name']);
            $this->temp_path = $file['tmp_name'];
            $this->type = $file['type'];
            $this->size = $file['size'];
        }
    } //end of set file method

    public function save_image() {
        if($this->id) {
            $this->update();
        } else {
            if(!empty($this->errors)) {
                return false;
            }

            if(empty($this->filename) || empty($this->temp_path)) {
                $this->errors[] = "The file was not available";
                return false;
            }

            $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->filename;

            if(file_exists($target_path)) {
                $this->errors[] = "The file {$this->filename} already exists";
                return false;
            }

            if(move_uploaded_file($this->temp_path, $target_path)) {
                if($this->create()) {
                    unset($this->temp_path);
                    return true;
                }
            } else {
                $this->errors[] = "The folder probably doesn't have permissions needed.";
            }
        }
    } //end of save method

    public static function find_all() {
        return static::find_by_query("SELECT * FROM " . static::$db_table);
    }

    public static function find_by_id($id) {
        global $database;
        $the_result_array = static::find_by_query("SELECT * FROM " . static::$db_table . " WHERE id = $id LIMIT 1");
        //turnery logic for if else
        return !empty($the_result_array) ? array_shift($the_result_array):false;
    }

    public static function find_by_query($sql) {
        global $database;
        $result_set = $database->query($sql);
        $object_array = array();

        while($row = mysqli_fetch_array($result_set)) {
            $object_array[] = static::instantiation($row);
        }

        return $object_array;
    }

    public static function instantiation($the_record) {
        $call_class = get_called_class();
        $object = new $call_class;

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

        foreach(static::$db_fields as $db_field) {
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
        return isset($this->id) ? $this->update() : $this->create();
    }

    public function create() {
        global $database;

        $properties = $this->clean_properties();

        $sql = "INSERT INTO " . static::$db_table . " ( " . implode(",", array_keys($properties)) . " )";
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

        $sql = "UPDATE " . static::$db_table . " SET ";
        $sql .= implode(", ", $property_pairs);
        $sql .= " WHERE id= " . $database->escape_string($this->id);

        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }// End of update method

    public function delete() {
        global $database;

        $sql = "DELETE FROM " . static::$db_table . " WHERE ";
        $sql .= "id = " . $database->escape_string($this->id);
        $sql .= " LIMIT 1";

        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }// End of delete method

    public static function count_all() {
        global $database;

        $sql = "SELECT COUNT(*) FROM " . static::$db_table;
        $result_set = $database->query($sql);
        $row = mysqli_fetch_array($result_set);

        return array_shift($row);
    }// End of count all method

}

?>
