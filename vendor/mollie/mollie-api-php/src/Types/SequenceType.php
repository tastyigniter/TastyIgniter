<?php

namespace Mollie\Api\Types;

class SequenceType
{
    /**
     * Sequence types.
     *
     * @see https://docs.mollie.com/guides/recurring
     */
    public const SEQUENCETYPE_ONEOFF = "oneoff";
    public const SEQUENCETYPE_FIRST = "first";
    public const SEQUENCETYPE_RECURRING = "recurring";
}
