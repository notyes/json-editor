<?php 

    if (! empty( $_POST['param'] )) {
        $myfile = fopen("text.json", "w") or die("Unable to open file!");
        fwrite($myfile, $_POST['param']);
        fclose($myfile);
    }

 ?>