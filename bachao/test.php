<?php
$log = fopen("files\\log.txt", "wb");
function debug($text)
{
	global $log;
	fwrite($log, "$text\n");
}

debug("line1");
debug("line2");
fclose($log);
?>