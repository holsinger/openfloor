{if $the_template eq "mollio-beat" || $the_template eq "paul01"}

<div class="featurebox">	
	<h3>Random Story</h3>	
		{if $random_story_randstoryurl neq ""}
			<a href = "{$random_story_randstoryurl}">Random Story</a>
		{else}
			There are no published stories!
		{/if}	
</div>

{elseif $the_template eq "digitalnature"}

<li>
  <div class="box" id="loggedinbox">
    <div class="box2" id="loggedin">
      <div class="wrap">
        <div class="content">
          <div style="padding:10px 6px;">
            <h3>Random Story</h3>
	<div id=random_story class=switchcontent style="font-size:11px;">
		{if $random_story_randstoryurl neq ""}
			<a href = "{$random_story_randstoryurl}">Random Story</a>
		{else}
			There are no published stories!
		{/if}
	 </div>
        </div>
      </div>
    </div>
  </div>

</li>
{elseif $the_template eq "yget"}

<div class="featurebox">	
<div class="tlb">
{php}
	echo "<span><a onclick=\"new Effect.toggle('randomstory','blind', {queue: 'end'}); \"> <img src=\"".my_pligg_base."/templates/yget/images/expand.png\"  onClick=expandcontent(this,'randomstory') ></a></span>";
{/php}

<a href="#">Random Story</a>

</div>

<div id="randomstory">
<div class="tog">
		{if $random_story_randstoryurl neq ""}
			<a href = "{$random_story_randstoryurl}">Random Story</a>
		{else}
			There are no published stories!
		{/if}	
</div>

</div>
</div>

{/if}