<?php
class Address
{
    public $street;
    public $city;

    public function getGeoCoords()
    {
        $data = file_get_contents(
            'http://nominatim.openstreetmap.org/search?q='
            . urlencode($this->street)
            . ',' . urlencode($this->city)
            . '&format=json&addressdetails=1'
        );
        $json = json_decode($data);
        return array(
            'lat' => $json[0]->lat,
            'lon' => $json[0]->lon
        );
    }
}
?>
