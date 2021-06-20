<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Go extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/go
	 *	- or -
	 * 		http://example.com/index.php/go/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 
	 
	public $data;   // campo per il menu personalizzato
	 
	public function __construct()
	{
		parent::__construct();
		//$this->load->model('negozio_model');
		
		// se non c'è l'utente lo creo anonimo
		if (!isset($this->session->utente))
	    {
			$utente_anonimo = new stdClass();
			$utente_anonimo->nome = 'anonimo';
			$utente_anonimo->ruolo = 'utente';
			
			$this->session->utente = $utente_anonimo;
		}
		// se non c'è il carrello lo creo vuoto
		if (!isset($this->session->carrello))
		{
			$carrello = array();
			$this->session->carrello = $carrello;
		}
		
		
		// imposto il menu
		$menu = array();
		$this->load->helper('MenuItem');
		if ($this->session->utente->nome != 'anonimo')
		{
		    $menu[] = new MenuItem('Esci', 'go/esci'); 
			$menu[] = new MenuItem('Miei Ordini','go/elencoMieiOrdini');
		}
		$this->data['menu'] = $menu;
		
		// scrivo nel file di LOG
		log_message('custom', $_SERVER["REMOTE_ADDR"].'  '.$this->session->utente->nome.'  '.$_SERVER['REQUEST_URI']);
	}	
	 
	public function index()
	{   
	    // versione alternativa 
		// $this->load->view('header2', $this->data);
		$this->load->view('header');
		$this->load->view('home');
		$this->load->view('footer');
	}
	
	public function provaRTF()
	{
	  $data='{\rtf
    Ciao!\par
    Ecco del testo in {\b grassetto}.\par
     }';
    force_download('prova.rtf', $data); 

	}
	
	public function provaCSV()
	{
	  $array_articoli = $this->negozio_model->get_articoli();
	  // uso le virgolette per delimitare la stringa "..."
      // per avere la corretta interpretazione dei caratteri speciali
      // se invece si usano gli apici singoli '...' 
      // i caratteri speciali non vengono interpretati
      // ma riscritti così come sono	  
	  $data="id;nome;prezzo\r\n";
	  foreach($array_articoli as $articolo)
	  {
	     $data = $data.$articolo->id.";".$articolo->nome.";".$articolo->prezzo."\r\n";
	  }   
      force_download('catalogo.csv', $data); 
	}
	
	
	public function faq()
	{
		$this->load->view('header');
		$this->load->view('faq');
		$this->load->view('footer');
	}
	
	public function download($doc)
	{	// ad esempio $doc = 'istruzioni.docx'
		force_download('documents/'.$doc, NULL);
		// rimango nella pagina dove sono		
	}
	
	public function catalogo()
	{
		$data['articoli'] = $this->negozio_model->get_articoli();
		$this->load->view('header');
		$this->load->view('catalogo', $data);
		$this->load->view('footer');
	}
	
	public function dettaglio($id)
	{
		$appo = $this->negozio_model->get_articolo($id);
		// siccome potrebbe non esserci l'articolo cercato
		// e' meglio dirlo all'utente
		if (isset($appo))
		{  //SCENARIO PRINCIPALE
			$data['articolo'] = $appo;
			$this->load->view('header');
			$this->load->view('dettaglio', $data);
			$this->load->view('footer');
		}
		else
		{ //SCENARIO ALTERNATIVO
		  // L'ARTICOLO NON ESISTE
		  $data['messaggio'] = "L'articolo non esiste!";
		  $this->load->view('header');
		  $this->load->view('errore', $data);
		  $this->load->view('footer');
		}
	}

	
    public function entra()
    {
		// conviene controllare che la pagina
		// viaggi in modo protetto con HTTPS
		//if(is_https())
		//{
		  $this->load->view('header');
		  $this->load->view('login');
		  $this->load->view('footer');		
		//}
        //else
		//{
		//	redirect('https://localhost/bici/index.php/go/entra');
		//}		
	}	

	
	public function controllaLogin()
	{
		// acquisisco i dati del form
		$nome = $this->input->post('nome');
		$password = $this->input->post('password');
				
	    $utente = $this->negozio_model->get_utente($nome, $password);
        
		// controllo se l'utente c'è per davvero	
		if (isset($utente))
		{
			// ok l'utente c'è
			// assegno l'utente ad una variabile di sessione
			$this->session->utente = $utente;
			$this->load->view('header');
		    $this->load->view('home');
		    $this->load->view('footer');
			
		}
	    else
		{
		  // utente inesistente
		  // allora mostro un messaggio di errore
		  $data['messaggio'] = "L'utente non è stato riconosciuto!";
		  $this->load->view('header');
		  $this->load->view('errore', $data);
		  $this->load->view('footer');
		}
	}
	
	public function esci()
	{
	   $this->session->sess_destroy();
	   redirect('go/index');  // va alla pagina index
	}


    public function riservato()
	{
		if ($this->session->utente->ruolo == 'admin')
		{
			// ok sei amministratore
			$this->load->view('header');
		    $this->load->view('riservato');
		    $this->load->view('footer');
		}
		else
		{
			// non sei amministratore
			// allora mostro un messaggio di errore
		    $data['messaggio'] = "Pagina riservata
		    all'amministratore: <br> 
		    fare l'accesso come amministratore!";
		    $this->load->view('header');
		    $this->load->view('errore', $data);
		    $this->load->view('footer');
		}
		
		
	}

    public function carrello()
	{
		$totale = 0;
		foreach ($this->session->carrello as $merce)
		{
		    $totale = $totale + $merce->prezzo;
		}	
		$data['totale'] = $totale;
		
		$this->load->view('header');
		$this->load->view('carrello',$data);
		$this->load->view('footer');
	}

	public function mettiNelCarrello($id)   // con LINK
	{
		$appo = $this->negozio_model->get_articolo($id);
		// siccome potrebbe non esserci l'articolo cercato
		// e' meglio dirlo all'utente
		if (isset($appo))
		{  //SCENARIO PRINCIPALE
			$merce = new stdClass();  // creo l'oggetto
			$merce->id = $appo->id;
			$merce->nome = $appo->nome;
			$merce->prezzo = $appo->prezzo;
			// prelevo il carrello dalla sessione
			$carrello = $this->session->carrello;
			$carrello[] = $merce;  // aggiungo la merce
			// aggiorno il carrello (variabile di sessione)
			$this->session->carrello = $carrello;
						
			//$this->load->view('header');
			//$this->load->view('carrello');
			//$this->load->view('footer');
			$this->carrello();
		}
		else
		{ //SCENARIO ALTERNATIVO
		  // L'ARTICOLO NON ESISTE
		  $data['messaggio'] = "L'articolo non esiste!";
		  $this->load->view('header');
		  $this->load->view('errore', $data);
		  $this->load->view('footer');
		}		
	}
	
	public function mettiNelCarrello2()   // con FORM
	{
		$id = $this->input->post('id');  // leggo l'input del form
		$appo = $this->negozio_model->get_articolo($id);
		// siccome potrebbe non esserci l'articolo cercato
		// e' meglio dirlo all'utente
		if (isset($appo))
		{  //SCENARIO PRINCIPALE
			$merce = new stdClass();  // creo l'oggetto
			$merce->id = $appo->id;
			$merce->nome = $appo->nome;
			$merce->prezzo = $appo->prezzo;
			// prelevo il carrello dalla sessione
			$carrello = $this->session->carrello;
			$carrello[] = $merce;  // aggiungo la merce
			// aggiorno il carrello (variabile di sessione)
			$this->session->carrello = $carrello;
			//$this->load->view('header');
			//$this->load->view('carrello');
			//$this->load->view('footer');
			$this->carrello();
		}
		else
		{ //SCENARIO ALTERNATIVO
		  // L'ARTICOLO NON ESISTE
		  $data['messaggio'] = "L'articolo non esiste!";
		  $this->load->view('header');
		  $this->load->view('errore', $data);
		  $this->load->view('footer');
		}	
	}
	
	
	////////// ajax //////////////
	// This function call from AJAX	
	public function mettiNelCarrello3()   // con AJAX
	{ 
	    //header('Access-Control-Allow-Origin: *');
		$id = $this->input->post('id');  // leggo l'input del form
		$appo = $this->negozio_model->get_articolo($id);
		
		if (isset($appo))
		{  
		    //SCENARIO PRINCIPALE		    
			$merce = new stdClass();  // creo l'oggetto
			$merce->id = $appo->id;
			$merce->nome = $appo->nome;
			$merce->prezzo = $appo->prezzo;
			// prelevo il carrello dalla sessione
			$carrello = $this->session->carrello;
			$carrello[] = $merce;  // aggiungo la merce
			// aggiorno il carrello (variabile di sessione)
			$this->session->carrello = $carrello;			
		}
        // conto le merci presenti nel carrello
		// e le restituisco come oggetto JSON
	    $carrello = $this->session->carrello;
		//$data = array( "numero" => count($carrello));
		$data['numero'] = count($carrello);	
	    //echo json_encode($data);
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($data));  
		}

	
	public function svuotaCarrello()
	{
		$this->session->carrello = array();
		//$this->load->view('header');
		//$this->load->view('carrello');
		//$this->load->view('footer');
		$this->carrello();
	}
	
	public function concludiOrdine()
	{
		if($this->session->utente->nome != 'anonimo')
		{
			$nomecliente = $this->session->utente->nome;
			// ok si può fare l'ordine
			$carrello = $this->session->carrello;
			if (count($carrello) > 0)
			{
				// ok ci sono merci nel carrello
				$errore = $this->negozio_model->inserisci_ordine($nomecliente, $carrello);
				if (isset($errore))
			    {   // scenario alternativo: errore database
			        $data['messaggio'] = $errore;		
                    $this->load->view('header');
                    $this->load->view('errore', $data);
                    $this->load->view('footer');					
		        }
				else
				{   // scenario principale
					// tutto OK
					
					/****  Invio una notifica Telegram*/
					$messaggio="Hai appena ricevuto un ordine!\n da ".$nomecliente;					
                    $botToken = "555070069:AAG8IS4Bzctni3PTjZ2j6IYFdyxxxxxxxxx";
                    $website="https://api.telegram.org/bot".$botToken;
                    $chatID=390360000;  //Receiver Chat Id 
                    $params=[
                        'chat_id'=>$chatID,
                        'text'=>$messaggio,
                            ];
                    $ch = curl_init($website.'/sendMessage');
                    curl_setopt($ch, CURLOPT_HEADER, false);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                    curl_setopt($ch, CURLOPT_POST, TRUE);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    $result = curl_exec($ch);
                    curl_close($ch);
					/*********************************/
					
					$data['messaggio'] = 'ORDINE EFFETTUATO CON SUCCESSO!';		
                    $this->load->view('header');
                    $this->load->view('conferma', $data);
                    $this->load->view('footer');
				}				
			}
			else
			{   // scenario alternativo: carrello vuoto
				$data['messaggio'] = "Prima di concludere l'ordine 
				           devi riempire il carrello!";		
                $this->load->view('header');
                $this->load->view('errore', $data);
                $this->load->view('footer');
			}		
		}
		else
		{   // scenario alternativo: non hai fatto il login
			$data['messaggio'] = "Per effettuare l'ordine 
				           devi accedere come utente!";		
            $this->load->view('header');
            $this->load->view('errore', $data);
            $this->load->view('footer');
		}
	}
	
	
	
	
	public function elencoMieiOrdini()
	{
		if($this->session->utente->nome != 'anonimo')
		{
		    // scenario principale
			$nomecliente = $this->session->utente->nome;
			// ok si può fare 
			$data['ordini'] = $this->negozio_model->get_ordini($nomecliente);
			$this->load->view('header');
            $this->load->view('ordini', $data);
            $this->load->view('footer');							
		}
		else
		{   
		    // scenario alternativo: non hai fatto il login
			$data['messaggio'] = "Devi prima fare l'accesso come utente!";		
            $this->load->view('header');
            $this->load->view('errore', $data);
            $this->load->view('footer');
		}
	}
	
	
	
	
	public function registrati()
	{
		$this->load->view('header');
        $this->load->view('registrazione');
        $this->load->view('footer');
	}
	
	
	public function registraUtente()
	{
		// acquisizione degli input dal form
		$nome = $this->input->post('nome');  // $nome = $_POST['nome']
		$password = $this->input->post('password');
		$ripetipassword = $this->input->post('ripetipassword');
		$ruolo = $this->input->post('ruolo');
		$email = $this->input->post('email');
		// regole di validazione del form
		$this->form_validation->set_rules('nome', 'Nome', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
		$this->form_validation->set_rules('ripetipassword', 'Ripeti Password', 'required|matches[password]');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		if ($this->form_validation->run() == FALSE)
		{  // scenario alternativo: qualche regola non è stata rispettata
	       // ritorno al form
		   $this->load->view('header');
           $this->load->view('registrazione');
           $this->load->view('footer');	
		}
		else
		{
			$errore = $this->negozio_model->inserisci_utente($nome, $password, $ruolo, $email);
			if (isset($errore))
			    {   // scenario alternativo: errore database
			        $data['messaggio'] = $errore;		
                    $this->load->view('header');
                    $this->load->view('errore', $data);
                    $this->load->view('footer');					
		        }
				else
				{   // scenario principale
					// tutto OK
                    // invio di una mail di conferma
			        $this->email->from('xxxxx@tiscali.it', 'Admin');
                    $this->email->to($email);
                    $this->email->subject('Conferma registrazione Go');
                    $testo = '<p>clicca sul seguente link per  
					   <a href="http://localhost/bici/index.php/go/confermaMail/'.$nome.'">
					   confermare la registrazione</a></p>';
			        $this->email->message($testo);
                    $this->email->send();
			   /*  debug
			   if ($this->email->send()) 
			   {
                   echo 'Your email was sent';
               } 
			   else 
			   {
                   show_error($this->email->print_debugger());
               }*/
			  
		      // fine mail
		      $data['messaggio'] = 'REGISTRAZIONE EFFETTUATA CON SUCCESSO!<br>
			                        Riceverai una mail per effettuare la conferma!';	
     		  $this->load->view('header');
		      $this->load->view('conferma', $data);
		      $this->load->view('footer');
		   }
		}   
	}
	
	
	public function confermaMail($nome)
	{
	        $errore = $this->negozio_model->conferma_utente($nome);
			if (isset($errore))
			    {   
				    // scenario alternativo: errore database
			        $data['messaggio'] = $errore;		
                    $this->load->view('header');
                    $this->load->view('errore', $data);
                    $this->load->view('footer');					
		        }
				else
				{   
				    // scenario principale			  
		            $data['messaggio'] = 'UTENTE '.$nome.' CONFERMATO CON SUCCESSO!';	    
	 		        $this->load->view('header');
		            $this->load->view('conferma', $data);
		            $this->load->view('footer');
	            }
	}
	
	
	
	public function richiestaRecuperoPassword()
	{
			        $this->load->view('header');
		            $this->load->view('recupero');
		            $this->load->view('footer');
	}
	
	public function recuperaPassword()
	{   
    	// acquisizione degli input dal form
		$nome = $this->input->post('nome');  
		$email = $this->input->post('email');
		// leggo nel database i dati dell'utente, in particolare
		// mi interessa la sua password
		$utente = $this->negozio_model->get_password($nome, $email);
        if (isset($utente))
		{  
		   // scenario principale
		   $hash = $utente->hash; // variabile di appoggio
		   // invio una mail per chiedere conferma
		   $this->email->from('xxxxxx@tiscali.it','Admin'); //('admin@azienda.it', 'Admin');
           $this->email->to($email);
           $this->email->subject('Conferma richiesta di recupero password');
           $testo = '<p>clicca sul seguente link per '.
                    '<a href="http://localhost/bici/index.php/go/rigeneraPassword/'.
			        $nome.'/'.urlencode($email).'/'.$hash.'">'. // si deve sostituire @ con %40
				    'confermare la richiesta di recupero della password</a></p>';
		   $this->email->message($testo);
           $this->email->send();
		   // debug		
		   //if ($this->email->send()) {
           //   echo 'Your email was sent';
           //   } 
		   //   else {
		   //   //show_error($this->email->print_debugger(array('headers')));
           //   show_error($this->email->print_debugger());
           //}
		   // fine debug   
			
		   $data['messaggio'] = 'Riceverai a breve una mail per confermare la richiesta di Recupero della Password!';	
    
	 	   $this->load->view('header');
		   $this->load->view('conferma', $data);
		   $this->load->view('footer');
		}
		else // scenario alternativo: dati errati
		{
		    $data['messaggio'] = 'IL NOME o LA EMAIL SONO ERRATI!';	
            $this->load->view('header');
	        $this->load->view('errore', $data);
	        $this->load->view('footer');    
		}
	}
	
	public function rigeneraPassword($nome, $email, $hash)
	{   
	    $email = urldecode($email);  // sostituisce %40 con @
	    $messaggio = $this->negozio_model->genera_nuova_password($nome, $email, $hash);
		
	    // invio una mail con il messaggio
	    // contenente la nuova password 
	    // oppure un messaggio di errore
	    $this->email->from('xxxxx@tiscali.it', 'Admin');//('admin@azienda.it', 'Admin');
        $this->email->to($email);
        $this->email->subject('Invio nuova password');
        $testo = '<p>'.$messaggio.'</p><p>Clicca sul seguente link per '.
                 '<a href="http://localhost/bici/index.php/go/entra/">'. 
		         'effettuare l\'accesso</a></p>';
	    $this->email->message($testo);	  
        $this->email->send();
		// debug		
		//if ($this->email->send()) 
		//{
        //    echo 'Your email was sent';
        //} 
      	//else 
		//{
		//   //show_error($this->email->print_debugger(array('headers')));
        //   show_error($this->email->print_debugger());
        //}
		// fine debug   
			
	    $data['messaggio'] = 'Riceverai a breve una mail con la nuova password!';
        $this->load->view('header');
	    $this->load->view('conferma', $data);
	    $this->load->view('footer');
	}

}
?>