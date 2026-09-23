<?php 
    $staff_id = base64_decode($id_);
    $this->db->where('staff_id', $staff_id);
    $info = $this->db->get('staff')->result_array();    
    foreach($info as $details):
?>
    <div class="todo-app-w">
        <div class="todo-sidebar">
        <div id="sticky">
            <div class="todo-sidebar-section" style="border-bottom:0px">
                <div class="todo-sidebar-section-contents">
                    <ul class="tasks-list">
                        <li class="side-li">
                            <a class="side-items active" href="<?php echo base_url();?>doctor/staff_profile/<?php echo base64_encode($staff_id);?>/"><i style="padding-right: 10px;    font-size: 22px;" class="picons-thin-icon-thin-0002_write_pencil_new_edit"></i> Editar perfil <span class="side-active"></span> </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/staff_notifications/<?php echo base64_encode($staff_id);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0543_world_earth_worldwide_location_travel"></i> Notificaciones </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/staff_security/<?php echo base64_encode($staff_id);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0705_user_profile_security_password_permissions"></i> Contraseña y seguridad </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/staff_activity/<?php echo base64_encode($staff_id);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0244_text_bullets_list"></i> Registro de actividad </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/staff_permissions/<?php echo base64_encode($staff_id);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0015_fountain_pen"></i> Permisos </a>
                        </li>
                    </ul>
                    <div class="text-center account-container"></div>
                </div>
            </div>
            </div>
        </div>
    <div class="todo-content conts">
        <h4 class="todo-content-header">
            <i class="batch-icon-arrow-right"></i><span>Editar perfil - <?php echo $this->accounts_model->get_name('staff',$details['staff_id']);?></span>
        </h4>
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-info">
                    <span class="alert-title"><i class="batch-icon-spam"></i> Manten actualizados tus datos.</span>
                    <span class="alert-content">Recuerda siempre mantener todos tus datos actualizados en esta sección, si no los actualizas es posible que no recibas notificaciones o tengas problemas de comunicación con <span class="alert-lined"><a href="javascript:void(0);" style="color:#0044e9">Medicaby</a>.</span></span>
                </div>  
            </div>
            <div class="col-sm-8">
                <div class="tasks-section">
                    <form action="<?php echo base_url();?>doctor/staff/update/<?php echo $details['staff_id'];?>" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-12 ">
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                        <input type='file' name="photo" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                        <label for="imageUpload"></label>
                                    </div>
                                    <div class="avatar-preview" style="border: 2px solid #198cff8f;">
                                        <div id="imagePreview" style="background-image: url(<?php echo $this->accounts_model->get_photo('staff', $staff_id);?>);"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
	                                <div class="form-group m-b-15">
       		                            <label for="simpleinput">Nombres:</label>
	                                    <input type="text" style="border: 1px solid #198cff8f;" name="first_name" required="" value="<?php echo $details['first_name'] ?>" class="form-control">
	                                </div>
	                            </div>

	                            <div class="col-sm-6">
	                                <div class="form-group m-b-15">
       		                            <label for="simpleinput">Apellidos:</label>
	                                    <input type="text" style="border: 1px solid #198cff8f;" name="last_name" required="" value="<?php echo $details['last_name'] ?>" class="form-control">
	                                </div>
	                            </div>
                                <div class="col-sm-12">
	                                <div class="form-group m-b-15">
       		                            <label for="simpleinput">Correo:</label>
	                                    <input type="email" style="border: 1px solid #198cff8f;" name="email" required="email" value="<?php echo $details['email'] ?>" class="form-control">
	                                </div>
	                            </div>
	                            <div class="col-sm-12">
	                                <div class="form-group m-b-15">
       		                            <label for="simpleinput">Celular:</label>
	                                    <input type="text" style="border: 1px solid #198cff8f;" name="phone" required="" value="<?php echo $details['phone'] ?>" class="form-control">
		                                </div>
	                            </div>
	                            
	                              <div class="col-sm-12">
		                            <div class="form-group m-b-15">
        		                        <label for="simpleinput">Dirección:</label>
		                                <textarea type="text" style="border: 1px solid #198cff8f;" name="address" required="" class="form-control"><?php echo $details['address'];?></textarea>
		                            </div>
		                        </div>
	                            
                            <div class="col-sm-12">
                                <div class="form-group date-time-picker m-b-15">
                                    <label for="simpleinvput">Nacimiento</label>
        			                <div class="input-group date datepicker" id="DoctorPicker1">
        	                           <input type="text" id="applyDate" name="date_of_birth" autocomplete="off" style="border: 1px solid #198cff8f;" value="<?php echo $details['date_of_birth'];?>" class="form-control">
        	        		           <span style="display: none;" class="input-group-addon"><i data-feather="calendar"></i></span>
        			               </div>
        		                </div>
	                        </div>
	                            <div class="col-sm-4">
		                            <div class="form-group">
		                                <label>Tipo de cuenta:</label>
		                                <select class="form-control" name="charge" required>
		                                         <option value="">Seleccionar</option>
		                                         <option value="Secretaria" <?php if($details['charge'] == 'Secretaria') echo "selected";?>>Secretaria</option>
		                                         <option value="Asistente" <?php if($details['charge'] == 'Asistente') echo "selected";?>>Asistente</option>
		                                     </select>
		                            </div>
		                        </div>
		                        
		                        <div class="col-sm-4">
		                                <div class="form-group m-b-15">
       		                            <label for="simpleinput">Salario:</label>
	                                    <input type="text" style="border: 1px solid #198cff8f;" name="salary" required="" value="<?php echo $details['salary'] ?>" class="form-control">
		                                </div>
		                            
		                        </div>
		                        
		                        <div class="col-sm-4">
	                                <div class="form-group">
	                                    <label>Género:</label>
	                                    <div class="input-group">
                                    <div class="form-check" style="padding-left: 0px;">
                                      <input <?php if($details['gender'] == "M") echo "checked";?> class="radiobutton" type="radio" name="gender" id="radio3" value="M"><label class="radiobutton-label" for="radio3">Masculino</label>
                                    </div>
                                    <div class="form-check mr-3">
                                      <input <?php if($details['gender'] == "F") echo "checked";?> class="radiobutton" type="radio" name="gender" id="radio4" value="F"><label class="radiobutton-label" for="radio4">Femenino</label>
                                    </div>
                                    </div>
		                        </div>
		                        </div>
		                        
		                        <div class="col-sm-12">
	                            <label>Redes sociales</label>
	                                <div class="row">
	                                  
	  	                              <div class="col-sm-5">
		                                  <div class="col-sm-12">
        		                            <div class="form-group m-b-15">
                		                        <div class="form-group">
         		                                    <div class="custom-control custom-checkbox mr-sm-2">
        		                                        <input type="checkbox" id="invc" name="Facebook" <?php if($details['facebook'] != '') echo 'checked';?> value="1" class="custom-control-input check">
            		                                    <label class="custom-control-label" for="invc">Facebook</label>
        		                                    </div>
        								        </div>
        		                            </div>
        		                          </div>
        		                           
        		                           <div class="col-sm-12"  id="fb">
        		                                <div class="form-group m-b-15">
                		                           <label for="simpleinput">Ingrese link de Facebook</label></label>
        		                                    <div class="form-group">
         		                                        <input style="border: 1px solid #198cff8f;" type="text" name="link_facebook" value="<?php echo $details['facebook'];?>" class="form-control">
        		                                    </div>
        		                                </div>
        		                            </div>
		                              </div>
	                              
	                              <div class="col-sm-5">
	                                  <div class="col-sm-12">
    		                            <div class="form-group m-b-15">
            		                        <div class="form-group">
     		                                    <div class="custom-control custom-checkbox mr-sm-2">
    		                                        <input style="border: 1px solid #198cff8f;" <?php if($details['instagram'] != '') echo 'checked';?> type="checkbox" id="invc3" name="Instagram" value="1" class="custom-control-input check">
        		                                    <label class="custom-control-label" for="invc3">Instagram</label>
    		                                    </div>
    								        </div>
    		                            </div>
    		                          </div>
        		                           
    		                           <div class="col-sm-12"  id="Ig">
    		                                <div class="form-group m-b-15">
            		                           <label for="simpleinput">Ingrese link de Instagram</label></label>
    		                                    <div class="form-group">
     		                                        <input style="border: 1px solid #198cff8f;" type="text" name="link_instagram" value="<?php echo $details['instagram'];?>" class="form-control">
    		                                    </div>
    		                                </div>
    		                            </div>
	                              </div>
	                              
	                              <div class="col-sm-2">
	                                  <div class="col-sm-12">
    		                            <div class="form-group m-b-15">
            		                        <div class="form-group">
     		                                    <div class="custom-control custom-checkbox mr-sm-2">
    		                                        <input type="checkbox" id="invc2" name="Whatsapp"  <?php if($details['whatsapp'] == 1) echo 'checked';?> value="1" class="custom-control-input check">
        		                                    <label class="custom-control-label" for="invc2">WhatsApp</label>
    		                                    </div>
    								        </div>
    		                            </div>
    		                          </div>
        		                  </div>
        		              </div>
            		      </div>
		                      
		              
		                
		                <div class="col-sm-12">
		                    <div class="form-group m-b-15">
		                        <button class="btn btn-primary">Aplicar cambios</button>
		                    </div>
		                </div>
		                
                        </div>
                        </form>
                    </div>
             
            </div>
            <div class="col-sm-4">
                <br>
                <h5 class="panel-content-title" style="font-weight:100">Servicios que usas para iniciar sesión en Medicaby.</h5>
                <span class="app-divider2"></span>
                <div class="support-ticket  <?php echo $details['gm_id'] == '' ? '':'active'; ?>" id="google">
                                        <div class="st-body">
                                            <div class="avatar">
                                                <img src="<?php echo base_url();?>public/assets/theme/images/google.png" style="width: 40px;">
                                            </div>
                                            <div class="ticket-content">
                                                <div class="ticket-description">
                                                    <div class="os-progress-bar primary">
                                                        <div class="bar-labels">
                                                            <div class="bar-label-left">
                                                                <span class="bigger"><b>Google</b></span>
                                                            </div>
                                                        </div>
                                                        <div class="bar-level-1" style="width: 100%;background:#fff;margin-top: -6px;">
                                                        <?php echo $details['gm_id'] == '' ? 'Sin vincular':'Vinculado'; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="support-ticket <?php echo $details['fb_id'] == '' ? '':'active'; ?>" > 
                                        <div class="st-body">
                                            <div class="avatar">
                                                <img src="<?php echo base_url();?>public/assets/theme/images/fb.png" style="width: 40px;">
                                            </div>
                                            <div class="ticket-content">
                                                <div class="ticket-description">
                                                    <div class="os-progress-bar primary">
                                                        <div class="bar-labels">
                                                            <div class="bar-label-left">
                                                                <span class="bigger"><b>Facebook</b></span>
                                                            </div>
                                                        </div>
                                            <div class="bar-level-1" style="width: 100%;background:#fff; margin-top: -6px;">
                                            <?php echo $details['fb_id'] == '' ? 'Sin vincular':'Vinculado'; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            </div>
            </div>
        </div>
    </div>
      </div>
    </div>
    
    <script type="text/javascript">
