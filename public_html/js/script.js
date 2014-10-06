function openAuthorizePopup(){
	$('#overlay').css('display','block');
	$('.popup.authH').css('display','table');
}
function openSendReview(){
	$('#overlay').css('display','block');
	$('.popup.sendReview').css('display','table');
}
function openSendQuestion(){
	$('#overlay').css('display','block');
	$('.popup.sendQuestion').css('display','table');
}
$(document).ready(function(){
	//закрытие всплывающего окна при клике вне окна
	$('#overlay').click(function(e) {
		exit_call();
	});
});
function exit_call(){
	$('#overlay').css('display','none');
	$('.popup').css('display','none');
}


$( document ).ready(function(){
	
	$(window).load(function() {
		$("body").removeClass("preload");
	});

	//Добавление класса для показа панели поиска
	$("#searchButton").click(function(){
		$("#siteSearch").toggleClass("visible");
	});

	//tabs
	$('.tabs').each(function(){
		var tabs=$(this),
		btTabs=tabs.children('.btTabs'),
		contents=tabs.children('.contentTabs');
		btTabs.children('.bt').click(function(){
			btTabs.children('.bt').removeClass('active');
			contents.children('.contentTab').removeClass('active');	
			$(this).addClass('active');
			contents.children('.contentTab:eq('+$(this).index()+')').addClass('active');
		});
		btTabs.children('.bt:first').trigger('click');
	});


	//Стилизация селектов
	$('select').styler(); 


	//dropdown
	$('.accParent').click(function(){

		if ($(this).hasClass('active'))
		{
			$(this).children('.accDropdown').slideUp(200);
			$(this).removeClass('active');
		}
		else
		{
			$('.accDropdown').slideUp(200);
			$('.accParent').removeClass('active');
			$(this).children('.accDropdown').slideToggle(200);
			$(this).addClass('active');
		}
		
	});


	$("#selectCountry").change(function(){
		$.ajax({
			type: "POST",
			data: {country_id: $(this).val()},
			url: "/ajax/getRegions.php",
			success: function (data) {
				$("#selectRegion").html(data);
				$("#selectRegion select").styler();
			}
		});
	});
  
  $('.colorbox').colorbox({
    /*innerWidth: '90%',*/
    rel:'groupPhoto',
    maxWidth:'98%',
    maxHeight:'98%'
  });
	
});




