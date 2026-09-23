
<?php $owner = $this->db->get_where('admin',array('admin_id'=>$this->session->userdata('login_user_id')) )->row()->owner;?>
    <link href="<?php echo base_url();?>public/assets/appointments/css/select2.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <div class="todo-app-w">
        
    <div class="todo-content" style="margin-bottom: 8%;">
        <div class="row">
            <div class="col-xl-8 col-lg-8 col-sm-10" style="float: none; margin: 0 auto;">
                <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                    <h4 class="todo-content-header">
                        <i class="batch-icon-arrow-right"></i><span>Agregar nuevo Doctor </span>
                    </h4>
                    <div class="col-sm-12">
                        <div class="alert alert-info">
                            <span class="alert-title"><i class="batch-icon-spam"></i> Complete los datos obligatorios *.</span>
                        </div>  
                    </div>
                    <form action="<?php echo base_url();?>staff/doctors/create" method="POST" enctype="multipart/form-data" id="doc_form">
                        <div class="row">
                        
                            <div class="col-sm-12 ">
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                        <input type='file' name="photo" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                        <label for="imageUpload"></label>
                                    </div>
                                    <div class="avatar-preview" style="border: 2px solid #198cff8f;">
                                        <div id="imagePreview" style="background-image: url(<?php echo base_url();?>public/uploads/user.png);"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
		                            <label for="simpleinput">Primer Nombre<span style="color:red">*</span></label>
                                    <input style="border: 1px solid #198cff8f;" type="text" name="first_name" required="" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
		                            <label for="simpleinput">Segundo Nombre</label>
                                    <input style="border: 1px solid #198cff8f;" type="text" name="second_name" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
		                            <label for="simpleinput">Tercer Nombre</label>
                                    <input style="border: 1px solid #198cff8f;" type="text" name="third_name"  class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
		                            <label for="simpleinput">Primer Apellido<span style="color:red">*</span></label>
                                    <input style="border: 1px solid #198cff8f;" type="text" name="last_name" required="" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
		                            <label for="simpleinput">Segundo Apellido</label>
                                    <input style="border: 1px solid #198cff8f;" type="text" name="second_last_name"  class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
		                            <label for="simpleinput">Apellido de casada</label>
                                    <input style="border: 1px solid #198cff8f;" type="text" name="married_last_name"  class="form-control">
                                </div>
                            </div>
                            
                            <div class="col-sm-6">
                                <div class="form-group date-time-picker m-b-15">
                                    <label for="simpleinvput">Nacimiento</label>
        			                <div class="input-group date datepicker" id="DoctorPicker1">
        	                           <input style="border: 1px solid #198cff8f;" type="text" id="applyDate" name="date_of_birth" autocomplete="off" style="border: 1px solid #198cff8f;" value="<?php echo date('d/m/Y');?>" class="form-control">
        	        		           <span style="display: none;" class="input-group-addon"><i data-feather="calendar"></i></span>
        			               </div>
        		                </div>
	                        </div>
                    
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
		                            <label for="simpleinput">Identificación<span style="color:red">*</span></label>  <span class="" id="errordpi"></span>
                                    <input style="border: 1px solid #198cff8f;" type="number" name="dpi" id="dpi" required="" onkeyup="validateDPI(this.value);" class="form-control">
                                  	
                                </div>
                            </div>
		                  
		                    <div class="col-sm-6">
                                <div class="form-group m-b-15">
		                            <label for="simpleinput">Celular<span style="color:red">*</span></label>
                                    <input style="border: 1px solid #198cff8f;" type="tel" name="phone" required="" class="form-control">
                                    <small>* Ingresar código de área p.j: 502xxxxxxxx</small>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
		                            <label for="simpleinput">Correo<span style="color:red">*</span></label>  <span class="" id="errorm"></span>
                                    <input style="border: 1px solid #198cff8f;" type="email" name="email" id="email" required="" onkeyup="validateEmail();" class="form-control">
                                  	
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                     <label for="simpleinput">Salario<span style="color:red">*</span></label>
                                    <div class="row">
                                        <div class="col-sm-12">
                                        <input style="border: 1px solid #198cff8f;" type="number" name="salary" class="form-control">  
                                        </div>
		                           </div>
                               </div> 
                            </div>
                            
                              <div class="col-sm-6">
                                <div class="form-group m-b-15">
		                            <label for="simpleinput">No. Colegiado</label>
                                    <input style="border: 1px solid #198cff8f;" type="text" name="no_college" class="form-control">
                                </div>
                            </div>
                            
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
		                            <label for="simpleinput">Especialidad 1 <span style="color:red">*</span></label>
		                            <select  class="itemName form-control select2" style="border: 1px solid #198cff8f;" required="" style="width:100%" name="specialty_1">
								      	<option value="">Seleccionar</option>
		                            	<?php 
								        	$specialties = $this->db->get('specialtie')->result_array();
								        	foreach($specialties as $cat):
								    	?>
					                    <option value="<?php echo $cat['specialtie_id'];?>"><?php echo $cat['name'];?></option>
					                	<?php endforeach;?>
					                </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
		                            <label for="simpleinput">Especialidad 2 <span style="color:red">*</span></label>
                                    <select  style="border: 1px solid #198cff8f;"  class="itemName form-control" style="width:100%" name="specialty_2">
								      	<option value="">Seleccionar</option>
		                            	<?php 
								        	foreach($specialties as $cat):
								    	?>
					                    <option value="<?php echo $cat['specialtie_id'];?>"><?php echo $cat['name'];?></option>
					                	<?php endforeach;?>
					                </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Estado civil:</label>
                                    <div class="input-group">
                                        <div class="form-check" style="padding-left: 0px;padding-right:4px">
                                          <input checked="" class="radiobutton" type="radio" name="status" id="single1" value="0"><label class="radiobutton-label" for="single1">Soltero</label>
                                        </div>
                                        <div class="form-check" style="padding-left: 0px;">
                                          <input class="radiobutton" type="radio" name="status" id="radio4" value="1"><label class="radiobutton-label" for="radio4">Casado</label>
                                        </div>
                                    </div>
		                        </div>
                             </div>
                             <?php if($owner == 1):?>
                             <div class="col-sm-6">
                                 <div class="form-group">
                                    <label>Tipo de cuenta:</label>
                                    <div class="input-group">
                                        <div class="form-check" style="padding-left: 0px;padding-right:4px">
                                          <input checked="" class="radiobutton" type="radio" name="owner" id="owner" value="1"><label class="radiobutton-label" for="owner">Propietario</label>
                                        </div>
                                        <div class="form-check" style="padding-left: 0px;">
                                          <input class="radiobutton" type="radio" name="owner" id="doctor" value="0"><label class="radiobutton-label" for="doctor">Doctor</label>
                                        </div>
                                    </div>
		                        </div>
                             </div>
                             <?php else:
                            ?> 
                            <input type="hidden" id="doctor" name="owner" value="0" class="custom-control-input" checked>
                            
                            <?php endif;?>
                             <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Género:</label>
                                    <div class="input-group">
                                        <div class="form-check" style="padding-left: 0px;padding-right:4px">
                                          <input checked="" class="radiobutton" type="radio" name="gender" id="radio3" value="M"><label class="radiobutton-label" for="radio3">Masculino</label>
                                        </div>
                                        <div class="form-check" style="padding-left: 0px;">
                                          <input class="radiobutton" type="radio" name="gender" id="radio5" value="F"><label class="radiobutton-label" for="radio5">Femenino</label>
                                        </div>
                                    </div>
		                        </div>
	                        </div>
	                        
	                        <div class="col-sm-6">
                                <div class="form-group m-b-15">
		                            <label for="simpleinput">Firma</label>
		                            <label class="labelx" for="apply"><input type="file" name="signature" class="inputx" id="apply" accept=".jpg, .png, .jpeg">Seleccionar</label>
                                    <small id="fileResponse"></small>
                                </div>
                            </div>
	                        
                            
                             <div class="col-sm-12">
                                <div class="form-group m-b-15">
		                            <label for="simpleinput">Dirección</label>
                                    <textarea type="text" style="border: 1px solid #198cff8f;" rows="3" name="address" class="form-control"></textarea>
                                </div>
                                <small>* Los datos de acceso serán enviados a la dirección de correo que proporcionaste arriba.</small><br><br>
                            </div>
                            
                          <div class="col-sm-12">
	                            <label>Redes sociales</label>
	                                <div class="row">
	                                  
	  	                              <div class="col-sm-5">
		                                  <div class="col-sm-12">
        		                            <div class="form-group m-b-15">
                		                        <div class="form-group">
         		                                    <div class="custom-control custom-checkbox mr-sm-2">
        		                                        <input type="checkbox" id="invc" name="Facebook" value="1" class="custom-control-input check">
            		                                    <label class="custom-control-label" for="invc">Facebook</label>
        		                                    </div>
        								        </div>
        		                            </div>
        		                          </div>
        		                           
        		                           <div class="col-sm-12"  id="fb">
        		                                <div class="form-group m-b-15">
                		                           <label for="simpleinput">Ingrese link de Facebook</label></label>
        		                                    <div class="form-group">
         		                                        <input style="border: 1px solid #198cff8f;" type="text" name="link_facebook" class="form-control">
        		                                    </div>
        		                                </div>
        		                            </div>
		                              </div>
	                              
	                              <div class="col-sm-5">
	                                  <div class="col-sm-12">
    		                            <div class="form-group m-b-15">
            		                        <div class="form-group">
     		                                    <div class="custom-control custom-checkbox mr-sm-2">
    		                                        <input style="border: 1px solid #198cff8f;" type="checkbox" id="invc3" name="Instagram" value="1" class="custom-control-input check">
        		                                    <label class="custom-control-label" for="invc3">Instagram</label>
    		                                    </div>
    								        </div>
    		                            </div>
    		                          </div>
        		                           
    		                           <div class="col-sm-12"  id="Ig">
    		                                <div class="form-group m-b-15">
            		                           <label for="simpleinput">Ingrese link de Instagram</label></label>
    		                                    <div class="form-group">
     		                                        <input style="border: 1px solid #198cff8f;" type="text" name="link_instagram" class="form-control">
    		                                    </div>
    		                                </div>
    		                            </div>
	                              </div>
	                              
	                              <div class="col-sm-2">
	                                  <div class="col-sm-12">
    		                            <div class="form-group m-b-15">
            		                        <div class="form-group">
     		                                    <div class="custom-control custom-checkbox mr-sm-2">
    		                                        <input type="checkbox" id="invc2" name="Whatsapp" value="1" class="custom-control-input check">
        		                                    <label class="custom-control-label" for="invc2">WhatsApp</label>
    		                                    </div>
    								        </div>
    		                            </div>
    		                          </div>
        		                  </div>
        		              </div>
            		      </div>
            		<?php if($owner == 1):?>
            		<div class="col-sm-12">
		                                <label>¿Modulos a los que tendra acceso?</label>
		                                <div class="row">
		                                
		                                
		                                <div class="col-sm-2 col-xl-4">
		                                     <div class="form-group">
                                                <label>¿Podra dar permisos?</label>
                                                <div class="input-group">
                                                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                                                      <input class="radiobutton" type="radio" name="moduls" id="modulos" value="1">
                                                      <label class="radiobutton-label" for="modulos">Sí</label>
                                                    </div>
                                                    <div class="form-check"  style="padding-left: 0px;">
                                                      <input  class="radiobutton" type="radio" name="moduls" id="modulosno" checked value="0">
                                                      <label class="radiobutton-label" for="modulosno">No</label>
                                                    </div>
                                                </div>
                                            </div>
		                                </div>
	                                
		                                <div class="col-sm-2 col-xl-4">
		                                    <div class="form-group">
                                                <label>Chat</label>
                                                <div class="input-group">
                                                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                                                      <input class="radiobutton" type="radio" name="chat" id="chat" value="1">
                                                      <label class="radiobutton-label" for="chat">Sí</label>
                                                    </div>
                                                    <div class="form-check"  style="padding-left: 0px;">
                                                      <input  class="radiobutton" type="radio" name="chat" id="chatno" checked value="0">
                                                      <label class="radiobutton-label" for="chatno">No</label>
                                                    </div>
                                                </div>
                                            </div>
		                                </div>
		                                
		                                <div class="col-sm-2 col-xl-4">
		                                    <div class="form-group">
                                                <label>Citas</label>
                                                <div class="input-group">
                                                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                                                      <input class="radiobutton" type="radio" name="appointments" id="appointments" value="1">
                                                      <label class="radiobutton-label" for="appointments">Sí</label>
                                                    </div>
                                                    <div class="form-check"  style="padding-left: 0px;">
                                                      <input  class="radiobutton" type="radio" name="appointments" checked id="appointmentsno" value="0">
                                                      <label class="radiobutton-label" for="appointmentsno">No</label>
                                                    </div>
                                                </div>
                                            </div>
		                                </div>
		                                
		                                <div class="col-sm-2 col-xl-4">
		                                    <div class="form-group">
                                                <label>Pacientes</label>
                                                <div class="input-group">
                                                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                                                      <input class="radiobutton" type="radio" name="patients" id="patients" value="1">
                                                      <label class="radiobutton-label" for="patients">Sí</label>
                                                    </div>
                                                    <div class="form-check"  style="padding-left: 0px;">
                                                      <input  class="radiobutton" type="radio" name="patients" checked id="patientsno" value="0">
                                                      <label class="radiobutton-label" for="patientsno">No</label>
                                                    </div>
                                                </div>
                                            </div>
		                                </div>
		                                
		                                <div class="col-sm-2 col-xl-4">
		                                    <div class="form-group">
                                                <label>Doctores</label>
                                                <div class="input-group">
                                                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                                                      <input class="radiobutton" type="radio" name="doctors" id="doctors" value="1">
                                                      <label class="radiobutton-label" for="doctors">Sí</label>
                                                    </div>
                                                    <div class="form-check"  style="padding-left: 0px;">
                                                      <input  class="radiobutton" type="radio" name="doctors" checked id="doctorsno" value="0">
                                                      <label class="radiobutton-label" for="doctorsno">No</label>
                                                    </div>
                                                </div>
                                            </div>
		                                </div>
		                                
		                                <div class="col-sm-2 col-xl-4">
		                                    <div class="form-group">
                                                <label>Equipo</label>
                                                <div class="input-group">
                                                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                                                      <input class="radiobutton" type="radio" name="staff" id="staff" value="1">
                                                      <label class="radiobutton-label" for="staff">Sí</label>
                                                    </div>
                                                    <div class="form-check"  style="padding-left: 0px;">
                                                      <input  class="radiobutton" type="radio" name="staff" checked id="staffno" value="0">
                                                      <label class="radiobutton-label" for="staffno">No</label>
                                                    </div>
                                                </div>
                                            </div>
		                                </div>
		                                
		                                <div class="col-sm-2 col-xl-4">
		                                    <div class="form-group">
                                                <label>Inventario</label>
                                                <div class="input-group">
                                                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                                                      <input class="radiobutton" type="radio" name="inventory" id="inventory" value="1">
                                                      <label class="radiobutton-label" for="inventory">Sí</label>
                                                    </div>
                                                    <div class="form-check"  style="padding-left: 0px;">
                                                      <input  class="radiobutton" type="radio" name="inventory" checked id="inventoryno" value="0">
                                                      <label class="radiobutton-label" for="inventoryno">No</label>
                                                    </div>
                                                </div>
                                            </div>
		                                </div>
		                                
		                                <div class="col-sm-2 col-xl-4">
		                                    <div class="form-group">
                                                <label>Finanzas</label>
                                                <div class="input-group">
                                                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                                                      <input class="radiobutton" type="radio" name="financial" id="financial" value="1">
                                                      <label class="radiobutton-label" for="financial">Sí</label>
                                                    </div>
                                                    <div class="form-check"  style="padding-left: 0px;">
                                                      <input  class="radiobutton" type="radio" name="financial" checked id="financialno" value="0">
                                                      <label class="radiobutton-label" for="financialno">No</label>
                                                    </div>
                                                </div>
                                            </div>
		                                </div>
		                                
		                                <div class="col-sm-2 col-xl-4">
		                                    <div class="form-group">
                                                <label>Reportes</label>
                                                <div class="input-group">
                                                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                                                      <input class="radiobutton" type="radio" name="reports" id="reports" value="1">
                                                      <label class="radiobutton-label" for="reports">Sí</label>
                                                    </div>
                                                    <div class="form-check"  style="padding-left: 0px;">
                                                      <input  class="radiobutton" type="radio" name="reports" checked id="reportsno" value="0">
                                                      <label class="radiobutton-label" for="reportsno">No</label>
                                                    </div>
                                                </div>
                                            </div>
		                                </div>
		                                
		                                <div class="col-sm-2 col-xl-4">
		                                    <div class="form-group">
                                                <label>Configuración</label>
                                                <div class="input-group">
                                                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                                                      <input class="radiobutton" type="radio" name="settings" id="settings" value="1">
                                                      <label class="radiobutton-label" for="settings">Sí</label>
                                                    </div>
                                                    <div class="form-check"  style="padding-left: 0px;">
                                                      <input  class="radiobutton" type="radio" name="settings" checked id="settingsno" value="0">
                                                      <label class="radiobutton-label" for="settingsno">No</label>
                                                    </div>
                                                </div>
                                            </div>
		                                </div>
		                               </div> 
		                            </div>
                            <?php endif;?>
                    		      
                    		      
    		                <div class="col-sm-12">
    		                    <div class="form-group m-b-15">
    		                        <button class="btn btn-primary">Guardar datos</button>
    		                    </div>
    		                </div>
		                
                        </div>
                        </form>
                    </div>
             
            </div>
            </div>
        </div>
    </div>
    
    
    <script type="text/javascript">
        $('.itemName').select2();
    </script>
    
    
    <script>
    document.getElementById('apply').onchange = function () {
   var filename = this.value.replace(/C:\\fakepath\\/i, '')
   $( "#fileResponse" ).html('<b>Archivo seleccionado:</b> '+filename);
};

     function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imageUpload").change(function() {
        readURL(this);
    });
    $(function() {
            'use strict';
            if($('#DoctorPicker1').length) {
                var date = new Date();
                var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
                $('#DoctorPicker1').datepicker({
                    format: "dd/mm/yyyy",
                    todayHighlight: true,
                    autoclose: true
                });
            }
        });
        $('.ae-side-menu-toggler').on('click', function () {
            $('.app-side').toggleClass('compact-side-menu');
        });
        if ($('.app-side').length) {
            if (is_display_type('phone') || is_display_type('tablet')) {
                $('.app-side').addClass('compact-side-menu');
            }
        }
    </script>
  
	
	<script type="text/javascript">
    $('#fb').hide();
    $('#Ig').hide();
    
    $(function()
    {
      $('[name="Facebook"]').change(function()
      {
        if ($(this).is(':checked')) {
            $('#fb').show(500);
        }
        else{
            $('#fb').hide(500);
        };
      });
    });
    
    $(function()
    {
      $('[name="Instagram"]').change(function()
      {
        if ($(this).is(':checked')) {
            $('#Ig').show(500);
        }
        else{
            $('#Ig').hide(500);
        };
      });
    });
