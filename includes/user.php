<?php
/**
 * Created by PhpStorm.
 * User: can you dig it
 * Date: 1/12/14
 * Time: 1:21 PM
 */
require_once(LIB_PATH . DS . 'database.php');

class User extends DatabaseObject
{
    protected static $table_name = "users";
    protected static $db_fields = array('id', 'salt', 'username', 'password', 'company_name', 'role', 'active_collabID');
    public $username;
    public $id;
    public $salt;
    public $password;
    public $company_name;
    public $active_collabID;
    public $role;

    // common database methods
    public static function  authenticate($username = "", $password = "")
    {
        global $database;
//        $saltString = "nongesticulatingitalian";
//        $password .= $saltString ;
//        $ecryptedString = sha1($password);

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
    public static function find_duplicate($username = "")
    {
        global $database;
        $result_array = self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE username='" . $database->escape_value($username) .
           "' LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function find_all()
    {

        return self::find_by_sql("SELECT * FROM " . self::$table_name);
    }

    public static function  find_by_id($id = 0)
    {
        global $database;
        $result_array = self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE id={$id} LIMIT 1");

        return !empty($result_array) ? array_shift($result_array) : false;
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
    }

    private function has_attributte($attribute)
    {
        //get_object_vars returns an associative array with all attributes including the private ones
        //as the keys and their current values as the value.
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

    public function save()
    {
        // determine if needs update or create by checking for an id
        return isset($this->id) ? $this->update() : $this->create();
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