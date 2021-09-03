$(function(){
	var slideAtual = 0;
	var fotoSlide = $('[fotos]').length - 1;
	var avaliacoesSlide = $('.info-avaliacao').length - 1;

	adicionarBolinhaBanner();
	// adicionarBolinhaAvaliacao();

	function adicionarBolinhaBanner(){
		for(var i = 0; i < fotoSlide + 1; i++){
			var bolinhas = $('.banner-slide').html();

			if(i == 0){
				bolinhas+='<span style="background-color: #B43C38"></span>';
			}else{
				bolinhas+='<span></span>';
			}

			$('.banner-slide').html(bolinhas);
		}

		$('[fotos]').hide();
		$('[fotos]').eq(0).show();
	}

	$('body').on('click','.banner-slide>span',function(){
		var bolinhaPrincipal = $(this);

		$('[fotos]').eq(slideAtual).stop().fadeOut();
		slideAtual = bolinhaPrincipal.index();
		$('[fotos]').eq(slideAtual).stop().fadeIn();
		$('.banner-slide>span').removeAttr('style');
		bolinhaPrincipal.css('background-color','#B43C38');
	});

	// function adicionarBolinhaAvaliacao(){
	// 	for(var i = 0; i < avaliacoesSlide + 1; i++){
	// 		var bolinhas = $('.slide-avaliacoes').html();

	// 		if(i == 0){
	// 			bolinhas+='<span style="background-color: #69382c"></span>';
	// 		}else{
	// 			bolinhas+='<span></span>';
	// 		}

	// 		$('.slide-avaliacoes').html(bolinhas);
	// 	}

	// 	$('.info-avaliacao').hide();
	// 	$('.info-avaliacao').eq(0).show();
	// }

	// $('.slide-avaliacoes>span').click(function(){
	// 	var bolinhaPrincipal = $(this);

	// 	$('.info-avaliacao').eq(slideAtual).stop().toggle('hide');
	// 	slideAtual = bolinhaPrincipal.index();
	// 	$('.info-avaliacao').eq(slideAtual).stop().toggle('show');
	// 	$('.slide-avaliacoes>span').removeAttr('style');
	// 	bolinhaPrincipal.css('background-color','#69382c');
	// });

	/**slick**/

	$('.box-avaliacoes').slick({
		centerMode:false,
		slidesToShow:1,
		arrows:false,
		dots:true,
		infinite:false,
	});
})