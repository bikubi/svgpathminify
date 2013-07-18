Reads SVG from STDIN, prints it to STDOUT with all `path/@d`s "minified" by rounding all coordinates to *N* decimals (N can be specified with the first argument, defaults to 0).   
Whitespace will be omitted, too.

Example:
```bash
echo '<svg><g><path d="M 0.19970259,11.510154 C 14.134584,27.674615 8.560631,-11.343034 24.725093,4.2640241 40.889555,19.871082 23.052907,18.198896 23.052907,18.198896" /></g></svg>' | ./svgpathminify.php 2 
```

Output:
```svg
<?xml version="1.0"?>
<svg><g><path d="M 0.2,11.51 C 14.13,27.67 8.56,-11.34 24.73,4.26 40.89,19.87 23.05,18.2 23.05,18.2"/></g></svg>```
