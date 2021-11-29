<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>{% block title %}{% endblock %}</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	</head>
	<body class="">
		<nav class="navbar">
			<div class="container p-3 my-3 border">
				<h1>Ini judul</h1>
				<!-- <button type="button" class="btn badge-pill badge-primary" data-toggle="modal" data-target="#myModal" > Tambah karyawan</button> -->
				<ul class="nav nav-pills nav-justified">
					<li class="nav-item">
						<a type="button" class="nav-link" href="/">Beranda</a>
					</li>
					<li class="nav-item">
						<a type="button" class="nav-link" href="/tabel-karyawan">Tabel Karyawan</a>
					</li>
					<li class="nav-item">
					<a type="button" class="nav-link" href="/tabel-gaji">Tabel Gaji</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/report-gaji-karyawan">Report Gaji Karyawan</a>
					</li>
				</ul>
			</div>
		</nav>
		<div class="content">			
		{%with messages = get_flashed_messages()%} <!-- Nampilke pesan menggunakan flash -->
		{%if messages%}
		{% for message in messages %}
		<div class="alert alert-success alert-dismissable" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label ="close">
					<span aria-hidden="true">&times;</span>
			</button>
					{{message}}
		</div>
		{%endfor%}
		{%endif%}
		{%endwith%}
			{% block content %}{% endblock %}
		</div> 
	</body>
</html>

