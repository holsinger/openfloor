<?php

?>

<h3><a class="close" onclick="new Effect.toggle('blog','blind', {queue: 'end'}); ">close</a><span>Political Blog Posts</span></h3>
<div class="box" id="blog">

<!-- ++Begin Blog Bar Wizard Generated Code++ -->
  <!--
  // Created with a Google AJAX Search Wizard
  // http://code.google.com/apis/ajaxsearch/wizards.html
  -->

  <!--
  // The Following div element will end up holding the actual blogbar.
  // You can place this anywhere on your page.
  -->
  <div id="blogBar-bar">
    <span style="color:#676767;font-size:11px;margin:10px;padding:4px;">Loading...</span>
  </div>

  <!-- Ajax Search Api and Stylesheet
  // Note: If you are already using the AJAX Search API, then do not include it
  //       or its stylesheet again
  //
  // The Key Embedded in the following script tag is designed to work with
  // the following site:
  // http://politic20.com
  -->
  <script src="http://www.google.com/uds/api?file=uds.js&v=1.0&source=uds-blbw&key=ABQIAAAAkKcqFPODFw9EgKwKbb0vmxQMMgp4bRk8oDwCMuUVC3eAkH6yhxRey5JriXQU4hISBErCZHOSAAHL4w"
    type="text/javascript"></script>
  <style type="text/css">
    @import url("http://www.google.com/uds/css/gsearch.css");
  </style>

  <!-- Blog Bar Code and Stylesheet -->
  <script src="http://www.google.com/uds/solutions/blogbar/gsblogbar.js?mode=new"
    type="text/javascript"></script>
  <style type="text/css">
    @import url("http://www.google.com/uds/solutions/blogbar/gsblogbar.css");
  </style>

  <script type="text/javascript">
    function LoadBlogBar() {
      var blogBar;
      var options = {
        largeResultSet : false,
        title : " ",
        horizontal : false,
        orderBy : GSearch.ORDER_BY_DATE,
        autoExecuteList : {
          executeList : ["politics", "us senate", "congress", "democrat", "republican", "campaign 2008", "liberal"]
        }
      }

      blogBar = new GSblogBar(document.getElementById("blogBar-bar"), options);
    }
    // arrange for this function to be called during body.onload
    // event processing
    GSearch.setOnLoadCallback(LoadBlogBar);
  </script>
<!-- ++End Blog Bar Wizard Generated Code++ -->
	
	
</div>
<div class="box-bottom"></div>