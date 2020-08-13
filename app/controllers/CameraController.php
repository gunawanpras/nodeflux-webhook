<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Cameras;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use App\Exceptions\ApiException\ValidationException;
use Nodeflux\Config\Response;
use Nodeflux\Config\Constant as CONSTANT;

class CameraController extends ControllerBase
{
    public function initialize() {
        $this->view->disable();
        $this->logger = $this->di->get('logger');
    }

    public function createAction() {
        try {
            $this->logger->info( 'request: ' . json_encode($this->request->getPost()) );

            $validator = new Validation();
            $validator
                ->add('cam_id', 
                    new PresenceOf([
                        'message' => ':field is required'
                            ]))
                            
                ->add('person_count', 
                    new PresenceOf([
                        'message' => ':field is required'
                            ]));

            $messages = $validator->validate($this->request->getPost());

            if (count($messages) > 0) {
                $errMessages = [];
                foreach ($messages as $message) {
                    array_push($errMessages, (string) $message);
                }

                $this->logger->error( json_encode($errMessages) );
                throw new ValidationException($errMessages);
            }
            
            $camera = new Cameras();
            $camera->cam_id = $this->request->getPost('cam_id', null);
            $camera->person_count = $this->request->getPost('person_count', null);
            
            if (! $camera->create()) {
                throw new ValidationException('SAVE_FAILED');
            }

            $response = Response::__success(CONSTANT::DEFAULT, CONSTANT::SUCCESS, []);
            $this->logger->info( 'response: ' . $response );

            return $response;

        } catch (ValidationException $e) {
            throw $e;
        }
    }
}

