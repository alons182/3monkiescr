

$(function() {

	$menu			= $('#menu'),
	$menuTop		= $('#menu-top'),
	$dialog         = $('.window'),
	$mainNav		= $menu.find('ul:first'),
	$menuItems		= $mainNav.children('li');
	
	// MENU OBJECT
	var Menu = (function(){
			var init = function() {
				initAddClassMenu();
				initEffectsMenu();
			},
			initAddClassMenu = function(){
				//ADD CLASS LI MENU FOR JOOMLA
				$menu.find('.menu > li').addClass('menu-item');
				$menu.find('.menu > li:nth-child(3n+1)').addClass('orange');
				$menu.find('.menu > li:nth-child(3n+2)').addClass('lime');
				$menu.find('.menu > li:nth-child(3n)').addClass('green');
				
				$menu.find('.menu > li > ul').addClass('submenu');
			},
			initEffectsMenu = function(){
				$menuItems.hover(efectHover,efectleave);
			},
			
			efectHover =function(){
				var height = 60;
				var count = $(this).children().length;
				var heightSub = $(this).children('.submenu').height();

				var expandedHeigh = height+heightSub;
				
				if( count > 1 )
				{
					
					$(this).stop().animate({height: expandedHeigh+"px" , background: 'red'}, 500);
				}
			},
			efectleave =function(){

				$(this).stop().animate({height: "40px" }, 500);
			};
			
					
			//INTERFAZ PUBLICA	
			return {
				init : init
			};

		})();

	var MenuTop = (function(){
			var init				= function() {
				initAddClassMenu();
				initEventsMenuTop();
				closeDialogEvents();
			},
			initAddClassMenu = function(){
				//ADD CLASS LI MENU FOR JOOMLA
				$menuTop.find('.menu > li').addClass('menu-item');
				//$menuTop.find('.menu > li:nth-child(3n+1)').addClass('orange');
				//$menuTop.find('.menu > li:nth-child(3n+2)').addClass('lime');
				//$menuTop.find('.menu > li:nth-child(3n)').addClass('green');
				
				$menuTop.find('.menu > li > ul').addClass('submenu');
			},
			initEventsMenuTop = function(){
				$('<button type="button" id="menutoggle" class="navtoogle" aria-hidden="true"><i aria-hidden="true" class="icon-menu"> </i> Menu</button>').insertBefore($menuTop.find('.menu'));
				$('<li class="menu-item"><a href="../../index.php">Home</a></li>').insertBefore($menuTop.find('.menu > li:first'));
				$menuTop.find('#menutoggle').on('click',function(e){

					//$menuTop.find('.menu').addClass('active')
					changeClass(this, 'navtoogle active', 'navtoogle');
				});

				$menuTop.find('.menu-top-item').on('click',function(e){
					
					
					if(e.currentTarget.id == "reservation")
					{
						if($("#reservationbox #dialog").css("display")=="none") 
						{
							$('.window').fadeOut(200);//hide();
							$('#reservationbox #dialog').fadeIn(200)//show();
						}

						
					}
					if(e.currentTarget.id == "call")
					{
						if($("#callbox #dialogC").css("display")=="none") 
						{
							$('.window').fadeOut(200);//hide();
							$('#callbox #dialogC').fadeIn(200)//show();
						}

					}
					if(e.currentTarget.id == "contact")
					{
						if($("#contactbox #dialogT").css("display")=="none") 
						{
							$('.window').fadeOut(200);//hide();
							$('#contactbox #dialogT').fadeIn(200)//show();
						}

					}
				});
			},
			 changeClass = function (r,className1,className2) {
				var regex = new RegExp("(?:^|\\s+)" + className1 + "(?:\\s+|$)");
				if( regex.test(r.className) ) {
					r.className = r.className.replace(regex,' '+className2+' ');
			    }
			    else{
					r.className = r.className.replace(new RegExp("(?:^|\\s+)" + className2 + "(?:\\s+|$)"),' '+className1+' ');
			    }
			    return r.className;
			},
			closeDialogEvents = function(){
				$dialog.find('.close').on('click',function(e){
					
					 e.preventDefault();
			        	

					$dialog.fadeOut(200)//hide();
					limpiaForm($('#reservationFormTour'));
					limpiaForm($('#reservationFormTrans'));
					limpiaForm($('#contactForm'));
					limpiaChosen();
				});
			};
			
			
			
			
			
					
			//INTERFAZ PUBLICA	
			return {
				init : init
			};

		})();

	//LLAMADA A MENU OBJECT
	Menu.init();
	MenuTop.init();
	

	$.validator.setDefaults({ ignore: ":hidden:not(select)" })
	//
	// LOAD ACTIVITIES FORM RESERVATION
	$.getJSON('/3monkies/helpers/activities.php', function(data) {

		  var items = [];

		  var select = $('#Activitie').empty();
        $.each(data, function(i,item) {
            select.append( '<option value="'
                                 + $.trim(item.title)
                                 + '">'
                                 + item.title
                                 + '</option>' ); 


		 
		});
		
		$(".chosen-select").trigger("chosen:updated");

		 //select.prepend('<option value="">Choose your activities</option>');

	});
	//chosen

	$(".chosen-select").chosen();
	//FORM TYPE
	
	$('#formulario #option').on('change',function(e){
		//console.log($(this).val());
		if($(this).val()=="tour")
		{
			
			$('#formulario').find('#reservationFormTour').show();
			$('#formulario').find('#reservationFormTrans').hide();
			/*$('#formulario').find('p.tour-field').show();
			$('#formulario').find('p.transport-field').hide();*/
		}
		if($(this).val()=="transport")
		{
			$('#formulario').find('#reservationFormTour').hide();
			$('#formulario').find('#reservationFormTrans').show();
			/*$('#formulario').find('p.tour-field').hide();
			$('#formulario').find('p.transport-field').show();*/
		}

	});

	
	//
	//FORM SUBMIT RESERVATION

	$( "#date" ).datepicker();
	$( "#dateP" ).datepicker();
	
	 $("#reservationFormTour").validate({

	 	rules: {
	 		
		    Activitie:{
		    	required: true
		    },
		    category:{
		    	required: true,
		    },
		    Childrens: {

		      required: true,

		      number: true

		    },
		     Adults: {

		      required: true,

		      number: true

		    }
		   

		  },

		  submitHandler: function(form) {

		    var formInput =  $('#reservationFormTour').serializeArray();
			var url = "/3monkies/helpers/reservation.php";
			
			$.post(url, formInput, function(data){
						console.log(data);
						
						limpiaForm($('#reservationFormTour'));
						limpiaChosen();

						if(data=="ok")
							$('.mensaje').html('<span class="ok">Reservation sent successfully</span>');
						else
							$('.mensaje').html('<span class="error">Error sending the reservation</span>');


						setTimeout(function(){  
					        $('.mensaje').fadeOut(200,function() {

							    $('.mensaje span').remove();
							    $('.mensaje').show();

							  });}, 2000);  


					});
		   // form.submit();

		  }

		 });

	 $("#reservationFormTrans").validate({

	 	rules: {
	 		
		    passengers:{
		    	required: true
		    }
		    

		  },

		  submitHandler: function(form) {

		    var formInput =  $('#reservationFormTrans').serializeArray();
			var url = "/3monkies/helpers/reservation.php";
			
			$.post(url, formInput, function(data){
						console.log(data);
						limpiaForm($('#reservationFormTrans'));
						limpiaChosen();


						if(data=="ok")
							$('.mensaje').html('<span class="ok">Reservation sent successfully</span>');
						else
							$('.mensaje').html('<span class="error">Error sending the reservation</span>');

						setTimeout(function(){  
					        $('.mensaje').fadeOut(200,function() {

							    $('.mensaje span').remove();
							    $('.mensaje').show();
							    
							  });}, 2000);  

					});


		   // form.submit();

		  }

		 });

	//FORM SUBMIT CONTACT
	
	 $("#contactForm").validate({

	 	rules: {
	 		
		    comments:{
		    	required: true
		    }

		  },

		  submitHandler: function(form) {

		    var formInput =  $('#contactForm').serializeArray();
			var url = "/3monkies/helpers/contact.php";
		
			$.post(url, formInput, function(data){
						console.log(data);
						limpiaForm($("#contactForm"));

						if(data=="ok")
							$('.mensaje').html('<span class="ok">Comments sent successfully</span>');
						else
							$('.mensaje').html('<span class="error">Error sending the comments</span>');


						setTimeout(function(){  
					        $('.mensaje').fadeOut(200,function() {

							    $('.mensaje span').remove();
							    $('.mensaje').show();
							    
							  });}, 2000);  
					});
		   // form.submit();

		  }

		 });

	 // FUNCTION LIMPIAR FORM
	  function limpiaChosen() {
	 	
	 	$("#Activitie").val('').trigger("chosen:updated");
		$("#category").val('').trigger("chosen:updated");
		$("#Adults").val('').trigger("chosen:updated");
		$("#Childrens").val('').trigger("chosen:updated");
		$("#passengers").val('').trigger("chosen:updated");
		
	}
	 function limpiaForm(miForm) {
	 	
		 // recorremos todos los campos que tiene el formulario
		 $(":input", miForm).each(function() {
		 var type = this.type;
		 var tag = this.tagName.toLowerCase();
		 //limpiamos los valores de los campos…
		if (type == 'text' || type == 'password'  || type == 'email' || tag == 'textarea')
		this.value = "";
		 // excepto de los checkboxes y radios, le quitamos el checked
		 // pero su valor no debe ser cambiado
		 else if (type == 'checkbox' || type == 'radio')
		this.checked = false;
		 // los selects le ponesmos el indice a -
		 else if (tag == 'select')
		this.selectedIndex = -1;
		 });
	}


	//MENU ARTICLE

	$('.tabs li').on('click',function(e){
		//console.log(e.currentTarget.id);
		 e.preventDefault();
		
		if(e.currentTarget.id == "intro")
		{
			if($("#content-article").find('article.intro').css("display")=="none") 
			{
				$('#content-article article').hide();
				$('#content-article').find('article.intro').fadeIn(500);//show();
			}

			
		}
		if(e.currentTarget.id == "details")
		{
			if($("#content-article").find('article.details').css("display")=="none") 
			{
				$('#content-article article').hide();
				$('#content-article').find('article.details').fadeIn(500);//show();
			}

		}
		if(e.currentTarget.id == "rates")
		{
			if($("#content-article").find('article.rates').css("display")=="none") 
			{
				$('#content-article article').hide();
				$('#content-article').find('article.rates').fadeIn(500);//show();
			}

		}
		if(e.currentTarget.id == "map")
		{
			if($("#content-article").find('article.map').css("display")=="none") 
			{
				$('#content-article article').hide();
				$('#content-article').find('article.map').fadeIn(500);//show();
			}

		}
		if(e.currentTarget.id == "booknow")
		{
			//debugger;
			var select = $("#option")
			var tour;
			/*if(e.currentTarget.attributes['data-activitie'] !== undefined)
				tour = e.currentTarget.attributes['data-activitie'].value;
			else
				tour = "";*/

			tour =	$('#content-title > h1').text();
				
			//console.log(select[0]);
			if(e.currentTarget.className =="tr")
			{	
				$("#option option[value='transport']").attr("selected",true);
				select[0].selectedIndex = 1;
				$('#option').trigger('change');
				$(".chosen-select").trigger("chosen:updated");
			}else
			{
				$("#option option[value='tour']").attr("selected",true);
				select[0].selectedIndex = 0;
				
				$("#Activitie option[value='"+ tour +"']").attr("selected",true); //Palo Verde National Park boat & lunch 

				$('#option').trigger('change');
				$(".chosen-select").trigger("chosen:updated");
				
			}


			

			if($("#reservationbox #dialog").css("display")=="none") 
				{
					$('.window').fadeOut(200);//hide();
					$('#reservationbox #dialog').fadeIn(200);//show();
				}

		}

	});

	//ABOUT US TEAM

	$('.team .detail').on('click', function(e){
		
		//debugger;
		if($("#content-article").find('#'+e.currentTarget.id+' + div.description-person').css("display")=="none") 
			{
				$('.description-person').hide();
				$("#content-article").find('#'+e.currentTarget.id+' + div.description-person').fadeIn(500);
			}else
				$("#content-article").find('#'+e.currentTarget.id+' + div.description-person').hide();

		});
	

	//OPTIONAL ACTIVITIES

	$('.opactivities .detail').on('click', function(e){
		
		//debugger;
		if($("#content-article").find('#'+e.currentTarget.id+' + div.description-activitie').css("display")=="none") 
			{
				$('.description-activitie').hide();
				$("#content-article").find('#'+e.currentTarget.id+' + div.description-activitie').fadeIn(500);
			}else
				$("#content-article").find('#'+e.currentTarget.id+' + div.description-activitie').hide();


	});

	//ARENAL OVERNIGHT

	$('.AM .detail-title').on('click', function(e){
		
		//debugger;
		if($("#content-article").find('#'+e.currentTarget.id+' + div.description-day').css("display")=="none") 
			{
				$('.description-day').hide();
				$("#content-article").find('#'+e.currentTarget.id+' + div.description-day').fadeIn(500);
			}else
				$("#content-article").find('#'+e.currentTarget.id+' + div.description-day').hide();


	});

	



});


