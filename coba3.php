<?php
    $filename='image.png';
    //Attempt to open 
    $img=@imagecreatefrompng($filename);
    //See if it failed
    if(!$img){
        //Create a blank image
        $width=150;
        $height=150;
        $newimg=imagecreatetruecolor($width,$height);
        $bgcolor=imagecolorallocate($newimg,255,255,255);
        $color=imagecolorallocate($newimg,0,0,0);
        imagefilledrectangle($newimg,0,0,$width-1,$height-1,$bgcolor);
        //Output an error message at half the height of the image
        imagestring($newimg,1,10,round($height/2),'Error loading '.$filename,$color);
    }else{

        //CONVERT IMAGE TO WxHx3 ARRAY
        $width=imagesx($img);
        $height=imagesy($img);
        //Create and array of RGB values
        $array=array();
        for($x=0;$x<$width;++$x){
            for($y=0;$y<$height;++$y){
                //Every pixel will be an array of 4 ints with the keys 'red', 'green', 'blue' and 'alpha'.
                $bytes=imagecolorat($img,$x,$y);
                $colors=imagecolorsforindex($img,$bytes);
                $array[$x][$y]=$colors;             
            }
        }       

        //CONVERT WxHx3 ARRAY TO IMAGE
        $newimg=imagecreatetruecolor($width,$height);
        for($x=0;$x<$width;++$x){
            for($y=0;$y<$height;++$y){
                $r=$array[$x][$y]['red'];
                $g=$array[$x][$y]['green'];
                $b=$array[$x][$y]['blue'];
                //$a=$array[$x][$y]['alpha'];
                $a=0; //0: opaque, 127: transparent
                $colors=imagecolorallocatealpha($newimg,$r,$g,$b,$a);
                imagesetpixel($newimg,$x,$y,$colors);         
            }
        }       
    }

    //Remove these comments to show the image instead of HTML
    //header('Content-Type: image/png');
    //imagepng($newimg);
    //exit();

    //Show the image inside a IMG tag
    header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Image</title>
    </head>
    <body>
        <?php
        ob_start();
        imagepng($newimg);
        $data = ob_get_clean();
        ob_end_clean();     
        echo '<img src="data:image/png;base64,'.base64_encode($data).'" />';
        ?>
    </body>
</html>
Share
Improve this ans