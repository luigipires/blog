$(function(){
	$('.respostas').hide();
	$('[title=Responder]').click(function(){
		$(this).parent().next('div').slideToggle();
	});

	$('.title-sessao-comentarios>h3').click(function(){
		var sessao = $(this).parent().next('.respostas');
		var icon = $(this).children('i');

		if(sessao.is(':hidden') == false){
			icon.removeClass('fas fa-minus-circle');
			icon.addClass('fas fa-plus-circle');
			$(this).attr('title','Ver respostas');
			sessao.slideUp('slow');
		}else{
			icon.removeClass('fas fa-plus-circle');
			icon.addClass('fas fa-minus-circle');
			$(this).removeAttr('title');
			sessao.slideDown('slow');
		}
	});

	/*****************************************************/
	// feedbacks

	likeComentario();
	noLikeComentario();
	deslikeComentario();
	noDeslikeComentario();

	likeResposta();
	deslikeResposta();
	noLikeResposta();
	noDeslikeResposta();

	function likeComentario(){
		$('[like]').click(function(){
			var este = $(this);
			var noticia = $(this).attr('noticiaLike');
			var comentario = $(this).attr('comentarioLike');

			$.ajax({
				url:include_path+'ajax/blog.php',
				method:'post',
				data:{idLike:'like',noticiaLike:noticia,comentarioLike:comentario}
			}).done(function(data){
				este.parent().html(data);

				noLikeComentario();
				deslikeComentario();
			});
		});
	}

	function noLikeComentario(){
		$('[no-like]').click(function(){
			var este = $(this);
			var noticia = $(this).attr('noticiaLike');
			var comentario = $(this).attr('comentarioLike');

			$.ajax({
				url:include_path+'ajax/blog.php',
				method:'post',
				data:{idNoLike:'no-like',noticiaLike:noticia,comentarioLike:comentario}
			}).done(function(data){
				este.parent().html(data);

				likeComentario();
				deslikeComentario();
			});
		});
	}

	function deslikeComentario(){
		$('[deslike]').click(function(){
			var este = $(this);
			var noticia = $(this).attr('noticiaDeslike');
			var comentario = $(this).attr('comentarioDeslike');

			$.ajax({
				url:include_path+'ajax/blog.php',
				method:'post',
				data:{idDeslike:'deslike',noticiaDeslike:noticia,comentarioDeslike:comentario}
			}).done(function(data){
				este.parent().html(data);

				likeComentario();
				noDeslikeComentario();
			});
		});
	}

	function noDeslikeComentario(){
		$('[no-deslike]').click(function(){
			var este = $(this);
			var noticia = $(this).attr('noticiaDeslike');
			var comentario = $(this).attr('comentarioDeslike');

			$.ajax({
				url:include_path+'ajax/blog.php',
				method:'post',
				data:{idNoDeslike:'no-deslike',noticiaDeslike:noticia,comentarioDeslike:comentario}
			}).done(function(data){
				este.parent().html(data);

				likeComentario();
				deslikeComentario();
			});
		});
	}

	/***********************************/
	// respostas

	function likeResposta(){
		$('[likeResposta]').click(function(){
			var este = $(this);
			var noticia = $(this).attr('noticiaLike');
			var comentario = $(this).attr('comentarioLike');
			var resposta = $(this).attr('respostaLike');

			$.ajax({
				url:include_path+'ajax/blog.php',
				method:'post',
				data:{idLikeResposta:'likeResposta',noticiaLike:noticia,comentarioLike:comentario,respostaLike:resposta}
			}).done(function(data){
				este.parent().html(data);

				noLikeResposta();
				deslikeResposta();
			});
		});
	}

	function noLikeResposta(){
		$('[no-likeResposta]').click(function(){
			var este = $(this);
			var noticia = $(this).attr('noticiaLike');
			var comentario = $(this).attr('comentarioLike');
			var resposta = $(this).attr('respostaLike');

			$.ajax({
				url:include_path+'ajax/blog.php',
				method:'post',
				data:{idNoLikeResposta:'no-likeResposta',noticiaLike:noticia,comentarioLike:comentario,respostaLike:resposta}
			}).done(function(data){
				este.parent().html(data);

				likeResposta();
				deslikeResposta();
			});
		});
	}

	function deslikeResposta(){
		$('[deslikeResposta]').click(function(){
			var este = $(this);
			var noticia = $(this).attr('noticiaDeslike');
			var comentario = $(this).attr('comentarioDeslike');
			var resposta = $(this).attr('respostaDeslike');

			$.ajax({
				url:include_path+'ajax/blog.php',
				method:'post',
				data:{idDeslikeResposta:'deslikeResposta',noticiaDeslike:noticia,comentarioDeslike:comentario,respostaDeslike:resposta}
			}).done(function(data){
				este.parent().html(data);

				likeResposta();
				noDeslikeResposta();
			});
		});
	}

	function noDeslikeResposta(){
		$('[no-deslikeResposta]').click(function(){
			var este = $(this);
			var noticia = $(this).attr('noticiaDeslike');
			var comentario = $(this).attr('comentarioDeslike');
			var resposta = $(this).attr('respostaDeslike');

			$.ajax({
				url:include_path+'ajax/blog.php',
				method:'post',
				data:{idNoDeslikeResposta:'no-deslikeResposta',noticiaDeslike:noticia,comentarioDeslike:comentario,respostaDeslike:resposta}
			}).done(function(data){
				este.parent().html(data);

				likeResposta();
				deslikeResposta();
			});
		});
	}

	/************************************/
	// denuncia

	$('[denunciar]').click(function(){
		var noticia = $(this).attr('noticiaDenuncia');
		var comentario = $(this).attr('comentarioDenuncia');

		$.ajax({
			url:include_path+'ajax/blog.php',
			method:'post',
			data:{idDenuncia:'denuncia',noticiaDenuncia:noticia,comentarioDenuncia:comentario}
		}).done(function(){});
	});

	$('[denunciarResposta]').click(function(){
		var noticia = $(this).attr('noticiaDenuncia');
		var comentario = $(this).attr('comentarioDenuncia');
		var resposta = $(this).attr('respostaDenuncia');

		$.ajax({
			url:include_path+'ajax/blog.php',
			method:'post',
			data:{idDenunciaResposta:'denunciaResposta',noticiaDenuncia:noticia,comentarioDenuncia:comentario,respostaDenuncia:resposta}
		}).done(function(){});
	});

	// $('#offset').submit(function(){
	// 	var offset = $('#offset');
	// 	offset.scrollTop(0);
	// })

	/*********************************************************/
	// ajax-formulários

	$('.post-comentario').submit(function(){
		var este = $(this);

		$.ajax({
			beforeSend:function(){
				este.animate({'opacity':'0.5'});
				este.find('textarea').attr('disabled','true');
				este.find('input[type=submit]').css('cursor','wait');
			},
			url:include_path+'ajax/publicacoes.php',
			dataType:'json',
			method:'post',
			data:este.serialize()
		}).done(function(data){
			$('.erro-mensagem').hide();
			este.animate({'opacity':'1'});
			este.find('textarea').removeAttr('disabled');
			este.find('input[type=submit]').css('cursor','pointer');

			if(data.sucesso){
				if($('.erro-mensagem').is(':hidden') == false){
					$('.erro-mensagem').hide();
				}

				este.prepend('<div style="padding:10px; margin: 20px auto;" class="sucesso-mensagem"><i class="fas fa-check-circle"></i><p>'+data.mensagem+'</p></div>');
				setTimeout(function(){
					$('.sucesso-mensagem').fadeOut(function(){
						var url = window.location.href;

						url = url.split('/');
						location.href=include_path+url[5]+'/'+url[6]+'/'+url[7];
					});
				},3000);
				este.trigger('reset');
			}else{
				if($('.erro-mensagem').is(':hidden') == false){
					$('.erro-mensagem').hide();
				}

				este.prepend('<div style="padding:10px; margin: 20px auto;" class="erro-mensagem"><i class="fas fa-exclamation-triangle"></i><p>'+data.mensagem+'</p></div>');
			}
		})

		return false;
	});

	$('.post-resposta').submit(function(){
		var este = $(this);

		$.ajax({
			beforeSend:function(){
				este.animate({'opacity':'0.5'});
				este.find('textarea').attr('disabled','true');
				este.find('input[type=submit]').css('cursor','wait');
			},
			url:include_path+'ajax/publicacoes.php',
			dataType:'json',
			method:'post',
			data:este.serialize()
		}).done(function(data){
			$('.erro-mensagem').hide();
			este.animate({'opacity':'1'});
			este.find('textarea').removeAttr('disabled');
			este.find('input[type=submit]').css('cursor','pointer');

			if(data.sucesso){
				if($('.erro-mensagem').is(':hidden') == false){
					$('.erro-mensagem').hide();
				}

				este.prepend('<div style="padding:10px; margin: 20px auto;" class="sucesso-mensagem"><i class="fas fa-check-circle"></i><p>'+data.mensagem+'</p></div>');
				setTimeout(function(){
					$('.sucesso-mensagem').fadeOut(function(){
						var url = window.location.href;

						url = url.split('/');
						location.href=include_path+url[5]+'/'+url[6]+'/'+url[7];
					});
				},3000);
				este.trigger('reset');
			}else{
				if($('.erro-mensagem').is(':hidden') == false){
					$('.erro-mensagem').hide();
				}

				este.prepend('<div style="padding:10px; margin: 20px auto;" class="erro-mensagem"><i class="fas fa-exclamation-triangle"></i><p>'+data.mensagem+'</p></div>');
			}
		})

		return false;
	});

	$('.post-responder-resposta').submit(function(){
		var este = $(this);

		$.ajax({
			beforeSend:function(){
				este.animate({'opacity':'0.5'});
				este.find('textarea').attr('disabled','true');
				este.find('input[type=submit]').css('cursor','wait');
			},
			url:include_path+'ajax/publicacoes.php',
			dataType:'json',
			method:'post',
			data:este.serialize()
		}).done(function(data){
			$('.erro-mensagem').hide();
			este.animate({'opacity':'1'});
			este.find('textarea').removeAttr('disabled');
			este.find('input[type=submit]').css('cursor','pointer');

			if(data.sucesso){
				if($('.erro-mensagem').is(':hidden') == false){
					$('.erro-mensagem').hide();
				}

				este.prepend('<div style="padding:10px; margin: 20px auto;" class="sucesso-mensagem"><i class="fas fa-check-circle"></i><p>'+data.mensagem+'</p></div>');
				setTimeout(function(){
					$('.sucesso-mensagem').fadeOut(function(){
						var url = window.location.href;

						url = url.split('/');
						location.href=include_path+url[5]+'/'+url[6]+'/'+url[7];
					});
				},3000);
				este.trigger('reset');
			}else{
				if($('.erro-mensagem').is(':hidden') == false){
					$('.erro-mensagem').hide();
				}

				este.prepend('<div style="padding:10px; margin: 20px auto;" class="erro-mensagem"><i class="fas fa-exclamation-triangle"></i><p>'+data.mensagem+'</p></div>');
			}
		})

		return false;
	});
})