</script>
    
    <script>
    
        var bool = false;
    
        function showPass()
    {
        if(bool)
        {
             bool = false;
       $('#fpassword').hide(500);
       $('#spassword').hide(500);
       $('#btnpassword').hide(500);
        }else
        {
       $('#fpassword').show(500);
       $('#spassword').show(500);
       $('#btnpassword').show(500);
       bool = true;
        }
    }
    
    function validatePass()
    {
        
       var fpass = $('#fpassword').val();
       var spass = $('#spassword').val();
        
        if(fpass==spass)
        {
            
            
            $('#btnpassword').prop('disabled', false);
            
            
            $('#errorm').removeClass('error');
            $('#errorm').removeClass('error_show');
            $('#errorm').removeClass('success');
		    $('#errorm').text('');
		    
            
            
        }else
        {
            $('#btnpassword').prop('disabled', true);
            $('#errorm').removeClass('error');
            $('#errorm').removeClass('error_show');
            $('#errorm').removeClass('success');
		    $('#errorm').text('Las contraseñas no son iguales.').addClass('error').animate({ }, 300);
		    
        }
        
        
        
        
    }
    
    </script>
    
    
    
        
<script>
    
      function cuiIsValid(cui) {
                            var console = window.console;
                            
                            if (!cui) {
                                console.log("CUI vacío");
                                return true;
                            }
                        
                            var cuiRegExp = /^[0-9]{4}\s?[0-9]{5}\s?[0-9]{4}$/;
                        
                            if (!cuiRegExp.test(cui)) {
                                console.log("CUI con formato inválido");
                                return false;
                            }
                        
                            cui = cui.replace(/\s/, '');
                            var depto = parseInt(cui.substring(9, 11), 10);
                            var muni = parseInt(cui.substring(11, 13));
                            var numero = cui.substring(0, 8);
                            var verificador = parseInt(cui.substring(8, 9));
                            
                            // Se asume que la codificación de Municipios y 
                            // departamentos es la misma que esta publicada en 
                            // http://goo.gl/EsxN1a
                        
                            // Listado de municipios actualizado segun:
                            // http://goo.gl/QLNglm
                        
                            // Este listado contiene la cantidad de municipios
                            // existentes en cada departamento para poder 
                            // determinar el código máximo aceptado por cada 
                            // uno de los departamentos.
                            var munisPorDepto = [ 
                                /* 01 - Guatemala tiene:      */ 17 /* municipios. */, 
                                /* 02 - El Progreso tiene:    */  8 /* municipios. */, 
                                /* 03 - Sacatepéquez tiene:   */ 16 /* municipios. */, 
                                /* 04 - Chimaltenango tiene:  */ 16 /* municipios. */, 
                                /* 05 - Escuintla tiene:      */ 13 /* municipios. */, 
                                /* 06 - Santa Rosa tiene:     */ 14 /* municipios. */, 
                                /* 07 - Sololá tiene:         */ 19 /* municipios. */, 
                                /* 08 - Totonicapán tiene:    */  8 /* municipios. */, 
                                /* 09 - Quetzaltenango tiene: */ 24 /* municipios. */, 
                                /* 10 - Suchitepéquez tiene:  */ 21 /* municipios. */, 
                                /* 11 - Retalhuleu tiene:     */  9 /* municipios. */, 
                                /* 12 - San Marcos tiene:     */ 30 /* municipios. */, 
                                /* 13 - Huehuetenango tiene:  */ 32 /* municipios. */, 
                                /* 14 - Quiché tiene:         */ 21 /* municipios. */, 
                                /* 15 - Baja Verapaz tiene:   */  8 /* municipios. */, 
                                /* 16 - Alta Verapaz tiene:   */ 17 /* municipios. */, 
                                /* 17 - Petén tiene:          */ 14 /* municipios. */, 
                                /* 18 - Izabal tiene:         */  5 /* municipios. */, 
                                /* 19 - Zacapa tiene:         */ 11 /* municipios. */, 
                                /* 20 - Chiquimula tiene:     */ 11 /* municipios. */, 
                                /* 21 - Jalapa tiene:         */  7 /* municipios. */, 
                                /* 22 - Jutiapa tiene:        */ 17 /* municipios. */ 
                            ];
                            
                            if (depto === 0 || muni === 0)
                            {
                                console.log("CUI con código de municipio o departamento inválido.");
                                return false;
                            }
                            
                            if (depto > munisPorDepto.length)
                            {
                                console.log("CUI con código de departamento inválido.");
                                return false;
                            }
                            
                            if (muni > munisPorDepto[depto -1])
                            {
                                console.log("CUI con código de municipio inválido.");
                                return false;
                            }
                            
                            // Se verifica el correlativo con base 
                            // en el algoritmo del complemento 11.
                            var total = 0;
                            
                            for (var i = 0; i < numero.length; i++)
                            {
                                total += numero[i] * (i + 2);
                            }
                            
                            var modulo = (total % 11);
                            
                            console.log("CUI con módulo: " + modulo);
                            return modulo === verificador;
                        };
                        
        function validateDPI(ddd) {
            var $this = $(this);
            var $parent = $this.parent();
            var $next = $this.next();
            var cui = ddd;
            
            
            
            if (cui && cuiIsValid(cui)) {
                
               
                        
                        $('#errordpi').removeClass('error');
                        $('#errordpi').removeClass('error_show');
                        $('#errordpi').removeClass('success');
    			
    				   $('#errordpi').text('DPI válido').addClass('success').animate({ }, 300);
                         $('input[name ="dpi"]')[0].setCustomValidity('');
                
            } else if (cui) {
                
                
               
                        $('#errordpi').removeClass('error');
                        $('#errordpi').removeClass('error_show');
                        $('#errordpi').removeClass('success');
    			
    				   $('#errordpi').text('Debe ingresar un DPI válido').addClass('error').animate({ }, 300);
    				     $('input[name ="dpi"]')[0].setCustomValidity('DPI no valido');
    				   
            } else {
                
             
                        $('#errordpi').removeClass('error');
                        $('#errordpi').removeClass('error_show');
                        $('#errordpi').removeClass('success');
    			
    				   $('#errordpi').text('DPI no válido').addClass('error').animate({ }, 300);
    				   $('input[name ="dpi"]')[0].setCustomValidity('DPI no puede quedar vacio');
    				  
    				   
    				   
            }
        };
                        
        
       //Validar correo electronico  
        function validateEmail() {

            var email = $('input[name ="email"]').val();
            
            console.log(email);
            

                    //validar correo electronico
                	var validacion_email = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
                    
            				if (!validacion_email.test(email))
            				{   
                     				    
                    				   
                    				    $('#errorm').removeClass('error');
                                        $('#errorm').removeClass('error_show');
                                        $('#errorm').removeClass('success');
                    			
                    				   $('#errorm').text('correo electrónico no válido').addClass('error').animate({ }, 300);
                    				   $('input[name ="email"]')[0].setCustomValidity('correo no válido');
            				    
            				}   else
            				{
            				    
            				      $.ajax({
                                        type:"POST",
                                        url:"<?php echo base_url();?>doctor/check_m",
                                        data: {
                                                'mail':email
                                            },
                                            success:function (data) {
                                               
                                               console.log(data.available);
                                               if(data.available >0) 
                                               {
                                                   
                                                    $('#errorm').removeClass('error');
                                                    $('#errorm').removeClass('error_show');
                                                    $('#errorm').removeClass('success');
                                    			    $('#errorm').text('Correo electrónico registrado con otra cuenta').addClass('error').animate({ }, 300);
                                    			    $('input[name ="email"]')[0].setCustomValidity('correo electrónico no disponible');
                                    			    
                                               }else
                                               {    
                                                    $('#errorm').removeClass('error');
                                                    $('#errorm').removeClass('error_show');
                                                    $('#errorm').removeClass('success_show');
                                                        
                                    				$('#errorm').text('Este correo está disponible').addClass('success').animate({ }, 300);
                                                   $('input[name ="email"]')[0].setCustomValidity('');
                                               }
                                                
                                      	 	},error:function(jqXHR, textStatus, errorThrown){
                                                 console.log('error: '+ errorThrown);
                                    }
                                   
                                   	});
            					                                 


                                
		                    }
        };
</script>

    
    
    
    
    