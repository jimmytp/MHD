/*
 * jQuery Superfish Menu Plugin
 * Copyright (c) 2013 Joel Birch
 *
 * Dual licensed under the MIT and GPL licenses:
 *	http://www.opensource.org/licenses/mit-license.php
 *	http://www.gnu.org/licenses/gpl.html
 */

(function (jQuery) {
	"use strict";

	var methods = (function () {
		// private properties and methods go here
		var c = {
				bcClass: 'sf-breadcrumb',
				menuClass: 'sf-js-enabled',
				anchorClass: 'sf-with-ul',
				menuArrowClass: 'sf-arrows'
			},
			ios = (function () {
				var ios = /iPhone|iPad|iPod/i.test(navigator.userAgent);
				if (ios) {
					// iOS clicks only bubble as far as body children
					jQuery(window).load(function () {
						jQuery('body').children().on('click', jQuery.noop);
					});
				}
				return ios;
			})(),
			wp7 = (function () {
				var style = document.documentElement.style;
				return ('behavior' in style && 'fill' in style && /iemobile/i.test(navigator.userAgent));
			})(),
			toggleMenuClasses = function (jQuerymenu, o) {
				var classes = c.menuClass;
				if (o.cssArrows) {
					classes += ' ' + c.menuArrowClass;
				}
				jQuerymenu.toggleClass(classes);
			},
			setPathToCurrent = function (jQuerymenu, o) {
				return jQuerymenu.find('li.' + o.pathClass).slice(0, o.pathLevels)
					.addClass(o.hoverClass + ' ' + c.bcClass)
						.filter(function () {
							return (jQuery(this).children(o.popUpSelector).hide().show().length);
						}).removeClass(o.pathClass);
			},
			toggleAnchorClass = function (jQueryli) {
				jQueryli.children('a').toggleClass(c.anchorClass);
			},
			toggleTouchAction = function (jQuerymenu) {
				var touchAction = jQuerymenu.css('ms-touch-action');
				touchAction = (touchAction === 'pan-y') ? 'auto' : 'pan-y';
				jQuerymenu.css('ms-touch-action', touchAction);
			},
			applyHandlers = function (jQuerymenu, o) {
				var targets = 'li:has(' + o.popUpSelector + ')';
				if (jQuery.fn.hoverIntent && !o.disableHI) {
					jQuerymenu.hoverIntent(over, out, targets);
				}
				else {
					jQuerymenu
						.on('mouseenter.superfish', targets, over)
						.on('mouseleave.superfish', targets, out);
				}
				var touchevent = 'MSPointerDown.superfish';
				if (!ios) {
					touchevent += ' touchend.superfish';
				}
				if (wp7) {
					touchevent += ' mousedown.superfish';
				}
				jQuerymenu
					.on('focusin.superfish', 'li', over)
					.on('focusout.superfish', 'li', out)
					.on(touchevent, 'a', o, touchHandler);
			},
			touchHandler = function (e) {
				var jQuerythis = jQuery(this),
					jQueryul = jQuerythis.siblings(e.data.popUpSelector);

				if (jQueryul.length > 0 && jQueryul.is(':hidden')) {
					jQuerythis.one('click.superfish', false);
					if (e.type === 'MSPointerDown') {
						jQuerythis.trigger('focus');
					} else {
						jQuery.proxy(over, jQuerythis.parent('li'))();
					}
				}
			},
			over = function () {
				var jQuerythis = jQuery(this),
					o = getOptions(jQuerythis);
				clearTimeout(o.sfTimer);
				jQuerythis.siblings().superfish('hide').end().superfish('show');
			},
			out = function () {
				var jQuerythis = jQuery(this),
					o = getOptions(jQuerythis);
				if (ios) {
					jQuery.proxy(close, jQuerythis, o)();
				}
				else {
					clearTimeout(o.sfTimer);
					o.sfTimer = setTimeout(jQuery.proxy(close, jQuerythis, o), o.delay);
				}
			},
			close = function (o) {
				o.retainPath = (jQuery.inArray(this[0], o.jQuerypath) > -1);
				this.superfish('hide');

				if (!this.parents('.' + o.hoverClass).length) {
					o.onIdle.call(getMenu(this));
					if (o.jQuerypath.length) {
						jQuery.proxy(over, o.jQuerypath)();
					}
				}
			},
			getMenu = function (jQueryel) {
				return jQueryel.closest('.' + c.menuClass);
			},
			getOptions = function (jQueryel) {
				return getMenu(jQueryel).data('sf-options');
			};

		return {
			// public methods
			hide: function (instant) {
				if (this.length) {
					var jQuerythis = this,
						o = getOptions(jQuerythis);
					if (!o) {
						return this;
					}
					var not = (o.retainPath === true) ? o.jQuerypath : '',
						jQueryul = jQuerythis.find('li.' + o.hoverClass).add(this).not(not).removeClass(o.hoverClass).children(o.popUpSelector),
						speed = o.speedOut;

					if (instant) {
						jQueryul.show();
						speed = 0;
					}
					o.retainPath = false;
					o.onBeforeHide.call(jQueryul);
					jQueryul.stop(true, true).animate(o.animationOut, speed, function () {
						var jQuerythis = jQuery(this);
						o.onHide.call(jQuerythis);
					});
				}
				return this;
			},
			show: function () {
				var o = getOptions(this);
				if (!o) {
					return this;
				}
				var jQuerythis = this.addClass(o.hoverClass),
					jQueryul = jQuerythis.children(o.popUpSelector);

				o.onBeforeShow.call(jQueryul);
				jQueryul.stop(true, true).animate(o.animation, o.speed, function () {
					o.onShow.call(jQueryul);
				});
				return this;
			},
			destroy: function () {
				return this.each(function () {
					var jQuerythis = jQuery(this),
						o = jQuerythis.data('sf-options'),
						jQueryhasPopUp;
					if (!o) {
						return false;
					}
					jQueryhasPopUp = jQuerythis.find(o.popUpSelector).parent('li');
					clearTimeout(o.sfTimer);
					toggleMenuClasses(jQuerythis, o);
					toggleAnchorClass(jQueryhasPopUp);
					toggleTouchAction(jQuerythis);
					// remove event handlers
					jQuerythis.off('.superfish').off('.hoverIntent');
					// clear animation's inline display style
					jQueryhasPopUp.children(o.popUpSelector).attr('style', function (i, style) {
						return style.replace(/display[^;]+;?/g, '');
					});
					// reset 'current' path classes
					o.jQuerypath.removeClass(o.hoverClass + ' ' + c.bcClass).addClass(o.pathClass);
					jQuerythis.find('.' + o.hoverClass).removeClass(o.hoverClass);
					o.onDestroy.call(jQuerythis);
					jQuerythis.removeData('sf-options');
				});
			},
			init: function (op) {
				return this.each(function () {
					var jQuerythis = jQuery(this);
					if (jQuerythis.data('sf-options')) {
						return false;
					}
					var o = jQuery.extend({}, jQuery.fn.superfish.defaults, op),
						jQueryhasPopUp = jQuerythis.find(o.popUpSelector).parent('li');
					o.jQuerypath = setPathToCurrent(jQuerythis, o);

					jQuerythis.data('sf-options', o);

					toggleMenuClasses(jQuerythis, o);
					toggleAnchorClass(jQueryhasPopUp);
					toggleTouchAction(jQuerythis);
					applyHandlers(jQuerythis, o);

					jQueryhasPopUp.not('.' + c.bcClass).superfish('hide', true);

					o.onInit.call(this);
				});
			}
		};
	})();

	jQuery.fn.superfish = function (method, args) {
		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		}
		else if (typeof method === 'object' || ! method) {
			return methods.init.apply(this, arguments);
		}
		else {
			return jQuery.error('Method ' +  method + ' does not exist on jQuery.fn.superfish');
		}
	};

	jQuery.fn.superfish.defaults = {
		popUpSelector: 'ul,.sf-mega', // within menu context
		hoverClass: 'sfHover',
		pathClass: 'overrideThisToUse',
		pathLevels: 1,
		delay: 800,
		animation: {opacity: 'show'},
		animationOut: {opacity: 'hide'},
		speed: 'normal',
		speedOut: 'fast',
		cssArrows: true,
		disableHI: false,
		onInit: jQuery.noop,
		onBeforeShow: jQuery.noop,
		onShow: jQuery.noop,
		onBeforeHide: jQuery.noop,
		onHide: jQuery.noop,
		onIdle: jQuery.noop,
		onDestroy: jQuery.noop
	};

	// soon to be deprecated
	jQuery.fn.extend({
		hideSuperfishUl: methods.hide,
		showSuperfishUl: methods.show
	});

})(jQuery);
(function($){
	
	//plugin's default options
	var settings = {
		combine: true,					//combine multiple menus into a single select
		groupPageText: 'Main',			//optgroup's aren't selectable, make an option for it
		nested: true,					//create optgroups by default
		prependTo: '#mainmenu',				//insert at top of page by default
		switchWidth: 600,				//width at which to switch to select, and back again
		topOptionText: 'Menu'	//default "unselected" state
	},
	
	//used to store original matched menus
	$menus,
	
	//used as a unique index for each menu if no ID exists
	menuCount = 0,
	
	//used to store unique list items for combining lists
	uniqueLinks = [];


	//go to page
	function goTo(url){
		document.location.href = url;
	}
	
	//does menu exist?
	function menuExists(){
		return ($('.mnav').length) ? true : false;
	}

	//validate selector's matched list(s)
	function isList($this){
		var pass = true;
		$this.each(function(){
			if(!$(this).is('ul') && !$(this).is('ol')){
				pass=false;
			}
		});
		return pass;
	}//isList()


	//function to decide if mobile or not
	function isMobile(){
		return ($(window).width() < settings.switchWidth);
	}
	
	
	//function to get text value of element, but not it's children
	function getText($item){
		return $.trim($item.clone().children('ul, ol').remove().end().text());
	}
	
	//function to check if URL is unique
	function isUrlUnique(url){
		return ($.inArray(url, uniqueLinks) === -1) ? true : false;
	}
	
	
	//function to do duplicate checking for combined list
	function checkForDuplicates($menu){
		
		$menu.find(' > li').each(function(){
		
			var $li = $(this),
				link = $li.find('a').attr('href'),
				parentLink = function(){
					if($li.parent().parent().is('li')){
						return $li.parent().parent().find('a').attr('href');
					} else {
						return null;
					}
				};
						
			//check nested <li>s before checking current one
			if($li.find(' ul, ol').length){
				checkForDuplicates($li.find('> ul, > ol'));
			}
		
			//remove empty UL's if any are left by LI removals
			if(!$li.find(' > ul li, > ol li').length){
				$li.find('ul, ol').remove();
			}
		
			//if parent <li> has a link, and it's not unique, append current <li> to the "unique parent" detected earlier
			if(!isUrlUnique(parentLink(), uniqueLinks) && isUrlUnique(link, uniqueLinks)){
				$li.appendTo(
					$menu.closest('ul#mmnav').find('li:has(a[href='+parentLink()+']):first ul')
				);
			}
			
			//otherwise, check if the current <li> is unique, if it is, add it to the unique list
			else if(isUrlUnique(link)){
				uniqueLinks.push(link);
			}
			
			//if it isn't, remove it. Simples.
			else{
				$li.remove();
			}
		
		});
	}
	
	
	//function to combine lists into one
	function combineLists(){
		
		//create a new list
		var $menu = $('<ul id="mmnav" />');
		
		//loop through each menu and extract the list's child items
		//then append them to the new list
		$menus.each(function(){
			$(this).children().clone().appendTo($menu);
		});
		
		//de-duplicate any repeated items
		checkForDuplicates($menu);
				
		//return new combined list
		return $menu;
		
	}//combineLists()
	
	
	
	//function to create options in the select menu
	function createOption($item, $container, text){
		
		//if no text param is passed, use list item's text, otherwise use settings.groupPageText
		if(!text){
			$('<option value="'+$item.find('a:first').attr('href')+'">'+$.trim(getText($item))+'</option>').appendTo($container);
		} else {
			$('<option value="'+$item.find('a:first').attr('href')+'">'+text+'</option>').appendTo($container);
		}
	
	}//createOption()
	
	
	
	//function to create option groups
	function createOptionGroup($group, $container){
		
		//create <optgroup> for sub-nav items
		var $optgroup = $('<optgroup label="'+$.trim(getText($group))+'" />');
		
		//append top option to it (current list item's text)
		createOption($group,$optgroup, settings.groupPageText);
	
		//loop through each sub-nav list
		$group.children('ul, ol').each(function(){
		
			//loop through each list item and create an <option> for it
			$(this).children('li').each(function(){
				createOption($(this), $optgroup);
			});
		});
		
		//append to select element
		$optgroup.appendTo($container);
		
	}//createOptionGroup()

	
	
	//function to create <select> menu
	function createSelect($menu){
	
		//create <select> to insert into the page
		var $select = $('<select id="mm'+menuCount+'" class="mnav" />');
		menuCount++;
		
		//create default option if the text is set (set to null for no option)
		if(settings.topOptionText){
			createOption($('<li>'+settings.topOptionText+'</li>'), $select);
		}
		
		//loop through first list items
		$menu.children('li').each(function(){
		
			var $li = $(this);

			//if nested select is wanted, and has sub-nav, add optgroup element with child options
			if($li.children('ul, ol').length && settings.nested){
				createOptionGroup($li, $select);
			}
			
			//otherwise it's a single level select menu, so build option
			else {
				createOption($li, $select);			
			}
						
		});
		
		//add change event and prepend menu to set element
		$select
			.change(function(){goTo($(this).val());})
			.prependTo(settings.prependTo);
	
	}//createSelect()

	
	//function to run plugin functionality
	function runPlugin(){
	
		//menu doesn't exist
		if(isMobile() && !menuExists()){
			
			//if user wants to combine menus, create a single <select>
			if(settings.combine){
				var $menu = combineLists();
				createSelect($menu);
			}
			
			//otherwise, create a select for each matched list
			else{
				$menus.each(function(){
					createSelect($(this));
				});
			}
		}
		
		//menu exists, and browser is mobile width
		if(isMobile() && menuExists()){
			$('.mnav').show();
			$menus.hide();
		}
			
		//otherwise, hide the mobile menu
		if(!isMobile() && menuExists()){
			$('.mnav').hide();
			$menus.show();
		}
		
	}//runPlugin()

	
	
	//plugin definition
	$.fn.mobileMenu = function(options){

		//override the default settings if user provides some
		if(options){$.extend(settings, options);}
		
		//check if user has run the plugin against list element(s)
		if(isList($(this))){
			$menus = $(this);
			runPlugin();
			$(window).resize(function(){runPlugin();});
		} else {
			alert('mobileMenu only works with <ul>/<ol>');
		}
				
	};//mobileMenu()
	
})(jQuery);
jQuery(function(){
		jQuery('ul.sf-menu').superfish();
		jQuery('#nav').mobileMenu();
		});