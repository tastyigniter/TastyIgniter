<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Describes the type of this unit and indicates which field contains the unit information. This is an
 * ‘open’ enum.
 */
class TerminalActionActionType
{
    /**
     * The action represents a request to check if the specific device is
     * online or currently active with the merchant in question. Does not require an action options value.
     */
    public const PING = 'PING';

    /**
     * Represents a request to save a card for future card-on-file use. Details are contained
     * in the `save_card_options` object.
     */
    public const SAVE_CARD = 'SAVE_CARD';

    /**
     * The action represents a request to display the receipt screen options. Details are
     * contained in the `receipt_options` object.
     */
    public const RECEIPT = 'RECEIPT';
}
