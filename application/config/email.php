<?php


$config['useragent'] = 'CodeIgniter';
$config['protocol']    = 'smtp';
        $config['smtp_host']    = 'localhost'; // 'smtp.tiscali.it';    
        $config['smtp_port']    = '25'; //587'; // '465';    
        $config['smtp_timeout'] = 5;
        $config['smtp_user']    = 'admin'; //'admin@azienda.it';
        $config['smtp_pass']    = 'admin';
		//$config['starttls']  = TRUE;
        $config['charset']    = 'utf-8';  // 'iso-8859-1';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'html'; //'text'; // or html
        //$config['validate'] = FALSE; //TRUE; // bool whether to validate email or not      

		$config['wordwrap'] = TRUE;
		$config['wrapchars'] = 76;
        

// non serve
// $this->email->initialize($config);


?>