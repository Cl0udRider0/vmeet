<main>
<h2> Catalogo </h2>

<table>
<tr><th>ID</th><th>Nome</th></tr>

<?php foreach($articoli as $a): 
/*  per array userei  $a['id']   */
?>
<tr><td><?=$a->id?></td><td><?= anchor('go/dettaglio/'.$a->id, $a->nome)?></td></tr>     
<?php endforeach ?>
</table>
</main>