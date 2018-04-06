<?php namespace System\Traits;

use Session;

trait SessionMaker
{
    /**
     * Retrieves key/value pair from session data.
     *
     * @param string $key Unique key for the data store.
     * @param string $default A default value to use when value is not found.
     *
     * @return mixed
     */
    public function getSession($key = null, $default = null)
    {
        $sessionKey = $this->makeSessionKey();
        $sessionData = [];

        if (!is_null($cached = Session::get($sessionKey))) {
            $sessionData = $this->decodeSessionData($cached);
        }

        return is_null($key) ? $sessionData : (isset($sessionData[$key]) ? $sessionData[$key] : $default);
    }

    /**
     * Saves key/value pair in to session data.
     *
     * @param string $key Unique key for the data store.
     * @param mixed $value The value to store.
     *
     * @return void
     */
    public function putSession($key, $value)
    {
        $sessionKey = $this->makeSessionKey();

        $sessionData = $this->getSession();
        $sessionData[$key] = $value;

        Session::put($sessionKey, $this->encodeSessionData($sessionData));
    }

    public function hasSession($key)
    {
        $sessionData = $this->getSession();

        return array_key_exists($key, $sessionData);
    }

    /**
     * Retrieves key/value pair from session temporary data.
     *
     * @param string $key Unique key for the data store.
     * @param string $default A default value to use when value is not found.
     *
     * @return mixed
     */
    public function getTempSession($key = null, $default = null)
    {
        $sessionKey = $this->makeSessionKey();
        $sessionData = [];

        if (!is_null($cached = Session::get($sessionKey))) {
            $sessionData = $this->decodeSessionData($cached);
        }

        return is_null($key) ? $sessionData : (isset($sessionData[$key]) ? $sessionData[$key] : $default);
    }

    /**
     * Saves key/value pair in to session temporary data.
     *
     * @param string $key Unique key for the data store.
     * @param mixed $value The value to store.
     *
     * @return void
     */
    public function putTempSession($key, $value)
    {
        $sessionKey = $this->makeSessionKey();

        $sessionData = $this->getSession();
        $sessionData[$key] = $value;

        Session::flash($sessionKey, $this->encodeSessionData($sessionData));
    }

    public function forgetSession($key)
    {
        $sessionData = $this->getSession();
        unset($sessionData[$key]);

        $sessionKey = $this->makeSessionKey();
        Session::put($sessionKey, $this->encodeSessionData($sessionData));
    }

    public function resetSession()
    {
        $sessionKey = $this->makeSessionKey();
        Session::forget($sessionKey);
    }

    /**
     * Returns a unique session identifier for this location.
     * @return string
     */
    protected function makeSessionKey()
    {
        if (isset($this->sessionKey))
            return $this->sessionKey;

        return get_class_id(get_class($this));
    }

    protected function encodeSessionData($data)
    {
        if (is_null($data))
            return null;

        if (!isset($this->encodeSession) OR $this->encodeSession === TRUE)
            $data = base64_encode(serialize($data));

        return $data;
    }

    protected function decodeSessionData($data)
    {
        if (!is_string($data))
            return null;

        $encodeSession = (!isset($this->encodeSession) OR $this->encodeSession === TRUE);

        if ($encodeSession OR (!$encodeSession AND is_string($data)))
            $data = @unserialize(@base64_decode($data));

        return $data;
    }
}