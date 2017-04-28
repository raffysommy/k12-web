<?php

namespace K12\Service;

use Zend\Authentication\AuthenticationService as ZendAuthService;

class AuthenticationService extends ZendAuthService
{
    protected $k12Api;
    
    public function __construct(OAuthServiceManager $k12Api)
    {
        parent::__construct(null, null);
        $this->k12Api = $k12Api;
    }
    
    public function clearIdentity()
    {
        $this->k12Api->logout();
        parent::clearIdentity();
    }
}

?>