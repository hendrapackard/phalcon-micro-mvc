<?php

use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    public function sendResponse($data, $code, $message)
    {
        // Create a response
        $response = new Response();

        // Change the HTTP status
        $response->setStatusCode($code);

        if ($data == [] || $data != null || $data != ''){

            $response->setJsonContent(
                [
                    'data'   => $data,
                    'code' => $code,
                    'message' => $message,
                ]);

        } else {

            $response->setJsonContent(
                [
                    'code' => $code,
                    'message' => $message,
                ]);

        }

        return $response;
    }

    public function sendError($data)
    {
        // Create a response
        $response = new Response();

        $errors = [];

        foreach ($data->getMessages() as $message) {

            // jika required
            if ($message->getType() == 'PresenceOf'){

                // Change the HTTP status
                $response->setStatusCode(400);

                // jika unique
            } elseif ($message->getType() == 'Uniqueness'){

                // Change the HTTP status
                $response->setStatusCode(409);
            }

            $errors[$message->getField()] = [$message->getMessage()];
        }

        $response->setJsonContent(
            [
                'code' => $response->getStatusCode(),
                'message' => 'validation error',
                'data' => $errors,
            ]);

        return $response;
    }
}
