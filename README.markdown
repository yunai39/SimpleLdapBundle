SimpleLdapBundle
================

This is a Bundle for Symfony for an Ldap Authentification

This Bundle will not register any information in a databases, it wil only interact with the Ldap annuary.
You do not need to add anything, expect for php_ldap, which is used to collect and authentificated an User.

Requirement
-----------

To use this Bundle you will need to have php_ldap installed on you server

Installation
------------

You need to add a package to your dependency list :

	"yunai39/simple-ldap-bundle": "dev-master"
	
When do a composer update:
	
	composer update "yunai39/simple-ldap-bundle"

You need to enable the bundle into your kernel

    //app/AppKernel.php
    new Yunai39\Bundle\SimpleLdapBundle\SimpleLdapBundle(),
    

Configuration
-------------

You need to configure your domain specific information

    # define your active directory server
    ldap.settings:
          server: ip.to.your.server
          port: 389 ou 636
          account_suffix : employeeNumber # The account suffix will be the parameter used to search your ldap
          base_dn : DC=example,DC=com  
    # The attribut you want your user Class to have, those are the default
    ldap.settings.user:
          FullName: cn # Here the ldap attribut cn will be set to FullName in the User Class
          Email: mail
    #The buissnessCategory wil determine the role of the user 
    ldap.role: buissnesscategory
    # The actual definition of the role, here if buissnesscategory is equal to Administration the user will have the ROLE_ADMIN
    ldap.settings.role:
          Administration: ROLE_ADMIN
    # The redirection after login based on the ROLE
    ldap.security.redirects: { ROLE_USER: user_home, ROLE_ADMIN: admin_home }
    # Name of the user class
    ldap.user.class: Acme\DemoBundle\Security\User\CustomLdapUser

You will also need to create an UserClass, check out [Example of an User](https://github.com/yunai39/SimpleLdapBundle/wiki/Example-User)

Finally, the security parameters (Just what's needed for the Bundle, the rest is up to you)

    security:
        encoders:
            Security\LdapBundle\Security\User\UserLdap : plaintext #Active directory does not support encrypted password yet
    providers:
        my_active_directory_provider:
              id: security_ldap_provider


Useful information
----------------------

You can use the authentification via Ajax, instead of sending you a redirection, a json response wil be send true ou false

This Bundle doesn't need any databases, the password will not be registred anywhere. As it use the php_ldap extension, you can use ldaps (You will need to configure ldap on you own)

SSL part of the lib isn't used (But fell free to test it)
