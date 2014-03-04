<?php

namespace Gn\Api;

/**
 * ResponseBodyGenerator
 */
class ResponseBodyGenerator implements ResponseBodyGeneratorInterface
{

    /**
     * @var array
     */
    protected $adapters = array();

    /**
     * @var null
     */
    protected $defaultAdapterIdentifier = null;

    /**
     * @param array $adapters
     */
    public function __construct(array $adapters)
    {
        $this->registerAdapters($adapters);
    }

    /**
     * @param array $adapters
     * @throws \UnexpectedValueException
     */
    protected function registerAdapters(array $adapters)
    {
        if (count($adapters) === 0) {
            throw new \UnexpectedValueException('At least one adapter should be supplied');
        }

        foreach ($adapters as $identifier => $adapter) {
            $this->registerAdapter($identifier, $adapter);
        }
    }

    /**
     * @param string $identifier
     * @param ResponseBodyGeneratorAdapterInterface $adapter
     *
     * @return ResponseBodyGenerator
     */
    public function registerAdapter($identifier, ResponseBodyGeneratorAdapterInterface $adapter)
    {
        $this->validateIdentifier($identifier);

        $isFirst = count($this->adapters) === 0;

        $this->adapters[$identifier] = $adapter;

        if ($isFirst === true) {
            $this->defaultAdapterIdentifier = $identifier;
        }

        return $this;
    }

    /**
     * @param string $identifier
     * @throws \UnexpectedValueException
     */
    protected function validateIdentifier($identifier)
    {
        if (is_string($identifier) === false) {
            throw new \UnexpectedValueException('Identifier should be of type string');
        }
    }

    /**
     * @param string $identifier
     * @return ResponseBodyGenerator
     */
    public function setDefaultAdapterIdentifier($identifier)
    {
        $this->validateIdentifier($identifier);
        $this->defaultAdapterIdentifier = $identifier;

        return $this;
    }

    /**
     * @param string $identifier
     * @return ResponseBodyGeneratorAdapterInterface
     *
     * @todo move to adapter bag?
     */
    protected function getAdapter($identifier)
    {
        return $this->adapters[$identifier];
    }

    /**
     * @param string $identifier
     * @return bool
     *
     * @todo move to adapter bag?
     */
    protected function hasAdapter($identifier)
    {
        return array_key_exists($identifier, $this->adapters);
    }

    /**
     * @return ResponseBodyGeneratorAdapterInterface
     */
    protected function getDefaultAdapter()
    {
        return $this->getAdapter($this->defaultAdapterIdentifier);
    }

    /**
     * @param Request $request
     * @return ResponseBodyGeneratorAdapterInterface
     */
    public function defineAdapter(Request $request)
    {
        $identifier = $request->headers->get('Accept', null);

        if (is_string($identifier) === true && $this->hasAdapter($identifier) === true) {
            $adapter = $this->getAdapter($identifier);
        } else {
            $adapter = $this->getDefaultAdapter();
        }

        return $adapter;
    }
}
