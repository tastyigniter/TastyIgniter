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
 * @since     File available since Release 1.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Alert Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Libraries\Alert.php
 * @link           http://docs.tastyigniter.com
 */
class Alert {

	/**
	 * The current CodeIgniter instance.
	 *
	 * @var object
	 * @access private
	 */
	private $_ci;

	/**
	 * The messages retrieved from the session.
	 *
	 * @var array
	 * @access private
	 */
	private $_session_messages = array();

	/**
	 * The messages stored for displaying on this request.
	 *
	 * @var array
	 * @access private
	 */
	private $_messages = array();

	/**
	 * The permitted config options for alteration.
	 *
	 * @var array
	 * @access private
	 */
	private $_config_whitelist = array(
		'session_name', 'default_style', 'styles', 'close_button', 'split_default',
		'merge_form_errors', 'form_error_message', 'form_error_msg'
	);

	/**
	 * The session name used for flashdata.
	 *
	 * @var string
	 * @access public
	 */
	public $session_name = 'alert';

	/**
	 * The default styling used if none specified.
	 *
	 * @var array
	 * @access public
	 */
	public $default_style = array('<div>', '</div>');

	/**
	 * The different styles used for specific message types.
	 *
	 * @var array
	 * @access public
	 */
	//public $styles = array();

	/**
	 * Split the displayed messages by default.
	 *
	 * @var boolean
	 * @access public
	 */
	public $split_default = FALSE;

	/**
	 * Merge form validation errors with error messages.
	 *
	 * @var boolean
	 * @access public
	 */
	public $merge_form_errors = TRUE;

	/**
	 * Optionally display only a single form error message.
	 *
	 * @var string
	 * @access public
	 */
	public $form_error_message = NULL;

	/**
	 * Constructer
	 *
	 * Retrieves the CI instance in use and then attempts to
	 * override the config options based on the config file, then
	 * passed in options.
	 *
	 * @param array $config Any config options to override
	 *
	 * @access public
	 */
	public function __construct(array $config = array())
	{
		$this->_ci =& get_instance();

		$this->_ci->load->driver('session');
		$this->_ci->config->load('alert');

		if (is_array(config_item('alert')))
			$config = array_merge(config_item('alert'), $config);

		if ( ! empty($config))
			$this->_initialize($config);
	}

	/**
	 * Initalize Class
	 *
	 * Overrides the whitelisted default config options with the
	 * ones passed in as a param.
	 *
	 * @param array $config Any config options to override
	 *
	 * @return void
	 * @access private
	 */
	private function _initialize(array $config = array())
	{
		foreach ($config as $config_key => $config_value) {
			if (in_array($config_key, $this->_config_whitelist)) {
				$this->{$config_key} = $config_value;
			}
		}
    }

	/**
	 * Add Message
	 *
	 * Adds a message to the specified types array - you have
	 * the option to display the message on this request, else it
	 * will be stored in flashdata for the next one.
	 *
	 * @param mixed  $message     The message to be added
	 * @param mixed  $group        string to be used to group the message
	 * @param string $type        The type of message being added
	 * @param bool   $display_now Display the message on this request or the next
	 *
	 * @throws Exception If none scalar message or none string type entered
	 * @return object $this
	 * @access private
	 */
	private function _add_message($message, $group = '', $type = 'default', $display_now = FALSE)
	{
		// all messages must be scalar types (int, float, string or boolean)
		// and the type must be a string, if either invalid an exception is raised
		if ( ! is_scalar($message) OR ! is_string($type))
			log_message('debug','Invalid message type/value entered.');

		// apply formatting based on type
//		$message = (is_array($data)) ?
//			vsprintf($message, $data) : sprintf($message, $data);

        // Set alert session name to lock alert to admin, main or modules
        $group = (!empty($group)) ? $group : APPDIR.'_'.$this->session_name;

		if ($display_now === FALSE) {
			$this->_session_messages[$type][] = $message;
			$this->_ci->session->set_flashdata($group, $this->_session_messages);
		}
		else {
			$this->_messages[$group][$type][] = $message;
		}

		return $this;
	}

