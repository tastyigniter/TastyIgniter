<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package   TastyIgniter
 * @author    SamPoyigi
 * @copyright TastyIgniter
 * @link      http://tastyigniter.com
 * @license   http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since     File available since Release 2.2
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Components class for TastyIgniter.
 *
 * Provides utility functions for working with components.
 */
class Components
{
	/**
	 * Reference to the Component singleton
	 *
	 * @var    object
	 */
	protected static $instance;

	/**
	 * @var array Cache of registration callbacks.
	 */
	public static $registry = [];

	/**
	 * @var array Cache of registration components callbacks.
	 */
	protected static $components_callbacks = [];

	/**
	 * @var array Cache of registration gateways callbacks.
	 */
	protected static $gateways_callbacks = [];

	/**
	 * @var array An array where keys are codes and values are class paths.
	 */
	protected static $code_map = [];

	/**
	 * @var array An array where keys are class paths and values are codes.
	 */
	protected static $class_path_map = [];

	/**
	 * @var array An array containing references to a corresponding extension for each component class.
	 */
	protected static $extension_map = [];

	/**
	 * @var array A cached array of components component_meta.
	 */
	protected static $components = [];

	/**
	 * @var array A cached array of payment gateways meta.
	 */
	protected static $payment_gateways = [];

	public function __construct()
	{
		self::$instance = $this;
	}

	/**
	 * Run a extension component method. Output from component is buffered and returned.
	 *
	 * @param string $component The extension/component/method to run.
	 * @param string $controller
	 * @param array $module
	 *
	 * @return mixed The output from the module.
	 */
	public static function run($component, $controller, $module)
	{
		$method = 'index';

		// If a directory separator is found in $module, use the right side of the
		// separator as $method, the left side as $module.
		if (($pos = strrpos($component, '/')) != FALSE) {
			$method = substr($component, $pos + 1);
			$component = substr($component, 0, $pos);
		}

		// Load the class indicated by $module and check whether $method exists.
		$class = self::make_component($component, $controller, $module);
		if (!$class OR !method_exists($class, $method)) {
			log_message('error', "Extension component failed to run: {$component}/{$method}");

			return;
		}

		// Buffer the output.
		ob_start();

		// Get the remaining arguments and pass them to $method.
		$output = call_user_func([$class, $method]);

		// Get/clean the current buffer.
		$buffer = ob_get_clean();

		// If $output is not null, return it, otherwise return the buffered content.
		return $output !== null ? $output : $buffer;
	}

	/**
	 * Scans each extension and loads it components.
	 *
	 * @return void
	 */
	protected static function load_components()
	{
		// Load manually registered components
		foreach (self::$components_callbacks as $callback) {
			$callback(self::$instance);
		}

		// Load extensions components
		$extensions = Modules::get_extensions();
		foreach ($extensions as $extension) {
			$components = $extension->registerComponents();
			if (!is_array($components)) {
				continue;
			}

			foreach ($components as $class_path => $component) {
				self::register_component($class_path, $component, $extension);
			}
		}
	}

	/**
	 * Scans each extension and loads it payment gateways.
	 *
	 * @return void
	 */
	protected static function load_payment_gateways()
	{
		// Load manually registered components
		foreach (self::$gateways_callbacks as $callback) {
			$callback(self::$instance);
		}

		// Load extensions payment gateways
		$extensions = Modules::get_extensions();
		foreach ($extensions as $extension) {
			$payment_gateways = $extension->registerPaymentGateways();
			if (!is_array($payment_gateways)) {
				continue;
			}

			foreach ($payment_gateways as $class_path => $payment_gateway) {
				self::register_payment_gateway($class_path, $payment_gateway, $extension);
			}
		}
	}

	/**
	 * Manually registers a component.
	 * Usage:
	 * <pre>
	 *   Components::register_components(function($manager){
	 *       $manager->register_component('account_module/components/Account_module', array(
	 *          'name' => 'account_module',
	 *            'title' => 'Account Component',
	 *            'description' => '..',
	 *        );
	 *   });
	 * </pre>
	 *
	 * @param callable $definitions
	 *
	 * @return void
	 */
	public static function register_components(callable $definitions)
	{
		self::$components_callbacks[] = $definitions;
	}

	/**
	 * Manually registers a payment gateways.
	 * Usage:
	 * <pre>
	 *   Components::register_payment_gateways(function($manager){
	 *       $manager->register_payment_gateway('paypal_express/components/Paypal_express', array(
	 *          'name' => 'paypal_express',
	 *            'title' => 'PayPal Express',
	 *            'description' => '..',
	 *        );
	 *   });
	 * </pre>
	 *
	 * @param callable $definitions
	 *
	 * @return void
	 */
	public static function register_payment_gateways(callable $definitions)
	{
		self::$gateways_callbacks[] = $definitions;
	}

	/**
	 * Registers a single component.
	 *
	 * @param string $class_path
	 * @param array $component
	 * @param object $extension Extension
	 */
	public static function register_component($class_path, $component = null, $extension = null)
	{
		if (!self::$class_path_map) {
			self::$class_path_map = [];
		}

		if (!self::$code_map) {
			self::$code_map = [];
		}

		$class_path = str_replace('.php', '', $class_path);

		$code = isset($component['code']) ? $component['code'] : strtolower(basename($class_path));

		self::$code_map[$code] = $class_path;
		self::$class_path_map[$class_path] = $code;
		self::$components[$code] = array_merge($component, ['path' => $class_path]);

		if ($extension !== null) {
			self::$extension_map[$class_path] = $extension;
		}
	}

