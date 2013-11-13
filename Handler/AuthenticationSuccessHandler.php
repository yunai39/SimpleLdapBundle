<?php
namespace Yunai39\Bundle\SimpleLdapBundle\Handler;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthenticationSuccessHandler extends DefaultAuthenticationSuccessHandler {
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
	
    public function __construct( HttpUtils $httpUtils, array $options, $router , $routes ) {
        parent::__construct( $httpUtils, $options );
        $this->router = $router;
        $this->routes = $routes;
    }

    public function onAuthenticationSuccess( Request $request, TokenInterface $token ) {
        if( $request->isXmlHttpRequest() ) {
            $response = new JsonResponse( 'true' );
        } else {
            $user = $token->getUser();
	        $roles = $user->getRoles();
	        $role = reset($roles);
			$referer_url = $request->headers->get('referer');
	        if (array_key_exists($role, $this->routes)) {
	        	$referer_url = $this->routes[$role];
	        }
	        return new RedirectResponse($this->router->generate($referer_url));
        }
        return $response;
    }
}