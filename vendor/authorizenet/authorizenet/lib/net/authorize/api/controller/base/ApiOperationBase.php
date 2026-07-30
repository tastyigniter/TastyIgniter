<?php
namespace net\authorize\api\controller\base;

use InvalidArgumentException;
// use JMS\Serializer\SerializerBuilder;
// use JMS\Serializer\handler\HandlerRegistryInterface;
// use GoetasWebservices\Xsd\XsdToPhpRuntime\Jms\Handler\BaseTypesHandler;
// use GoetasWebservices\Xsd\XsdToPhpRuntime\Jms\Handler\XmlSchemaDateHandler;

use \net\authorize\util\HttpClient;
use \net\authorize\util\Helpers;
use \net\authorize\util\LogFactory as LogFactory;


abstract class ApiOperationBase implements IApiOperation
{
    /**
     * @var \net\authorize\api\contract\v1\AnetApiRequestType
     */
    private $apiRequest = null;

    /**
     * @var \net\authorize\api\contract\v1\AnetApiResponseType
     */
    private $apiResponse = null;

    /**
     * @var String
     */
    private $apiResponseType = '';

    /**
     * @var \JMS\Serializer\Serializer;
     */
    public $serializer = null;

    /**
     * @var \net\authorize\util\HttpClient;
     */
    public $httpClient = null;
    private $logger = null;
    /**
     * Constructor.
     *
     * @param \net\authorize\api\contract\v1\AnetApiRequestType $request ApiRequest to send
     * @param string $responseType response type expected
     * @throws InvalidArgumentException if invalid request
     */
    public function __construct(\net\authorize\api\contract\v1\AnetApiRequestType $request, $responseType)
    {
        $this->logger = LogFactory::getLog(get_class($this));

        if ( null == $request)
        {
            throw new InvalidArgumentException( "request cannot be null");
        }

        if ( null == $responseType || '' == $responseType)
        {
            throw new InvalidArgumentException( "responseType cannot be null or empty");
        }

        if ( null != $this->apiResponse)
        {
            throw new InvalidArgumentException( "response has to be null");
        }

        $this->apiRequest = $request;
        $this->validate();

        $this->apiResponseType = $responseType;
        $this->httpClient = new HttpClient;

/*        $serializerBuilder = SerializerBuilder::create();
        $serializerBuilder->addMetadataDir( __DIR__ . '/../../yml/v1', 'net\authorize\api\contract\v1');//..\..\yml\v1\ //'/../lib/net/authorize/api/yml/v1'
        $serializerBuilder->configureHandlers(
            function (HandlerRegistryInterface $h)

            use($serializerBuilder)
            {
                $serializerBuilder->addDefaultHandlers();
                $h->registerSubscribingHandler(new BaseTypesHandler()); // XMLSchema List handling
                $h->registerSubscribingHandler(new XmlSchemaDateHandler()); // XMLSchema date handling
            }
        );
        $this->serializer = $serializerBuilder->build();*/
    }

    /**
     * Retrieves response
     * @return \net\authorize\api\contract\v1\AnetApiResponseType
     */
    public function getApiResponse()
    {
        return $this->apiResponse;
    }

    /**
     * Sends request and retrieves response
     * @return \net\authorize\api\contract\v1\AnetApiResponseType
     */
    public function executeWithApiResponse($endPoint = \net\authorize\api\constants\ANetEnvironment::CUSTOM)
    {
        $this->execute($endPoint);
        return $this->apiResponse;
    }

    public function execute($endPoint = \net\authorize\api\constants\ANetEnvironment::CUSTOM)
    {
        $this->beforeExecute();

    $this->apiRequest->setClientId("sdk-php-" . \net\authorize\api\constants\ANetEnvironment::VERSION);

        $this->logger->info("Request Creation Begin");
        $this->logger->debug($this->apiRequest);
        // $xmlRequest = $this->serializer->serialize($this->apiRequest, 'xml');
        //$requestArray = [lcfirst((new \ReflectionClass($this->apiRequest))->getShortName()) => $this->apiRequest];
        
        // $requestRoot = (new \net\authorize\api\contract\v1\Mapper)->getXmlName((new \ReflectionClass($this->apiRequest))->getName());
        // $requestRoot = (\net\authorize\api\contract\v1\Mapper::Instance())->getXmlName((new \ReflectionClass($this->apiRequest))->getName());
        $mapper = \net\authorize\util\Mapper::Instance();
        $requestRoot = $mapper->getXmlName((new \ReflectionClass($this->apiRequest))->getName());

        $requestArray = [$requestRoot => $this->apiRequest];
    
        $this->logger->info("Request  Creation End");

        $this->httpClient->setPostUrl( $endPoint);
        /*$xmlResponse = $this->httpClient->_sendRequest($xmlRequest);
        if ( null == $xmlResponse)
        {
            throw new \Exception( "Error getting valid response from api. Check log file for error details");
        }
        $this->logger->info("Response De-Serialization Begin");
        $this->apiResponse = $this->serializer->deserialize( $xmlResponse, $this->apiResponseType , 'xml');
        $this->logger->info("Response De-Serialization End");*/

        $jsonResponse = $this->httpClient->_sendRequest(json_encode($requestArray));
        if($jsonResponse != null){
            //decoding json and removing bom
            $possibleBOM = substr($jsonResponse, 0, 3);
            $utfBOM = pack("CCC", 0xef, 0xbb, 0xbf);
            
            if (0 === strncmp($possibleBOM, $utfBOM, 3)) {
                $response = json_decode( substr($jsonResponse,3), true);
            }
            else {
                $response = json_decode($jsonResponse, true);
            }
            $this->apiResponse = new $this->apiResponseType();
            $this->apiResponse->set($response);  
        }
        else {
            $this->logger->error("Error getting response from API");
            $this->apiResponse = null;
        }
        
        $this->afterExecute();
    }

    private function validate()
    {
        $merchantAuthentication = $this->apiRequest->getMerchantAuthentication();
        if ( null == $merchantAuthentication)
        {
            throw new \InvalidArgumentException( "MerchantAuthentication cannot be null");
        }

        $this->validateRequest();
    }

    protected function beforeExecute() {}
    protected function afterExecute()  {}
    protected function validateRequest() {} //need to make this abstract

    protected function now()
    {
        return date( DATE_RFC2822);
    }
}
