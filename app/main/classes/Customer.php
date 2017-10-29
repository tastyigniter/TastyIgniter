<?php namespace Main\Classes;

/**
 * Customer Class
 *
 * @package Main
 */
class Customer extends \Igniter\Flame\Auth\Manager
{
    protected $sessionKey = 'customer_info';

    protected $model = 'Admin\Models\Customers_model';

    protected $identifier = 'email';

//    protected $customer_id;
//
//    protected $first_name;
//
//    protected $last_name;
//
//    protected $email;
//
//    protected $telephone;
//
//    protected $address_id;
//
//    protected $security_question_id;
//
//    protected $security_answer;
//
//    protected $customer_group_id;

//    public function __construct()
//    {
//        parent::__construct();
//        $this->initialize();
//    }
//
//    public function logout()
//    {
//        parent::logout();
//
//        $this->customer_id = '0';
//        $this->first_name = '';
//        $this->last_name = '';
//        $this->email = '';
//        $this->telephone = '';
//        $this->address_id = '';
//        $this->security_question_id = '';
//        $this->security_answer = '';
//        $this->customer_group_id = '';
//    }

    public function isLogged()
    {
        return $this->check();
    }

    public function getId()
    {
        return $this->user->customer_id;
    }

    public function getName()
    {
        return $this->user->customer_name;
    }

    public function getFirstName()
    {
        return $this->user->first_name;
    }

    public function getLastName()
    {
        return $this->user->last_name;
    }

    public function getEmail()
    {
        return strtolower($this->user->email);
    }

//    public function checkPassword($password)
//    {
//        $credentials = [
//            'email'    => $this->email,
//            'password' => $password,
//        ];
//
//        return $this->validate($credentials, FALSE, FALSE);
//    }

    public function getTelephone()
    {
        return $this->user->telephone;
    }

    public function getAddressId()
    {
        return $this->user->address_id;
    }

    public function getSecurityQuestionId()
    {
        return $this->user->security_question_id;
    }

    public function getSecurityAnswer()
    {
        return $this->user->security_answer;
    }

    public function getGroupId()
    {
        return $this->user->customer_group_id;
    }

    public function updateCart()
    {
//        $this->CI->db->set('cart', ($cart_contents = $this->CI->cart->contents()) ? serialize($cart_contents) : '');
//        $this->CI->db->where('customer_id', $this->customer_id);
//        $this->CI->db->where('email', $this->email);
//        $this->CI->db->update('customers');
    }
}
