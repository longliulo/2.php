<?php namespace MyApp;

use Phalcon\Mvc\User\Component,
    Phalcon\Acl\Adapter\Memory as AclMemory,
    Phalcon\Acl\Role as AclRole,
    Phalcon\Acl\Resource as AclResource,
    MyApp\Model\Roles;

/**
 *
 *
 *
 */
class Acl extends Component
{

    private $_acl;


    private $_privateResources = array(
        /*'managepermissions' => array('index'),
        'managedistricts' => array('index','add','edit','delete'),
        'managefacilities'=>array('index','add','edit','delete'),
        'managelistings'=>array('index','add','edit','delete'),
        'managenewspost'=>array('index','add','edit','delete'),
        'manageprojects'=>array('index','add','edit','delete'),
        'managepropertytypes'=>array('index','add','edit','delete'),
        'managetags'=>array('index','add','edit','delete'),
        'manageuser'=>array('index','add','edit','delete', 'resetPassword'),
        'dashboard'=>array('index'),
        'manageareas'=>array('index','add','edit','delete'),
        'managefaqs'=>array('index','add','edit','delete'),
        'managedevelopers'=>array('index','add','edit','delete'),
        'agent'=>array('index','profile','listproject','savePrice', 'deleteProject', 'delete', 'updateProfile', 'checkEmail', 'checkUser'),
        'manageuserlistings' => array('index', 'edit', 'delete', 'commonlisting', 'add'),
        'dashboarduser'      => array('index', 'completePayment', 'profile'),
        'agentprojects'      => array('detail'),
        'agentlistings'      => array('detail'),*/
    );

    private $_actionDescriptions = array(
        'index' => 'Access/list',
        'search' => 'Search',
        'add' => 'Create',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'transfe' =>'transfe',
        'changePassword' => 'Change password',
        'profile' => 'profile',
        'listproject' => 'listproject',
        'savePrice' => 'savePrice',
        'deleteProject' =>'deleteProject',
        'updateProfile' => 'updateProfile',
        'checkEmail' => 'checkEmail',
        'checkUser' => 'checkUser',
        'resetPassword' => 'resetPassword',
        'detail' => 'Detail'
    );

    /**
     * Checks if a controller is private or not
     *
     * @param string $controllerName
     * @return boolean
     */
    public function isPrivate($controllerName)
    {
        return isset($this->_privateResources[$controllerName]);
    }

    /**
     * Checks if the current profile is allowed to access a resource
     *
     * @param string $profile
     * @param string $controller
     * @param string $action
     * @return boolean
     */
    public function isAllowed($profile, $controller, $action)
    {
        return $this->getAcl()->isAllowed($profile, $controller, $action);
    }

    /**
     * Returns the ACL list
     *
     * @return Phalcon\Acl\Adapter\Memory
     */
    public function getAcl()
    {


        $this->_acl = $this->rebuild();


        return $this->_acl;
    }

    /**
     * Returns the permissions assigned to a profile
     *
     * @param Roles $profile
     * @return array
     */
    public function getPermissions(Roles $profile)
    {
        $permissions = array();
        foreach ($profile->getPermissions() as $permission) {
            $permissions[$permission->resource . '.' . $permission->action] = true;
        }
        return $permissions;
    }

    /**
     * Returns all the resoruces and their actions available in the application
     *
     * @return array
     */
    public function getResources()
    {
        return $this->_privateResources;
    }

    /**
     * Returns the action description according to its simplified name
     *
     * @param string $action
     * @return $action
     */
    public function getActionDescription($action)
    {
        if (isset($this->_actionDescriptions[$action])) {
            return $this->_actionDescriptions[$action];
        } else {
            return $action;
        }
    }

    /**
     * Rebuils the access list into a file
     *
     */
    public function rebuild()
    {

        $acl = new AclMemory();

        $acl->setDefaultAction(\Phalcon\Acl::DENY);

        //Register roles
        $roles = Roles::find('active = "Y"');

        foreach ($roles as $role) {
            $acl->addRole(new AclRole($role->name));
        }

        foreach ($this->_privateResources as $resource => $actions) {
            $acl->addResource(new AclResource($resource), $actions);
        }

        //Grant acess to private area to role Users
        foreach ($roles as $role) {

            //Grant permissions in "permissions" model
            foreach ($role->getPermissions() as $permission) {
                $acl->allow($role->name, $permission->resource, $permission->action);
            }

            //Always grant these permissions
            //$acl->allow($role->name, 'users', 'changePassword');

        }
        return $acl;
    }
}