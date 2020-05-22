$(document).ready(function(){ 

jQuery(function($){
   $(".cnpj").mask("99.999.999-9999/99");
   $(".telefone").mask("(99) 99999-9999");
   $(".telefonefixo").mask("(99) 9999-9999");
   $(".data_nota").mask("99/999/9999");
});

$(function() {
	$("#data_nota").datepicker();
	$("#data_inicial").datepicker();
	$("#data_final").datepicker();
});

} );



