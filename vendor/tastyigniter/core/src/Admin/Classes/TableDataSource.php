<?php

declare(strict_types=1);

namespace Igniter\Admin\Classes;

/**
 * The server-side data source for the Table widget.
 */
class TableDataSource
{
    /** Internal record offset */
    protected int $offset = 0;

    /** Keeps the data source data. */
    protected array $data = [];

    /**
     * Class constructor.
     *
     * @param string $keyColumn Specifies a name of the key column.
     */
    public function __construct(protected string $keyColumn = 'id') {}

    /**
     * Initializes records in the data source.
     * The method doesn't replace existing records and
     * could be called multiple times in order to fill
     * the data source.
     *
     * @param array $records Records to initialize in the data source.
     */
    public function initRecords(array $records): void
    {
        $this->data = array_merge($this->data, $records);
    }

    /**
     * Returns a total number of records in the data source.
     */
    public function getCount(): int
    {
        return count($this->data);
    }

    /**
     * Removes all records from the data source.
     */
    public function purge(): void
    {
        $this->data = [];
    }

    /**
     * Return records from the data source.
     *
     * @param int $offset Specifies the offset of the first record to return, zero-based.
     * @param int $count Specifies the number of records to return.
     *
     * @return array Returns the records.
     * If there are no more records, returns an empty array.
     */
    public function getRecords($offset, $count): array
    {
        return array_slice($this->data, $offset, $count);
    }

    /**
     * Returns all records in the data source.
     * This method is specific only for the client memory data sources.
     */
    public function getAllRecords(): array
    {
        return $this->data;
    }

    /**
     * Rewinds the the data source to the first record.
     * Use this method with the readRecords() method.
     */
    public function reset(): void
    {
        $this->offset = 0;
    }

    /**
     * Returns a set of records from the data source.
     *
     * @param int $count Specifies the number of records to return.
     *
     * @return array Returns the records.
     * If there are no more records, returns an empty array.
     */
    public function readRecords(int $count = 10): array
    {
        $result = $this->getRecords($this->offset, $count);
        $this->offset += count($result);

        return $result;
    }
}
