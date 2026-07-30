<?php

declare(strict_types=1);

namespace Square\Apis;

use Core\Request\Parameters\BodyParam;
use Core\Request\Parameters\FormParam;
use Core\Request\Parameters\HeaderParam;
use Core\Request\Parameters\QueryParam;
use Core\Request\Parameters\TemplateParam;
use CoreInterfaces\Core\Request\RequestMethod;
use Square\Http\ApiResponse;
use Square\Models\AcceptDisputeResponse;
use Square\Models\CreateDisputeEvidenceFileRequest;
use Square\Models\CreateDisputeEvidenceFileResponse;
use Square\Models\CreateDisputeEvidenceTextRequest;
use Square\Models\CreateDisputeEvidenceTextResponse;
use Square\Models\DeleteDisputeEvidenceResponse;
use Square\Models\ListDisputeEvidenceResponse;
use Square\Models\ListDisputesResponse;
use Square\Models\RetrieveDisputeEvidenceResponse;
use Square\Models\RetrieveDisputeResponse;
use Square\Models\SubmitEvidenceResponse;
use Square\Utils\FileWrapper;

class DisputesApi extends BaseApi
{
    /**
     * Returns a list of disputes associated with a particular account.
     *
     * @param string|null $cursor A pagination cursor returned by a previous call to this endpoint.
     *        Provide this cursor to retrieve the next set of results for the original query.
     *        For more information, see [Pagination](https://developer.squareup.com/docs/build-
     *        basics/common-api-patterns/pagination).
     * @param string|null $states The dispute states used to filter the result. If not specified,
     *        the endpoint returns all disputes.
     * @param string|null $locationId The ID of the location for which to return a list of disputes.
     *        If not specified, the endpoint returns disputes associated with all locations.
     *
     * @return ApiResponse Response from the API call
     */
    public function listDisputes(
        ?string $cursor = null,
        ?string $states = null,
        ?string $locationId = null
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/disputes')
            ->auth('global')
            ->parameters(
                QueryParam::init('cursor', $cursor),
                QueryParam::init('states', $states),
                QueryParam::init('location_id', $locationId)
            );

        $_resHandler = $this->responseHandler()->type(ListDisputesResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Returns details about a specific dispute.
     *
     * @param string $disputeId The ID of the dispute you want more details about.
     *
     * @return ApiResponse Response from the API call
     */
    public function retrieveDispute(string $disputeId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/disputes/{dispute_id}')
            ->auth('global')
            ->parameters(TemplateParam::init('dispute_id', $disputeId));

        $_resHandler = $this->responseHandler()->type(RetrieveDisputeResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Accepts the loss on a dispute. Square returns the disputed amount to the cardholder and
     * updates the dispute state to ACCEPTED.
     *
     * Square debits the disputed amount from the seller’s Square account. If the Square account
     * does not have sufficient funds, Square debits the associated bank account.
     *
     * @param string $disputeId The ID of the dispute you want to accept.
     *
     * @return ApiResponse Response from the API call
     */
    public function acceptDispute(string $disputeId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/disputes/{dispute_id}/accept')
            ->auth('global')
            ->parameters(TemplateParam::init('dispute_id', $disputeId));

        $_resHandler = $this->responseHandler()->type(AcceptDisputeResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Returns a list of evidence associated with a dispute.
     *
     * @param string $disputeId The ID of the dispute.
     * @param string|null $cursor A pagination cursor returned by a previous call to this endpoint.
     *        Provide this cursor to retrieve the next set of results for the original query.
     *        For more information, see [Pagination](https://developer.squareup.com/docs/build-
     *        basics/common-api-patterns/pagination).
     *
     * @return ApiResponse Response from the API call
     */
    public function listDisputeEvidence(string $disputeId, ?string $cursor = null): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/disputes/{dispute_id}/evidence')
            ->auth('global')
            ->parameters(TemplateParam::init('dispute_id', $disputeId), QueryParam::init('cursor', $cursor));

        $_resHandler = $this->responseHandler()->type(ListDisputeEvidenceResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Uploads a file to use as evidence in a dispute challenge. The endpoint accepts HTTP
     * multipart/form-data file uploads in HEIC, HEIF, JPEG, PDF, PNG, and TIFF formats.
     *
     * @param string $disputeId The ID of the dispute for which you want to upload evidence.
     * @param CreateDisputeEvidenceFileRequest|null $request Defines the parameters for a
     *        `CreateDisputeEvidenceFile` request.
     * @param FileWrapper|null $imageFile
     *
     * @return ApiResponse Response from the API call
     */
    public function createDisputeEvidenceFile(
        string $disputeId,
        ?CreateDisputeEvidenceFileRequest $request = null,
        ?FileWrapper $imageFile = null
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/disputes/{dispute_id}/evidence-files')
            ->auth('global')
            ->parameters(
                TemplateParam::init('dispute_id', $disputeId),
                FormParam::init('request', $request)
                    ->encodingHeader('Content-Type', 'application/json; charset=utf-8'),
                FormParam::init('image_file', $imageFile)->encodingHeader('Content-Type', 'image/jpeg')
            );

        $_resHandler = $this->responseHandler()->type(CreateDisputeEvidenceFileResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Uploads text to use as evidence for a dispute challenge.
     *
     * @param string $disputeId The ID of the dispute for which you want to upload evidence.
     * @param CreateDisputeEvidenceTextRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function createDisputeEvidenceText(string $disputeId, CreateDisputeEvidenceTextRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/disputes/{dispute_id}/evidence-text')
            ->auth('global')
            ->parameters(
                TemplateParam::init('dispute_id', $disputeId),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()->type(CreateDisputeEvidenceTextResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Removes specified evidence from a dispute.
     * Square does not send the bank any evidence that is removed.
     *
     * @param string $disputeId The ID of the dispute from which you want to remove evidence.
     * @param string $evidenceId The ID of the evidence you want to remove.
     *
     * @return ApiResponse Response from the API call
     */
    public function deleteDisputeEvidence(string $disputeId, string $evidenceId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(
            RequestMethod::DELETE,
            '/v2/disputes/{dispute_id}/evidence/{evidence_id}'
        )
            ->auth('global')
            ->parameters(
                TemplateParam::init('dispute_id', $disputeId),
                TemplateParam::init('evidence_id', $evidenceId)
            );

        $_resHandler = $this->responseHandler()->type(DeleteDisputeEvidenceResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Returns the metadata for the evidence specified in the request URL path.
     *
     * You must maintain a copy of any evidence uploaded if you want to reference it later. Evidence cannot
     * be downloaded after you upload it.
     *
     * @param string $disputeId The ID of the dispute from which you want to retrieve evidence
     *        metadata.
     * @param string $evidenceId The ID of the evidence to retrieve.
     *
     * @return ApiResponse Response from the API call
     */
    public function retrieveDisputeEvidence(string $disputeId, string $evidenceId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(
            RequestMethod::GET,
            '/v2/disputes/{dispute_id}/evidence/{evidence_id}'
        )
            ->auth('global')
            ->parameters(
                TemplateParam::init('dispute_id', $disputeId),
                TemplateParam::init('evidence_id', $evidenceId)
            );

        $_resHandler = $this->responseHandler()->type(RetrieveDisputeEvidenceResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Submits evidence to the cardholder's bank.
     *
     * The evidence submitted by this endpoint includes evidence uploaded
     * using the [CreateDisputeEvidenceFile]($e/Disputes/CreateDisputeEvidenceFile) and
     * [CreateDisputeEvidenceText]($e/Disputes/CreateDisputeEvidenceText) endpoints and
     * evidence automatically provided by Square, when available. Evidence cannot be removed from
     * a dispute after submission.
     *
     * @param string $disputeId The ID of the dispute for which you want to submit evidence.
     *
     * @return ApiResponse Response from the API call
     */
    public function submitEvidence(string $disputeId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/disputes/{dispute_id}/submit-evidence')
            ->auth('global')
            ->parameters(TemplateParam::init('dispute_id', $disputeId));

        $_resHandler = $this->responseHandler()->type(SubmitEvidenceResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }
}
