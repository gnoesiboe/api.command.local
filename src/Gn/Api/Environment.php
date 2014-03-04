<?php

namespace Gn\Api;

/**
 * Environment
 */
class Environment
{

    /**
     * @var string
     */
    const PRODUCTION = 'prod';

    /**
     * @var string
     */
    const DEVELOPMENT = 'dev';

    /**
     * @var string
     */
    const TEST = 'test';

    /**
     * @var string
     */
    const STAGING = 'staging';

    /**
     * @var string
     */
    protected $value;

    /**
     * @var array
     */
    protected static $supportedEnvironments = array(
        self::PRODUCTION,
        self::STAGING,
        self::TEST,
        self::DEVELOPMENT
    );

    /**
     * @param string $value
     */
    public function __construct($value)
    {
        $this->setValue($value);
    }

    /**
     * @param string $value
     */
    protected function setValue($value)
    {
        $this->validateValue($value);
        $this->value = $value;
    }

    /**
     * @param string $value
     * @throws \UnexpectedValueException
     */
    protected function validateValue($value)
    {
        if (is_string($value) === false) {
            throw new \UnexpectedValueException('Please provide an environment');
        }

        if (in_array($value, self::$supportedEnvironments) === false) {
            throw new \UnexpectedValueException(sprintf('Environment %s not supported', $value));
        }
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isDevelopmentEnvironment()
    {
        return $this->isEnvironment(self::DEVELOPMENT);
    }

    /**
     * @param string $value
     * @return bool
     */
    public function isEnvironment($value)
    {
        return $this->value === $value;
    }

    /**
     * @return bool
     */
    public function isProductionEnvironment()
    {
        return $this->isEnvironment(self::PRODUCTION);
    }

    /**
     * @return Environment
     */
    public static function createFromEnvironmentVariables()
    {
        return new static(is_string(getenv('APPLICATION_ENV')) === true ? getenv('APPLICATION_ENV') : Environment::DEVELOPMENT);
    }
}
