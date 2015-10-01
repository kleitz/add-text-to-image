<?php
function is_ajax(){

	if (strtolower(filter_input(INPUT_SERVER, 'X-Requested-With')) === 'xmlhttprequest') {
	 	return true;
	}

	if (strtolower(filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) === 'xmlhttprequest') {
	 	return true;
	}
	return false;
}

function getListFont(){
	$arrFont = array(
		'angillatattoopersonaluseonly',
		'edwardian',
		'fetteunzfraktur',
		'h74rbl',
		'impact',
		'kgkissmeslowly',
		'lhfbostontruckstylec',
		'lintsec',
		'oklahoma',		
		'oldeenglish',		
		'sanchezregular'		
		);
}

?>