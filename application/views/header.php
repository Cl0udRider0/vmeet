<!DOCTYPE html>
<html>
<title> VMeet </title>
<link rel="stylesheet" href="<?= base_url('stile.css') ?>">

<body>
  <header>
    <?= img('images/logo.svg', false, ['class' => 'logo', 'style' => 'position: relative;top: 50px;']) ?>
  </header>
  <nav>
    <p id="utente">
      <?php if ($this->session->utente->nome == 'anonimo') :
        echo anchor('go/entra', 'Entra', ['class' => 'btn']);
        echo anchor('go/registrati', 'Registrati', ['class' => 'btn']);
      endif
      ?>
      <span class="btn username">
        Benvenuto <?= $this->session->utente->nome?>
      </span>
      &nbsp;
      <?php if ($this->session->utente->nome != 'anonimo') :
        echo anchor('go/esci', 'Log out', ['class' => 'btn logout']);
      endif
      ?>
    </p>
    <p id="other">
      <?= anchor('go/aboutus', 'Chi siamo', ['class' => 'btn']) ?>
      <?= anchor('user/settings', 'Impostazioni', ['class' => 'btn']) ?>
      <?= anchor('user/profile', 'Profilo', ['class' => 'btn']) ?>

    </p>
  </nav>