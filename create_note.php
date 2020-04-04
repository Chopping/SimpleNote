<?php
require "polices.php";
?>
<html>

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="css/create_note.css">
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<style type="text/css">
		.toolbar {
			border: 1px solid #ccc;
		}

		.text {
			border: 1px solid #ccc;
			height: 400px;
		}
	</style>
</head>

<body>

	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
		<div class="container">
			<a class="navbar-brand" href="main.php">Note System</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarResponsive">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item active">
						<a class="nav-link" href="main.php">Home
							<span class="sr-only">(current)</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="create_user.php">Registry</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="create_note.php">Create New Note</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Contact</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<!-- Page Content -->
	<div class="container">
		<div class="card border-0 shadow my-5">
			<div class="card-body p-5">
				<h1 class="font-weight-light">Write down your note immediately!</h1>
				<p class="lead">In this snippet, the background image is fixed to the body element. Content on the page will scroll, but the image will remain in a fixed position!</p>
				<form id="create_note_form">
					<div class="form-group">
						<label class="display-4" for="note_title">Title:</label>
						<input type="text" class="form-control" id="note_title" aria-describedby="note_title_p" maxlength="100" placeholder="Input title here ...">
						<small id="note_title_p" class="form-text text-muted">Please note that the title should be unique.</small>
					</div>

					<!-- 富文本区域 -->
					<div class="form-group">
						<label class="display-4" for="note_title">Content:</label>
						<div id="editor">
							<p>Today, I .....</p>
						</div>
					</div>
					<!-- 富文本区域 end -->
					<div class="form-group">
						<label class="display-4" for="note_title">Private Option:</label><br>
						<div class="custom-control custom-radio">
							<input type="radio" id="private_btn" name="privacy" class="custom-control-input" value="private">
							<label class="custom-control-label" for="private_btn">It's a private note, please help to keep it a security!</label>
						</div>
						<div class="custom-control custom-radio">
							<input type="radio" id="public_btn" name="privacy" class="custom-control-input" value="public" checked="checked">
							<label class="custom-control-label" for="public_btn">It's a public note, Just store it directly!</label>
						</div>
					</div>

					<div class="form-group" id="private_opt" style="display:none">
						<form class="form-inline">
							<p class="lead">Set the key to encrypt your note:(remember to keep this key as you need it to decrypt and view your own note)</p>
							<label class="sr-only" for="note_key">Encryption Key: </label>
							<div class="input-group mb-2 mr-sm-2">
								<div class="input-group-prepend">
									<div class="input-group-text">#</div>
								</div>
								<input type="password" class="form-control" id="note_key" maxlength="16" name="encrypt_key">
							</div>
						</form>
					</div>

					<button id="submit_btn" type="button" class="btn btn-primary mb-2">OK</button>
				</form>
			</div>
		</div>

	</div>

	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://rawgit.com/leizongmin/js-xss/master/dist/xss.js"></script>
	<script type="text/javascript" src="js/wangEditor.min.js"></script>
	<script type="text/javascript">
		var E = window.wangEditor
		var editor = new E('#editor')
		// 或者 var editor = new E( document.getElementById('editor') )
		editor.create();
		$('input[type=radio][name=privacy]').change(function() {
			$("#private_opt").hide();
			if (this.value == 'public') {
				// 做点什么好呢
				$("#private_opt").hide();
			} else if (this.value == 'private') {
				$("#private_opt").show();
			}
		});

		$("#submit_btn").click(function() {
			var private_opt = document.getElementById("private_btn").checked;
			$.ajax({
				type: 'POST',
				url: 'create_note_handler.php',
				data: {
					title: $("#note_title").val(),
					content: editor.txt.html(),
					note_key: $("#note_key").val(),
					p_opt: private_opt ? 1 : 0,
				},
				success: function(data) {
					console.log(data);
					let json_obj = JSON.parse(data);
					if (json_obj.success == 1) {
						window.location.href = ("view.php?note_id=" + json_obj.insert_id);
					} else {
						alert(json_obj.msg);
					}
				},
				error: function(data) {
					alert("Failed to create note!! Bad request! ");
				}
			});
		});
	</script>
</body>

</html>