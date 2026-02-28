<?php

namespace App\Traits;

trait JsonResponder
{
    /**
     * Send a JSON response
     *
     * @param array $data
     * @param int $status
     * @return void
     */
    protected function jsonResponse($data, $status = 200)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
        exit;
    }

    /**
     * Send a success response
     *
     * @param array $data
     * @param string $message
     * @param int $status
     * @return void
     */
    protected function success($data = [], $message = 'Success', $status = 200)
    {
        $this->jsonResponse([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    /**
     * Send an error response
     *
     * @param string $message
     * @param int $status
     * @param array $errors
     * @return void
     */
    protected function error($message = 'Error', $status = 400, $errors = [])
    {
        $this->jsonResponse([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], $status);
    }
}
