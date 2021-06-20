<?php
/**
 * This class will be called by the post_controller_constructor hook and act as ACL
 * 
 * @author ChristianGaertner (adattamento di Bandiera Roberto)
 */
class ACL {
    
    /**
     * Array to hold the rules
     * Keys are the role_id and values arrays
     * In this second level arrays the key is the controller and value an array with key method and value boolean
     * @var Array 
     */
    private $perms;
    /**
     * The field name, which holds the role_id
     * @var string 
     */
	 
    private $role_field;
    /**
     * Contstruct in order to set rules
     * @author ChristianGaertner  (adattato da Bandiera Roberto)
     */
	 
    public function __construct() {
	    $CI =& get_instance();
        $this->role_field = $CI->session->utente->ruolo; 
        
        // se l'acceso è consentito a tutti non occorre mettere nessuna regola
		//$this->perms['utente']['go']['index']     = true;   // è inutile
		//$this->perms['admin']['go']['index']     = true;   // è inutile
       
		// se si mette una regola di permesso per qualcuno
		// allora per tutti gli altri il permesso è automaticamente "false"
		// quindi non possono entrare
		        
        $this->perms['admin']['admin']['riservato']  = true;
       
		
		//$this->perms['ruolo']['controller']['metodo']  = true;
      
	  
	  }
    /**
     * The main method, determines if the a user is allowed to view a site
     * @author ChristianGaertner    (adattato da Bandiera Roberto)
     * @return boolean
     */
    public function auth()
    {
        $CI =& get_instance();
        
        if (!isset($CI->session))
        { # Sessions are not loaded
            $CI->load->library('session');
        }
        
        if (!isset($CI->router))
        { # Router is not loaded
            $CI->load->library('router');
        }
        
        
        $class = $CI->router->fetch_class();
        $method = $CI->router->fetch_method();
        // Is rule defined?
        $is_ruled = false;
        foreach ($this->perms as $role)
        { # Loop through all rules
            if (isset($role[$class][$method]))
            { # For this role exists a rule for this route
                $is_ruled = true;
            }
        }
        if (!$is_ruled)
        { # No rule defined for this route
            // ignoring the ACL
            return;
        }
        
        
        if ($this->role_field)
        { # Role_ID successfully determined
            if (isset($this->perms[$this->role_field][$class][$method]) && $this->perms[$this->role_field][$class][$method])
            { # The user is allowed to enter the site
                return true;
            }
            else
            { # The user does not have permissions
			    $message = 'Non hai il permesso di entrare qui!';
			    show_error($message, $status_code = '403', $heading = 'Errore di Accesso');
            }
        }
        /*else
        * Con le impostazioni attuali dell’applicazione, un utente
        * che non ha fatto il login è comunque ‘anonimo’
        * pertanto il ramo “else” non trova applicazione!!!
        { # not logged in
            if ($this->perms[0][$class][$method])
            { # The user is allowed to enter the site
                return true;
            }
            else
            { # The user does not have permissions
                $message = 'Non hai il permesso di entrare qui!';							
			    show_error($message, $status_code = '403', $heading = 'Errore di Accesso');
            }
        }
		*/
        
        
    }
}