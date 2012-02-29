<?php

global $tml, $user_level, $tml_admin_messages, $tml_admin, $time_bases, $tml_form_errors;

if( !is_object($tml) || !current_user_can("edit_plugins") ) {
	echo __("Sorry: you can not configure Thank Me Later with your account.", "thankmelater");
	exit;
}

$time_bases = array(
				// (plural, singular)
			1 =>      array( __("seconds", "thankmelater"),   __("second", "thankmelater") ),
			60 =>     array( __("minutes", "thankmelater"),   __("minute", "thankmelater") ),
			3600 =>   array( __("hours", "thankmelater"),     __("hour", "thankmelater")   ),
			86400 =>  array( __("days", "thankmelater"),      __("day", "thankmelater")    ),
			604800 => array( __("weeks", "thankmelater"),     __("week", "thankmelater")   )
		);

class TML_form {
	static $time_bases = "";
	
	const MESSAGE_ERROR   = 1;
	const MESSAGE_UPDATED = 2;
	const MESSAGE_INFO    = 3;

	// take a time in seconds and convert it to a suitable "natural" unit
	// for example, 43200 seconds becomes 14 hours
	// $types in form array( SECONDS_EQUIVALENT => array(NAME_PLURAL, NAME_SINGULAR) [...] )
	// ad-hoc implementation based on length of the whole number part.
	static function get_natural_time( $time, $types = NULL, $precision = 3 /* in decimal places */ ) 
	{
		if($types === NULL)
			$types = $GLOBALS["time_bases"];
			
		$ret = array( $time, 1 );
		
		foreach( $types as $t => $name ) {
			if( !$t )	
				continue;
				
			$new_time = $time / $t;
			
			$int_new_time = intval($new_time);
			
			if( $int_new_time && strlen($int_new_time) < strlen($ret[0]) )
				$ret = array( $new_time, $t );
		}
		
		$ret[0] = round($ret[0], $precision);
		
		return $ret;
		
	}
	
	//### functions to output input fields ###
	
	// generate the html tag attributed (ie: id="element-id" class="...)
	static function html_tag_attribs( $attribs ) {
		$out = "";
		foreach( $attribs as $a => $v )
			$out .= " " . attribute_escape($a) . '="' . attribute_escape($v) . '"';
		return $out;
	}
	
	static function input_checkbox($name, $value = 1, $checked = false, $tabindex = NULL, $additional_attribs = array() ) {
		global $tml_form_errors;
		$attribs = array_merge(
				array(
					"type" => "checkbox",
					"name" => $name,
					"value" => $value,
					"class" => ($tml_form_errors->param_has_error($name) ? "field_error" : "")
				),
				$additional_attribs
			);
		if($tabindex !== NULL)
			$attribs["tabindex"] = $tabindex;
			
		if($checked)
			$attribs["checked"] = "checked";
			
		return "<input" . self::html_tag_attribs($attribs) . " />";
	}
	
	static function input_small_text($name, $value, $tabindex = NULL, $additional_attribs = array() ) {
		global $tml_form_errors;
		$attribs = array_merge(
				array(
					"type" => "text",
					"size" => "7",
					"name" => $name,
					"value" => $value,
					"class" => "small-text " . ($tml_form_errors->param_has_error($name) ? "field_error" : "")
				),
				$additional_attribs
			);
		if($tabindex !== NULL)
			$attribs["tabindex"] = $tabindex;
			
		return "<input" . self::html_tag_attribs($attribs) . " />";	
	}
	
	static function input_text( $name, $value, $tabindex = NULL, $additional_attribs = array() ) {
		global $tml_form_errors;
		$attribs = array_merge(
				array(
					"type" => "text",
					"name" => $name,
					"value" => $value,
					"class" => "regular-text " .  ($tml_form_errors->param_has_error($name) ? "field_error" : "")
				),
				$additional_attribs
			);
		if($tabindex !== NULL)
			$attribs["tabindex"] = $tabindex;
			
		return "<input" . self::html_tag_attribs($attribs) . " />";	
	}
	
