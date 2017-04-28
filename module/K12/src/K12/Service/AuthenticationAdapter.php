<?php

namespace K12\Service;

use K12\Entity\User;
use K12\Service\OAuthServiceManager;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;

class AuthenticationAdapter implements AdapterInterface
{
    protected $username;
    protected $password;
    protected $oAuthService;
    
    /**
     * Sets authentication data
     *
     * @return void
     */
    public function __construct(OAuthServiceManager $oAuthService, $username = null, $password = null)
    {
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setOAuthService($oAuthService);
    }
    
    /**
     * Performs an authentication attempt
     *
     * @return \Zend\Authentication\Result
     * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface
     *               If authentication cannot be performed
     */
    public function authenticate()
    {
        $oauthResult = $this->getOAuthService()->login($this->username, $this->password);
        if (isset($oauthResult->access_token))
            return new Result(Result::SUCCESS, new User(
                json_decode($this->getOAuthService()->sendRequest('/api/user/info')->getContent(), true)
            ));
        return new Result(Result::FAILURE, new User);
    }

	public function getUsername()
	{
		return $this->username;
	}
	
	public function getOAuthService()
	{
		return $this->oAuthService;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function setUsername($value)
	{
		$this->username = $value;
		return $this;
	}

	public function setPassword($value)
	{
		$this->password = $value;
		return $this;
	}
	
	public function setOAuthService(OAuthServiceManager $value)
	{
		$this->oAuthService = $value;
		return $this;
	}
}

?>