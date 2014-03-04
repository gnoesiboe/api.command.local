<?php

namespace Gn\Api;

use Gn\Api\Exception\BadRequestException;
use Gn\Api\Exception\MissingRequiredParameterException;
use Gn\Api\Exception\NonAllowedParameterException;
use Gn\Api\ServiceLocator\CommandServiceLocator;

/**
 * Command
 */
abstract class Command
{

    /**
     * @var array
     */
    protected $registeredParams = array();

    /**
     * @var CommandServiceLocator
     */
    protected $serviceLocator;

    /**
     * @param CommandServiceLocator $serviceLocator
     */
    public function __construct(CommandServiceLocator $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;

        $this->configure();
    }

    /**
     * Configures this command
     */
    abstract protected function configure();

    /**
     * @param string $key
     * @param bool $required
     *
     * @return $this
     */
    protected function registerParam($key, $required)
    {
        $this->validateKey($key);
        $this->validateRequired($required);

        $this->registeredParams[$key] = $required;

        return $this;
    }

    /**
     * @param bool $required
     * @throws \UnexpectedValueException
     */
    protected function validateRequired($required)
    {
        if (is_bool($required) === false) {
            throw new \UnexpectedValueException('Required should be of type bool');
        }
    }

    /**
     * @param string $key
     * @throws \UnexpectedValueException
     */
    protected function validateKey($key)
    {
        if (is_string($key) === false) {
            throw new \UnexpectedValueException('Identifier should be of type string');
        }
    }

    /**
     * @param array $params
     * @return mixed
     *
     * @throws BadRequestException
     */
    public function execute(array $params)
    {
        $this->validateAgainstRegisteredParams($params);

        return $this->apply($params);
    }

    /**
     * @param array $params
     * @throws BadRequestException
     *
     * @return mixed
     */
    protected function apply(array $params)
    {
        try {
            return $this->doApply($params);
        } catch(\Exception $e) {
            throw new BadRequestException($e->getMessage(), 0, $e);
        }
    }

    /**
     * @param array $params
     */
    abstract protected function doApply(array $params);

    /**
     * @param string $key
     * @return bool
     */
    protected function hasRegisteredParam($key)
    {
        $this->validateKey($key);

        return array_key_exists($key, $this->registeredParams);
    }

    /**
     * @param array $params
     * @throws Exception\BadRequestException
     */
    protected function validateAgainstRegisteredParams(array $params)
    {
        $errors = array();

        // validate that no extra params are set
        foreach ($params as $key => $value) {
            try {
                if ($this->hasRegisteredParam($key) === false) {
                    throw new NonAllowedParameterException(sprintf('Parameter \'%s\' not allowed', (string) $key));
                }
            } catch (NonAllowedParameterException $e) {
                $errors[] = $e;
            }
        }

        // validate that no required key is missing
        foreach ($this->registeredParams as $registeredKey => $registerKeyRequired) {
            if ($registerKeyRequired === false) {
                continue;
            }

            try {
                if (array_key_exists($registeredKey, $params) === false) {
                    throw new MissingRequiredParameterException(sprintf('Missing required parameter \'%s\'', $registeredKey));
                }
            } catch (MissingRequiredParameterException $e) {
                $errors[] = $e;
            }
        }

        if (count($errors) > 0) {
            $badRequestException = new BadRequestException('Command could not be executed');
            $badRequestException->setChildren($errors);

            throw $badRequestException;
        }
    }
}
