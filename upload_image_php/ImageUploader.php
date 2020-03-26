<?php
namespace MyApp;

class ImageUploader {

    private $_imageFileName;
    private $_imageType;
    public function upload() {
        # code...
        try {
            //まずエラーチェック
            $this->_validateUpload();
            //次に画像のタイプチェック（phpの処理が変わるため）
            $ext = $this->_validateImageType();
            // var_dump($ext);
            // exit;
            // save
            $savePath = $this->_save($ext);

            // 必要に応じてサムネイルの作成
            $this->_createThumbnails($savePath);

            $_SESSION['success'] = 'Upload Done !';

        } catch (\Exception $e) {
            //throw $th;
            $_SESSION['error'] = $e->getMessage();
            exit;
        }
        // リダイレクト（フォームを送信した後にページ再読み込みをすると、２重投稿になってしまうため
        header('Location: http://' . $_SERVER['HTTP_HOST']);
        exit;
    }

    public function getResults() {
        $success = null;
        $error = null;
        if (isset($_SESSION['success'])) {
            $success = $_SESSION['success'];
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['error'])) {
            $error = $_SESSION['error'];
            unset($_SESSION['error']);
        }
        return [$success, $error];
    }

    public function getImages()
    {
        # code...
        $images = [];
        $files = [];
        $imageDir = opendir(IMAGES_DIR);
        while (false !== ($file = readdir($imageDir))) {
            # code...
            if ($file === '.' || $file === '..') {
                # code...
                continue;
            }
            $files[] = $file;
            if (file_exists(THUMBNAIL_DIR . '/' . $file)) {
                # code...
                $images[] = basename(THUMBNAIL_DIR) . '/' . $file;
            }else {
                $images[] = basename(IMAGES_DIR) . '/' . $file;
            }
        }
        array_multisort($files, SORT_DESC, $images);
        return $images;
    }

    private function _createThumbnails($savePath) {
        $imageSize = getimagesize($savePath);
        $width = $imageSize[0];
        $height = $imageSize[1];

        if($width > THUMBNAIL_WIDTH){
            $this->_createThumbnailMain($savePath, $width, $height);
        }
    }
    private function _createThumbnailMain($savePath, $width, $height) {
        switch ($this->_imageType) {
            case IMAGETYPE_GIF:
                $srcImage = imagecreatefromgif($savePath);
                break;
            case IMAGETYPE_PNG:
                $srcImage = imagecreatefrompng($savePath);
                break;
            case IMAGETYPE_JPEG:
                # code...
                $srcImage = imagecreatefromjpeg($savePath);
                break;

        }
        $thumbHeight = round($height * THUMBNAIL_WIDTH / $width);
        $thumbImage = imagecreatetruecolor(THUMBNAIL_WIDTH, $thumbHeight);
        imagecopyresampled($thumbImage, $srcImage, 0,0, 0, 0, THUMBNAIL_WIDTH, $thumbHeight, $width, $height);

        switch ($this->_imageType) {
            case IMAGETYPE_GIF:
                # code...
                imagegif($thumbImage, THUMBNAIL_DIR . '/' . $this->_imageFileName);
                break;
            case IMAGETYPE_PNG:
                imagepng($thumbImage, THUMBNAIL_DIR . '/' . $this->_imageFileName);
            break;
            case IMAGETYPE_JPEG:
                imagejpeg($thumbImage, THUMBNAIL_DIR . '/' . $this->_imageFileName);
            break;
        }
    }

    private function _save($ext) {
        $this->_imageFileName = sprintf(
            '%s_%s.%s',
            time(),
            sha1(uniqid(mt_rand(), true)),
            $ext
        );
        $savePath = IMAGES_DIR . '/' . $this->_imageFileName;
        $res = move_uploaded_file($_FILES['image']['tmp_name'], $savePath);
        if ($res === false) {
            # code...
            throw new \Exception('Could not upload!');
        }
        return $savePath;
    }

    private function _validateImageType() {
        $this->_imageType = exif_imagetype($_FILES['image']['tmp_name']);
        switch ($this->_imageType) {
            case IMAGETYPE_GIF:
                return 'gif';
            case IMAGETYPE_JPEG:
                return 'jpg';
            case IMAGETYPE_PNG:
                return 'png';

            default:
                # code...
                throw new \Exception('PNG/JPEG/GIF only!');
        }
    }

    private function _validateUpload() {
        // var_dump($_FILES);
        // exit;
        if (!isset($_FILES['image']) || !isset($_FILES['image']['error'])) {
            # code...
            throw new \Exception("Upload Error!", 1);
        }
        switch ($_FILES['image']['error']) {
            case UPLOAD_ERR_OK:
                return true;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                # code...
                throw new \Exception('File too large', 1);

            default:
                # code...
                throw new \Exception('Error:'. $_FILES['image']['error']);
        }
    }

}
