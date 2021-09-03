$(function(){
	var excluir = $('[exclusao]');
	var excluirimagem = $('[exclusaoimagem]');
	var excluirimagemmultiple = $('[exclusaoimagemmultiple]');
	fecharJanela();

	excluirimagem.click(function(e){
		e.preventDefault();
		$('html,body').scrollTop(0);
		$('.fundo-transparente').fadeIn('fast');
		$('.janela-excluir-imagem').fadeIn('fast');
		$('body').css('overflow','hidden');
		e.stopPropagation();
	});

	var urlprincipal = window.location.href;
	urlprincipal = urlprincipal.split(/[?=]/);

	if(urlprincipal[1] == 'pagina'){
		excluir.click(function(){
			var url = window.location.href;
			url = url.split('/');
			$('html,body').scrollTop(0);
			var name = $(this).attr('iduser');
			janelamodal = $('.excluir-imagem>div>a').attr('href',url[6]+'&excluir='+name);
			$('.fundo-transparente').fadeIn('fast');
			$('.janela-excluir-imagem').fadeIn('fast');
			$('body').css('overflow','hidden');
		});
	}else{
		excluir.click(function(){
			var url = window.location.href;
			url = url.split('/');
			$('html,body').scrollTop(0);
			var name = $(this).attr('iduser');
			janelamodal = $('.excluir-imagem>div>a').attr('href',url[6]+'?excluir='+name);
			$('.fundo-transparente').fadeIn('fast');
			$('.janela-excluir-imagem').fadeIn('fast');
			$('body').css('overflow','hidden');
		});
	}

	excluirimagemmultiple.click(function(e){
		e.preventDefault();
		var url = window.location.href;
		url = url.split('/');
		$('html,body').scrollTop(0);
		var name = $(this).attr('idimagem');
		janelamodal = $('.excluir-imagem>div>a').attr('href',url[6]+'&excluir='+name);
		$('.fundo-transparente').fadeIn('fast');
		$('.janela-excluir-imagem').fadeIn('fast');
		$('body').css('overflow','hidden');
		e.stopPropagation();
	});

	function fecharJanela(){
		$('.fechar-janela').click(function(){
			$('body').css('overflow','auto');
			$('.fundo-transparente').fadeOut('fast');
			$('.janela-excluir-imagem').fadeOut('fast');
			$('.janela-sucesso-imagem').fadeOut('fast');
			$('.subir-comentario').fadeOut('fast');
		});
	};

	if($('.sucesso-mensagem').is(':hidden') == false){
		setTimeout(function(){
			$('.sucesso-mensagem').fadeOut(function(){
				//pegando valores da url para reconstruir a url
				var url = window.location.href;
				url = url.split(/[/?&]/);

				var urlcortada = window.location.href;
				urlcortada = urlcortada.split(/[/?&=]/);
				setTimeout(function(){
					if(urlcortada[7] != 'editar'){
						location.href=include_path_painel+url[6];
					}else{
						location.href=include_path_painel+url[6]+'?'+url[7];
					}
				},1000);
			});
		},3000);
	}

	$('[view]').click(function(){
		$('html,body').scrollTop(0);
		$('.fundo-transparente').fadeIn('fast');
		$('.subir-comentario').fadeIn('fast');
		$('body').css('overflow','hidden');

		var comentario = $(this).attr('idComent');
		$('.box-comentario>p').html(comentario);
	})
})