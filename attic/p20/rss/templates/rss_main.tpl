{* get a list of feeds in the database and put them into smarty varliable "FeedList" *}
{feedsListFeeds varname=FeedList}

{literal}
	<style type="text/css">
		.eip_editable { background-color: #ff9; padding: 3px; }
		.eip_savebutton { background-color: #36f; color: #fff; }
		.eip_cancelbutton { background-color: #000; color: #fff; }
		.eip_saving { background-color: #903; color: #fff; padding: 3px; }
		.eip_empty { color: #afafaf; }
	</style>
{/literal}

<html>
<head><title>RSS Import</title>

{checkForJs}

<b>RSS Import v1.1.0</b>
<hr>
<a href = "import_feeds.php">Import the feeds</a>
<hr>

{foreach from=$FeedList item=feed_id}
	
  <b>Feed Name: </b>{eipItem item=qeip_FeedName unique=$feed_id}<br>
	<b>Feed URL: </b>{eipItem item=qeip_FeedURL unique=$feed_id}<br>
	<a href = "?action=dropfeed&feed_id={$feed_id}">Delete this feed</a>
	<br><br>
	- <b>Feed Frequency (hours): </b>{eipItem item=qeip_FeedFreqHours unique=$feed_id} -- how often to check for new items.<br>
	- <b>Feed Votes: </b>{eipItem item=qeip_FeedVotes unique=$feed_id} -- how many votes new items recieve (limit 200)<br>
	- <b>Feed Items Limit: </b>{eipItem item=qeip_FeedItemLimit unique=$feed_id} -- how many new items to take from the feed when it's checked<br>
	- <b>Feed URL Dupes: </b>{eipItem item=qeip_FeedURLDupe unique=$feed_id} -- Allow duplicate URL's 0=No, 1=Yes, Allow<br>
	- <b>Feed Title Dupes: </b>{eipItem item=qeip_FeedTitleDupe unique=$feed_id} -- Allow duplicate Title's 0=No, 1=Yes, Allow<br>
	- <b>Feed Submitter Id (number): </b>{eipItem item=qeip_FeedSubmitter unique=$feed_id} -- The ID of the person who will be listed as the submitter<br>
	- <b>Feed Category Id (number): </b>{eipItem item=qeip_FeedCategory unique=$feed_id} -- The ID of the category to place these items into<br>

	<br>
	{* get a list of all field_links where `feed_id` = $feed_id and put them into the smarty variable "FeedLinks" *}
		{feedsListFeedLinks varname=FeedLinks feedid=$feed_id}
		
	{foreach from=$FeedLinks item=feed_link_id}
		{* get a list of fields in the RSS feed and put them into the smarty variable "eip_select" for the EIP selectbox to use *}
			{feedsListFeedFields feed_id=$feed_id}
	
		-- <b>feed field name</b>: {eipItem item=qeip_FeedLink_FeedField unique=$feed_link_id}

		{* get a list of pligg fields and put them into the smarty variable "eip_select" for the EIP selectbox to use *}
			{feedsListPliggLinkFields}
			
		--- <b>pligg field name</b>: {eipItem item=qeip_FeedLink_PliggField unique=$feed_link_id}

		--- <a href = "?action=dropfieldlink&FeedLinkId={$feed_link_id}">Remove this link</a>
 		<br>

	{/foreach}
	
	-- <a href = "?action=addnewfieldlink&FeedLinkId={$feed_id}">Add a new field link</a>

	<hr>
	
{/foreach}
<a href="?action=addnewfeed">Add a new feed</a>
