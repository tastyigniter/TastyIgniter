<?php

namespace Admin\Widgets\Table\Source;

/**
 * The server-side data source for the Table widget.
 */
class DataSource
{
    /**
     * @var string Specifies a name of record's key column
     */
    protected $keyColumn;

    /**
     * @var integer Internal record offset
     */
    protected $offset = 0;

    /**
     * @var array Keeps the data source data.
     */
    protected $data = [];

    /**
     * Class constructor.
     *
     * @param string $keyColumn Specifies a name of the key column.
     */
    public function construct($keyColumn = 'id')
    {
        $this->keyColumn = $keyColumn;
    }

    /**
     * Initializes records in the data source.
     * The method doesn't replace existing records and
     * could be called multiple times in order to fill
     * the data source.
     *
     * @param array $records Records to initialize in the data source.
     */
    public function initRecords($records)
    {
        $this->data = array_merge($this->data, $records);
    }

    /**
     * Returns a total number of records in the data source.
     * @return integer
     */
    public function getCount()
    {
        return count($this->data);
    }

    /**
     * Removes all records from the data source.
     */
    public function purge()
    {
        $this->data = [];
    }

    /**
     * Return records from the data source.
     *
     * @param integer $offset Specifies the offset of the first record to return, zero-based.
     * @param integer $count Specifies the number of records to return.
     *
     * @return array Returns the records.
     * If there are no more records, returns an empty array.
     */
    public function getRecords($offset, $count)
    {
        return array_slice($this->data, $offset, $count);
    }

    /**
     * Returns all records in the data source.
     * This method is specific only for the client memory data sources.
     */
    public function getAllRecords()
    {
        return $this->data;
    }

    /**
     * Rewinds the the data source to the first record.
     * Use this method with the readRecords() method.
     */
    public function reset()
    {
        $this->offset = 0;
    }

    /**
     * Returns a set of records from the data source.
     *
     * @param integer $count Specifies the number of records to return.
     *
     * @return array Returns the records.
     * If there are no more records, returns an empty array.
     */
    public function readRecords($count = 10)
    {
        $result = $this->getRecords($this->offset, $count);
        $this->offset += count($result);

        return $result;
    }
}