<?php namespace Igniter\Libraries\Location;

use Exception;
use Model;
use Igniter\Traits\DelegateToCI;
use Igniter\Traits\SessionMaker;


/**
 * Location Class
 *
 * @package        Igniter\Libraries\Location.php
 * @link           http://docs.tastyigniter.com
 */
class Location
{
    use DelegateToCI;
    use SessionMaker;

    public $encodeSession = false;

    const CLOSED = 'closed';
    const OPEN = 'open';
    const OPENING = 'opening';
    const DELIVERY = 'delivery';
    const COLLECTION = 'collection';

    /**
     * @var  \Igniter\Libraries\Location\Area
     */
    public $area;

    /**
     * @var \Igniter\Libraries\Location\Geocode
     */
    public $geocode;

    /**
     * @var \Igniter\Libraries\Location\WorkingHours
     */
    public $workingHours;

    /**
     * @var \Admin\Models\Locations_model
     */
    protected $model;

    public $config;

    protected $params = [];

    public $searchMode;

    public static $defaultLocation;

    public $order_type = 'delivery';

    public $permalink;

    protected $isInitialized;

    protected static $localModelCache = [];

    protected $tempSessionData;

    protected static $orderTypes = [];

    public function __construct($config)
    {
        $this->config = $config;
        $this->area = new Area($this);
        $this->workingHours = new WorkingHours($this);

        $this->subscribeEvents();

        self::$orderTypes = [1 => self::DELIVERY, 2 => self::COLLECTION];

        if (!isset($this->config['location_id']))
            $this->config['location_id'] = setting('default_location_id');

        $this->setSearchMode(setting('site_location_mode'));
    }

    public function initialize($useDefault = FALSE)
    {
//        if (!$this->isMultiSearchMode() OR $useDefault OR !$this->getParam('location_id')) {
        if ($useDefault OR !$this->isMultiSearchMode()) {
            $this->setParam('location_id', $this->config['location_id']);
        }

        $model = null;

        // We wont have to reload the class properties
        // if specific parameters has not changed
        if ($this->validateParams()) {
            $this->setModel($this->getLocal($this->getParams()));

            $this->workingHours()->initialize();
            $this->area()->initialize();
        }

        $model = $this->getModel();
        $this->isInitialized = ($model AND $model->exists);
        if (!$this->isInitialized)
            $this->clearLocal();
    }

    public function reload()
    {
        $this->initialize();
    }

    protected function validateParams()
    {
        $sessLocal = $this->getSession();
        $params = $this->getParams();

        $changed = FALSE;
        foreach ($params as $key => $value) {
            if ($value == null) {
                $this->setParam($key, isset($sessLocal[$key]) ? $sessLocal[$key] : $value);
                $changed = TRUE;
            }
        }

        return $changed;
    }

    protected function getParams()
    {
        $default = [
            'location_id'  => null,
            'area_id'      => null,
            'order_type'   => null,
            'geocode'      => null,
            'userPosition' => null,
        ];

        return array_merge($default, $this->params);
    }

    public function getParam($key, $default = null)
    {
        $params = $this->getParams();

        return isset($params[$key]) ? $params[$key] : $default;
    }

    protected function setParam($key, $value, $updateSession = FALSE)
    {
        $this->params[$key] = $value;

        if ($updateSession)
            $this->putSession($key, $value);

        return $this;
    }

//    protected function loadProperties()
//    {
//        $params = $this->getParams();
//
//        if ($localModel = $this->getLocal($params)) {
//
//            $this->setModel($localModel);
//            $this->setOrderType();
//
//            $this->workingHours()->initialize();
////            $this->initWorkingHours();
//
//            $this->area()->initialize();
////            $this->initArea();
//
////            if (!empty($this->permalink) AND setting('permalink') == '1')
////                $this->permalink = $this->permalink->getPermalink('location_id='.$this->getId());
//        }
//        else {
//            $this->clearLocal();
//        }
//    }

//    protected function initWorkingHours()
//    {
//        $this->workingHours()->initialize();
//        $this->workingHours()->setCurrentPeriod();
//    }

//    protected function initArea()
//    {
//        $this->area()->bindEvent('location.area.changed', function ($position) {
//            $this->setParam('area', $position, TRUE);
//        });

//        $this->area()->initialize();

//        $this->geocode()->setSearchQuery($this->searchQuery());

//        $userPosition = $this->findUserPosition();

//        $this->area()->setUserPosition($userPosition);

