<!DOCTYPE html>
<html>
<head>
<base href="http://127.0.0.1/homepage/">
<meta charset="UTF-8">
<title>homepage</title>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.9/semantic.min.css">
</head>
<body>
<table id='site' class="ui table"><thead id='' class=""><tr id='htmltablecontent--0' class=""><th id='htmltr-htmltablecontent--0-0' class="">Nom de l'établissement</th> <th id='htmltr-htmltablecontent--0-1' class="">Latitude</th> <th id='htmltr-htmltablecontent--0-2' class="">Longitude</th> <th id='htmltr-htmltablecontent--0-3' class=""></th></tr></thead> <tbody id='' class=""><tr id='site-tr-1' class="" data-ajax="1"><td id='htmltr-site-tr-1-0' class="">Campus III Ifs</td> <td id='htmltr-site-tr-1-1' class="">49.148815</td> <td id='htmltr-site-tr-1-2' class="">-0.353537</td> <td id='htmltr-site-tr-1-3' class=""><button id='' class="ui button icon _edit basic" data-ajax="1"><i id='icon-' class="icon edit"></i></button></td></tr></tbody></table><script type="text/javascript" >
// <![CDATA[
window.defer=function (method) {if (window.jQuery) method(); else setTimeout(function() { defer(method) }, 50);};window.defer(function(){$(document).ready(function() {

	$("#site ._edit").click(function(event){
		
if(event && event.stopPropagation) event.stopPropagation();

if(event && event.preventDefault) event.preventDefault();
url='http://127.0.0.1/homepage//addSite';url=url+'/'+($(this).attr('data-ajax')||'');
var self=this;
$("#frmSite").empty();
		$("#frmSite").prepend('<div class="ajax-loader"><span></span><span></span><span></span><span></span><span></span></div>');
$.get(url,{}).done(function( data ) {
	$("#frmSite").html( data );
	
});

	});
})});
// ]]>
</script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.9/semantic.min.js"></script>
</body>
</html>
