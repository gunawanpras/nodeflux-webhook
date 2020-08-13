<?php
namespace Nodeflux\Config;

use \Nodeflux\Config\Constant as CONSTANT;
use \Phalcon\Di;

class Response
{
    // public static $responseInstance;

    public function initialize() {
        // static::$responseInstance = \Phalcon\Di::getDefault()->getShared('response');
    }
    
    public static function __success($status = CONSTANT::DEFAULT, $defaultInfo = CONSTANT::SUCCESS, $data = [], $description = '') {        
        $response = \Phalcon\Di::getDefault()->getShared('response');
        $response->setStatusCode($status);
        $response->setJsonContent([
            'code' => $defaultInfo['code'],
            'data' => $data,
            'description' => ! empty($description) ? $description : $defaultInfo['description'],
        ]);
        $response->setHeader('ContentLength', strlen($response->getContent()));
        $response->send();
    }

    public static function __error($status = CONSTANT::GENERAL_ERROR, $code = 3000, $title = '', $description = '') {
        $response = \Phalcon\Di::getDefault()->getShared('response');
        $response->setStatusCode($status);
        $response->setJsonContent([
            'code' => $code,
            'error' => $title,
            'description' => $description,
        ]);
        $response->setHeader('ContentLength', strlen($response->getContent()));
        $response->send();
    }
}
