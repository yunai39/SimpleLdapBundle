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
    %TODO%

You need to enable the bundle into your kernel

    //app/AppKernel.php
    new Yunai39\Bundle\SimpleLdapBundle\SimpleLdapBundle(),
    

You need to configure your domain specific information
# define your active directory server
    ldap.settings:
          server: 172.16.33.153
          port: 389
          account_suffix : employeeNumber 
          base_dn : DC=example,DC=com 
# The attribut you want your user Class to have, those are the default
    ldap.settings.user:
          FullName: cn
          Email: mail
# The buissnessCategory wil determine the role of the user 
    ldap.role: buissnesscategory
# The actual definition of the role, here if buissnesscategory is equel to Administration the user will have the ROLE_ADMIN
    ldap.settings.role:
          Administration: ROLE_ADMIN
# The redirection after login based on the ROLE
    ldap.security.redirects: { ROLE_USER: user_home, ROLE_ADMIN: admin_home }
    
Finally, the security parameters (Just what's needed for the undle, the rest is up to you)
security:
    encoders:
        Security\LdapBundle\Security\User\UserLdap : plaintext #Active directory does not support encrypted password yet

    role_hierarchy:

    providers:
        my_active_directory_provider:
              id: security_ldap_provider


Useful information
----------------------

You can use the authentification via Ajax, instead of sending you a redirection, a json response wil be send true ou false

This Bundle doesn't need any databases, the password will not be registred anywhere. As it use the php_ldap extension, you can use ldaps (You will need to configure ldap on you own)

SSL part of the lib isn't used yet and haven't been tested with Symfony