<?php if($details['facebook'] == ''):?>
    $('#fb').hide();
<?php endif;?>
<?php if($details['instagram'] == ''):?>
    $('#Ig').hide();
<?php endif;?>    
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

    <script src="<?php echo base_url();?>public/assets/back/js/jquery-3.1.1.min.js"></script>
    <script>
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
   
   
   


<!--     <div id="main-content">
	    <div class="row">

		    <div class="col-sm-4">

		        <div class="card-box">
					<div class="row">
					    <div class="col-sm-12 m-b-30 row">
                             
                                <div class="col-md-4">
                                    <input style="display:none" id="fpassword" name="titulo" autocomplete="off" type="password" onkeyup="validatePass()" placeholder="Nueva contraseña" class="form-control" required>
                                </div>

                                <div class="col-md-4">
                                    <span id="errorm"></span>
                                    <input style="display:none" id="spassword" name="titulo" autocomplete="off" type="password" onkeyup="validatePass()" placeholder="Repetir contraseña" class="form-control" required>
                                </div>
                            
					        <button style="display:none" class="btn btn-success" id="btnpassword" disabled onclick="changePass()" >Cambiar contraseña</button>
					    </div>

					
					</div>
				</div>
		    </div>
	    </div>
	</div>-->
    <?php 
    endforeach;
    ?>
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
     function changePass()
    {
            Swal.fire({
                title: 'Confirmar esta acción',
                text: "Se enviará un correo al paciente con la información de la cita. ¿Seguro deseas continuar?",
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#9fd13b',
                cancelButtonColor: '#fd4f57',
                confirmButtonText: 'Enviar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) 
                {
                        $.ajax({
                        url: "<?php echo base_url();?>doctor/password_change_pass",
                        type: 'POST',
                        data: {'id':<?php echo base64_decode($id_);?>,
                                'pass': $('#spassword').val()
                        
                            
                        },
                        success: function(data){
                           
                           if(data='success')
                           {
                               const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-right',
                                showConfirmButton: false,
                                timer: 5000
                                }); 
                                Toast.fire({
                                    type: 'success',
                                    title: 'cambiado correctamente'
                                });
                                
                                       $('#fpassword').hide(500);
                                       $('#spassword').hide(500);
                                       $('#btnpassword').hide(500);
                                       
                                       $('#fpassword').val('');
                                       $('#spassword').val('');
                                       
                                       bool = false;
                               
                           }else
                           {
                                const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-right',
                                showConfirmButton: false,
                                timer: 5000
                                }); 
                                Toast.fire({
                                    type: 'error',
                                    title: data
                                })
                               
                               
                               
                           }

                        },
                        error: function(data){
                            /*
                            * Se ejecuta si la peticón ha sido erronea
                            * */
                            alert("Problemas al tratar de enviar el formulario");
                        }
                    });
                    
                }
            });
    }
    </script>