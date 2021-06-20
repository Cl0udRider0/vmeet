<?php

// classe che contiene i metodi
// CRUD per accedere al database
//
// CRUD = Create Retrieve Update Delete
class Negozio_model extends CI_model
{
	public function __construct()
	{
		parent::__construct();
	    // apro il database
		//$this->load->database();
		// imposta i messaggi in italiano
		$this->db->query("SET lc_messages = 'it_IT'");
	}
	
	// mio primo metodo CRUD
	public function get_articoli()
	{
		$query = $this->db->query("select * from articoli order by id");
		return $query->result(); // array di oggetti
		// return $query->result_array(); // array di array
	}
	
	public function get_ordini($nomecliente)
	{
		$query = $this->db->query("select ordini.id as idOrdine, nomeCliente, idArticolo, articoli.nome,
                                   ordini.prezzo, dataOra
								   from ordini inner join articoli 
		                           on ordini.idArticolo = articoli.id 
								   where nomeCliente = ? 
								   order by ordini.id", array($nomecliente));
		return $query->result(); // array di oggetti
		// return $query->result_array(); // array di array
	}
	
	
	public function get_articolo($id)
	{
		$query = $this->db->query("select * from articoli where id=?", array($id));
		return $query->row();  // oggetto o null
	}

    public function get_utente($nome, $password)
    {
		$query = $this->db->query("select * 
		                         from utenti
							where nome = ? and password = ?",
								 array($nome, $password));
		return $query->row();  // oggetto o null
	}	
	
	// usato per il recupero della password
	public function get_password($nome, $email)
    {
		$query = $this->db->query("select * 
		                         from utenti
							where nome = ? and email = ?",
								 array($nome, $email));
		return $query->row();  // oggetto o null
	}

	// funzione di servizio per generare una password casuale
    private function random($lunghezza)	
	{
 $caratteri = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
 $stringa = "";
 for($i=0; $i<$lunghezza; $i++)
 {
   $stringa = $stringa . substr($caratteri, rand(0,strlen($caratteri)-1), 1);	
 }
 return $stringa;
}

    // effettua la generazione di una nuova password e la registra nel database 
    public function genera_nuova_password($nome, $email, $hash)
	{
	     $messaggio = '';
	     $nuovaPassword = $this->random(8);  // di 8 caratteri
		 $nuovoHash = md5($nuovaPassword);
		 $sql = 'update utenti
		         set password = ?, hash = ?
				 where nome = ? and email = ? and hash = ?';
			$this->db->query($sql, array($nuovaPassword, $nuovoHash, $nome, $email, $hash));				
		    $e = $this->db->error();  // array 'code' 'message'
			if ($e['code'] != 0)
			{	
				 $messaggio = 'ERRORE: '. $e['message'];
		    }		 
			else if ($this->db->affected_rows() == 0)
			{	
				 $messaggio = 'ERRORE: utente non trovato!';
		    }		 
			else
			{
			     $messaggio = "La nuova password è " . $nuovaPassword;
			}
	     return $messaggio;
	}

	
	
	public function inserisci_ordine($nomecliente, $carrello)
	{
		$messaggioDiErrore = NULL;
		$ultimo_id = 0;
		// transazione per inserire tutte le righe dell'ordine
		$this->db->trans_start();  // BEGIN TRANSACTION
		foreach($carrello as $merce)
		{
			$sql = 'INSERT INTO ORDINI(NOMECLIENTE, IDARTICOLO, PREZZO)
			        VALUES(?, ?, ?)';
			$this->db->query($sql, array($nomecliente, $merce->id, $merce->prezzo));				
		    $e = $this->db->error();  // array 'code' 'message'
			if ($e['code'] != 0)
			{	
				 $messaggioDiErrore = $e['message'];
		    }		 
			// $ultimo_id = $this->db->insert_id();  echo $ultimo_id;
		}
		$this->db->trans_complete();  // COMMIT
		
		// ritorno l'eventuale messaggio di errore fornitomi dal server
		return $messaggioDiErrore;
	}
	
	
	public function inserisci_utente($nome, $password, $ruolo, $email)
	{
		$messaggioDiErrore = NULL;
		$sql = 'INSERT INTO UTENTI(NOME, PASSWORD, RUOLO, EMAIL) VALUES(?,?,?,?)';
		$this->db->query($sql, array($nome, $password, $ruolo, $email));
		$e = $this->db->error();  // array 'code' 'message'
		if ($e['code'] != 0)
		{
			$messaggioDiErrore = $e['message'];
		}
		return $messaggioDiErrore;
	}
	
	public function conferma_utente($nome)
	{
	    $messaggioDiErrore = NULL;
	    $sql = 'UPDATE UTENTI SET CONFERMATO = "si" WHERE NOME = ?';
		$this->db->query($sql, array($nome));
		$e = $this->db->error();
		if ($e['code'] != 0)
		{
		   $messaggioDiErrore = $e['message'];
		}
		return $messaggioDiErrore;
	}
}
?>


