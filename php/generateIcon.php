<?php
    ob_start();
    if(isset($_FILES['icon_image'])){
        $image = $_FILES['icon_image'];
        $size = filesize($image['tmp_name'])/1024;

        if($size < 1512){
            //genero un id aleatorio para nombrar la carpeta
            $foldername = md5(rand(0, 1000000));

            //creo la carpeta
            if (!file_exists('./../downloads/'.$foldername)) {
                mkdir('./../downloads/'.$foldername, 0777, true);
                mkdir('./../downloads/'.$foldername.'/touch_icons_dimitriconejo', 0777, true);

                $path = './../downloads/'.$foldername.'/touch_icons_dimitriconejo';

                //preparamos los iconos
                //152x152px
                $icon152 = new Imagick($image['tmp_name']);
                $icon152->cropThumbnailImage(152, 152);
                $icon152->writeImage($path.'/apple-touch-icon-152x152.png');
                chmod($icon152, 0777);

                //144x144px
                $icon144 = new Imagick($image['tmp_name']);
                $icon144->cropThumbnailImage(144, 144);
                $icon144->writeImage($path.'/apple-touch-icon-144x144.png');
                chmod($icon144, 0777);

                //120x120px
                $icon120 = new Imagick($image['tmp_name']);
                $icon120->cropThumbnailImage(120, 120);
                $icon120->writeImage($path.'/apple-touch-icon-120x120.png');
                chmod($icon120, 0777);

                //114x114px
                $icon114 = new Imagick($image['tmp_name']);
                $icon114->cropThumbnailImage(114, 114);
                $icon114->writeImage($path.'/apple-touch-icon-114x114.png');
                chmod($icon114, 0777);

                //76x76px
                $icon76 = new Imagick($image['tmp_name']);
                $icon76->cropThumbnailImage(76, 76);
                $icon76->writeImage($path.'/apple-touch-icon-76x76.png');
                chmod($icon76, 0777);

                //72x72px
                $icon72 = new Imagick($image['tmp_name']);
                $icon72->cropThumbnailImage(72, 72);
                $icon72->writeImage($path.'/apple-touch-icon-72x72.png');
                chmod($icon72, 0777);

                //60x60px
                $icon60 = new Imagick($image['tmp_name']);
                $icon60->cropThumbnailImage(60, 60);
                $icon60->writeImage($path.'/apple-touch-icon-60x60.png');
                chmod($icon60, 0777);

                //57x57px
                $icon57 = new Imagick($image['tmp_name']);
                $icon57->cropThumbnailImage(57, 57);
                $icon57->writeImage($path.'/apple-touch-icon-57x57.png');
                chmod($icon57, 0777);

                copy('./../code/TOUCHICONS.txt', './../downloads/'.$foldername.'/touch_icons_dimitriconejo/TOUCHICONS.txt');

                //creo el zip y mando un JSON con la ruta de descarga + folder
                $rootPath = realpath('./../downloads/'.$foldername);
                $zip = new ZipArchive();
                $zip->open('./../downloads/'.$foldername.'/touch_icons_dimitriconejo.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);
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
                echo json_encode(array('location' => './../downloads/'.$foldername.'/touch_icons_dimitriconejo.zip', 'folder' => $foldername));
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