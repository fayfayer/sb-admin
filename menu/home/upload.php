<?php

    if (isset($_POST["btnUpload"])) {
        $file_photo = $_FILES["photo"];
        /* if ($file_photo["tmp_name"] !== "") {
            echo "photonya ada.<br>";
            var_dump($file_photo);
        } else {
            echo "photonya nggak ada.!<br>";
            var_dump($file_photo);
        }
        exit; */

        $file_name = explode(".",$file_photo["name"]);
        $file_name = sha1(uniqid()).".".end($file_name);
        $path = "upload/".basename($file_name);
        $imageFileType = pathinfo($path,PATHINFO_EXTENSION);
        $error = null;
        if ($file_photo["tmp_name"] !== "") {
            $allowType = array("jpg","jpeg","png","gif");
            if (!in_array($imageFileType,$allowType)) {
                $error = "Format gambar tidak di boleh kan...<br>";
                $error .= "yang di bolehkan adalah jpg,jpeg,png dan gif..";
                echo $error;
            } else {
                if ($file_photo["size"] > (1000 * 1024)) {
                    $error = "Ukuran gambar ke gedean..";
                    echo $error;
                } else {
                    move_uploaded_file($file_photo["tmp_name"],$path);
                    echo "<br>";
                    var_dump($file_photo);
                    echo "<br>";
                    var_dump($imageFileType);
                    echo "<br>";
                    /* var_dump($file_name);
                    echo "<br>"; */
                }
            }
        } else {
            $file_name = "data kosong..!";
        }

        if (!isset($error)) {
            echo $file_name;
        }
    }

    /*   array(5) { ["name"]=> string(37) "aplikasi-karaoke-android-150x150.jpeg" ["type"]=> string(10) "image/jpeg" ["tmp_name"]=> string(24) "C:\xampp\tmp\phpA78F.tmp" ["error"]=> int(0) ["size"]=> int(8136) }    */

    /* array(5) { ["name"]=> string(38) "Cara-Bobol-Wifi-Dengan-CMD-150x150.jpg" ["type"]=> string(10) "image/jpeg" ["tmp_name"]=> string(24) "C:\xampp\tmp\php4F01.tmp" ["error"]=> int(0) ["size"]=> int(6113) }  */

    /* array(5) { ["name"]=> string(34) "internetan-mode-pesawat-100x80.png" ["type"]=> string(9) "image/png" ["tmp_name"]=> string(24) "C:\xampp\tmp\php4A6A.tmp" ["error"]=> int(0) ["size"]=> int(8798) } */

    /* array(5) { ["name"]=> string(37) "_ILOVEMYBODY_banner_160x600_FINAL.gif" ["type"]=> string(9) "image/gif" ["tmp_name"]=> string(24) "C:\xampp\tmp\php574E.tmp" ["error"]=> int(0) ["size"]=> int(156613) }  */

    /* array(5) { ["name"]=> string(13) "Data_User.pdf" ["type"]=> string(15) "application/pdf" ["tmp_name"]=> string(24) "C:\xampp\tmp\phpE425.tmp" ["error"]=> int(0) ["size"]=> int(4393) }  */

    /* array(5) { ["name"]=> string(9) "style.css" ["type"]=> string(8) "text/css" ["tmp_name"]=> string(24) "C:\xampp\tmp\phpEBDD.tmp" ["error"]=> int(0) ["size"]=> int(12018) }  */

    /* array(5) { ["name"]=> string(16) "cookie_push.html" ["type"]=> string(9) "text/html" ["tmp_name"]=> string(24) "C:\xampp\tmp\php4BEB.tmp" ["error"]=> int(0) ["size"]=> int(1788) } */ 

    /* array(5) { ["name"]=> string(14) "OperaSetup.exe" ["type"]=> string(24) "application/x-msdownload" ["tmp_name"]=> string(24) "C:\xampp\tmp\phpA272.tmp" ["error"]=> int(0) ["size"]=> int(1163080) } */ 

?>

<div class="col-md-4">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <input type="file" name="photo" class="form-control"><br>
            <button type="submit" name="btnUpload" class="btn btn-outline-primary">Upload</button>
        </div>
    </form>
</div>
