SimpleLdapBundle
================

This is a Bundle for Symfony for an Ldap Authentification

This bundle will is meant to be use without a database (V1.x) or you can use it with a database for (V2.x).

The version without a database is describe on the tag V1

The version with a database is simple, you have a database where a id corresponding to a field(the name of that field is defined int the parameter.yml) in the ldap tree (exemple: employeenumber - 00000), and you will give a specific role for the user with the field employee number 00000
You also have a boolean field for the user to be unvalidated, user who are unvalidated and not recored in the database (but do exist in the LDAP tree, will have a default role defined in the parameter.yml)

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

The configuration is a bit long:

First you need to register the bundle in your AppKernel
	
	
    $bundles = array(
	...
	new Yunai39\Bundle\SimpleLdapBundle\SimpleLdapBundle(),
	...
	};



You need to configure your domain specific information, put those information into app/config/parameters.yml

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
    # The redirection after login based on the ROLE
    ldap.security.redirects: { ROLE_USER: user_home, ROLE_ADMIN: admin_home }
    # Name of the user class
    ldap.user.class: Acme\DemoBundle\Security\User\CustomLdapUser
    #if the user is not registered in that database or is not registered as valid in the database he will have the default role
    ldap.default.role: ROLE_USER
	#Information about the table that will handle the role for the user
    security.user_ldap.class: Main\SecurityBundle\Entity\MyUserLdap


You will also need to create an UserClass, check out [Example of an User](https://github.com/yunai39/SimpleLdapBundle/wiki/Example-User)


There is also the need to create the table for role association, check out [Create the association database](https://github.com/yunai39/SimpleLdapBundle/wiki/How-to-create-the-database-for-association)

The security parameters (Just what's needed for the Bundle, the rest is up to you)

    security:
        encoders:
            Security\LdapBundle\Security\User\UserLdap : plaintext #Active directory does not support encrypted password yet
    providers:
        my_active_directory_provider:
              id: security_ldap_provider

You will also need to add the following configuration key in your firewall to reference the providers

    ldap: true
    
Example

        firewalls:
        ldap:
            pattern:  ^/
            anonymous: ~
            form_login:
                login_path: login
                check_path: login_check
            logout:
                path:   /logout
                target: login
            ldap: true
                
Information
-----------

Do not forget to generate a crud that will be in a safe part of your web site (Lets say you need the role ROLE_SUPER_ADMIN to acces it), and to create a user that have the role(ROLE_SUPER_ADMIN) to access that part of the website.


Version
----------------------
	
2.0
	- A database to handle user role
