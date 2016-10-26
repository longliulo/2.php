<?php namespace MyApp;

use Phalcon\Mvc\User\Component,
    MyApp\Model\Users;

/**
 *
 * Manages Authentication/Identity Management in
 */
class Auth extends Component
{

    /**
     * Checks the user credentials
     *
     * @param array $credentials
     * @return boolean
     */
    public function checkAdmin($credentials) {

    $password = sha1($credentials['password']);
    $user = Users::findFirst(array("deleted = 0 and email = '". $credentials['email'] ."' and password='".$password."'"));
    if ($user == false) {
        return false;
    }
    //check role login
    if($user -> role_id == GROUP_USER){
        return false;
    }

    //Check if the user was flagged, active or not active
    //$this->checkUserFlags($user);


    //Check if the remember me was selected
    if (isset($credentials['remember'])) {
        $this->createRememberEnviroment($user);
    }

    $this->session->set('auth-identity-admin', array(
        'id' => $user->id,
        'username' => $user -> name,
        'role' => $user -> role -> name,
        'role_id' => $user -> role -> id,
        'avatar' => $user -> avatar,
    ));
    return true;
    }

    public function checkUser($credentials) {

        $password = sha1($credentials['password']);
        $user = Users::findFirst(array("deleted = 0 and email = '". $credentials['email'] ."' and password='".$password."'"));

        if ($user == false) {
            return false;
        }
        //check role login
        if ($user -> role_id != GROUP_USER && $user -> role_id != GROUP_USER_ADMIN) {
            return false;
        }


        //Check if the remember me was selected
        if (isset($credentials['remember'])) {
            $this->createRememberEnviroment($user);
        }

        $this->session->set('auth-identity', array(
            'id' => $user->id,
            'username' => $user->name,
            'role' => $user -> role -> name,
            'role_id' => $user -> role -> id,
            'avatar' => $user -> avatar,
        ));
        return true;
    }

    /**
     * Creates the remember me environment settings the related cookies and generating tokens
     *
     */
    public function createRememberEnviroment(Users $user)
    {

    $userAgent = $this->request->getUserAgent();
    $token = md5($user->username . $user->password . $userAgent);

    $remember = new RememberTokens();
    $remember->usersId = $user->id;
    $remember->token = $token;
    $remember->userAgent = $userAgent;

    if ($remember->save() != false) {
        $expire = time() + 86400 * 8;
        $this->cookies->set('RMU', $user->id, $expire);
        $this->cookies->set('RMT', $token, $expire);
    }

    }

    /**
     * Check if the session has a remember me cookie
     *
     * @return boolean
     */
    public function hasRememberMe()
    {
    return $this->cookies->has('RMU');
    }

    /**
     * Logs on using the information in the coookies
     *
     * @return Phalcon\Http\Response
     */
    public function loginWithRememberMe()
    {
    $userId = $this->cookies->get('RMU')->getValue();
    $cookieToken = $this->cookies->get('RMT')->getValue();

    $user = Users::findFirstById($userId);
    if ($user) {

        $userAgent = $this->request->getUserAgent();
        $token = md5($user->email . $user->password . $userAgent);

        if ($cookieToken == $token) {

        $remember = RememberTokens::findFirst(array(
            'usersId = ?0 AND token = ?1',
            'bind' => array($user->id, $token)
        ));
        if ($remember) {

            //Check if the cookie has not expired
            if ((time() - (86400 * 8)) < $remember->createdAt) {

            //Check if the user was flagged
            $this->checkUserFlags($user);

            //Register identity
            $this->session->set('auth-identity', array(
                'id' => $user->id,
                'username' => $user->username,
                'profile' => $user->profile->name
            ));

            //Register the successful login
            $this->saveSuccessLogin($user);

            return $this->response->redirect('admin/hososinhvien');
            }
        }

        }

    }

    $this->cookies->get('RMU')->delete();
    $this->cookies->get('RMT')->delete();

    return $this->response->redirect('admin/');
    }

    /**
     * Returns the current identity
     *
     * @return array
     */
    public function getIdentity()
    {
    return $this->session->get('auth-identity');
    }

    /**
     * Returns the current identity for admin
     */
    public function getIdentityAdmin()
    {
    return $this->session->get('auth-identity-admin');
    }

    /**
     * Returns the current identity
     *
     * @return string
     */
    public function getName()
    {
    $identity = $this->session->get('auth-identity');
    return $identity['username'];
    }

    /**
     * Removes the user identity information from session For Admin
     */
    public function removeForAdmin()
    {
    if ($this->cookies->has('RMU')) {
        $this->cookies->get('RMU')->delete();
    }
    if ($this->cookies->has('RMT')) {
        $this->cookies->get('RMT')->delete();
    }

    $this->session->remove('auth-identity-admin');
    }


    /**
     * Removes the user identity information from session
     */
    public function remove()
    {
    if ($this->cookies->has('RMU')) {
        $this->cookies->get('RMU')->delete();
    }
    if ($this->cookies->has('RMT')) {
        $this->cookies->get('RMT')->delete();
    }

    $this->session->remove('auth-identity');
    }

    /**
     * Auths the user by his/her id
     *
     * @param int $id
     */
    public function authUserById($id)
    {
    $user = Users::findFirstById($id);
    if ($user == false) {
        throw new Exception('The user does not exist');
    }

    $this->checkUserFlags($user);

    $this->session->set('auth-identity', array(
        'id' => $user->id,
        'username' => $user->username,
        'profile' => $user->profile->name
    ));

    }

    /**
     * Get the entity related to user in the active identity
     *
     */
    public function getUser()
    {
    $identity = $this->session->get('auth-identity');
    if (isset($identity['id'])) {

        $user = Users::findFirstById($identity['id']);
        if ($user == false) {
        throw new Exception('The user does not exist');
        }

        return $user;
    }

    return false;
    }

}