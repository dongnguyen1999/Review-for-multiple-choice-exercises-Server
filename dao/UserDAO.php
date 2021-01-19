<?php
include_once ('dbconnect.php');
include_once ('../model/UserModel.php');

class UserDAO
{
    public static function findById($id){
        global $conn;
        $sql = "SELECT * FROM USER WHERE userId = '$id'";
        $res = $conn->query($sql);
        if ($res->num_rows > 0) {
            return new UserModel($res->fetch_assoc());
        } else return null;
    }

    public static function findByEmailPassword($email, $password) {
        global $conn;
        $sql = "SELECT * FROM USER WHERE email = '$email' AND password = '$password'";
        $res = $conn->query($sql);
        if ($res->num_rows > 0) {
            return new UserModel($res->fetch_assoc());
        } else return null;
    }

    public static function findByEmail($email){
        global $conn;
        $sql = "SELECT * FROM USER WHERE email = '$email'";
        $res = $conn->query($sql);

        if ($res->num_rows > 0) {
            return new UserModel($res->fetch_assoc());
        } else return null;
    }

    // Insert a new row to USER table, optional field will be filled with null
    // if model has userId field != null, update exist user
    public static function save($model) {
        global $conn;

        if ($model->userId != null) {
            $sql = "SELECT * FROM USER WHERE userId = '$model->userId'";
            $res = $conn->query($sql);
            if ($res->num_rows > 0) {
                $oldUser = new UserModel($res->fetch_assoc());
                $userId = $oldUser->userId;
                $sql = "UPDATE USER SET email = %email, password = %password, name = %name, phone = %phone, avatar = %avatar WHERE userId = '$userId'";        
                $sql = str_replace('%email', $model->email!=null? "'$model->email'": "'$oldUser->email'", $sql);
                $sql = str_replace('%password', $model->password!=null? "'$model->password'": "'$oldUser->password'", $sql);
                $sql = str_replace('%name', $model->name!=null? "'$model->name'": "'$oldUser->name'", $sql);
                $sql = str_replace('%phone', $model->phone!=null? "'$model->phone'": "'$oldUser->phone'", $sql);
                $sql = str_replace('%avatar', $model->avatar!=null? "'$model->avatar'": "'$oldUser->avatar'", $sql);
                $sql = str_replace("''", "null", $sql);
                // echo $sql;
                if ($conn->query($sql) === true) {
                    return UserDAO::findById($userId);
                } else return null;

            } else return null;
        } else {
            $sql = "INSERT INTO USER(email, password, name, phone, avatar) VALUES (%email, %password, %name, %phone, %avatar)";
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
