<main>
<h2> Registrazione </h2>

<p id="errore"> <?= validation_errors() ?> </p>

<?= form_open('go/registraUtente') ?>
<p>
Nome* <input type="text" name="nome" value="<?= set_value('nome')?>">
</p>
<p>
Password* <input type="password" name="password">
</p>
<p>
Ripeti Password* <input type="password" name="ripetipassword">
</p>
<p>
Ruolo <select name="ruolo">
<option value="utente" <?= set_select('ruolo','utente')?>> utente </option>
<option value="admin"  <?= set_select('ruolo','admin')?>> amministratore </option>
</select>
</p>
<p>
Email* <input type="text" name="email">
</p>
<p>
<input type="submit" name="registrati" value="Registrati">
</p>
</form>

<p> * campo obbligatorio </p>

</main>
