<?php

namespace Gn\Api\ResponseBodyGeneratorAdapter;

use Gn\Api\RepresentationInterface;
use Gn\Api\ResponseBodyGeneratorAdapterInterface;

/**
 * Xml
 */
class Xml implements ResponseBodyGeneratorAdapterInterface
{

    /**
     * @param RepresentationInterface $representation
     * @return string
     */
    public function fromRepresentation(RepresentationInterface $representation)
    {
        $rootElement = new \SimpleXMLElement('<response></response>');

        $dataElement = $rootElement->addChild('data');
        $this->appendChildren($dataElement, $representation->getData());

        $debugElement = $rootElement->addChild('debug');
        $this->appendChildren($debugElement, $representation->getDebug());

        return $rootElement->asXML();
    }

    /**
     * @param \SimpleXMLElement $parent
     * @param array $data
     */
    protected function appendChildren(\SimpleXMLElement $parent, array $data)
    {
        foreach ($data as $key => $item) {
            $key = is_string($key) === true ? $key : 'item';

            if (is_scalar($item) === true) {
                $parent->addChild($key, $item);
            } else {
                $this->appendChildren($parent->addChild($key), $item);
            }
        }
    }

    /**
     * @param array $array
     * @return bool
     */
    protected function checkIsAssociativeArray(array $array)
    {
        return ctype_digit(implode('', array_keys($array)));
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return 'text/xml';
    }
}
