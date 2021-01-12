<?php
 include_once("dbconnect.php");

 include_once("ResponseData.php");


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

//Response
//{
//    "errorCode": 0,
//    "message": "Đăng ký thành công",
//    "data": {
//    "USERID": "3",
//        "NAME": "Dong Nguyen",
//        "USERNAME": "username3",
//        "PASSWORD": "12345",
//        "EMAIL": "abc@mail",
//        "PHONE": "13233543"
//    }
//}

//{
//    "errorCode": 1,
//    "message": "Tên tài khoản đã tồn tại trên hệ thống",
//    "data": null
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


       echo ResponseData::ResponseSuccess('Đăng nhập thành công', $data);
    
        
    }
    
    
    else{
        echo ResponseData::ResponseFail("Nhập vào đầy đủ tài khoản và mật khẩu");
    }

}


?>