{% extends 'layout.php' %}

{% block title %}Table Gaji tab {% endblock %} 

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
          <h4 class="modal-title">Input gaji karyawan</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
					<form action="{{ url_for('semoga_naik_gaji') }}" method="post" autocomplete="off">
            <div class="form-group" >
              <h6 for="nik" >Nik</h6>
              <i class="fas fa-male"></i>
              <input type="text" name="nik" placeholder="Nik" id="nik" required>
            </div>
            <div class="form-group" >
              <h6 for="tgl_gajian" >Tanggal Gajian</h6>
              <i class="fas fa-male"></i>
              <input type="date" name="tgl_gajian" id="tgl_gajian" required>
            </div>                      
            <div class="form-group" >
              <h6 for="gaji" >Gaji</h6>
              <i class="fas fa-laugh"></i>
              </label>
              <input type="number" name="gaji" placeholder="Gaji" id="gaji" required>
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
  <h2>Tabel Gaji</h2>
  
  <button type="button" class="btn badge-pill badge-primary" data-toggle="modal" data-target="#myModal" > Tambah daftar gaji</button>
  
  <div>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>TGL PEMBAYARAN GAJI</th>
          <th>NIK</th>
          <th>GAJI KE</th>
          <th>GAJI</th>
          <th>ACTION</th>
        </tr>
      </thead> 
      {% for row in dummy %}
        <tr>
          <td>{{row.0}}</td>
          <td>{{row.1}}</td>
          <td>{{row.3}}</td>
          <td>{{row.2}}</td>
          <td>
            <a href="/update" data-toggle="modal" data-target="#modaledit{{row.1}}{{row.3}}" class="btn btn-outline-info" >Edit</a>
            <a href="/delete-gaji/{{row.1}},{{row.3}}"  onclick="return confirm('Yakin delete salary nik : {{row.1}} , periode {{row.0}} ?')" class="btn btn-outline-danger" >Delete</a>
          </td>
        </tr>  

        <!-- The Modal Update-->
                <div class="modal" id="modaledit{{row.1}}{{row.3}}">
                  <div class="modal-dialog">
                    <div class="modal-content">
                    
                      <!-- Modal Header -->
                      <div class="modal-header">
                        <h4 class="modal-title">Update gaji {{row.1}} periode {{row.0}}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      
                      <div class="modal-body">
                        <form action="{{ url_for('semoga_lebih_baik') }}" method="post" autocomplete="off">
                        <div class="form-group" >
                          <h6 for="tanggal_gajian" >Tanggal Gajian</h6>
                          <i class="fas fa-male"></i>
                          <input type="date" value="{{row.0}}" name="tanggal_gajian" id="tanggal_gajian" required>
                        </div>  
                                        <input hidden="" type="text" name="p_gaji_ke" value="{{row.3}}" id="p_haji_ke" required>
                          <div class="form-group" >
                            <h6 for="nik" >Nik</h6>
                            <i class="fas fa-male"></i>
                            <input type="text" name="nik" value="{{row.1}}" id="nik" required>
                          </div>  
                          <div hidden="" class="form-group" >
                            <h6 for="gaji_ke" >gaji_ke</h6>
                            <i class="fas fa-male"></i>
                            <input type="text" name="gaji_ke" value="{{row.3}}" id="gaji_ke" required>
                          </div>          
                          <div class="form-group" >
                            <h6 for="gaji" >Gaji</h6>
                            <i class="fas fa-laugh"></i>
                            </label>
                            <input type="number" name="gaji" value="{{row.2}}" id="gaji" required>
                          </div>
                          <br>
                          <div class="form-group" >
                            <button class="btn btn-primary" type="submit">Save</button>
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