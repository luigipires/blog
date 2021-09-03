$(function(){
	document.getElementsByClassName('alerta-mensagem').style.maxWidth = '100%';
	// $('.alerta-mensagem').css('max-width','100%');
	var mensagemerro = document.getElementsByClassName('erro-mensagem');
	var mensagemsucesso = document.getElementsByClassName('sucesso-mensagem');

	if(mensagemerro.is(':hidden') == false){
		setTimeout(function(){
			mensagemerro.fadeOut();
		},4000);
	}

	if(mensagemsucesso.is(':hidden') == false){
		setTimeout(function(){
			mensagemsucesso.fadeOut(function(){
				setTimeout(function(){
					location.href=include_path;
				},1000);
			});
		},4000);
	}

	$('.mostrar-senha>h3').click(function(){
		var mostrarsenha = $('input[name=redefinir-senha]').attr('type');

		if(mostrarsenha == 'password'){
			$('input[name=redefinir-senha]').attr('type','text');
			$('.mostrar-senha>h3>i').removeClass('fas fa-eye');
			$('.mostrar-senha>h3>i').addClass('fas fa-eye-slash');
		}else{
			$('input[name=redefinir-senha]').attr('type','password');
			$('.mostrar-senha>h3>i').removeClass('fas fa-eye-slash');
			$('.mostrar-senha>h3>i').addClass('fas fa-eye');
		}
	});
})