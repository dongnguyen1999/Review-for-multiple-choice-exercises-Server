<?php
include_once ('dbconnect.php');
include_once ('../model/UserModel.php');

class UserDAO
{
    public static function findById($id){
        global $conn;
        $sql = "SELECT * FROM user WHERE userId = '$id'";
        $res = $conn->query($sql);
        if ($res->num_rows > 0) {
            return new UserModel($res->fetch_assoc());
        } else return null;
    }

    public static function findByEmailPassword($email, $password) {
        global $conn;
        $sql = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
        $res = $conn->query($sql);
        if ($res->num_rows > 0) {
            return new UserModel($res->fetch_assoc());
        } else return null;
    }

    public static function findByEmail($email){
        global $conn;
        $sql = "SELECT * FROM user WHERE email = '$email'";
        $res = $conn->query($sql);
        if ($res->num_rows > 0) {
            return new UserModel($res->fetch_assoc());
        } else return null;
    }

    // Insert a new row to user table, optional field will be filled with null
    public static function save($model) {
        global $conn;
        $sql = "INSERT INTO user(email, password, name, phone, avatar) VALUES (%email, %password, %name, %phone, %avatar)";

        $sql = str_replace('%email', "'$model->email'", $sql);
        $sql = str_replace('%password', "'$model->password'", $sql);
        $sql = str_replace('%name', $model->name!=null? "'$model->name'": "null", $sql);
        $sql = str_replace('%phone', $model->phone!=null? "'$model->phone'": "null", $sql);
        $sql = str_replace('%avatar', $model->avatar!=null? "'$model->avatar'": "null", $sql);

        if ($conn->query($sql) === true) {
            $last_id = $conn->insert_id;
            return UserDAO::findById($last_id);
        } else return null;
    }

    public static function findAll() {
        global $conn;
        $data = array();
        $sql = "SELECT * FROM USER";
        $res = $conn->query($sql);
        while ($row = mysqli_fetch_assoc($res)) {
            array_push($data, new UserModel($row));
        }
        return $data;
    }



}
