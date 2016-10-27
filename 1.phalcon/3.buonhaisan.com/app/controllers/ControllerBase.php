<?php
namespace MyApp\Controllers;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;


class ControllerBase extends Controller
{
    public $user;
    public function onConstruct() {
		
        $this -> view -> setLayout('home');

    }
    public function beforeExecuteRoute(Dispatcher $dispatcher) {

        $controllerName = $dispatcher -> getControllerName();

        //Only check permissions on private controllers
        if ($this -> acl -> isPrivate($controllerName)) {

            //Get the current identity
            $identity = $this -> auth -> getIdentity();

            //If there is no identity available the user is redirected to index/index
            if (!is_array($identity)) {
                //$dispatcher -> forward(array('controller' => 'index', 'action' => 'index'));
                $this->session->set('keep-link', "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                $this -> response->redirect("/login");
                return false;
            }

            //Check if the user have permission to the current option
            $actionName = $dispatcher -> getActionName();
            if (!$this -> acl -> isAllowed($identity['role'], $controllerName, $actionName)) {
                //$dispatcher -> forward(array('controller' => 'index', 'action' => 'index'));
                $this->response->redirect('/');
                return false;
            }

        }
    }

    /*In-progress */
    private function checkDomainForTeam($domain) {
        $pos = strpos($domain, DOMAIN_NAME);
        $teams = new Teams();
        $team = false;
        if ($pos === false) {
            $team = $teams ->findByDomain($domain);
        } else {
            $subDomain = array_shift((explode(".", $domain)));
            $domain =  array_shift((explode(".",DOMAIN_NAME)));
            if ($subDomain != $domain) {
                $team = $teams ->findByName($subDomain);
            }
        }
    }
}