<?php
    ob_start();
    if(isset($_FILES['favicon_image'])){
        $image = $_FILES['favicon_image'];
        $size = filesize($image['tmp_name'])/1024;

        if($size < 1512){
            //genero un id aleatorio para nombrar la carpeta
            $foldername = md5(rand(0, 1000000));

            //creo la carpeta
            if (!file_exists('./../downloads/'.$foldername)) {
                mkdir('./../downloads/'.$foldername, 0777, true);
                mkdir('./../downloads/'.$foldername.'/favicon_dimitriconejo', 0777, true);

                $path = './../downloads/'.$foldername.'/favicon_dimitriconejo';

                //preparamos los favicon
                //196x196px
                $fav196 = new Imagick($image['tmp_name']);
                $fav196->cropThumbnailImage(196, 196);
                $fav196->writeImage($path.'/favicon-196x196.png');
                chmod($fav196, 0777);

                //128x128px
                $fav128 = new Imagick($image['tmp_name']);
                $fav128->cropThumbnailImage(128, 128);
                $fav128->writeImage($path.'/favicon-128x128.png');
                chmod($fav128, 0777);

                //96x96px
                $fav96 = new Imagick($image['tmp_name']);
                $fav96->cropThumbnailImage(96, 96);
                $fav96->writeImage($path.'/favicon-96x96.png');
                chmod($fav96, 0777);

                //64x64px ICO
                $fav64 = new Imagick($image['tmp_name']);
                $fav64->cropThumbnailImage(64, 64);
                $fav64->writeImage($path.'/favicon.ico');
                chmod($fav64, 0777);

                //32x32px
                $fav32 = new Imagick($image['tmp_name']);
                $fav32->cropThumbnailImage(32, 32);
                $fav32->writeImage($path.'/favicon-32x32.png');
                chmod($fav32, 0777);

                //16x16px
                $fav16 = new Imagick($image['tmp_name']);
                $fav16->cropThumbnailImage(16, 16);
                $fav16->writeImage($path.'/favicon-16x16.png');
                chmod($fav16, 0777);

                copy('./../code/FAVICON.txt', './../downloads/'.$foldername.'/favicon_dimitriconejo/FAVICON.txt');

                //creo el zip y mando un JSON con la ruta de descarga + folder
                $rootPath = realpath('./../downloads/'.$foldername);
                $zip = new ZipArchive();
                $zip->open('./../downloads/'.$foldername.'/favicon_dimitriconejo.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);
                $files = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator($rootPath),
                    RecursiveIteratorIterator::LEAVES_ONLY
                );

                foreach ($files as $name => $file){
                    if (!$file->isDir()){
                        $filePath = $file->getRealPath();
                        $relativePath = substr($filePath, strlen($rootPath) + 1);
                        $zip->addFile($filePath, $relativePath);
                    }
                }

                $zip->close();
                echo json_encode(array('location' => './../downloads/'.$foldername.'/favicon_dimitriconejo.zip', 'folder' => $foldername));
            }
            else{
                echo 'Oops! There was an error creating the .zip file.';
            }
        }
        else{
            echo 'Oops! It looks like your image exceeds the size limit, 1.5 MB.';
        }
    }
    else{
        echo 'Oops! Something went wrong. Refresh and try it again!';
    }
?>