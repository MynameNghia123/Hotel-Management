<?php

namespace App\Http\Traits;

trait JsonResponseTrait
{
    /**
     * Return a success JSON response
     * 
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($data = null, $message = 'Thành công', $statusCode = 200)
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Return an error JSON response
     * 
     * @param string $message
     * @param int $statusCode
     * @param mixed $errors
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($message = 'Có lỗi xảy ra', $statusCode = 500, $errors = null)
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Return a paginated JSON response
     * 
     * @param mixed $data
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function paginatedResponse($data, $message = 'Dữ liệu được lấy thành công')
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data->items(),
            'pagination' => [
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'from' => $data->firstItem(),
                'to' => $data->lastItem(),
            ]
        ], 200);
    }

    /**
     * Return a created resource JSON response (201 status)
     * 
     * @param mixed $data
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createdResponse($data = null, $message = 'Tài nguyên được tạo thành công')
    {
        return $this->successResponse($data, $message, 201);
    }

    /**
     * Return a not found JSON response (404 status)
     * 
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function notFoundResponse($message = 'Không tìm thấy tài nguyên')
    {
        return $this->errorResponse($message, 404);
    }

    /**
     * Return an unauthorized JSON response (401 status)
     * 
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function unauthorizedResponse($message = 'Không được phép truy cập')
    {
        return $this->errorResponse($message, 401);
    }

    /**
     * Return a forbidden JSON response (403 status)
     * 
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function forbiddenResponse($message = 'Truy cập bị cấm')
    {
        return $this->errorResponse($message, 403);
    }

    /**
     * Return a validation error JSON response (422 status)
     * 
     * @param array $errors
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function validationErrorResponse($errors, $message = 'Dữ liệu không hợp lệ')
    {
        return $this->errorResponse($message, 422, $errors);
    }

    /**
     * Return a server error JSON response (500 status)
     * 
     * @param string $message
     * @param mixed $errors
     * @return \Illuminate\Http\JsonResponse
     */
    protected function serverErrorResponse($message = 'Lỗi máy chủ nội bộ', $errors = null)
    {
        return $this->errorResponse($message, 500, $errors);
    }
}
