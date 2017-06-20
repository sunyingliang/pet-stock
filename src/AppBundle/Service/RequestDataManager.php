<?php

namespace AppBundle\Service;

class RequestDataManager
{

    // Fetch data send by request
    public function getData(&$request)
    {
        $data = [];

        $queryParams   = $request->query->all();

        $requestParams = $request->request->all();
        
        $data = array_merge($queryParams, $requestParams);
        
        if ($request->headers->get('Content-Type') == 'application/json') {
            $content = $request->getContent();
        
            if (!empty($content)) {
                $jsonParams = \json_decode($content, true);
                $data = array_merge($data, $jsonParams);
                //$data = $jsonParams;
            }
        }
        
        return $data;
    }

    // Validate mandatory fields in request data
    public function required($data, $mandatory = null, $strict = false)
    {
        $retValue = [
            'valid'   => false,
            'message' => ''
        ];

        if (is_string($data)) {
            if (defined($data)) {
                $data = constant($data);
            } else {
                $retValue['message'] = 'The given data does not exist';
                return $retValue;
            }
        }

        $required = [];

        if (!isset($data) || !is_array($data)) {
            $retValue['message'] = 'The given data must be a valid array';
        }

        foreach ($mandatory as $item) {
            if (!isset($data[$item])) {
                $required[] = $item;
            } else if ($strict && empty($data[$item])) {
                $required[] = $item;
            }
        }

        if (empty($required)) {
            return ['valid' => true];
        } else {
            $retValue['message'] = 'Required parameters: ' . implode(', ', $required);
        }

        return $retValue;
    } 
}