    // @todo: mode to area Class
//        if ($changed = $this->area()->nearestAreaChanged($nearestArea))
//            $this->setParam('area', $nearestArea, true);
//
//        $this->areaChanged = $changed;
//    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    protected function createModel()
    {
        $class = 'Admin\Models\Locations_model';
        if (!class_exists($class)) {
            throw new Exception("Missing location model {$class}");
        }

        $model = new $class;

        return $model;
    }

    public function setSearchMode($searchMode)
    {
        $this->searchMode = !in_array($searchMode, ['single', 'multiple']) ? 'single' : $searchMode;
    }

    public function isMultiSearchMode()
    {
        return $this->searchMode != 'single';
    }

    public function isInitialized()
    {
        return $this->isInitialized;
    }

    //
    //	BOOT METHODS
    //

    public function useLocation($locationId, $updateSession = FALSE)
    {
        if ($locationId instanceof Model) {
            $this->setModel($locationId);
            $locationId = $locationId->getKey();
        }

        $this->setParam('location_id', $locationId, $updateSession);

        return $this;
    }

    public function setOrderType($orderType = null)
    {
        if (is_null($orderType))
            $orderType = $this->getParam('order_type');

        if (is_numeric($orderType))
            $orderType = self::$orderTypes[$orderType];

        if (!is_string($orderType))
            $orderType = ($this->hasCollection() AND !$this->hasDelivery()) ? self::COLLECTION : self::DELIVERY;

        $this->orderType = $orderType;

//        $orderTypes = array_flip(self::$orderTypes);
//        $this->setParam('order_type', $orderTypes[$orderType]);
    }

    public function setDeliveryArea($area = [])
    {
        if (is_array($area) AND isset($area['boundary']) AND $area['boundary'] != 'outside') {
            $this->setParam('area', $area);

            $this->area()->initialize();
//            $this->loadProperties();
        }
    }

    public function searchRestaurant($searchQuery = null)
    {
        $userPosition = $this->area()->geocode()->geocodePosition($searchQuery);

        if ($userPosition->status != 'OK')
            return $userPosition;

//        dd($this->getParams(), $userPosition);
        if (!$nearestArea = $this->area()->setUserPosition($userPosition)->findNearestArea())
            return $userPosition;

        $userPosition->boundary = $nearestArea->positionBoundary;

        if ($userPosition->boundary != 'outside') {
            $this->setParam('location_id', $nearestArea->location_id, TRUE)
                 ->setParam('area_id', $nearestArea->area_id, TRUE)
                 ->setParam('userPosition', $userPosition, TRUE)
                 ->reload();
        }

//        $this->updateSessionData([
//            'location_id' => $nearestArea->location_id,
//            'geocode'     => $userPosition,
//            'area'        => $nearestArea,
//        ]);

//        $this->initialize();

//        return (array)$nearestArea;

        return $userPosition;
    }

    //
    //	HELPER METHODS
    //

    public function getLocal($localInfo)
    {
        $locationId = isset($localInfo['location_id']) ? $localInfo['location_id'] : null;

        if ($model = $this->getModel() AND $model->getKey() == $locationId)
            return $model;

        $location = null;

        $query = $this->createModel();

        if (is_numeric($locationId)) {
            $location = $query->find($locationId);
        }
        else if (is_string($locationId)) {
            $location = $query->findSlug($locationId);
        }

        if (!$location)
            $location = $query->find($this->config['location_id']);

        return $location;
    }

    public function currentTime()
    {
        return time();
    }

    public function getId()
    {
        return $this->location_id;
    }

    public function getName()
    {
        return $this->location_name;
    }

