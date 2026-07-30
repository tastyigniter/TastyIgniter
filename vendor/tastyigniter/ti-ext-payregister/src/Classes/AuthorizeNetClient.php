<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Classes;

use Igniter\Flame\Exception\ApplicationException;
use net\authorize\api\constants\ANetEnvironment;
use net\authorize\api\contract\v1\ANetApiResponseType;
use net\authorize\api\contract\v1\CreateTransactionResponse;
use net\authorize\api\contract\v1\CreditCardType;
use net\authorize\api\contract\v1\MerchantAuthenticationType;
use net\authorize\api\contract\v1\OpaqueDataType;
use net\authorize\api\contract\v1\PaymentType;
use net\authorize\api\contract\v1\TransactionRequestType;
use net\authorize\api\contract\v1\TransactionResponseType;

class AuthorizeNetClient
{
    protected bool $sandbox = true;

    protected ?MerchantAuthenticationType $authentication = null;

    public function setTestMode(bool $sandbox = true): static
    {
        $this->sandbox = $sandbox;

        return $this;
    }

    public function authentication()
    {
        if ($this->authentication instanceof MerchantAuthenticationType) {
            return $this->authentication;
        }

        return $this->authentication = new MerchantAuthenticationType;
    }

    public function createTransactionRequest(array $fields = []): AuthorizeNetTransactionRequest
    {
        $paymentOne = new PaymentType;
        $transactionRequestType = new TransactionRequestType;

        if (array_has($fields, ['opaqueDataDescriptor', 'opaqueDataValue'])) {
            $opaqueData = new OpaqueDataType;
            $opaqueData->setDataDescriptor($fields['opaqueDataDescriptor']);
            $opaqueData->setDataValue($fields['opaqueDataValue']);
            $paymentOne->setOpaqueData($opaqueData);
        }

        if (array_has($fields, ['cardNumber', 'expirationDate'])) {
            $creditCard = new CreditCardType;
            $creditCard->setCardNumber($fields['cardNumber']);
            $creditCard->setExpirationDate($fields['expirationDate']);
            $paymentOne = new PaymentType;
            $paymentOne->setCreditCard($creditCard);
        }

        $transactionRequestType->setPayment($paymentOne);
        $transactionRequestType->setTransactionType($fields['transactionType'] ?? '');
        if ($amount = array_get($fields, 'amount')) {
            $transactionRequestType->setAmount($amount);
        }

        if ($transactionId = array_get($fields, 'transactionId')) {
            $transactionRequestType->setRefTransId($transactionId);
        }

        $request = new AuthorizeNetTransactionRequest;
        $request->setMerchantAuthentication($this->authentication());

        $request->setRefId($fields['refId'] ?? '');
        $request->setTransactionRequest($transactionRequestType);

        return $request;
    }

    public function createTransaction(AuthorizeNetTransactionRequest $request): TransactionResponseType
    {
        /** @var null|CreateTransactionResponse $response */
        $response = $request->controller()->executeWithApiResponse(
            $this->sandbox ? ANetEnvironment::SANDBOX : ANetEnvironment::PRODUCTION,
        );

        throw_if(is_null($response), new ApplicationException('No response returned'));

        $transactionResponse = $response->getTransactionResponse();

        if ($response->getMessages()->getResultCode() !== 'Ok') {
            throw new ApplicationException($this->getErrorMessageFromResponse($response, $transactionResponse));
        }

        if (is_null($transactionResponse->getMessages())) {
            throw new ApplicationException('Transaction failed with empty message');
        }

        return $transactionResponse;
    }

    protected function getErrorMessageFromResponse(?ANetApiResponseType $response, ?TransactionResponseType $transactionResponse): string
    {
        $message = "Transaction Failed \n Error Code : %s \n Error Message : %s \n";
        if ($transactionResponse != null && $transactionResponse->getErrors() != null) {
            return sprintf($message,
                $transactionResponse->getErrors()[0]->getErrorCode(),
                $transactionResponse->getErrors()[0]->getErrorText(),
            );
        }

        return sprintf($message,
            $response->getMessages()->getMessage()[0]->getCode(),
            $response->getMessages()->getMessage()[0]->getText(),
        );
    }
}
