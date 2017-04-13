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
 * @since File available since Release 2.2
 */
//namespace Igniter\Core;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * BcryptHash Class
 *
 * @category       Core
 * @package        Igniter\Core\BcryptHash.php
 * @link           http://docs.tastyigniter.com
 */
class BcryptHash
{
    /**
     * Default crypt cost factor.
     *
     * @var int
     */
    protected $rounds = 10;

    public function getHashKey()
    {
        $CI =& get_instance();

        return $CI->config->item('encryption_key');
    }

    /**
     * Hash the given value.
     *
     * @param  string $value
     * @param  array $options
     *
     * @return bool|string
     */
    public function make($value, array $options = [])
    {
        $hash = password_hash($value, PASSWORD_BCRYPT, [
            'cost' => $this->cost($options),
        ]);

        if ($hash === FALSE) {
            log_message('error', 'Bcrypt hashing not supported. See http://php.net/crypt');

            return FALSE;
        }

        return $hash;
    }

    /**
     * Check the given plain value against a hash.
     *
     * @param  string $value
     * @param  string $hashedValue
     *
     * @return bool
     */
    public function check($value, $hashedValue)
    {
        if (strlen($hashedValue) === 0) {
            return FALSE;
        }

        return password_verify($value, $hashedValue);
    }

    /**
     * Check if the given hash has been hashed using the given options.
     *
     * @param  string $hashedValue
     * @param  array $options
     *
     * @return bool
     */
    public function needsRehash($hashedValue, array $options = [])
    {
        return password_needs_rehash($hashedValue, PASSWORD_BCRYPT, [
            'cost' => $this->cost($options),
        ]);
    }

    /**
     * Set the default password work factor.
     *
     * @param  int $rounds
     *
     * @return $this
     */
    public function setRounds($rounds)
    {
        $this->rounds = (int)$rounds;

        return $this;
    }

    /**
     * Extract the cost value from the options array.
     *
     * @param  array $options
     *
     * @return int
     */
    protected function cost(array $options = [])
    {
        return isset($options['rounds']) ? $options['rounds'] : $this->rounds;
    }
}