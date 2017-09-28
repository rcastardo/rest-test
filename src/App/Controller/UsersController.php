<?php

namespace Acme\App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Acme\Util\Database;


class UsersController implements ControllerProviderInterface
{

    protected $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }


    public function connect(Application $app) {
       
        $factory = $app['controllers_factory'];
        $factory->get('/', 'Acme\App\Controller\UsersController::getAction');
        $factory->post('/', 'Acme\App\Controller\UsersController::postAction');
        $factory->delete('/{id}', 'Acme\App\Controller\UsersController::deleteAction');

        return $factory;
    }

    public function getAction()
    {
        $stmt = $this->db->prepare("SELECT * FROM users");
        $stmt->execute();
        $users = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return new JsonResponse($users, 201, ['Location' => 'users']);
    }
    
    public function postAction(Request $request)
    {
        $rawData = json_decode(file_get_contents("php://input"), true);
        // json_decode($request->getContent(), true);
     
        $stmt = $this->db->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
        $stmt->execute($rawData);
        return new JsonResponse(1, 201, ['Location' => 'users']);
    }
    
    public function deleteAction(Request $request)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $request->get('id')); 
        $stmt->execute();
     
        return new JsonResponse(1, 201, ['Location' => 'users']);
    }


}
