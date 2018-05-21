<?php

class SetupPDO extends PDO
{
    protected $configHost;
    protected $configPort;
    protected $configDatabase;
    protected $configUsername;
    protected $configPassword;
    protected $configPrefix;

    public function __construct(string $dsn, string $username, string $passwd, array $options, array $config)
    {
        foreach ($config as $item => $value) {
            $item = 'config'.ucfirst($item);
            if (property_exists($this, $item)) {
                $this->$item = $value;
            }
        }

        parent::__construct($dsn, $username, $passwd, $options);
    }

    public function config($key, $default = null)
    {
        $item = 'config'.ucfirst($key);

        return $this->$item ?? $default;
    }

    public function isFreshlyInstalled()
    {
        $fetch = $this->query("show tables where tables_in_{$this->configDatabase} like '".
            str_replace('_', '\\_', $this->configPrefix)."%'",
            static::FETCH_NUM
        );

        $tables = 0;
        while ($result = $fetch->fetch()) $tables++;

        return $tables < 1;
    }

    public function hasPreviouslyInstalledSettings()
    {
        $tableName = sprintf('%s%s', $this->configPrefix, 'settings');
        $fetch = $this->query("select * from {$tableName} where item = ".$this->quote('ti_version'), static::FETCH_ASSOC);

        $settings = $fetch->fetch();
        $version = $settings['value'] ?? null;

        return 0 === strpos($version, '2.1.');
    }
}