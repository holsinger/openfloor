<li>
  <div class="box" id="loginbox">
    <h1><span class="expand"><a id="explogin" class="expand-up"></a></span><a class="htitle">{#PLIGG_Visual_Login_Title#}</a></h1>
    <form action="{$URL_login}" method="post" class="login" id="loginform">
      <input type="text" name="username" class="text" value="" class="text" value="{$login_username}"  />
      <input type="password" name="password" class="text" />
      <input type="hidden" name="processlogin" value="1"/>
      <p class="left">
        <input type="submit" value="{#PLIGG_Visual_Login_LoginButton#}" class="submit" style="width:75px" />
      </p>
      <input type="hidden" name="return" value="{$templatelite.get.return}"/>
      <p class="right"> {#PLIGG_Visual_Login_Remember#}:
        <input type="checkbox" name="persistent" class="check" />
      </p>
      <br clear="all" />
      <p id="register"><a href="{$URL_register}">Register</a></p>
    </form>
  </div>
</li>