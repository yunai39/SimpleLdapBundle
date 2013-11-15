<?php
namespace Yunai39\Bundle\SimpleLdapBundle\Handler;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationFailureHandler;
use Symfony\Component\Security\Http\HttpUtils;

class AuthenticationFailureHandler extends DefaultAuthenticationFailureHandler {

    public function __construct( HttpKernelInterface $httpKernel, HttpUtils $httpUtils, array $options,  $logger = null ) {
        parent::__construct( $httpKernel, $httpUtils, $options, $logger );
    }

    public function onAuthenticationFailure( Request $request, AuthenticationException $exception ) {
        if( $request->isXmlHttpRequest() ) {
            $response = new JsonResponse( 'false' );
        } else {
            $response = new RedirectResponse($request->headers->get('referer'));
        }
        return $response;
    }
}