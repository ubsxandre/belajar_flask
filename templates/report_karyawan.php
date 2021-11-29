{% extends 'layout.php' %}

{% block title %}Table Gaji tab {% endblock %} 

{% block content %}
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 

<div class="container">
  <h2>Report Gaji Karyawan</h2> 
  
  <div>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>NIK</th>                  
          <th>NAMA</th>
          <th>GOLONGAN</th>
          <th>TANGGAL GAJIAN</th>
          <th>GAJI KE</th>
          <th>SALARY</th>
          <th>TANGGAL MASUK KERJA</th>
          <th>STATUS KARYAWAN</th>
        </tr>
      </thead> 
      {% for row in dummy %}
        <tr>
          <td>{{row.0}}</td>
          <td>{{row.1}}</td>
          <td>{{row.2}}</td>
          <td>{{row.3}}</td>
          <td>{{row.4}}</td>
          <td>{{row.5}}</td>
          <td>{{row.6}}</td>
          <td>{{row.7}}</td>
        </tr>  

      {% endfor %}     
    </table>
  </div>
  </div>


{% endblock %}