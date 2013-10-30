<?php
namespace Yunai39\Bundle\SimpleLdapBundle\Security\Listener;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher as EventDispatcher;

class SecurityListener
{ 
	/**
     * Router
     *
     * @var Router
     */
    protected $router;

    /**
     * Routes
     *
     * @var array
     */
    protected $routes = array();

    /**
     * Route to redirect to
     *
     * @var string
     */
    protected $redirect;

    /**
     * Constructor
     *
     * @param Router $router The router
     * @param array $routes The routes for redirection
     */
    public function __construct(Router $router, array $routes)
    {
        $this->router = $router;
        $this->routes = $routes;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();
        $roles = $user->getRoles();
        $role = reset($roles);
        if (array_key_exists($role, $this->routes)) {
            $this->redirect = $this->routes[$role];
        }
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (null !== $this->redirect) {
            $url = $this->router->generate($this->redirect);
            $event->setResponse(new RedirectResponse($url));
        }
    }
}
