<?
/*
 * GALERY CONFIG
*/

$dir = "gfx"; //sciezka do katalogu z plikami graficznymi
$show_images = 1; //pokazac miniaturke, 0 falsz, 1 prawda
$show_filename = 1; //pokazac nazwe pliku ? (tylko gdy $show_images = 1), 0 falsz, 1 prawda
$show_weight = 1; //pokazac wage pliku w KB ?
$img_res = "200x200"; // rozdzialka miniaturki
$convert = "/usr/bin/convert"; // sciezka do programu convert
$columns = 4;  //ile obok siebie, 1 = jeden pod drugim, 2 = dwa obok siebie itd.
$show_res = 1; //pokazac rozmiar pliku, 0 falsz, 1 prawda
$show_files = 8; //pokazac ile plikow naraz
$su = 0; // masz su_php wlaczone ? 0 nie, 1 tak, jesli $su = 0, trzeba stworzyc katalog mini recznie z prawami 777
$summary = 1; // pokazac ile razem wszystkich plikow graficznych ?
$css = "css/lightbox.css"; //jesli nie chcesz, zostaw puste
$comments = 10; // komentarze do plikow
$footer = 1; //pokazac text dolny
$admin_pass = "changeme"; // set admins password
$admin_link = 0; // show admin link on site ?

?>