	static function input_select_base($name, $base = 1, $tabindex = NULL, $additional_attribs = array() ) {
		global $time_bases, $tml_form_errors;;
		
		$attribs = array_merge(
				array(
					"name" => $name,
					"class" => ($tml_form_errors->param_has_error($name) ? "field_error" : "")
				),
				$additional_attribs
			);
		if($tabindex !== NULL)
			$attribs["tabindex"] = $tabindex;
		
		$out = "<select" . self::html_tag_attribs($attribs) .">";
		
		foreach($time_bases as $t => $name) {
			$attribs = array(
					"value" => $t,
				);
			if($t == $base)
				$attribs["selected"] = "selected";
			$out .= "<option" . self::html_tag_attribs($attribs) .">". wp_specialchars($name[0])."</option>";
		}
		$out .= "</select>";
		
		return $out;
	}
	
	static function input_select_restriction_type($name, $sel = 0, $tabindex = NULL, $additional_attribs = array() ) {	
		global $tml_form_errors;	
		$attribs = array_merge(
				array(
					"name" => $name,
					"class" => ($tml_form_errors->param_has_error($name) ? "field_error" : "")
				),
				$additional_attribs
			);
		if($tabindex !== NULL)
			$attribs["tabindex"] = $tabindex;
			
		$out = "<select" . self::html_tag_attribs($attribs) .">";
		$out .=   '<option value="0"'.(($sel == 0) ? ' selected="selected"' : '').'>' . __('Include all excluding:', 'thankmelater') . '</option>';
		$out .=   '<option value="1"'.(($sel == 1) ? ' selected="selected"' : '').'>' . __('Include only:', 'thankmelater') . '</option>';
		$out .= "</select>";
		
		return $out;
	}
	
	// take a comma-separated string list (item1, item2, item3, ...)
	// and return an array, removing any empty elements
	// values are trim()ed
	static function list_to_array($list) {
		$arr = explode(",", $list);
		$newarr = array();
		foreach($arr as $a) 
			if( trim($a) )
				$newarr[] = trim( $a );
		return $newarr;
	}
	
	static function merge_post_data($values) {
		if(isset($_POST) && $_POST)
			foreach($values as $k => $v) {
				if( isset($_POST[$k]) )
					$values[$k] = stripslashes( $_POST[$k] );
				elseif( is_bool($v) ) // checkbox
					$values[$k] = false;
			}
		return $values;
	}
	
	// show the error/updated box
	// note: $message is not htmlspecialchars()'d, so links, etc, can be
	//  inserted. Make $message safe before passing it here, if necessary.
	static function show_message( $message, $type = NULL ) {
		switch( $type ) {
			case self::MESSAGE_ERROR:
				?>
				<p><div id="message" class="error"><p><strong><?php echo $message; ?></strong></p></div></p>
				<?php
			break;
			case self::MESSAGE_UPDATED:
			default:
				?>
				<p><div id="message" class="updated"><p><strong><?php echo $message; ?></strong></p></div></p>
				<?php
			break;
		}
	}
	
}

class TML_form_errors {
	var $has_errors = false;
	var $errors = array();
	
	// add an error
	// $param could be the form element name
	// or "form" for the form itself
	function add_error( $param, $message ) {
		$this->has_errors = true;
		$this->errors[ $param ][] = $message;
	}
	
	function list_errors() {
		echo "<ul>";
			
		foreach($this->errors as $param => $_errors)
			foreach($_errors as $i => $error)
				echo "<li>" . wp_specialchars( $error ) . "</li>";
		
		echo "</ul>";
	}
	
	function param_has_error( $name ) {
		if( isset($this->errors[$name]) && count($this->errors[$name]) )
			return true;
		return false;
	}
}

?>