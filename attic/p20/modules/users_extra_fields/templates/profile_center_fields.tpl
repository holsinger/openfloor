
	{section name=fields loop=$users_extra_fields_field}
		{if $users_extra_fields_field[fields].show_to_user eq TRUE}
			
			<tr><td><label for="name" accesskey="1">{$users_extra_fields_field[fields].show_to_user_text}</label></td>
			
			<td><input type="text" name="{$users_extra_fields_field[fields].name}" id="{$users_extra_fields_field[fields].name}" tabindex="1" value="{$users_extra_fields_field[fields].value}"></td>
			<td><label for="name" accesskey="1">{$users_extra_fields_field[fields].show_to_user_text_2}</label></td>
			
			</tr>
			
		{/if}
	{/section}	
