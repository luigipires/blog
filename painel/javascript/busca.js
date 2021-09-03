$(function(){
	$(':input').bind('keyup change input',function(){
		requisicao();
	});

	function requisicao(){
		$('.ajax-busca').ajaxSubmit({
			data:{'informacao':$('input[name=busca]').val()},
			success:function(data){
				$('.listas>table').html(data);

				var excluir = $('[exclusao]');

				excluir.click(function(e){
					e.preventDefault();
					$('html,body').scrollTop(0);
					var name = $(this).attr('iduser');
					janelamodal = $('.excluir-imagem>div>a').attr('href','lista-usuarios?excluir='+name);
					$('.fundo-transparente').show();
					$('.janela-excluir-imagem').show();
					$('body').css('overflow','hidden');
					e.stopPropagation();
				});

				fecharJanela();

				if($('.sucesso-mensagem').is(':hidden') == false){
					setTimeout(function(){
						$('.sucesso-mensagem').fadeOut(function(){
							setTimeout(function(){
								location.href=include_path_painel;
							},1000);
						});
					},3000);
				}
			}
		})
	}

	function fecharJanela(){
		$('.fechar-janela').click(function(){
			$('body').css('overflow','auto');
			$('.fundo-transparente').hide();
			$('.janela-excluir-imagem').hide();
			$('.janela-sucesso-imagem').hide();
		});
	};
})