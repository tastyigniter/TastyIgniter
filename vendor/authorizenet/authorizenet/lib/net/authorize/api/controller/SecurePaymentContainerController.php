<?php
namespace net\authorize\api\controller;

use net\authorize\api\contract\v1\AnetApiRequestType;
use net\authorize\api\controller\base\ApiOperationBase;

class SecurePaymentContainerController extends ApiOperationBase
{
    public function __construct(AnetApiRequestType $request)
    {
        $responseType = 'net\authorize\api\contract\v1\SecurePaymentContainerResponse';
        parent::__construct($request, $responseType);
    }

    protected function validateRequest()
    {
        //validate required fields of $this->apiRequest->

        //validate non-required fields of $this->apiRequest->
    }
}