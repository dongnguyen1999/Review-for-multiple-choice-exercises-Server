<?php


class UserModel
{

    public $userId;
    public $email;
    public $name;
    public $password;
    public $avatar;
    public $phone;

    public static $DEFAULT_PASSWORD;

    public function __construct($data) {
        $this->userId = isset($data['userId'])? $data['userId']: null;
        $this->email = $data['email'];
        $this->password = isset($data['password'])? $data['password']: UserModel::$DEFAULT_PASSWORD;
        $this->name = isset($data['name'])? $data['name']: null;
        $this->avatar = isset($data['avatar'])? $data['avatar']: null;
        $this->phone = isset($data['phone'])? $data['phone']: null;
    }

    public function saveUserAvatar() {
        // Save user avatar image
        if ($this->avatar != null) {
            $imgId = rand();
            $email = $this->email;
            if ($email == null) $email = $this->userId;
            $avatarFileName = "$email-$imgId.png";
            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $this->avatar));
            file_put_contents("../data/avatar/$avatarFileName", $data);
            $this->avatar = "/data/avatar/$avatarFileName";
        }
    }

}

UserModel::$DEFAULT_PASSWORD = hash('md5', 'social-media-user');