	/**
	 * Registers a single payment gateway.
	 *
	 * @param string $class_path
	 * @param array $payment_gateway
	 * @param object $extension Extension
	 */
	public static function register_payment_gateway($class_path, $payment_gateway = null, $extension = null)
	{
		if (!self::$class_path_map) {
			self::$class_path_map = [];
		}

		if (!self::$code_map) {
			self::$code_map = [];
		}

		$class_path = str_replace('.php', '', $class_path);

		$code = isset($payment_gateway['code']) ? $payment_gateway['code'] : strtolower(basename($class_path));

		self::$code_map[$code] = $class_path;
		self::$class_path_map[$class_path] = $code;
		self::$payment_gateways[$code] = array_merge($payment_gateway, ['path' => $class_path]);

		if ($extension !== null) {
			self::$extension_map[$class_path] = $extension;
		}
	}

	/**
	 * Returns a list of registered components.
	 *
	 * @return array Array keys are codes, values are component meta array.
	 */
	public static function list_components()
	{
		if (self::$components == null) {
			self::load_components();
		}

		return self::$components;
	}

	/**
	 * Returns a list of registered payment gateways.
	 *
	 * @return array Array keys are codes, values are payment gateways meta array.
	 */
	public static function list_payment_gateways()
	{
		if (self::$payment_gateways == null) {
			self::load_payment_gateways();
		}

		return self::$payment_gateways;
	}

	/**
	 * Returns a class name from a component code
	 * Normalizes a class name or converts an code to it's class name.
	 *
	 * @param string $name
	 *
	 * @return string The class name resolved, or null.
	 */
	public static function resolve($name)
	{
		self::list_components();

		if (isset(self::$code_map[$name])) {
			return self::$code_map[$name];
		}

		$name = self::convert_code_to_path($name);
		if (isset(self::$class_path_map[$name])) {
			return $name;
		}

		return null;
	}

	/**
	 * Checks to see if a component has been registered.
	 *
	 * @param string $name A component class name or alias.
	 *
	 * @return bool Returns true if the component is registered, otherwise false.
	 */
	public static function has_component($name)
	{
		$class_path = self::resolve($name);
		if (!$class_path) {
			return FALSE;
		}

		return isset(self::$class_path_map[$class_path]);
	}

	/**
	 * Returns component details based on its name.
	 *
	 * @param $name
	 *
	 * @return mixed|null
	 */
	public static function find_component($name)
	{
		if (!self::has_component($name)) {
			return null;
		}

		return self::$components[$name];
	}

	/**
	 * Returns payment gateway details based on its name.
	 *
	 * @param $name
	 *
	 * @return mixed|null
	 */
	public static function find_payment_gateway($name)
	{
		if (empty(self::$payment_gateways[$name])) {
			return null;
		}

		return self::$payment_gateways[$name];
	}

	/**
	 * Returns payment gateway details based on its name.
	 *
	 * @param $name
	 *
	 * @return mixed|null
	 */
	public static function get_meta($name)
	{
		if (!self::has_component($name)) {
			return null;
		}

		if (isset(self::$components[$name])) {
			return self::$components[$name];
		}

		if (isset(self::$payment_gateways[$name])) {
			return self::$payment_gateways[$name];
		}

		return null;
	}

	/**
	 * Makes a component/gateway object with properties set.
	 *
	 * @param string $name                A component/gateway class name or code.
	 * @param Main_Controller $controller The controller that spawned this component.
	 * @param array $params               The properties set by the Page or Layout.
	 *
	 * @return Base_Component The component object.
	 */
	public static function make_component($name, $controller = null, $params = [])
	{
		if (!isset(self::$registry[$name])) {
			$class_path = self::resolve($name);
			if (!$class_path) {
				show_error(sprintf('Class name is not registered for the component "%s". Check the component extension.', $name));
			}

			$class_name = ucfirst(basename($class_path));
			$module = dirname(dirname($class_path));
			list($path, $file) = Modules::find($class_name, $module, 'components/');

			if ($path != FALSE) {
				Modules::load_file($class_name, $path);
			}

			if (!class_exists($class_name, FALSE)) {
				show_error(sprintf('Component class not found "%s". Check the component extension.', $class_name));
			}

			// Create and register the new controller.
			$class_name = ucfirst($class_name);
			$component = new $class_name($controller, $params);
			$component->name = $name;
			self::$registry[$name] = $component;
		}

		return self::$registry[$name];
	}

	/**
	 * Returns a parent extension for a specific component.
	 *
	 * @param mixed $component A component to find the extension for.
	 *
	 * @return mixed Returns the extension object or null.
	 */
	public static function find_component_extension($component)
	{
		$class_path = self::resolve($component);
		if (isset(self::$extension_map[$class_path])) {
			return self::$extension_map[$class_path];
		}

		return null;
	}

	/**
	 * Convert class alias to class path
	 *
	 * @param string $alias
	 *
	 * @return string
	 */
	public static function convert_code_to_path($alias)
	{
		if (strpos($alias, '/') !== FALSE) {
			return $alias;
		}

		return $alias . '/components/' . ucfirst($alias);
	}
}
