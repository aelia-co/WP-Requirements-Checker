<?php
if(!defined('ABSPATH')) exit; // Exit if accessed directly

// Load the base class. Set the path accordingly
require_once dirname(__FILE__) . '/path/to/aelia-wc-requirementscheck.php';

/**
 * Sample plugin checking class.
 */
class Aelia_WP_Sample_Plugin_Requirements_Checker extends Aelia_WP_Requirements_Checker {
	// @var string The text domain for the messages displayed by the class.
	protected $text_domain = 'wp_aelia_sample_plugin';
	// @var string The plugin for which the requirements are being checked. Change it in descendant classes.
	protected $plugin_name = 'Aelia Sample Plugin';
	// @var string The path to the directory containing the admin-install.js file.
	protected $js_dir = 'some/javascript/dir';
	// @var string The PHP version required by the plugin.
	protected $php_version = '5.4';

	// @var array An array of PHP extensions required by the plugin.
	protected $required_extensions = array(
		'curl',
		'soap',
	);

	// @var array An array of WordPress plugins (name => version) required by the plugin.
	protected $required_plugins = array(
		'Important Required Plugin' => array(
			'version' => '1.2.3.140508',
			'extra_info' => 'You can get the plugin from <a href="http://site-xyz.com">site XYZ</a>.',
			'url' => 'http://site-xyz.com/important-required-plugin',
		),
	);

	/**
	 * Factory method. It MUST be copied to every descendant class, as it has to
	 * be compatible with PHP 5.2 and earlier, so that the class can be instantiated
	 * in any case and and gracefully tell the user if PHP version is insufficient.
	 *
	 * @return Aelia_WP_Sample_Plugin_RequirementsChecks
	 */
	public static function factory() {
		$instance = new self();
		return $instance;
	}
}
