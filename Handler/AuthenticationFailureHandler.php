<?php
namespace Yunai39\Bundle\SimpleLdapBundle\Handler;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationFailureHandler;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\SecurityContextInterface;
class AuthenticationFailureHandler extends DefaultAuthenticationFailureHandler {

    public function __construct( HttpKernelInterface $httpKernel, HttpUtils $httpUtils, array $options,  $logger = null ) {
        parent::__construct( $httpKernel, $httpUtils, $options, $logger );
    }

	/**
	 * @method onAuthenticationFailure
	 * 
	 * @param Request $request 						The request for the authentification
	 * @param AuthenticationException $exception	Exception generate by the failure
	 * 
	 * This function will response false if the AuthenticationFailure was proceded with Ajax
	 * Otherwise it will redirect the user toward the previous page (login page usually) 
	 */
    public function onAuthenticationFailure( Request $request, AuthenticationException $exception ) {
        if( $request->isXmlHttpRequest() ) {
            $response = new JsonResponse( 'false' );
        } else {
            $response = new RedirectResponse($request->headers->get('referer'));
        }
        $request->getSession()->set(SecurityContextInterface::AUTHENTICATION_ERROR, $exception);
        return $response;
    }
}