    /**
     * Get Messages
     *
     * Returns the specifed type of messages as an array, else returns all available
     * messages. Optionally allows you to return single types of messages as an associative
     * array, which is internally used for displaying.
     *
     * @param mixed  $group  string to be used to group the message
     * @param string $type the message type to return, or empty for all
     * @param boolean $single_as_assoc return single types as an associative array
     *
     * @return array The specifed types messages or empty array
     * @access public
     */
	public function get($group = '', $type = '', $single_as_assoc = FALSE)
	{
        $not_module = FALSE;
        if (empty($group)) {
            $not_module = TRUE;
            $group = APPDIR.'_'.$this->session_name;
        }

        $session_messages = $this->_ci->session->flashdata($group);
		$messages         = isset($this->_messages[$group]) ? $this->_messages[$group] : array();

		// sets the session message to an array if not already the case
		if ( ! is_array($session_messages)) {
			$session_messages = array();
		}

		// attempt to display form errors if no type or form/error types passed in
		if ($not_module === TRUE AND ($type === '' OR $type === 'form' OR ($this->merge_form_errors AND $type === 'error'))) {
			$this->_ci->load->library('form_validation');

			// check to see if any form validation errors are present
			if ($errors = trim(validation_errors(' ', '|'))) {
				if ($this->form_error_message !== NULL) {
					// create single item array with error message
					$form_errors = array($this->form_error_message);
				}
				else {
					// create array from validation errors string
					$form_errors = explode('|', substr($errors, 0, -1));
				}

				// Overwrite form errors with custom message
				array_unshift($form_errors, $this->form_error_msg[0]);

				// merge into errors array if configured to
				if ($this->merge_form_errors AND ($type === '' OR $type === 'error')) {
					if ( ! isset($messages['error']))
						$messages['error'] = array();

					$messages['error'] = array_merge($messages['error'], $form_errors);
				}
				else {
					if ( ! isset($messages['form']))
						$messages['form'] = array();

					$messages['form'] = array_merge($messages['form'], $form_errors);
				}
			}
		}

		// set the messages to a specific type if option present, else set to empty array
		if ($type !== '') {
			if (isset($session_messages[$type])) {
				// create associative array with type if desired
				$session_messages = ($single_as_assoc) ?
					array($type => $session_messages[$type]) : $session_messages[$type];
			}
			else {
				$session_messages = array();
			}

			if (isset($messages[$type])) {
				// create associative array with type if desired
				$messages = ($single_as_assoc) ?
					array($type => $messages[$type]) : $messages[$type];
			}
			else {
				$messages = array();
			}
		}

		// merge session messages into current requests array
		$messages = array_merge_recursive($session_messages, $messages);
		return $messages;
	}

	/**
	 * Display Messages
	 *
	 * Returns the HTML to display the specified type in either split or joined
	 * message format. If no type specified all types are returned.
	 * If 'form' is passed in as the type the form validation class is used
	 * to retrieve the errors.
	 *
     * @param mixed  $group  string to be used to group the message
     * @param string  $type  The message type to display
	 * @param boolean $split Display messages split or joined
	 *
	 * @return string The message HTML
	 * @access public
	 */
	public function display($group = '', $type = '', $split = NULL)
	{
		// set split option to default if no option passed in
		if ($split === NULL)
			$split = $this->split_default;

		// returns an associative array with specified messages in
		$messages = $this->get($group, $type, TRUE);
		$close_btn = $this->close_button[0] . $this->close_button[1];

		$output = '';
		if ( ! empty($messages)) {
			// loop through all message types if array not empty
			foreach ($messages as $type => $messages) {
				// set the selected style based on type or use default
				$selected_style = (isset($this->styles[$type])) ?
					$this->styles[$type] : $this->default_style;

				// output beginning style if split is false
				if ( ! $split) {
					$output .= $selected_style[0] . $close_btn . '<ul class="list-group-alert">';
				}

				foreach ($messages as $key => $message) {
					// output full message style with message if split is true
					if ($split) {
						$output .= $selected_style[0] . $close_btn . $message . $selected_style[1];
					}
					// output as a list element if not
					else if ($type === 'form') {
						$class = ($key < 1) ? 'alert-dropdown' : 'alert-hide';
						$output .= '<li class="'.$class.'">' . $message . '</li>';
					}
					else {
						$output .= '<li>' . $message . '</li>';
					}
				}

				// output ending style if split is false
				if ( ! $split) {
					$output .= '</ul>' . $selected_style[1];
				}
			}
		}

		return $output;
	}

    /**
     * Set Messages
     *
     *
     * @param string $type The message type to display
     * @param $message
     * @param mixed  $group  string to be used to group the message
     * @return string The message HTML
     * @internal param bool $split Display messages split or joined
     *
     * @access public
     */
	public function set($type = '', $message, $group = '') {
		// call the private add message method with provided arguments
		return $this->{$type}($message, $group);
	}

	/**
	 * Call (Magic Method)
	 *
	 * Used to allow the user to call the class with a message type as the function name.
	 * When called it internally invokes the private add message function.
	 *
	 * @param string $name      The message type name
	 * @param array  $arguments The arguments passed into the method
	 *
	 * @throws BadMethodCallException If no arguments are passed in
	 * @return object $this
	 * @access public
	 */
	public function __call($name, $arguments)
	{
        if ( ! empty($arguments)) {
			// set display status based on function call name and set message
			$name    = preg_replace('/_now$/', '', $name, 1, $display_now);
			$message = $arguments[0];
            $group = (isset($arguments[1])) ? $arguments[1] : '';

			// call the private add message method with provided arguments
			return $this->_add_message($message, $group, $name, (bool)$display_now);
		}
		// throw a bad method exception if no arguments passed
		else {
			show_error('Requires arguments to be passed');
		}
	}

	/**
	 * Get (Magic Method)
	 *
	 * Used to allow the user to call the class with a message type as the property name.
	 * When called it internally invokes the get function.
	 *
	 * @param string $name The type of messages to return
	 *
	 * @return array The specifed types messages or empty array
	 * @access public
	 */
	public function __get($name)
	{
        return $this->get($name);
	}

}


/* End of file flash.php */
/* Location: ./sparks/flash/1.0.0/libraries/flash.php */