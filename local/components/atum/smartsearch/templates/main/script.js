function JsSmartSearch(templateURL, ajaxURL, params){
	this.templateURL	= templateURL;
	this.ajaxURL		= ajaxURL;
	this.params		= params;
	this.timer 		= null;
	this.minChars		= params.SEARCH_MIN_CHARS;
	this.searchPage		= params.SEARCH_PAGE;

	this.classMain		= '.js-smartSearch';
	this.classSearch	= '.js-smartSearch-search';
	this.classInput   	= '.js-smartSearch-input';
	this.classClear		= '.js-smartSearch-clear';
	this.classResult	= '.js-smartSearch-result';
	this.classItem    	= '.js-smartSearch-result-item';
}
JsSmartSearch.prototype = { 
	keyup: function(input,event){
		var id = $(input).closest(this.classMain);
		var value = $(input).val();
		var search = id.find(this.classSearch).val();
		
		if (value){
			id.find(this.classClear).addClass('visible');
		}else{
			id.find(this.classClear).removeClass('visible');
		}
				
		if (value.length >= parseInt(this.minChars)){
			if (value != search){
				id.find(this.classResult).html('');
				id.find(this.classResult).removeClass( 'open' );
				id.find(this.classResult).removeClass('loading');
				id.find(this.classResult).addClass( 'loading' );
				
				if(!!this.timer){
					clearTimeout(this.timer);
				}
				this.timer = setTimeout($.proxy(function(){
					this.reload(id,value);
				}, this),1000);
	
				id.find(this.classSearch).val(value);
			}
		}else{
			id.find(this.classResult).html('');
			id.find(this.classResult).removeClass('open');
		}
		if(this.searchPage!==''){
			if (event.keyCode == 13 ){
				searchPage(value,this.searchPage);
			}
		}
	},
	click: function(input,event){
		var id = $(input).closest(this.classMain);
		$(this.classResult+'.open').removeClass('open');
		if (id.find(this.classResult).html()){
			id.find(this.classResult).addClass('open');
		}
		return false;
	},
	clear: function(input,event){
		var id = $(input).closest(this.classMain);
		$(input).removeClass('visible');
		id.find(this.classInput).val('');
		id.find(this.classInput).keyup();
		return false;
	},
	submit: function(input,event){
		if(this.searchPage!==''){
			var id = $(input).closest(this.classMain);
			var value = id.find(this.classInput).val();
			var $window = false;
			if ( event.which == 2 ){ $window = true; }
			if ( event.which == 1 || event.which == 2 ){
				searchPage(value,this.searchPage,$window);
			}
		}	
	},
	more: function(input,event){
		var id = $(input).closest(this.classMain);
		$(input).data('loading', 'y');			
		var visibleCount = id.find(this.classItem+':visible').length;
		var currentPage =  id.find(this.classItem+':visible').eq(visibleCount - 1).data('page');
				
		if (!currentPage){ currentPage = 0; }
				
		var nextPage = currentPage + 1;
				
		id.find(this.classItem+'[data-page="' + nextPage + '"]').fadeIn( 500 );
		id.find(this.classItem+'[data-page="' + nextPage + '"]').addClass('visible');
				
		var invisibleCount = id.find(this.classItem+':hidden').length;
				
		if (invisibleCount == 0 ){ 
			$(input).hide();
		}
				
		setTimeout(function (){ 
			$(input).data('loading', ''); 
		},100);
	},
	reload: function(id,value){
		var result = id.find(this.classResult);
		$.post(this.ajaxURL,{SEARCH:value, PARAMS:this.params, TEMPLATE: this.templateURL}, function (data) {
			result.removeClass( 'loading' );
			result.addClass( 'open' );
			result.html(data);
		},'html');
		return false;
	}
}
function searchPage(input,page,$window = false){
	if (input){
		var url = page+'?q=' + input;
		if ($window){
			window.open(url);
		}else{
			window.location.href = url;
		}	
	}
}
$(document).ready(function (){	
	$(document).mouseup(function (event){
		var id = '.js-smartSearch';
		if (!$(id).is(event.target) && $(id).has(event.target).length === 0) {
			$(id).find('.js-smartSearch-result.open').removeClass('open');
    		}
	});
});

let isOpenedSearch = false;

const toggleSearchNew = () => {
	if (window.innerWidth > 768) {
		const container = window.innerWidth <= 768 ? '.nav-mobile-main ' : ''
		const searchButton = document.querySelector(`${container}.js-smartSearch-submit`);
		const searchInput = document.querySelector(`${container}.js-smartSearch-input`);
		const searchForm = document.querySelector(`${container}.smartSearch-form`);


		if (searchButton && searchInput) {
			if (isOpenedSearch) {
				if (!searchInput.value) {
					isOpenedSearch = false;
					searchInput.style.width = '0';
					searchInput.style.padding = '0';
					searchInput.style.border = 'none';
					searchButton.style.borderRadius = '10px';
					searchButton.style.borderLeft = '1px solid #d5dadc';
				} else {
					searchForm.submit();
				}
			} else {
				searchInput.style.width = '100%';
				searchInput.style.padding = '6px 12px';
				searchInput.style.border = '1px solid #d5dadc';
				searchButton.style.borderRadius = '0 10px 10px 0';
				searchButton.style.borderLeft = 'none';
				isOpenedSearch = true;
			}
		}
	}
}