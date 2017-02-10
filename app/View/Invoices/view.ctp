<?php
    $CakePdf = new CakePdf();
$html = '';

foreach($tp as $t){
	$html .= ''.$t['content'];

}
echo $html;

?>