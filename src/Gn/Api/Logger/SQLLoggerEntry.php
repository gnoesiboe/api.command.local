<?php

namespace Gn\Api\Logger;

/**
 * SQLLoggerEntry
 */
class SQLLoggerEntry
{

    /**
     * @var string
     */
    protected $sql = null;

    /**
     * @var array
     */
    protected $params = null;

    /**
     * @var array
     */
    protected $types = null;

    /**
     * @var float
     */
    protected $startTime = null;

    /**
     * @var float
     */
    protected $endTime = null;

    /**
     * @param $sql
     * @param array $params
     * @param array $types
     */
    public function __construct($sql, array $params = null, array $types = null)
    {
        $this->sql = $sql;
        $this->params = $params;
        $this->types = $types;
        $this->startTime = microtime(true);
    }

    /**
     * Proclaims that the query has ended
     */
    public function proclaimEnded()
    {
        $this->endTime = microtime(true);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            'sql' => $this->sql,
            'params' => $this->params,
            'types' => $this->types,
            'duration' => $this->calculateDuration()
        );
    }

    /**
     * @return float
     */
    protected function calculateDuration()
    {
        $inSeconds = $this->endTime - $this->startTime;
        $inMiliseconds = ($inSeconds * 1000);

        return $inMiliseconds;
    }
}
