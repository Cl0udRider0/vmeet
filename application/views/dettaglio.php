<main>
<h2> Dettaglio Articolo </h2>

<p> <?= $articolo->id ?> 
    <?= $articolo->nome ?>
<br>
<?= img('images/'.$articolo->foto) ?>
<br>
Prezzo <?= $articolo->prezzo ?>  &euro;
</p>
<p> <?= anchor('go/mettiNelCarrello/'.$articolo->id,
        'Metti nel carrello') ?> </p>
		
<p> altro modo per mettere la merce nel carrello : FORM </p>

<?= form_open('go/mettiNelCarrello2') ?>
<input type="hidden" name="id" value="<?= $articolo->id ?>">		
<p> <input type="submit" name="submit" value="Metti nel carrello"></p>
</form>
		
<p> altro modo per mettere la merce nel carrello : AJAX BUTTON </p>
<!-- script src="/bici/jquery.min.js"></script -->
<script src="<?=base_url('jquery.min.js')?>"></script>
<script type="text/javascript">
function metti() 
{
var idbici = <?= $articolo->id ?>;
//http://[::1]/bici/index.php/go/mettiNelCarrello3",
// {id: idbici},
$.ajax({
   type: "POST",
   url: "<?= site_url('go/mettiNelCarrello3') ?>",  
   data: {id: idbici}, 
   dataType: "json",   
   success: function(risposta) {
	  //$("span#nbici").show();
	  $("span#nbici").html(risposta.numero); 
	  },
   error: function(richiesta, stato, errore){
      $("span#nbici").html("Errore: "+stato+" "+errore);
  }
});
}
</script>
<p> <button id="bottone" onclick="metti()"> Metti nel carrello </button> </p>				
</main>