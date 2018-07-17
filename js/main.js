var favicon_btn = document.getElementsByClassName('favicon-btn').item(0);
var icons_btn = document.getElementsByClassName('icons-btn').item(0);
var screens_btn = document.getElementsByClassName('screens-btn').item(0);

favicon_btn.addEventListener('click', function(){
	CreateOverlay(1);
}, false);

icons_btn.addEventListener('click', function(){
	CreateOverlay(2);
}, false);

screens_btn.addEventListener('click', function(){
	CreateOverlay(3);
}, false);


function CreateOverlay(num){
	var numOverlay = num - 1;
	var wimool = document.getElementsByClassName('wimool').item(0);
	var overlay = document.createElement('section');
	overlay.className = 'overlay';

	//favicon
	if(num === 1){
		overlay.style.backgroundColor = '#6BB9F0';
		overlay.innerHTML = '<div class="guide"><h2>Generate the favicon images for your web</h2><ol><li>Upload an image from your library and uncompress the downloaded .zip file. Recommended size: 196 x 196.<a class="favicon-select" href="javascript:void(0);" onclick="selectFavicon();">Upload an image</a><input class="favicon-input" type="file" accept="image/jpeg, image/png, image/ico, image/x-png" hidden></li><li>Move all favicon images inside your project.</li><li>Open the FAVICON.txt file. Copy and paste the code inside the head tag.</li><li>Change the absolute URLs.</li></ol></div><a onclick="DeleteOverlay('+numOverlay+');" href="javascript:void(0);" class="close">Close</a>';
	}

	//icons
	else if(num === 2){
		overlay.style.backgroundColor = '#F7DA47';
		overlay.style.color = '#3D4349';
		overlay.innerHTML = '<div class="guide"><h2>Generate the touch icons for iOS</h2><ol><li>Upload an image from your library and uncompress the downloaded .zip file. Recommended size: 152 x 152.<a class="icon-select" href="javascript:void(0);" onclick="selectIcon();">Upload an image</a><input class="icon-input" type="file" accept="image/jpeg, image/png, image/x-png" hidden></li><li>Move all touch icons inside your project.</li><li>Open the TOUCHICONS.txt file. Copy and paste the code inside the head tag.</li><li>Change the absolute URLs.</li></ol></div><a onclick="DeleteOverlay('+numOverlay+');" href="javascript:void(0);" class="close">Close</a>';
	}

	//screens
	else{
		overlay.style.backgroundColor = '#FF5F38';
		overlay.innerHTML = '<div class="guide"><h2>Generate the startup images for iOS</h2><ol><li>Upload an image from your library and uncompress the downloaded .zip file. Recommended size: 1536 x 2208.<a class="screen-select" href="javascript:void(0);" onclick="selectScreen();">Upload an image</a><input class="screen-input" type="file" accept="image/jpeg, image/png, image/x-png" hidden></li><li>Move all startup images inside your project.</li><li>Open the STARTUP.txt file. Copy and paste the code inside the head tag.</li><li>Change the absolute URLs.</li></ol></div><a onclick="DeleteOverlay('+numOverlay+');" href="javascript:void(0);" class="close">Close</a>';
	}

	document.getElementsByClassName('item').item(num - 1).appendChild(overlay);
}


function DeleteOverlay(num){
	var overlayItem = document.getElementsByClassName('item').item(num).getElementsByClassName('overlay').item(0);
	overlayItem.style.animation = 'disappear 0.2s ease-in-out';
	overlayItem.style.WebkitAnimation = 'disappear 0.2s ease-in-out';
	overlayItem.style.MozAnimation = 'disappear 0.2s ease-in-out';
	overlayItem.style.OAnimation = 'disappear 0.2s ease-in-out';
	setTimeout(function(){
		overlayItem.remove();
	}, 200);
}


