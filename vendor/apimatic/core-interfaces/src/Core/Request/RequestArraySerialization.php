<?php

namespace CoreInterfaces\Core\Request;

interface RequestArraySerialization
{
    public const INDEXED = "Indexed:&";
    public const UN_INDEXED = "UnIndexed:&";
    public const PLAIN = "Plain:&";
    public const CSV = "Csv:,";
    public const PSV = "Psv:|";
    public const TSV = "Tsv:\t";
}
