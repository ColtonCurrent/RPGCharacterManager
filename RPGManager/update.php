<h1>Update Your Character:</h1>
<form method="POST">
    <label>Character Name: </label><input type="text" name="charName" value="<?php echo $charName; ?>" required><br>
    <label>Character Level: </label><input type="number" name="charLevel" value="<?php echo $charLevel; ?>" min="0" max="25" step="1" required><br>
    <label>Character Class: </label><input type="text" name="charClass" value="<?php echo $charClass; ?>" required><br>
    <input type="submit" value="Update">
</form>