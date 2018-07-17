<?php
    ob_start();
    if(isset($_FILES['screen_image'])){
        $image = $_FILES['screen_image'];
        $size = filesize($image['tmp_name'])/1024;


        if($size < 1512){
            //genero un id aleatorio para nombrar la carpeta
            $foldername = md5(rand(0, 1000000));

            //creo la carpeta
            if (!file_exists('./../downloads/'.$foldername)) {
                mkdir('./../downloads/'.$foldername, 0777, true);
                mkdir('./../downloads/'.$foldername.'/startup_images_dimitriconejo', 0777, true);

                $path = './../downloads/'.$foldername.'/startup_images_dimitriconejo';

                //preparamos los startup
                //1536x2008px portrait
                $startup1 = new Imagick($image['tmp_name']);
                $startup1->cropThumbnailImage(1536, 2008);
                $startup1->writeImage($path.'/apple-startup-image-1536x2008.png');
                chmod($startup1, 0777);

                //1496x2048px landscape
                $startup2 = new Imagick($image['tmp_name']);
                autoRotateImage($startup2);
                $startup2->cropThumbnailImage(1496, 2048);
                $startup2->writeImage($path.'/apple-startup-image-1496x2048.png');
                chmod($startup2, 0777);

                //768x1004px portrait
                $startup3 = new Imagick($image['tmp_name']);
                $startup3->cropThumbnailImage(768, 1004);
                $startup3->writeImage($path.'/apple-startup-image-768x1004.png');
                chmod($startup3, 0777);

                //748x1024px landscape
                $startup4 = new Imagick($image['tmp_name']);
                autoRotateImage($startup4);
                $startup4->cropThumbnailImage(748, 1024);
                $startup4->writeImage($path.'/apple-startup-image-748x1024.png');
                chmod($startup4, 0777);

                //1242x2148px portrait
                $startup5 = new Imagick($image['tmp_name']);
                $startup5->cropThumbnailImage(1242, 2148);
                $startup5->writeImage($path.'/apple-startup-image-1242x2148.png');
                chmod($startup5, 0777);

                //1182x2208px landscape
                $startup6 = new Imagick($image['tmp_name']);
                autoRotateImage($startup6);
                $startup6->cropThumbnailImage(1182, 2208);
                $startup6->writeImage($path.'/apple-startup-image-1182x2208.png');
                chmod($startup6, 0777);

                //750x1294px portrait
                $startup7 = new Imagick($image['tmp_name']);
                $startup7->cropThumbnailImage(750, 1294);
                $startup7->writeImage($path.'/apple-startup-image-750x1294.png');
                chmod($startup7, 0777);

                //640x1096px portrait
                $startup8 = new Imagick($image['tmp_name']);
                $startup8->cropThumbnailImage(640, 1096);
                $startup8->writeImage($path.'/apple-startup-image-640x1096.png');
                chmod($startup8, 0777);

                //640x920px portrait
                $startup9 = new Imagick($image['tmp_name']);
                $startup9->cropThumbnailImage(640, 920);
                $startup9->writeImage($path.'/apple-startup-image-640x920.png');
                chmod($startup9, 0777);

                //320x460px portrait
                $startup10 = new Imagick($image['tmp_name']);
                $startup10->cropThumbnailImage(320, 460);
                $startup10->writeImage($path.'/apple-startup-image-320x460.png');
                chmod($startup10, 0777);

                copy('./../code/STARTUP.txt', './../downloads/'.$foldername.'/startup_images_dimitriconejo/STARTUP.txt');

                //creo el zip y mando un JSON con la ruta de descarga + folder
                $rootPath = realpath('./../downloads/'.$foldername);
                $zip = new ZipArchive();
                $zip->open('./../downloads/'.$foldername.'/startup_images_dimitriconejo.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);
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
                echo json_encode(array('location' => './../downloads/'.$foldername.'/startup_images_dimitriconejo.zip', 'folder' => $foldername));
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

    function autoRotateImage($image){
        $image->rotateimage("#000", -90);
        $image->setImageOrientation(imagick::ORIENTATION_TOPLEFT);
    }
?>