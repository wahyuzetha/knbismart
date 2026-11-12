<?php
function read_docx($filename){

    $striped_content = '';
    $content = '';

    if(!$filename || !file_exists($filename)) return false;

    $zip = zip_open($filename);
    if (!$zip || is_numeric($zip)) return false;

    while ($zip_entry = zip_read($zip)) {

        if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

        if (zip_entry_name($zip_entry) != "word/document.xml") continue;

        $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

        zip_entry_close($zip_entry);
    }
    zip_close($zip);      
    $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
    $content = str_replace('</w:r></w:p>', "\r\n", $content);
    $striped_content = strip_tags($content);

    return $striped_content;
}
//echo read_docx("tes.docx");


$filename="tes.docx";
$zip2 = new ZipArchive;
$zip2->open($filename);
$zip = zip_open($filename);
$zip2->open($filename);
$i=0;
if (!$zip || is_numeric($zip)) return false;

while ($zip_entry = zip_read($zip)) {

    if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

    $zipEntryName = zip_entry_name($zip_entry);
    if(preg_match("([^\s]+(\.(?i)(jpg|jpeg|png|gif|bmp))$)",$zipEntryName))
    {
      //  echo zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
        $dataIn = $zip2->statIndex($i);
        $zip_element = $zip2->statIndex($i);

        $index = $zip_element['index'];
     //  echo "<image src='display.php?filename=".$filename."&index=".$index."' ><br />";
    }
    $i++;

    if (strpos($zipEntryName, 'word/media') !== false)
    {
        # Removes 'word/media' prefix
     $imageName = substr($zipEntryName, 11);

        # Prevent EMF file extensions passing, as they are used by word rather than being manually placed
        if (substr($imageName, -3) == 'emf') continue;

        # Place the image assets into an array for future reference
        $imageAssets[$imageName] = array(
            'h' => 'auto',
            'w' => 'auto',
            'title' => $imageName,
            'id' => null,
            'data' => base64_encode(zip_entry_read($zip_entry, zip_entry_filesize($zip_entry))));
    }

    if ($zipEntryName != "word/document.xml") continue;

    $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

    zip_entry_close($zip_entry);

}

zip_close($zip);
$content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
$content = str_replace('</w:r></w:p>', "\r\n", $content);
$content = str_replace("\r\n", "\n", $content);
$striped_content = strip_tags($content);

//echo"$striped_content";


?>
<?php



/*****************************************************************
This approach uses detection of NUL (chr(00)) and end line (chr(13))
to decide where the text is:
- divide the file contents up by chr(13)
- reject any slices containing a NUL
- stitch the rest together again
- clean up with a regular expression
*****************************************************************/

function parseWord($userDoc) 
{
    $fileHandle = fopen($userDoc, "r");
    $line = @fread($fileHandle, filesize($userDoc));   
    $lines = explode(chr(0x0D),$line);
    $outtext = "";
    foreach($lines as $thisline)
      {
        $pos = strpos($thisline, chr(0x00));
        if (($pos !== FALSE)||(strlen($thisline)==0))
          {
          } else {
            $outtext .= $thisline." ";
          }
      }
     $outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/","",$outtext);
    return $outtext;
} 

$userDoc = "tes.doc";

$text = parseWord($userDoc);
echo $text;


?>