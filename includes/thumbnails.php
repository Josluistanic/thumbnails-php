<?php

createThumbnail($_FILES['img']['name']);

/**
 * It creates a thumbnail of the image that was uploaded.
 * 
 * @param file_name The name of the file that you want to create a thumbnail for.
 */
function createThumbnail($file_name)
{
    $final_width        = 100;
    $dir_fullsize_img   = '../img/fullSize/';
    $dir_thumbnail_img  = '../img/thumbs/';
    $tmp_name           = $_FILES['img']['tmp_name'];
    $final_name         = $dir_fullsize_img . $_FILES['img']['name'];

    move_uploaded_file($tmp_name, $final_name);

    $img = null;

    if (preg_match('/[.](jpg)$/', $file_name)) {
        $img = imagecreatefromjpeg($final_name);
    } else if (preg_match('/[.](gif)$/', $file_name)) {
        $img = imagecreatefromgif($final_name);
    } else if (preg_match('/[.](png)$/', $file_name)) {
        $img = imagecreatefrompng($final_name);
    }

    $width = imagesx($img);
    $height = imagesy($img);

    $thumb_width = $final_width;
    $thumb_height = floor($height * ($final_width / $width));
    $image_true_color = imagecreatetruecolor($thumb_width, $thumb_height);

    imagecopyresized($image_true_color, $img, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height);

    if (!file_exists($dir_thumbnail_img)) {
        if (!mkdir($dir_thumbnail_img)) {
            die("Could not create directory $dir_thumbnail_img");
        }
    }
    imagejpeg($image_true_color, $dir_thumbnail_img . $file_name);
}
