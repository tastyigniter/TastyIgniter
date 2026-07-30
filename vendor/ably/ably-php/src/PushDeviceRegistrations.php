<?php
namespace Ably;

use Ably\Models\DeviceDetails;
use Ably\Models\PaginatedResult;

class PushDeviceRegistrations {

    private $ably;

    /**
     * Constructor
     * @param AblyRest $ably Ably API instance
     */
    public function __construct( AblyRest $ably ) {
        $this->ably = $ably;
    }

    /**
     * Creates or updates the device. Returns a DeviceDetails object.
     *
     * @param array $device an array with the device information
     */
    public function save ( $device ) {
        $deviceDetails = new DeviceDetails( $device );
        $path = '/push/deviceRegistrations/' . $deviceDetails->id;
        $params = $deviceDetails->toArray();
        $body = $this->ably->put( $path, [], $params );
        $body = json_decode(json_encode($body), true); // Convert stdClass to array
        return new DeviceDetails ( $body );
    }

    /**
     *  Returns a DeviceDetails object if the device id is found or results in
     *  a not found error if the device cannot be found.
     *
     *  @param string $deviceId the id of the device
     */
    public function get ($deviceId) {
        $path = '/push/deviceRegistrations/' . $deviceId;
        $body = $this->ably->get( $path );
        $body = json_decode(json_encode($body), true); // Convert stdClass to array
        return new DeviceDetails ( $body );
    }

    /**
     *  Returns a PaginatedResult object with the list of DeviceDetails
     *  objects, filtered by the given parameters.
     *
     *  @param array $params the parameters used to filter the list
     */
    public function list_ (array $params = []) {
        $path = '/push/deviceRegistrations';
        return new PaginatedResult( $this->ably, 'Ably\Models\DeviceDetails', $cipher = false, 'GET', $path, $params );
    }

    /**
     *  Deletes the registered device identified by the given device id.
     *
     *  @param string $device_id the id of the device
     */
    public function remove ($deviceId, $returnHeaders = false) {
        $path = '/push/deviceRegistrations/' . $deviceId;
        return $this->ably->delete( $path, [], [], $returnHeaders );
    }

    /**
     * Deletes the subscriptions identified by the given parameters.
     *
     * @param array $params the parameters that identify the subscriptions to remove
     */
    public function removeWhere(array $params, $returnHeaders = false) {
        $path = '/push/deviceRegistrations';
        return $this->ably->delete( $path, [], $params, $returnHeaders );
    }

}
