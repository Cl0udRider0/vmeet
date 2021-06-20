<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2018, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2018, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['email_must_be_array'] = "La validazione dell\'e-mail richiede un array di parametri.";
$lang['email_invalid_address'] = "Indirizzo e-mail non valido: %s";
$lang['email_attachment_missing'] = "Allegato non trovato: %s";
$lang['email_attachment_unreadable'] = "Allegato illeggibile: %s";
$lang['email_no_from'] = "Mail senza mittente: From";
$lang['email_no_recipients'] = "Manca il destinatario della mail: To, Cc, or Bcc";
$lang['email_send_failure_phpmail'] = "Impossibile inviare la mail con PHP mail. Il server potrebbe non essere stato configurato per inviare mail.";
$lang['email_send_failure_sendmail'] = "Impossibile inviare la mail con Sendmail. Il server potrebbe non essere stato configurato per inviare mail.";
$lang['email_send_failure_smtp'] = "Impossibile inviare la mail con SMTP. Il server potrebbe non essere stato configurato per inviare mail.";
$lang['email_sent'] = "Messaggio inviato con il protocollo: %s";
$lang['email_no_socket'] = "Impossibile aprire una connessione per Sendmail. Controlla le impostazioni.";
$lang['email_no_hostname'] = "Server SMTP non specificato.";
$lang['email_smtp_error'] = "Errore SMTP: %s";
$lang['email_no_smtp_unpw'] = "Errore: SMTP richiede nome utente e password.";
$lang['email_failed_smtp_login'] = "Fallimento del comando AUTH LOGIN. Errore: %s";
$lang['email_smtp_auth_un'] = "Autenticazione del nome utente fallita. Errore: %s";
$lang['email_smtp_auth_pw'] = "Autenticazione della password fallita. Errore: %s";
$lang['email_smtp_data_failure'] = "Impossibile inviare i dati: %s";
$lang['email_exit_status'] = "Codice di terminazione: %s";
?>
