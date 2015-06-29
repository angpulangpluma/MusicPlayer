// Name: controller.js
// Desc: checks and displays errors on the page.

jQuery(document).ready(function() {
	var check;
	
	function validateForm(form){
		var formname = form.request.value;

		var isValid;

		switch(formname){
			case "createplaylist":
				var checkForBlank = form.out;
				isValid = true;
				markAsValid($(checkForBlank));

			 	if(checkForBlank.value.length == 0){
			 		markAsInvalid($(checkForBlank));
			 		getResult("empty", "createplaylist");
			 		isValid=false;
			 		return false;
			 	} else if (!checkForBlank.value.match(/(.m3u)\b/i)){
			 		markAsInvalid($(checkForBlank));
			 		getResult("wronginput", "createplaylist");
			 		isValid=false;
			 		return false;
			 	}

			 	getResult("success", "createplaylist");
			 	return true;

			case "addplaylist":
				var checkForBlank = document.getElementById("file").files;
				var fileInput = document.getElementById("file");

				markAsValid($(fileInput));
				isValid = true;

				if (checkForBlank.length == 0){
					getResult("empty", "addplaylist");
					markAsInvalid($(fileInput));
					isValid = false;
					return false;
				} else {

				}

				getResult("success", "addplaylist");
				return true;
				// for(var i = 0; i < fileList.length; i++){
				// 	$()
				// }
				// $("#" + checkForBlank).val(removeExtraSpaces($("#" + checkForBlank).val()));

				// markAsValid($(checkForBlank));
				// isValid = true;

				// if($("#" + checkForBlank).val()==""){
				// 	isValid = false;
				// 	markAsInvalid($("#" + checkForBlank));
				// 	getResult("empty", "addplaylist");
				// } else if ($("#" + checkForBlank))


		}
	}

	function removeExtraSpaces(string){
		return string.replace(/ +(?=)/g,'').trim();
	}

	function markAsValid(element){
		element.css("border-color", "#ccc");
	}

	function markAsInvalid(element){
		element.css("border-color", "red");
	}

	function getResult(result, form){
		if (result!=null){
			var desc = $("#message");
			var title = $("#title");

			if(result == "success"){
				title.html("Success");
				title.css("color", "green");
				desc.html(getResultMessage(result, form));
			} else{
				title.html("Error");
				title.css("color", "red");
				desc.html(getResultMessage(result, form));
			}
		} else{

		}
	}

	function getResultMessage(result, form){
		switch(form){
			case "addplaylist":
				switch(result){
					case "empty":
						return "Please upload at least one file.";
					case "success":
						return "File/s successfully uploaded."
					default:
						return "";
				}
			case "createplaylist":
				switch(result){
					case "empty":
					case "wronginput":
						return "Please enter a valid filename. Do not enter '.m3u' or '<filename>.m3u'.";
					case "success":
						return "Playlist created!";
					default:
						return "";
				}
		}
	}
}