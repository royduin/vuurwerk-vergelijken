$(window).bind('resize load',function(){
	if( $(this).width() < 768 ){
		$('#filters').removeClass('in').addClass('out').removeClass('hidden-xs');
	} else {
		$('#filters').removeClass('out').addClass('in').removeAttr('style');
	}
});

(function()
{
	// Fancybox
	$('.fancybox').fancybox({
		padding: 0,
		width: '90%',
		height: '90%',
		helpers: {
			media: {}
		},
		youtube: {
			autoplay: 1,
			hd: 1,
			vq: 'hd1080'
		}
	});

	// Tooltip
	$('[data-toggle="tooltip"]').tooltip();

	// Add price
	$('.add-price').on('click',function()
	{
		$('#addPrice').modal('show');
		$('.modal#addPrice #add-price-product-id').val( $(this).data('product-id') );
		$('.modal#addPrice #add-price-product').html( $(this).data('product') );
		$('.modal#addPrice #add-price-year').val( $(this).data('jaar') );
		if( $(this).data('store-id') ){
			$('.modal#addPrice #add-price-store option[value='+$(this).data('store-id')+']').attr('selected','selected');
		} else {
			$('.modal#addPrice #add-price-store option[value=0]').attr('selected','selected');
		}
		return false;
	});

	// Add price submit
	$('#add-price-submit').on('click',function()
	{
		// Get the modal form
		modalForm = $('.modal#addPrice form');

		// Show loader
		$('#loader').show();

		$.ajax({
			data: {
				product_id: modalForm.find('#add-price-product-id').val(),
				jaar: modalForm.find('#add-price-year').val(),
				store: modalForm.find('#add-price-store').val(),
				amount: modalForm.find('#add-price-amount').val(),
				price: modalForm.find('#add-price-price').val(),
				source: modalForm.find('#add-price-source').val(),
				csrf_vuurwerk_vergelijken: modalForm.find('[name=csrf_vuurwerk_vergelijken]').val()
			},
			type: 'POST',
			url: modalForm.attr('action'),
			success: function(data){
				if(data['success'])
				{
					// Clear values
					modalForm.find('input[type=text]').val('');

					// Hide modal
					$('#addPrice').modal('hide');

					// Show thank you message
					alert('Bedankt voor het toevoegen van een prijs! De prijs wordt z.s.m. toegevoegd.');

				} else
				{
					// Remove previous errors
					modalForm.find('.error-message').remove();
					modalForm.find('.has-error').removeClass('has-error');

					// Loop through the errors
					$(data['errors']).each(function(k,error)
					{
						// Add errors message and error status
						$('#add-price-'+error['field']).closest('.col-sm-10').append('<p class="help-block error-message">'+error['error']+'</p>').closest('.form-group').addClass('has-error');
					});
				}
			},
			error: function(){
				alert('Er ging iets fout, probeer het later nog een keer!');
			},
			complete: function(){
				// hide loader
				$('#loader').hide();
			}
		});
	});

	// Add store
	$('.add-store').on('click',function()
	{
		$('#addPrice').modal('hide');
		$('#addStore').modal('show');
		return false;
	});

	// Add store submit
	$('#add-store-submit').on('click',function()
	{
		// Get the modal form
		modalForm = $('.modal#addStore form');

		// Show loader
		$('#loader').show();

		$.ajax({
			data: {
				name: modalForm.find('#add-store-name').val(),
				website: modalForm.find('#add-store-website').val(),
				csrf_vuurwerk_vergelijken: modalForm.find('[name=csrf_vuurwerk_vergelijken]').val()
			},
			type: 'POST',
			url: modalForm.attr('action'),
			success: function(data){
				if(data['success'])
				{
					// Clear values
					modalForm.find('input[type=text]').val('');

					// Hide modal
					$('#addStore').modal('hide');

					// Show thank you message
					alert('Bedankt voor het toevoegen van een winkel! De winkel wordt z.s.m. toegevoegd.');

				} else
				{
					// Remove previous errors
					modalForm.find('.error-message').remove();
					modalForm.find('.has-error').removeClass('has-error');

					// Loop through the errors
					$(data['errors']).each(function(k,error)
					{
						// Add errors message and error status
						$('#add-store-'+error['field']).closest('.col-sm-9').append('<p class="help-block error-message">'+error['error']+'</p>').closest('.form-group').addClass('has-error');
					});
				}
			},
			error: function(){
				alert('Er ging iets fout, probeer het later nog een keer!');
			},
			complete: function(){
				// hide loader
				$('#loader').hide();
			}
		});
	});

	// Add product
	$('.add-product').on('click',function()
	{
		$('#addProduct').modal('show');
		return false;
	});

	// Add product submit
	$('#add-product-submit').on('click',function()
	{
		// Get the modal form
		modalForm = $('.modal#addProduct form');

		// Show loader
		$('#loader').show();

		var data = {
			naam: modalForm.find('#add-product-naam').val(),
			artikelnummer: modalForm.find('#add-product-artikelnummer').val(),
			nieuw: modalForm.find('#add-product-nieuw').val(),
			buitenland: modalForm.find('#add-product-buitenland').is(":checked") ? 1 : 0,
			soort: modalForm.find('#add-product-soort').val(),
			importeur: modalForm.find('#add-product-importeur').val(),
			merk: modalForm.find('#add-product-merk').val(),
			aantal: modalForm.find('#add-product-aantal').val(),
			inch: modalForm.find('#add-product-inch').val(),
			schoten: modalForm.find('#add-product-schoten').val(),
			gram: modalForm.find('#add-product-gram').val(),
			tube: modalForm.find('#add-product-tube').val(),
			duur: modalForm.find('#add-product-duur').val(),
			hoogte: modalForm.find('#add-product-hoogte').val(),
			lengte: modalForm.find('#add-product-lengte').val(),
			video: modalForm.find('#add-product-video').val(),
			omschrijving: modalForm.find('#add-product-omschrijving').val(),
			afbeelding: modalForm.find('#add-product-afbeelding').val(),
			csrf_vuurwerk_vergelijken: modalForm.find('[name=csrf_vuurwerk_vergelijken]').val()
		}

		if(modalForm.find('#add-product-slug').length){
			data.slug = modalForm.find('#add-product-slug').val()
		}

		$.ajax({
			data: data,
			type: 'POST',
			url: modalForm.attr('action'),
			success: function(data){
				if(data['success'])
				{
					// Clear values
					modalForm.find('input[type=text]').val('');
					modalForm.find('input[type=textarea]').val('');
					modalForm.find('input[type=checkbox]').attr('checked', false);

					// Hide modal
					$('#addProduct').modal('hide');

					// Show thank you message
					alert('Bedankt voor het toevoegen van een product! Het product wordt z.s.m. toegevoegd.');

				} else
				{
					// Remove previous errors
					modalForm.find('.error-message').remove();
					modalForm.find('.has-error').removeClass('has-error');

					// Loop through the errors
					$(data['errors']).each(function(k,error)
					{
						// Add errors message and error status
						$('#add-product-'+error['field']).closest('.col-sm-9').append('<p class="help-block error-message">'+error['error']+'</p>').closest('.form-group').addClass('has-error');
					});
				}
			},
			error: function(){
				alert('Er ging iets fout, probeer het later nog een keer!');
			},
			complete: function(){
				// hide loader
				$('#loader').hide();
			}
		});
	});

	// Edit product
	$('.edit-product').on('click',function()
	{
		alert('Het is nog niet mogelijk om producten te bewerken, klopt er iets niet of heb je iets toe te voegen? Laat het ons weten!');
		return false;
	});

	// Add video
	$('.add-video').on('click',function()
	{
		$('#addVideo').modal('show');
		$('.modal#addVideo #add-video-product-id').val( $(this).data('product-id') );
		$('.modal#addVideo #add-video-product').html( $(this).data('product') );
		return false;
	});

	// Add video submit
	$('#add-video-submit').on('click',function()
	{
		// Get the modal form
		modalForm = $('.modal#addVideo form');

		// Show loader
		$('#loader').show();

		$.ajax({
			data: {
				product_id: modalForm.find('#add-video-product-id').val(),
				titel: modalForm.find('#add-video-titel').val(),
				video: modalForm.find('#add-video-video').val(),
				csrf_vuurwerk_vergelijken: modalForm.find('[name=csrf_vuurwerk_vergelijken]').val()
			},
			type: 'POST',
			url: modalForm.attr('action'),
			success: function(data){
				if(data['success'])
				{
					// Clear values
					modalForm.find('input[type=text]').val('');

					// Hide modal
					$('#addVideo').modal('hide');

					// Show thank you message
					alert('Bedankt voor het toevoegen van een video! De video wordt z.s.m. toegevoegd.');

				} else
				{
					// Remove previous errors
					modalForm.find('.error-message').remove();
					modalForm.find('.has-error').removeClass('has-error');

					// Loop through the errors
					$(data['errors']).each(function(k,error)
					{
						// Add errors message and error status
						$('#add-video-'+error['field']).closest('.col-sm-9').append('<p class="help-block error-message">'+error['error']+'</p>').closest('.form-group').addClass('has-error');
					});
				}
			},
			error: function(){
				alert('Er ging iets fout, probeer het later nog een keer!');
			},
			complete: function(){
				// hide loader
				$('#loader').hide();
			}
		});
	});

	// Product ratings
	$('.product .rating a').hover(function(){
		$(this).prevAll().addClass('hover');
	},function(){
		$('.rating a').removeClass('hover');
	}).on('click',function()
	{
		// Show loader
		$('#loader').show();
		
		$.ajax({
			data: {
				product_id: $(this).parent().data('product-id'),
				rating: $(this).data('star'),
				csrf_vuurwerk_vergelijken: $('.modal#addPrice form').find('[name=csrf_vuurwerk_vergelijken]').val()
			},
			type: 'POST',
			url: $(this).parent().data('ajax-url'),
			success: function(data)
			{
				if(data['status'] == 'added'){
					alert('Je stem is toegevoegd');
				} else {
					alert('Je stem is gewijzigd');
				}
				location.reload();
			},
			error: function()
			{
				alert('Er ging iets fout, probeer het later nog een keer!');
			},
			complete: function()
			{
				// hide loader
				$('#loader').hide();
			}

		});

		return false;
	});

	// Store ratings
	$('.store .rating a').hover(function(){
		$(this).prevAll().addClass('hover');
	},function(){
		$('.rating a').removeClass('hover');
	}).on('click',function()
	{
		// Show loader
		$('#loader').show();
		
		$.ajax({
			data: {
				winkel_id: $(this).parent().data('winkel-id'),
				rating: $(this).data('star'),
				csrf_vuurwerk_vergelijken: $(this).parent().data('csrf')
			},
			type: 'POST',
			url: $(this).parent().data('ajax-url'),
			success: function(data)
			{
				if(data['status'] == 'added'){
					alert('Je stem is toegevoegd');
				} else {
					alert('Je stem is gewijzigd');
				}
				location.reload();
			},
			error: function()
			{
				alert('Er ging iets fout, probeer het later nog een keer!');
			},
			complete: function()
			{
				// hide loader
				$('#loader').hide();
			}

		});

		return false;
	});

	// Add product behaviour for types when adding products
	$('#soort_id,#add-product-soort').on('change',function()
	{
		specifications = $(this).find('option:selected').data('specificaties').split(',');

		$('.spec').each(function(key,value){
			if(specifications.indexOf($(value).attr('name').replace('add-product-','')) != -1){
				$(value).closest('.form-group').removeClass('hidden');
			} else {
				$(value).closest('.form-group').addClass('hidden');
			}
		});
	});

	// Calculate "gram per tube"
	$('#gram,#schoten').on('change',function()
	{
		if( $('#schoten').is(':visible') && $('#tube').is(':visible') ){
			count = parseFloat($('#gram').val()) / parseFloat($('#schoten').val());
			if(!isNaN(count)){
				$('#tube').val( Math.round(count * 100) / 100 );
			}
		}
	});
	$('#add-product-gram,#add-product-schoten').on('change',function()
	{
		if( $('#add-product-schoten').is(':visible') && $('#add-product-tube').is(':visible') ){
			count = parseFloat($('#add-product-gram').val()) / parseFloat($('#add-product-schoten').val());
			if(!isNaN(count)){
				$('#add-product-tube').val( Math.round(count * 100) / 100 );
			}
		}
	});

	// Generate a slug
	$('#naam').on('keyup',function(){
		var slug = $('#slug');
		if(slug.length){
			slug.val($(this).val().toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-'));
		}
	});
	$('#add-product-naam').on('keyup',function(){
		var slug = $('#add-product-slug');
		if(slug.length){
			slug.val($(this).val().toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-'));
		}
	});

	// Generate the search on Youtube link
	$('#artikelnummer,#add-product-artikelnummer').on('change',function(){
		var videoLink = $('#video_link');
		if(videoLink.length){
			videoLink.attr('href',videoLink.data('href')+encodeURIComponent($(this).val())+'%20'+encodeURIComponent(typeof $('#naam').val() != 'undefined' ? $('#naam').val() : $('#add-product-naam').val()));
		}
	});

	// Add to wishlist
	$('.add-wishlist').on('click',function()
	{
		// Show loader
		$('#loader').show();
		
		$.ajax({
			data: {
				product_id: $(this).data('product-id'),
				csrf_vuurwerk_vergelijken: $('.modal#addPrice form').find('[name=csrf_vuurwerk_vergelijken]').val()
			},
			type: 'POST',
			url: $(this).data('ajax-url'),
			success: function(data)
			{
				alert('Het product is toegevoegd aan je verlanglijst');
				location.reload();
			},
			error: function()
			{
				alert('Er ging iets fout, probeer het later nog een keer!');
			},
			complete: function()
			{
				// hide loader
				$('#loader').hide();
			}

		});

		return false;
	});

	// Remove from wishlist
	$('.remove-wishlist').on('click',function()
	{
		// Show loader
		$('#loader').show();
		
		$.ajax({
			data: {
				product_id: $(this).data('product-id'),
				csrf_vuurwerk_vergelijken: $('.modal#addPrice form').find('[name=csrf_vuurwerk_vergelijken]').val()
			},
			type: 'POST',
			url: $(this).data('ajax-url'),
			success: function(data)
			{
				alert('Het product is verwijderd van je verlanglijst');
				location.reload();
			},
			error: function()
			{
				alert('Er ging iets fout, probeer het later nog een keer!');
			},
			complete: function()
			{
				// hide loader
				$('#loader').hide();
			}

		});

		return false;
	});

	// Remove all from wishlist
	$('.clear-wishlist').on('click',function()
	{
		// Show loader
		$('#loader').show();
		
		$.ajax({
			data: {
				csrf_vuurwerk_vergelijken: $('.modal#addPrice form').find('[name=csrf_vuurwerk_vergelijken]').val()
			},
			type: 'POST',
			url: $(this).data('ajax-url'),
			success: function(data)
			{
				alert('Alle producten zijn verwijderd van je verlanglijst');
				location.reload();
			},
			error: function()
			{
				alert('Er ging iets fout, probeer het later nog een keer!');
			},
			complete: function()
			{
				// hide loader
				$('#loader').hide();
			}

		});

		return false;
	});

	// Change amount from wishlist
	$('.change-wishlist').on('click',function(){
		alert('Deze functionaliteit is nog niet klaar, wil je deze functionaliteit snel gebruiken? Help ons om van vuurwerk-vergelijken.nl een succes te maken door producten en prijzen toe te voegen.');
		return false;
	});

	// Homepage countdown
	if( $('.progress-bar').length ){
		$('.progress-bar').countdown('2016/12/31 0:0:0',function(e){
			format = 'Nog';
			if(e.offset.weeks > 0){
				format += ' %-w %!w:week,weken;';
			}
			if(e.offset.days > 0){
				format += ' %-d dag%!d:en;';
			}
			if(e.offset.hours > 0){
				format += ' %-H %!H:uur,uren;';
			}
			if(e.offset.minutes > 0){
				format += ' %-M %!M:minuut,minuten;';
			}
			if(e.offset.seconds > 0){
				format += ' %-S %!S:seconde,seconden;';
			}
			format += ' tot het nieuwe jaar!';
			$(this).text(e.strftime(format)).width(100 - (e.offset.totalDays * 100 / 365)+'%').attr('aria-valuenow',100 - (e.offset.totalDays * 100 / 365));

		}).on('finish.countdown',function(){
			$(this).text('Gelukkig nieuw jaar!');
		});
	}

	// Filters
	$('#colletie').on('change',function(){
		window.location.href = $(this).val()+location.search+'#producten';
	});

	$('#importeur,#jaar').on('change',function(){
		redirecter($(this).attr('id'),$(this).val());
	});

	if($('.slider').length){
		var sliderTooltip = $.Link({
			target: '-tooltip-<div class="slider-tooltip"></div>'
		});
	}

	$('.slider').each(function(){
		start = $(this).data('start');
		end = $(this).data('end');
		value = $(this).data('value').toString().split('-');
		if(isNaN(value[0]) || value[0] > end || value[0] < start || value[0] < 0 || value[0] == ''){
			value[0] = start;
		}
		if(isNaN(value[1]) || value[1] > end || value[1] < start || value[1] < 0 || value[1] == ''){
			value[1] = end;
		}
		$(this).noUiSlider({
			start: [value[0],value[1]],
			step: 1,
			range: {
				'min': start,
				'max': end
			},
			serialization: {
				lower: [sliderTooltip],
				upper: [sliderTooltip],
				format: {
					decimals: 0
				}
			}
		}).on('change',function(){
			redirecter($(this).data('spec'),$(this).val().toString().replace(',','-'));
		});
	});

	// Register
	$('.register').on('click',function(){
		$('#register').modal('show');
		return false;
	});

	// Register submit
	$('#register-submit').on('click',function()
	{
		// Get the modal form
		modalForm = $('.modal#register form');

		// Show loader
		$('#loader').show();

		$.ajax({
			data: {
				username: modalForm.find('#register-username').val(),
				email: modalForm.find('#register-email').val(),
				password: modalForm.find('#register-password').val(),
				password2: modalForm.find('#register-password2').val(),
				csrf_vuurwerk_vergelijken: modalForm.find('[name=csrf_vuurwerk_vergelijken]').val()
			},
			type: 'POST',
			url: modalForm.attr('action'),
			success: function(data){
				if(data['success'])
				{
					// Clear values
					modalForm.find('input[type=text]').val('');
					modalForm.find('input[type=password]').val('');

					// Hide modal
					$('#register').modal('hide');

					// Show thank you message
					alert('Bedankt voor het aanmaken van een account. Je kan nu direct inloggen.');

				} else
				{
					// Remove previous errors
					modalForm.find('.error-message').remove();
					modalForm.find('.has-error').removeClass('has-error');

					// Loop through the errors
					$(data['errors']).each(function(k,error)
					{
						// Add errors message and error status
						$('#register-'+error['field']).closest('.col-sm-8').append('<p class="help-block error-message">'+error['error']+'</p>').closest('.form-group').addClass('has-error');
					});
				}
			},
			error: function(){
				alert('Er ging iets fout, probeer het later nog een keer!');
			},
			complete: function(){
				// hide loader
				$('#loader').hide();
			}
		});
	});
	
	// Login
	$('.login').on('click',function(){
		$('#login').modal('show');
		return false;
	});

	// Login submit
	$('#login-submit').on('click',function()
	{
		// Get the modal form
		modalForm = $('.modal#login form');

		// Show loader
		$('#loader').show();

		$.ajax({
			data: {
				email: modalForm.find('#login-email').val(),
				password: modalForm.find('#login-password').val(),
				remember: modalForm.find('#login-stay').is(':checked'),
				csrf_vuurwerk_vergelijken: modalForm.find('[name=csrf_vuurwerk_vergelijken]').val()
			},
			type: 'POST',
			url: modalForm.attr('action'),
			success: function(data){
				if(data['success'])
				{
					// Clear values
					modalForm.find('input[type=text]').val('');
					modalForm.find('input[type=password]').val('');

					// Hide modal
					$('#login').modal('hide');

					// Show thank you message
					alert('Je bent succesvol ingelogd!');
					location.reload();

				} else
				{
					// Remove previous errors
					modalForm.find('.error-message').remove();
					modalForm.find('.has-error').removeClass('has-error');

					// Loop through the errors
					$(data['errors']).each(function(k,error)
					{
						// Add errors message and error status
						$('#login-'+error['field']).closest('.col-sm-9').append('<p class="help-block error-message">'+error['error']+'</p>').closest('.form-group').addClass('has-error');
					});
				}
			},
			error: function(){
				alert('Er ging iets fout, probeer het later nog een keer!');
			},
			complete: function(){
				// hide loader
				$('#loader').hide();
			}
		});
	});

})();

function redirecter(attr,value){
	loc = location.href;
	lastSegment = location.href.substr(location.href.lastIndexOf('/') + 1).replace(location.hash,'');
	if(!isNaN(lastSegment)){
		loc = location.href.replace(location.href.substr(location.href.lastIndexOf('/') + 1), '');
	}
	if(location.search){
		if(getParameterByName(attr) == ''){
			url = loc+'&'+attr+'='+value;
		} else {
			if(value == '0'){
				url = removeURLParameter(loc,attr);
			} else {
				url = loc.replace(getParameterByName(attr),value);
			}
		}
	} else {
		url = loc+'?'+attr+'='+value;
	}
	window.location.href = url.replace(location.hash,'')+'#producten';
}

function getParameterByName(name){
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function removeURLParameter(url, parameter){
    var urlparts = url.split('?');
    if (urlparts.length >= 2) {
        var prefix = encodeURIComponent(parameter)+'=';
        var pars = urlparts[1].split(/[&;]/g);
        for (var i= pars.length; i-- > 0;) {
            if (pars[i].lastIndexOf(prefix, 0) !== -1) {
                pars.splice(i, 1);
            }
        }
        if(pars.length != 0){
			url = urlparts[0]+'?'+pars.join('&');
		} else {
			url = urlparts[0];
        }
        return url;
    } else {
        return url;
    }
}
