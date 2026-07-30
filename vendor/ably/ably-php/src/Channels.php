<?php
namespace Ably;

class Channels {

    private $ably;
    private $channels = [];

    /**
     * Constructor
     * @param AblyRest $ably Ably API instance
     */
    public function __construct( AblyRest $ably ) {
        $this->ably = $ably;
    }

    /**
     * Creates a new Channel object for the specified channel if none exists, or returns the existing channel
     * Note that if you request the same channel with different parameters, all the instances
     * of the channel will be updated.
     * @param string $name Name of the channel
     * @param array|null $options ChannelOptions for the channel
     * @return \Ably\Channel
     */
    public function get( $name, $options = null ) {

        if ( isset( $this->channels[$name] ) ) {
            if ( !is_null( $options ) ) {
                $this->channels[$name]->setOptions( $options );
            }

            return $this->channels[$name];
        } else {
            $this->channels[$name] = new Channel( $this->ably, $name, is_null( $options ) ? [] : $options );

            return $this->channels[$name];
        }
    }

    /**
     * Releases the channel resource i.e. it’s deleted and can then be garbage collected
     * @param string $name Name of the channel
     */
    public function release( $name ) {
        if ( isset( $this->channels[$name] ) ) {
            unset( $this->channels[$name] );
        }
    }
}