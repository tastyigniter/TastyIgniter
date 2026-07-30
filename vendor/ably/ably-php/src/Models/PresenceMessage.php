<?php
namespace Ably\Models;

class PresenceMessage extends BaseMessage {

    /**
     * @var int A unique id for the client associated with the update, to disambiguate in the case
     * that a single clientId is simultaneously present multiple times (eg on different connections).
     * Populated by the server.
     */
    public $memberKey;
    /**
     * @var int The timestamp for this message. Populated by the server.
     */
    public $action;

    const ABSENT  = 0;
    const PRESENT = 1;
    const ENTER   = 2;
    const LEAVE   = 3;
    const UPDATE  = 4;
}