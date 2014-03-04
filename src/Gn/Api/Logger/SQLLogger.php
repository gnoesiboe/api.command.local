<?php

namespace Gn\Api\Logger;

/**
 * SQLLogger
 */
class SQLLogger implements \Doctrine\DBAL\Logging\SQLLogger
{

    /**
     * @var SQLLoggerEntry[]
     */
    protected $entries = array();

    /**
     * @var int
     */
    protected $entryCounter = 0;

    /**
     * Logs a SQL statement somewhere.
     *
     * @param string $sql The SQL to be executed.
     * @param array|null $params The SQL parameters.
     * @param array|null $types The SQL parameter types.
     *
     * @return void
     */
    public function startQuery($sql, array $params = null, array $types = null)
    {
        $this->entryCounter++;
        $this->entries[$this->entryCounter] = new SQLLoggerEntry($sql, $params, $types);
    }

    /**
     * Marks the last started query as stopped. This can be used for timing of queries.
     *
     * @return void
     */
    public function stopQuery()
    {
        $this->entries[$this->entryCounter]->proclaimEnded();
    }

    /**
     * @return array
     */
    public function getEntriesAsArray()
    {
        $out = array(
            'count' => $this->entryCounter,
            'entries' => array()
        );

        foreach ($this->entries as $index => $entry) {
            $out['entries'][(int) $index] = $entry->toArray();
        }

        return $out;
    }
}
