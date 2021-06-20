<main>
<h2> Entra </h2>

<?= form_open('go/controllaLogin') ?>
<p>
Nome <input type="text" name="nome">
</p>
<p>
Password <input type="password" name="password">
</p>
<p>
<input type="submit" name="entra" value="Entra" class="btn">
</p>
</form>
<p>
Se non ricordi la password puoi effettuare il 
<?= anchor('go/richiestaRecuperoPassword', 'recupero della password', ['class' => 'btn forgotpassword']) ?>
</p>
</main>
