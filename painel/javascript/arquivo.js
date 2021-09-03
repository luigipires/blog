$(function(){
	$('.destaque').show(function(){
		$(this).parent('div').prev().children('h3').children('i').attr('class','fas fa-minus-circle');
		$(this).parent().children().slideDown();
	});

	$('#drop-down>div:nth-of-type(1)').click(function(){
		var menu = $(this).next('div').children('div');
		var element = $(this).children('h3').children('i');

		if(menu.is(':hidden') == true){
			element.removeClass('fas fa-plus-circle')
			element.addClass('fas fa-minus-circle');
			menu.slideDown();
		}else{
			element.removeClass('fas fa-minus-circle')
			element.addClass('fas fa-plus-circle');
			menu.slideUp();
		}
	})

	var aberto = true;
	var tamanhotela = $(window)[0].innerWidth;
	var tamanhomenu = (tamanhotela <= 400) ? 200 : 250;

	if(tamanhotela <= 768){
		aberto = false;
	}

	$('.menu-painel>h3').click(function(){
		if(aberto){
			$('aside').css('display','none');
			$('aside').animate({'width':'0'},function(){
				aberto = false;
			});
			$('header').css('width','100%');
			$('header').animate({'left':'0'},function(){
				aberto = false;
			});
			$('section').css('width','100%');
			$('section').animate({'left':'0'},function(){
				aberto = false;
			});
		}else{
			$('aside').css('display','block');
			$('aside').animate({'width':+tamanhomenu+'px'},function(){
				aberto = true;
			});
			$('header').css('width','calc(100% - 250px)');
			$('header').animate({'left':+tamanhomenu+'px'},function(){
				aberto = true;
			});
			$('section').css('width','calc(100% - 250px)');
			$('section').animate({'left':+tamanhomenu+'px'},function(){
				aberto = true;
			});
		}
	});

	$('.mostrar-senha>h3').click(function(){
		var mostrarsenha = $('input[name=senha]').attr('type');

		if(mostrarsenha == 'password'){
			$('input[name=senha]').attr('type','text');
			$('.mostrar-senha>h3>i').removeClass('fas fa-eye');
			$('.mostrar-senha>h3>i').addClass('fas fa-eye-slash');
		}else{
			$('input[name=senha]').attr('type','password');
			$('.mostrar-senha>h3>i').removeClass('fas fa-eye-slash');
			$('.mostrar-senha>h3>i').addClass('fas fa-eye');
		}
	});

	var input = document.getElementById('foto');
    var fileName = document.getElementById('label-foto');
    
	input.addEventListener('change',(t) => {
	  fileName.textContent = t.target.value.split('\\').pop();
	});

	$('.tooltip>h3').hover(function() {
		$('.tooltip>div>div').fadeIn('slow');
	},function(){
		$('.tooltip>div>div').fadeOut('slow');
	});
})