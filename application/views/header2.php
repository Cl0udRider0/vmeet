<!DOCTYPE html>
<html>
<title> VMeet </title>
<link rel="stylesheet" href="<?=base_url('stile.css')?>">

<body>
<header>
<h1> VMeet </h1>
</header>
<nav>
<p id="utente">
<?= anchor('go/entra', 'Entra')?>/ <?= anchor('go/registrati', 'Registrati') ?>
 &nbsp; Benvenuto 
<span>
<?= $this->session->utente->nome  ?> ( 
<?= $this->session->utente->ruolo  ?> )
</span>
&nbsp;
<?php foreach($menu as $m): 
  echo anchor($m->azione, $m->testo);
  endforeach
?>
</p>
<p>
<?= anchor('go/index', 'Pagina Iniziale') ?>
<?= anchor('go/faq', 'Domande Frequenti') ?>
<?= anchor('admin/riservato', 'Riservato') ?>

</p>
</nav>
