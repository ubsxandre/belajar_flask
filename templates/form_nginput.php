{% extends 'layout.php' %}

{% block title %}Profile{% endblock %}

{% block content %}
			<form action="{{ url_for('nginputcoy') }}" method="post" autocomplete="off">

        <label for="Nik">
					<i class="fas fa-male"></i>
				</label>
				<input type="text" name="nik" placeholder="Nik" id="nik" required>

				<label for="First Name">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="first_name" placeholder="First Name" id="first_name" required>

        <label for="Last Name">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="last_name" placeholder="Last Name" id="last_name" required>

				<label for="Golongan">
					<i class="fas fa-laugh"></i>
				</label>
				<input type="text" name="golongan" placeholder="Golongan" id="golongan" required>

				<div class="msg">{{ msg }}</div>
				<input type="submit" value="input">
			</form>
{% endblock %}