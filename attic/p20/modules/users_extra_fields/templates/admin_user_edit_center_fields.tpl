{section name=fields loop=$users_extra_fields_field}
	{if $users_extra_fields_field[fields].show_to_admin eq TRUE}
		<tr>
			<td>{$users_extra_fields_field[fields].show_to_admin_text}</td>
			<td><input size="1" name="{$users_extra_fields_field[fields].name}" value="{$users_extra_fields_field[fields].value}"></td>
		</tr>	
	{/if}
{/section}	
