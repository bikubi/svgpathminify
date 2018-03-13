#!/usr/bin/php
<?php

$accu = floatval($_SERVER['argv'][1]);
if ($accu != round($accu)) {
	fwrite(STDERR, "Warning: accuracy is a float, might not minify\n");
}
$div = pow(10, $accu);

$xml = '';

while ($line = fgets(STDIN)) $xml .= $line;

$dom = new DOMDocument;
$dom->loadXML($xml);
/* we're minifying anyway */
$dom->preserveWhiteSpace = false;
$dom->formatOutput = false;

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
		$node->setAttribute('d', trim($dmin));
	}
}

echo $dom->saveXML();

?>
