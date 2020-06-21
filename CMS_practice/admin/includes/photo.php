<?php

class Photo extends Db_object {
    protected static $db_table = "photos";
    protected static $db_fields = array('id','title', 'caption', 'description', 'filename', 'alt_text', 'type', 'size');
    public $id;
    public $title;
    public $caption;
    public $description;
    public $filename;
    public $alt_text;
    public $type;
    public $size;

    public $temp_path;
    public $upload_directory = "images";


    //this passes the $_FILES['upload_file'] super global as an argument - added to db_object class
    //public function set_file($file) {
    //    if(empty($file) || !$file || !is_array($file)) {
    //        $this->errors[] = "There was no file uploaded.";
    //        return false;
    //    }elseif($file['error'] !=0) {
    //        $this->errors[] = $this->upload_errors_array[$file['error']];
    //        return false;
    //    } else {
    //        $this->filename = basename($file['name']);
    //        $this->temp_path = $file['temp_name'];
    //        $this->type = $file['type'];
    //        $this->size = $file['size'];
    //    }
    //} //end of set file method

    public function picture_path() {
        return $this->upload_directory.DS.$this->filename;
    }

   /* public function save() {
        if($this->id) {
            $this->update();
        } else {
            if(!empty($this->errors)) {
                return false;
            }

            if(empty($this->filename) || empty($this->temp_path)) {
                $this->errors[] = "the file was not available";
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
                $this->errors[] = "The folder probably can't get permissions needed.";
            }

            $this->create();
        }
    } *///end of save method - moved to db_object class

    public function delete_photo() {
        if($this->delete()) {
            $target_path = SITE_ROOT.DS. 'admin' . DS . $this->picture_path();
            return unlink($target_path) ? true : false;
        } else {
            return false;
        }
    }
}

?>
