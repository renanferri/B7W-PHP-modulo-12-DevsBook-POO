<?php
require_once 'config.php';
require_once 'models/Auth.php';
require_once 'dao/PostDaoMySql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

$array = ['error' => ''];

$postDao = new PostDaoMySql($pdo);

if (isset($_FILES['photo']) && !empty($_FILES['photo']['tmp_name'])) {
    $photo = $_FILES['photo'];

    if(in_array($photo['type'], ['image/png', 'image/jpg', 'image/jpeg'])) {
        list($widthOrig, $heightOrig) = getimagesize($photo['tmp_name']);
        $ratio = $widthOrig / $heightOrig;

        $newWidth = $maxWidth;
        $newHeight = $maxHeight;
        $ratioMax = $newWidth / $maxHeight;
        
        if ($ratioMax > $ratio) { // 1 > 0,8 
            // 800 / 1000 = 0,8 => retangulo com altura maior
            $newWidth = $newHeight * $ratio; // 800 * 0,8 = 640
            // $newWidth = 640
            // $newHeight = 800
        } else { // 1 > 1,25
            // 1000 / 800 = 1,25 => retangulo com base maior
            $newHeight = $newWidth / $ratio; // 800 / 1,25 = 640
            // $newHeight = 640
            // $newWidth = 800
        }

        $finalImage = imagecreatetruecolor($newWidth, $newHeight);
        switch ($photo['type']) {
            case 'image/png':
                $image = imagecreatefrompng($photo['tmp_name']);
                break;                    
            case 'image/jpg':
            case 'image/jpeg':
                $image = imagecreatefromjpeg($photo['tmp_name']);
                break;
        }

        imagecopyresampled(
            $finalImage, $image,
            0, 0, 0, 0,
            $newWidth, $newHeight, $widthOrig, $heightOrig
        );

        $photoName = md5(time().rand(0,9999)).'.jpg';

        imagejpeg($finalImage, 'media/uploads/'.$photoName);

        $newPost = new Post();
        $newPost->id_user = $userInfo->id;
        $newPost->type = 'photo';
        $newPost->created_at = date('Y-m-d H:i:s');
        $newPost->body = $photoName;

        $postDao->insert($newPost);

    } else {
        $array['error'] = 'Arquivo não suportado (jpg ou png)';    
    }

} else {
    $array['error'] = 'Nenhuma imagem enviada';
}

header("Content-Type: application/json");
echo json_encode($array);
exit;