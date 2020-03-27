<?php

/**
 * Return string list of constant by prefix and value
 * if value is defined first constant with that value is returned, set to null if you don't want to search by value.
 * @param $prefix
 * @param null $valueToSearch
 * @return array
 */
function getConstantsByPrefix($prefix,$valueToSearch=null)
{
	$dump = [];
	foreach (get_defined_constants() as $key => $value)
		if (substr($key, 0, strlen($prefix)) == $prefix) {
			$dump[$key] = $value;
			if($valueToSearch != null && $value==$valueToSearch)
				return $key;
		}
	return $dump;
}

/**
 * Escape any value for preventing XSS, Use this whereever you are echoing user input.
 * @param $string
 * @return string
 */
function escapeXSS($string)
{
	return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Use it inplace of echo, this sanitizes all inputs.
 * @param $value
 * @return bool
 */
function ticho($value){
	echo escapeXSS($value);
	return true;
}




/**
 * Tells if a given array is Associative or not.
 * @param array $array
 * @return bool
 */
function isAssoc(array $array)
{
	// Keys of the array
	$keys = array_keys($array);

	// If the array keys of the keys match the keys, then the array must
	// not be associative (e.g. the keys array looked like {0:0, 1:1...}).
	return array_keys($keys) !== $keys;
}


/**
 * Return item from array for a given key if not found $defVal is returned.
 * @param $item
 * @param $key
 * @param $defVal
 * @return mixed
 */
function getDefault($item, $key, $defVal)
{
	if (isset($item) && isset($item[$key]) && !empty($item[$key]))
		return $item[$key];
	return $defVal;
}


/**
 * Return only specified keys from array.
 * @param $arr
 * @param $keys
 * @param array $removeKeysWithValue
 * @return array
 */
function getValuesOfKeys($arr, $keys, $removeKeysWithValue = null)
{
	$ar = array();

	if (isAssoc($keys)) {
		foreach ($keys as $key => $val) {
			$v = (isset($arr[$key]) ? $arr[$key] : $val);
			if (!is_array($removeKeysWithValue) or !in_array($v, $removeKeysWithValue))
				$ar[$key] = $v;
		}
	} else {
		foreach ($keys as $key) {
			$v = (isset($arr[$key]) ? $arr[$key] : null);
			if (!is_array($removeKeysWithValue) or !in_array($v, $removeKeysWithValue))
				$ar[$key] = $v;
		}
	}

	return $ar;
}



/**
 * Handle unauthorized cases, it simply redirects user to a page with messages and few conditions.
 *
 * @param null $message string Message you want to show in frontend.
 * @param null $permissionLevels Array|string of permission number incase user doesn't has certain permission and we know which is required.
 */
function unauthorized($message = null, $permissionLevels = null)
{
	if ($permissionLevels !== null && is_int($permissionLevels))
		$permissionLevels = array($permissionLevels);


	redirect(URL_NO_PERMISSION . "?_=" . time() . "&from=" . urlencode($_SERVER['REQUEST_URI']) .
		($message !== null ? '&m=' . $message : '') .
		(is_array($permissionLevels) ? '&p=' . implode(';', $permissionLevels) : '')
		, 'auto', 302);
}



//set flashdata message
function set_msg($key, $value, $data = null)
{
	$CI = &get_instance();
	$msg = 'Please set message';
	if ($key == 'error') {
		$msg = '<div class="container-fluid"><div class="alert alert-danger display-hide col-md-12 notification" style="display: block;"><button class="close" data-close="alert"></button><span><b><img src="' . BASE_URL . 'assets/images/pnotify/error.png' . '" style="width: 25px;"> </b> ' . $value . ' </span></div></div>';
	}

	if ($key == 'success') {
		$msg = '<div class="container-fluid"><div class="alert alert-success display-hide col-md-12 notification" style="display: block;"><button class="close" data-close="alert"></button><span><b><img src="' . BASE_URL . 'assets/images/pnotify/img/success.png' . '" style="width: 25px;"></b> ' . $value . ' </span></div></div>';
	}


	if ($key == 'warning') {
		$msg = $msg = '<div class="container-fluid"><div class="alert alert-warning display-hide col-md-12 notification" style="display: block;"><button class="close" data-close="alert"></button><span><b><img src="' . BASE_URL . 'assets/images/pnotify/img/warning.png' . '" style="width: 25px;"> </b> ' . $value . ' </span></div></div>';;
	}

	if ($key == 'info') {
		$msg = $msg = '<div class="container-fluid"><div class="alert alert-info display-hide col-md-12 notification" style="display: block;"><button class="close" data-close="alert"></button><span><b><img src="' . BASE_URL . 'assets/images/pnotify/img/info.png' . '" style="width: 25px;"></b> ' . $value . ' </span></div></div>';
	}
	$CI->session->set_flashdata($key, $msg);
	$CI->session->set_flashdata("message_data", $data);
}

function get_msg()
{

	$CI = &get_instance();

	if (($CI->session->flashdata('error'))) {
		echo $CI->session->flashdata('error');
	}

	if (($CI->session->flashdata('success'))) {
		echo $CI->session->flashdata('success');
	}

	if (($CI->session->flashdata('warning'))) {
		echo $CI->session->flashdata('warning');
	}

	if (($CI->session->flashdata('info'))) {
		echo $CI->session->flashdata('info');
	}

	return $CI->session->flashdata('message_data');
}
