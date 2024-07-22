<form action="#" method="post" enctype="multipart/form-data">
    <label for="img">Upload Any image</label>
    <input type="file" name="img" id="img" accept="image/*">
    <input type="submit" name="submit" value="Submit">
</form>
<?php
if (isset($_POST['submit'])) {

    try {
        $FILE = $_FILES['img'] ?? null;

        if (!$FILE || $FILE['error'] != UPLOAD_ERR_OK) {
            throw new Exception("File upload error", 400);
        }

        // Set the dimensions you want for your image
        $imgDimensions = [
            'height' => 60,
            'width' => 140,
        ];

        // Set the quality of the img range from 10 to 100
        $quality = 95;

        $compressed_img = ($imgDimensions['height'] == null || $imgDimensions['width'] == null) ? 
            compressImg($FILE, $quality) : 
            compressImg($FILE, $quality, $imgDimensions);

        // Moving the image data from local to '/compressed_image/'
        if (isset($compressed_img['tmp_name'])) {
            $ext = pathinfo($FILE['name'], PATHINFO_EXTENSION);
            $name = pathinfo($FILE['name'], PATHINFO_FILENAME);
            $target_dir = __DIR__ . "/compressed_image/";
            
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $new_addr = $target_dir . $name . "_compressed." . $ext;

            if (rename($compressed_img['tmp_name'], $new_addr)) {
                echo "Image Compressed successfully and saved to $new_addr";
            } else {
                throw new Exception("Failed to move compressed image", 400);
            }

        } else {
            throw new Exception("Compression failed", 400);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

function compressImg($imgObj, $quality = 50, $imgDimensions = []) {
    try {
        $imgObj['type'] = getimagesize($imgObj['tmp_name'])['mime'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

        if (!in_array($imgObj['type'], $allowedTypes)) {
            throw new Exception("Unsupported image type", 415);
        }

        switch ($imgObj['type']) {
            case 'image/jpeg':
            case 'image/jpg':
                $image = imagecreatefromjpeg($imgObj['tmp_name']);
                break;
            case 'image/png':
                $image = imagecreatefrompng($imgObj['tmp_name']);
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($imgObj['tmp_name']);
                break;
            default:
                throw new Exception("Unexpected image type", 415);
        }

        if (count($imgDimensions) == 2) {
            list($width, $height) = getimagesize($imgObj['tmp_name']);
            $source = $image;
            $image = imagecreatetruecolor($imgDimensions['width'], $imgDimensions['height']);

            // Alpha blending and save the alpha channel information
            imagealphablending($image, false);
            imagesavealpha($image, true);

            // Transparent image
            $transparentColor = imagecolorallocatealpha($image, 0, 0, 0, 127);
            imagefill($image, 0, 0, $transparentColor);

            // Resize
            imagecopyresized($image, $source, 0, 0, 0, 0, $imgDimensions['width'], $imgDimensions['height'], $width, $height);
            imagedestroy($source);
        }

        $success = false;
        $tmp_name = tempnam(sys_get_temp_dir(), 'compressed_img_');
        
        switch ($imgObj['type']) {
            case 'image/jpeg':
            case 'image/jpg':
                $success = imagejpeg($image, $tmp_name, $quality);
                break;
            case 'image/png':
                $success = imagepng($image, $tmp_name, (int)($quality / 11));
                break;
            case 'image/webp':
                $success = imagewebp($image, $tmp_name, $quality);
                break;
        }

        imagedestroy($image);
        
        if (!$success) {
            throw new Exception("Failed to compress image", 400);
        }

        return ['tmp_name' => $tmp_name, 'type' => $imgObj['type']];
    } catch (Exception $e) {
        return $e;
    }
}
?>
