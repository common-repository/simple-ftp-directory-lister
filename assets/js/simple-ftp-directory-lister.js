jQuery(document).ready(function( $ ) {

	/* reset width of element with additional condition, this is to prevent width from stacking and provide proper calculation for subelements */
	function width_reset_for_calc(param, second_condition, else_width) {
		var width;
					if (param > 0 && second_condition)
					{width = param;}
					else
						{
							if (else_width > 0){width = else_width;}
							else {width = "auto";}
									}
	return width;
								}

// show first level of listing
$(".directory-lister-wrapper").find("> .soubor").each(function() {
	$(this).removeClass("schovat-slozku");
	$(this).addClass("zobrazit-slozku");
});
$(".directory-lister-wrapper").find("> .slozka").each(function() {
	$(this).removeClass("schovat-slozku");
	$(this).addClass("zobrazit-slozku");
});

/* check if screen is >= 768px */
	function isMobileWidth() {
	var mobile_version_breakpoint = $(".directory-lister-wrapper").attr("mobile_version_breakpoint");
	var directory_lister_wrapper_outerwidth = $(".directory-lister-wrapper").outerWidth();

/*debug*/
//	alert("Mobile breakoint:"+mobile_version_breakpoint+"   Wapper width: "+directory_lister_wrapper_outerwidth);

if (mobile_version_breakpoint >= directory_lister_wrapper_outerwidth){
	return true;
}
else{	return false;}
	}

var sfdl_layout = $(".directory-lister-wrapper").attr("layout");

/* if screen >= 768px run this */
	if (isMobileWidth() == false && sfdl_layout == "horizontal") {

/* get largest width of element */
function largest_width(param){
$param = param;
  if ($(param).length){
var largest_width = Math.max.apply( null, $( param ).map( function () {
    return $( this ).outerWidth( true );
}) )}
else {largest_width = 0}
return largest_width;
}

//calculate largest width of main folder/file listing
if (largest_width('.directory-lister-wrapper>.slozka>.nazev-slozky') > largest_width('.directory-lister-wrapper>.soubor')) {
	$(".directory-lister-wrapper>.slozka>.nazev-slozky").css("width", largest_width('.directory-lister-wrapper>.slozka>.nazev-slozky'));
}
else {
	$(".directory-lister-wrapper>.slozka>.nazev-slozky").css("width", largest_width('.directory-lister-wrapper>.soubor'));
}


// max width 32%
	$( ".directory-lister-wrapper .child-wrapper" ).css("max-width", (($( ".directory-lister-wrapper").width())-((($( ".directory-lister-wrapper").width())/100)*3))/3);
	// margin-left 1%
	$( ".directory-lister-wrapper>.slozka>.child-wrapper, .directory-lister-wrapper>.slozka>.child-wrapper>.slozka>.child-wrapper, .directory-lister-wrapper>.slozka>.child-wrapper>.slozka>.child-wrapper>.slozka>.child-wrapper"  )
	.css("margin-left", ($( ".directory-lister-wrapper").width())/100);

//calculate largest width of wrapper elements
$(".directory-lister-wrapper .child-wrapper").each(function() {
if (largest_width($(this).find('>.slozka>.nazev-slozky')) > largest_width($(this).find('>.soubor>.soubor-link'))) {
$(this).css("width", largest_width($(this).find('>.slozka>.nazev-slozky'))+47);
}
else {
	$(this).css("width", largest_width($(this).find('>.soubor>.soubor-link'))+35);
}
});
}

// folder open/close control
$(".directory-lister-wrapper").find(".slozka").click(function(e) {

//keep only one folder open
	$( ".directory-lister-wrapper > .slozka" ).find(".child-wrapper").not($(this).find(".child-wrapper")).addClass("schovat-slozku");
	$( ".directory-lister-wrapper > .slozka" ).find(".child-wrapper").not( $(this).find(".child-wrapper")).removeClass("zobrazit-slozku");

	$( ".directory-lister-wrapper > .slozka" ).find(".nazev-slozky").not($(this).find(".nazev-slozky")).removeClass("subfolder-selected");
	$( ".directory-lister-wrapper > .slozka" ).find(".nazev-slozky > .sfdl-icon").not($(this).find(".nazev-slozky > .sfdl-icon")).addClass("folder-icon");
	$( ".directory-lister-wrapper > .slozka" ).find(".nazev-slozky > .sfdl-icon").not($(this).find(".nazev-slozky > .sfdl-icon")).removeClass("folder-icon-white");

//show direct child
	if ($(this).children(".child-wrapper").hasClass("schovat-slozku")) {
		$( this ).children(".child-wrapper").addClass("zobrazit-slozku");
	  $( this ).children(".child-wrapper").removeClass("schovat-slozku");
		if (isMobileWidth() == false && sfdl_layout == "horizontal") {
		$( this ).children(".nazev-slozky").not(".directory-lister-wrapper > .slozka > .nazev-slozky").addClass("subfolder-selected");
		$( this ).find("> .nazev-slozky > .sfdl-icon").not(".directory-lister-wrapper > .slozka > .nazev-slozky > .sfdl-icon").addClass("folder-icon-white");
		$( this ).find("> .nazev-slozky > .sfdl-icon").not(".directory-lister-wrapper > .slozka > .nazev-slozky > .sfdl-icon").removeClass("folder-icon");
		}

	}
//hide all descendants
	else if ($(this).children(".child-wrapper").hasClass("zobrazit-slozku")) {
	  $( this ).find(".child-wrapper").addClass("schovat-slozku");
	  $( this ).find(".child-wrapper").removeClass("zobrazit-slozku");

		if (isMobileWidth() == false && sfdl_layout == "horizontal") {
		$( this ).find(".nazev-slozky").not(".directory-lister-wrapper > .slozka > .nazev-slozky").removeClass("subfolder-selected");
		$( this ).find(".nazev-slozky > .sfdl-icon").not(".directory-lister-wrapper > .slozka > .nazev-slozky > .sfdl-icon").removeClass("folder-icon-white");
		$( this ).find(".nazev-slozky > .sfdl-icon").not(".directory-lister-wrapper > .slozka > .nazev-slozky > .sfdl-icon").addClass("folder-icon");
		}
	}

// calculate margin of last element and expand if folder listing is larger than wrapper to keep it visible
if (isMobileWidth() == false && sfdl_layout == "horizontal") {
var height_of_main_wrapper = $( ".directory-lister-wrapper" ).outerHeight();
var sum_all_child_wrapper_heights = 0;
var main_folder_position = $( this ).parent(".directory-lister-wrapper").find($( this )).position();

$( this ).find(".child-wrapper.zobrazit-slozku").each(function(index, child_wrapper ) {
sum_all_child_wrapper_heights +=  $(child_wrapper).outerHeight();
	});
if ((height_of_main_wrapper - main_folder_position.top) < sum_all_child_wrapper_heights)
{
//alert(sum_all_child_wrapper_heights + " - ("+ height_of_main_wrapper +" - "+ main_folder_position.top+")");
	 var margin_last_element = sum_all_child_wrapper_heights - (height_of_main_wrapper - main_folder_position.top);
	 $(".directory-lister-wrapper").css("margin-bottom", margin_last_element);
}
else {
$(".directory-lister-wrapper").css("margin-bottom", "auto");
}
	}
});

// vytváření odkazů
$( ".soubor-link" ).each(function() {
var link = "";

$( this ).parents(".slozka").last().each(function() {
$(this).attr("path", $( this ).find("> .nazev-slozky").text());
$( this ).find(".slozka").each(function(index) {
$(this).attr("path", $( this ).find("> .nazev-slozky").text());
});
});
  $($( this ).parents(".slozka").get().reverse()).each(function() {
link += $(this).attr("path") + "/";
  });
var newUrl = $("#directory-lister").attr("mainpath") + "/" +  link + $( this ).attr("file");
    $(this).attr("href", newUrl);
 });

 $(".soubor-link").click(function(e) {
   e.stopPropagation();
});

 $('.slozka:not(:has(.soubor))').addClass('empty-inside');

$(".sfdl-loading-gif, .sfdl-loading-gif-wrapper").css("display", "none");
$(".directory-lister-wrapper").css("visibility", "visible");
})
