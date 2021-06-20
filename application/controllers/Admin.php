<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

// funzioni esclusive per l'amministratore
		 
	public function __construct()
	{
		parent::__construct();
		
		// se non c'è l'utente lo creo anonimo
		if (!isset($this->session->utente))
	    {
			$utente_anonimo = new stdClass();
			$utente_anonimo->nome = 'anonimo';
			$utente_anonimo->ruolo = 'utente';
			
			$this->session->utente = $utente_anonimo;
		}		
		log_message('custom', $_SERVER["REMOTE_ADDR"].'  '.$this->session->utente->nome.'  '.$_SERVER['REQUEST_URI']);
	}	
	 
	public function index()
	{   
		$this->load->view('header');
		$this->load->view('home');
		$this->load->view('footer');
	}

    public function riservato()
	{
			$this->load->view('header');
		    $this->load->view('riservato');
		    $this->load->view('footer');
	}
	
}
?>