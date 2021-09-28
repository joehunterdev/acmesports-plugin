<?php
/**
 * @package  AcmesportsPlugin
 */

class AcmesportsPluginDeactivate
{
	public static function deactivate() {
		flush_rewrite_rules();
	}
}