function selectFavicon(e){
	var favicon_input = document.getElementsByClassName('favicon-input').item(0);
	var favicon_troll = document.getElementsByClassName('favicon-select').item(0);
	favicon_input.click();

	favicon_input.onchange = function(){

		//limito la subida a 1.5 MB
		if(GetFileSize(favicon_input) < 1512){

			var data = new FormData();
			var favicon_image = favicon_input.files[0];
			data.append("favicon_image", favicon_image);

			var xhr = new XMLHttpRequest();
			xhr.open("POST", "./php/generateFavicon.php", true);
			xhr.onload = function(){
				var response = xhr.responseText;
				if(response !== null){
					try{
						var parsed = JSON.parse(response);
						var iframe = document.createElement('iframe');
						iframe.src = "./php/processor.php?path="+parsed.location+"&folder="+parsed.folder;
						iframe.width = 0;
						iframe.height = 0;
						document.getElementsByClassName('item').item(0).getElementsByClassName('overlay').item(0).appendChild(iframe);
						favicon_input.value = '';
						favicon_troll.innerHTML = 'Upload an image';
					}
					catch(e){
						alert(response);
						favicon_input.value = '';
						favicon_troll.innerHTML = 'Upload an image';
					}
				}
				else{
					alert('The server response is empty. Refresh and try it again.');
				}
			};
	        xhr.send(data);
	        favicon_troll.innerHTML = '<img src="./images/extra/loader.gif">';
		}
		else{
			alert('Oops! It looks like your image exceeds the size limit, 1.5 MB.');
			favicon_input.value = '';
	       	favicon_troll.innerHTML = 'Upload an image';
		}
	};
}


function selectIcon(e){
	var icon_input = document.getElementsByClassName('icon-input').item(0);
	var icon_troll = document.getElementsByClassName('icon-select').item(0);
	icon_input.click();

	icon_input.onchange = function(){

		//limito la subida a 1.5 MB
		if(GetFileSize(icon_input) < 1512){

			var data = new FormData();
			var icon_image = icon_input.files[0];
			data.append("icon_image", icon_image);

			var xhr = new XMLHttpRequest();
			xhr.open("POST", "./php/generateIcon.php", true);
			xhr.onload = function(){
				var response = xhr.responseText;
				if(response !== null){
					try{
						var parsed = JSON.parse(response);
						var iframe = document.createElement('iframe');
						iframe.src = "./php/processor.php?path="+parsed.location+"&folder="+parsed.folder;
						iframe.width = 0;
						iframe.height = 0;
						document.getElementsByClassName('item').item(1).getElementsByClassName('overlay').item(0).appendChild(iframe);
						icon_input.value = '';
						icon_troll.innerHTML = 'Upload an image';
					}
					catch(e){
						alert(response);
						icon_input.value = '';
						icon_troll.innerHTML = 'Upload an image';
					}
				}
				else{
					alert('The server response is empty. Refresh and try it again.');
				}
			};
	        xhr.send(data);
	        icon_troll.innerHTML = '<img src="./images/extra/loader.gif">';
		}
		else{
			alert('Oops! It looks like your image exceeds the size limit, 1.5 MB.');
			icon_input.value = '';
	       	icon_troll.innerHTML = 'Upload an image';
		}
	};
}


function selectScreen(e){
	var screen_input = document.getElementsByClassName('screen-input').item(0);
	var screen_troll = document.getElementsByClassName('screen-select').item(0);
	screen_input.click();

	screen_input.onchange = function(){

		//limito la subida a 1.5 MB
		if(GetFileSize(screen_input) < 1512){

			var data = new FormData();
			var screen_image = screen_input.files[0];
			data.append("screen_image", screen_image);

			var xhr = new XMLHttpRequest();
			xhr.open("POST", "./php/generateStartup.php", true);
			xhr.onload = function(){
				var response = xhr.responseText;
				if(response !== null){
					try{
						var parsed = JSON.parse(response);
						var iframe = document.createElement('iframe');
						iframe.src = "./php/processor.php?path="+parsed.location+"&folder="+parsed.folder;
						iframe.width = 0;
						iframe.height = 0;
						document.getElementsByClassName('item').item(2).getElementsByClassName('overlay').item(0).appendChild(iframe);
						screen_input.value = '';
						screen_troll.innerHTML = 'Upload an image';
					}
					catch(e){
						alert(response);
						screen_input.value = '';
						screen_troll.innerHTML = 'Upload an image';
					}
				}
				else{
					alert('The server response is empty. Refresh and try it again.');
				}
			};
	        xhr.send(data);
	        screen_troll.innerHTML = '<img src="./images/extra/loader.gif">';
		}
		else{
			alert('Oops! It looks like your image exceeds the size limit, 1.5 MB.');
			screen_input.value = '';
	       	screen_troll.innerHTML = 'Upload an image';
		}
	};
}


//funcion para conseguir el tamaño de una imagen seleccionada
function GetFileSize(inputElement){
	var fi = inputElement;
	if (fi.files.length > 0){
	    for (var i = 0; i <= fi.files.length - 1; i++){
	        var fsize = fi.files.item(i).size;
	        var fsizeKB = fsize/1024;
	        return fsizeKB;
	    }
	}
}