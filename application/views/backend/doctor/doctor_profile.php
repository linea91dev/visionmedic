<?php 
    $doctor_id = $id_;
    $this->db->where('admin_id', $doctor_id);
    $info = $this->db->get('admin')->result_array();    
    foreach($info as $details): 
        $owner = $this->crud_model->account_owner();
?>
    <link href="<?php echo base_url();?>public/assets/appointments/css/select2.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <div class="todo-app-w">
        <div class="todo-sidebar">
        <div id="sticky">
            <div class="todo-sidebar-section" style="border-bottom:0px">
                <div class="todo-sidebar-section-contents">
                    <ul class="tasks-list">
                        <li class="side-li">
                            <a class="side-items active" href="<?php echo base_url();?>doctor/doctor_profile/<?php echo base64_encode($details['admin_id']);?>/"><i style="padding-right: 10px;    font-size: 22px;" class="picons-thin-icon-thin-0002_write_pencil_new_edit"></i> <?php if($owner == 1):?> Editar perfil <?php else:?> Ver perfil<?php endif;?> <span class="side-active"></span></a>
                        </li>
                        <?php if($owner == 1):?>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/notifications/<?php echo base64_encode($details['admin_id']);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0543_world_earth_worldwide_location_travel"></i> Notificaciones </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/doctor_security/<?php echo base64_encode($details['admin_id']);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0705_user_profile_security_password_permissions"></i> Contraseña y seguridad </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/doctor_activity/<?php echo base64_encode($details['admin_id']);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0244_text_bullets_list"></i> Registro de Actividad </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/doctor_calendar/<?php echo base64_encode($details['admin_id']);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i> Calendario </a>
                        </li>
                        <?php endif;?>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/doctor_appointments/<?php echo base64_encode($details['admin_id']);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0021_calendar_month_day_planner"></i> Citas </a>
                        </li>
                        <?php if($owner == 1):?>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/doctor_permissions/<?php echo base64_encode($details['admin_id']);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0015_fountain_pen"></i> Permisos </a>
                        </li>
                        <?php endif;?>
                    </ul>
                    <div class="text-center account-container"></div>
                </div>
            </div>
            </div>
        </div>
        <div class="todo-content" style="margin-bottom: 10%;">
            <h4 class="todo-content-header">
                <?php if($owner == 1):?>
                    <i class="batch-icon-arrow-right"></i><span>Editar perfil - <?php echo $this->accounts_model->get_name('admin',$details['admin_id']);?></span>
                <?php else:?>
                    <i class="batch-icon-arrow-right"></i><span>Perfil de doctor - <?php echo $this->accounts_model->get_name('admin',$details['admin_id']);?></span>
                <?php endif;?>
            </h4>
            <div class="row">
                <div class="col-sm-12">
                    <?php if($owner == 1):?>
                    <div class="alert alert-info">
                        <span class="alert-title"><i class="batch-icon-spam"></i> Mantén actualizados los datos.</span>
                        <span class="alert-content">Recuerda siempre mantener todos los datos actualizados en esta sección, si no estám actualizados es posible que no se envíen notificaciones o se tengan problemas de comunicación con <span class="alert-lined"><a href="javascript:void(0);" style="color:#0044e9">Medicaby</a>.</span></span>
                    </div>  
                    <?php endif;?>
                </div>
                <div class="col-sm-8">
                    <div class="tasks-section">
                        <form action="<?php echo base_url();?>doctor/doctors/update/<?php echo $details['admin_id'];?>" method="POST" id="doctorUpdate" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-sm-12 ">
                                    <div class="avatar-upload">
                                        <?php if($owner == 1):?>
                                        <div class="avatar-edit">
                                            <input type='file' name="photo" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                            <label for="imageUpload"></label>
                                        </div>
                                        <?php endif;?>
                                        <div class="avatar-preview" style="border: 2px solid #198cff8f;">
                                            <div id="imagePreview" style="background-image: url(<?php echo $this->accounts_model->get_photo('admin', $details['admin_id']);?>);"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Primer Nombre<span style="color:red">*</span></label>
                                        <input style="border: 1px solid #198cff8f;" type="text" name="first_name" value="<?php echo $details['first_name'];?>" required="" class="form-control" <?php if($owner != '1'):?> readonly="" <?php endif;?>>
                                    </div>
                                </div>                            
                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Segundo Nombre</label>
                                        <input style="border: 1px solid #198cff8f;" type="text" name="second_name" value="<?php echo $details['second_name'];?>" class="form-control" <?php if($owner != '1'):?> readonly="" <?php endif;?>>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Tercer Nombre</label>
                                        <input style="border: 1px solid #198cff8f;" type="text" name="third_name" value="<?php echo $details['third_name'];?>" class="form-control" <?php if($owner != 1):?> readonly <?php endif;?> />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Primer Apellido<span style="color:red">*</span></label>
                                        <input style="border: 1px solid #198cff8f;" type="text" name="last_name" required="" value="<?php echo $details['last_name'];?>" class="form-control" <?php if($owner != 1):?> readonly="" <?php endif;?>>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Segundo Apellido</label>
                                        <input style="border: 1px solid #198cff8f;" type="text" name="second_last_name" value="<?php echo $details['second_last_name'];?>" class="form-control" <?php if($owner != 1):?> readonly="" <?php endif;?>>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Apellido de casada</label>
                                        <input style="border: 1px solid #198cff8f;" type="text" name="married_last_name" value="<?php echo $details['married_last_name'];?>" class="form-control" <?php if($owner != 1):?> readonly="" <?php endif;?>>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group date-time-picker m-b-15">
                                        <label for="simpleinvput">Nacimiento</label>
                                        <div class="input-group date datepicker" id="DoctorPicker1">
                                           <input style="border: 1px solid #198cff8f;" type="text" id="applyDate" name="date_of_birth" autocomplete="off" style="border: 1px solid #198cff8f;"  value="<?php echo $details['date_of_birth'];?>" class="form-control" <?php if($owner != 1):?> readonly="" <?php endif;?>>
                                           <span style="display: none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                       </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Identificación<span style="color:red">*</span></label>  <span class="" id="errordpi"></span>
                                        <input style="border: 1px solid #198cff8f;" type="text" name="dpi" id="dpi" required="" value="<?php echo $details['dpi']?>" onkeyup="validateDPI(this.value);" class="form-control" <?php if($owner != 1):?> readonly="" <?php endif;?>>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Celular<span style="color:red">*</span></label>
                                        <input style="border: 1px solid #198cff8f;" type="tel" name="phone" value="<?php echo $details['phone']?>" required="" class="form-control" <?php if($owner != 1):?> readonly="" <?php endif;?>>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Correo<span style="color:red">*</span></label>  <span class="" id="errorm"></span>
                                        <input style="border: 1px solid #198cff8f;" type="email" name="email" id="email" required="" value="<?php echo $details['email']?>" onkeyup="validateEmail();" class="form-control" <?php if($owner != 1):?> readonly="" <?php endif;?>>
                                    </div>
                                </div>
                                <?php if($owner == 1): ?> 
                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Salario<span style="color:red">*</span></label>
                                        <input <?php if($owner != 1):?> readonly="" <?php endif;?> style="border: 1px solid #198cff8f;" type="number" value="<?php echo $details['salary']?>" name="salary" class="form-control">  
                                   </div> 
                                </div>
                                <?php endif;?> 
                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">No. Colegiado</label>
                                        <input style="border: 1px solid #198cff8f;" type="text" name="no_college" value="<?php echo $details['no_college']?>" class="form-control" <?php if($owner != 1):?> readonly="" <?php endif;?> />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Usuario</label>
                                        <input style="border: 1px solid #198cff8f;" type="text" name="married_last_name" value="<?php echo $details['username'];?>" class="form-control" readonly="">
                                    </div>
                                </div>
                                <?php if($owner == 1):?>
                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Firma</label>
                                        <label class="labelx" for="apply"><input type="file" name="signature" class="inputx" id="apply" accept=".jpg, .png, .jpeg">Seleccionar</label>
    		                            <small id="fileResponse"></small>
                                    </div>
                                </div>
                                <?php endif;?>
                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Especialidad 1 <span style="color:red">*</span></label>
                                        <select  class="itemName form-control select2" style="border: 1px solid #198cff8f;" required="" style="width:100%" name="specialty_1" <?php if($owner != 1):?> disabled="" <?php endif;?>>
                                            <option value="">Seleccionar</option>
                                            <?php 
                                                $specialties = $this->db->get('specialtie')->result_array();
                                                foreach($specialties as $cat):
                                            ?>
                                            <option value="<?php echo $cat['specialtie_id'];?>" <?php if($details['specialty_1'] == $cat['specialtie_id']) echo "selected";?>><?php echo $cat['name'];?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Especialidad 2 <span style="color:red">*</span></label>
                                        <select  style="border: 1px solid #198cff8f;"  class="itemName form-control" style="width:100%" name="specialty_2" <?php if($owner != 1):?> disabled="" <?php endif;?>>
                                            <option value="">Seleccionar</option>
                                            <?php 
                                                foreach($specialties as $cat):
                                            ?>
                                            <option value="<?php echo $cat['specialtie_id'];?>" <?php if($details['specialty_2'] == $cat['specialtie_id']) echo "selected";?>><?php echo $cat['name'];?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-<?php if($owner == 1):?>4<?php else:?>6<?php endif;?>">
                                    <div class="form-group">
                                        <label>Estado civil</label>
                                        <div class="input-group">
                                            <div class="form-check" style="padding-left: 0px; padding-right:1px">
                                              <input <?php if($details['status'] == 0) echo "checked";?> class="radiobutton" type="radio" name="status" id="single1" value="0" <?php if($owner != 1):?> disabled="" <?php endif;?>><label class="radiobutton-label" for="single1">Soltero</label>
                                            </div>
                                            <div class="form-check" style="padding-left: 0px;">
                                              <input <?php if($details['status'] == 1) echo "checked";?> class="radiobutton" type="radio" name="status" id="maried1" value="1" <?php if($owner != 1):?> disabled="" <?php endif;?>><label class="radiobutton-label" for="maried1">Casado</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if($owner == 1):?>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Tipo de cuenta</label>
                                        <div class="input-group">
                                            <div class="form-check" style="padding-left: 0px; padding-right:1px">
                                              <input <?php if($details['owner'] == 1) echo "checked";?> class="radiobutton" type="radio" name="owner" id="owner" value="1" <?php if($owner != 1):?> disabled="" <?php endif;?>><label class="radiobutton-label" for="owner">Propietario</label>
                                            </div>
                                            <div class="form-check" style="padding-left: 0px;">
                                              <input <?php if($details['owner'] == 0) echo "checked";?> class="radiobutton" type="radio" name="owner" id="doctor" value="0" <?php if($owner != 1):?> disabled="" <?php endif;?>><label class="radiobutton-label" for="doctor">Doctor</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif;?>
                                <div class="col-sm-<?php if($owner == 1):?>4<?php else:?>6<?php endif;?>">
                                    <div class="form-group">
                                        <label>Género:</label>
                                        <div class="input-group">
                                            <div class="form-check" style="padding-left: 0px; padding-right:1px">
                                              <input <?php if($details['gender'] == 'M') echo "checked";?> class="radiobutton" type="radio" name="gender" id="radio3" value="M" <?php if($owner != 1):?> disabled="" <?php endif;?>><label class="radiobutton-label" for="radio3">Masculino</label>
                                            </div>
                                            <div class="form-check" style="padding-left: 0px;">
                                              <input <?php if($details['gender'] == 'F') echo "checked";?> class="radiobutton" type="radio" name="gender" id="radio4" value="F" <?php if($owner != 1):?> disabled="" <?php endif;?>><label class="radiobutton-label" for="radio4">Femenino</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Dirección</label>
                                        <textarea type="text" style="border: 1px solid #198cff8f;" rows="3" name="address" class="form-control" <?php if($owner != 1):?> readonly="" <?php endif;?>><?php echo $details['address'];?></textarea>
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
                                                            <input type="checkbox" id="invc" name="Facebook" value="1" <?php if($details['facebook'] != '') echo "checked";?> class="custom-control-input check" <?php if($owner != 1):?> disabled="" <?php endif;?>>
                                                            <label class="custom-control-label" for="invc">Facebook</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12"  id="fb" <?php if($details['facebook'] == ''):?>style="display:none;"<?php endif;?> >
                                                <div class="form-group m-b-15">
                                                   <label for="simpleinput">Ingrese link de Facebook</label>
                                                    <div class="form-group">
                                                        <input style="border: 1px solid #198cff8f;" type="text" name="link_facebook" value="<?php echo $details['facebook'];?>" class="form-control" <?php if($owner != 1):?> readonly="" <?php endif;?>>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="col-sm-12">
                                                <div class="form-group m-b-15">
                                                    <div class="form-group">
                                                        <div class="custom-control custom-checkbox mr-sm-2">
                                                            <input style="border: 1px solid #198cff8f;" type="checkbox" id="invc3" name="Instagram" value="1" <?php if($details['instagram'] != '') echo "checked";?> class="custom-control-input check" <?php if($owner != 1):?> disabled="" <?php endif;?> >
                                                            <label class="custom-control-label" for="invc3">Instagram</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12"  id="Ig" <?php if($details['instagram'] == ''):?>style="display:none;"<?php endif;?> >
                                                <div class="form-group m-b-15">
                                                   <label for="simpleinput">Ingrese link de Instagram</label>
                                                    <div class="form-group">
                                                        <input style="border: 1px solid #198cff8f;" type="text" name="link_instagram" value="<?php echo $details['instagram'];?>" class="form-control" <?php if($owner != 1):?> readonly="" <?php endif;?> />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="col-sm-12">
                                                <div class="form-group m-b-15">
                                                    <div class="form-group">
                                                        <div class="custom-control custom-checkbox mr-sm-2">
                                                            <input type="checkbox" id="invc2" name="Whatsapp" value="1" class="custom-control-input check" <?php if($details['whatsapp'] == '1') echo "checked";?> <?php if($owner != 1):?> disabled="" <?php endif;?>>
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
                                    <div class="form-group m-b-15">
                                        <button class="btn btn-primary">Aplicar cambios</button>
                                    </div>
                                </div>
                                <?php endif;?>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-4">
                    <br>
                    <h5 class="panel-content-title" style="font-weight:100">Servicios que utilizas para iniciar sesión en Medicaby.</h5>
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
        $('.itemName').select2();
    </script>
    <script src="<?php echo base_url();?>public/assets/back/js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript">      
        document.getElementById('apply').onchange = function () {
           var filename = this.value.replace(/C:\\fakepath\\/i, '')
           $( "#fileResponse" ).html('<b>Archivo seleccionado:</b> '+filename);
        };
        $(function(){
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
        $(function(){
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
<?php  endforeach; ?>