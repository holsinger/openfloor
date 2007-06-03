<fieldset><legend>Disable User</legend>
<table style="border:none" cellspacing="5">

<tr>
    <td>Are you sure you want to "disable" this user and prevent them from logging in?</td>
</tr>


<tr>
    <td><input type=button onclick="window.history.go(-1)" value="No, cancel" class="log2">	
	<a href = "admin_users.php?mode=yesdisable&user={$user}">Yes, disable this user.</a></td>
</tr>

<tr>
    <td><strong>A disabled user will be "logged out" if they are currently "logged in."</strong></td>
</tr>

</table>
</fieldset>