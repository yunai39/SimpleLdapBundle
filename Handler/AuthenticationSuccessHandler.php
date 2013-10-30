<?php
namespace Security\LdapBundle\Handler;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler;
use Symfony\Component\Security\Http\HttpUtils;

class AuthenticationSuccessHandler extends DefaultAuthenticationSuccessHandler {

    public function __construct( HttpUtils $httpUtils, array $options ) {
        parent::__construct( $httpUtils, $options );
    }

    public function onAuthenticationSuccess( Request $request, TokenInterface $token ) {
        if( $request->isXmlHttpRequest() ) {
            $response = new JsonResponse( 'true' );
        } else {
            $response = parent::onAuthenticationSuccess( $request, $token );
        }
        return $response;
    }
}