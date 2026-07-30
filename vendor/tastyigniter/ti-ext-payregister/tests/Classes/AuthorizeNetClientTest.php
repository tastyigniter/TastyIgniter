<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Tests\Classes;

use Igniter\Flame\Exception\ApplicationException;
use Igniter\PayRegister\Classes\AuthorizeNetClient;
use Igniter\PayRegister\Classes\AuthorizeNetTransactionRequest;
use net\authorize\api\contract\v1\ANetApiResponseType;
use net\authorize\api\contract\v1\CreateTransactionRequest;
use net\authorize\api\contract\v1\MerchantAuthenticationType;
use net\authorize\api\contract\v1\MessagesType;
use net\authorize\api\contract\v1\TransactionResponseType;
use net\authorize\api\contract\v1\TransactionResponseType\ErrorsAType\ErrorAType;
use net\authorize\api\contract\v1\TransactionResponseType\MessagesAType\MessageAType;
use net\authorize\api\controller\CreateTransactionController;

beforeEach(function(): void {
    $this->authorizeNetClient = new AuthorizeNetClient;
});

it('creates authentication instance', function(): void {
    $this->authorizeNetClient->authentication();
    $result = $this->authorizeNetClient->authentication();

    expect($result)->toBeInstanceOf(MerchantAuthenticationType::class);
});

it('creates transaction request instance', function(): void {
    $result = $this->authorizeNetClient->createTransactionRequest([
        'opaqueDataDescriptor' => 'descriptor',
        'opaqueDataValue' => 'value',
        'transactionType' => 'type',
        'amount' => 100,
    ]);

    expect($result)->toBeInstanceOf(CreateTransactionRequest::class)
        ->and($result->controller())->toBeInstanceOf(CreateTransactionController::class)
        ->and($result->getMerchantAuthentication())->toBeInstanceOf(MerchantAuthenticationType::class);
});

it('throws exception if no response returned from create transaction', function(): void {
    $request = mock(AuthorizeNetTransactionRequest::class);
    $request->shouldReceive('getMerchantAuthentication')->andReturn(mock(MerchantAuthenticationType::class));
    $request->shouldReceive('setClientId')->andReturnSelf();
    $request->shouldReceive('jsonSerialize')->andReturn([]);
    $controller = mock(CreateTransactionController::class, [$request]);
    $controller->shouldReceive('executeWithApiResponse')->andReturnNull();
    $request->shouldReceive('controller')->andReturn($controller);

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('No response returned');

    $this->authorizeNetClient->createTransaction($request);
});

it('throws exception if response result code is not Ok', function(): void {
    $request = mock(AuthorizeNetTransactionRequest::class);
    $request->shouldReceive('getMerchantAuthentication')->andReturn(mock(MerchantAuthenticationType::class));
    $request->shouldReceive('setClientId')->andReturnSelf();
    $request->shouldReceive('jsonSerialize')->andReturn([]);
    $response = mock(ANetApiResponseType::class);
    $response->shouldReceive('getMessages->getResultCode')->andReturn('Error');
    $transactionResponse = mock(TransactionResponseType::class);
    $errorType = mock(ErrorAType::class);
    $errorType->shouldReceive('getErrorCode')->andReturn('E00001');
    $errorType->shouldReceive('getErrorText')->andReturn('Failed to create transaction');
    $transactionResponse->shouldReceive('getErrors')->andReturn([$errorType]);
    $response->shouldReceive('getTransactionResponse')->andReturn($transactionResponse);
    $controller = mock(CreateTransactionController::class, [$request]);
    $controller->shouldReceive('executeWithApiResponse')->andReturn($response);
    $request->shouldReceive('controller')->andReturn($controller);

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessageMatches('/Error Code : E00001/');
    $this->expectExceptionMessageMatches('/Error Message : Failed to create transaction/');

    $this->authorizeNetClient->createTransaction($request);
});

it('throws exception if response result code is not Ok and has message', function(): void {
    $request = mock(AuthorizeNetTransactionRequest::class);
    $request->shouldReceive('getMerchantAuthentication')->andReturn(mock(MerchantAuthenticationType::class));
    $request->shouldReceive('setClientId')->andReturnSelf();
    $request->shouldReceive('jsonSerialize')->andReturn([]);
    $response = mock(ANetApiResponseType::class);
    $transactionResponse = mock(TransactionResponseType::class);
    $messagesType = mock(MessagesType::class);
    $messageAType = mock(MessageAType::class);
    $messageAType->shouldReceive('getCode')->andReturn('E00001');
    $messageAType->shouldReceive('getText')->andReturn('Failed to create transaction');
    $messagesType->shouldReceive('getMessage')->andReturn([$messageAType]);
    $messagesType->shouldReceive('getResultCode')->andReturn('Error');
    $transactionResponse->shouldReceive('getErrors')->andReturnNull();
    $response->shouldReceive('getMessages')->andReturn($messagesType);
    $response->shouldReceive('getTransactionResponse')->andReturn($transactionResponse);
    $controller = mock(CreateTransactionController::class, [$request]);
    $controller->shouldReceive('executeWithApiResponse')->andReturn($response);
    $request->shouldReceive('controller')->andReturn($controller);

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessageMatches('/Error Code : E00001/');
    $this->expectExceptionMessageMatches('/Error Message : Failed to create transaction/');

    $this->authorizeNetClient->createTransaction($request);
});

it('throws exception if response result code is Ok and empty message', function(): void {
    $request = mock(AuthorizeNetTransactionRequest::class);
    $request->shouldReceive('getMerchantAuthentication')->andReturn(mock(MerchantAuthenticationType::class));
    $request->shouldReceive('setClientId')->andReturnSelf();
    $request->shouldReceive('jsonSerialize')->andReturn([]);
    $response = mock(ANetApiResponseType::class);
    $response->shouldReceive('getMessages->getResultCode')->andReturn('Ok');
    $transactionResponse = mock(TransactionResponseType::class);
    $transactionResponse->shouldReceive('getMessages')->andReturnNull();
    $response->shouldReceive('getTransactionResponse')->andReturn($transactionResponse);
    $controller = mock(CreateTransactionController::class, [$request]);
    $controller->shouldReceive('executeWithApiResponse')->andReturn($response);
    $request->shouldReceive('controller')->andReturn($controller);

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('Transaction failed with empty message');

    $this->authorizeNetClient->createTransaction($request);
});

it('returns transaction response if successful', function(): void {
    $response = mock(ANetApiResponseType::class);
    $response->shouldReceive('getMessages->getResultCode')->andReturn('Ok');
    $request = mock(AuthorizeNetTransactionRequest::class);
    $request->shouldReceive('getMerchantAuthentication')->andReturn(mock(MerchantAuthenticationType::class));
    $request->shouldReceive('setClientId')->andReturnSelf();
    $request->shouldReceive('jsonSerialize')->andReturn([$response]);
    $transactionResponse = mock(TransactionResponseType::class);
    $transactionResponse->shouldReceive('getMessages')->andReturn(mock(MessagesType::class));
    $response->shouldReceive('getTransactionResponse')->andReturn($transactionResponse);
    $controller = mock(CreateTransactionController::class);
    $controller->shouldReceive('executeWithApiResponse')->andReturn($response);
    $request->shouldReceive('controller')->andReturn($controller);

    $result = $this->authorizeNetClient->createTransaction($request);

    expect($result)->toBe($transactionResponse);
});
