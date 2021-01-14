<?php
include_once("dbconnect.php");
include_once("ResponseData.php");
include_once("ResponseData.php");

session_start();

//url: http://hostname/api/login.php
//POST - formdata
//{
//    'type': 'register',
//    'name': 'Full name',
//    'username': 'username1',
//    'password': 'meomeo'
//    'avatar': 'base64encodedimage'
//    'email': 'abc@mail.com',
//    'phone': '0334007127',
//}

// Register an user account
// Register success response new inserted user info
// Else return error message
if(isset($_POST['type']) && $_POST['type'] == "register") {
    try {
        global $conn;

        $username = isset($_POST['username'])? $_POST['username']: null;
        $name = isset($_POST['name'])? $_POST['name']: null;
        $password = isset($_POST['password'])? $_POST['password']: null;
        $image = isset($_POST['avatar'])? $_POST['avatar']: null;
        $phone = isset($_POST['phone'])? $_POST['phone']: null;
        $email = isset($_POST['email'])? $_POST['email']: null;

        $sql = "SELECT * FROM user WHERE username = '$username'";
        if ($conn->query($sql)->num_rows > 0) {
            echo ResponseData::ResponseFail("Tên tài khoản đã tồn tại trên hệ thống");
            die();
        }

        // Save user avatar image
        if ($image != null) {
            $imgId = rand();
            $avatarFileName = "$username$imgId.jpg";
            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));
            file_put_contents("../data/avatar/$avatarFileName", $data);
            $avatarPath = "/data/avatar/$avatarFileName";
        } else {
            $avatarPath = null;
        }


        $sql = "INSERT INTO USER(username, password, name, phone, email, avatar) VALUES ('$username', '$password', '$name', '$phone', '$email', '$avatarPath')";

        if ($conn->query($sql) === true) {
            $last_id = $conn->insert_id;
            $sql = "SELECT * FROM user WHERE userid = '$last_id'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            unset($row['PASSWORD']); //exclude password field
            echo ResponseData::ResponseSuccess('Đăng ký thành công', $row);
        } else {
            echo ResponseData::ResponseFail("Tên tài khoản hoặc mật khẩu không chính xác");
        }
    } catch(Exception $e) {
        echo ResponseData::ResponseFail("Đăng ký thất bại: $e");
    }

}


//url: http://hostname/api/login.php
//GET
//{
//    'type': 'login',
//    'username': 'username1',
//    'password': 'meomeo'
//}
// Login success response user info
// Else response error message
if(isset($_GET['type']) && $_GET['type'] == "login"){
    $username = trim($_GET['username']);
    $password = trim($_GET['password']);

    if($username != "" && $password != "") {
        $resultArr = array();
        $data = array();
        $sql = "select * from user where username= '" . $username . "' and password= '" . $password . "'";
        $res = mysqli_query($conn, $sql);

        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            //Keep username in session
            $username = $row['USERNAME'];
            $_SESSION['username'] = $username;
            unset($row['PASSWORD']); //exclude password field
            echo ResponseData::ResponseSuccess('Đăng nhập thành công', $row);
        } else {
            echo ResponseData::ResponseFail("Tên tài khoản hoặc mật khẩu không chính xác");
        }
    } else{
        echo ResponseData::ResponseFail("Nhập vào đầy đủ tài khoản và mật khẩu");
    }

}


//url: http://hostname/api/login.php
//GET
//{
//    'type': 'currentUser',
//}

//Response success if user is logged in
//Response fail if user has not logged in
if(isset($_GET['type']) && $_GET['type'] == "currentUser"){

    if (!isset($_SESSION['username'])) {
        echo ResponseData::ResponseFail("Người dùng chưa đăng nhập");
    }else{
     
        $sesionname=$_SESSION['username'];
        ///$sql = "SELECT * FROM user WHERE username = '$sesionname'";
        $sql = "select * from user where username= '".$sesionname."' ";
        $res = mysqli_query($conn,$sql);
        $row = $res->fetch_assoc();
        unset($row['PASSWORD']); //exclude password field
        echo ResponseData::ResponseSuccess('Người dùng đang đăng nhập', $row);
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
    unset($_SESSION['username']);
}


//url: http://hostname/api/login.php
//GET
//{
//    'type': 'userInfo',
//    'username': 'username1'
//}

//Get user data with username
//Response user data or not found user name error
if(isset($_GET['type']) && $_GET['type'] == "userInfo"){
    $username = $_GET['username'];
    $sql = "select * from user where username = '$username'";
    $res = mysqli_query($conn,$sql);
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        unset($row['PASSWORD']); //exclude password field
        echo ResponseData::ResponseSuccess('Thông tin người dùng', $row);
    } else {
        ResponseData::ResponseFail('Người dùng không tồn tại');
    }
}

?>