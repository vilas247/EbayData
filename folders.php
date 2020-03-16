<?php
function listFolderFiles($dir){
    $ffs = scandir($dir);

    unset($ffs[array_search('.', $ffs, true)]);
    unset($ffs[array_search('..', $ffs, true)]);

    // prevent empty ordered elements
    if (count($ffs) < 1)
        return;

    echo '<ol>';
    foreach($ffs as $ff){
        echo '<li>'.$ff;
        if(is_dir($dir.'/'.$ff)) listFolderFiles($dir.'/'.$ff);
        echo '</li>';
    }
    echo '</ol>';
}

function get_all_directory_and_files($dir){
	//echo $dir;
     $dh = new DirectoryIterator($dir);   
	 print_r($dh);echo "<br/>";
     // Dirctary object 
     foreach ($dh as $k=>$item) {
		 //echo $k;echo "<br/>";
         if (!$item->isDot()) {
            if ($item->isDir()) {
                get_all_directory_and_files("$dir/$item");
            } else {
                echo $dir . "/" . $item->getFilename();
                echo "<br>";
            }
         }
      }
   }
//listFolderFiles('/');
get_all_directory_and_files('../Translate');

?>