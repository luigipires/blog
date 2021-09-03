$(function(){
	var mobile = document.querySelector('.mobile>h3');
	mobile.addEventListener('click',() => {
		$('.mobile ul').slideToggle();
	})

	abrirJanela();
	fecharJanela();

	var input = document.getElementById('foto');
    var fileName = document.getElementById('label-foto');

	input.addEventListener('change',(t) => {
	  fileName.textContent = t.target.value.split('\\').pop();
	});

	var iconEye = document.querySelector('.mostrar-senha>h3');
	iconEye.addEventListener('click',() => {
		var mostrarsenha = document.querySelector('input[name=password-cadastro]').getAttribute('type');

		if(mostrarsenha == 'password'){
			$('input[name=password-cadastro]').attr('type','text');
			$('.mostrar-senha>h3>i').removeClass('fas fa-eye');
			$('.mostrar-senha>h3>i').addClass('fas fa-eye-slash');
		}else{
			$('input[name=password-cadastro]').attr('type','password');
			$('.mostrar-senha>h3>i').removeClass('fas fa-eye-slash');
			$('.mostrar-senha>h3>i').addClass('fas fa-eye');
		}
	});

	function abrirJanela(){
		var modalLogin = document.querySelectorAll('.abrir-janela');

		for(var i = 0; i < modalLogin.length; i++){
			modalLogin[i].addEventListener('click',() => {
				$('.mobile ul').hide();
				$('.tela-login').fadeIn('fast');
				$('html,body').scrollTop(0);
				document.querySelector('body').style.overflow = 'hidden';
			});
		}
	};

	function fecharJanela(){
		var fecharModalJanela = document.querySelector('.fechar-janela>img');

		fecharModalJanela.addEventListener('click',() => {
			$('.tela-login').fadeOut('fast');
			document.querySelector('body').style.overflow = 'auto';
		});
	};

	$('.tooltip>h3').hover(function(){
		$('.tooltip>div>div').fadeIn('slow');
	},function(){
		$('.tooltip>div>div').fadeOut('slow');
	});
})