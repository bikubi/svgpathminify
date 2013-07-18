#!/usr/bin/php
<?php

/* we can suppress "undefined offset", this defaults to 1 */
$div = @pow(10, intval($_SERVER['argv'][1]));

$xml = '';

while ($line = fgets(STDIN)) $xml .= $line;

$dom = new DOMDocument;
$dom->loadXML($xml);
$dom->preserveWhiteSpace = false; /* we're minifying anyway */

$nodes = $dom->getElementsByTagName('path');

foreach ($nodes as $node) {
	$d = $node->getAttribute('d');
	if ($d) {
		/* the regexp is probably too loose but works so far */
		$split = preg_split('/([, mclhvzqt])/i', $d, -1, PREG_SPLIT_DELIM_CAPTURE);
		$dmin = '';
		foreach($split as $_) {
			$f = floatval($_);
			/* for some reasone sprintf with one decimal doesn't work */
			$dmin .= ($f !== 0.0)
				? (round($f * $div) / $div)
				: $_;
		}
		$node->setAttribute('d', $dmin);
	}
}

echo $dom->saveXML();

?>
