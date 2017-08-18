$(document).ready(function(){

	var user_href;
	var user_href_splitted;
	var user_id;

	var image_src;
	var image_src_splitted;
	var image_name;
	var image_id;


$(".modal-thumbnails").click(function(){

	$("#set_user_image").prop('disabled', false);

	$(this).addClass('selected');
	user_href = $("#user-id").prop('href');
	user_href_splitted = user_href.split("=");
	user_id = user_href_splitted[user_href_splitted.length - 1];

	image_src = $(this).prop('src');
	image_src_splitted = image_src.split("/");

	/*Set image name*/
	image_name = image_src_splitted[image_src_splitted.length - 1];


	/*Set image id*/
	image_id = $(this).attr("data");

	$.ajax({

		url: "includes/ajax_code.php",
		data:{image_id: image_id},
		type: "POST", 
		success: function(data) {
			if (!data.error) {
				//returns the content of the selected element
				$("#modal_sidebar").html(data);
			}
		}

	});

});	


$("#set_user_image").click(function(){

	$.ajax({

		url: "includes/ajax_code.php",
		data:{image_name:image_name, user_id: user_id},
		type: "POST", 
		success: function(data) {
			if (!data.error) {
				$(".user_image_box a img").prop('src', data);
			}
		}

	});

});


	/******************Edit Photo Dropdown**********************/

	$(".info-box-header").click(function(){

		$(".inside").slideToggle("fast");
		$("#toggle").toggleClass("glyphicon-menu-down glyphicon , glyphicon-menu-up glyphicon");
	});

	/******************Delete Function**********************/

	$(".delete_link").click(function(){

		return confirm("Are you sure you want to delete?");
		
	});



});

//tinymce.init({ selector:'textarea' });