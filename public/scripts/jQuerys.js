$(document).ready(function() 
    {
		//$( document ).tooltip();
        $(".tablesorter").tablesorter( {sortList: [[0,1]]} ); 
    } 
); 

$(function() {
	$( "#tabs" ).tabs();
});

$(function() {
	$( ".accordion" ).accordion();});

$(function() {
	$( "#accordion1" ).accordion();
});

$(function() {
$( "#menu" ).menu();
});
