<?php
include_once("../dao/dbconnect.php");
include_once("../dao/UserDAO.php");
include_once("../model/ResponseData.php");
include_once("../model/UserModel.php");

session_start();

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
            $_SESSION['email'] = $user->email;
            unset($user->password);
            echo ResponseData::ResponseSuccess('Đăng nhập thành công', $user);
        } else echo ResponseData::ResponseFail("Tên tài khoản hoặc mật khẩu không chính xác");
    } else echo ResponseData::ResponseFail("Nhập vào đầy đủ tài khoản và mật khẩu");
}


//url: http://hostname/api/login.php
//GET
//{
//    'type': 'checkLoggedIn',
//}

//Response success if user is logged in
//Response fail if user has not logged in
if(isset($_GET['type']) && $_GET['type'] == "checkLoggedIn"){

    if (!isset($_SESSION['email'])) {
        echo ResponseData::ResponseFail("Người dùng chưa đăng nhập");
    }else{
        $email = $_SESSION['email'];
        $user = UserDAO::findByEmail($email);
        unset($user->password);
        echo ResponseData::ResponseSuccess('Người dùng đang đăng nhập', $user);
   }

}


//url: http://hostname/api/login.php
//GET
//{
//    'type': 'logout',
//}

//Logout: remove user name from session
//No response !
if(isset($_GET['type']) && $_GET['type'] == "logout"){
    unset($_SESSION['email']);
}

