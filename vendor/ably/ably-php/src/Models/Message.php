<?php
namespace Ably\Models;

class Message extends BaseMessage {

    /**
     * @var string|null The event name of the message.
     */
    public $name;

    /**
     * @var string|null Connection key from a realtime connection,
     * when publishing on behalf of it.
     */
    public $connectionKey;

    protected function encode() {
        $msg = parent::encode();

        if ( isset( $this->name ) && $this->name ) {
            $msg->name = $this->name;
        }

        if ( isset( $this->connectionKey ) && $this->connectionKey ) {
            $msg->connectionKey = $this->connectionKey;
        }

        return $msg;
    }

}
