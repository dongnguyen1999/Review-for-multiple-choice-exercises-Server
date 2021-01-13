<?php
 include_once("dbconnect.php");

 include_once("ResponseData.php");

 session_start();

//url: http://hostname/api/login.php
//POST
//{
//    'type': 'register',
//    'name': 'Full name',
//    'username': 'username1',
//    'password': 'meomeo'
//    'email': 'abc@mail.com',
//    'phone': '0334007127',
//}

 if(isset($_POST['type']) && $_POST['type'] == "register") {
 	try {
 		global $conn;

 		$username = $_POST['username'];
        $name = $_POST['name'];
        $password = $_POST['password'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];

        $sql = "SELECT * FROM user WHERE username = '$username'";
        if ($conn->query($sql)->num_rows > 0) {
            echo ResponseData::ResponseFail("Tên tài khoản đã tồn tại trên hệ thống");
            die();
        }
        $sql = "INSERT INTO USER(username, password, name, phone, email) VALUES ('$username', '$password', '$name', '$phone', '$email')";

        if ($conn->query($sql) === true) {
            $last_id = $conn->insert_id;
            $sql = "SELECT * FROM user WHERE userid = '$last_id'";
            $result = $conn->query($sql);
            echo ResponseData::ResponseSuccess('Đăng ký thành công', $result->fetch_assoc());
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

if(isset($_GET['type']) && $_GET['type'] == "login"){
    $username = trim($_GET['username']);
    $password = trim($_GET['password']);
    

    if($username != "" && $password != "")
    {
        $resultArr = array();
        $data = array();
        $sql = "select * from user where username= '".$username."' and password= '".$password."'";
        $res = mysqli_query($conn,$sql);

        while ($row = mysqli_fetch_assoc($res)) {
            array_push($data, $row);
        }
        if ($conn->query($sql)->num_rows > 0) {
       echo ResponseData::ResponseSuccess('Đăng nhập thành công', $data);
//        tao session
//        put username to session
           
            $_SESSION['username'] = $username;

        }else{
            echo ResponseData::ResponseFail("Đăng nhập thất bại");

        }
    }
    
    else{
        echo ResponseData::ResponseFail("Nhập vào đầy đủ tài khoản và mật khẩu");
    }

}


//url: http://hostname/api/login.php
//GET
//{
//    'type': 'checkLoggedIn',
//    'username': 'username1',
//}

//Response current logged in user | null

if(isset($_GET['type']) && $_GET['type'] == "checkLoggedIn"){

 if (!isset($_SESSION['username'])) {
    echo ResponseData::ResponseFail("Không có sesion");
     
   }else{
     
       $sesionname=$_SESSION['username'];
    ///$sql = "SELECT * FROM user WHERE username = '$sesionname'";
    $data = array();
    $sql = "select * from user where username= '".$sesionname."' ";
    $res = mysqli_query($conn,$sql);

    while ($row = mysqli_fetch_assoc($res)) {
        array_push($data, $row);
    }
    echo ResponseData::ResponseSuccess('Sesion', $data);

   }


}


//url: http://hostname/api/login.php
//GET
//{
//    'type': 'logout',
//    'username': 'username1',
//}

//Response 0 | 1
if(isset($_GET['type']) && $_GET['type'] == "logout"){
   
    unset($_SESSION['username']);

}




?>