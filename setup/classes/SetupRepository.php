<?php

class SetupRepository
{
    /**
     * All of the configuration items.
     *
     * @var array
     */
    protected $items = [];

    /**
     * @var string
     */
    protected $configPath;

    /**
     * Set the config paths and items.
     */
    public function __construct($path)
    {
        $this->configPath = $path;
        $this->load();
    }

    public function load()
    {
        if (!is_file($this->configPath))
            touch($this->configPath);

        $this->items = @json_decode($this->contents(), TRUE);

        return $this;
    }

    /**
     * Determine if the given configuration value exists.
     *
     * @param  string $key
     *
     * @return bool
     */
    public function has($key)
    {
        return isset($this->items[$key]);
    }

    /**
     * Get the specified configuration value.
     *
     * @param  array|string $key
     * @param  mixed $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (!isset($this->items[$key])) {
            return $default;
        }

        return $this->items[$key];
    }

    /**
     * Set a given configuration value.
     *
     * @param  array|string $key
     * @param  mixed $value
     *
     * @return \SetupRepository
     */
    public function set($key, $value = null)
    {
        $this->items[$key] = $value;

        return $this;
    }

    /**
     * Get all of the configuration items for the application.
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Get the content of the config file.
     * @return string
     */
    public function contents()
    {
        return file_get_contents($this->configPath);
    }

    /**
     * Get the the config file path.
     * @return string
     */
    public function getPath()
    {
        return $this->configPath;
    }

    public function save()
    {
        $contents = @json_encode($this->items);

        return file_put_contents($this->configPath, $contents);
    }

    public function exists()
    {
        return is_file($this->configPath);
    }

    public function destroy()
    {
        @unlink($this->configPath);

        return $this;
    }
}