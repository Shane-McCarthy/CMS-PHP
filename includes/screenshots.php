<?php
/**
 * Created by PhpStorm.
 * User: can you dig it
 * Date: 1/12/14
 * Time: 1:21 PM
 */
require_once(LIB_PATH . DS . 'database.php');

class Screenshots extends DatabaseObject
{
    protected static $table_name = "screenshots";
    protected static $db_fields = array('id', 'filename', 'type', 'size', 'caption', 'report_link', 'hypotheses', 'lift_points', 'samples', 'confidence', 'experiments_id');
    public $id;
    public $filename;
    public $type;
    public $size;
    public $caption;
    public $report_link;
    public $lift_points;
    public $hypotheses;
    public $samples;
    public $confidence;
    public $experiments_id;

    private $temp_path;
    protected $upload_dir = 'images';
    public $errors = array();
    protected $upload_errors = array(
        // http://www.php.net/manual/en/features.file-upload.errors.php
        UPLOAD_ERR_OK => "No errors.",
        UPLOAD_ERR_INI_SIZE => "Larger than upload_max_filesize.",
        UPLOAD_ERR_FORM_SIZE => "Larger than form MAX_FILE_SIZE.",
        UPLOAD_ERR_PARTIAL => "Partial upload.",
        UPLOAD_ERR_NO_FILE => "No file.",
        UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
        UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
        UPLOAD_ERR_EXTENSION => "File upload stopped by extension."
    );

    // pass in $_FILE(['uploaded_file']) as an argument.
    public function attach_file($file)
    {
        // perform error checking on this form
        if (!$file || empty($file) || !array($file)) {
            // error : nothing was uploaded
            $this->errors[] = $this->upload_errors = "No file was uploaded. ";
            return false;
        } elseif ($file['error'] != 0) {
            //error: report what php says went wrong
            $this->errors[] = $this->upload_errors[$file['error']];
            return false;
        } else {
            //set object attributes to the form parameters
            $this->temp_path = $file['tmp_name'];
            $this->filename = basename($file['name']);
            $this->type = $file['type'];
            $this->size = $file['size'];
            return true;

        }
    }

    public function save()
    {
        // a new record will not have an id yet
        if (isset($this->id)) {
            // this will update the caption
            $this->update();
        } else {
            // make sure therre are no errors

            if (!empty($this->errors)) {
                return false;
            }
            // make sure the caption is not to long for the DB
            if (strlen($this->caption) >= 255) {
                //return the error
                $this->errors[] = "The caption can only be 255 characters long. ";
                return false;
            }

            if (empty($this->filename) || empty($this->temp_path)) {
                $this->errors[] = "the location was not available . ";
                return false;
            }
            // Determine the target_path
            $target_path = SITE_ROOT . DS . 'views' . DS . 'public' . DS . $this->upload_dir . DS . $this->filename;
            // make sure a file does not already exist in the target area
            if (file_exists($target_path)) {
                $this->errors[] = "The file {$this->filename} already exists";
                return false;
            }
            // Attempt to move the file
            if (move_uploaded_file($this->temp_path, $target_path)) {
                // Success

                if ($this->create()) {
                    // We are done with temp_path, the file isn't there anymore
                    unset($this->temp_path);
                    return true;
                }
            } else {
                // File was not moved.
                $this->errors[] = "The file upload failed, possibly due to incorrect permissions on the upload folder.";
                return false;
            }
        }
    }

    public function destroy()
    {
        // First remove the database entry
        if ($this->delete()) {
            // then remove the file

            $target_path = SITE_ROOT . DS . 'public' . DS . $this->image_path();
            return unlink($target_path) ? true : false;
        } else {
            // database delete failed
            return false;
        }
    }

    public function image_path()
    {
        $DS = "/";
        return $this->upload_dir . DS . $this->filename;
    }

    public function size_as_text()
    {
        if ($this->size < 1024) {
            return "{$this->size} bytes";
        } elseif ($this->size < 1048576) {
            $size_kb = round($this->size / 1024);
            return "{$size_kb} KB";
        } else {
            $size_mb = round($this->size / 1048576, 1);
            return "{$size_mb} MB";
        }
    }


    // common database methods
    public static function  authenticate($username = "", $password = "")
    {
        global $database;
        $username = $database->escape_value($username);
        $password = $database->escape_value($password);
        $sql = "SELECT * FROM users ";
        $sql .= "WHERE username = '{$username}' ";
        $sql .= "AND password = '{$password}' ";
        $sql .= "LIMIT 1";
        $result_array = self::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : false;

    }

    public function  full_name()
    {
        if (isset($this->first_name) && ($this->last_name)) {
            return $this->first_name . " " . $this->last_name;
        } else {
            return "";
        }
    }

    public static function find_all()
    {

        return self::find_by_sql("SELECT* FROM " . self::$table_name);
    }

    public static function  find_by_id($id = 0)
    {
        global $database;
        $result_array = self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE id={$id} LIMIT 1");

        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function  find_by_exp($id = 0)
    {
        global $database;
        $result_array = self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE experiments_id={$id} ");

        return $result_array;
    }

    public static function  find_by_sql($sql = "")
    {
        global $database;
        $result_set = $database->query($sql);
        //$found = $database->fetch_array($result_set);
        $object_array = array();
        while ($row = $database->fetch_array($result_set)) {
            $object_array[] = self::instantiate($row);
        }
        return $object_array;
    }

    public static function count_all()
    {
        global $database;
        $sql = "SELECT COUNT(*)";
        $sql .= " FROM " . self::$table_name . "";
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);

    }

    private static function instantiate($record)
    {

        $object = new self;


        foreach ($record as $attribute => $value) {
            if ($object->has_attributte($attribute)) {
                $object->$attribute = $value;
            }
        }
        return $object;

        return $object;
    }

    private function has_attributte($attribute)
    {

        $object_vars = get_object_vars($this);
        // we don't care about the value we just want to know they exist and return true or false.
        return array_key_exists($attribute, $object_vars);
    }

    protected function attributes()
    {
        // return an array of attribute names and their values
        $attributes = array();
        foreach (self::$db_fields as $field) {
            if (property_exists($this, $field)) {
                $attributes[$field] = $this->$field;
            }
        }
        return $attributes;
    }

    protected function sanitized_attributes()
    {
        global $database;
        $clean_attributes = array();
        // sanitize the values before submitting

        foreach ($this->attributes() as $key => $value) {
            $clean_attributes[$key] = $database->escape_value($value);
        }
        return $clean_attributes;
    }

    public function create()
    {
        global $database;

        $attributes = $this->sanitized_attributes();
        $sql = "INSERT INTO " . self::$table_name . " (";
        $sql .= join(", ", array_keys($attributes));
        $sql .= ") VALUES ('";
        $sql .= join("', '", array_values($attributes));
        $sql .= "')";
        if ($database->query($sql)) {
            $this->id = $database->insert_id();
            return true;
        } else {
            return false;
        }
    }

    public function update()
    {
        global $database;

        $attributes = $this->sanitized_attributes();
        $attribute_pairs = array();
        foreach ($attributes as $key => $value) {
            $attribute_pairs[] = "{$key}='{$value}'";
        }
        $sql = "UPDATE " . self::$table_name . " SET ";
        $sql .= join(", ", $attribute_pairs);
        $sql .= " WHERE id=" . $database->escape_value($this->id);
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }

    public function delete()
    {
        global $database;

        $sql = "DELETE FROM " . self::$table_name;
        $sql .= " WHERE id=" . $database->escape_value($this->id);
        $sql .= " LIMIT 1";
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;


    }
} 