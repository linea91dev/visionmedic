<link rel="stylesheet" href="<?php echo base_url();?>public/assets/telinput/intlTelInput.css">
 
    <div class="white-box"> 
        <div class="os-tabs-w">
            <div class="os-tabs-controls">
                <ul class="navx nav-tabs">
                    <li class="nav-item text-center">
                        <a class="nav-link current" href="<?php echo base_url();?>staff/settings/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0049_settings_panel_equalizer_preferences"></i></div> <span>Configuración</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>staff/forms/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0064_bullet_list_view"></i></div> <span>Formularios</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>staff/clinics/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0047_home_flat"></i></div> <span>Sucursales</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>staff/services/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0813_heart_vitals_pulse_rate_health"></i></div> <span>Servicios</span>
                        </a>
                    </li>
                    <?php 
                    $odonto = $this->db->get_where('clinic', array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->odonto;
                    if($odonto != ''):
                
                        ?>
                        <li class="nav-item text-center">
                            <a class="nav-link" href="<?php echo base_url();?>staff/thooth_procedures/">
                                <div class="navWidget"><i class="picons-thin-icon-thin-0826_teeth_tooth_dental"></i></div> <span>Procedimientos</span>
                            </a>
                        </li>
                    <?php endif;?>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>staff/specialties/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0825_stetoscope_doctor_hospital_ill"></i></div><span>Especialidades</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>staff/laboratories/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0817_tube_laboratory_chemistry"></i></div><span>Laboratorios</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>staff/surveys/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0065_bullet_list_view"></i></div><span>Encuestas</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="main-content">
        <form id="target" action="<?php echo base_url();?>staff/settings/apply" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
				        <div class="card-box">
		                    <div class="card-h">
		                        <h5 class="card-caption">Configura tu aplicación</h5>
		                    </div>
		                    <div class="card-b">
		                        <div class="row">
		                            <div class="col-lg-6">
		                                <label>Elige un color para tu clínica</label>
		                                <div class="picker"></div>
		                                <input type="hidden" id="theme" name="theme">
		                                <hr>
		                                <div class="middless">
                                            <label>
                                                <input type="radio" name="radio" onclick="dataModule()"/>
                                                <div class="download box">
                                                    <span>Descarga <p style="margin-top:-4px;font-size: 15px;font-weight:500;color:#707d94;">tu información.</p></span>
                                                </div>
                                            </label>
                                            <label>
                                                <input type="radio" name="radio" onclick="close_sessions()"/>
                                                <div class="session box">
                                                    <span>Cierra todas <p style="margin-top:-4px;font-size: 15px;font-weight:500;color:#707d94;">tus sesiones.</p></span>
                                                </div>
                                            </label>
                                        </div>
		                                <div>
		                                    <div class="col-lg-12" id="modules" style="display:none;"><br>
		                                        <p style="text-align:justify;font-size:13px;">
		                                            Puedes descargar una copia de tu información de <b>Medicaby</b> cuando quieras. Tienes la opición de descargarla en su totalidad o seleccionar solo los tipos de datos que te interesen. 
		                                            Toda tu información será entregada en formato <b>.xlsx</b> y <b>.zip</b>
		                                        </p>
                                                <p style="text-align:justify;font-size:13px;">
                                                    Tu información se generará en los próximos 7 días hábiles.
                                                </p>
        		                                <div class="custom-control custom-switch">
        		                                    <input type="checkbox" name="mod_appointments" value="0" class="custom-control-input" id="mod_appointments">
        		                                    <label class="custom-control-label" for="mod_appointments">Descargar informacion de tus citas.</label>
        		                                </div>
        		                                <div class="custom-control custom-switch">
        		                                    <input type="checkbox" name="mod_patients" value="0" class="custom-control-input" id="mod_patients">
        		                                    <label class="custom-control-label" for="mod_patients">Descargar informacion de los pacientes.</label>
        		                                </div>
        		                                <div class="custom-control custom-switch">
        		                                    <input type="checkbox" name="mod_doctors" value="0" class="custom-control-input" id="mod_doctors" >
        		                                    <label class="custom-control-label" for="mod_doctors">Descargar informacion de los doctores.</label>
        		                                </div>
                                                <div class="custom-control custom-switch">
        		                                    <input type="checkbox" name="mod_staff" value="0" class="custom-control-input" id="mod_staff" >
        		                                    <label class="custom-control-label" for="mod_staff">Descargar informacion del Staff.</label>
        		                                </div>
        		                                <div class="custom-control custom-switch">
        		                                    <input type="checkbox" name="mod_ingresos" value="0" class="custom-control-input" id="mod_ingresos" >
        		                                    <label class="custom-control-label" for="mod_ingresos">Descargar informacion de los ingresos.</label>
        		                                </div>
        		                                <div class="custom-control custom-switch">
        		                                    <input type="checkbox" name="mod_egresos" value="0" class="custom-control-input" id="mod_egresos" >
        		                                    <label class="custom-control-label" for="mod_egresos">Descargar informacion de los egresos.</label>
        		                                </div>
                        		                <div class="col-sm-6"><hr>
                		                            <a  onclick="downloadData()" class="btn btn-primary"><i class="picons-thin-icon-thin-0315_email_mail_post_send"></i> Enviar solicitud</a>
                		                        </div>
        		                            </div>
		                                </div>
		                                <hr>
		                                <span>Sube tu logotipo:</span>
                                        <div class="avatar-upload">
                                            <div class="avatar-edit">
                                                <input type='file' name="logo" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                                <label for="imageUpload"></label>
                                            </div>
                                            <div class="avatar-preview">
                                                <?php if($this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->logo != ''):?>
                                                <div id="imagePreview" style="background-image: url(<?php echo base_url();?>public/uploads/<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->logo;?>);"></div>
                                                <?php else:?>
                                                <div id="imagePreview" style="background-image: url(<?php echo base_url();?>public/uploads/user.png);"></div>
                                                <?php endif;?>  
                                            </div>
                                        </div>
                                        <hr>
		                            </div> 
		                            <div class="col-lg-6">
		                                <div class="custom-control custom-switch">
		                                    <input type="checkbox" name="send_survey" value="1" class="custom-control-input" id="send_survey_check" <?php if($this->crud_model->check_item('send_survey') == 1) echo "checked";?>>
		                                    <label class="custom-control-label" for="send_survey_check">Enviar encuesta al paciente al finalizar cita.</label>
		                                </div>
		                                <div class="form-group" id="send_survey">
                                            <label for="">¿Qué encuesta enviaremos?</label>
                                            <select class="itemName form-control" style="width:100%" name="survey_id" id="survey_id">
							                    <option value="">Seleccionar</option>
							                    <?php
							                    $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
									            $surveys = $this->db->get('survey')->result_array();
									            foreach($surveys as $surv):?>
						                        <option value="<?php echo $surv['survey_id'];?>" <?php if($surv['survey_id'] == $this->crud_model->check_item('survey_id')) echo "selected";?> ><?php echo $surv['title'];?></option>
						                        <?php endforeach;?>
							                </select>
                                        </div>
		                                <div class="custom-control custom-switch">
		                                    <input type="checkbox" name="send_schedule" value="1" class="custom-control-input" id="send_schedule_check" <?php if($this->crud_model->check_item('send_schedule') == 1) echo "checked";?>>
		                                    <label class="custom-control-label" for="send_schedule_check">Enviar Agenda diaria al correo.</label>
		                                </div>
		                                <div class="form-group" id="send_schedule">
                                            <label for="">¿En qué horario quieres recibirla?</label>
                                            <div class="input-group clockpicker" data-align="top" data-autoclose="true">
                                                <div class="input-group date timepicker" id="horainicio" data-target-input="nearest">
								                    <input type="text" name="hour" class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#horainicio" id="hour" value="<?php if($this->crud_model->check_item('hour') == "") echo date('H:i'); else echo $this->crud_model->check_item('hour');  ?>">
								                </div>
                                            </div>
                                        </div>
		                                <div class="custom-control custom-switch">
		                                    <input type="checkbox" name="send_reminder" value="1" class="custom-control-input" id="send_reminder_check" <?php if($this->crud_model->check_item('send_reminder') == 1) echo "checked";?>>
		                                    <label class="custom-control-label" for="send_reminder_check">Enviar recordatorios de citas a pacientes.</label>
		                                </div>
		                                <div class="form-group" id="send_reminder">
                                            <label for="">¿En qué momento?</label>
                                            <select class="itemName form-control" style="width:100%" name="reminder" id="reminder">
							                    <option value="">Seleccionar</option>
						                        <option value="1" <?php if(1 == $this->crud_model->check_item('reminder')) echo "selected";?>>1 hora antes.</option>
						                        <option value="2" <?php if(2 == $this->crud_model->check_item('reminder')) echo "selected";?>>2 horas antes.</option>
						                        <option value="3" <?php if(3 == $this->crud_model->check_item('reminder')) echo "selected";?>>3 horas antes.</option>
						                        <option value="4" <?php if(4 == $this->crud_model->check_item('reminder')) echo "selected";?>>1 día antes.</option>
							                </select>
                                        </div>
                                        <div class="custom-control custom-switch">
		                                    <input type="checkbox" name="product_module" value="1" class="custom-control-input" id="product_module_check" <?php if($this->crud_model->check_item('product_module') == 1) echo "checked";?>>
		                                    <label class="custom-control-label" for="product_module_check">Activar módulo de productos.</label>
		                                </div>
		                                <br>
		                                <div class="form-group">
		                                    <label class="form-control-label">Moneda</label>
		                                    <select class="itemName form-control" style="width:100%" name="currency" id="currency">
						                        <option value="Q" <?php $mon = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency; if($mon == 'Q') echo "selected";?>>Guatemala.</option>
						                        <option value="MXN$"  <?php if($mon == 'MXN$') echo "selected";?>>México.</option>
						                        <option value="L"  <?php if($mon == 'L') echo "selected";?>>Honduras.</option>
						                        <option value="RD$"  <?php if($mon == 'RD$') echo "selected";?>>Republica Dominicana.</option>
                                                <option value="US$"  <?php if($mon == 'US$') echo "selected";?>>USA.</option>
                                                <option value="€"  <?php if($mon == '€') echo "selected";?>>España.</option>
                                                <option value="AR$"  <?php if($mon == 'AR$') echo "selected";?>>Argentina.</option>
							                </select>
		                                </div>
                                        <div class="form-group">
		                                    <label class="form-control-label">Mensaje de confirmación</label><br>
                                            <small>Si quieres alguno de los siguientes datos debes colocar el mensaje predeterminado.</small>
                                            <ul>
                                                <li>Nombre del doctor: [DOCTOR]</li>
                                                <li>Nombre del paciente: [PACIENTE]</li>
                                                <li>Hora de la cita: [HORA]</li>
                                                <li>Fecha de la cita: [FECHA]</li>
                                            </ul>
		                                     <textarea type="text" name="sms_confirm" class="form-control" id="mensaje" maxlength="150" rows="3"><?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->sms_confirm;?></textarea>
                                             <div id="contador">0/150</div>
		                                </div>
		                            </div>
		                            <div class="col-sm-12">
		                                <button type="submit" class="btn btn-success"><i class="picons-thin-icon-thin-0154_ok_successful_check"></i> Aplicar cambios</button>
		                            </div>
		                        </div>
		                    </div> 
		            </div>     
			    </div>
		    </div>
		</form>
	</div>
 
    <script src="<?php echo base_url();?>public/assets/back/js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/back/js/colorPick.js"></script>
	<script src="<?php echo base_url();?>public/assets/back/js/moment.min.js"></script>
	<script src="<?php echo base_url();?>public/assets/back/js/tempusdominus-bootstrap-4.js"></script>
	<script src="<?php echo base_url();?>public/assets/back/js/timepicker.js"></script>
	<script src="<?php echo base_url();?>public/assets/back/js/settings.js"></script>
    <script src="https://cdn.rawgit.com/leodido/i18n.phonenumbers.js/master/dist/i18n.phonenumbers.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/telinput/prism.js"></script>
    <script src="<?php echo base_url();?>public/assets/telinput/intlTelInput.js"></script>
    <script src="<?php echo base_url();?>public/assets/telinput/hiddenInput.js"></script>
    <script src="<?php echo base_url();?>public/assets/telinput/utils.js"></script>
    <script type="text/javascript">
    /*              // update the hidden input on submi
    $( "#target" ).submit(function( event ) {
    
    var number = iti.getExtension();
        alert(number);
        event.preventDefault();
    
        return true;
        });
*/
    const mensaje = document.getElementById('mensaje');
    const contador = document.getElementById('contador');
    mensaje.addEventListener('input', function(e) {
        const target = e.target;
        const longitudMax = target.getAttribute('maxlength');
        const longitudAct = target.value.length;
        contador.innerHTML = `${longitudAct}/${longitudMax}`;
    });


    $(function()
    {

        const longitudAct = mensaje.value.length;
        contador.innerHTML = `${longitudAct}/150`;
        <?php if($this->crud_model->check_item('send_survey') == 0):?>
            $("#send_survey").hide();
        <?php endif;?>
        <?php if($this->crud_model->check_item('send_schedule') == 0):?>
            $("#send_schedule").hide();
        <?php endif;?>
        <?php if($this->crud_model->check_item('send_reminder') == 0):?>
            $("#send_reminder").hide();
        <?php endif;?>
    });
  </script>