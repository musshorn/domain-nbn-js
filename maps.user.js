// ==UserScript==
// @name          NBN Burbs
// @namespace     hahano
// @description	  Shows if/when the suburb will get the NBN on domain.com.au
// @include       http://www.domain.com.au/*
// @include       https://www.domain.com.au/*
// @require       https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js
// ==/UserScript==

var url = $("#Frame").attr("src");
GM_xmlhttpRequest({
  method: "GET",
  url: "http://hserver.me/nbn.php?postcode="+url.split("&")[2].split("=")[1],
  onload: function(response) {
    $("h1.cT-searchHeading").append("<div align='right'>NBN-Status: "+response.responseText+'</div>');
  }
});