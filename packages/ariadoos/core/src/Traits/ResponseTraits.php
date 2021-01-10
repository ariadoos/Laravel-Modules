<?php
/**
 * Created by PhpStorm.
 * User: @ariadoos - Nikesh Bdr. Adhikari
 * Date: 1/10/2021
 * Time: 9:12 PM
 */

namespace Modules\Core\Traits;

use Modules\Core\Constants\StatusCodes;

trait ResponseTraits
{
    /**
     * Json success response
     * @param null $data
     * @param null $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendSuccessResponse($data = NULL, $message = NULL)
    {
        $response = [
          'success' => true,
          'message' => $message,
          'data'    => $data,
          'code'    => StatusCodes::HTTP_OK,
        ];

        return response()->json($response, StatusCodes::HTTP_OK);
    }

    /**
     * Json error response
     * @param null $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendErrorResponse($message = NULL, $code = StatusCodes::HTTP_INTERNAL_SERVER_ERROR)
    {
        $response = [
            'success' => false,
            'message' => $message,
            'code'  => $code
        ];

        return response()->json($response, $code);
    }

    /**
     * @param null $data
     * @param null $message
     * @return array
     */
    public function successResponse($data = NULL, $message = NULL)
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data'    => $data,
            'code'    => StatusCodes::HTTP_OK,
        ];

        return $response;
    }

    /**
     * @param null $message
     * @param int $code
     * @return array
     */
    public function errorResponse($message = NULL, $code = StatusCodes::HTTP_INTERNAL_SERVER_ERROR)
    {
        $response = [
            'success' => false,
            'message' => $message,
            'code'  => $code
        ];

        return $response;
    }
}