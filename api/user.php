<?php
include_once("../dao/dbconnect.php");
include_once("../dao/UserDAO.php");
include_once("../model/ResponseData.php");
include_once("../model/UserModel.php");

// url: http://hostname/api/user.php
// POST - formdata
// {
//    'type': 'register',
//    'email': 'nvdkg1999@gmail.com',
//    //Optional
//    'password': 'meomeo', //use default password if password is null, default password: hashmd5('social-media-user')
//    'name': 'Full name',
//    'avatar': 'base64encodedimage'
//    'phone': '0334007127',
// }

// Register an user account
// Register success response new inserted user info
// Else return error message

if(isset($_POST['type']) && $_POST['type'] == "register") {
    try {

        $user = new UserModel($_POST); // Map request data from $_POST

        $existUser = UserDAO::findByEmail($user->email);
        if ($existUser != null) {
            echo ResponseData::ResponseFail("Email đã được sử dụng đăng ký tài khoản");
            die();
        }

        if ($user->password == null) {
            $user->password = UserModel::$DEFAULT_PASSWORD;
        }
        $user->saveUserAvatar();

        $user = UserDAO::save($user); // insert new user with post data

        if ($user != null) {
            unset($user->password);
            echo ResponseData::ResponseSuccess('Đăng ký thành công', $user);
        } else {
            echo ResponseData::ResponseFail("Lỗi đăng ký, vui lòng thử lại");
        }

    } catch(Exception $e) {
        echo ResponseData::ResponseFail("Đăng ký thất bại: $e");
    }

}


//url: http://hostname/api/user.php
//POST - formdata
// {
//    'type': 'edit',
//    'userId': '1', // for identify editing user
//    //Optional
//    'password': 'meomeo', //use default password if password is null, default password: hashmd5('social-media-user')
//    'name': 'Full name',
//    'avatar': 'base64encodedimage'
//    'phone': '0334007127',
//    'email': 'nvdkg1999@gmail.com',
// }
//
// Register an user account
// Register success response new inserted user info
// Else return error message

if(isset($_POST['type']) && $_POST['type'] == "edit") {
    try {

        $user = new UserModel($_POST); // Map request data from $_POST, include 'userId'

        $user->saveUserAvatar();

        $user = UserDAO::save($user); // update exist user with post data

        if ($user != null) {
            unset($user->password);
            echo ResponseData::ResponseSuccess('Sửa thông tin thành công', $user);
        } else {
            echo ResponseData::ResponseFail("Lỗi trong hệ thống, vui lòng thử lại sau");
        }

    } catch(Exception $e) {
        echo ResponseData::ResponseFail("Sửa thông tin thất bại: $e");
    }

}


//url: http://hostname/api/user.php
//GET
//{
//    'type': 'list',
//    //Optional
//    'userId': '1' // Get info of one user by its userid
//    'email': 'email@com' // Get info of one user by its email
//}

//Get user data with username, userid, or all user
//Response user data, array of userdata
if(isset($_GET['type']) && $_GET['type'] == "list"){
    $data = array();
    if (isset($_GET['userId'])) { // get one by user id
        $userid = trim($_GET['userId']);
        $data = UserDAO::findById($userid);
        unset($data->password);
    } else if (isset($_GET['email'])) { // get one by user email
        $email = trim($_GET['email']);
        $data = UserDAO::findByEmail($email);
        unset($data->password);
    } else { // list all user
        $data = UserDAO::findAll();
    }
    echo ResponseData::ResponseSuccess('Truy vấn người dùng thành công', $data);
}

//url: http://hostname/api/login.php
//GET
//{
//    'type': 'login',
//    'email': 'email@com',
//    'password': 'meomeo'
//}
// Login success response user info
// Else response error message
if(isset($_GET['type']) && $_GET['type'] == "login"){
    $email = trim($_GET['email']);
    $password = trim($_GET['password']);

    if($email != "" && $password != "") {
        $user = UserDAO::findByEmailPassword($email, $password);
        if ($user != null) {
            unset($user->password);
            echo ResponseData::ResponseSuccess('Đăng nhập thành công', $user);
        } else echo ResponseData::ResponseFail("Tên tài khoản hoặc mật khẩu không chính xác");
    } else echo ResponseData::ResponseFail("Nhập vào đầy đủ tài khoản và mật khẩu");
}
