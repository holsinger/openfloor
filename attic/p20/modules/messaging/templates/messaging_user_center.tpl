{config_load file=$messaging_lang_conf}

<img src="{$my_pligg_base}/templates/{$the_template}/images/user_message.png" align="absmiddle"/> <a href="#view_message" rel="view_message~!~view=small_msg_compose~!~login={$user_login}" class="lbOn">send a message</a>

{* this is a temporary fix. When you load a new config file the existing config gets dropped. *}
{config_load file="/libs/lang.conf"}