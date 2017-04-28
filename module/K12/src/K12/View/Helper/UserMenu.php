<?php

namespace K12\View\Helper;

use Zend\View\Helper\AbstractHelper;

class UserMenu extends AbstractHelper
{
	protected $user = null;
				
	public function __construct($user)
	{
		$this->setUser($user);
	}
		
	public function __invoke()
	{
	    $urlPlugin = $this->getView()->plugin('url');
	    $basePathPlugin = $this->getView()->plugin('basePath');
	    echo 
	    '<li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="'.$basePathPlugin('dist/img/user2-160x160.jpg').'" class="user-image" alt="User Image"/>
                <span class="hidden-xs">'.$this->user->firstName.' '.$this->user->lastName.'</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
                <li class="user-header">
                    <img src="'.$basePathPlugin('dist/img/user2-160x160.jpg').'" class="img-circle" alt="User Image" />
                    <p>
                        '.$this->user->firstName.' '.$this->user->lastName.' - '.$this->user->role.'
                    </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <div class="pull-left">
                        <a href="'.$urlPlugin('authentication').'" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                        <a href="'.$urlPlugin('authentication/logout').'" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                </li>
            </ul>
        </li>';
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