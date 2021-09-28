<?php
/**
 * @package  AcmesportsPlugin
 */

class AcmesportsPluginActivate
{
   
	public  $output = "";

	public static function activate() {

		//this.>get_nfl_data("team_list");
     	//echo "Im activating";
	    //get_nfl_data	add_shortcode('nfltable', 'get_nfl_data');
		//add_shortcode('nfltable', array( $this , "nfltable_function" ) );
		
 	   flush_rewrite_rules();

	}
 
}