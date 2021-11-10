<?php

namespace Pab\Controller;

use Pop\Controller\AbstractController;
use Pop\Http\Server\Request;
use Pop\Http\Server\Response;
use Pop\View\View;
use Pab\Model;

class IndexController extends AbstractController
{

    /**
     * @var Request
     */
    protected $request  = null;

    /**
     * @var Response
     */
    protected $response = null;

    /**
     * @var string
     */
    protected $viewPath = __DIR__ . '/../../view';

    /**
     * @var array
     */
    protected $nav = [
        'New Orders', 'Active Users', 'Admins', 'Home'
    ];

    public function __construct(Request $request, Response $response)
    {
        $this->request  = $request;
        $this->response = $response;
    }

    public function index()
    {
        $view        = new View($this->viewPath . '/index.phtml');
        $view->title = 'Welcome';
        $view->nav   = $this->nav;

        $this->response->setBody($view->render());
        $this->response->send();
    }

    public function orders()
    {
        $view        = new View($this->viewPath . '/orders.phtml');
        $view->title = 'New Orders';
        $view->nav   = $this->nav;

        $this->response->setBody($view->render());
        $this->response->send();
    }

    public function users()
    {
        $userModel   = new Model\User();
        $view        = new View($this->viewPath . '/users.phtml');
        $view->title = 'Active Users';
        $view->nav   = $this->nav;
        $view->users = $userModel->getAll();

        $this->response->setBody($view->render());
        $this->response->send();
    }

    public function user($id)
    {
        $view        = new View($this->viewPath . '/user.phtml');
        $view->title = 'Active Users';
        $view->nav   = $this->nav;

        /**
         * Task 3:
         *
         * Explore the user model object. Get a user by the ID passed down to this controller method.
         * Display that user's information in the view however you see fit. Consider what to display
         * in the view if the ID passed does not return a user.
         */
        
        $userModel = new Model\User(); // this creates a new nuer Model
        $user = $userModel->getById($id); // this gets the user by its id

        // if no user found it updates the view as No User Found and if a user is found it displays the user information in the view
         if(count($user) === 0){
             $view->title = 'No User Found';
         }else{
             $username = $user['username'];
             $email = $user['email'];
             $view->title = $username;
             $view->id = $id;
             $view->username = $username;
             $view->email= $email;
         }

        $this->response->setBody($view->render());
        $this->response->send();
    }

    public function admins()
    {
        $view        = new View($this->viewPath . '/admins.phtml');
        $view->title = 'Admins';
        $view->nav   = $this->nav;

        $this->response->setBody($view->render());
        $this->response->send();
    }

    public function error()
    {
        $view = new View($this->viewPath . '/error.phtml');
        $view->title = 'Error';
        $view->nav   = $this->nav;

        $this->response->setBody($view->render());
        $this->response->send(404);
    }

}
