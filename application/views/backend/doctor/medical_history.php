<?php 
    $patient_id = base64_decode($id_);
    $this->db->where('patient_id', $patient_id);
    $info = $this->db->get('patient')->result_array();    
    foreach($info as $details):
?>
<div class="todo-app-w" style="margin-bottom:10%">
    <div class="todo-content">
        <h4 class="todo-content-header">
            <i class="batch-icon-arrow-right"></i><span>Historial médico -
                <?php echo $this->accounts_model->get_name('patient',$details['patient_id']);?></span>
        </h4>
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-info">
                    <span class="alert-title"><i class="batch-icon-spam"></i> Historial del paciente.</span>
                    <span class="alert-content">En esta sección podrás llevar el control clínico de tu paciente como
                        signos vitales, antecendentes médicos e historial de <span class="alert-lined"><a
                                href="javascript:void(0);" style="color:#0044e9">medicamentos</a>.</span></span>
                </div>
            </div>
            <div class="col-sm-12">
                <a href="<?php echo base_url();?>doctor/patient_profile/<?php echo base64_encode($patient_id);?>"
                    class="btn btn-info"><i class="picons-thin-icon-thin-0132_arrow_back_left"></i> Regresar</a><br><br>
            </div>
            <div class="col-sm-3">
                <div id="antecedentes">
                    <div class="card-widget">
                        <h5 class="panel-content-title">Últimos signos vitales</h5>
                        <span class="app-divider2"></span>
                        <div class="card-b">
                            <?php
					        $signs = $this->crud_model->medical_history($patient_id);
                            if(count($signs) > 0):
            			        foreach($signs as $row):
						       ?>
                           
                            <div class="form-group">
                                <i class="picons-thin-icon-thin-0263_text_font_typography" style="font-size:25px;"></i>
                                <span style="vertical-align: 4px;">Estatura:</span> <span
                                    style="float:right;"><?php echo $row['t']; ?> cm</span>
                            </div>
                            <hr>
                           
    					
                            <div class="form-group">
                                <i class="picons-thin-icon-thin-0827_body_weight_fitness_health_fat"
                                    style="font-size:25px"></i> <span style="vertical-align: 4px;">Peso:</span> <span
                                    style="float:right;"><?php echo $row['w'];?> Kg</span>
                            </div>
                            <hr>
                           
                          
                            <div class="form-group">
                                <i class="picons-thin-icon-thin-0720_user_location_position" style="font-size:25px"></i>
                                <span style="vertical-align: 4px;">Masa corporal:</span> <span
                                    style="float:right;"><?php echo $row['imc'];?></span>
                            </div>
                            <hr>
                            
                            <div class="form-group">
                                <i class="picons-thin-icon-thin-0824_fever_body_temperature_ill"
                                    style="font-size:25px"></i> <span style="vertical-align: 4px;">Temperatura:</span>
                                <span style="float:right;"><?php echo $row['temp'];?> °C</span>
                            </div>
                            <hr>
                            
                            <div class="form-group">
                                <i class="picons-thin-icon-thin-0810_heart_pulse_rate_health"
                                    style="font-size:25px"></i> <span style="vertical-align: 4px;">Frecuencia
                                    respiratoria:</span> <span style="float:right;"><?php echo $row['fr'];?>
                                    r/m</span>
                            </div>
                            <hr>
                            <div class="form-group">
                                <i class="picons-thin-icon-thin-0810_heart_pulse_rate_health" style="font-size:25px"></i> 
                                <span style="vertical-align: 4px;">Presion Arterial:</span> <span style="float:right;"><?php echo $row['fr'];?> </span>
                            </div>
                            <hr>
                            <div class="form-group">
                                <i class="picons-thin-icon-thin-0813_heart_vitals_pulse_rate_health"
                                    style="font-size:25px"></i> <span style="vertical-align: 4px;">Frecuencia
                                    cardiaca:</span> <span style="float:right;"><?php echo $row['fc'];?> bpm</span>
                            </div>
                            <hr>
                            
                            <div class="form-group">
                                <i class="picons-thin-icon-thin-0815_lungs_breathing" style="font-size:25px"></i> <span
                                    style="vertical-align: 4px;">Saturación de Oxígeno:</span> <span
                                    style="float:right;"><?php echo $row['so2']; ?></span>
                            </div>
                            
                            <?php endforeach; ?>
                            <?php else:?>
                            <br>
                            <center>
                                <img alt="Signos vitales" src="<?php echo base_url();?>public/uploads/signosvitales.svg"
                                    style="width:160px">
                            </center>
                            <br>
                            <center>Aún no se han registrado datos.</center><br>
                            <?php endif;  
					            ?>
						       
                        </div>
                    </div>
                </div>
            </div>
            <link rel="stylesheet"
                href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/fontawesome.min.css"
                integrity="sha256-mM6GZq066j2vkC2ojeFbLCcjVzpsrzyMVUnRnEQ5lGw=" crossorigin="anonymous" />
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/regular.min.css"
                integrity="sha256-Pd28JXamAUfl4NS9QzGAdbaqdPQGG9dKLj3caGj28fg=" crossorigin="anonymous" />
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/solid.min.css"
                integrity="sha256-APTxfVyJgjHUS35EeuRpYs2tAbIQO7UF0nAV6krdYJ0=" crossorigin="anonymous" />
            <div class="col-sm-6">
                <div class="card-widget">
                    <h5 class="panel-content-title">Antecedentes</h5>
                    <span class="app-divider2"></span>
                    <div class="card-b">
                        <div class="col-sm-12">
                            <div class="ant-tile ant-tile-inlined">
                                <a class="ant-tile-box faded" href="javascript:void(0);"
                                    onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_allergies/<?php echo $patient_id;?>');">
                                    <div class="pt-new-icon">
                                        <i class="os-icon picons-thin-icon-thin-0151_plus_add_new"></i>
                                    </div>
                                </a>
                                <span
                                    style="margin-left:10px; font-weight:600;color:#047bf8;font-size:13px;    text-transform: uppercase;">Alergias</span>
                            </div>

                            <ul
                                style="margin-top:-15px;margin-bottom:15px;border-bottom: 1px solid rgba(0, 0, 0, 0.1);list-style:none">
                                <?php 
        			            $this->db->order_by('allergie_id', 'desc');
        			            $this->db->where('patient_id',$patient_id);
        			            $allergies = $this->db->get('allergie')->result_array();
        			            foreach($allergies as $row):
        			            ?>
                                <li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i>
                                    <?php echo $row['name'];?><a href="javascript:void(0):"
                                        onclick="delete_allergie('<?php echo $row['allergie_id'];?>')"><i
                                            style="float:right;"
                                            class="picons-thin-icon-thin-0057_bin_trash_recycle_delete_garbage_full"></i></a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php if($this->crud_model->check_item('pathological') == 1) { ?>
                        <div class="col-sm-12">
                            <div class="ant-tile ant-tile-inlined">
                                <a class="ant-tile-box faded" href="javascript:void(0);"
                                    onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_pathological_list/<?php echo $patient_id;?>');">
                                    <div class="pt-new-icon">
                                        <i class="os-icon picons-thin-icon-thin-0151_plus_add_new"></i>
                                    </div>
                                </a>
                                <span
                                    style="margin-left:10px; font-weight:600;color:#047bf8;font-size:13px;    text-transform: uppercase;">Antecedentes
                                    patológicos</span>
                            </div>
                            <ul
                                style="margin-top:-15px;margin-bottom:15px;border-bottom: 1px solid rgba(0, 0, 0, 0.1);list-style:none">
                                <?php 
        			            $this->db->order_by('date', 'desc');
        			            $this->db->where('patient_id',$patient_id);
        			            $pathologicals = $this->db->get('pathological')->result_array();
        			            foreach($pathologicals as $row):
        			            ?>
                                <?php if($row['hospitalization'] == 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Hospitalización previa |</b>
                                    <?php echo ucfirst($row['hospitalization_comment']);?><?php endif;?>
                                    <?php if($row['surgeries'] == 1): ?>
                                <li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Cirugías
                                        previas |</b> <?php echo ucfirst($row['surgeries_comment']);?></li>
                                <?php endif; ?>
                                <?php if($row['diabetes'] == 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b>Diabetes |</b>
                                    <?php echo ucfirst($row['diabetes_comment']);?></li><?php endif; ?>
                                <?php if($row['thyroid'] == 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b>Enfermedades tiroideas
                                        |</b><?php echo ucfirst($row['thyroid_comment']);?></li><?php endif; ?>
                                <?php if($row['hypertension'] == 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b>Hipertensión arterial
                                        |</b><?php echo ucfirst($row['hypertension_comment']);?></li><?php endif; ?>
                                <?php if($row['heart_disease'] == 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b>Cardiopatias
                                        |</b><?php echo ucfirst($row['heart_disease_comment']);?></li><?php endif; ?>
                                <?php if($row['trauma'] == 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b>Traumatismos
                                        |</b><?php echo ucfirst($row['trauma_comment']);?></li><?php endif; ?>
                                <?php if($row['cancer'] == 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b>Cáncer
                                        |</b><?php echo ucfirst($row['cancer_comment']);?></li><?php endif; ?>
                                <?php if($row['tuberculosis'] == 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b>Tuberculosis
                                        |</b><?php echo ucfirst($row['tuberculosis_comment']);?></li><?php endif; ?>
                                <?php if($row['transfusions'] == 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b>Transfusiones
                                        |</b><?php echo ucfirst($row['transfusions_comment']);?></li><?php endif; ?>
                                <?php if($row['pathologies'] == 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b>Patologías respiratorias
                                        |</b><?php echo ucfirst($row['pathologies_comment']);?></li><?php endif; ?>
                                <?php if($row['gastrointestinal'] == 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b>Patologías gastrointestinales
                                        |</b><?php echo ucfirst($row['gastrointestinal_comment']);?></li><?php endif; ?>
                                <?php if($row['sexual'] == 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b>Enfermedades de transmisión sexual
                                        |</b><?php echo ucfirst($row['sexual_comment']);?></li><?php endif; ?>
                                <?php if($row['others'] == 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b>Otros
                                        |</b><?php echo ucfirst($row['others_comment']);?></li><?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div><?php }
                        if($this->crud_model->check_item('non_pathological') == 1) {
                        ?>
                        <div class="col-sm-12">
                            <div class="ant-tile ant-tile-inlined">
                                <a class="ant-tile-box faded" href="javascript:void(0);"
                                    onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_no_pathological_list/<?php echo $patient_id;?>');">
                                    <div class="pt-new-icon">
                                        <i class="os-icon picons-thin-icon-thin-0151_plus_add_new"></i>
                                    </div>
                                </a>
                                <span
                                    style="margin-left:10px; font-weight:600;color:#047bf8;font-size:13px;    text-transform: uppercase;">Antecedentes
                                    no patológicos</span>
                            </div>
                            <ul
                                style="margin-top:-15px;margin-bottom:15px;border-bottom: 1px solid rgba(0, 0, 0, 0.1);list-style:none">
                                <?php 
        			                $this->db->order_by('date', 'desc');
        			                $this->db->where('patient_id', $patient_id);
        			                $no_pathologicals = $this->db->get('no_pathological')->result_array();
        			                foreach($no_pathologicals as $row):
        			            ?>
                                <?php if($row['activity'] == 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Actividad física |
                                    </b><?php echo ucfirst($row['activity_comment']);?></li> <?php endif; ?>
                                <?php if($row['smoking'] == 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b>Tabaquismo |
                                    </b><?php echo ucfirst($row['smoking_comment']);?></li><?php endif; ?>
                                <?php if($row['alcoholism'] == 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b>Alcoholismo |
                                    </b><?php echo ucfirst($row['alcoholism_comment']);?></li><?php endif; ?>
                                <?php if($row['drugs'] == 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b>Uso de otras sustancias (Drogas) |
                                    </b><?php echo ucfirst($row['drugs_comment']);?></li><?php endif; ?>
                                <?php if($row['vaccine'] == 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b>Vacuna o inmunización reciente |
                                    </b><?php echo ucfirst($row['vaccine_comment']);?></li><?php endif; ?>
                                <?php if($row['others'] == 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b>Otros |
                                    </b><?php echo ucfirst($row['others_comment']);?></li><?php endif; ?>

                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php }
                        if($this->crud_model->check_item('hereditary') == 1) {
                        ?>
                        <div class="col-sm-12">
                            <div class="ant-tile ant-tile-inlined">
                                <a class="ant-tile-box faded" href="javascript:void(0);"
                                    onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_record_family_list/<?php echo $patient_id;?>');">
                                    <div class="pt-new-icon">
                                        <i class="os-icon picons-thin-icon-thin-0151_plus_add_new"></i>
                                    </div>
                                </a>
                                <span
                                    style="margin-left:10px; font-weight:600;color:#047bf8;font-size:13px;    text-transform: uppercase;">Antecedentes
                                    heredofamiliares</span>
                            </div>
                            <ul
                                style="margin-top:-15px;margin-bottom:15px;border-bottom: 1px solid rgba(0, 0, 0, 0.1);list-style:none">
                                <?php 
        			                $this->db->order_by('date', 'desc');
        			                $this->db->where('patient_id',$patient_id);
        			                $heredos = $this->db->get('record_family')->result_array();
        			                foreach($heredos as $row):
        			            ?>
                                <?php if($row['diabetes'] == 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Diabetes |
                                    </b><?php echo ucfirst($row['diabetes_comment']);?></li> <?php endif; ?>
                                <?php if($row['heart_disease'] == 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Cardiopatías |
                                    </b><?php echo ucfirst($row['heart_disease_comment']);?></li> <?php endif; ?>
                                <?php if($row['hypertension'] == 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Hipertensión arterial |
                                    </b><?php echo ucfirst($row['hypertension_comment']);?></li> <?php endif; ?>
                                <?php if($row['thyroid'] == 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Enfermedades tiroideas |
                                    </b><?php echo ucfirst($row['thyroid_comment']);?></li> <?php endif; ?>
                                <?php if($row['others'] == 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Otros |
                                    </b><?php echo ucfirst($row['others_comment']);?></li> <?php endif; ?>
                                <?php endforeach; ?>

                            </ul>
                        </div>
                        <?php }
                        if($this->crud_model->check_item('psychiatric') == 1) {
                        ?>
                        <div class="col-sm-12">
                            <div class="ant-tile ant-tile-inlined">
                                <a class="ant-tile-box faded" href="javascript:void(0);"
                                    onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_psychiatric_list/<?php echo $patient_id;?>');">
                                    <div class="pt-new-icon">
                                        <i class="os-icon picons-thin-icon-thin-0151_plus_add_new"></i>
                                    </div>
                                </a>
                                <span
                                    style="margin-left:10px; font-weight:600;color:#047bf8;font-size:13px;    text-transform: uppercase;">Antecedentes
                                    psiquiátricos</span>
                            </div>
                            <ul
                                style="margin-top:-15px;margin-bottom:15px;border-bottom: 1px solid rgba(0, 0, 0, 0.1);list-style:none">
                                <?php 
        			                $this->db->order_by('date', 'desc');
        			                $this->db->where('patient_id',$patient_id);
        			                $phys = $this->db->get('psychiatric')->result_array();
        			                foreach($phys as $row):
        			            ?>
                                <?php if($row['family_record']!= ""): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Historia familiar |
                                    </b><?php echo ucfirst($row['family_record']);?></li> <?php endif; ?>
                                <?php if($row['disease_awareness'] == 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Conciencia de enfermedad |
                                    </b><?php echo ucfirst($row['disease_awareness_comment']);?></li> <?php endif; ?>
                                <?php if($row['affected_areas'] != ""): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Áreas afectadas por la enfermedad
                                        | </b><?php echo ucfirst($row['affected_areas']);?></li> <?php endif; ?>
                                <?php if($row['past_treatments'] != ""): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Tratamientos pasados y actuales |
                                    </b><?php echo ucfirst($row['past_treatments']);?></li> <?php endif; ?>
                                <?php if($row['family_group_social'] == 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Apoyo del grupo familiar o social
                                        | </b><?php echo ucfirst($row['family_group_social_comment']);?></li>
                                <?php endif; ?>
                                <?php if($row['family_group'] != ""): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Grupo familiar del paciente |
                                    </b><?php echo ucfirst($row['family_group']);?></li> <?php endif; ?>
                                <?php if($row['aspects_social'] != ""): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Aspectos de la vida social |
                                    </b><?php echo ucfirst($row['aspects_social']);?></li> <?php endif; ?>
                                <?php if($row['aspects_work'] != ""): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Aspectos de la vida laboral |
                                    </b><?php echo ucfirst($row['aspects_work']);?></li> <?php endif; ?>
                                <?php if($row['authority'] != ""): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Relación con la autoridad |
                                    </b><?php echo ucfirst($row['authority']);?></li> <?php endif; ?>
                                <?php if($row['impulse_control'] != ""): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Control de impulsos |
                                    </b><?php echo ucfirst($row['impulse_control']);?></li> <?php endif; ?>
                                <?php if($row['frustration'] != ""): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Manejo de frustración en su vida |
                                    </b><?php echo ucfirst($row['frustration']);?></li> <?php endif; ?>


                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php }
                        if($this->crud_model->check_item('vaccination') == 1) {
                        ?>
                        <div class="col-sm-12">
                            <div class="ant-tile ant-tile-inlined">
                                <a class="ant-tile-box faded" href="javascript:void(0);"
                                    onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_vaccination_list/<?php echo $patient_id;?>');">
                                    <div class="pt-new-icon">
                                        <i class="os-icon picons-thin-icon-thin-0151_plus_add_new"></i>
                                    </div>
                                </a>
                                <span
                                    style="margin-left:10px; font-weight:600;color:#047bf8;font-size:13px;    text-transform: uppercase;">Esquema
                                    de vacunación</span>
                            </div>
                            <ul
                                style="margin-top:-15px;margin-bottom:15px;border-bottom: 1px solid rgba(0, 0, 0, 0.1);list-style:none">
                                <?php 
        			                $this->db->where('patient_id',$patient_id);
        			                $vacc = $this->db->get('vaccination')->result_array();
        			                if(count($vacc)>0){
        			                foreach($vacc as $row):
        			            ?>
                                <li><b>Nacimiento</b></li>
                                <li><?php  if($row['bcg'] == 1){ ?><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <?php } else { ?><i
                                        class="fas fa-close" style="color:#d8000c"></i> <?php } ?> BCG</li>
                                <li><?php  if($row['hepatitis_b_1'] == 1){ ?><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <?php } else { ?><i
                                        class="fas fa-close" style="color:#d8000c"></i> <?php } ?> 1a. Hepatitis B </li>
                                <hr>
                                <li><b>2 meses</b></li>
                                <li><?php  if($row['pentavalente_acelular_1'] == 1){ ?><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <?php } else { ?><i
                                        class="fas fa-close" style="color:#d8000c"></i> <?php } ?> 1a. Pentavalente
                                    Acelular</li>
                                <li><?php  if($row['hepatitis_b_2'] == 1){ ?><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <?php } else { ?><i
                                        class="fas fa-close" style="color:#d8000c"></i> <?php } ?> 2a. Hepatitis B</li>
                                <li><?php  if($row['rotavirus_1'] == 1){ ?><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <?php } else { ?><i
                                        class="fas fa-close" style="color:#d8000c"></i> <?php } ?> 1a. Rotavirus</li>
                                <li><?php  if($row['neumococo_1'] == 1){ ?><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <?php } else { ?><i
                                        class="fas fa-close" style="color:#d8000c"></i> <?php } ?> 1a. Neumococo</li>
                                <hr>
                                <li><b>4 meses</b></li>
                                <li><?php  if($row['pentavalente_acelular_2'] == 1){ ?><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <?php } else { ?><i
                                        class="fas fa-close" style="color:#d8000c"></i> <?php } ?> 2a. Pentavalente
                                    Acelular</li>
                                <li><?php  if($row['rotavirus_2'] == 1){ ?><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <?php } else { ?><i
                                        class="fas fa-close" style="color:#d8000c"></i> <?php } ?> 2a. Rotavirus</li>
                                <li><?php  if($row['neumococo_2'] == 1){ ?><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <?php } else { ?><i
                                        class="fas fa-close" style="color:#d8000c"></i> <?php } ?> 2a. Neumococo</li>
                                <hr>
                                <li><b>6 meses</b></li>
                                <li><?php  if($row['pentavalente_acelular_3'] == 1){ ?><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <?php } else { ?><i
                                        class="fas fa-close" style="color:#d8000c"></i> <?php } ?> 3a. Pentavalente
                                    Acelular</li>
                                <li><?php  if($row['hepatitis_b_3'] == 1){ ?><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <?php } else { ?><i
                                        class="fas fa-close" style="color:#d8000c"></i> <?php } ?> 3a. Hepatitis B</li>
                                <li><?php  if($row['rotavirus_3'] == 1){ ?><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <?php } else { ?><i
                                        class="fas fa-close" style="color:#d8000c"></i> <?php } ?> 3a. Rotavirus</li>
                                <li><?php  if($row['anti_influenza_1'] == 1){ ?><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <?php } else { ?><i
                                        class="fas fa-close" style="color:#d8000c"></i> <?php } ?> 1a. Anti Influenza
                                    (en temporada de frio)</li>
                                <hr>
                                <li><b>7 meses</b></li>
                                <li><?php  if($row['anti_influenza_2'] == 1){ ?><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <?php } else { ?><i
                                        class="fas fa-close" style="color:#d8000c"></i> <?php } ?> 2a. Anti Influenza
                                    (en temporada de frio)</li>
                                <hr>
                                <li><b>12 meses</b></li>
                                <li><?php  if($row['srp_1'] == 1){ ?><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <?php } else { ?><i
                                        class="fas fa-close" style="color:#d8000c"></i> <?php } ?> 1a. SRP</li>
                                <li><?php  if($row['neumococo_3'] == 1){ ?><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <?php } else { ?><i
                                        class="fas fa-close" style="color:#d8000c"></i> <?php } ?> 3a. Neumococo</li>
                                <hr>
                                <li><b>18 meses</b></li>
                                <li><?php  if($row['pentavalente_acelular_4'] == 1){ ?><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <?php } else { ?><i
                                        class="fas fa-close" style="color:#d8000c"></i> <?php } ?> 4a. Pentavalente
                                    Acelular</li>
                                <hr>
                                <li><b>2 años</b></li>
                                <li><?php  if($row['influenza_refuerzo_anual_2a'] == 1){ ?><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <?php } else { ?><i
                                        class="fas fa-close" style="color:#d8000c"></i> <?php } ?> Influenza Refuerzo
                                    Anual (oct-ene)</li>
                                <hr>
                                <li><b>3 años</b></li>
                                <li><?php  if($row['influenza_refuerzo_anual_3a'] == 1){ ?><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <?php } else { ?><i
                                        class="fas fa-close" style="color:#d8000c"></i> <?php } ?> Influenza Refuerzo
                                    Anual (oct-ene)</li>
                                <hr>
                                <li><b>4 años</b></li>
                                <li><?php  if($row['dpt'] == 1){ ?><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <?php } else { ?><i
                                        class="fas fa-close" style="color:#d8000c"></i> <?php } ?> DPT</li>
                                <li><?php  if($row['influenza_refuerzo_anual_4a'] == 1){ ?><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <?php } else { ?><i
                                        class="fas fa-close" style="color:#d8000c"></i> <?php } ?> Influenza Refuerzo
                                    Anual (oct-ene)</li>
                                <hr>
                                <li><b>5 años</b></li>
                                <li><?php  if($row['influenza_refuerzo_anual_5a'] == 1){ ?><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <?php } else { ?><i
                                        class="fas fa-close" style="color:#d8000c"></i> <?php } ?> Influenza Refuerzo
                                    Anual (oct-ene)</li>
                                <li><?php  if($row['vop'] == 1){ ?><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <?php } else { ?><i
                                        class="fas fa-close" style="color:#d8000c"></i> <?php } ?> VOP/OPV (Sabin, pollo
                                    oral) en 1a y 2a Semana Nal. de Salud (después de 2 previas de Pentavalente
                                    Acelular)</li>
                                <hr>
                                <li><b>6 años</b></li>
                                <li><?php  if($row['srp_2'] == 1){ ?><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <?php } else { ?><i
                                        class="fas fa-close" style="color:#d8000c"></i> <?php } ?> 2a SRP</li>
                                <hr>
                                <li><b>11 años /5to primaria</b></li>
                                <li><?php  if($row['vph'] == 1){ ?><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <?php } else { ?><i
                                        class="fas fa-close" style="color:#d8000c"></i> <?php } ?> VPH</li>
                                <hr>
                                <?php  if($row['others'] == 1){ ?>
                                <li><b>Otras vacunas</b></li>
                                <li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i><?php echo ucfirst($row['others_comment'])?>
                                </li>
                                <hr>
                                <?php } else { ?><li> </li> <?php } ?>
                                <?php endforeach; }
                                else{ ?><ul> </ul><?php } ?>
                            </ul>
                        </div>
                        <?php }
                        if($this->crud_model->check_item('diet') == 1) {
                        ?>
                        <div class="col-sm-12">
                            <div class="ant-tile ant-tile-inlined">
                                <a class="ant-tile-box faded" href="javascript:void(0);"
                                    onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_nutriological_list/<?php echo $patient_id;?>');">
                                    <div class="pt-new-icon">
                                        <i class="os-icon picons-thin-icon-thin-0151_plus_add_new"></i>
                                    </div>
                                </a>
                                <span
                                    style="margin-left:10px; font-weight:600;color:#047bf8;font-size:13px;    text-transform: uppercase;">Dieta
                                    nutriológica</span>
                            </div>
                            <ul
                                style="margin-top:-15px;margin-bottom:15px;border-bottom: 1px solid rgba(0, 0, 0, 0.1);list-style:none">
                                <?php 
        			                $this->db->where('patient_id',$patient_id);
        			                $nutri = $this->db->get('nutriological')->result_array();
        			                foreach($nutri as $row):
        			            ?>
                                <?php if($row['breakfast']== 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Desayuno |
                                    </b><?php echo ucfirst($row['breakfast_comment']);?></li> <?php endif; ?>
                                <?php if($row['snack']== 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Colación en la mañana |
                                    </b><?php echo ucfirst($row['snack_comment']);?></li> <?php endif; ?>
                                <?php if($row['food']== 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Comida |
                                    </b><?php echo ucfirst($row['food_comment']);?></li> <?php endif; ?>
                                <?php if($row['snack_afternoon']== 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Colación en la tarde |
                                    </b><?php echo ucfirst($row['snack_afternoon_comment']);?></li> <?php endif; ?>
                                <?php if($row['dinner']== 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Cena |
                                    </b><?php echo ucfirst($row['dinner_comment']);?></li> <?php endif; ?>
                                <?php if($row['food_home']== 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Alimentos preparados en casa |
                                    </b><?php echo ucfirst($row['food_home_comment']);?></li> <?php endif; ?>
                                <?php if($row['appetite'] != ""): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Nivel de apetito |
                                    </b><?php if($row['appetite'] == 4) echo "Excesivo"; if($row['appetite'] == 3) echo "Bueno"; if($row['appetite'] == 2) echo "Regular"; if($row['appetite'] == 1) echo "Poco"; if($row['appetite'] == 5) echo "Nulo";?>
                                </li> <?php endif; ?>
                                <?php if($row['hunger_satiety']== 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Presencia de hambre-saciedad |
                                    </b><?php echo ucfirst($row['hunger_satiety_comment']);?></li> <?php endif; ?>
                                <?php if($row['glasses'] != ""): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Vasos de agua al día |
                                    </b><?php if($row['glasses'] == 1) echo "1 ó menos"; if($row['glasses'] == 2) echo "2 a 3"; if($row['glasses'] == 3) echo "4 ó más";?>
                                </li> <?php endif; ?>
                                <?php if($row['food_preferences'] != ""): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Preferencia de alimentos |
                                    </b><?php echo ucfirst($row['food_preferences']);?></li> <?php endif; ?>
                                <?php if($row['food_unrest']== 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Malestares por alimentos |
                                    </b><?php echo ucfirst($row['food_unrest_comment']);?></li> <?php endif; ?>
                                <?php if($row['supplements']== 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Medicamentos, complementos o
                                        suplementos | </b><?php echo ucfirst($row['supplements_comment']);?></li>
                                <?php endif; ?>
                                <?php if($row['carried_out']== 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Otras dietas realizadas |
                                    </b><?php echo ucfirst($row['carried_out_comment']);?></li> <?php endif; ?>
                                <?php if($row['ideal_weight'] != ""): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Peso ideal |
                                    </b><?php echo ucfirst($row['ideal_weight']);?></li> <?php endif; ?>
                                <?php if($row['current_condition']== 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Padecimiento actual relacionado al
                                        peso | </b><?php echo ucfirst($row['current_condition_comment']);?></li>
                                <?php endif; ?>
                                <?php if($row['personal_history']== 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Antecedentes personales
                                        relacionados al peso |
                                    </b><?php echo ucfirst($row['personal_history_comment']);?></li> <?php endif; ?>
                                <?php if($row['consumption']== 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Consumo de líquidos |
                                    </b><?php echo ucfirst($row['consumption_comment']);?></li> <?php endif; ?>
                                <?php if($row['nutrition_education']== 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Educación nutriológica |
                                    </b><?php echo ucfirst($row['nutrition_education_comment']);?></li> <?php endif; ?>
                                <?php if($row['others']== 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Otros |
                                    </b><?php echo ucfirst($row['others_comment']);?></li> <?php endif; ?>
                                <?php endforeach;?>
                            </ul>
                        </div>
                        <?php }
                        if($this->crud_model->check_item('obstetrics') == 1) {
                        ?>

                        <div class="col-sm-12">
                            <div class="ant-tile ant-tile-inlined">
                                <a class="ant-tile-box faded" href="javascript:void(0);"
                                    onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_gyneco_obstetric_list/<?php echo $patient_id;?>');">
                                    <div class="pt-new-icon">
                                        <i class="os-icon picons-thin-icon-thin-0151_plus_add_new"></i>
                                    </div>
                                </a>
                                <span
                                    style="margin-left:10px; font-weight:600;color:#047bf8;font-size:13px;    text-transform: uppercase;">Gineco-Obstétricos</span>
                            </div>
                            <ul
                                style="margin-top:-15px;margin-bottom:15px;border-bottom: 1px solid rgba(0, 0, 0, 0.1);list-style:none">
                                <?php 
        			                $this->db->where('patient_id',$patient_id);
        			                $gyneco = $this->db->get('gyneco_obstetrics')->result_array();
        			                foreach($gyneco as $row):
        			            ?>
                                <?php if($row['first_menstruation']!= ""): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Primera menstruación |
                                    </b><?php echo ucfirst($row['first_menstruation']);?></li> <?php endif; ?>
                                <?php if($row['last_menstruation']!= ""): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Última menstruación |
                                    </b><?php echo ucfirst($row['last_menstruation']);?></li> <?php endif; ?>
                                <?php if($row['menstruation_features']!= ""): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Características de menstruación |
                                    </b><?php echo ucfirst($row['menstruation_features']);?></li> <?php endif; ?>
                                <?php if($row['pregnancies']== 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Embarazos |
                                    </b><?php echo ucfirst($row['pregnancies_comment']);?></li> <?php endif; ?>
                                <?php if($row['cervical_cancer']== 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Cáncer cérvico |
                                    </b><?php echo ucfirst($row['cervical_cancer_comment']);?></li> <?php endif; ?>
                                <?php if($row['uterine_cancer']== 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Cáncer uterino |
                                    </b><?php echo ucfirst($row['uterine_cancer_comment']);?></li> <?php endif; ?>
                                <?php if($row['breast_cancer']== 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Cáncer de mama |
                                    </b><?php echo ucfirst($row['breast_cancer_comment']);?></li> <?php endif; ?>
                                <?php if($row['sexual_activity']== 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Actividad sexual del paciente |
                                    </b><?php echo ucfirst($row['sexual_activity_comment']);?></li> <?php endif; ?>
                                <?php if($row['family_planning']!= ""): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Método de planificación familiar |
                                    </b><?php echo ucfirst($row['family_planning']);?></li> <?php endif; ?>
                                <?php if($row['replacement_therapy']== 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Terapia de reemplazo hormonal |
                                    </b><?php echo ucfirst($row['replacement_therapy_comment']);?></li> <?php endif; ?>
                                <?php if($row['last_pap']!= ""): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Último papanicolau |
                                    </b><?php echo ucfirst($row['last_pap']);?></li> <?php endif; ?>
                                <?php if($row['mammography']!= ""): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Última mastografía |
                                    </b><?php echo ucfirst($row['mammography']);?></li> <?php endif; ?>
                                <?php if($row['others']== 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Otros |
                                    </b><?php echo ucfirst($row['others_comment']);?></li> <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php }
                        if($this->crud_model->check_item('perinatal') == 1) {
                        ?>
                        <div class="col-sm-12">
                            <div class="ant-tile ant-tile-inlined">
                                <a class="ant-tile-box faded" href="javascript:void(0);"
                                    onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_perinatal_list/<?php echo $patient_id;?>');">
                                    <div class="pt-new-icon">
                                        <i class="os-icon picons-thin-icon-thin-0151_plus_add_new"></i>
                                    </div>
                                </a>
                                <span
                                    style="margin-left:10px; font-weight:600;color:#047bf8;font-size:13px;    text-transform: uppercase;">Perinatales</span>
                            </div>
                            <ul
                                style="margin-top:-15px;margin-bottom:15px;border-bottom: 1px solid rgba(0, 0, 0, 0.1);list-style:none">
                                <?php 
        			                $this->db->where('patient_id',$patient_id);
        			                $perinatals = $this->db->get('perinatal')->result_array();
        			                foreach($perinatals as $row):
        			            ?>
                                <?php if($row['last_menstrual']!= ""): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Último ciclo menstrual |
                                    </b><?php echo ucfirst($row['last_menstrual']);?></li> <?php endif; ?>
                                <?php if($row['cycle_duration']!= ""): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Duración ciclo |
                                    </b><?php echo ucfirst($row['cycle_duration']);?></li> <?php endif; ?>
                                <?php if($row['last_method']!= ""): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Último método anticonceptivo usado
                                        | </b><?php echo ucfirst($row['last_method']);?></li> <?php endif; ?>
                                <?php if($row['assisted_conception']== 1): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Concepción asistida |
                                    </b><?php echo ucfirst($row['assisted_conception_comment']);?></li> <?php endif; ?>
                                <?php if($row['ucm_date']!= ""): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Fecha probable de parto por UCM |
                                    </b><?php echo ucfirst($row['ucm_date']);?></li> <?php endif; ?>
                                <?php if($row['fpp_final']!= ""): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> FPP final |
                                    </b><?php echo ucfirst($row['fpp_final']);?></li> <?php endif; ?>
                                <?php if($row['notes']!= ""): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Notas sobre el embarazo |
                                    </b><?php echo ucfirst($row['notes']);?></li> <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php }
                        if($this->crud_model->check_item('postnatal') == 1) {
                        ?>
                        <div class="col-sm-12">
                            <div class="ant-tile ant-tile-inlined">
                                <a class="ant-tile-box faded" href="javascript:void(0);"
                                    onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_postnatal_list/<?php echo $patient_id;?>');">
                                    <div class="pt-new-icon">
                                        <i class="os-icon picons-thin-icon-thin-0151_plus_add_new"></i>
                                    </div>
                                </a>
                                <span
                                    style="margin-left:10px; font-weight:600;color:#047bf8;font-size:13px;    text-transform: uppercase;">Postnatales</span>
                            </div>
                            <ul
                                style="margin-top:-15px;margin-bottom:15px;border-bottom: 1px solid rgba(0, 0, 0, 0.1);list-style:none">
                                <?php 
        			           $this->db->where('patient_id',$patient_id);
        			           $postnatals = $this->db->get('postnatal')->result_array();
        			           foreach($postnatals as $row): ?>
                                <?php if($row['baby_name'] != ""): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Detalles del parto |
                                    </b><?php echo ucfirst($row['baby_name']);?></li> <?php endif; ?>
                                <?php if($row['birth_details'] != ""): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Nombre del bebé |
                                    </b><?php echo ucfirst($row['birth_details']);?></li> <?php endif; ?>
                                <?php if($row['birth_weight'] != ""): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Peso al nacer |
                                    </b><?php echo ucfirst($row['birth_weight']);?></li> <?php endif; ?>
                                <?php if($row['baby_health'] != ""): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Salud del bebé |
                                    </b><?php echo ucfirst($row['baby_health']);?></li> <?php endif; ?>
                                <?php if($row['baby_feeding'] != ""): ?><li><i class="fas fa-check"
                                        style="color:#60d600;font-size:14px"></i> <b> Alimentación del bebé |
                                    </b><?php if($row['baby_feeding'] == 1) echo "Sólo pecho"; if($row['baby_feeding'] == 2) echo "Sólo fórmula"; if($row['baby_feeding'] == 3) echo "Pecho y fórmula"; endif;?>
                                    <?php if($row['emotional_state'] != ""): ?>
                                <li><i class="fas fa-check" style="color:#60d600;font-size:14px"></i> <b> Estado
                                        emocional | </b><?php echo ucfirst($row['emotional_state']);?></li>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>

                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div id="medicamentos">
                    <div class="card-widget">
                        <h5 class="panel-content-title">Historial de medicamentos</h5>
                        <span class="app-divider2"></span>
                        <input type="hidden" id="patient_id" value="<?php echo $patient_id;?>" />
                        <div class="card-b">
                            <span><input type="text" id="medicament" class="form-control"
                                    style="width:80%; float:left;"> <a style="float:right;" type="submit"
                                    href="javascript:void(0);" id="submit_btn" value="+"
                                    class="btn btn-warning">+</a></span>
                        </div>
                        <br><br><br>
                        <ul style="padding: 0; list-style-type: none;">
                            <table class="col-sm-12" id="table_medicaments">
                            </table>
                        </ul>
                    </div>
                </div>
            </div>
        </div>






    </div>
</div>
<script src="<?php echo base_url();?>public/assets/back/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url();?>public/assets/theme/js/bs.js"></script>
<script>
$('.ae-side-menu-toggler').on('click', function() {
    $('.app-side').toggleClass('compact-side-menu');
});
if ($('.app-side').length) {
    if (is_display_type('phone') || is_display_type('tablet')) {
        $('.app-side').addClass('compact-side-menu');
    }
}
</script>
<?php  endforeach; ?>

<script src="<?php echo base_url();?>public/assets/appointments/js/common_scripts.js"></script>

<script>
var patient_id = $("#patient_id").val();
$(document).ready(function() {
    update_table_medication(patient_id);
});
</script>

<script>
var post_message = 'Se ha registrado el medicamento correctamente';
$(document).ready(function() {
    $("#submit_btn").click(function() {
        var medicament = $("#medicament").val();
        if (patient_id != "" && medicament != "") {
            $.ajax({
                url: "<?php echo base_url();?>doctor/medication_history/create/",
                type: 'POST',
                data: {
                    patient_id: patient_id,
                    medicament: medicament
                },
                success: function(result) {

                    $("#medicament").val('');
                    update_table_medication(patient_id);

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'bottom-right',
                        showConfirmButton: false,
                        timer: 5000
                    });

                    Toast.fire({
                        type: 'success',
                        title: post_message
                    })
                }
            });
        }
    });


});
</script>

<script>
function update_table_medication(patient_id) {
    $.ajax({
        url: '<?php echo base_url();?>doctor/update_medication_table/' + patient_id,
        success: function(response) {
            jQuery('#table_medicaments').html(response);
        }
    });
}



function delete_element(element_id) {
    var r = confirm("¿Está seguro que desea eliminar la información?");
    if (r == true) {
        $.ajax({
            url: '<?php echo base_url();?>doctor/medication_history/delete/' + element_id,
            success: function(response) {
                update_table_medication(patient_id);
            }
        });
    }
}
</script>


<script type="text/javascript">
function delete_allergie(allergie_id) {

    var patient_id = $("#patient_id").val();
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede revertir.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {

            $.ajax({
                url: "<?php echo base_url();?>doctor/patients/delete_allergie/" + allergie_id,
                success: function(response) {
                    location.reload();
                }
            })

        }
    })
}
</script>