<?php

namespace App\Security;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class SessionIdleHandler 
{

    protected $session;
    protected $securityToken;
    protected $router;
    protected $maxIdleTime;
    protected $urlGenerator;
    protected $request;

    public function __construct($maxIdleTime, SessionInterface $session, TokenStorageInterface $securityToken, RouterInterface $router, UrlGeneratorInterface $urlGenerator)
    {
        $this->session = $session;
        $this->securityToken = $securityToken;
        $this->router = $router;
        $this->maxIdleTime = $maxIdleTime;
        $this->urlGenerator = $urlGenerator;
        $this->request = new Request();
        
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST != $event->getRequestType()) {

            return;
        }

        if ($this->maxIdleTime > 0) {

            $this->session->start();
            $lapse = time() - $this->session->getMetadataBag()->getLastUsed();

            if ($lapse > $this->maxIdleTime) {

                header('location: '.$this->router->generate('self_deconnexion'));
                exit;
                //$this->securityToken->setToken(null);
                //$this->session->getFlashBag()->set('info', 'You have been logged out due to inactivity.');

                // logout is defined in security.yaml.  See 'Logging Out' section here:
                // https://symfony.com/doc/4.1/security.html

            }
        }
    }
}