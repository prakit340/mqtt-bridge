<form onsubmit="" method="post">
<p>
<div><label for="user">User: </label></div>
<div><input type="text" name="user" id="user" value="<?php echo $user; ?>"/></div>
</p>
<p>
<div><label for="pass">Password: </label></div>
<div><input type="password" name="pass" id="pass"></div>
</p>
<p>
<div><label for="topic">Topic: </label></div>
<div><input type="text" name="topic" id="topic" value="<?php echo $topic; ?>"></div>
</p>
<p>
<div><label for="value">Value: </label></div>
<div><input type="text" name="value" id="value" value="<?php echo $value; ?>"></div>
</p>
<p>
<div><label for="retain">Retain message: </label></div>
<div><input type="checkbox" name="retain" id="retain" <?php echo ($retain) ? 'checked' : ''; ?>></div>
</p>
<p>
<div><label for="allow_spaces">Allow spaces in topic names: </label></div>
<div><input type="checkbox" name="allow_spaces" id="allow_spaces" <?php echo ($allow_spaces) ? 'checked' : ''; ?>></div>
</p>
<p><div><input type="submit" name="submit" value="publish"></div></p>
