<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $targetDir = "upload/"; // 上传目录
    $fileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
    $fileName = '';
    $uploadOk = 1;
    $maxFileSize = 5 * 1024 * 1024; // 5MB

    if ($_FILES["fileToUpload"]["size"] > $maxFileSize) {
        echo "文件大小超过限制。";
        $uploadOk = 0;
    }

    if ($fileType == "jpg") {
        $prefix = 'p';
        $allowedImageFormats = array("jpg");
    } elseif ($fileType == "mp4") {
        $prefix = 'v';
        $allowedVideoFormats = array("mp4");
    } else {
        echo "仅支持上传图片格式为 JPG 和视频格式为 MP4。";
        $uploadOk = 0;
    }

    if (!in_array($fileType, $allowedImageFormats) && !in_array($fileType, $allowedVideoFormats)) {
        echo "不支持的文件类型。";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "上传失败，请检查文件类型和大小。";
    } else {
        $i = 1;
        while (true) {
            $targetFile = $targetDir . $prefix . $i . '.' . $fileType;
            if (!file_exists($targetFile)) {
                break;
            }
            $i++;
        }

        // 新增以下两行代码来重命名上传的文件
        $originalFileName = basename($_FILES["fileToUpload"]["name"]);
        $_FILES["fileToUpload"]["name"] = $prefix . $i . '.' . $fileType;

        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            echo "文件已成功上传";
        } else {
            echo "上传文件时发生错误。";
        }
    }
}
?>
