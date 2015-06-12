<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_sess extends ES_Model {

    public function __construct()
    {
        $this->table_name = "users";
    }

    function is_logged_in(){
        return $this->session->userdata('status') === STATUS_ACTIVATED ;
    }

       /**
     * Login user on the site. Return TRUE if login is successful
     * (user exists and activated, password is correct), otherwise FALSE.
     *
     * @param	$login    string	(username or email)
     * @param	$password string
     */
    function login($login, $password) {
        $login    = strval(trim($login));
        $password = strval(trim($password));
        $user = $this->user->findOneBy(array("recycle"=>ESC_NORMAL,"username"=>$login));
        if(!$user){
            return 2;//no such user!
        }
        if($user['password'] == md5($password)){
            $this->session->set_userdata(array(
                'user_id'	=> $user['id'],
                'username'	=> $user['username'],
                'status'	=> STATUS_ACTIVATED,
            ));
            return 0;
        }else{
            return 1; //wrong password
        }

    }
    
    /**
     * Get user_id
     *
     * @return	string
     */
    function get_user_id()
    {
        return $this->session->userdata('user_id');
    }
    
    function findCurrentUser()
    {
        return $this->find_sql($this->session->userdata('user_id'));
    }

    /**
     * Get username
     *
     * @return	string
     */
    function get_username()
    {
        return $this->session->userdata('username');
    }
    
}
