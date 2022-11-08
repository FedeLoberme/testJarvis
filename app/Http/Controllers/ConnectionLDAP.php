<?php
namespace Jarvis\Http\Controllers;
use Illuminate\Http\Request;

class ConnectionLDAP extends Controller
{
   public static function Ldap($person, $ldappass){
		//Variables para autenticacion y busqueda de atributos
		$ldaprdn  = 'CN='.$person.',OU=Administradores,OU=Corporativos,OU=Usuarios de CTI,DC=ctimovil,DC=net';   // String de autenticación con informacion del "Arbol"
		$justthese = array("cn", "displayName", "extensionAttribute2", "extensionAttribute7", "department", "mail","sn", "givenname"); // Atributos solicitados al Active Directory
		$filter="(CN=$person*)"; //Valor a Buscar en A.D. para obtener los atributos

		// conexión al servidor LDAP
		@$ldapconn = ldap_connect("ldap.claro.amx")  
		    or die("Could not connect to LDAP server.");

		if (!empty($ldapconn)) { // si se pudo conectar....
		    
		    @$ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);//realizando la autenticación
		    if ($ldapbind != true) {
		    	$ldaprdn  = 'CN='.$person.',OU=Usuarios,OU=Corporativos,OU=Usuarios de CTI,DC=ctimovil,DC=net';
		    	@$ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);
		    }
		    if ($ldapbind) { // verificación del enlace
		      //  echo "LDAP bind successful...";  // Linea para debugging. Informa si se conecto 
				$sr=ldap_search($ldapconn, $ldaprdn, $filter, $justthese);	// Busqueda en A.D. . Se pasa conexión, String de usuario autenticado, para a buscar, y atributos solicitados
				
				$info = ldap_get_entries($ldapconn,$sr); // Pasa al Array info los atributos devueltos. Nombre, Grupo, mail, etc...
				if (!empty($info[0]['extensionattribute2'])) {
					$img = $info[0]['extensionattribute2'][0];
				}else{
					$img = 'https://logodownload.org/wp-content/uploads/2014/02/claro-logo1.png';
				}
				$workgroup = 'Vacio';
			   if(!empty($info[0]['extensionattribute7'][0])){
			    	$workgroup = utf8_encode($info[0]['extensionattribute7'][0]);
			   }
				$name_full = $info[0]['displayname'][0];
			    $divi = explode(" ", $name_full);
				if(!isset($info[0]['department'][0])){
					$department = 'Vacio';
				}else{
					$department = utf8_encode($info[0]['department'][0]);
				};
			    $name = $info[0]['givenname'][0];
			    $last_name = utf8_encode($info[0]['sn'][0]);
			    $user = utf8_encode($info[0]['cn'][0]);
			    $email = utf8_encode($info[0]['mail'][0]);
			    $data = array(
			    	'workgroup' => $workgroup,
			    	'img' => $img,
			    	'department' => $department,
			    	'name' => $name,
			    	'last_name' => $last_name,
			    	'user' => $user,
			    	'email' => $email,
			    	'exists' => 10,
			    );
		    } else {
				$data = array(
			    	'exists' => '30',
			    );
				// Aqui va el codigo para el caso de que falle la autenticación
		    }

			ldap_close($ldapconn); // Cierre de conexion a LDAP

		}else{
				$data = array(
			    	'exists' => '50',
			    );// no hay conexión
		}
		return $data;
	}
}