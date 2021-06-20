<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
 
    // campo con l'elenco dei comandi
	private $comandi = [
	'getCatalogo' => 'Restituisce il catalogo degli articoli', 
	'getDettaglio/<n>' => "Restituisce il dettaglio dell'articolo <n>", 
	'msgTelegram/<testo>' => 'Invia un messaggio Telegram con il <testo> specificato'
	]; 
	 
	 
	public function index()
	{   
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($this->comandi));
	}
	
	public function help()
	{   
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($this->comandi));
	}
	
	public function getCatalogo()
	{
		$appo = $this->negozio_model->get_articoli();
	    //echo json_encode($appo);
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($appo));
	}
	
	public function getDettaglio($id)
	{
		$appo = $this->negozio_model->get_articolo($id);
		//echo json_encode($appo);
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($appo));  
	}
	
	/*
	public function getFoto()
	{  
	   //echo file_get_contents('license.txt');
	   $this->output->set_content_type('image/jpeg');  // vedi anche config/mimes.php
       $this->output->set_output(file_get_contents('telegram.jpg'));
	}
	*/
		
	//////////  telegram //////////////
	// This function send a Telegram message
	// it uses @VessilloBot
    public function msgTelegram($testo) 
    { 
    	// poichè il testo proviene da un browser, gli spazi arrivano codificati con %20
        // pertanto ripristiniamo gli spazi con urldecode()
 					$messaggio=urldecode($testo);					
                    $botToken = "555070069:AAG8IS4Bzctni3PTjZ2j6IYFdyQclxxxxxx";
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
    }
}
?>
