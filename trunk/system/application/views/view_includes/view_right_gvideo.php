<?php

?>

<h3><a class="close" onclick="new Effect.toggle('videos','blind', {queue: 'end'}); ">close</a><span>Political Videos</span></h3>
<div class="box" id="videos">

	<!-- ++Begin Video Search Control Wizard Generated Code++ -->
  <!--
  // Created with a Google AJAX Search Wizard
  // http://code.google.com/apis/ajaxsearch/wizards.html
  -->

  <!--
  // The Following div element will end up holding the Video Search Control.
  // You can place this anywhere on your page.
  -->
  <div id="videoControl">
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
  <script src="http://www.google.com/uds/api?file=uds.js&v=1.0&source=uds-vsw&key=ABQIAAAAkKcqFPODFw9EgKwKbb0vmxQMMgp4bRk8oDwCMuUVC3eAkH6yhxRey5JriXQU4hISBErCZHOSAAHL4w"
    type="text/javascript"></script>
  <style type="text/css">
    @import url("http://www.google.com/uds/css/gsearch.css");
  </style>

  <!-- Video Search Control and Stylesheet -->
  <script type="text/javascript">
    window._uds_vsw_donotrepair = true;
  </script>
  <script src="http://www.google.com/uds/solutions/videosearch/gsvideosearch.js?mode=new"
    type="text/javascript"></script>
  <style media="all" type="text/css">@import "css/googleVideo.css";</style>

  <script type="text/javascript">
    function LoadVideoSearchControl() {
      var options = { twoRowMode : true };
      //var options = { largeResultSet : true };
      var videoSearch = new GSvideoSearchControl(
                              document.getElementById("videoControl"),
                              [{ query : "politics"}, { query : "campaign 2008"}, { query : "u.s. senate"}, { query : "congress"}, { query : "liberal"}, { query : "democrat"}, { query : "republican"}], null, null, options);
    }
    // arrange for this function to be called during body.onload
    // event processing
    GSearch.setOnLoadCallback(LoadVideoSearchControl);
  </script>

<!-- --End Video Search Control Wizard Generated Code-- -->
                
	
	
</div>
<div class="box-bottom"></div>