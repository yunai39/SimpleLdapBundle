<?php

namespace Yunai39\Bundle\SimpleLdapBundle\Service;

/**
 * Class LdapService
 * @package Yunai39\Bundle\SimpleLdapBundle\Service
 */
class LdapService
{
    /** @var array */
    protected $parameters;

    /**
     * LdapService constructor.
     * @param array $parameters
     */
    public function __construct($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @return resource
     */
    public function connect()
    {
        $connect = ldap_connect($this->parameters['server'], $this->parameters['port']);

        return $connect;
    }

    /**
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function authenticate($username, $password)
    {
        foreach ($this->parameters['base_dn'] as $d) {
            $dn = $this->parameters['account_suffix'] . '=' . $username . ',' . $d;

            $connect = ldap_connect($this->parameters['server'], $this->parameters['port']);
            ldap_set_option($connect, LDAP_OPT_DEBUG_LEVEL, 7);
            // Set ten second before timeout
            if (!ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3)) {
                return false;
            }
            $bindServerLDAP = @ldap_bind($connect, $dn, $password);
            if ($bindServerLDAP) {
                ldap_close($connect);

                return true;
            }
        }
        ldap_close($connect);

        return false;
    }

    /**
     * @param string $username
     * @param $key
     * @return array|bool
     */
    public function infoCollection($username, $key)
    {
        foreach ($this->parameters['base_dn'] as $dn) {
            $ds = ldap_connect(
                $this->parameters['server'],
                $this->parameters['port']
            );
            // doit �tre un serveur LDAP valide !
            if ($ds) {
                $filter = $this->parameters['account_suffix'] . '=' . $username;
                $sr = ldap_search($ds, $dn, $filter);
                $info = ldap_get_entries($ds, $sr);
                ldap_close($ds);
                $ret = array();
                foreach ($key as $k => $v) {
                    if (isset($info[0][$v])) {
                        $ret[$v] = $info[0][$v][0];
                    } else {
                        $ret[$v] = "";
                    }
                }

                return $ret;
            }
        }

        return false;
    }
}
