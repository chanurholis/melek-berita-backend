<?php

if (!function_exists('isEmpty')) {
    function isEmpty($value)
    {
        if ($value === null || $value === [] || $value === '') {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('customResponse')) {
    function customResponse($isError, $statusCode, $message, $data = [])
    {
        return response()->json([
            'isError' => $isError,
            'statusCode' => $statusCode,
            'message' => $message,
            'data' => $data
        ]);
    }
}

if (!function_exists('xmlToJson')) {
    function xmlToJson($dataSource)
    {
        $xmlString = file_get_contents($dataSource);
        $xmlObject = simplexml_load_string($xmlString);
        $json = json_encode($xmlObject);
        $phpArray = json_decode($json, true);
        return $phpArray;
    }
}

if (!function_exists('curlGetContents')) {
    function curlGetContents($dataSource)
    {
        $curlSession = curl_init();
        curl_setopt($curlSession, CURLOPT_URL, $dataSource);
        curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
        return curl_exec($curlSession);
        curl_close($curlSession);
    }
}
