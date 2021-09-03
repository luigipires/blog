$(function(){
	var select = document.querySelector('select[name=categoria]');

	select.addEventListener('change',(t) => {
		location.href=include_path+'blog/'+t.target.value;
	});

	if($('.sucesso-mensagem').is(':hidden') == false){
		setTimeout(function(){
			$('.sucesso-mensagem').fadeOut(function(){
				setTimeout(function(){
					location.href=include_path+'blog';
				},1000);
			});
		},3000);
	}
})