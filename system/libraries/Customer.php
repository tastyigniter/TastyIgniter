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
 * Customer Class
 *
 * @category       Libraries
 * @package        Igniter\Libraries\Customer.php
 * @link           http://docs.tastyigniter.com
 */
class Customer extends \Igniter\Core\Auth
{
    protected $model = 'Customers_model';
    protected $identifier = 'email';

    protected $customer_id;
	protected $firstname;
	protected $lastname;
	protected $email;
	protected $telephone;
	protected $address_id;
	protected $security_question_id;
	protected $security_answer;
	protected $customer_group_id;

    public function __construct()
    {
        parent::__construct();
        $this->initialize();
    }

    public function initialize()
	{
        if (is_null($customerModel = $this->user()))
            return;

        foreach ($customerModel->toArray() as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }


        $this->is_logged = TRUE;
	}

    public function login($userModel, $remember = FALSE)
    {
        parent::login($userModel, $remember);
        $this->initialize();
    }

    public function logout()
	{
        parent::logout();

		$this->customer_id = '0';
		$this->firstname = '';
		$this->lastname = '';
		$this->email = '';
		$this->telephone = '';
		$this->address_id = '';
		$this->security_question_id = '';
		$this->security_answer = '';
		$this->customer_group_id = '';
	}

	public function isLogged()
	{
        return $this->check();
	}

	public function getId()
	{
		return $this->customer_id;
	}

	public function getName()
	{
		return $this->firstname . ' ' . $this->lastname;
	}

	public function getFirstName()
	{
		return $this->firstname;
	}

	public function getLastName()
	{
		return $this->lastname;
	}

	public function getEmail()
	{
		return strtolower($this->email);
	}

	public function checkPassword($password)
	{
        $credentials = [
            'email' => $this->email,
            'password' => $password
        ];
        return $this->validate($credentials, FALSE, FALSE);
	}

	public function getTelephone()
	{
		return $this->telephone;
	}

	public function getAddressId()
	{
		return $this->address_id;
	}

	public function getSecurityQuestionId()
	{
		return $this->security_question_id;
	}

	public function getSecurityAnswer()
	{
		return $this->security_answer;
	}

	public function getGroupId()
	{
		return $this->customer_group_id;
	}

	public function updateCart()
	{
		$this->CI->db->set('cart', ($cart_contents = $this->CI->cart->contents()) ? serialize($cart_contents) : '');
		$this->CI->db->where('customer_id', $this->customer_id);
		$this->CI->db->where('email', $this->email);
		$this->CI->db->update('customers');
	}
}

// END Customer Class

/* End of file Customer.php */
/* Location: ./system/tastyigniter/libraries/Customer.php */