<?php
$get_args = getopt(
	'',
	array(
		'source:'
	)
);

$file = file_get_contents($get_args['source']) or die();
$file = json_decode($file, true);
//var_dump($file);
//die();
$new_array = array();

foreach( $file['RECORDS'] as $currency ) {
	$new_array[$currency['currency_code']] = array(
		'flag_name' => $currency['flag_name'],
		'html_code' => $currency['html_code'],
		'currency_symbol' => $currency['currency_symbol']
	);
}
$new_content = var_export($new_array, true);

$new_content = '<?php' . PHP_EOL . $new_content . ';';

$output_file = fopen("currencies-data.php", "w") or die("Unable to open file!");
fwrite($output_file, $new_content);
die();