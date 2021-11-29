{% extends 'layout.php' %}

{% block title %}Table Karyawan tab {% endblock %} 

{% block content %}
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<!-- modal -->

<!-- The Modal Input-->
<div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Input data karyawan</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
					<form action="{{ url_for('nginputcoy') }}" method="post" autocomplete="off">
            <div class="form-group" >
              <h6 for="nik" >Nik</h6>
              <i class="fas fa-male"></i>
              <input type="text" name="nik" placeholder="Nik" id="nik" required>
            </div>
            <div class="form-group" >
            <h6 for="first_name" >First Name</h6>
              <i class="fas fa-user"></i>						
              <input type="text" name="first_name" placeholder="First Name" id="first_name" required >              
            </div>										
            <div class="form-group" >
              <h6 for="last_name" >Last_name</h6>
              <i class="fas fa-user"></i>
              <input type="text" name="last_name" placeholder="Last Name" id="last_name" required>
            </div>
            <div class="form-group" >
              <h6 for="golongan" >Golongan</h6>
              <i class="fas fa-laugh"></i>
              </label>
              <input type="text" name="golongan" placeholder="Golongan" id="golongan" required>
            </div>
            <div class="form-group" >
              <h6 for="nik" >Tanggal Mulai Kerja</h6>
              <i class="fas fa-laugh"></i>
              </label>
              <input type="datetime-local" name="tgl_kerja" id="tgl_kerja" required>
            </div>
            <div>
            <h6 for="sts_aktif" >Status Aktif</h6>
            <select name="sts_aktif" class="custom-select">
              <option selected disabled>Status Aktif</option>
              <option value="1">Aktif</option>
              <option value="0">Tidak Aktif</option>
            </select>
            </div>
            <br>
            <div class="form-group" >
              <button class="btn btn-primary" type="submit">Insert</button>
            </div>						
					</form>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
<!-- End Modal Input -->


  

<div class="container">
  <h2>Tabel Karyawan</h2>
  
  <button type="button" class="btn badge-pill badge-primary" data-toggle="modal" data-target="#myModal" > Tambah karyawan</button>
  
  <div>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>NIK</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Golongan</th>
          <th>Action</th>
        </tr>
      </thead> 
      {% for row in dummy %}
        <tr>
          <td>{{row.0}}</td>
          <td>{{row.1}}</td>
          <td>{{row.2}}</td>
          <td>{{row.3}}</td>
          <td>
            <a href="/update/{{row.0}}" data-toggle="modal" data-target="#modaledit{{row.0}}" class="btn btn-outline-info" >Edit</a>
            <a href="/delete/{{row.0}}"  onclick="return confirm('Yakin delete {{row.0}} ?')" class="btn btn-outline-danger" >Delete</a>
          </td>
        </tr>  
            <!-- The Modal Update-->
              <div class="modal" id="modaledit{{row.0}}">
                  <div class="modal-dialog">
                    <div class="modal-content">
                    
                      <!-- Modal Header -->
                      <div class="modal-header">
                        <h4 class="modal-title">Update data karyawan {{row.0}}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      
                      <!-- Modal body -->
                      <div class="modal-body">
                        <form action="{{url_for('update')}}" method="POST">
                        <div class="form-group" >
                          <h6 for="nik" >Nik</h6>
                          <i class="fas fa-male"></i>
                          <input type="text" name="nik" value="{{row.0}}" id="nik" required>
                        </div>
                        <div class="form-group" >
                        <h6 for="first_name" >First Name</h6>
                          <i class="fas fa-user"></i>						
                          <input type="text" name="first_name" value="{{row.1}}" id="first_name" required >              
                        </div>										
                        <div class="form-group" >
                          <h6 for="last_name" >Last_name</h6>
                          <i class="fas fa-user"></i>
                          <input type="text" name="last_name" value="{{row.2}}" id="last_name" required>
                        </div>
                        <div class="form-group" >
                          <h6 for="golongan" >Golongan</h6>
                          <i class="fas fa-laugh"></i>
                          </label>
                          <input type="text" name="golongan" value="{{row.3}}" id="golongan" required>
                        </div>
                        <div class="form-group" >
                          <h6 for="nik" >Tanggal Mulai Kerja</h6>
                          <i class="fas fa-laugh"></i>
                          </label>
                          <input type="datetime-local" value="{{row.4.strftime('%Y-%m-%dT%H:%M:%S')}}" name="tgl_kerja" id="tgl_kerja" required>
                        </div>
                        <br>
                        <div class="form-group" >
                          <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                        </form>
                      </div>
                      
                      <!-- Modal footer -->
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      </div>
                      
                    </div>
                  </div>
                </div>

                
              <!-- End Modal Update -->
      {% endfor %}     
    </table>
  </div>
  </div>


{% endblock %}