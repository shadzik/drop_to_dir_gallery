<!--<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="js/lightbox.js"></script>-->
<?
/* galeria_drop_to_dir by shadzik (shadzik@atwa.us)
   for .jpg .png .gif .bmp files
   to create previews of the images you need to have ImageMagick installed or compiled in your home dir
   license: GPL
   version: 0.8pre1-snap20050218 status: testing
   author: Bartosz ¦wi±tek aka shadzik (bartek@atwa.us)

   YOU DO NOT HAVE TO CHANGE ANYTHING BELOW ! unless you know what you're doing:)
*/

require_once("config.php");

// ponizej lepiej juz nic nie zmieniac chyba ze sie wie co sie robi

$show = $_REQUEST['show'];
// GREAT IF BENEATH
if ($show == "" || $show == null) {
// GREAT IF ABOVE

if ($show_images == 1){
    if (file_exists("mini")){
       if (is_dir("mini")){
          } else {
             if ($su == 1) {
                mkdir("mini", 0700);
                chmod("mini", 0700);
             } else { echo "You do not have su_php enabled. Please create the 'mini' directory manualy and give it 777 rights"; 
                      echo "<br>otherwise you won't be able to see the previews"; 
                      exit(0);}
          }
    } else {
       if ($su == 1) {
          mkdir("mini", 0700);
          chmod("mini", 0700);
       } else { echo "You do not have su_php enabled. Please create the 'mini' directory manualy and give it 777 rights";
                echo "<br>otherwise you won't be able to see the previews"; 
                exit(0);}
    }
}

$author = "shadzik";
$version = "0.9-snap20091020";
$status = "testing";
$license = "GPLv2+";
$j = 0;
$k = 0;

$id = $_REQUEST['id'];

if ($id == 0 || $id == null) { $id=1; }

$filenames = array();

if ($handle = opendir($dir)) {
	while (false !== ($file = readdir($handle))) {
		if ($file != "." && $file != "..") {
			if (preg_match("/.jpg/i", $file) || preg_match("/.png/i", $file) || preg_match("/.gif/i", $file) || preg_match("/.bmp/i", $file)) {
				$filenames[] = $file;
				$j++;
			}
		}
	}
	closedir($handle);
}

sort($filenames);
$file = $filenames;

if ($j!=0){
   $ile = ceil($j/$show_files);
} else { $ile = 0; }

echo "<center>";
//echo "<link rel=\"stylesheet\" type=\"text/css\" href=$css>";
echo "<table cellpadding=2 cellspacing=1 border=0><tr>";
if ($j>0 && $id!=null && $id>0 && $id<=$ile) {
	$i=($id-1)*$show_files;
	while($i<$show_files*$id) {
		if (array_key_exists($i,$file)) {
                   if ($show_images == 0) {
                           echo "<td>";
                           echo "<a href=\"$dir/$file\"i rel=\"lightbox[roadtrip]\">$file</a>";
                           echo "  ";
                           if ($show_weight == 1){
                               $weight = floor(filesize("$dir/$file[$i]")/1024);
                               echo "<br>$weight KB";
                           }
                           if ($show_res == 1) {
                               $size = GetImageSize("$dir/$file[$i]");
                               $rx = $size[0];
                               $ry = $size[1];
                               echo "<br>res: ".$rx."x".$ry;
                           }
                           if ($comments == 1) {
                              if (file_exists("comments/$file[$i]".".txt")) {
                                 echo "<br>";
                                 include("comments/$file[$i].txt");
                              }
                           }
                           echo "</td>";
                       $k++;
                       if ($k == $columns) { echo "<tr>"; $k=0; }
                   }
                   if ($show_images == 1) {
			   echo "<td>";
                               if (file_exists("mini/$file[$i]")){
                                   echo "<a href=\"$dir/$file[$i]\" rel=\"lightbox[roadtrip]\">"; 
                                   echo "<img src=\"mini/$file[$i]\" border=\"0\"></a>";
                               } else {
                                   system("$convert $dir/$file[$i] -resize $img_res mini/$file[$i]");
                                   chmod("mini/$file[$i]", 0644);
                                   echo "<a href=\"$dir/$file[$i]\" rel=\"lightbox[roadtrip]\">";
                                   echo "<img src=\"mini/$file[$i]\" border=\"0\"></a>";
                           }
                           if ($show_filename == 1) {
                              echo "<br>$file[$i]";
                           }
                           if ($show_weight == 1){
                               $weight = floor(filesize("$dir/$file[$i]")/1024);
                               echo "<br>$weight KB";
                           }
                           if ($show_res == 1) {
                               $size = GetImageSize("$dir/$file[$i]");
                               $rx = $size[0];
                               $ry = $size[1];
                               echo "<br>res: ".$rx."x".$ry;
                           }
                           if ($comments == 1) {
                              if (file_exists("comments/$file[$i]".".txt")) {
                                 echo "<br>";
                                 include("comments/$file[$i].txt");
                              }
                           }
                           echo "</td>";
                       $k++;
			   if ($k == $columns) { echo "<tr>"; $k=0; }
			}
		   } //if array key exists
		   $i++;
	} //while
} 

echo "</tr></table>";

if ($ile>1) {
echo "Strona: ";
   for ($i=1; $i<=$ile; $i++) {
       if ($i!=$id) {
          echo "<a href=\"?id=$i\">[<u>$i</u>]</a> ";
       } else {
          echo "[$i] ";
       }
   }
}

if ($summary == 1) {
   if ($j == 0) {
      echo "<br>Brak plikow w galerii";
      } else {
      echo "<br>Razem: $j";
    }
}

if ($admin_link == 1) {
   echo "<br><br><a href=\"?show=admin\">Upload file section</a>";
}

if ($footer == 1) {
echo "<br><br><br>Drop_to_dir Gallery by $author ver. $version-$status<br>";
echo "NOTE: the drop_to_dir gallery is FREE software distributed on the terms of the $license license,<br>";
echo "to get a copy contact shadzik at atwa dot us.";
}
echo "</center>";

//GREAT IF ENDS HERE !
}
// Finally

