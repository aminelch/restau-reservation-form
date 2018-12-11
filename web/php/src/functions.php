<?php
/**
 * [dd  small debogguer]
 * @param  [mixed] $var
 * @return [string]
 */
function dd($var){
	echo "<pre>".print_r($var,true)."</pre>";
}

/** [Génere une chaine alétoire]
@param $length longeur de chaine
@return string
*/
function random_string ($length=60) {
	$str="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	return substr(str_repeat(str_shuffle($str),$length),0,$length);
}


function create_hash ($password){

	return  password_hash($password,PASSWORD_DEFAULT);
}
function compare_hash($password,$hash){
	return password_verify($password,$hash);
}

/*
RENVOIE $length CHAR D' UNE CHAINE
 */
function extrait($str,$length=20){

	return htmlentities(substr($str,0,$length));
}

/**
 * Return the stored Csrf on the session Or NULL
 * @return [string] [the data]
 */


function dump(&$var, $info = FALSE){
	$scope = false;
	$prefix = 'unique';
	$suffix = 'value';

	if($scope) $vals = $scope;
	else $vals = $GLOBALS;

	$old = $var;
	$var = $new = $prefix.rand().$suffix; $vname = FALSE;
	foreach($vals as $key => $val) if($val === $new) $vname = $key;
	$var = $old;

	echo '<pre style="margin: 0px 0px 10px 0px; display: block; background: white; color: black; font-family:Source Code Pro,Helvetica; border: 1px solid #cccccc; padding: 5px; font-size: 18px; line-height: 28px;">';
	if($info != FALSE) echo "<b style='color: red;'>$info:</b><br>";
	do_dump($var, '$'.$vname);
	echo "</pre>";
}

////////////////////////////////////////////////////////
// Function:         do_dump
// Inspired from:     PHP.net Contributions
// Description: Better GI than print_r or var_dump
// @parm
function do_dump(&$var, $var_name = NULL, $indent = NULL, $reference = NULL){
	$do_dump_indent = "<span style='color:#eeeeee;'>|</span>&nbsp; ";
	$reference = $reference.$var_name;
	$keyvar = 'the_do_dump_recursion_protection_scheme'; $keyname = 'referenced_object_name';

	if (is_array($var) && isset($var[$keyvar]))
	{
		$real_var = &$var[$keyvar];
		$real_name = &$var[$keyname];
		$type = ucfirst(gettype($real_var));
		echo "$indent$var_name <span style='color:#a2a2a2'>$type</span> = <span style='color:#e87800;'>&amp;$real_name</span><br>";
	}
	else
	{
		$var = array($keyvar => $var, $keyname => $reference);
		$avar = &$var[$keyvar];

		$type = ucfirst(gettype($avar));
		if($type == "String") $type_color = "<span style='color:green'>";
		elseif($type == "Integer") $type_color = "<span style='color:red'>";
		elseif($type == "Double"){ $type_color = "<span style='color:#0099c5'>"; $type = "Float"; }
		elseif($type == "Boolean") $type_color = "<span style='color:#92008d'>";
		elseif($type == "NULL") $type_color = "<span style='color:#c54900'>";

		if(is_array($avar))
		{
			$count = count($avar);
			echo "$indent" . ($var_name ? "$var_name => ":"") . "<span style='color:#b72cac'>$type ($count)</span><br>$indent(<br>";
			$keys = array_keys($avar);
			foreach($keys as $name)
			{
				$value = &$avar[$name];
				do_dump($value, "['$name']", $indent.$do_dump_indent, $reference);
			}
			echo "$indent)<br>";
		}
		elseif(is_object($avar))
		{
			echo "$indent$var_name <span style='color:#a2a2a2'>$type</span><br>$indent(<br>";
			foreach($avar as $name=>$value) do_dump($value, "$name", $indent.$do_dump_indent, $reference);
			echo "$indent)<br>";
		}
		elseif(is_int($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $type_color$avar</span><br>";
		elseif(is_string($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $type_color\"$avar\"</span><br>";
		elseif(is_float($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $type_color$avar</span><br>";
		elseif(is_bool($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $type_color".($avar == 1 ? "TRUE":"FALSE")."</span><br>";
		elseif(is_null($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> {$type_color}NULL</span><br>";
		else echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $avar<br>";

		$var = $var[$keyvar];
	}
}

/**
* [setFlash description]
* @param [type] $message [description]
* @param string $type    [description]
*/
function setFlash($message, $type='success'){
$_SESSION['flash']['type']=$type;
$_SESSION['flash']['message']=$message;
}
/**
* [flash description]
* @return [type] [description]
*/
function flash () {
if(isset($_SESSION['flash'])){
	extract($_SESSION['flash']);
	unset($_SESSION['flash']);

   return "<div class='alert alert-$type'>$message</div>";
    // "<div class='alert alert-dismissible alert-$type'>
    // $message<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    // <span aria-hidden='true'>&times;</span>
    // </button>
    // </div>";

}
}
