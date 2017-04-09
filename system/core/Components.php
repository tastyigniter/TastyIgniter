<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package Igniter
 * @author Samuel Adepoyigi
 * @copyright (c) 2013 - 2016. Samuel Adepoyigi
 * @copyright (c) 2016 - 2017. TastyIgniter Dev Team
 * @link https://tastyigniter.com
 * @license http://opensource.org/licenses/MIT The MIT License
 * @since File available since Release 1.0
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
	protected static $componentsCallbacks = [];

	/**
	 * @var array Cache of registration gateways callbacks.
	 */
	protected static $gatewaysCallbacks = [];

	/**
	 * @var array An array where keys are codes and values are class paths.
	 */
	protected static $codeMap = [];

	/**
	 * @var array An array where keys are class paths and values are codes.
	 */
	protected static $classPathMap = [];

	/**
	 * @var array An array containing references to a corresponding extension for each component class.
	 */
	protected static $extensionMap = [];

	/**
	 * @var array A cached array of components component_meta.
	 */
	protected static $components = [];

	/**
	 * @var array A cached array of payment gateways meta.
	 */
	protected static $paymentGateways = [];

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
		$class = self::makeComponent($component, $controller, $module);
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
	protected static function loadComponents()
	{
		// Load manually registered components
		foreach (self::$componentsCallbacks as $callback) {
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
				self::registerComponent($class_path, $component, $extension);
			}
		}
	}

	/**
	 * Scans each extension and loads it payment gateways.
	 *
	 * @return void
	 */
	protected static function loadPaymentGateways()
	{
		// Load manually registered components
		foreach (self::$gatewaysCallbacks as $callback) {
			$callback(self::$instance);
		}

		// Load extensions payment gateways
		$extensions = Modules::get_extensions();
		foreach ($extensions as $extension) {
			$paymentGateways = $extension->registerPaymentGateways();
			if (!is_array($paymentGateways)) {
				continue;
			}

			foreach ($paymentGateways as $class_path => $payment_gateway) {
				self::registerPaymentGateway($class_path, $payment_gateway, $extension);
			}
		}
	}

	/**
	 * Manually registers a component.
	 * Usage:
	 * <pre>
	 *   Components::registerComponents(function($manager){
	 *       $manager->registerComponent('account_module/components/Account_module', array(
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
	public static function registerComponents(callable $definitions)
	{
		self::$componentsCallbacks[] = $definitions;
	}

	/**
	 * Manually registers a payment gateways.
	 * Usage:
	 * <pre>
	 *   Components::registerPaymentGateways(function($manager){
	 *       $manager->registerPaymentGateway('paypal_express/components/Paypal_express', array(
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
	public static function registerPaymentGateways(callable $definitions)
	{
		self::$gatewaysCallbacks[] = $definitions;
	}

	/**
	 * Registers a single component.
	 *
	 * @param string $class_path
	 * @param array $component
	 * @param object $extension Extension
	 */
	public static function registerComponent($class_path, $component = null, $extension = null)
	{
		if (!self::$classPathMap) {
			self::$classPathMap = [];
		}

		if (!self::$codeMap) {
			self::$codeMap = [];
		}

		$class_path = str_replace('.php', '', $class_path);

		$code = isset($component['code']) ? $component['code'] : strtolower(basename($class_path));

		self::$codeMap[$code] = $class_path;
		self::$classPathMap[$class_path] = $code;
		self::$components[$code] = array_merge($component, ['path' => $class_path]);

		if ($extension !== null) {
			self::$extensionMap[$class_path] = $extension;
		}
	}

	/**
	 * Registers a single payment gateway.
	 *
	 * @param string $class_path
	 * @param array $payment_gateway
	 * @param object $extension Extension
	 */
	public static function registerPaymentGateway($class_path, $payment_gateway = null, $extension = null)
	{
		if (!self::$classPathMap) {
			self::$classPathMap = [];
		}

		if (!self::$codeMap) {
			self::$codeMap = [];
		}

		$class_path = str_replace('.php', '', $class_path);

		$code = isset($payment_gateway['code']) ? $payment_gateway['code'] : strtolower(basename($class_path));

		self::$codeMap[$code] = $class_path;
		self::$classPathMap[$class_path] = $code;
		self::$paymentGateways[$code] = array_merge($payment_gateway, ['path' => $class_path]);

		if ($extension !== null) {
			self::$extensionMap[$class_path] = $extension;
		}
	}

	/**
	 * Returns a list of registered components.
	 *
	 * @return array Array keys are codes, values are component meta array.
	 */
	public static function listComponents()
	{
		if (self::$components == null) {
			self::loadComponents();
		}

		return self::$components;
	}

	/**
	 * Returns a list of registered payment gateways.
	 *
	 * @return array Array keys are codes, values are payment gateways meta array.
	 */
	public static function listPaymentGateways()
	{
		if (self::$paymentGateways == null) {
			self::loadPaymentGateways();
		}

		return self::$paymentGateways;
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
		self::listComponents();

		if (isset(self::$codeMap[$name])) {
			return self::$codeMap[$name];
		}

		$name = self::convertCodeToPath($name);
		if (isset(self::$classPathMap[$name])) {
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
	public static function hasComponent($name)
	{
		$class_path = self::resolve($name);
		if (!$class_path) {
			return FALSE;
		}

		return isset(self::$classPathMap[$class_path]);
	}

	/**
	 * Returns component details based on its name.
	 *
	 * @param $name
	 *
	 * @return mixed|null
	 */
	public static function findComponent($name)
	{
		if (!self::hasComponent($name)) {
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
	public static function findPaymentGateway($name)
	{
		if (empty(self::$paymentGateways[$name])) {
			return null;
		}

		return self::$paymentGateways[$name];
	}

	/**
	 * Returns payment gateway details based on its name.
	 *
	 * @param $name
	 *
	 * @return mixed|null
	 */
	public static function getMeta($name)
	{
		if (!self::hasComponent($name)) {
			return null;
		}

		if (isset(self::$components[$name])) {
			return self::$components[$name];
		}

		if (isset(self::$paymentGateways[$name])) {
			return self::$paymentGateways[$name];
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
	 * @return BaseComponent The component object.
	 */
	public static function makeComponent($name, $controller = null, $params = [])
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
	public static function findComponentExtension($component)
	{
		$class_path = self::resolve($component);
		if (isset(self::$extensionMap[$class_path])) {
			return self::$extensionMap[$class_path];
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
	public static function convertCodeToPath($alias)
	{
		if (strpos($alias, '/') !== FALSE) {
			return $alias;
		}

		return $alias . '/components/' . ucfirst($alias);
	}
}
