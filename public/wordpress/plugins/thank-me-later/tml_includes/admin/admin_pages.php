<?php

// functions to manage the admin page "structure" (ie navigation to child options)
class TML_admin_pages_hierarchy {
	static $levels = array();
	static $level_prefix = "tml_p";

	static function add_level() {
		$id = self::$level_prefix . count(self::$levels);
		self::$levels[ $id  ] = "";
		return $id;
	}
	
	static function assign_level($level, $value) {
		self::$levels[$level] = $value;
	}
	
	// build the URL query string for navigational links
	static function build_query( $level_id = "", $value = "", $add_get = false /* add get arguments */ ) {
		$q = isset($_GET["page"]) ? "&page=" . urlencode(stripslashes($_GET["page"])) : "";
		
		foreach(self::$levels as $k => $v) {
			if($k == $level_id) {
				$q .= "&" . urlencode($k) . "=" . urlencode($value);
				break; // only go up to our level (a parent's children is not important to a different, new parent)
			}else
				$q .= "&" . urlencode($k) . "=" . urlencode($v);
		}
		
		if($add_get) { // add get arguments?
		
			foreach($_GET as $k => $v) {
				if( self::$level_prefix == substr($k, 0, strlen(self::$level_prefix)) // don't prefix our page arguments (they have already been included) or
					|| $k == "page" // we have already dealt with page					
					)
					continue; // don't include this argument
				$q .= "&" . urlencode($k) . "=" . urlencode($v);
			}
		
		}
		
		return substr($q, 1);
	}
}

class TML_admin_pages {
	var $pages = NULL;
	var $page  = "";
	var $level_id = "";
	
	function TML_admin_pages() {
		$this->__construct();
	}
	
	function __construct($pages, $default) {
		$this->pages = $pages;
		$this->page  = $default;
		
		$level_id = TML_admin_pages_hierarchy::add_level();
		$this->level_id = $level_id;
		
		// if the $_GET value exists, set our current page to that and let the hierarchy class know
		if( isset( $_GET[ $level_id ] ) ) 
			if( isset( $this->pages[ stripslashes($_GET[$level_id]) ] ) ) {
				$this->page = stripslashes( $_GET[ $level_id ] ); 
			}
			
		TML_admin_pages_hierarchy::assign_level( $level_id, $this->page );
		
	}
	
	function nav() {
		global $tml;
		?>
		<ul id="submenu" class="subsubsub">
		<?php
		$first = true;
		foreach( $this->pages as $k => $p ) {
		
			if( isset($p["defaultly_hidden"]) && $p["defaultly_hidden"] && $this->page != $k )
				continue;
				
			$query_string = TML_admin_pages_hierarchy::build_query( $this->level_id, $k, ($this->page == $k) /* current page? */ );
		
			?>
			<li>
			<?php if (!$first) { ?>
			&bull;
			<?php } $first = false; ?>
				<a href="?<?php echo attribute_escape($query_string); ?>"<?php if($this->page == $k) { ?> class="current"<?php } ?>>
		
					<?php echo $p["display"]; ?>
			
				</a>
			</li>
			<?php
		
		}
		?>
		</ul>
		<div class="clear"></div>
		<?php
	}
	
	function content() {
		$levels = TML_admin_pages_hierarchy::$levels;
		
		$location = "";
		
		foreach($levels as $l) {
			$location .= preg_replace("#[^a-z0-9]#i", "_", $l) . "/";
		}
		
		$location .= preg_replace("#[^a-z0-9]#i", "_", $this->page) . ".php";	
		
		require_once $location;
	}
	
}

?>