/*
 * ADMIN SECTION
*/
/*
$pass = $_REQUEST['pass'];

if ($show == "admin") {
   if ($pass != $admin_pass) {
      echo "<center>";
      echo "<form method=\"post\" action=\"?show=admin\">";
      echo "<input type=\"password\" name=\"pass\" size=\"10\"><br>";
      echo "<input type=\"submit\" value=\"Submit\">";
      echo "</form>";
      echo "<br><br><a href=\"?id=1\">Back to gallery</a></center>";
   }
   if ($pass == $admin_pass) {
      echo "<center><form enctype=\"multipart/form-data\" action=\"?show=send\" method=POST>";
      echo "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"5120000\">";
      echo "<table border=\"0\" cellspacing=\"5\" cellpadding=\"0\">";
      echo "<tr><td colspan=\"2\" align=\"center\"><b>Attached file cannot weight more than 5Mb !</b></td></tr>";
      echo "<tr><td>Choose file:</td><td>";
      echo "<input type=\"file\" name=\"plik\"></td></tr>";
      echo "<tr><td>(SHORT) Comment:</td><td>";
      echo "<input type=\"text\" name=\"comment\"></td></tr>";
      echo "<tr><td colspan=\"2\" align=\"center\">";
      echo "<input type=\"submit\" value=\"Send file\"></td></tr></table></form>";
      echo "<br><br><a href=\"?id=1\">Back to gallery</a></center>";
   }
}

if ($show == "send") {
	$plik = $_REQUEST['plik'];
	$comment = $_REQUEST['comment'];
   echo "<center>";
   if (is_uploaded_file($plik)) {
      if (copy($plik, "$dir/$plik_name")) {
         chmod("$dir/$plik_name", 0644);
         $koment = fopen("comments/$plik_name".".txt","w");
         //flock($koment,2);
         fwrite($koment, "$comment"."\n");
         //flock($koment,3);
         fclose($koment);
         chmod("comments/$plik_name".".txt", 0644);
         echo"File was uploaded successfully!";
         echo "<br><br><a href=\"?id=1\">Back to gallery</a></center>";
      } else {
         echo "Upload failed!";
         echo "<br><br><a href=\"?id=1\">Back to gallery</a></center>";
      }
   } else {
      echo "Upload failed!";
      echo "<br><br><a href=\"?id=1\">Back to gallery</a></center>";
   }
   echo "</center>";
}   
 */
?>
