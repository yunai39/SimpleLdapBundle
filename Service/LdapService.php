<?php

namespace Yunai39\Bundle\SimpleLdapBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;

class LdapService
{
	protected $parameters;
    public function __construct($parameters)
    {
        $this->parameters = $parameters;
    }


    public function connect()
    {
        $connect = ldap_connect($this->parameters['server'],$this->parameters['port']);
        return $connect;
    }
	
	public function authenticate($username,$password){
		
		$dn = $this->parameters['account_suffix'].'='.$username.','.$this->parameters['base_dn'];
        $connect = ldap_connect($this->parameters['server'],$this->parameters['port']);
		ldap_set_option($connect, LDAP_OPT_DEBUG_LEVEL,7);
		// Set ten second before timeout
		ldap_set_option($connect, LDAP_OPT_NETWORK_TIMEOUT,10);
        if (!ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3)) 
		{
			return false;
		} 
		$bindServerLDAP=@ldap_bind($connect,$dn,$password);
		if ($bindServerLDAP)
		{
			ldap_close($connect); 
			return true;
		}
		else
		{
			ldap_close($connect); 
			return false;
		}
	}

	public function infoCollection($username,$keys){
		
		$ds=ldap_connect($this->parameters['server'],$this->parameters['port']);  // doit �tre un serveur LDAP valide !
		if ($ds) 
		{
			$dn = $this->parameters['base_dn'];
			$filter=$this->parameters['account_suffix'].'='.$username;
			$sr=ldap_search($ds,$dn,$filter);  
			$info = ldap_get_entries($ds, $sr);
			ldap_close($ds);
			$ret = array();
			var_dump($keys);
			foreach($keys as $key){
				if(isset($info[0][$key][0])){
					$ret[$key] = $info[0][$key][0];
				}else{
					$ret[$key] = "";
				}
			}
			return $ret;
		} 
	}
}
