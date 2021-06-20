<?php

class MenuItem
{
   // classe che rappresenta un elemento del menu
   public $testo;
   public $azione;
   
   public function __construct($unTesto, $unaAzione)
   {
       $this->testo = $unTesto;
	   $this->azione = $unaAzione;
   }
}

?>
