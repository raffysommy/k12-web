<?php

namespace K12\View\Helper;

use Zend\View\Helper\AbstractHelper;

class UserIdentity extends AbstractHelper
{
	protected $user = null;

	public function __construct($user)
	{
		$this->setUser($user);
	}

	public function __invoke()
	{
		return $this->user;
	}

	public function setUser($user)
	{
		$this->user = $user;
	}

	public function getUser()
	{
		return $this->user;
	}
}

?>