<?php
require_once 'config.php';
require_once 'models/Auth.php';
require_once 'dao/UserDaoMySql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

$userDao = new UserDaoMySql($pdo);

$name = filter_input(INPUT_POST, 'name');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$birthdate = filter_input(INPUT_POST, 'birthdate');
$city = filter_input(INPUT_POST, 'city');
$work = filter_input(INPUT_POST, 'work');
$password = filter_input(INPUT_POST, 'password');
$password_confirmation = filter_input(INPUT_POST, 'password_confirmation');

if ($name && $email) {
    $userInfo->name = $name;
    $userInfo->city = $city;
    $userInfo->work = $work;

    // E-MAIL
    if ($userInfo->email != $email) {
        if ($userDao->findByEmail($email) === false) {
            $userInfo->email = $email;
        } else {
            $_SESSION['flash'] = 'E-mail já existe!';                        
            header("Location: ".$base."/configuracoes.php");
            exit;
        }
    }

    // BIRTHDATE
    $birthdate = explode('/', $birthdate);

    if (count($birthdate) != 3) {
        $_SESSION['flash'] = 'Data de nascimento inválida';
        header("Location: ".$base."/configuracoes.php");
        exit;
    }

    $birthdate = $birthdate[2] . '-' .$birthdate[1] . '-' . $birthdate[0];
    if (strtotime($birthdate) === false) {
        $_SESSION['flash'] = 'Data de nascimento inválida';
        header("Location: ".$base."/configuracoes.php");
        exit;
    }

    $userInfo->birthdate = $birthdate;

    // PASSWORD
    if (!empty($password)) {
        if ($password === $password_confirmation) {
            $userInfo->password = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $_SESSION['flash'] = 'As senhas não batem!';
            header("Location: ".$base."/configuracoes.php");
            exit;
        }
    }

    //AVATAR

    if ($_FILES['avatar'] && !empty($_FILES['avatar']['tmp_name'])) {
        $newAvatar = $_FILES['avatar'];

        if (in_array($newAvatar['type'], ['image/jpeg', 'image/jpg', 'image/png'])) {
            $avatarWidth = 200;
            $avatarHeigth = 200;

            list($widthOrig, $heigthOrig) = getimagesize($newAvatar['tmp_name']);
            $ratio = $widthOrig / $heigthOrig;

            $newWidth = $avatarWidth;
            $newHeigth = $newWidth / $ratio;

            if ($newHeigth < $avatarHeigth) {
                $newHeigth = $avatarHeigth;
                $newWidth = $newHeigth * $ratio;
            } 

            $x = $avatarWidth - $newWidth;
            $y = $avatarHeigth - $newHeigth;
            $x = $x<0 ? $x/2 : $x;
            $y = $y<0 ? $y/2 : $y;

            $finalImage = imagecreatetruecolor($avatarWidth, $avatarHeigth);

            switch ($newAvatar['type']) {
                case 'image/jpeg':
                case 'image/jpg':
                    $image = imagecreatefromjpeg($newAvatar['tmp_name']);
                    break;                
                case 'image/png':
                    $image = imagecreatefrompng($newAvatar['tmp_name']);
                    break;
            }

            imagecopyresampled(
                $finalImage, $image,
                $x, $y, 0, 0,
                $newWidth, $newHeigth,
                $widthOrig, $heigthOrig
            );

            $avatarName = md5(time().rand(0,9999)).'.jpg';

            imagejpeg($finalImage, './media/avatars/' . $avatarName, 100);
            
            $userInfo->avatar = $avatarName;
        }
    }

    //COVER

    if ($_FILES['cover'] && !empty($_FILES['cover']['tmp_name'])) {
        $newCover = $_FILES['cover'];

        if (in_array($newCover['type'], ['image/jpeg', 'image/jpg', 'image/png'])) {
            $coverWidth = 850;
            $coverHeigth = 310;

            list($widthOrig, $heigthOrig) = getimagesize($newCover['tmp_name']);
            $ratio = $widthOrig / $heigthOrig;

            $newWidth = $coverWidth;
            $newHeigth = $newWidth / $ratio;

            if ($newHeigth < $coverHeigth) {
                $newHeigth = $coverHeigth;
                $newWidth = $newHeigth * $ratio;
            } 

            $x = $coverWidth - $newWidth;
            $y = $coverHeigth - $newHeigth;
            $x = $x<0 ? $x/2 : $x;
            $y = $y<0 ? $y/2 : $y;

            $finalImage = imagecreatetruecolor($coverWidth, $coverHeigth);

            switch ($newCover['type']) {
                case 'image/jpeg':
                case 'image/jpg':
                    $image = imagecreatefromjpeg($newCover['tmp_name']);
                    break;                
                case 'image/png':
                    $image = imagecreatefrompng($newCover['tmp_name']);
                    break;
            }

            imagecopyresampled(
                $finalImage, $image,
                $x, $y, 0, 0,
                $newWidth, $newHeigth,
                $widthOrig, $heigthOrig
            );

            $coverName = md5(time().rand(0,9999)).'.jpg';

            imagejpeg($finalImage, './media/covers/' . $coverName, 100);
            
            $userInfo->cover = $coverName;
        }
    }

    $userDao->update($userInfo);
}

header("Location: ".$base."/configuracoes.php");
exit;