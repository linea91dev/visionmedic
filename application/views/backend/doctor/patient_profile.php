<?php 
    $patient_id = base64_decode($id_);
    $this->db->where('patient_id', $patient_id);
    $info = $this->db->get('patient')->result_array();    
    foreach($info as $details):
?>
<style>
    #video{
        width: 100%;
        height: 100%;
        border-radius: 100%;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        display:none;
    }
    .avatar-upload .avatar-preview
    {
            width: 200px;
    height: 200px;
    position: relative;
    border-radius: 100%;
    border: 5px solid #e2e1e1;
    box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1)
    }
</style>
    <div class="todo-app-w">
        <div class="todo-sidebar">
        <div id="sticky">
            <div class="todo-sidebar-section" style="border-bottom:0px">
                <div class="todo-sidebar-section-contents">
                    <ul class="tasks-list">
                        <li class="side-li">
                            <a class="side-items active" href="<?php echo base_url();?>doctor/patient_profile/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0002_write_pencil_new_edit"></i> Editar perfil <span class="side-active"></span></a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/medical_history/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0299_address_book_contacts"></i> Historial </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/patient_security/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0705_user_profile_security_password_permissions"></i> Contraseña y seguridad </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/medical_prescriptions/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0003_write_pencil_new_edit"></i> Recetas </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/patient_files/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0119_folder_open_full_documents"></i> Archivos </a>
                        </li>
                        <?php  
                            $odonto = $this->db->get_where('clinic', array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->odonto;
                            if($odonto != ''):
                        ?>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/treatment/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0826_teeth_tooth_dental"></i> Planes de tratamiento </a>
                        </li>
                        <?php endif;?>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/patient_appointments/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0021_calendar_month_day_planner"></i> Citas </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/patient_financial/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0425_money_payment_dollar_cash"></i> Financiero </a>
                        </li>
                    </ul>
                    <div class="text-center account-container"></div>
                </div>
            </div>
            </div>
        </div>
    <div class="todo-content conts">
        <h4 class="todo-content-header">
            <i class="batch-icon-arrow-right"></i><span> Editar perfil - <?php echo $this->accounts_model->get_name('patient',$details['patient_id']);?> </span>
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
                     <div class="col-sm-12 ">
                                 <div id="camera">
                                   
                                    <button id="startbutton">Tomar Foto</button>
                                </div>
                               
                            </div>
                    <form id="profileUpdate" action="<?php echo base_url();?>doctor/patients/update/<?php echo $details['patient_id'];?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="patient_id" id="patient_id" value="<?php echo $details['patient_id']; ?>"/>
		                    <input type="hidden" name="profile" value="1" required="" class="form-control">
                        <div class="row">
                            <div class="col-sm-12 " style="text-align: center;display: flex;justify-content: center;">
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                        <input type='file' name="photo" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                        
                                        <label for="imageUpload"></label>
                                    </div>
                                    <div class="avatar-preview" style="border: 2px solid #198cff8f;">
                                         <video id="video" >Video stream not available.</video>
                                        <div id="imagePreview" style="background-image: url(<?php echo $this->accounts_model->get_photo('patient', $patient_id);?>);"></div>
                                    </div>
                                </div>
                            </div>
                           
                             <input type="hidden" id="photo" name="photo">
                            <div class="col-sm-4">
	                                <div class="form-group m-b-15">
       		                            <label for="simpleinput"><span style="color:red">*</span> Primer nombre:</label></label>
	                                    <input type="text" style="border: 1px solid #198cff8f;" name="first_name" required="" value="<?php echo $details['first_name'] ?>" class="form-control">
	                                </div>
	                            </div>
	                            <div class="col-sm-4">
	                                <div class="form-group m-b-15">
       		                            <label for="simpleinput">Segundo nombre:</label>
	                                    <input type="text" style="border: 1px solid #198cff8f;" name="second_name"  value="<?php echo $details['second_name'] ?>" class="form-control">
	                                </div>
	                            </div>
	                            <div class="col-sm-4">
	                                <div class="form-group m-b-15">
       		                            <label for="simpleinput">Tercer nombre:</label>
	                                    <input type="text" style="border: 1px solid #198cff8f;" name="third_name"  value="<?php echo $details['third_name'] ?>" class="form-control">
	                                </div>
	                            </div>
	                            <div class="col-sm-4">
	                                <div class="form-group m-b-15">
       		                            <label for="simpleinput"><span style="color:red">*</span> Primer apellido:</label></label>
	                                    <input type="text" style="border: 1px solid #198cff8f;" name="last_name" required="" value="<?php echo $details['last_name'] ?>" class="form-control">
	                                </div>
	                            </div>
	                            <div class="col-sm-4">
	                                <div class="form-group m-b-15">
       		                            <label for="simpleinput">Segundo apellido:</label>
	                                    <input type="text" style="border: 1px solid #198cff8f;" name="second_last_name"  value="<?php echo $details['second_last_name'] ?>" class="form-control">
	                                </div>
	                            </div>
	                            <div class="col-sm-4">
	                                <div class="form-group m-b-15">
       		                            <label for="simpleinput">Apellido de casada:</label>
	                                    <input type="text" style="border: 1px solid #198cff8f;" name="married_last_name"  value="<?php echo $details['married_last_name'] ?>" class="form-control">
	                                </div>
	                            </div>
	                            <div class="col-sm-6">
                                <div class="form-group date-time-picker m-b-15">
                                    <label for="simpleinvput"><span style="color:red">*</span> Nacimiento</label></label>
        			                <div class="input-group date datepicker" id="DoctorPicker1">
        	                           <input type="text" id="applyDate" name="date_of_birth" autocomplete="off" style="border: 1px solid #198cff8f;" value="<?php echo $details['date_of_birth'];?>" class="form-control">
        	        		           <span style="display: none;" class="input-group-addon"><i data-feather="calendar"></i></span>
        			               </div>
        		                </div>
	                        </div>
                                <div class="col-sm-6">
	                                <div class="form-group m-b-15"></label>
       		                            <label for="simpleinput">Correo:</label>
	                                    <input type="email" style="border: 1px solid #198cff8f;" name="email" value="<?php echo $details['email'] ?>" class="form-control" onkeyup="validateEmail();">
	                                </div>
	                            </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>¿Enviar notificaciones por correo?</label>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="email1" name="email_status" value="1" <?php if($details['email_status'] == 1) echo "checked";?> class="custom-control-input">
                                            <label class="custom-control-label" for="email1">Si</label>
                                        </div>
                                        <div class="custom-control custom-radio"> 
                                            <input type="radio" id="email2" name="email_status" value="0" <?php if($details['email_status'] == 0) echo "checked";?> class="custom-control-input">
                                            <label class="custom-control-label" for="email2">No</label>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
	                                <div class="form-group m-b-15">
       		                            <label for="simpleinput"><span style="color:red">*</span> Celular</label>
	                                    <input type="number" style="border: 1px solid #198cff8f;" name="phone" value="<?php echo $details['phone'] ?>" maxlength="15" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"  required="" class="form-control">
                                    </div>
	                            </div>
	                            <div class="col-sm-4">
	                                <div class="form-group m-b-15"></label>
       		                            <label for="simpleinput">Teléfono de contacto:</label>
	                                    <input type="number"  style="border: 1px solid #198cff8f;" maxlength="15" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" name="phone_contact" value="<?php echo $details['phone_contact'] ?>" class="form-control">
                                    </div>
	                            </div>
	                            <?php 
                                $sms = $this->db->get_where('clinic',array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->sms;
                                if($sms == 1): ?>
	                            <div class="col-sm-4">
		                            <div class="form-group">
		                                <label>Notificaciones por sms:</label>
		                                <div class="custom-control custom-radio">
		                                    <input type="radio" id="wha2" name="whatsapp_status" value="1" <?php if($details['whatsapp_status'] == 1) echo "checked";?> class="custom-control-input">
    		                                <label class="custom-control-label" for="wha2">Sí</label>
		                                </div>
		                            <div class="custom-control custom-radio">
		                                <input type="radio" id="wha" name="whatsapp_status" value="0" <?php if($details['whatsapp_status'] == 0) echo "checked";?> class="custom-control-input">
    		                            <label class="custom-control-label" for="wha">No</label>
		                            </div>
		                            </div>
		                        </div>
                                <?php endif;?>
	                            <div class="col-sm-6">
	                                <div class="form-group m-b-15">
       		                            <label for="simpleinput">Profesión/Ocupación:</label>
	                                    <input type="text" style="border: 1px solid #198cff8f;" name="profession"  value="<?php echo $details['profession'] ?>" class="form-control">
		                                </div>
	                            </div>
	                            <div class="col-sm-6">
	                                <div class="form-group m-b-15">
       		                            <label for="simpleinput">Tipo sanguíneo:</label>
       		                            <select class="form-control" name="blood" tyle="border: 1px solid #198cff8f;">
        		                                <option value="">Seleccionar</option>
        		                                <option value="A+" <?php if($details['blood'] == 'A+') echo 'selected';?>>A+</option>
        		                                <option value="A-" <?php if($details['blood'] == 'A-') echo 'selected';?>>A-</option>
        		                                <option value="B+" <?php if($details['blood'] == 'B+') echo 'selected';?>>B+</option>
        		                                <option value="B-" <?php if($details['blood'] == 'B-') echo 'selected';?>>B-</option>
        		                                <option value="O+" <?php if($details['blood'] == 'O+') echo 'selected';?>>O+</option>
        		                                <option value="O-" <?php if($details['blood'] == 'O-') echo 'selected';?>>O-</option>
        		                                <option value="AB+" <?php if($details['blood'] == 'AB+') echo 'selected';?>>AB+</option>
        		                                <option value="AB-" <?php if($details['blood'] == 'AB-') echo 'selected';?>>AB-</option>
        		                        </select>
		                            </div>
	                            </div>
                                
                                
	                              <div class="col-sm-12">
		                            <div class="form-group m-b-15">
        		                        <label for="simpleinput">Dirección:</label>
		                                <textarea type="text" style="border: 1px solid #198cff8f;" name="address" class="form-control"><?php echo $details['address'];?></textarea>
		                            </div>
		                        </div>
	                            <div class="col-sm-6">
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
		                        
		                        <div class="col-sm-6">
		                            <div class="form-group">
	                                    
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
                <h5 class="panel-content-title" style="font-weight:100">Servicios que utiliza para iniciar sesión en Medicaby.</h5>
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
    <script src="<?php echo base_url();?>public/assets/back/js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/sticky-sidebar.js"></script>
<script src="<?php echo base_url();?>public/assets/theme/js/jquery.sticky.js"></script>
<script src="<?php echo base_url();?>public/assets/theme/js/PositionSticky/dist/PositionSticky.js"></script>
    <script>

var sidebar = new StickySidebar('#sticky', {topSpacing: 10});
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
        
        
        // Obtenemos la referencia al botón para tomar la foto
var startButton = document.getElementById("startbutton");

// Agregamos el evento click al botón
startButton.addEventListener("click", function(){
    // Obtenemos la referencia al video y su contexto
    var video = document.getElementById("video");
    var canvas = document.createElement("canvas");
    var context = canvas.getContext("2d");

    // Escalamos el tamaño del canvas para que sea igual al tamaño del video
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.style.borderRadius = "50%";
    // Dibujamos la imagen del video en el canvas
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    // Convertimos la imagen a formato base64 y la asignamos al input
    var photoInput = document.getElementById("photo");
    photoInput.value = canvas.toDataURL();
    
    console.log(canvas.toDataURL())
    $('#imagePreview').css('background-image', 'url('+canvas.toDataURL() +')');
});

if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia){
    // El navegador soporta getUserMedia

    // Verificamos si el usuario ha permitido el acceso a la cámara
    navigator.mediaDevices.getUserMedia({video:true})
        .then(function(stream){
            // Accedemos a la cámara
            var video = document.querySelector("video");
            video.srcObject = stream;
            video.play();
        })
        .catch(function(err){
            // El usuario ha denegado el acceso a la cámara
            console.log("Error al acceder a la cámara: " + err.message);
        });
}else{
    // El navegador no soporta getUserMedia
    console.log("Lo sentimos, tu navegador no soporta getUserMedia.");
}


    </script>
<?php  endforeach; ?>