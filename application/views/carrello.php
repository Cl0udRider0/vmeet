<main>
<h2> Carrello </h2>

<?php foreach($this->session->carrello  as $merce): ?>

<p><?= $merce->id ?> <?= $merce->nome ?> <?= $merce->prezzo ?>&euro;</p>

<?php endforeach ?>

<p> Totale =  <?= $totale ?>&euro; </p>

<p> <?= anchor('go/svuotaCarrello', 'Svuota il carrello') ?> </p>

<p><?= anchor('go/concludiOrdine', 'Concludi ordine') ?> </p>
<p> Le spese di trasporto sono sempre gratis! </p>
</main>