    public function getEmail()
    {
        return strtolower($this->location_email);
    }

    public function getTelephone()
    {
        return $this->location_telephone;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getSlug($suffix = 'menus')
    {
        if ($this->searchMode == 'single')
            return $suffix;

        return $this->permalink_slug.'/'.$suffix;
    }

    public function getAddress($useLineBreaks = TRUE)
    {
        if (!$model = $this->getModel())
            return null;

        $this->ci()->load->helper('country');
        $address = $model->processAddress();

        return format_address($address, $useLineBreaks);
    }

    public function getCity()
    {
        return $this->location_city;
    }

    public function getState()
    {
        return $this->location_state;
    }

    public function getImage()
    {
        return $this->location_thumb;
    }

    public function getGallery()
    {
        return isset($this->options['gallery']) ? $this->options['gallery'] : [];
    }

    public function getReservationInterval()
    {
        return $this->reservation_time_interval;
    }

    public function deliveryTime()
    {
        return $this->delivery_time;
    }

    public function collectionTime()
    {
        return $this->collection_time;
    }

    public function lastOrderTime()
    {
        $timeFormat = $this->workingHours()->getTimeFormat();

        return (is_numeric($this->last_order_time) AND $this->last_order_time > 0)
            ? mdate($timeFormat, strtotime($this->closingTime()) - ($this->last_order_time * 60))
            : mdate($timeFormat, strtotime($this->closingTime()));
    }

    public function futureOrderDays($orderType = null)
    {
        $orderType = $orderType ?: static::DELIVERY;

        return isset($this->future_order_days[$orderType])
            ? $this->future_order_days[$orderType] : 5;
    }

    public function local()
    {
        return $this->getModel()->toArray();
    }

    public function getDefaultLocal()
    {
        $defaultLocal = $this->createModel()->find(setting('default_location_id'));

        return $defaultLocal ? $defaultLocal->toArray() : null;
    }

    public function hasGallery()
    {
        $gallery = $this->getGallery();

        return (isset($gallery['images']) AND count(array_filter($gallery['images'])));
    }

    public function hasDelivery()
    {
        return ($model = $this->getModel()) ? $model->offersOrderType(static::DELIVERY) : null;
    }

    public function hasCollection()
    {
        return ($model = $this->getModel()) ? $model->offersOrderType(static::COLLECTION) : null;
    }

    public function hasFutureOrder()
    {
        return ($model = $this->getModel()) ? $model->hasFutureOrder() : null;
    }

    public function hasOrderType($order_type = null)
    {
        return $this->getOrderTypeName($order_type) == self::DELIVERY ? $this->hasDelivery() : $this->hasCollection();
    }

    public function hasSearchQuery()
    {
//        return $this->getParam('search_query', null);
        return $this->area()->hasSearchQuery();
    }

    public function searchQuery($formatted = FALSE)
    {
        $userPosition = $this->area()->userPosition();

        $item = ($formatted) ? 'address' : 'query';

        return isset($userPosition->$item) ? $userPosition->$item : null;
    }

    public function searchQueryRequired()
    {
        return $this->ci()->config->item('location_order');
    }

    public function orderType()
    {
        $this->setOrderType($this->order_type);
        $orderTypes = array_flip(self::$orderTypes);

        return $orderTypes[$this->order_type];
    }

    public function getOrderType()
    {
        return $this->order_type;
    }

    public function getOrderTypeName($order_type)
    {
        if (is_numeric($order_type) AND isset(self::$orderTypes[$order_type]))
            $order_type = self::$orderTypes[$order_type];

        return $order_type;
    }

    public function checkOrderType($orderType = '')
    {
        $orderType = $this->getOrderTypeName($orderType);
        $orderType = strlen($orderType) ? $orderType : $this->getOrderType();

        $workingStatus = $this->workingStatus($orderType);

        $isOpen = !($workingStatus == static::CLOSED OR !$this->hasOrderType($orderType));
        $isOpening = (!$this->hasFutureOrder() AND $workingStatus == static::OPENING);

        return ($isOpen OR $isOpening);
    }

    public function payments($split = '')
    {
        return $this->getModel()->listPaymentGateways();
//        $local_payments = (!empty($this->local_options['payments'])) ? $this->local_options['payments'] : null;
//
//        $payments = [];
//        foreach (ComponentManager::instance()->listPaymentGateways() as $code => $payment) {
//            if (!empty($local_payments) AND !in_array($code, $local_payments)) continue;
//
//            $settings = $this->Extensions_model->getSettings($code);
//            $payments[$code] = array_merge($payment, [
//                'name'        => isset($payment['name']) ? $this->lang->line($payment['name']) : '',
//                'description' => isset($payment['description']) ? $this->lang->line($payment['description']) : '',
//                'priority'    => !empty($settings['priority']) ? $settings['priority'] : '0',
//                'status'      => empty($settings['status']) ? '0' : '1',
//            ]);
//        }
//
//        sort_array($payments);
//
//        return ($payments AND $split !== '') ? implode(array_column($payments, 'name'), $split) : $payments;
    }

    //
    //	HOURS
    //

    /**
     * @note If you are looking to return hours use $workingHours->getHours() method instead
     * @return \Igniter\Libraries\Location\WorkingHours
     */
    public function workingHours()
    {
        return $this->workingHours;
    }

    public function isOpened()
    {
        return $this->workingHours()->isOpened();
    }

    public function isClosed()
    {
        return $this->workingHours()->isClosed();
    }

    public function openingTime($type = null)
    {
        return $this->workingHours()->openTime($type);
    }

    public function closingTime($type = null)
    {
        return $this->workingHours()->closeTime($type);
    }

    public function workingTime($type = 'opening', $hour = 'open', $format = TRUE)
    {
        return $this->workingHours()->getCurrentPeriod()->getTypeHour($type, $hour, $format);
    }

    public function workingStatus($type = null, $time = null)
    {
        return $this->workingHours()->getCurrentPeriod()->getTypeStatus($type, $time);
    }

    public function workingType($hourType = '')
    {
        $hours = [];
        $hourType = $hourType == '' ? static::OPENING : $hourType;
        if (isset($this->options['opening_hours']["{$hourType}_type"])) { // backward compatibility
            $hours = $this->options['opening_hours']["{$hourType}_type"];
        }
        else if (isset($this->options['hours'][$hourType])) {
            $hours = $this->options['hours'][$hourType];
        }

        return isset($hours['type']) ? $hours['type'] : null;
    }

    public function orderTimeRange()
    {
        if ($this->isClosed() OR !$this->checkOrderType()) return null;

        $orderType = $this->getOrderType();
        $days_in_advance = ($this->hasFutureOrder()) ? $this->futureOrderDays($orderType) : '0';

        $startDate = mdate("%d-%m-%Y", strtotime("-1 day", $this->currentTime()));
        $endDate = mdate("%d-%m-%Y", strtotime("+{$days_in_advance} day", $this->currentTime()));

        return [];

        return $this->workingHours()->setWorkingType($orderType)->getOrderSchedule($startDate, $endDate);
    }

    public function orderTimeInterval()
    {
        return ($this->orderType() == '1') ? $this->deliveryTime() : $this->collectionTime();
    }

    public function checkOrderTime($time, $type = self::DELIVERY)
    {
        $timeDate = mdate("%d-%m-%Y", strtotime($time));
        $workingSchedule = $this->workingHours()->getPeriod($timeDate);
        dd($workingSchedule);
        $status = $this->workingStatus($type, $time, $workingSchedule);

        return ($status === 'open' OR ($this->hasFutureOrder() AND $status !== 'closed'));
    }

    //
    //	DELIVERY & GEOCODE
    //

    /**
     * @return \Igniter\Libraries\Location\Area
     */
    public function area()
    {
        return $this->area;
    }

    /**
     * @return \Igniter\Libraries\Location\Geocode
     */
    public function geocode()
    {
        return $this->geocode;
    }

    public function getAreaId()
    {
        return $this->area()->getNearestAreaId();
    }

    public function deliveryAreas()
    {
        return $this->area()->getAreas();
    }

    public function deliveryCharge($cartTotal = 0)
    {
        return $this->area()->setCartTotal($cartTotal)->getChargeDeliveryAmount();
    }

    public function minimumOrder($cartTotal = 0)
    {
        return $this->area()->setCartTotal($cartTotal)->getChargeMinOrderTotal();
    }

    public function getDeliveryChargeSummary()
    {
        return $this->area()->getNearestAreaChargeSummary();
    }

    public function checkDistance($decimalPoint = 0)
    {
        $distance = $this->area()->calculateDistanceFromUserPosition();

        return round($distance, $decimalPoint);
    }

    public function checkDeliveryCoverage($searchQuery = null)
    {
        $userPosition = $this->area()->geocode()->geocodePosition($searchQuery);

        return $this->area()->setUserPosition($userPosition)->checkCoverage();
    }

    public function checkMinimumOrder($cartTotal)
    {
        return ($cartTotal >= $this->minimumOrder($cartTotal));
    }

    public function getLatLng($searchQuery = FALSE)
    {
        return $this->area()->geocode()->geocodePosition($searchQuery);
    }

    protected function subscribeEvents()
    {
        $this->area()->bindEvent('location.area.changed', function ($position) {
            $this->setParam('area', $position, TRUE);
        });
    }

    //
    // DEPRECATED METHODS
    //

    /**
     * @deprecated since v2.2 use Currency::addressFormat() method instead
     * @return array|mixed
     */
    public function formatAddress($address = [], $format = TRUE)
    {
        return $this->country->addressFormat($address, $format);
    }

    /**
     * @deprecated since v2.2 use Location::useLocation() method instead
     * @return array|mixed
     */
    public function setLocation($locationId, $updateSession = TRUE)
    {
        $this->useLocation($locationId, $updateSession);
    }

    /**
     * @deprecated since v2.2 use Area::checkChargeCondition() method instead
     *
     * @return array|mixed|null
     */
    public function deliveryCondition($sort_by = 'amounts', $cart_total = FALSE)
    {
        return $this->area()->setCartTotal($cart_total)->checkChargeCondition($sort_by);
    }

    /**
     * @deprecated since v2.2 use Area::findNearestArea() method instead
     *
     * @param null $currentPosition
     *
     * @return object|null
     */
    public function checkDeliveryArea($currentPosition = null)
    {
        return $this->area()->setUserPosition($currentPosition)->queryNearestArea();
    }

    /**
     * @deprecated since v2.2 use $location_areas_model->pointInVertices() method instead
     *
     * @param $point
     * @param array $vertices
     *
     * @return string
     */
    public function pointInPolygon($point, $vertices = [])
    {
        return $this->area()->getNearestArea()->pointInVertices($point);
    }

    /**
     * @deprecated since v2.2 use $location_areas_model->pointInCircle() method instead
     *
     * @param $point
     * @param array $circle
     *
     * @return string
     */
    public function pointInCircle($point, $circle = [])
    {
        return $this->area()->getNearestArea()->pointInCircle($point);
    }

//    public function getLocation($id)
//    {
//        if (!isset(self::$localModelCache[$id])) {
//            $this->load->model('Locations_model');
//            self::$localModelCache[$id] = $this->Locations_model->isEnabled()->find($id);
//        }
//
//        if (!count(self::$localModelCache[$id]))
//            return null;
//
//        return self::$localModelCache[$id]->toArray();
//    }

//    public function getLocalModelCache()
//    {
//        return collect(self::$localModelCache);
//    }

    public function clearLocal()
    {
        $this->isInitialized = FALSE;
//        $this->resetSession();
    }

    public function __get($key)
    {
        $model = $this->getModel();
        if ($model AND isset($model->{$key}))
            return $model->{$key};

        return $this->delegateFromCI($key);
    }
}

// END Location Class

/* End of file Location.php */
/* Location: ./system/libraries/Location.php */