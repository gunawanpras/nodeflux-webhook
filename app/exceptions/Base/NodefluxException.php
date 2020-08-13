<?php

namespace App\Exceptions\Base;

use Nodeflux\Config\Constant as CONSTANT;

/**
 * Abstract class: NodefluxException
 * 
 */

abstract class NodefluxException extends \Exception implements NodefluxThrowable {
    /**
     * @var code
     */
    protected $code;
    
    /**
     * @var status
     */
    protected $status;
    
    /**
     * @var title
     */
    protected $title;
    
    /**
     * @var description
     */
    protected $description;

    private function preBuiltResponse(array $args) {        
        $info = CONSTANT::GENERAL_ERROR_DESC;        

        $error = array_shift( $args );
        $className = \get_called_class();

        if (is_string( $error )) {
            if (! preg_match('/^[A-Z]+_/', $error)) {
                $info['description'] = $error;
            } else {
                if ( CONSTANT::check($error) ) {
                    $info = constant("CONSTANT::$error");
                }
            }

        } else if (\is_array( $error )) {
            $info['description'] = $error;
        }

        $info['status'] = $className::HTTP_STATUS;
        $info['title'] = $className::HTTP_STATUS_TEXT;

        return $info;
    }

    public function buildResponse( array $args ) {
        $infos = $this->preBuiltResponse( $args );

        $this->status = $infos['status'];
        $this->code = $infos['code'];
        $this->title = $infos['title'];
        $this->description = $infos['description'];
    }

    public function render() {
        \Nodeflux\Config\Response::__error(
            $this->status, 
            $this->code, 
            $this->title, 
            $this->description
        );
    }
}
