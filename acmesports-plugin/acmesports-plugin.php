<?php

/**
 * @package  AcmesportsPlugin
 */
/*
Plugin Name: Acmesports Plugin
Plugin URI: http://joehunter.es/plugin
Description: This is a simple challenge example plugin to provide a visual overview of the national footbal league (U.S.A) teams.
Version: 1.2.0
Author: Joseph Hunter
Author URI: http://wpdev.joehunter.es
License: GPLv2 or later
Text Domain: acmesports-plugin
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/

defined('ABSPATH') or die('No direct access');

if (!class_exists('AcmesportsPlugin')) {

	class AcmesportsPlugin
	{

		public $plugin;

		function __construct()
		{
			$this->plugin = plugin_basename(__FILE__);
		}

		function register()
		{
			add_action('wp_enqueue_scripts', array($this, 'enqueue')); // should just be include scripts ? datatables
			add_action('admin_menu', array($this, 'add_admin_pages'));
			add_filter("plugin_action_links_$this->plugin", array($this, 'settings_link'));
			add_shortcode('nfl_teams_table', array($this, 'nfl_teams_table_function'));
		}

		public function settings_link($links)
		{
			$settings_link = '<a href="admin.php?page=acmesports_plugin">Settings</a>';
			array_push($links, $settings_link);
			return $links;
		}

		public function add_admin_pages()
		{
			add_menu_page('Acmesports Plugin', 'Acmesports', 'manage_options', 'acmesports_plugin', array($this, 'admin_index'), 'dashicons-store', 110);
		}

		public function admin_index()
		{
			require_once plugin_dir_path(__FILE__) . 'templates/admin.php';
		}


		function enqueue()
		{
			// enqueue all our scripts
			wp_enqueue_style('datatables_style',         plugins_url('/assets/css/jquery.dataTables.min.css', __FILE__));
			wp_enqueue_style('main_style',               plugins_url('/assets/css/main.css', __FILE__));
			wp_enqueue_script('datatables_script',       plugins_url('/assets/js/jquery.dataTables.min.js', __FILE__), array('jquery-core'), null, true); // require jquery first
			wp_enqueue_script('datatbles_config_script', plugins_url('/assets/js/dataTableConfig.js', __FILE__), array('jquery-core'), null, true);
		}


 		function activate()
		{
			require_once plugin_dir_path(__FILE__) . 'inc/acmesports-plugin-activate.php';
			AcmesportsPluginActivate::activate();
		}

		public function test_get()
		{   /*file_get_contents() may cause server env issues. Would be nice to have a wp hook for this*/
			$data = wp_remote_retrieve_body("https://delivery.oddsandstats.co/{$endpoint}/NFL.JSON?api_key=74db8efa2a6db279393b433d97c2bc843f8e32b0");
		}

		private function get_teams_list_array()
		{
			$endpoint   =   "team_list";
			
			return  json_decode(file_get_contents("https://delivery.oddsandstats.co/{$endpoint}/NFL.JSON?api_key=74db8efa2a6db279393b433d97c2bc843f8e32b0", ''), TRUE); // wp_remote_get ? 
	        /*Could do more here with parameters or an iteration with a case:switch*/  
	
		}

	    public function nfl_teams_table_function(){
			
			$data = $this->get_teams_list_array();

			$table_html  =

			'<table class="display" id="nfl-table" style="width:100%">
				<thead>
					<tr>
					<th>Name</th>
					<th>Nickname</th>
					<th>Display Name</th>
					<th>Id</th>
					<th>Conference</th>
					<th>Division</th>
					</tr>
				</thead>
				<tbody>
            ';

			foreach ($data['results']['data']['team'] as $index => $value) {

				$table_html .= "<tr><td>" . implode("</td><td>", array_values($value)) . "</td></tr>";
			}


			$table_html .=
				'   </tbody>
			</table>';

			return    $table_html;
		}

	}

	$alecadddPlugin = new AcmesportsPlugin();
	$alecadddPlugin->register();

	// activation
	/*instantiate or call our main logic pull data and manage template displays*/
	register_activation_hook(__FILE__, array($alecadddPlugin, 'activate')); /*activte*/

	// deactivation
	/*Do anything you need to*/
	require_once plugin_dir_path(__FILE__) . 'inc/acmesports-plugin-deactivate.php';
	register_deactivation_hook(__FILE__, array('AcmesportsPluginDeactivate', 'deactivate'));
}
