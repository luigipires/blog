$(function(){
	$('.mostrar-senha-login>h3').click(function(){
		var mostrarsenhalogin = $('input[name=password-login]').attr('type');

		if(mostrarsenhalogin == 'password'){
			$('input[name=password-login]').attr('type','text');
			$('.mostrar-senha-login>h3>i').removeClass('fas fa-eye');
			$('.mostrar-senha-login>h3>i').addClass('fas fa-eye-slash');
		}else{
			$('input[name=password-login]').attr('type','password');
			$('.mostrar-senha-login>h3>i').removeClass('fas fa-eye-slash');
			$('.mostrar-senha-login>h3>i').addClass('fas fa-eye');
		}
	});

	$('#cadastro-formulario').submit(function(){
		var este = $(this);

		$.ajax({
			beforeSend:function(){
				este.animate({'opacity':'0.5'});
				este.find('input').attr('disabled','true');
				este.find('input[type=submit]').css('cursor','wait');
			},
			url:include_path+'ajax/dados.php',
			dataType:'json',
			method:'post',
			data:este.serialize()
		}).done(function(data){
			$('.erro-mensagem').hide();
			este.animate({'opacity':'1'});
			este.find('input').removeAttr('disabled');
			este.find('input[type=submit]').css('cursor','pointer');

			if(data.sucesso){
				if($('.erro-mensagem').is(':hidden') == false){
					$('.erro-mensagem').hide();
				}

				$('.form-cadastro').prepend('<div style="padding:10px; margin: 0 0 30px 0;" class="sucesso-mensagem"><i class="fas fa-check-circle"></i><p>'+data.mensagem+'</p></div>');
				setTimeout(function(){
					$('.sucesso-mensagem').fadeOut();
				},7000);
				document.getElementById('cadastro-formulario').reset();
				$('#cadastro-formulario>div>label').html('Selecionar arquivo');
			}else{
				if($('.erro-mensagem').is(':hidden') == false){
					$('.erro-mensagem').hide();
				}

				$('.form-cadastro').prepend('<div style="padding:10px; margin: 0 0 30px 0;" class="erro-mensagem"><i class="fas fa-exclamation-triangle"></i><p>'+data.mensagem+'</p></div>');
				// setTimeout(function(){
				// 	$('.erro-mensagem').fadeOut();
				// },2000);
			}
		});

		return false;
	});

	$('#formulario-contato').submit(function(){
		var este = $(this);

		$.ajax({
			beforeSend:function(){
				este.animate({'opacity':'0.5'});
				este.find('input').attr('disabled','true');
				este.find('input[type=submit]').css('cursor','wait');
			},
			url:include_path+'ajax/dados.php',
			dataType:'json',
			method:'post',
			data:este.serialize()
		}).done(function(data){
			$('.erro-mensagem').hide();
			este.animate({'opacity':'1'});
			este.find('input').removeAttr('disabled');
			este.find('input[type=submit]').css('cursor','pointer');

			if(data.sucesso){
				if($('.erro-mensagem').is(':hidden') == false){
					$('.erro-mensagem').hide();
				}

				este.children('div:nth-of-type(2)').prepend('<div style="padding:10px; margin: 0 0 30px 0;" class="sucesso-mensagem"><i class="fas fa-check-circle"></i><p>'+data.mensagem+'</p></div>');
				setTimeout(function(){
					$('.sucesso-mensagem').fadeOut();
				},4000);
				este.trigger('reset');
			}else{
				if($('.erro-mensagem').is(':hidden') == false){
					$('.erro-mensagem').hide();
				}

				este.children('div:nth-of-type(2)').prepend('<div style="padding:10px; margin: 0 0 30px 0;" class="erro-mensagem"><i class="fas fa-exclamation-triangle"></i><p>'+data.mensagem+'</p></div>');
				// setTimeout(function(){
				// 	$('.erro-mensagem').fadeOut();
				// },2000);
			}
		});

		return false;
	});

	$('#login-formulario').submit(function(){
		var este = $(this);

		$.ajax({
			beforeSend:function(){
				este.animate({'opacity':'0.5'});
				este.find('input').attr('disabled','true');
				este.find('input[type=submit]').css('cursor','wait');
				este.children('.complemento-login').children('div').find('input[type=checkbox]').attr('disabled','true');
				este.children('.complemento-login').children('div').find('input[type=checkbox]').css('cursor','default');
				este.children('.complemento-login').children('div').find('a').css('display','none');
			},
			url:include_path+'ajax/dados.php',
			dataType:'json',
			method:'post',
			data:este.serialize()
		}).done(function(data){
			$('.erro-mensagem').hide();
			este.animate({'opacity':'1'});
			este.find('input').removeAttr('disabled');
			este.find('input[type=submit]').css('cursor','pointer');
			este.children('.complemento-login').children('div').find('input[type=checkbox]').removeAttr('disabled');
			este.children('.complemento-login').children('div').find('a').css('display','block');
			este.children('.complemento-login').children('div').find('input[type=checkbox]').css('cursor','pointer');

			if(data.sucesso){
				este.trigger('reset');

				var url = window.location.href;
				url = url.split('/');

				if(url[6] == null && url[7] == null){
					location.href=include_path+'painel';
				}else{
					location.href=include_path+url[5]+'/'+url[6]+'/'+url[7];
				}
			}else{
				if($('.erro-mensagem').is(':hidden') == false){
					$('.erro-mensagem').hide();
				}

				este.children('div:nth-of-type(2)').prepend('<div style="padding:10px; margin-bottom:20px;" class="erro-mensagem"><i class="fas fa-exclamation-triangle"></i><p>'+data.mensagem+'</p></div>');
				// setTimeout(function(){
				// 	$('.erro-mensagem').fadeOut();
				// },2000);
			}
		});

		return false;
	});
})