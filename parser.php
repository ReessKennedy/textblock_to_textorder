<style> 
*, html, body {
	font-family: arial;
	font-size: 10px;
	padding: 0px;

  box-sizing: border-box;
}
table {
	border: 2px solid #ddd;
  table-layout: fixed;
  border-collapse: collapse;
  width: 100%;
}
table td {
	border: 1px solid #ddd;
	padding: 5px;
	vertical-align: top;

  overflow: hidden !important;
  white-space: nowrap;
  xwidth: 400px;

  background: navy; 
  color: #ddd;
}

</style> 
<table> 
<th>date</th>
<th>body, full</th>
<th>tags only</th>
<th>body [-images]</th>
<th>body, [-tags]</th>
<th>body, [-images, -tags]</th>
<th>images [start]</th>



<?php
foreach($files as $file) {
   $content = file_get_contents($file);


   // $content = str_starts_with($content, '![](');
   // echo 'First part'.$content;


   // $content = str_replace("#1projects-cats/inception","",$content);
   // $content = str_replace("#_.inboxes/_ek","",$content);
   // $content = str_replace("# ","",$content);




   $firstline = $str = strtok($content, "\n");

   $filetime = date ("n/j/Y h:i:s A", filemtime($file));

  // echo '2';  
  
  // function just_image() {

  // }

?>

<tr>
<td><?php echo $filetime; ?></td>

<td style="width: 200px; overflow: hidden;">
<?php echo nl2br($content); ?>
</td>


<?php

    /*
    Split paragraph into lines
    https://stackoverflow.com/questions/3997336/explode-php-string-by-new-line
    
    */
    $content_lines_array = explode(PHP_EOL, $content);


    // echo '<td>'.$content_lines_array[0].'</td>';


// Tags only

    echo '<td>';
    foreach($content_lines_array as $line) {

      if (substr($line, 0, 2 ) == "# ") {
        

       // Skip if space after hash as these are headers 
      } elseif (substr($line, 0, 1 ) == "#") {
        echo $line;
        // Execute if no space, as this is tag
      } 

    }
    // echo nl2br($newcontent); 
    echo '</td>';







// body -images

    echo '<td>';
    foreach($content_lines_array as $line) {
      if (substr($line, 0, 4 ) == "![](") {
        $newcontent = str_replace($line, "", $content)."\n";
      } 
      // else { echo $line."\n"; }
    }
    echo nl2br($newcontent); 
    echo '</td>';







// body -tags

    echo '<td>';
    foreach($content_lines_array as $line) {     
        if (substr($line, 0, 2 ) == "# ") {
       
        } elseif (substr($line, 0, 1 ) == "#") {
          $newcontent = str_replace($line, "", $content)."\n";
        } 
        // else { echo $line."\n"; }
    }
    echo nl2br($newcontent); 
    echo '</td>';


// body -tags -images

    echo '<td>';
    foreach($content_lines_array as $line) {

      if (substr($line, 0, 1 ) == "![](") {
        $newcontent = str_replace($line, "", $content)."\n";

       // Skip if space after hash as these are headers 
      } elseif (substr($line, 0, 1 ) == "# ") {

        // Execute if no space, as this is tag
      }  elseif (substr($line, 0, 1 ) == "#") {
        // Remove tag -- do this different in case there is more text AFTER a tag ... so you don't delete the whole row
        $newcontent = preg_replace("/(?<=^|\s)#\w+/", "" , $line); 
      } 

      // else { echo $line."\n"; }
    }
    echo nl2br($newcontent); 
    echo '</td>';


    /**
     * 
     * Creating a TD for each image ... 
     */
  
    foreach($content_lines_array as $line) {

      
      
      // Created cells with images ... 
      if (substr($line, 0, 4 ) == "![](") {
        // $imagefile = just_image($line); 

        $imagefile = str_replace("![](", "", $line);
        $imagefile = str_replace(")", "", $line);
        $split_string = explode("/", $imagefile);
        $imagefile = $split_string[1];

        echo '<td>'.$imagefile.'</td>';
       }


    }
    // for ($i = 0; $i < 3; $i++) {
     /* 
      See if
      New function in php8 that is better than this
      
      */
      /*
      echo '<td>';
      if (substr($content_lines_array[$i], 0, 4 ) == "![](") {
        echo $content_lines_array[$i];
       }
       echo '</td>';
       */

   //  }  


 

?>



</tr>
  
    
<?php    
        //file_put_contents($output, $content, FILE_APPEND);
    }
    
?>    

</table>
