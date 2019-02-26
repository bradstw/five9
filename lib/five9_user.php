<?php
# Class to get and manage user information
class five9_user extends five9
{
    # ACCEPTS user name
    # RETURNS array of users general info
    public function getUsersGeneralInfo($user_name)
    {
        $method = 'getUsersGeneralInfo';
        $user = [
            'username' => [
                'userNamePattern' => $user_name,
            ]
        ];
        $result = $this->client->__soapCall($method, $user);
        $vars = get_object_vars($result);
        $response = get_object_vars($vars['return']);
        return $response;
    }
    
    # ACCEPTS user name
    # RETURNS array of all users info (general info, roles, skills, permissions)
    public function getAllUsersInfo($user_name)
    {
        $method = 'getUsersInfo';
        $user = [
            'username' => [
                'userNamePattern' => $user_name,
            ]
        ];
        $result = $this->client->__soapCall($method, $user);
        $vars = get_object_vars($result);
        $response = get_object_vars($vars['return']);
        return $response;
    }
    
    # ACCEPTS array of new user parameters
    # RETURNS array generalInfo, roles, skills of created user
    public function createUser($new_user)
    {
        $method = 'createUser';
        
        # DEFAULTS for new user creation
        $change_pass = !isset($new_user['can_change_password']) ? true : $new_user['can_change_password'];
        $must_change = !isset($new_user['must_change_password']) ? true : $new_user['must_change_password'];
        
        $user_general_info = [
            'firstName' => $new_user['first_name'],
            'lastName' => $new_user['last_name'],
            'password' => $new_user['password'],
            'userName' => $new_user['user_name'],
            'EMail' => $new_user['email'],
            'userProfileName' => $new_user['user_profile'],
            'canChangePassword' => $change_pass,
            'mustChangePassword' => $must_change,
            'active' => true,
        ];
        
        # DEFAULTS for agent role settings
        $agent_role_params = [
            'alwaysRecorded' => true,
            'sendEmailOnVm' => false,
            'attachVmToEmail' => false,
        ];
        
        $new_user_build = [
            'userInfo' => [
                'generalInfo' => $user_general_info,
                'roles' => [
                    'agent' => $agent_role_params,
                ],
            ],
        ];
        
        try {
            $result = $this->client->$method($new_user_build);
            $vars = get_object_vars($result);
            $response = get_object_vars($vars['return']);
            return $response;
        } catch (\Exception $e) {
            $error_message = $e->getMessage();
            return $error_message;
        }
    }
    
    # ACCEPTS user name
    # RETURNS success response or error exception
    public function deleteUser($user_name)
    {
        $method = 'deleteUser';
        $user = [
            'userName' => $user_name
        ];
        
        try {
            $result = $this->client->$method($user);
            $response = 'success';
            return $response;
        } catch (\Exception $e) {
            $error_message = $e->getMessage();
            return $error_message;
        }
    }
}
