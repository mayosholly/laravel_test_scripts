<?php 

namespace App\Http\Traits;

trait ApiResponseTrait
{
    /**
     * Generate a success response
     * 
     * @param mixed $data
     * @param string $message
     * @param int $status
     * @param array $meta
     * @return JsonResponse
     */
    public function successResponse($data = [], $message = 'Sucess',  $meta=[], $status= 200)
    {
       return response()->json([
        'success' => true,
        'data' => $data,
        'message' => $message,
        'meta' => $meta
       ], $status); 
    }

      /**
     * Generate a error response
     * 
     * @param mixed $data
     * @param string $message
     * @param int $status
     * @param array $meta
     * @return JsonResponse
     */
    public function errorResponse($data = [], $message = 'Error', $meta = [], $status= 400 )
    {
       return response()->json([
        'success' => false,
        'data' => $data,
        'message' => $message,
        'meta' => $meta
       ], $status); 
    }
}
