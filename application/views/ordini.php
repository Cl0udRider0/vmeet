<main>
<h2> Ordini </h2>

<table>
<tr><th>ID ordine</th><th>Nome Cliente</th><th>ID articolo</th><th>Nome Articolo</th><th>Prezzo</th><th>Data e Ora</th></tr>

<?php foreach($ordini as $o): 
/*  per array userei  $a['id']   */
?>
<tr><td><?=$o->idOrdine?></td>
<td><?=$o->nomeCliente?></td>
<td><?=$o->idArticolo?></td>
<td><?=$o->nome?></td>
<td><?=$o->prezzo?></td>
<td><?=$o->dataOra?></td>
</tr>     
<?php endforeach ?>
</table>
</main>