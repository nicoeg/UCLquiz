	<form>
		<label for="email">Email</label>
		<input type="email" name="email" id="email">
		<label for="password">Password</label>
		<input type="password" name="password" id="password">
		<input type="button" onclick="return ajaxRequest()" value="submit">
	</form>


	
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script>
		function ajaxRequest() {

			var data = $('#email').val() + ':' + $('#password').val();

			var base_url = '<?php echo base_url();?>';
			
			function base_url_gen(string){
			    return base_url + string;
			}

			var path = "api/user";

			var base64data = btoa(data);

			$.ajax({
				type: "GET",
				url: base_url_gen(path),
				headers: {
					Authorization: 'Basic ' + base64data
				},
				data: {keyName: data},
				contentType : 'application/json',
				success : function(response) {
					response = jQuery.parseJSON(response);
					// if (response.error) {
					// 	$( "form" ).before( "<p>"+response.error+"</p>" );
					// }
					// else if( response.redirect ){
					// 	window.location.assign(response.redirect);
					// 	console.log(response.redirect);
					// }

					console.log(response);
	            },
				error : function(xhr, status, error) {
	                var err = eval("(" + xhr.responseText + ")");
	                console.log(err);                   
	            }
			});
			// console.log(data + ', ' + base_url(path));
			// return false;
		};
	</script>