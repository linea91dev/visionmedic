<link rel="stylesheet" href="<?php echo base_url();?>public/assets/search/estilo.css">
<style>
.flot-chart-container {
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    width: 100%;
    height: 400px
}

.flot-chart-container #toggling-series-flot {
    width: 79% !important
}

.all-chart .flot-chart-container {
    height: 350px
}

.flot-chart-placeholder {
    width: 100%;
    height: 100%;
    font-size: 14px;
    line-height: 1.2em;
    text-align: center
}

.flot-chart-placeholder .legend table {
    border-spacing: 5px
}
</style>
<?php   
    $appointment_id = base64_decode($id_);
    $this->db->where('appointment_id', $appointment_id);
    $info = $this->db->get('appointment')->result_array();
    foreach ($info as $det):
    $patient_id = $det['patient_id'];
?>
<script>
var base_url = '<?php echo base_url();?>';
var app = '<?php echo base64_decode($id_);?>';
</script>
<div id="main-content">
    <div class="row">
        <?php if($det['status'] == 0):?>
        <div class="col-sm-12">
            <div class="alert alert-info">
                <span class="alert-title"><i class="batch-icon-spam"></i> Se requiere confirmación.</span>
                <span class="alert-content">Esta cita aún está pendiente de confirmación, para poder llenar los
                    datos y finalizarla por favor confirmala o cambiala de <span class="alert-lined"><a href="javascript:void(0);" style="color:#0044e9">estado</a>.</span></span>
            </div>
        </div>
        <?php endif;?>
        <div class="col-sm-4">
            <div class="" id="sticky">
                <div class="card-widget" style="border: 1px solid #c6c6cc;">
                    <h4 class="panel-content-title">Paciente</h4>
                    <span class="app-divider2"></span>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="patient-info">
                                <div class="profile-tile-box">
                                    <div class="pt-avatar-w"><img alt="" src="<?php echo $this->accounts_model->get_photo('patient', $patient_id);?>">
                                    </div>
                                    <div class="pt-user-last">
                                        <a href="<?php echo base_url(); ?>doctor/patient_profile/<?php echo base64_encode($patient_id); ?>" style="font-size:20px;color:black;text-decoration:none;"><?php echo $this->accounts_model->get_full_name('patient',$patient_id);?></a>
                                    </div>
                                    <div class="col-sm-12 col-lg-12">
                                        <div class="form-group">
                                            <a class="" href="javascript:void(0);" onclick="showGraphics()">
                                                VER PROGRESO


                                            </a>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="pt-user-med">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-12 col-lg-6" style="overflow-wrap: anywhere;background: #f9fafc; width: 100%; padding: 10px; border-radius: 10px; border: 2px dotted #c6c6cc;margin-bottom: 10px!important;padding-left: 20px; text-align: left; margin: 0 auto;">
                                                <div>
                                                    <span style="display: block;">Edad:</span>
                                                    <span style="font-weight: bold;">
                                                        <?php $originalDate = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->date_of_birth; $newDate = date("d-m-Y", strtotime($originalDate)); ?>
                                                        <?php echo $this->accounts_model->get_age($originalDate);?>.
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-12 col-lg-6" style="overflow-wrap: anywhere;background: #f9fafc; width: 100%; padding: 10px; border-radius: 10px; border: 2px dotted #c6c6cc;margin-bottom: 10px!important;padding-left: 20px; text-align: left; margin: 0 auto;">
                                                <div>
                                                    <span style="display: block;">Género:</span>
                                                    <span style="font-weight: bold;">
                                                        <?php $gen = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->gender; echo $gen =='M' ?  'Masculino' : 'Femenino'; ?></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-12 col-lg-6" style="overflow-wrap: anywhere;background: #f9fafc; width: 100%; padding: 10px; border-radius: 10px; border: 2px dotted #c6c6cc;margin-bottom: 10px!important;padding-left: 20px; text-align: left; margin: 0 auto;">
                                                <div>
                                                    <span style="display: block;">Tipo sanguíneo:</span>
                                                    <span style="font-weight: bold;">
                                                        <input onchange="updateDataPatient('blood',<?php echo  $patient_id ?>,this.value)" type="text" class="form-control" value=" <?php $blood = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->blood; if($blood != '') echo $blood; else echo 'No especificado'; ?>"></input>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-12 col-lg-6" style="overflow-wrap: anywhere;background: #f9fafc; width: 100%; padding: 10px; border-radius: 10px; border: 2px dotted #c6c6cc;margin-bottom: 10px!important;padding-left: 20px; text-align: left; margin: 0 auto;">
                                                <div>
                                                    <span style="display: block;">Correo:</span>
                                                    <span>
                                                        <input onchange="updateDataPatient('email',<?php echo  $patient_id ?>,this.value)" type="text" class="form-control" value=" <?php $mail =  $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->email; if($mail != '') echo $mail; else echo 'No especificado'; ?>"></input>
                                                    </span>
                                                </div>
                                            </div>
                                            <?php if($this->session->userdata('current_clinic') == 1):
                                                $pat = $this->db->get_where('patient', array('patient_id' => $patient_id))->row();
                                                
                                                ?>
                                            <div class="col-sm-6 col-md-12 col-lg-12  " style="text-align: left; overflow-wrap: anywhere;background: #f9fafc; width: 100%; padding: 10px; border-radius: 10px; border: 2px dotted #c6c6cc;margin-bottom: 10px!important;padding-left: 20px; text-align: left; margin: 0 auto;">
                                                <span>Padre:</span>
                                                <br>
                                                <br>
                                                <div class="row" style="">
                                                    <div class="col-sm-4">
                                                        <input onchange="updateDataPatient('father_name',<?php echo  $patient_id ?>,this.value)" type="text" placeholder="Nombre" class="form-control" value="<?php echo $pat->father_name; ?>"></input>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input onchange="updateDataPatient('father_lastname',<?php echo  $patient_id ?>,this.value)" type="text" placeholder="Apellido" class="form-control" value="<?php echo $pat->father_lastname; ?>"></input>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input onchange="updateDataPatient('father_phone',<?php echo  $patient_id ?>,this.value)" type="text" placeholder="Teléfono" class="form-control" value="<?php echo $pat->father_phone; ?>"></input>
                                                    </div>
                                                    <br>
                                                    <br>
                                                    <div class="col-sm-12">
                                                        <input onchange="updateDataPatient('father_ocupation',<?php echo  $patient_id ?>,this.value)" type="text" placeholder="Ocupación" class="form-control" value="<?php echo $pat->father_ocupation; ?>"></input>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-12 col-lg-12  " style="text-align: left; overflow-wrap: anywhere;background: #f9fafc; width: 100%; padding: 10px; border-radius: 10px; border: 2px dotted #c6c6cc;margin-bottom: 10px!important;padding-left: 20px; text-align: left; margin: 0 auto;">
                                                <span>Madre:</span>
                                                <br>
                                                <br>
                                                <div class="row" style="">
                                                    <div class="col-sm-4">
                                                        <input onchange="updateDataPatient('mother_name',<?php echo  $patient_id ?>,this.value)" type="text" class="form-control" placeholder="Nombre" value="<?php echo $pat->mother_name; ?>"></input>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input onchange="updateDataPatient('mother_lastname',<?php echo  $patient_id ?>,this.value)" type="text" class="form-control" placeholder="Apellido" value="<?php echo $pat->mother_lastname; ?>"></input>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input onchange="updateDataPatient('mother_phone',<?php echo  $patient_id ?>,this.value)" type="text" class="form-control" placeholder="Teléfono" value="<?php echo $pat->mother_phone;?>"> </input>
                                                    </div>
                                                    <br>
                                                    <br>
                                                    <div class="col-sm-12">
                                                        <input onchange="updateDataPatient('mother_ocupation',<?php echo  $patient_id ?>,this.value)" type="text" placeholder="Ocupación" class="form-control" value="<?php echo $pat->mother_ocupation; ?>"></input>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-12 col-lg-12  " style="text-align: left; overflow-wrap: anywhere;background: #f9fafc; width: 100%; padding: 10px; border-radius: 10px; border: 2px dotted #c6c6cc;margin-bottom: 10px!important;padding-left: 20px; text-align: left; margin: 0 auto;">
                                                <span>ENCARGADO O TUTOR:</span>
                                                <br>
                                                <br>
                                                <div class="row" style="">
                                                    <div class="col-sm-4">
                                                        <input onchange="updateDataPatient('tutor_name',<?php echo  $patient_id ?>,this.value)" type="text" class="form-control" placeholder="Nombre" value="<?php echo $pat->tutor_name; ?>"></input>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input onchange="updateDataPatient('tutor_lastname',<?php echo  $patient_id ?>,this.value)" type="text" class="form-control" placeholder="Apellido" value="<?php echo $pat->tutor_lastname; ?>"></input>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input onchange="updateDataPatient('tutor_phone',<?php echo  $patient_id ?>,this.value)" type="text" class="form-control" placeholder="Teléfono" value="<?php echo $pat->tutor_phone;?>"> </input>
                                                    </div>
                                                    <br>
                                                    <br>
                                                    <div class="col-sm-12">
                                                        <input onchange="updateDataPatient('tutor_ocupation',<?php echo  $patient_id ?>,this.value)" type="text" placeholder="Ocupación" class="form-control" value="<?php echo $pat->tutor_ocupation; ?>"></input>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endif;?>
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <center>
                                                    <span class="app-divider"></span>
                                                </center>
                                                <div class="row">
                                                    <div class="col-sm-12 col-lg-4">
                                                        <div class="form-group">
                                                            <a class="btn btn-success custom-radius full-width" href="<?php echo base_url();?>doctor/patient_profile/<?php echo  base64_encode($patient_id);?>">
                                                                Ir al perfil
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-4">
                                                        <div class="form-group">
                                                            <a class="btn btn-primary custom-radius full-width" href="<?php echo base_url();?>doctor/medical_history/<?php echo  base64_encode($patient_id);?>">
                                                                Historial
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-4 col-md-6">
                                                        <div class="form-group">
                                                            <a class="btn btn-danger custom-radius full-width" href="<?php echo base_url();?>doctor/patient_files/<?php echo  base64_encode($patient_id);?> ">
                                                                Archivos
                                                            </a>
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
                </div>

            </div>
        </div>

        <div class="col-sm-8">
            <div id="graphics" style="display:none">
                <?php if($gen != "M" ):?>
                <div class="col-sm-12">
                    <div class="card-widget">
                        <h4 class="panel-content-title">Talla para la edad niñas</h4>
                        <canvas id="lhfa_girls" height="150" style="width:100%"></canvas>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card-widget">
                        <h4 class="panel-content-title">Peso para la edad niñas</h4>
                        <canvas id="wfa_girls" height="150" style="width:100%"></canvas>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card-widget">
                        <h4 class="panel-content-title">Peso para la talla niñas</h4>
                        <canvas id="wfl_girls" height="150" style="width:100%"></canvas>
                    </div>
                </div>
                <?php else: ?>
                <div class="col-sm-12">
                    <div class="card-widget">
                        <h4 class="panel-content-title">Talla para la edad niños</h4>
                        <canvas id="lhfa_boys" height="150" style="width:100%"></canvas>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card-widget">
                        <h4 class="panel-content-title">Peso para la edad niños</h4>
                        <canvas id="wfa_boys" height="150" style="width:100%"></canvas>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card-widget">
                        <h4 class="panel-content-title">Peso para la talla niños</h4>
                        <canvas id="wfl_boys" height="150" style="width:100%"></canvas>
                    </div>
                </div>
                <?php endif;?>
            </div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <?php $citas = $this->db->order_by('order_date','ASC')->get_where('appointment',array('patient_id'=>$det['patient_id']))->result_array();?>
                <?php foreach ($citas as $c): ?>

                <li class="nav-item">
                    <a class="nav-link " data-toggle="tab" href="#c-<?php echo $c['appointment_id']?>" id="d-<?php echo $c['appointment_id']?>"><?php echo $c['date']?></a>
                </li>

                <?php endforeach;?>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <?php foreach ($citas as $details): ?>
                <?php
                    $oft_fields = array(
                        'od_avsc', 'od_avcc', 'od_avph', 'od_meo', 'od_pio', 'od_pupilas',
                        'os_avsc', 'os_avcc', 'os_avph', 'os_meo', 'os_pio', 'os_pupilas',
                        'oft_vias_lagrimales_od', 'oft_vias_lagrimales_os',
                        'oft_parpados_pestanas_od', 'oft_parpados_pestanas_os',
                        'oft_conjuntiva_od', 'oft_conjuntiva_os',
                        'oft_esclera_cornea_od', 'oft_esclera_cornea_os',
                        'oft_camara_anterior_od', 'oft_camara_anterior_os',
                        'oft_iris_od', 'oft_iris_os',
                        'oft_cristalino_od', 'oft_cristalino_os',
                        'oft_gonioscopia_od', 'oft_gonioscopia_os',
                        'oft_vitreo_od', 'oft_vitreo_os',
                        'oft_nervio_optico_od', 'oft_nervio_optico_os',
                        'oft_retina_p_post_od', 'oft_retina_p_post_os',
                        'oft_retina_periferica_od', 'oft_retina_periferica_os',
                        'oft_ic', 'oft_tx',
                        'lens_od_esf', 'lens_od_cil', 'lens_od_eje', 'lens_od_add',
                        'lens_os_esf', 'lens_os_cil', 'lens_os_eje', 'lens_os_add',
                        'ro_od_esf', 'ro_od_cil', 'ro_od_eje', 'ro_od_add',
                        'ro_os_esf', 'ro_os_cil', 'ro_os_eje', 'ro_os_add',
                        'rs_od_esf', 'rs_od_cil', 'rs_od_eje', 'rs_od_add',
                        'rs_os_esf', 'rs_os_cil', 'rs_os_eje', 'rs_os_add',
                        'rf_od_esf', 'rf_od_cil', 'rf_od_eje', 'rf_od_add',
                        'rf_os_esf', 'rf_os_cil', 'rf_os_eje', 'rf_os_add',
                        'rc_od_esf', 'rc_od_cil', 'rc_od_eje', 'rc_od_add',
                        'rc_os_esf', 'rc_os_cil', 'rc_os_eje', 'rc_os_add',
                        'graf_od_externo', 'graf_os_externo', 'graf_od_fondo', 'graf_os_fondo',
                        'kera_od_k1', 'kera_od_k1_eje', 'kera_od_k1_nomarca', 'kera_od_k1_irregular', 'kera_od_kprom',
                        'kera_od_k2', 'kera_od_k2_eje', 'kera_od_k2_nomarca', 'kera_od_k2_irregular',
                        'kera_os_k1', 'kera_os_k1_eje', 'kera_os_k1_nomarca', 'kera_os_k1_irregular', 'kera_os_kprom',
                        'kera_os_k2', 'kera_os_k2_eje', 'kera_os_k2_nomarca', 'kera_os_k2_irregular',
                        'ar_od_esf', 'ar_od_cil', 'ar_od_eje', 'ar_od_nomarca', 'ar_od_dip',
                        'ar_os_esf', 'ar_os_cil', 'ar_os_eje', 'ar_os_nomarca', 'ar_os_dip',
                        'ar_notas_ojo', 'ar_notas', 'ar_diferido',
                        'av_od_avl_sc', 'av_od_avl_cc', 'av_od_avc_sc', 'av_od_avc_cc', 'av_od_avl_ph',
                        'av_os_avl_sc', 'av_os_avl_cc', 'av_os_avc_sc', 'av_os_avc_cc', 'av_os_avl_ph',
                        'av_optotipo', 'av_notas_ojo', 'av_notas', 'av_diferido',
                        'seg_vias_od', 'seg_vias_os', 'seg_parpados_od', 'seg_parpados_os',
                        'seg_conjuntiva_od', 'seg_conjuntiva_os', 'seg_esclera_od', 'seg_esclera_os',
                        'seg_cornea_od', 'seg_cornea_os', 'seg_camara_od', 'seg_camara_os',
                        'seg_iris_od', 'seg_iris_os', 'seg_pupila_od', 'seg_pupila_os',
                        'seg_cristalino_od', 'seg_cristalino_os',
                        'seg_vias_od_nota', 'seg_vias_os_nota', 'seg_parpados_od_nota', 'seg_parpados_os_nota',
                        'seg_conjuntiva_od_nota', 'seg_conjuntiva_os_nota', 'seg_esclera_od_nota', 'seg_esclera_os_nota',
                        'seg_cornea_od_nota', 'seg_cornea_os_nota', 'seg_camara_od_nota', 'seg_camara_os_nota',
                        'seg_iris_od_nota', 'seg_iris_os_nota', 'seg_pupila_od_nota', 'seg_pupila_os_nota',
                        'seg_cristalino_od_nota', 'seg_cristalino_os_nota',
                        'rx_comentario',
                        'rx_final_od_esf', 'rx_final_od_cil', 'rx_final_od_eje', 'rx_final_od_prisma', 'rx_final_od_base',
                        'rx_final_os_esf', 'rx_final_os_cil', 'rx_final_os_eje', 'rx_final_os_prisma', 'rx_final_os_base',
                        'rx_add_od_esf', 'rx_add_od_cil', 'rx_add_od_eje', 'rx_add_od_prisma', 'rx_add_od_base',
                        'rx_add_os_esf', 'rx_add_os_cil', 'rx_add_os_eje', 'rx_add_os_prisma', 'rx_add_os_base',
                        'rx_dip',
                        'rx_lente_monofocal', 'rx_lente_progresivo', 'rx_lente_bifocal', 'rx_lente_otro',
                        'rx_rec_filtro', 'rx_rec_antireflejo', 'rx_rec_polarizado', 'rx_rec_polarizado_nota',
                        'rx_rec_policarbonato', 'rx_rec_sol', 'rx_rec_tenido', 'rx_rec_tenido_nota',
                        'rx_rec_transitions', 'rx_rec_transitions_nota', 'rx_rec_otros',
                        'rx_contacto'
                    );
                    $oft_defaults = array_fill_keys($oft_fields, '');
                    $oft_row = $this->db->get_where('appointment_oftalmology', array('appointment_id' => $details['appointment_id']))->row_array();
                    if (!is_array($oft_row)) {
                        $oft_row = array();
                    }
                    $details = array_merge($details, $oft_defaults, $oft_row);
                ?>

                <div class="tab-pane container " id="c-<?php echo $details['appointment_id']?>">

                    <form action="<?php echo base_url();?>doctor/appointment/finish" method="POST">
                        <input type="hidden" name="appointment_id" id="appointment_id" value="<?php echo $details['appointment_id'];?>">
                        <input type="hidden" name="patient_id" id="patient_id" value="<?php echo $this->db->get_where('patient', array('patient_id' => $det['patient_id']))->row()->patient_id; ?>">
                        <script>
                        var base_url = '<?php echo base_url();?>';
                        var appointment_id = '<?php echo $appointment_id;?>';
                        </script>
                        <br>
                        <?php if($details['practice']==21 && $appointment_id == $details['appointment_id']):?>
                        <div class="card-widget" style="border: 1px solid #c6c6cc;">
                            <h5 class="panel-content-title">Teleconsulta</h5>
                            <span class="app-divider2"></span>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="teleconsulta" style="height: 400px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif;?>
                        <div class="card-widget" style="border: 1px solid #c6c6cc;">
                            <h5 class="panel-content-title">Detalles de la cita</h5>
                            <span class="app-divider2"></span>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="alert alert-pending">
                                        <b>Fecha y hora</b>
                                        <span style="display:block"><?php 
                                                    
                                                    setlocale(LC_TIME, "spanish");
                                                    $Nueva_Fecha = date("d-m-Y", strtotime( str_replace("/","-",$details['date']) ));				
                                                    $Mes_Anyo = strftime("%d de %B de %Y", strtotime($Nueva_Fecha)); 
                                                    echo $Mes_Anyo; 
                                            ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <b>Motivo de consulta:</b>
                                        <textarea cols="80" class="form-control" name="instructions" rows="1" onchange="updateConsulta('mc',<?php echo $details['appointment_id'] ?>,this.value)"><?php echo $details['comment']; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <b>MC:</b>
                                        <textarea cols="80" class="form-control" name="ckplan" rows="5" onchange="updateConsulta('he',<?php echo $details['appointment_id'] ?>,this.value)"><?php   echo $details['he']?>
                                        </textarea>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <b>HEA:</b>
                                        <textarea cols="80" class="form-control" name="instructions" rows="5" onchange="updateConsulta('ef',<?php echo $details['appointment_id'] ?>,this.value)"><?php    echo $details['ef']; ?></textarea>
                                    </div>
                                </div>
                                <?php
                                    $app_key = $details['appointment_id'];
                                    $patient_ants = array();
                                    if ($this->db->table_exists('patient_antecedent')) {
                                        $patient_ants = $this->db->order_by('antecedent_id', 'ASC')->get_where('patient_antecedent', array('patient_id' => $det['patient_id']))->result_array();
                                    }
                                    $ants_md = array();
                                    $ants_qx = array();
                                    $ants_alg = array();
                                    $ants_trx = array();
                                    $ants_fam = array();
                                    foreach ($patient_ants as $ant_row) {
                                        if ($ant_row['type'] == 'md') $ants_md[] = $ant_row;
                                        if ($ant_row['type'] == 'qx') $ants_qx[] = $ant_row;
                                        if ($ant_row['type'] == 'alg') $ants_alg[] = $ant_row;
                                        if ($ant_row['type'] == 'trx') $ants_trx[] = $ant_row;
                                        if ($ant_row['type'] == 'fam') $ants_fam[] = $ant_row;
                                    }
                                ?>
                                <div class="col-sm-12">
                                    <div class="form-group" style="border:1px solid #e6e8ee;border-radius:8px;padding:12px;margin-bottom:12px;">
                                        <div style="display:flex;justify-content:space-between;align-items:center;">
                                            <div>
                                                <div style="font-size:12px;letter-spacing:.4px;color:#8b93a7;">ANTECEDENTES</div>
                                                <div style="color:#047bf8;font-weight:700;">MD</div>
                                            </div>
                                            <button type="button" class="btn btn-primary" style="border-radius:10px;min-width:42px;" onclick="addAntecedentRow('md',<?php echo $app_key; ?>,<?php echo $det['patient_id']; ?>)">+</button>
                                        </div>
                                        <div id="ant_md_rows_<?php echo $app_key; ?>" style="margin-top:8px;">
                                            <?php if (count($ants_md) == 0) $ants_md[] = array('antecedent_id' => '', 'item' => '', 'treatment' => '', 'notes' => ''); ?>
                                            <?php foreach ($ants_md as $ant): ?>
                                            <div class="ant-row" data-id="<?php echo $ant['antecedent_id']; ?>" data-type="md" data-patient="<?php echo $det['patient_id']; ?>" style="border-top:1px solid #f0f2f6;padding-top:10px;margin-top:8px;">
                                                <div class="row">
                                                    <div class="col-sm-6"><label>DIAGNÓSTICO</label><input type="text" class="form-control ant-item" onchange="saveAntecedentRow(this)" value="<?php echo htmlspecialchars($ant['item']); ?>"></div>
                                                    <div class="col-sm-6"><label>TRATAMIENTO</label><input type="text" class="form-control ant-tx" onchange="saveAntecedentRow(this)" value="<?php echo htmlspecialchars($ant['treatment']); ?>"></div>
                                                    <div class="col-sm-12" style="margin-top:8px;"><label>NOTAS</label><textarea class="form-control ant-notes" rows="2" onchange="saveAntecedentRow(this)"><?php echo htmlspecialchars($ant['notes']); ?></textarea></div>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="form-group" style="border:1px solid #e6e8ee;border-radius:8px;padding:12px;margin-bottom:12px;">
                                        <div style="display:flex;justify-content:space-between;align-items:center;">
                                            <div>
                                                <div style="font-size:12px;letter-spacing:.4px;color:#8b93a7;">ANTECEDENTES</div>
                                                <div style="color:#047bf8;font-weight:700;">QX</div>
                                            </div>
                                            <button type="button" class="btn btn-primary" style="border-radius:10px;min-width:42px;" onclick="addAntecedentRow('qx',<?php echo $app_key; ?>,<?php echo $det['patient_id']; ?>)">+</button>
                                        </div>
                                        <div id="ant_qx_rows_<?php echo $app_key; ?>" style="margin-top:8px;">
                                            <?php if (count($ants_qx) == 0) $ants_qx[] = array('antecedent_id' => '', 'item' => '', 'treatment' => '', 'notes' => ''); ?>
                                            <?php foreach ($ants_qx as $ant): ?>
                                            <div class="ant-row" data-id="<?php echo $ant['antecedent_id']; ?>" data-type="qx" data-patient="<?php echo $det['patient_id']; ?>" style="border-top:1px solid #f0f2f6;padding-top:10px;margin-top:8px;">
                                                <div class="row">
                                                    <div class="col-sm-6"><label>CIRUGÍA</label><input type="text" class="form-control ant-item" onchange="saveAntecedentRow(this)" value="<?php echo htmlspecialchars($ant['item']); ?>"></div>
                                                    <div class="col-sm-6"><label>NOTAS</label><textarea class="form-control ant-notes" rows="2" onchange="saveAntecedentRow(this)"><?php echo htmlspecialchars($ant['notes']); ?></textarea></div>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="form-group" style="border:1px solid #e6e8ee;border-radius:8px;padding:12px;margin-bottom:12px;">
                                        <div style="display:flex;justify-content:space-between;align-items:center;">
                                            <div>
                                                <div style="font-size:12px;letter-spacing:.4px;color:#8b93a7;">ANTECEDENTES</div>
                                                <div style="color:#047bf8;font-weight:700;">ALG</div>
                                            </div>
                                            <button type="button" class="btn btn-primary" style="border-radius:10px;min-width:42px;" onclick="addAntecedentRow('alg',<?php echo $app_key; ?>,<?php echo $det['patient_id']; ?>)">+</button>
                                        </div>
                                        <div id="ant_alg_rows_<?php echo $app_key; ?>" style="margin-top:8px;">
                                            <?php if (count($ants_alg) == 0) $ants_alg[] = array('antecedent_id' => '', 'item' => '', 'treatment' => '', 'notes' => ''); ?>
                                            <?php foreach ($ants_alg as $ant): ?>
                                            <div class="ant-row" data-id="<?php echo $ant['antecedent_id']; ?>" data-type="alg" data-patient="<?php echo $det['patient_id']; ?>" style="border-top:1px solid #f0f2f6;padding-top:10px;margin-top:8px;">
                                                <div class="row">
                                                    <div class="col-sm-6"><label>ALERGIA</label><input type="text" class="form-control ant-item" onchange="saveAntecedentRow(this)" value="<?php echo htmlspecialchars($ant['item']); ?>"></div>
                                                    <div class="col-sm-6"><label>NOTAS</label><textarea class="form-control ant-notes" rows="2" onchange="saveAntecedentRow(this)"><?php echo htmlspecialchars($ant['notes']); ?></textarea></div>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="form-group" style="border:1px solid #e6e8ee;border-radius:8px;padding:12px;margin-bottom:12px;">
                                        <div style="display:flex;justify-content:space-between;align-items:center;">
                                            <div>
                                                <div style="font-size:12px;letter-spacing:.4px;color:#8b93a7;">ANTECEDENTES</div>
                                                <div style="color:#047bf8;font-weight:700;">TRX</div>
                                            </div>
                                            <button type="button" class="btn btn-primary" style="border-radius:10px;min-width:42px;" onclick="addAntecedentRow('trx',<?php echo $app_key; ?>,<?php echo $det['patient_id']; ?>)">+</button>
                                        </div>
                                        <div id="ant_trx_rows_<?php echo $app_key; ?>" style="margin-top:8px;">
                                            <?php if (count($ants_trx) == 0) $ants_trx[] = array('antecedent_id' => '', 'item' => '', 'treatment' => '', 'notes' => ''); ?>
                                            <?php foreach ($ants_trx as $ant): ?>
                                            <div class="ant-row" data-id="<?php echo $ant['antecedent_id']; ?>" data-type="trx" data-patient="<?php echo $det['patient_id']; ?>" style="border-top:1px solid #f0f2f6;padding-top:10px;margin-top:8px;">
                                                <div class="row">
                                                    <div class="col-sm-6"><label>TRAUMA</label><input type="text" class="form-control ant-item" onchange="saveAntecedentRow(this)" value="<?php echo htmlspecialchars($ant['item']); ?>"></div>
                                                    <div class="col-sm-6"><label>NOTAS</label><textarea class="form-control ant-notes" rows="2" onchange="saveAntecedentRow(this)"><?php echo htmlspecialchars($ant['notes']); ?></textarea></div>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="form-group" style="border:1px solid #e6e8ee;border-radius:8px;padding:12px;margin-bottom:12px;">
                                        <div style="display:flex;justify-content:space-between;align-items:center;">
                                            <div>
                                                <div style="font-size:12px;letter-spacing:.4px;color:#8b93a7;">ANTECEDENTES</div>
                                                <div style="color:#047bf8;font-weight:700;">FAM</div>
                                            </div>
                                            <button type="button" class="btn btn-primary" style="border-radius:10px;min-width:42px;" onclick="addAntecedentRow('fam',<?php echo $app_key; ?>,<?php echo $det['patient_id']; ?>)">+</button>
                                        </div>
                                        <div id="ant_fam_rows_<?php echo $app_key; ?>" style="margin-top:8px;">
                                            <?php if (count($ants_fam) == 0) $ants_fam[] = array('antecedent_id' => '', 'item' => '', 'treatment' => '', 'notes' => ''); ?>
                                            <?php foreach ($ants_fam as $ant): ?>
                                            <div class="ant-row" data-id="<?php echo $ant['antecedent_id']; ?>" data-type="fam" data-patient="<?php echo $det['patient_id']; ?>" style="border-top:1px solid #f0f2f6;padding-top:10px;margin-top:8px;">
                                                <div class="row">
                                                    <div class="col-sm-6"><label>DIAGNÓSTICO</label><input type="text" class="form-control ant-item" onchange="saveAntecedentRow(this)" value="<?php echo htmlspecialchars($ant['item']); ?>"></div>
                                                    <div class="col-sm-6"><label>FAMILIAR</label><input type="text" class="form-control ant-tx" onchange="saveAntecedentRow(this)" value="<?php echo htmlspecialchars($ant['treatment']); ?>"></div>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <b>M:(x)</b>
                                            <input class="form-control" name="instructions" onchange="updateConsulta('w',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['w'];?>"></input>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <b>Q:(x)</b>
                                            <input class="form-control" name="instructions" onchange="updateConsulta('t',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['t'];?>"></input>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <b>Far(x):</b>
                                            <input class="form-control" name="instructions" onchange="updateConsulta('cc',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['cc'];?>"></input>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <b>FECHA:</b>
                                            <input class="form-control" name="instructions" onchange="updateConsulta('imc',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['imc'];?>"></input>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <b>FAM:</b>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <b>DM:</b>
                                            <input class="form-control" name="instructions" onchange="updateConsulta('temp',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['temp'];?>"></input>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <b>HTA:</b>
                                            <input class="form-control" name="instructions" onchange="updateConsulta('fr',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['fr'];?>"></input>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <b>Corazon:</b>
                                            <input class="form-control" name="instructions" onchange="updateConsulta('fc',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['fc'];?>"></input>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <b>CA:</b>
                                            <input class="form-control" name="instructions" onchange="updateConsulta('pa',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['pa'];?>"></input>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <b>ACV:</b>
                                            <input class="form-control" name="instructions" onchange="updateConsulta('so2',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['so2'];?>"></input>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <b>Evaluación visual:</b>
                                        <div class="table-responsive" style="margin-top:8px;">
                                            <table class="table table-bordered" style="margin-bottom:0;">
                                                <thead>
                                                    <tr>
                                                        <th style="width:70px;"></th>
                                                        <th style="width:70px;">AVsc</th>
                                                        <th style="width:70px;">AVcc</th>
                                                        <th style="width:70px;">AVph</th>
                                                        <th style="width:70px;">MEO</th>
                                                        <th style="width:70px;">PIO</th>
                                                        <th style="width:90px;">Pupilas</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><b>DO: OD</b></td>
                                                        <td><input class="form-control" onchange="updateConsulta('od_avsc',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['od_avsc'];?>"></td>
                                                        <td><input class="form-control" onchange="updateConsulta('od_avcc',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['od_avcc'];?>"></td>
                                                        <td><input class="form-control" onchange="updateConsulta('od_avph',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['od_avph'];?>"></td>
                                                        <td><input class="form-control" onchange="updateConsulta('od_meo',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['od_meo'];?>"></td>
                                                        <td><input class="form-control" onchange="updateConsulta('od_pio',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['od_pio'];?>"></td>
                                                        <td><input class="form-control" onchange="updateConsulta('od_pupilas',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['od_pupilas'];?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>OS</b></td>
                                                        <td><input class="form-control" onchange="updateConsulta('os_avsc',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['os_avsc'];?>"></td>
                                                        <td><input class="form-control" onchange="updateConsulta('os_avcc',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['os_avcc'];?>"></td>
                                                        <td><input class="form-control" onchange="updateConsulta('os_avph',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['os_avph'];?>"></td>
                                                        <td><input class="form-control" onchange="updateConsulta('os_meo',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['os_meo'];?>"></td>
                                                        <td><input class="form-control" onchange="updateConsulta('os_pio',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['os_pio'];?>"></td>
                                                        <td><input class="form-control" onchange="updateConsulta('os_pupilas',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['os_pupilas'];?>"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group" style="border:1px solid #e6e8ee;border-radius:8px;padding:12px;">
                                        <b>QUERATOMETRÍA</b>
                                        <?php
                                            $aid = $details['appointment_id'];
                                            $kera_eyes = array('od' => 'OD', 'os' => 'OS');
                                        ?>
                                        <?php foreach ($kera_eyes as $eye => $eye_label): ?>
                                        <div class="row" style="margin-top:10px;align-items:center;">
                                            <div class="col-sm-1"><b><?php echo $eye_label; ?></b></div>
                                            <div class="col-sm-11">
                                                <div style="display:flex;flex-wrap:wrap;gap:8px;align-items:flex-end;margin-bottom:8px;">
                                                    <div><label style="display:block;font-size:12px;color:#047bf8;">K1</label><input class="form-control" style="width:90px;" onchange="updateConsulta('kera_<?php echo $eye; ?>_k1',<?php echo $aid; ?>,this.value)" value="<?php echo $details['kera_'.$eye.'_k1']; ?>"></div>
                                                    <span style="padding-bottom:8px;">x</span>
                                                    <div><label style="display:block;font-size:12px;color:#047bf8;">EJE</label><input class="form-control" style="width:90px;" onchange="updateConsulta('kera_<?php echo $eye; ?>_k1_eje',<?php echo $aid; ?>,this.value)" value="<?php echo $details['kera_'.$eye.'_k1_eje']; ?>"></div>
                                                    <label style="padding-bottom:8px;"><input type="checkbox" <?php echo $details['kera_'.$eye.'_k1_nomarca'] == '1' ? 'checked' : ''; ?> onchange="updateConsulta('kera_<?php echo $eye; ?>_k1_nomarca',<?php echo $aid; ?>,this.checked ? '1' : '0')"> NO MARCA</label>
                                                    <label style="padding-bottom:8px;"><input type="checkbox" <?php echo $details['kera_'.$eye.'_k1_irregular'] == '1' ? 'checked' : ''; ?> onchange="updateConsulta('kera_<?php echo $eye; ?>_k1_irregular',<?php echo $aid; ?>,this.checked ? '1' : '0')"> IRREGULAR</label>
                                                    <div><label style="display:block;font-size:12px;color:#047bf8;">K PROM</label><input class="form-control" style="width:90px;" onchange="updateConsulta('kera_<?php echo $eye; ?>_kprom',<?php echo $aid; ?>,this.value)" value="<?php echo $details['kera_'.$eye.'_kprom']; ?>"></div>
                                                </div>
                                                <div style="display:flex;flex-wrap:wrap;gap:8px;align-items:flex-end;">
                                                    <div><label style="display:block;font-size:12px;color:#047bf8;">K2</label><input class="form-control" style="width:90px;" onchange="updateConsulta('kera_<?php echo $eye; ?>_k2',<?php echo $aid; ?>,this.value)" value="<?php echo $details['kera_'.$eye.'_k2']; ?>"></div>
                                                    <span style="padding-bottom:8px;">x</span>
                                                    <div><label style="display:block;font-size:12px;color:#047bf8;">EJE</label><input class="form-control" style="width:90px;" onchange="updateConsulta('kera_<?php echo $eye; ?>_k2_eje',<?php echo $aid; ?>,this.value)" value="<?php echo $details['kera_'.$eye.'_k2_eje']; ?>"></div>
                                                    <label style="padding-bottom:8px;"><input type="checkbox" <?php echo $details['kera_'.$eye.'_k2_nomarca'] == '1' ? 'checked' : ''; ?> onchange="updateConsulta('kera_<?php echo $eye; ?>_k2_nomarca',<?php echo $aid; ?>,this.checked ? '1' : '0')"> NO MARCA</label>
                                                    <label style="padding-bottom:8px;"><input type="checkbox" <?php echo $details['kera_'.$eye.'_k2_irregular'] == '1' ? 'checked' : ''; ?> onchange="updateConsulta('kera_<?php echo $eye; ?>_k2_irregular',<?php echo $aid; ?>,this.checked ? '1' : '0')"> IRREGULAR</label>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="form-group" style="border:1px solid #e6e8ee;border-radius:8px;padding:12px;margin-top:12px;">
                                        <b>AUTOREFRACTÓMETRO</b>
                                        <div style="display:flex;gap:8px;margin:10px 0 4px 40px;color:#047bf8;font-size:12px;">
                                            <span style="width:90px;">ESF</span>
                                            <span style="width:16px;"></span>
                                            <span style="width:90px;">CIL</span>
                                            <span style="width:16px;"></span>
                                            <span style="width:90px;">EJE</span>
                                            <span style="width:90px;">NO MARCA</span>
                                            <span style="width:90px;">DIP</span>
                                        </div>
                                        <?php foreach ($kera_eyes as $eye => $eye_label): ?>
                                        <div style="display:flex;flex-wrap:wrap;gap:8px;align-items:center;margin-bottom:8px;">
                                            <b style="width:28px;"><?php echo $eye_label; ?></b>
                                            <input class="form-control" style="width:90px;" onchange="updateConsulta('ar_<?php echo $eye; ?>_esf',<?php echo $aid; ?>,this.value)" value="<?php echo $details['ar_'.$eye.'_esf']; ?>">
                                            <span>-</span>
                                            <input class="form-control" style="width:90px;" onchange="updateConsulta('ar_<?php echo $eye; ?>_cil',<?php echo $aid; ?>,this.value)" value="<?php echo $details['ar_'.$eye.'_cil']; ?>">
                                            <span>x</span>
                                            <input class="form-control" style="width:90px;" onchange="updateConsulta('ar_<?php echo $eye; ?>_eje',<?php echo $aid; ?>,this.value)" value="<?php echo $details['ar_'.$eye.'_eje']; ?>">
                                            <label style="width:90px;margin:0;"><input type="checkbox" <?php echo $details['ar_'.$eye.'_nomarca'] == '1' ? 'checked' : ''; ?> onchange="updateConsulta('ar_<?php echo $eye; ?>_nomarca',<?php echo $aid; ?>,this.checked ? '1' : '0')"></label>
                                            <input class="form-control" style="width:90px;" onchange="updateConsulta('ar_<?php echo $eye; ?>_dip',<?php echo $aid; ?>,this.value)" value="<?php echo $details['ar_'.$eye.'_dip']; ?>">
                                        </div>
                                        <?php endforeach; ?>
                                        <div style="margin-top:12px;">
                                            <label><b>NOTAS</b></label>
                                            <div style="margin-bottom:8px;">
                                                <label style="margin-right:12px;"><input type="radio" name="ar_notas_ojo_<?php echo $aid; ?>" value="od" <?php echo $details['ar_notas_ojo'] == 'od' ? 'checked' : ''; ?> onchange="updateConsulta('ar_notas_ojo',<?php echo $aid; ?>,this.value)"> OD</label>
                                                <label style="margin-right:12px;"><input type="radio" name="ar_notas_ojo_<?php echo $aid; ?>" value="os" <?php echo $details['ar_notas_ojo'] == 'os' ? 'checked' : ''; ?> onchange="updateConsulta('ar_notas_ojo',<?php echo $aid; ?>,this.value)"> OS</label>
                                                <label><input type="radio" name="ar_notas_ojo_<?php echo $aid; ?>" value="ou" <?php echo $details['ar_notas_ojo'] == 'ou' ? 'checked' : ''; ?> onchange="updateConsulta('ar_notas_ojo',<?php echo $aid; ?>,this.value)"> OU</label>
                                            </div>
                                            <div style="display:flex;gap:10px;align-items:flex-start;">
                                                <textarea class="form-control" rows="2" onchange="updateConsulta('ar_notas',<?php echo $aid; ?>,this.value)"><?php echo $details['ar_notas']; ?></textarea>
                                                <button type="button" class="btn <?php echo $details['ar_diferido'] == '1' ? 'btn-danger' : 'btn-danger'; ?>" style="min-width:120px;" onclick="updateConsulta('ar_diferido',<?php echo $aid; ?>,'1'); this.innerText='Diferido';">
                                                    <?php echo $details['ar_diferido'] == '1' ? 'Diferido' : 'DIFERIDO'; ?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="border:1px solid #e6e8ee;border-radius:8px;padding:12px;margin-top:12px;">
                                        <b>AGUDEZA VISUAL</b>
                                        <div style="display:flex;gap:8px;margin:10px 0 4px 36px;font-size:12px;font-weight:600;">
                                            <span style="width:90px;">AVL SC</span>
                                            <span style="width:90px;color:#2e9e4f;">AVL CC</span>
                                            <span style="width:90px;color:#2e9e4f;">AVC SC</span>
                                            <span style="width:90px;color:#2e9e4f;">AVC CC</span>
                                            <span style="width:90px;color:#e23b3b;">AVL PH</span>
                                        </div>
                                        <?php
                                            $av_cols = array(
                                                'avl_sc' => 'AVL SC',
                                                'avl_cc' => 'AVL CC',
                                                'avc_sc' => 'AVC SC',
                                                'avc_cc' => 'AVC CC',
                                                'avl_ph' => 'AVL PH'
                                            );
                                        ?>
                                        <?php foreach ($kera_eyes as $eye => $eye_label): ?>
                                        <div style="display:flex;flex-wrap:wrap;gap:8px;align-items:center;margin-bottom:8px;">
                                            <b style="width:28px;"><?php echo $eye_label; ?></b>
                                            <?php foreach ($av_cols as $av_key => $av_label): ?>
                                            <input class="form-control" readonly style="width:90px;cursor:pointer;background:#fff;" onclick="openAvNotation(this,'av_<?php echo $eye; ?>_<?php echo $av_key; ?>',<?php echo $aid; ?>,'<?php echo $av_label; ?>')" value="<?php echo $details['av_'.$eye.'_'.$av_key]; ?>">
                                            <?php endforeach; ?>
                                        </div>
                                        <?php endforeach; ?>
                                        <div style="margin-top:14px;">
                                            <b>TIPO DE OPTOTIPO</b>
                                            <div style="display:flex;gap:28px;margin-top:8px;color:#e23b3b;font-size:22px;font-weight:700;">
                                                <label style="text-align:center;margin:0;">N<br><input type="radio" name="av_optotipo_<?php echo $aid; ?>" value="n" <?php echo $details['av_optotipo'] == 'n' ? 'checked' : ''; ?> onchange="updateConsulta('av_optotipo',<?php echo $aid; ?>,this.value)"></label>
                                                <label style="text-align:center;margin:0;">2<br><input type="radio" name="av_optotipo_<?php echo $aid; ?>" value="2" <?php echo $details['av_optotipo'] == '2' ? 'checked' : ''; ?> onchange="updateConsulta('av_optotipo',<?php echo $aid; ?>,this.value)"></label>
                                                <label style="text-align:center;margin:0;">&#8962;<br><input type="radio" name="av_optotipo_<?php echo $aid; ?>" value="casa" <?php echo $details['av_optotipo'] == 'casa' ? 'checked' : ''; ?> onchange="updateConsulta('av_optotipo',<?php echo $aid; ?>,this.value)"></label>
                                                <label style="text-align:center;margin:0;">E<br><input type="radio" name="av_optotipo_<?php echo $aid; ?>" value="e" <?php echo $details['av_optotipo'] == 'e' ? 'checked' : ''; ?> onchange="updateConsulta('av_optotipo',<?php echo $aid; ?>,this.value)"></label>
                                            </div>
                                        </div>
                                        <div style="margin-top:12px;">
                                            <label><b>NOTAS</b></label>
                                            <div style="margin-bottom:8px;">
                                                <label style="margin-right:12px;"><input type="radio" name="av_notas_ojo_<?php echo $aid; ?>" value="od" <?php echo $details['av_notas_ojo'] == 'od' ? 'checked' : ''; ?> onchange="updateConsulta('av_notas_ojo',<?php echo $aid; ?>,this.value)"> OD</label>
                                                <label style="margin-right:12px;"><input type="radio" name="av_notas_ojo_<?php echo $aid; ?>" value="os" <?php echo $details['av_notas_ojo'] == 'os' ? 'checked' : ''; ?> onchange="updateConsulta('av_notas_ojo',<?php echo $aid; ?>,this.value)"> OS</label>
                                                <label><input type="radio" name="av_notas_ojo_<?php echo $aid; ?>" value="ou" <?php echo $details['av_notas_ojo'] == 'ou' ? 'checked' : ''; ?> onchange="updateConsulta('av_notas_ojo',<?php echo $aid; ?>,this.value)"> OU</label>
                                            </div>
                                            <div style="display:flex;gap:10px;align-items:flex-start;">
                                                <textarea class="form-control" rows="2" onchange="updateConsulta('av_notas',<?php echo $aid; ?>,this.value)"><?php echo $details['av_notas']; ?></textarea>
                                                <button type="button" class="btn btn-danger" style="min-width:120px;" onclick="updateConsulta('av_diferido',<?php echo $aid; ?>,'1'); this.innerText='Diferido';">
                                                    <?php echo $details['av_diferido'] == '1' ? 'Diferido' : 'DIFERIDO'; ?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    $seg_rows = array(
                                        array('key' => 'vias', 'label' => 'VÍAS LAGRIMALES', 'opts' => array('ok' => 'OK', 'diferido' => 'DIFERIDO', 'otro' => 'OTRO')),
                                        array('key' => 'parpados', 'label' => 'PÁRPADOS Y PESTAÑAS', 'opts' => array('ok' => 'OK', 'diferido' => 'DIFERIDO', 'otro' => 'OTRO')),
                                        array('key' => 'conjuntiva', 'label' => 'CONJUNTIVA', 'opts' => array('ok' => 'OK', 'diferido' => 'DIFERIDO', 'otro' => 'OTRO')),
                                        array('key' => 'esclera', 'label' => 'ESCLERA', 'opts' => array('ok' => 'OK', 'diferido' => 'DIFERIDO', 'otro' => 'OTRO')),
                                        array('key' => 'cornea', 'label' => 'CÓRNEA', 'opts' => array('ok' => 'OK', 'diferido' => 'DIFERIDO', 'otro' => 'OTRO')),
                                        array('key' => 'camara', 'label' => 'CÁMARA ANTERIOR', 'opts' => array('profunda' => 'PROFUNDA', 'estrecha' => 'ESTRECHA', 'otro' => 'OTRO')),
                                        array('key' => 'iris', 'label' => 'IRIS', 'opts' => array('ok' => 'OK', 'diferido' => 'DIFERIDO', 'otro' => 'OTRO')),
                                        array('key' => 'pupila', 'label' => 'PUPILA', 'opts' => array('ok' => 'OK', 'diferido' => 'DIFERIDO', 'otro' => 'OTRO')),
                                        array('key' => 'cristalino', 'label' => 'CRISTALINO', 'opts' => array('ok' => 'OK', 'diferido' => 'DIFERIDO', 'otro' => 'OTRO'))
                                    );
                                ?>
                                <div class="col-sm-12">
                                    <div class="form-group" style="border:1px solid #e6e8ee;border-radius:8px;padding:12px;">
                                        <b>Lámpara de hendidura</b>
                                        <div class="row" style="margin-top:8px;">
                                            <?php foreach (array('od' => 'OD', 'os' => 'OS') as $eye => $eye_label): ?>
                                            <div class="col-sm-6">
                                                <div style="font-weight:700;border-bottom:1px solid #e6e8ee;margin-bottom:8px;"><?php echo $eye_label; ?></div>
                                                <?php foreach ($seg_rows as $seg): ?>
                                                <?php
                                                    $seg_current = $details['seg_'.$seg['key'].'_'.$eye];
                                                    if ($seg_current == '') {
                                                        $seg_current = ($seg['key'] == 'camara') ? 'profunda' : 'ok';
                                                    }
                                                ?>
                                                <div style="margin-bottom:8px;">
                                                    <div style="display:flex;justify-content:space-between;gap:8px;align-items:center;">
                                                        <span style="font-size:12px;letter-spacing:.3px;"><?php echo $seg['label']; ?></span>
                                                        <span style="white-space:nowrap;">
                                                            <?php foreach ($seg['opts'] as $opt_val => $opt_label): ?>
                                                            <label style="margin:0 8px 0 0;font-weight:400;color:#047bf8;">
                                                                <input type="radio" name="seg_<?php echo $seg['key']; ?>_<?php echo $eye; ?>_<?php echo $aid; ?>" value="<?php echo $opt_val; ?>" <?php echo $seg_current == $opt_val ? 'checked' : ''; ?> onchange="updateConsulta('seg_<?php echo $seg['key']; ?>_<?php echo $eye; ?>',<?php echo $aid; ?>,this.value); document.getElementById('seg_nota_<?php echo $seg['key']; ?>_<?php echo $eye; ?>_<?php echo $aid; ?>').style.display = this.value == 'otro' ? 'block' : 'none';">
                                                                <?php echo $opt_label; ?>
                                                            </label>
                                                            <?php endforeach; ?>
                                                        </span>
                                                    </div>
                                                    <input id="seg_nota_<?php echo $seg['key']; ?>_<?php echo $eye; ?>_<?php echo $aid; ?>" class="form-control" placeholder="Nota" style="margin-top:4px;<?php echo $seg_current == 'otro' ? '' : 'display:none;'; ?>" onchange="updateConsulta('seg_<?php echo $seg['key']; ?>_<?php echo $eye; ?>_nota',<?php echo $aid; ?>,this.value)" value="<?php echo htmlspecialchars($details['seg_'.$seg['key'].'_'.$eye.'_nota']); ?>">
                                                </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <b>Exploración oftalmológica:</b>
                                        <div class="row" style="margin-top:8px;">
                                            <div class="col-sm-7">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" style="margin-bottom:10px;">
                                                        <thead>
                                                            <tr>
                                                                <th>LH</th>
                                                                <th>OD</th>
                                                                <th>OS</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Vías lagrimales</td>
                                                                <td><input class="form-control" onchange="updateConsulta('oft_vias_lagrimales_od',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['oft_vias_lagrimales_od'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('oft_vias_lagrimales_os',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['oft_vias_lagrimales_os'];?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Párpados y pestañas</td>
                                                                <td><input class="form-control" onchange="updateConsulta('oft_parpados_pestanas_od',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['oft_parpados_pestanas_od'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('oft_parpados_pestanas_os',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['oft_parpados_pestanas_os'];?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Conjuntiva</td>
                                                                <td><input class="form-control" onchange="updateConsulta('oft_conjuntiva_od',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['oft_conjuntiva_od'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('oft_conjuntiva_os',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['oft_conjuntiva_os'];?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Esclera y córnea</td>
                                                                <td><input class="form-control" onchange="updateConsulta('oft_esclera_cornea_od',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['oft_esclera_cornea_od'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('oft_esclera_cornea_os',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['oft_esclera_cornea_os'];?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Cámara anterior</td>
                                                                <td><input class="form-control" onchange="updateConsulta('oft_camara_anterior_od',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['oft_camara_anterior_od'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('oft_camara_anterior_os',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['oft_camara_anterior_os'];?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Iris</td>
                                                                <td><input class="form-control" onchange="updateConsulta('oft_iris_od',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['oft_iris_od'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('oft_iris_os',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['oft_iris_os'];?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Cristalino</td>
                                                                <td><input class="form-control" onchange="updateConsulta('oft_cristalino_od',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['oft_cristalino_od'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('oft_cristalino_os',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['oft_cristalino_os'];?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Gonioscopia</td>
                                                                <td><input class="form-control" onchange="updateConsulta('oft_gonioscopia_od',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['oft_gonioscopia_od'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('oft_gonioscopia_os',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['oft_gonioscopia_os'];?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Vítreo</td>
                                                                <td><input class="form-control" onchange="updateConsulta('oft_vitreo_od',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['oft_vitreo_od'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('oft_vitreo_os',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['oft_vitreo_os'];?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Nervio óptico</td>
                                                                <td><input class="form-control" onchange="updateConsulta('oft_nervio_optico_od',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['oft_nervio_optico_od'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('oft_nervio_optico_os',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['oft_nervio_optico_os'];?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Retina p. post</td>
                                                                <td><input class="form-control" onchange="updateConsulta('oft_retina_p_post_od',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['oft_retina_p_post_od'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('oft_retina_p_post_os',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['oft_retina_p_post_os'];?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Retina periférica</td>
                                                                <td><input class="form-control" onchange="updateConsulta('oft_retina_periferica_od',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['oft_retina_periferica_od'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('oft_retina_periferica_os',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['oft_retina_periferica_os'];?>"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label><b>IC:</b></label>
                                                        <textarea class="form-control" rows="2" onchange="updateConsulta('oft_ic',<?php echo $details['appointment_id'] ?>,this.value)"><?php echo $details['oft_ic'];?></textarea>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label><b>Tx:</b></label>
                                                        <textarea class="form-control" rows="2" onchange="updateConsulta('oft_tx',<?php echo $details['appointment_id'] ?>,this.value)"><?php echo $details['oft_tx'];?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" style="margin-bottom:0;">
                                                        <thead>
                                                            <tr>
                                                                <th style="width:130px;">Ref.</th>
                                                                <th style="width:45px;">Ojo</th>
                                                                <th>Esf</th>
                                                                <th>Cil</th>
                                                                <th>Eje</th>
                                                                <th>Add</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td rowspan="2"><b>Lensometría</b></td>
                                                                <td>OD</td>
                                                                <td><input class="form-control" onchange="updateConsulta('lens_od_esf',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['lens_od_esf'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('lens_od_cil',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['lens_od_cil'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('lens_od_eje',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['lens_od_eje'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('lens_od_add',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['lens_od_add'];?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>OS</td>
                                                                <td><input class="form-control" onchange="updateConsulta('lens_os_esf',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['lens_os_esf'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('lens_os_cil',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['lens_os_cil'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('lens_os_eje',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['lens_os_eje'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('lens_os_add',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['lens_os_add'];?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td rowspan="2"><b>Ref. Objetiva</b></td>
                                                                <td>OD</td>
                                                                <td><input class="form-control" onchange="updateConsulta('ro_od_esf',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['ro_od_esf'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('ro_od_cil',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['ro_od_cil'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('ro_od_eje',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['ro_od_eje'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('ro_od_add',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['ro_od_add'];?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>OS</td>
                                                                <td><input class="form-control" onchange="updateConsulta('ro_os_esf',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['ro_os_esf'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('ro_os_cil',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['ro_os_cil'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('ro_os_eje',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['ro_os_eje'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('ro_os_add',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['ro_os_add'];?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td rowspan="2"><b>Ref. Subjetiva</b></td>
                                                                <td>OD</td>
                                                                <td><input class="form-control" onchange="updateConsulta('rs_od_esf',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['rs_od_esf'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('rs_od_cil',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['rs_od_cil'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('rs_od_eje',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['rs_od_eje'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('rs_od_add',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['rs_od_add'];?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>OS</td>
                                                                <td><input class="form-control" onchange="updateConsulta('rs_os_esf',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['rs_os_esf'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('rs_os_cil',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['rs_os_cil'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('rs_os_eje',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['rs_os_eje'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('rs_os_add',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['rs_os_add'];?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td rowspan="2"><b>Ref. Final</b></td>
                                                                <td>OD</td>
                                                                <td><input class="form-control" onchange="updateConsulta('rf_od_esf',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['rf_od_esf'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('rf_od_cil',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['rf_od_cil'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('rf_od_eje',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['rf_od_eje'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('rf_od_add',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['rf_od_add'];?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>OS</td>
                                                                <td><input class="form-control" onchange="updateConsulta('rf_os_esf',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['rf_os_esf'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('rf_os_cil',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['rf_os_cil'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('rf_os_eje',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['rf_os_eje'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('rf_os_add',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['rf_os_add'];?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td rowspan="2"><b>Ref. Cicloplégica</b></td>
                                                                <td>OD</td>
                                                                <td><input class="form-control" onchange="updateConsulta('rc_od_esf',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['rc_od_esf'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('rc_od_cil',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['rc_od_cil'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('rc_od_eje',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['rc_od_eje'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('rc_od_add',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['rc_od_add'];?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>OS</td>
                                                                <td><input class="form-control" onchange="updateConsulta('rc_os_esf',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['rc_os_esf'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('rc_os_cil',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['rc_os_cil'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('rc_os_eje',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['rc_os_eje'];?>"></td>
                                                                <td><input class="form-control" onchange="updateConsulta('rc_os_add',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['rc_os_add'];?>"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <b>Esquema gráfico ocular:</b>
                                        <p style="margin:6px 0 10px 0; color:#6a7180;">Dibuja sobre cada esquema. Se guarda automáticamente al soltar el mouse o el dedo.</p>
                                        <div class="row">
                                            <div class="col-sm-6 col-md-3">
                                                <label><b>O.D.</b></label>
                                                <canvas id="graf_od_externo_<?php echo $details['appointment_id']; ?>" width="240" height="150" style="width:100%; border:1px solid #c6c6cc; border-radius:8px; background:#fff; touch-action:none;"></canvas>
                                                <a class="btn btn-default btn-sm" style="margin-top:6px;" href="javascript:void(0);" onclick="clearOcularCanvas('graf_od_externo_<?php echo $details['appointment_id']; ?>','graf_od_externo',<?php echo $details['appointment_id']; ?>,'eye')">Limpiar</a>
                                            </div>
                                            <div class="col-sm-6 col-md-3">
                                                <label><b>O.S.</b></label>
                                                <canvas id="graf_os_externo_<?php echo $details['appointment_id']; ?>" width="240" height="150" style="width:100%; border:1px solid #c6c6cc; border-radius:8px; background:#fff; touch-action:none;"></canvas>
                                                <a class="btn btn-default btn-sm" style="margin-top:6px;" href="javascript:void(0);" onclick="clearOcularCanvas('graf_os_externo_<?php echo $details['appointment_id']; ?>','graf_os_externo',<?php echo $details['appointment_id']; ?>,'eye')">Limpiar</a>
                                            </div>
                                            <div class="col-sm-6 col-md-3">
                                                <label><b>O.D. (fondo)</b></label>
                                                <canvas id="graf_od_fondo_<?php echo $details['appointment_id']; ?>" width="240" height="150" style="width:100%; border:1px solid #c6c6cc; border-radius:8px; background:#fff; touch-action:none;"></canvas>
                                                <a class="btn btn-default btn-sm" style="margin-top:6px;" href="javascript:void(0);" onclick="clearOcularCanvas('graf_od_fondo_<?php echo $details['appointment_id']; ?>','graf_od_fondo',<?php echo $details['appointment_id']; ?>,'retina')">Limpiar</a>
                                            </div>
                                            <div class="col-sm-6 col-md-3">
                                                <label><b>O.S. (fondo)</b></label>
                                                <canvas id="graf_os_fondo_<?php echo $details['appointment_id']; ?>" width="240" height="150" style="width:100%; border:1px solid #c6c6cc; border-radius:8px; background:#fff; touch-action:none;"></canvas>
                                                <a class="btn btn-default btn-sm" style="margin-top:6px;" href="javascript:void(0);" onclick="clearOcularCanvas('graf_os_fondo_<?php echo $details['appointment_id']; ?>','graf_os_fondo',<?php echo $details['appointment_id']; ?>,'retina')">Limpiar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                (function() {
                                    if (typeof window.setupOcularCanvas !== 'function') {
                                        window.ocularCanvasRegistry = {};
                                        window.drawOcularTemplate = function(ctx, type, width, height) {
                                            ctx.clearRect(0, 0, width, height);
                                            ctx.fillStyle = '#ffffff';
                                            ctx.fillRect(0, 0, width, height);
                                            ctx.strokeStyle = '#1f1f1f';
                                            ctx.lineWidth = 2;
                                            if (type === 'eye') {
                                                ctx.beginPath();
                                                ctx.moveTo(15, height / 2);
                                                ctx.quadraticCurveTo(width / 2, 10, width - 15, height / 2);
                                                ctx.quadraticCurveTo(width / 2, height - 10, 15, height / 2);
                                                ctx.stroke();
                                                ctx.beginPath();
                                                ctx.arc(width / 2, height / 2, 40, 0, Math.PI * 2);
                                                ctx.stroke();
                                                ctx.beginPath();
                                                ctx.arc(width / 2, height / 2, 12, 0, Math.PI * 2);
                                                ctx.fillStyle = '#1f1f1f';
                                                ctx.fill();
                                            } else {
                                                ctx.beginPath();
                                                ctx.arc(width / 2, height / 2, 55, 0, Math.PI * 2);
                                                ctx.stroke();
                                                ctx.beginPath();
                                                ctx.arc(width / 2, height / 2, 10, 0, Math.PI * 2);
                                                ctx.stroke();
                                                ctx.beginPath();
                                                ctx.moveTo(width / 2 - 50, height / 2 - 35);
                                                ctx.bezierCurveTo(width / 2 + 10, height / 2 - 55, width / 2 + 20, height / 2 + 15, width / 2 - 45, height / 2 + 35);
                                                ctx.stroke();
                                                ctx.beginPath();
                                                ctx.moveTo(width / 2 + 50, height / 2 - 35);
                                                ctx.bezierCurveTo(width / 2 - 10, height / 2 - 55, width / 2 - 20, height / 2 + 15, width / 2 + 45, height / 2 + 35);
                                                ctx.stroke();
                                            }
                                        };
                                        window.setupOcularCanvas = function(cfg) {
                                            var canvas = document.getElementById(cfg.id);
                                            if (!canvas || canvas.dataset.ready === '1') {
                                                return;
                                            }
                                            canvas.dataset.ready = '1';
                                            var ctx = canvas.getContext('2d');
                                            var drawing = false;
                                            var width = canvas.width;
                                            var height = canvas.height;
                                            var getPos = function(e) {
                                                var rect = canvas.getBoundingClientRect();
                                                if (e.touches && e.touches[0]) {
                                                    return { x: e.touches[0].clientX - rect.left, y: e.touches[0].clientY - rect.top };
                                                }
                                                return { x: e.clientX - rect.left, y: e.clientY - rect.top };
                                            };
                                            var saveCanvas = function() {
                                                updateConsulta(cfg.field, cfg.appId, canvas.toDataURL('image/png'));
                                            };
                                            var begin = function(e) {
                                                drawing = true;
                                                var p = getPos(e);
                                                ctx.beginPath();
                                                ctx.moveTo(p.x, p.y);
                                                e.preventDefault();
                                            };
                                            var draw = function(e) {
                                                if (!drawing) return;
                                                var p = getPos(e);
                                                ctx.lineWidth = 2;
                                                ctx.strokeStyle = '#121212';
                                                ctx.lineTo(p.x, p.y);
                                                ctx.stroke();
                                                e.preventDefault();
                                            };
                                            var end = function(e) {
                                                if (!drawing) return;
                                                drawing = false;
                                                ctx.closePath();
                                                saveCanvas();
                                                if (e) e.preventDefault();
                                            };
                                            canvas.addEventListener('mousedown', begin);
                                            canvas.addEventListener('mousemove', draw);
                                            canvas.addEventListener('mouseup', end);
                                            canvas.addEventListener('mouseleave', end);
                                            canvas.addEventListener('touchstart', begin, { passive: false });
                                            canvas.addEventListener('touchmove', draw, { passive: false });
                                            canvas.addEventListener('touchend', end, { passive: false });
                                            if (cfg.value) {
                                                var img = new Image();
                                                img.onload = function() {
                                                    ctx.clearRect(0, 0, width, height);
                                                    ctx.drawImage(img, 0, 0, width, height);
                                                };
                                                img.src = cfg.value;
                                            } else {
                                                window.drawOcularTemplate(ctx, cfg.template, width, height);
                                            }
                                            window.ocularCanvasRegistry[cfg.id] = {
                                                ctx: ctx,
                                                template: cfg.template,
                                                width: width,
                                                height: height,
                                                field: cfg.field,
                                                appId: cfg.appId
                                            };
                                        };
                                        window.clearOcularCanvas = function(id, field, appId, template) {
                                            var item = window.ocularCanvasRegistry[id];
                                            if (item) {
                                                window.drawOcularTemplate(item.ctx, item.template, item.width, item.height);
                                            } else {
                                                var canvas = document.getElementById(id);
                                                if (canvas) {
                                                    var ctx = canvas.getContext('2d');
                                                    window.drawOcularTemplate(ctx, template, canvas.width, canvas.height);
                                                }
                                            }
                                            updateConsulta(field, appId, '');
                                        };
                                    }
                                    window.setupOcularCanvas({
                                        id: 'graf_od_externo_<?php echo $details['appointment_id']; ?>',
                                        field: 'graf_od_externo',
                                        appId: <?php echo $details['appointment_id']; ?>,
                                        template: 'eye',
                                        value: <?php echo json_encode($details['graf_od_externo']); ?>
                                    });
                                    window.setupOcularCanvas({
                                        id: 'graf_os_externo_<?php echo $details['appointment_id']; ?>',
                                        field: 'graf_os_externo',
                                        appId: <?php echo $details['appointment_id']; ?>,
                                        template: 'eye',
                                        value: <?php echo json_encode($details['graf_os_externo']); ?>
                                    });
                                    window.setupOcularCanvas({
                                        id: 'graf_od_fondo_<?php echo $details['appointment_id']; ?>',
                                        field: 'graf_od_fondo',
                                        appId: <?php echo $details['appointment_id']; ?>,
                                        template: 'retina',
                                        value: <?php echo json_encode($details['graf_od_fondo']); ?>
                                    });
                                    window.setupOcularCanvas({
                                        id: 'graf_os_fondo_<?php echo $details['appointment_id']; ?>',
                                        field: 'graf_os_fondo',
                                        appId: <?php echo $details['appointment_id']; ?>,
                                        template: 'retina',
                                        value: <?php echo json_encode($details['graf_os_fondo']); ?>
                                    });
                                })();
                                </script>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <b>Tratamiento:</b>
                                        <textarea cols="80" class="form-control" name="ckplan" rows="5" onchange="updateConsulta('tx',<?php echo $details['appointment_id'] ?>,this.value)"><?php   echo $details['tx']?></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <b>Impresión clinica:</b>
                                        <textarea cols="80" class="form-control" name="ckplan" rows="5" onchange="updateConsulta('ic',<?php echo $details['appointment_id'] ?>,this.value)"><?php   echo $details['ic']?> </textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <b>Plan:</b>
                                        <input cols="80" class="form-control" name="ckplan" rows="1" onchange="updateConsulta('plan',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php   echo $details['plan']?>">
                                        </input>
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                        <div class="card-widget" style="border: 1px solid #c6c6cc;">
                            <h5 class="panel-content-title">Detalles de la cita</h5>
                            <span class="app-divider2"></span>
                            <div class="row">
                                <a class="btn btn-success" target="_blank" href="<?php echo base_url();?>doctor/print_dictamen_details/<?php echo $details['appointment_id'];?>">Imprimir
                                        Historia clínica</a>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <b>Historia clínica:</b>
                                        <textarea cols="80" class="form-control" name="dictamen" id="ckeditor25" rows="25" ><?php  echo $details['dictamen']; ?></textarea>
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>

                        <?php if ($this->crud_model->check_item('signs') == 1): ?>
                        <div class="card-widget" style="border: 1px solid #c6c6cc;">
                            <h5 class="panel-content-title">Sígnos vitales</h5>
                            <span class="app-divider2"></span>
                            <div class="row">
                                <?php include 'vital.php';?>
                            </div>
                        </div>
                        <?php endif;  ?>
                        <div class="card-widget" style="border: 1px solid #c6c6cc;">
                            <h5 class="panel-content-title">Receta</h5>
                            <span class="app-divider2"></span>
                            <?php $rxid = $details['appointment_id']; $rx_contacto = $details['rx_contacto'] == '' ? 'escleral' : $details['rx_contacto']; ?>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label>COMENTARIO</label>
                                    <textarea class="form-control" rows="2" onchange="updateConsulta('rx_comentario',<?php echo $rxid; ?>,this.value)"><?php echo $details['rx_comentario']; ?></textarea>
                                </div>
                                <div class="col-sm-12" style="margin-top:12px;overflow-x:auto;">
                                    <table class="table table-bordered" style="margin-bottom:0;">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th>ESFERA</th>
                                                <th>CILINDRO</th>
                                                <th>EJE</th>
                                                <th>PRISMA</th>
                                                <th>BASE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach (array('final' => 'FINAL', 'add' => 'ADICIÓN') as $rx_group => $rx_group_label): ?>
                                            <?php foreach (array('od' => 'OD', 'os' => 'OS') as $rx_eye => $rx_eye_label): ?>
                                            <tr>
                                                <?php if ($rx_eye == 'od'): ?><td rowspan="2"><b><?php echo $rx_group_label; ?></b></td><?php endif; ?>
                                                <td><?php echo $rx_eye_label; ?></td>
                                                <?php foreach (array('esf' => 'esf', 'cil' => 'cil', 'eje' => 'eje', 'prisma' => 'prisma', 'base' => 'base') as $rx_part): ?>
                                                <td><input class="form-control" onchange="updateConsulta('rx_<?php echo $rx_group; ?>_<?php echo $rx_eye; ?>_<?php echo $rx_part; ?>',<?php echo $rxid; ?>,this.value)" value="<?php echo $details['rx_'.$rx_group.'_'.$rx_eye.'_'.$rx_part]; ?>"></td>
                                                <?php endforeach; ?>
                                            </tr>
                                            <?php endforeach; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-12" style="margin-top:12px;">
                                    <b>AUTOREFRACTÓMETRO</b>
                                    <div style="margin-top:6px;">DIP <input class="form-control" style="display:inline-block;width:140px;margin-left:8px;" onchange="updateConsulta('rx_dip',<?php echo $rxid; ?>,this.value)" value="<?php echo $details['rx_dip']; ?>"></div>
                                </div>
                                <div class="col-sm-6" style="margin-top:12px;">
                                    <b>TIPO DE LENTE</b>
                                    <div><label><input type="checkbox" <?php echo $details['rx_lente_monofocal'] == '1' ? 'checked' : ''; ?> onchange="updateConsulta('rx_lente_monofocal',<?php echo $rxid; ?>,this.checked ? '1' : '0')"> MONOFOCAL</label></div>
                                    <div><label><input type="checkbox" <?php echo $details['rx_lente_progresivo'] == '1' ? 'checked' : ''; ?> onchange="updateConsulta('rx_lente_progresivo',<?php echo $rxid; ?>,this.checked ? '1' : '0')"> PROGRESIVO</label></div>
                                    <div><label><input type="checkbox" <?php echo $details['rx_lente_bifocal'] == '1' ? 'checked' : ''; ?> onchange="updateConsulta('rx_lente_bifocal',<?php echo $rxid; ?>,this.checked ? '1' : '0')"> BIFOCAL</label></div>
                                    <div><label><input type="checkbox" <?php echo $details['rx_lente_otro'] == '1' ? 'checked' : ''; ?> onchange="updateConsulta('rx_lente_otro',<?php echo $rxid; ?>,this.checked ? '1' : '0')"> OTRO</label></div>
                                </div>
                                <div class="col-sm-6" style="margin-top:12px;">
                                    <b>RECOMENDACIÓN</b>
                                    <div><label><input type="checkbox" <?php echo $details['rx_rec_filtro'] == '1' ? 'checked' : ''; ?> onchange="updateConsulta('rx_rec_filtro',<?php echo $rxid; ?>,this.checked ? '1' : '0')"> FILTRO DE LUZ AZUL</label></div>
                                    <div><label><input type="checkbox" <?php echo $details['rx_rec_antireflejo'] == '1' ? 'checked' : ''; ?> onchange="updateConsulta('rx_rec_antireflejo',<?php echo $rxid; ?>,this.checked ? '1' : '0')"> ANTIREFLEJO</label></div>
                                    <div style="display:flex;gap:8px;align-items:center;margin-bottom:6px;"><label style="margin:0;"><input type="checkbox" <?php echo $details['rx_rec_polarizado'] == '1' ? 'checked' : ''; ?> onchange="updateConsulta('rx_rec_polarizado',<?php echo $rxid; ?>,this.checked ? '1' : '0')"> POLARIZADO</label><input class="form-control" style="width:140px;" onchange="updateConsulta('rx_rec_polarizado_nota',<?php echo $rxid; ?>,this.value)" value="<?php echo $details['rx_rec_polarizado_nota']; ?>"></div>
                                    <div><label><input type="checkbox" <?php echo $details['rx_rec_policarbonato'] == '1' ? 'checked' : ''; ?> onchange="updateConsulta('rx_rec_policarbonato',<?php echo $rxid; ?>,this.checked ? '1' : '0')"> POLICARBONATO</label></div>
                                    <div><label><input type="checkbox" <?php echo $details['rx_rec_sol'] == '1' ? 'checked' : ''; ?> onchange="updateConsulta('rx_rec_sol',<?php echo $rxid; ?>,this.checked ? '1' : '0')"> LENTES DE SOL</label></div>
                                    <div style="display:flex;gap:8px;align-items:center;margin-bottom:6px;"><label style="margin:0;"><input type="checkbox" <?php echo $details['rx_rec_tenido'] == '1' ? 'checked' : ''; ?> onchange="updateConsulta('rx_rec_tenido',<?php echo $rxid; ?>,this.checked ? '1' : '0')"> TEÑIDO</label><input class="form-control" style="width:140px;" onchange="updateConsulta('rx_rec_tenido_nota',<?php echo $rxid; ?>,this.value)" value="<?php echo $details['rx_rec_tenido_nota']; ?>"></div>
                                    <div style="display:flex;gap:8px;align-items:center;margin-bottom:6px;"><label style="margin:0;"><input type="checkbox" <?php echo $details['rx_rec_transitions'] == '1' ? 'checked' : ''; ?> onchange="updateConsulta('rx_rec_transitions',<?php echo $rxid; ?>,this.checked ? '1' : '0')"> TRANSITIONS</label><input class="form-control" style="width:140px;" onchange="updateConsulta('rx_rec_transitions_nota',<?php echo $rxid; ?>,this.value)" value="<?php echo $details['rx_rec_transitions_nota']; ?>"></div>
                                    <div><label><input type="checkbox" <?php echo $details['rx_rec_otros'] == '1' ? 'checked' : ''; ?> onchange="updateConsulta('rx_rec_otros',<?php echo $rxid; ?>,this.checked ? '1' : '0')"> OTROS</label></div>
                                </div>
                                <div class="col-sm-12" style="margin-top:12px;">
                                    <b>FINAL EN LENTE DE CONTACTO ESCLERAL O RÍGIDO</b>
                                    <div>
                                        <label style="margin-right:16px;"><input type="radio" name="rx_contacto_<?php echo $rxid; ?>" value="escleral" <?php echo $rx_contacto == 'escleral' ? 'checked' : ''; ?> onchange="updateConsulta('rx_contacto',<?php echo $rxid; ?>,this.value)"> ESCLERAL</label>
                                        <label><input type="radio" name="rx_contacto_<?php echo $rxid; ?>" value="rigido" <?php echo $rx_contacto == 'rigido' ? 'checked' : ''; ?> onchange="updateConsulta('rx_contacto',<?php echo $rxid; ?>,this.value)"> RÍGIDO</label>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <hr>
                                    <a class="btn btn-success" target="_blank" href="<?php echo base_url();?>doctor/print_prescription_details/<?php echo $details['appointment_id'];?>">Imprimir receta</a>
                                </div>
                            </div>
                        </div>
                        <?php if ($this->crud_model->check_item('nutri') == 1000): ?>
                        <div class="card-widget" style="border: 1px solid #c6c6cc;">
                            <h5 class="panel-content-title">Seguimiento nutriológico</h5>
                            <span class="app-divider2"></span>
                            <div class="row">
                                <?php include 'nutriology.php';?>
                            </div>
                        </div>
                        <?php endif;?>
                        <?php if ($this->crud_model->check_item('cetosis') == 1000): ?>
                        <div class="card-widget" style="border: 1px solid #c6c6cc;">
                            <h5 class="panel-content-title">Cetosis</h5>
                            <span class="app-divider2"></span>
                            <div class="row">
                                <?php include 'cetosis.php';?>
                            </div>
                        </div>
                        <?php endif;?>
                        <div id="resumen">
                            <div class="card-widget" style="border: 1px solid #c6c6cc;">
                                <h4 class="panel-content-title">Resumen</h4>
                                <span class="app-divider2"></span>
                                <div class="row">
                                    <div class="col-sm-7">
                                        <span style="text-align:left"><b>Práctica:</b> </span>
                                    </div>
                                    <div class="col-sm-5">
                                        <span style="float:left"><b>Cargos:</b></span>
                                    </div>
                                    <div class="col-sm-7">
                                        <span style="float:left">
                                            <?php if ($details['practice'] > 0): ?>
                                            <?php echo $this->db->get_where('service', array( 'service_id' => $details['practice']))->row()->name;?>
                                            <?php else: ?>
                                            Otros servicios.
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                    <div class="col-sm-5">
                                        <span style="float:left">
                                            <?php
                                            $su=0;
                                            if($details['status']!= 4 && $details['status'] != 10 ):
                                            if ($details['practice'] > 0): ?>
                                            <input type="number" class="form-control monto" style="width: 150px; margin-right:0;" value="<?php echo $su = $this->db->get_where('service', array( 'service_id' => $details['practice']))->row()->cost; ?>" onkeyup="change_amout(this.value, <?php echo $details['appointment_id']?>)" onchange="change_amout(this.value, <?php echo $details['appointment_id']?>)" <?php echo $details['status']== 1? '' : 'disabled' ;?> /><br>
                                            <?php else: ?>
                                            <input type="number" class="form-control monto" style="width: 150px; margin-right:0;" value="0" onkeyup="change_amout(this.value, <?php echo $details['appointment_id']?>)" onchange="change_amout(this.value, <?php echo $details['appointment_id']?>)" <?php echo $details['status']== 1? '' : 'disabled' ;?> /><br>
                                            <?php endif; 
                                            else: ?>
                                            <input type="number" class="form-control monto" style="width: 150px; margin-right:0;" value="<?php echo $details['charges'] ?>" onkeyup="change_amout(this.value, <?php echo $details['appointment_id']?>)" onchange="change_amout(this.value,<?php echo $details['appointment_id']?>)" disabled /><br>
                                            <?php endif;?>
                                        </span>
                                    </div>
                                    <div class="col-sm-12">
                                        <span style="background: #fafbfe; padding: 15px; border: 2px dotted #748be6; border-radius: 15px; display: block; font-size: 25px; font-weight: 700; width: 100%; font-family: 'Quicksand';">
                                            Total:
                                            <?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;?>.
                                            <input id="totalGeneral_<?php echo $details['appointment_id']?>" type="hidden" name="total_appointment" value="<?php echo $details['charges'] == ""? $this->db->get_where('service', array( 'service_id' => $details['practice']))->row()->cost:$details['charges']; ?>">
                                            <span id="total_text_<?php echo $details['appointment_id']?>">
                                                <?php echo $details['charges'] == ""? $su:$details['charges'];?>
                                            </span>
                                        </span>
                                        <hr>
                                        <?php if($details['status']==1):?>
                                        <button class="btn btn-primary" style="width:30%; float:right">
                                            Finalizar cita
                                        </button>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                </form>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url();?>public/assets/search/bootstrap3-typeahead.js"></script>
<?php if($det['practice']==21):?>
<script src="https://meet.jit.si/external_api.js"></script>
<script>
var domain = "meet.jit.si";
var options = {
    disableDeepLinking: true,
    userInfo: {
        email: '<?php echo $this->db->get_where('admin',array('admin_id'=>$det['doctor_id']))->row()->email;?>',
        displayName: ' <?php echo $this->accounts_model->get_name('admin', $det['doctor_id']);?>',
        moderator: true,
    },
    roomName: "<?php echo base64_encode("Consulta_".$det['date'].$appointment_id);?>",
    width: "100%",
    height: "100%",
    parentNode: document.querySelector('#teleconsulta'),
    interfaceConfigOverwrite: {
        DISABLE_DOMINANT_SPEAKER_INDICATOR: true,
        SHOW_BRAND_WATERMARK: false,
        SHOW_JITSI_WATERMARK: false,
        SHOW_WATERMARK_FOR_GUESTS: false,
        DEFAULT_BACKGROUND: '<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->theme?>',
        DEFAULT_LOGO_URL: 'https://medicaby.com/resources/app-logo/logo.svg',
    },
}
var api = new JitsiMeetExternalAPI(domain, options);
api.executeCommand('subject', 'test');
</script>
<?php endif;?>
<script src="<?php echo base_url();?>public/assets/appointments/js/appointments_details.js"></script>
<?php endforeach; ?>

<div id="avNotationModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:9999;">
    <div style="background:#fff;width:640px;max-width:94%;max-height:90vh;overflow:auto;margin:4vh auto;border-radius:8px;padding:16px;">
        <div style="display:flex;justify-content:space-between;align-items:center;">
            <b id="avNotationTitle">AVL SC</b>
            <a href="javascript:void(0);" onclick="$('#avNotationModal').hide();" style="font-size:22px;text-decoration:none;color:#333;">&times;</a>
        </div>
        <div style="margin-top:10px;font-size:12px;color:#8b93a7;">NOTACIONES EQUIVALENTES</div>
        <div style="display:flex;flex-wrap:wrap;gap:12px;align-items:center;margin:8px 0 12px;">
            <label style="margin:0;"><input type="radio" name="av_notation_pick" value="(NPL)"> (NPL)</label>
            <label style="margin:0;"><input type="radio" name="av_notation_pick" value="(PL)"> (PL)</label>
            <label style="margin:0;"><input type="radio" name="av_notation_pick" value="(MM)"> (MM)</label>
            <input id="av_custom_value" type="text" class="form-control" style="width:90px;" placeholder="+">
            <label style="margin:0;"><input type="radio" name="av_notation_pick" value="(FSM)"> (FSM)</label>
            <button type="button" class="btn btn-primary btn-sm" onclick="acceptAvNotation()">Aceptar</button>
        </div>
        <div style="overflow:auto;">
            <table class="table table-bordered" style="font-size:13px;margin-bottom:10px;">
                <thead>
                    <tr>
                        <th>DECIMAL</th>
                        <th>US</th>
                        <th>CC</th>
                        <th>(MM)</th>
                        <th>20/200</th>
                        <th>JAEGER</th>
                    </tr>
                </thead>
                <tbody id="avNotationBody"></tbody>
            </table>
        </div>
        <div style="display:flex;justify-content:space-between;">
            <button type="button" class="btn btn-default" onclick="clearAvNotation()">LIMPIAR</button>
            <div>
                <button type="button" class="btn btn-default" onclick="$('#avNotationModal').hide();">CANCELAR</button>
                <button type="button" class="btn btn-primary" onclick="acceptAvNotation()">ACEPTAR</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.0.0-beta.11/chart.js"></script>
<script>
  $('form').on('keydown', function(event) {
        if (event.which === 13) {
            event.preventDefault();
            return false;
        }
    });
    

function showGraphics() {
    $('#graphics').toggle();
}

var avNotationTarget = null;
var avNotationRows = [
    ['0.05', '20/400', '6/120', '0.05', '20/400', 'J16'],
    ['0.1', '20/200', '6/60', '0.1', '20/200', 'J10'],
    ['0.12', '20/160', '6/48', '0.12', '20/160', ''],
    ['0.16', '20/125', '6/36', '0.16', '20/125', 'J7'],
    ['0.2', '20/100', '6/30', '0.2', '20/100', 'J6'],
    ['0.25', '20/80', '6/24', '0.25', '20/80', 'J5'],
    ['0.3', '20/70', '6/21', '0.3', '20/60', ''],
    ['0.4', '20/50', '6/15', '0.4', '20/50', 'J3'],
    ['0.5', '20/40', '6/12', '0.5', '20/40', 'J2'],
    ['0.6', '20/30', '6/9', '0.62', '20/30', 'J1'],
    ['0.7', '20/25', '6/8', '0.75', '20/25', ''],
    ['0.8', '20/25', '6/7.5', '0.8', '20/25', 'J1+'],
    ['0.9', '20/22', '6/6.7', '0.9', '20/22', ''],
    ['1.0', '20/20', '6/6', '1', '20/20', ''],
    ['1.2', '20/15', '6/5', '1.25', '20/15', ''],
    ['1.5', '20/13', '6/4', '1.5', '20/13', ''],
    ['2.0', '20/10', '6/3', '2', '20/10', '']
];

function openAvNotation(el, field, appId, title) {
    avNotationTarget = { el: el, field: field, appId: appId };
    $('#avNotationTitle').text(title);
    $('input[name="av_notation_pick"]').prop('checked', false);
    $('#av_custom_value').val('');
    if (!$('#avNotationBody').data('ready')) {
        var html = '';
        for (var i = 0; i < avNotationRows.length; i++) {
            html += '<tr>';
            for (var c = 0; c < avNotationRows[i].length; c++) {
                var val = avNotationRows[i][c];
                html += '<td style="text-align:center;padding:4px 8px;">';
                if (val) {
                    html += '<label style="margin:0;font-weight:400;cursor:pointer;"><input type="radio" name="av_notation_pick" value="' + val + '"> ' + val + '</label>';
                }
                html += '</td>';
            }
            html += '</tr>';
        }
        $('#avNotationBody').html(html).data('ready', 1);
    }
    $('#avNotationModal').show();
}

function acceptAvNotation() {
    var val = $('input[name="av_notation_pick"]:checked').val() || '';
    if ($('#av_custom_value').val()) {
        val = $('#av_custom_value').val();
    }
    if (avNotationTarget && val !== '') {
        $(avNotationTarget.el).val(val);
        updateConsulta(avNotationTarget.field, avNotationTarget.appId, val);
    }
    $('#avNotationModal').hide();
}

function clearAvNotation() {
    if (avNotationTarget) {
        $(avNotationTarget.el).val('');
        updateConsulta(avNotationTarget.field, avNotationTarget.appId, '');
    }
    $('input[name="av_notation_pick"]').prop('checked', false);
    $('#av_custom_value').val('');
    $('#avNotationModal').hide();
}

function addAntecedentRow(type, appId, patientId) {
    var fields = '';
    if (type === 'md') {
        fields = '<div class="col-sm-6"><label>DIAGNÓSTICO</label><input type="text" class="form-control ant-item" onchange="saveAntecedentRow(this)"></div>' +
            '<div class="col-sm-6"><label>TRATAMIENTO</label><input type="text" class="form-control ant-tx" onchange="saveAntecedentRow(this)"></div>' +
            '<div class="col-sm-12" style="margin-top:8px;"><label>NOTAS</label><textarea class="form-control ant-notes" rows="2" onchange="saveAntecedentRow(this)"></textarea></div>';
    } else if (type === 'qx') {
        fields = '<div class="col-sm-6"><label>CIRUGÍA</label><input type="text" class="form-control ant-item" onchange="saveAntecedentRow(this)"></div>' +
            '<div class="col-sm-6"><label>NOTAS</label><textarea class="form-control ant-notes" rows="2" onchange="saveAntecedentRow(this)"></textarea></div>';
    } else if (type === 'trx') {
        fields = '<div class="col-sm-6"><label>TRAUMA</label><input type="text" class="form-control ant-item" onchange="saveAntecedentRow(this)"></div>' +
            '<div class="col-sm-6"><label>NOTAS</label><textarea class="form-control ant-notes" rows="2" onchange="saveAntecedentRow(this)"></textarea></div>';
    } else if (type === 'fam') {
        fields = '<div class="col-sm-6"><label>DIAGNÓSTICO</label><input type="text" class="form-control ant-item" onchange="saveAntecedentRow(this)"></div>' +
            '<div class="col-sm-6"><label>FAMILIAR</label><input type="text" class="form-control ant-tx" onchange="saveAntecedentRow(this)"></div>';
    } else {
        fields = '<div class="col-sm-6"><label>ALERGIA</label><input type="text" class="form-control ant-item" onchange="saveAntecedentRow(this)"></div>' +
            '<div class="col-sm-6"><label>NOTAS</label><textarea class="form-control ant-notes" rows="2" onchange="saveAntecedentRow(this)"></textarea></div>';
    }
    var row = '<div class="ant-row" data-id="" data-type="' + type + '" data-patient="' + patientId + '" style="border-top:1px solid #f0f2f6;padding-top:10px;margin-top:8px;"><div class="row">' + fields + '</div></div>';
    $('#ant_' + type + '_rows_' + appId).append(row);
}

function saveAntecedentRow(el) {
    var row = $(el).closest('.ant-row');
    var item = row.find('.ant-item').val() || '';
    var treatment = row.find('.ant-tx').length ? row.find('.ant-tx').val() : '';
    var notes = row.find('.ant-notes').val() || '';
    if (item === '' && treatment === '' && notes === '') {
        return;
    }
    $.ajax({
        url: base_url + 'doctor/save_antecedent',
        type: 'POST',
        data: {
            antecedent_id: row.attr('data-id'),
            patient_id: row.attr('data-patient'),
            type: row.attr('data-type'),
            item: item,
            treatment: treatment,
            notes: notes
        },
        success: function(resp) {
            var id = $.trim(resp);
            if (id) {
                row.attr('data-id', id);
            }
        }
    });
}

function deleteAntecedent(antecedentId) {
    $.ajax({
        url: base_url + 'doctor/delete_antecedent/' + antecedentId,
        type: 'POST',
        success: function() {
            location.reload();
        }
    });
}

<?php if($gen != "M"):?>
//////////////////////////////////////////  lhfa_girls
new Chart('lhfa_girls', {
    type: 'line',
    data: {
        labels: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60],
        datasets: [{
            label: 'Talla',
            data: [{
                x: 47,
                y: 100.5
            }],
            backgroundColor: ['blue'],
            borderWidth: 2,
            borderColor: 'blue',
            pointStyle: 'circle',
            pointRadius: 4,
            pointHoverRadius: 4
        }, {
            label: '-2',
            data: [43.6, 47.8, 51, 53.5, 55.6, 57.4, 58.9, 60.3, 61.7, 62.9, 64.1, 65.2, 66.3, 67.3, 68.3, 69.3, 70.2, 71.1, 72, 72.8, 73.7, 74.5, 75.2, 76, 76.7, 76.8, 77.5, 78.1, 78.8, 79.5, 80.1, 80.7, 81.3, 81.9, 82.5, 83.1, 83.6, 84.2, 84.7, 85.3, 85.8, 86.3, 86.8, 87.4, 87.9, 88.4, 88.9, 89.3, 89.8, 90.3, 90.7, 91.2, 91.7, 92.1, 92.6, 93, 93.4, 93.9, 94.3, 94.7, 95.2],
            backgroundColor: ['black'],
            borderWidth: 2,
            borderColor: 'black',
            pointStyle: 'circle',
            pointRadius: 0,
            pointHoverRadius: 1
        }, {
            label: '-1',
            data: [45.4, 49.8, 53, 55.6, 57.8, 59.6, 61.2, 62.7, 64, 65.3, 66.5, 67.7, 68.9, 70, 71, 72, 73, 74, 74.9, 75.8, 76.7, 77.5, 78.4, 79.2, 80, 80, 80.8, 81.5, 82.2, 82.9, 83.6, 84.3, 84.9, 85.6, 86.2, 86.8, 87.4, 88, 88.6, 89.2, 89.8, 90.4, 90.9, 91.5, 92, 92.5, 93.1, 93.6, 94.1, 94.6, 95.1, 95.6, 96.1, 96.6, 97.1, 97.6, 98.1, 98.5, 99, 99.5, 99.9],
            backgroundColor: ['red'],
            borderWidth: 2,
            borderColor: 'red',
            pointStyle: 'circle',
            pointRadius: 0,
            pointHoverRadius: 1
        }, {
            label: '0',
            data: [49.1, 53.7, 57.1, 59.8, 62.1, 64, 65.7, 67.3, 68.7, 70.1, 71.5, 72.8, 74, 75.2, 76.4, 77.5, 78.6, 79.7, 80.7, 81.7, 82.7, 83.7, 84.6, 85.5, 86.4, 86.6, 87.4, 88.3, 89.1, 89.9, 90.7, 91.4, 92.2, 92.9, 93.6, 94.4, 95.1, 95.7, 96.4, 97.1, 97.7, 98.4, 99, 99.7, 100.3, 100.9, 101.5, 102.1, 102.7, 103.3, 103.9, 104.5, 105, 105.6, 106.2, 106.7, 107.3, 107.8, 108.4, 108.9, 109.4],
            backgroundColor: ['green'],
            borderWidth: 2,
            borderColor: 'green',
            pointStyle: 'circle',
            pointRadius: 0,
            pointHoverRadius: 1
        }, {
            label: '+1',
            data: [52.9, 57.6, 61.1, 64, 66.4, 68.5, 70.3, 71.9, 73.5, 75, 76.4, 77.8, 79.2, 80.5, 81.7, 83, 84.2, 85.4, 86.5, 87.6, 88.7, 89.8, 90.8, 91.9, 92.9, 93.1, 94.1, 95, 96, 96.9, 97.7, 98.6, 99.4, 100.3, 101.1, 101.9, 102.7, 103.4, 104.2, 105, 105.7, 106.4, 107.2, 107.9, 108.6, 109.3, 110, 110.7, 111.3, 112, 112.7, 113.3, 114, 114.6, 115.2, 115.9, 116.5, 117.1, 117.7, 118.3, 118.9],
            backgroundColor: ['red'],
            borderWidth: 2,
            borderColor: 'red',
            pointStyle: 'circle',
            pointRadius: 0,
            pointHoverRadius: 1
        }, {
            label: '+2',
            data: [54.7, 59.5, 63.2, 66.1, 68.6, 70.7, 72.5, 74.2, 75.8, 77.4, 78.9, 80.3, 81.7, 83.1, 84.4, 85.7, 87, 88.2, 89.4, 90.6, 91.7, 92.9, 94, 95, 96.1, 96.4, 97.4, 98.4, 99.4, 100.3, 101.3, 102.2, 103.1, 103.9, 104.8, 105.6, 106.5, 107.3, 108.1, 108.9, 109.7, 110.5, 111.2, 112, 112.7, 113.5, 114.2, 114.9, 115.7, 116.4, 117.1, 117.7, 118.4, 119.1, 119.8, 120.4, 121.1, 121.8, 122.4, 123.1, 123.7],
            backgroundColor: ['black'],
            borderWidth: 2,
            borderColor: 'black',
            pointStyle: 'circle',
            pointRadius: 0,
            pointHoverRadius: 1
        }]
    },
    options: {
        scales: {
            myScale: {
                position: 'right', // `axis` is determined by the position as `'y'`
            }
        }
    }
})

//////////////////////////////////////////  wfa_girls
new Chart('wfa_girls', {
    type: 'line',
    data: {
        labels: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60],
        datasets: [{
            label: 'Peso',
            data: [],
            backgroundColor: ['blue'],
            borderWidth: 2,
            borderColor: 'blue',
            pointStyle: 'circle',
            pointRadius: 4,
            pointHoverRadius: 4
        }, {
            label: '-2',
            data: [2, 2.7, 3.4, 4, 4.4, 4.8, 5.1, 5.3, 5.6, 5.8, 5.9, 6.1, 6.3, 6.4, 6.6, 6.7, 6.9, 7, 7.2, 7.3, 7.5, 7.6, 7.8, 7.9, 8.1, 8.2, 8.4, 8.5, 8.6, 8.8, 8.9, 9, 9.1, 9.3, 9.4, 9.5, 9.6, 9.7, 9.8, 9.9, 10.1, 10.2, 10.3, 10.4, 10.5, 10.6, 10.7, 10.8, 10.9, 11, 11.1, 11.2, 11.3, 11.4, 11.5, 11.6, 11.7, 11.8, 11.9, 12, 12.1],
            backgroundColor: ['black'],
            borderWidth: 2,
            borderColor: 'black',
            pointStyle: 'circle',
            pointRadius: 0,
            pointHoverRadius: 1
        }, {
            label: '-1',
            data: [2.4, 3.2, 3.9, 4.5, 5, 5.4, 5.7, 6, 6.3, 6.5, 6.7, 6.9, 7, 7.2, 7.4, 7.6, 7.7, 7.9, 8.1, 8.2, 8.4, 8.6, 8.7, 8.9, 9, 9.2, 9.4, 9.5, 9.7, 9.8, 10, 10.1, 10.3, 10.4, 10.5, 10.7, 10.8, 10.9, 11.1, 11.2, 11.3, 11.5, 11.6, 11.7, 11.8, 12, 12.1, 12.2, 12.3, 12.4, 12.6, 12.7, 12.8, 12.9, 13, 13.2, 13.3, 13.4, 13.5, 13.6, 13.7],
            backgroundColor: ['red'],
            borderWidth: 2,
            borderColor: 'red',
            pointStyle: 'circle',
            pointRadius: 0,
            pointHoverRadius: 1
        }, {
            label: '0',
            data: [3.2, 4.2, 5.1, 5.8, 6.4, 6.9, 7.3, 7.6, 7.9, 8.2, 8.5, 8.7, 8.9, 9.2, 9.4, 9.6, 9.8, 10, 10.2, 10.4, 10.6, 10.9, 11.1, 11.3, 11.5, 11.7, 11.9, 12.1, 12.3, 12.5, 12.7, 12.9, 13.1, 13.3, 13.5, 13.7, 13.9, 14, 14.2, 14.4, 14.6, 14.8, 15, 15.2, 15.3, 15.5, 15.7, 15.9, 16.1, 16.3, 16.4, 16.6, 16.8, 17, 17.2, 17.3, 17.5, 17.7, 17.9, 18, 18.2],
            backgroundColor: ['green'],
            borderWidth: 2,
            borderColor: 'green',
            pointStyle: 'circle',
            pointRadius: 0,
            pointHoverRadius: 1
        }, {
            label: '+1',
            data: [4.2, 5.5, 6.6, 7.5, 8.2, 8.8, 9.3, 9.8, 10.2, 10.5, 10.9, 11.2, 11.5, 11.8, 12.1, 12.4, 12.6, 12.9, 13.2, 13.5, 13.7, 14, 14.3, 14.6, 14.8, 15.1, 15.4, 15.7, 16, 16.2, 16.5, 16.8, 17.1, 17.3, 17.6, 17.9, 18.1, 18.4, 18.7, 19, 19.2, 19.5, 19.8, 20.1, 20.4, 20.7, 20.9, 21.2, 21.5, 21.8, 22.1, 22.4, 22.6, 22.9, 23.2, 23.5, 23.8, 24.1, 24.4, 24.6, 24.9],
            backgroundColor: ['red'],
            borderWidth: 2,
            borderColor: 'red',
            pointStyle: 'circle',
            pointRadius: 0,
            pointHoverRadius: 1
        }, {
            label: '+2',
            data: [4.8, 6.2, 7.5, 8.5, 9.3, 10, 10.6, 11.1, 11.6, 12, 12.4, 12.8, 13.1, 13.5, 13.8, 14.1, 14.5, 14.8, 15.1, 15.4, 15.7, 16, 16.4, 16.7, 17, 17.3, 17.7, 18, 18.3, 18.7, 19, 19.3, 19.6, 20, 20.3, 20.6, 20.9, 21.3, 21.6, 22, 22.3, 22.7, 23, 23.4, 23.7, 24.1, 24.5, 24.8, 25.2, 25.5, 25.9, 26.3, 26.6, 27, 27.4, 27.7, 28.1, 28.5, 28.8, 29.2, 29.5],
            backgroundColor: ['black'],
            borderWidth: 2,
            borderColor: 'black',
            pointStyle: 'circle',
            pointRadius: 0,
            pointHoverRadius: 1
        }]
    },
    options: {
        scales: {
            myScale: {
                position: 'right', // `axis` is determined by the position as `'y'`
            }
        }
    }
})


//////////////////////////////////////////  wfl_girls
new Chart('wfl_girls', {
    type: 'line',
    data: {
        labels: [45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 94, 95, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117, 118, 119, 120],
        datasets: [{
            label: 'Peso',
            data: [],
            backgroundColor: ['blue'],
            borderWidth: 2,
            borderColor: 'blue',
            pointStyle: 'circle',
            pointRadius: 4,
            pointHoverRadius: 4
        }, {
            label: '-2',
            data: [1.9, 2, 2.2, 2.3, 2.4, 2.6, 2.8, 2.9, 3.1, 3.3, 3.5, 3.7, 3.9, 4.1, 4.3, 4.5, 4.7, 4.9, 5.1, 5.3, 5.6, 5.8, 5.9, 6.1, 6.3, 6.4, 6.6, 6.7, 6.9, 7, 7.2, 7.3, 7.5, 7.6, 7.8, 7.9, 8.1, 8.3, 8.5, 8.6, 8.8, 9, 9.2, 9.4, 9.6, 9.8, 10, 10.2, 10.4, 10.6, 10.8, 10.9, 11.1, 11.3, 11.5, 11.7, 12, 12.2, 12.4, 12.6, 12.9, 13.1, 13.4, 13.7, 13.9, 14.2, 14.5, 14.8, 15.1, 15.4, 15.7, 16, 16.3, 16.6, 16.9, 17.3],
            backgroundColor: ['black'],
            borderWidth: 2,
            borderColor: 'black',
            pointStyle: 'circle',
            pointRadius: 0,
            pointHoverRadius: 1
        }, {
            label: '-1',
            data: [2.1, 2.2, 2.4, 2.5, 2.6, 2.8, 3, 3.2, 3.4, 3.6, 3.8, 4, 4.3, 4.5, 4.7, 4.9, 5.1, 5.3, 5.5, 5.7, 6.1, 6.3, 6.4, 6.6, 6.8, 7, 7.1, 7.3, 7.5, 7.6, 7.8, 8, 8.1, 8.3, 8.4, 8.6, 8.8, 9, 9.2, 9.4, 9.6, 9.8, 10, 10.2, 10.4, 10.6, 10.9, 11.1, 11.3, 11.5, 11.7, 11.9, 12.1, 12.3, 12.5, 12.8, 13, 13.3, 13.5, 13.8, 14, 14.3, 14.6, 14.9, 15.2, 15.5, 15.8, 16.2, 16.5, 16.8, 17.2, 17.5, 17.8, 18.2, 18.5, 18.9],
            backgroundColor: ['red'],
            borderWidth: 2,
            borderColor: 'red',
            pointStyle: 'circle',
            pointRadius: 0,
            pointHoverRadius: 1
        }, {
            label: '0',
            data: [2.5, 2.6, 2.8, 3, 3.2, 3.4, 3.6, 3.8, 4, 4.3, 4.5, 4.8, 5.1, 5.4, 5.6, 5.9, 6.1, 6.4, 6.6, 6.9, 7.2, 7.5, 7.7, 7.9, 8.1, 8.3, 8.5, 8.7, 8.9, 9.1, 9.3, 9.5, 9.6, 9.8, 10, 10.2, 10.4, 10.7, 10.9, 11.1, 11.4, 11.6, 11.9, 12.1, 12.4, 12.6, 12.9, 13.1, 13.4, 13.6, 13.9, 14.1, 14.4, 14.7, 14.9, 15.2, 15.5, 15.8, 16.1, 16.4, 16.8, 17.1, 17.5, 17.8, 18.2, 18.6, 19, 19.4, 19.8, 20.2, 20.7, 21.1, 21.5, 22, 22.4, 22.8],
            backgroundColor: ['green'],
            borderWidth: 2,
            borderColor: 'green',
            pointStyle: 'circle',
            pointRadius: 0,
            pointHoverRadius: 1
        }, {
            label: '+1',
            data: [3, 3.2, 3.4, 3.6, 3.8, 4, 4.3, 4.6, 4.9, 5.2, 5.5, 5.8, 6.1, 6.5, 6.8, 7.1, 7.4, 7.7, 8, 8.3, 8.7, 9, 9.3, 9.5, 9.8, 10, 10.3, 10.5, 10.7, 11, 11.2, 11.4, 11.6, 11.8, 12.1, 12.3, 12.6, 12.8, 13.1, 13.4, 13.7, 14, 14.3, 14.6, 14.9, 15.2, 15.5, 15.8, 16.1, 16.4, 16.7, 17, 17.4, 17.7, 18, 18.4, 18.7, 19.1, 19.5, 19.9, 20.3, 20.8, 21.2, 21.7, 22.1, 22.6, 23.1, 23.6, 24.2, 24.7, 25.2, 25.8, 26.3, 26.9, 27.4, 28],
            backgroundColor: ['red'],
            borderWidth: 2,
            borderColor: 'red',
            pointStyle: 'circle',
            pointRadius: 0,
            pointHoverRadius: 1
        }, {
            label: '+2',
            data: [3.3, 3.5, 3.7, 4, 4.2, 4.5, 4.8, 5.1, 5.4, 5.7, 6.1, 6.4, 6.8, 7.1, 7.5, 7.8, 8.2, 8.5, 8.8, 9.1, 9.7, 10, 10.2, 10.5, 10.8, 11.1, 11.3, 11.6, 11.8, 12.1, 12.3, 12.6, 12.8, 13.1, 13.3, 13.6, 13.9, 14.1, 14.5, 14.8, 15.1, 15.4, 15.8, 16.1, 16.4, 16.8, 17.1, 17.4, 17.8, 18.1, 18.5, 18.8, 19.2, 19.5, 19.9, 20.3, 20.7, 21.1, 21.6, 22, 22.5, 23, 23.5, 24, 24.5, 25.1, 25.7, 26.2, 26.8, 27.4, 28.1, 28.7, 29.3, 29.9, 30.6, 31.2],
            backgroundColor: ['black'],
            borderWidth: 2,
            borderColor: 'black',
            pointStyle: 'circle',
            pointRadius: 0,
            pointHoverRadius: 1
        }]
    },
    options: {
        scales: {
            myScale: {
                position: 'right', // `axis` is determined by the position as `'y'`
            }
        }
    }
})
<?php else:?>

//////////////////////////////////////////  lhfa_boys

new Chart('lhfa_boys', {
    type: 'line',
    data: {
        labels: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60],
        datasets: [{
            label: 'Talla',
            data: <?php echo $this->accounts_model->get_lhfa($originalDate,$patient_id);?>,
            backgroundColor: ['blue'],
            borderWidth: 2,
            borderColor: 'blue',
            pointStyle: 'circle',
            pointRadius: 4,
            pointHoverRadius: 4
        }, {
            label: '-2',
            data: [44.2, 48.9, 52.4, 55.3, 57.6, 59.6, 61.2, 62.7, 64, 65.2, 66.4, 67.6, 68.6, 69.6, 70.6, 71.6, 72.5, 73.3, 74.2, 75, 75.8, 76.5, 77.2, 78, 78.7, 78.6, 79.3, 79.9, 80.5, 81.1, 81.7, 82.3, 82.8, 83.4, 83.9, 84.4, 85, 85.5, 86, 86.5, 87, 87.5, 88, 88.4, 88.9, 89.4, 89.8, 90.3, 90.7, 91.2, 91.6, 92.1, 92.5, 93, 93.4, 93.9, 94.3, 94.7, 95.2, 95.6, 96.1],
            backgroundColor: ['black'],
            borderWidth: 2,
            borderColor: 'black',
            pointStyle: 'circle',
            pointRadius: 0,
            pointHoverRadius: 1
        }, {
            label: '-1',
            data: [46.1, 50.8, 54.4, 57.3, 59.7, 61.7, 63.3, 64.8, 66.2, 67.5, 68.7, 69.9, 71, 72.1, 73.1, 74.1, 75, 76, 76.9, 77.7, 78.6, 79.4, 80.2, 81, 81.7, 81.7, 82.5, 83.1, 83.8, 84.5, 85.1, 85.7, 86.4, 86.9, 87.5, 88.1, 88.7, 89.2, 89.8, 90.3, 90.9, 91.4, 91.9, 92.4, 93, 93.5, 94, 94.4, 94.9, 95.4, 95.9, 96.4, 96.9, 97.4, 97.8, 98.3, 98.8, 99.3, 99.7, 100.2, 100.7],
            backgroundColor: ['red'],
            borderWidth: 2,
            borderColor: 'red',
            pointStyle: 'circle',
            pointRadius: 0,
            pointHoverRadius: 1
        }, {
            label: '0',
            data: [49.9, 54.7, 58.4, 61.4, 63.9, 65.9, 67.6, 69.2, 70.6, 72, 73.3, 74.5, 75.7, 76.9, 78, 79.1, 80.2, 81.2, 82.3, 83.2, 84.2, 85.1, 86, 86.9, 87.8, 88, 88.8, 89.6, 90.4, 91.2, 91.9, 92.7, 93.4, 94.1, 94.8, 95.4, 96.1, 96.7, 97.4, 98, 98.6, 99.2, 99.9, 100.4, 101, 101.6, 102.2, 102.8, 103.3, 103.9, 104.4, 105, 105.6, 106.1, 106.7, 107.2, 107.8, 108.3, 108.9, 109.4, 110],
            backgroundColor: ['green'],
            borderWidth: 2,
            borderColor: 'green',
            pointStyle: 'circle',
            pointRadius: 0,
            pointHoverRadius: 1
        }, {
            label: '+1',
            data: [53.7, 58.6, 62.4, 65.5, 68, 70.1, 71.9, 73.5, 75, 76.5, 77.9, 79.2, 80.5, 81.8, 83, 84.2, 85.4, 86.5, 87.7, 88.8, 89.8, 90.9, 91.9, 92.9, 93.9, 94.2, 95.2, 96.1, 97, 97.9, 98.7, 99.6, 100.4, 101.2, 102, 102.7, 103.5, 104.2, 105, 105.7, 106.4, 107.1, 107.8, 108.5, 109.1, 109.8, 110.4, 111.1, 111.7, 112.4, 113, 113.6, 114.2, 114.9, 115.5, 116.1, 116.7, 117.4, 118, 118.6, 119.2],
            backgroundColor: ['red'],
            borderWidth: 2,
            borderColor: 'red',
            pointStyle: 'circle',
            pointRadius: 0,
            pointHoverRadius: 1
        }, {
            label: '+2',
            data: [55.6, 60.6, 64.4, 67.6, 70.1, 72.2, 74, 75.7, 77.2, 78.7, 80.1, 81.5, 82.9, 84.2, 85.5, 86.7, 88, 89.2, 90.4, 91.5, 92.6, 93.8, 94.9, 95.9, 97, 97.3, 98.3, 99.3, 100.3, 101.2, 102.1, 103, 103.9, 104.8, 105.6, 106.4, 107.2, 108, 108.8, 109.5, 110.3, 111, 111.7, 112.5, 113.2, 113.9, 114.6, 115.2, 115.9, 116.6, 117.3, 117.9, 118.6, 119.2, 119.9, 120.6, 121.2, 121.9, 122.6, 123.2, 123.9],
            backgroundColor: ['black'],
            borderWidth: 2,
            borderColor: 'black',
            pointStyle: 'circle',
            pointRadius: 0,
            pointHoverRadius: 1
        }]
    },
    options: {

        scales: {
            myScale: {
                position: 'right', // `axis` is determined by the position as `'y'`
            }
        }
    }
})

//////////////////////////////////////////  wfa_boys
new Chart('wfa_boys', {
    type: 'line',
    data: {
        labels: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60],
        datasets: [{
            label: 'Peso',
            data: <?php echo $this->accounts_model->get_wfa($originalDate,$patient_id);?>,
            backgroundColor: ['blue'],
            borderWidth: 2,
            borderColor: 'blue',
            pointStyle: 'circle',
            pointRadius: 4,
            pointHoverRadius: 4
        }, {
            label: '-2',
            data: [2.1, 2.9, 3.8, 4.4, 4.9, 5.3, 5.7, 5.9, 6.2, 6.4, 6.6, 6.8, 6.9, 7.1, 7.2, 7.4, 7.5, 7.7, 7.8, 8, 8.1, 8.2, 8.4, 8.5, 8.6, 8.8, 8.9, 9, 9.1, 9.2, 9.4, 9.5, 9.6, 9.7, 9.8, 9.9, 10, 10.1, 10.2, 10.3, 10.4, 10.5, 10.6, 10.7, 10.8, 10.9, 11, 11.1, 11.2, 11.3, 11.4, 11.5, 11.6, 11.7, 11.8, 11.9, 12, 12.1, 12.2, 12.3, 12.4],
            backgroundColor: ['black'],
            borderWidth: 2,
            borderColor: 'black',
            pointStyle: 'circle',
            pointRadius: 0,
            pointHoverRadius: 1
        }, {
            label: '-1',
            data: [2.5, 3.4, 4.3, 5, 5.6, 6, 6.4, 6.7, 6.9, 7.1, 7.4, 7.6, 7.7, 7.9, 8.1, 8.3, 8.4, 8.6, 8.8, 8.9, 9.1, 9.2, 9.4, 9.5, 9.7, 9.8, 10, 10.1, 10.2, 10.4, 10.5, 10.7, 10.8, 10.9, 11, 11.2, 11.3, 11.4, 11.5, 11.6, 11.8, 11.9, 12, 12.1, 12.2, 12.4, 12.5, 12.6, 12.7, 12.8, 12.9, 13.1, 13.2, 13.3, 13.4, 13.5, 13.6, 13.7, 13.8, 14, 14.1],
            backgroundColor: ['red'],
            borderWidth: 2,
            borderColor: 'red',
            pointStyle: 'circle',
            pointRadius: 0,
            pointHoverRadius: 1
        }, {
            label: '0',
            data: [3.3, 4.5, 5.6, 6.4, 7, 7.5, 7.9, 8.3, 8.6, 8.9, 9.2, 9.4, 9.6, 9.9, 10.1, 10.3, 10.5, 10.7, 10.9, 11.1, 11.3, 11.5, 11.8, 12, 12.2, 12.4, 12.5, 12.7, 12.9, 13.1, 13.3, 13.5, 13.7, 13.8, 14, 14.2, 14.3, 14.5, 14.7, 14.8, 15, 15.2, 15.3, 15.5, 15.7, 15.8, 16, 16.2, 16.3, 16.5, 16.7, 16.8, 17, 17.2, 17.3, 17.5, 17.7, 17.8, 18, 18.2, 18.3],
            backgroundColor: ['green'],
            borderWidth: 2,
            borderColor: 'green',
            pointStyle: 'circle',
            pointRadius: 0,
            pointHoverRadius: 1
        }, {
            label: '+1',
            data: [4.4, 5.8, 7.1, 8, 8.7, 9.3, 9.8, 10.3, 10.7, 11, 11.4, 11.7, 12, 12.3, 12.6, 12.8, 13.1, 13.4, 13.7, 13.9, 14.2, 14.5, 14.7, 15, 15.3, 15.5, 15.8, 16.1, 16.3, 16.6, 16.9, 17.1, 17.4, 17.6, 17.8, 18.1, 18.3, 18.6, 18.8, 19, 19.3, 19.5, 19.7, 20, 20.2, 20.5, 20.7, 20.9, 21.2, 21.4, 21.7, 21.9, 22.2, 22.4, 22.7, 22.9, 23.2, 23.4, 23.7, 23.9, 24.2],
            backgroundColor: ['red'],
            borderWidth: 2,
            borderColor: 'red',
            pointStyle: 'circle',
            pointRadius: 0,
            pointHoverRadius: 1
        }, {
            label: '+2',
            data: [5, 6.6, 8, 9, 9.7, 10.4, 10.9, 11.4, 11.9, 12.3, 12.7, 13, 13.3, 13.7, 14, 14.3, 14.6, 14.9, 15.3, 15.6, 15.9, 16.2, 16.5, 16.8, 17.1, 17.5, 17.8, 18.1, 18.4, 18.7, 19, 19.3, 19.6, 19.9, 20.2, 20.4, 20.7, 21, 21.3, 21.6, 21.9, 22.1, 22.4, 22.7, 23, 23.3, 23.6, 23.9, 24.2, 24.5, 24.8, 25.1, 25.4, 25.7, 26, 26.3, 26.6, 26.9, 27.2, 27.6, 27.9],
            backgroundColor: ['black'],
            borderWidth: 2,
            borderColor: 'black',
            pointStyle: 'circle',
            pointRadius: 0,
            pointHoverRadius: 1
        }]
    },
    options: {
        scales: {
            myScale: {
                position: 'right', // `axis` is determined by the position as `'y'`
            }
        }
    }
})

//////////////////////////////////////////  wfl_boys

new Chart('wfl_boys', {
    type: 'line',
    data: {
        labels: [45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 94, 95, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117, 118, 119, 120],
        datasets: [{
            label: 'Peso',
            data: <?php echo $this->accounts_model->get_wfl($originalDate,$patient_id);?>,
            backgroundColor: ['blue'],
            borderWidth: 2,
            borderColor: 'blue',
            pointStyle: 'circle',
            pointRadius: 4,
            pointHoverRadius: 4
        }, {
            label: '-2',
            data: [1.9, 2, 2.1, 2.3, 2.4, 2.6, 2.7, 2.9, 3.1, 3.3, 3.6, 3.8, 4, 4.3, 4.5, 4.7, 4.9, 5.1, 5.3, 5.5, 5.9, 6.1, 6.2, 6.4, 6.6, 6.8, 6.9, 7.1, 7.3, 7.4, 7.6, 7.7, 7.9, 8, 8.2, 8.3, 8.5, 8.7, 8.8, 9, 9.2, 9.4, 9.6, 9.8, 10, 10.2, 10.4, 10.6, 10.8, 11, 11.1, 11.3, 11.5, 11.7, 11.9, 12.1, 12.3, 12.5, 12.8, 13, 13.2, 13.4, 13.7, 13.9, 14.1, 14.4, 14.6, 14.9, 15.2, 15.4, 15.7, 16, 16.2, 16.5, 16.8, 17.1],
            backgroundColor: ['black'],
            borderWidth: 2,
            borderColor: 'black',
            pointStyle: 'circle',
            pointRadius: 0,
            pointHoverRadius: 1
        }, {
            label: '-1',
            data: [2, 2.2, 2.3, 2.5, 2.6, 2.8, 3, 3.2, 3.4, 3.6, 3.8, 4.1, 4.3, 4.6, 4.8, 5.1, 5.3, 5.6, 5.8, 6, 6.3, 6.5, 6.7, 6.9, 7.1, 7.3, 7.5, 7.7, 7.9, 8, 8.2, 8.4, 8.5, 8.7, 8.8, 9, 9.2, 9.3, 9.5, 9.7, 10, 10.2, 10.4, 10.6, 10.8, 11, 11.2, 11.4, 11.6, 11.8, 12, 12.2, 12.4, 12.6, 12.9, 13.1, 13.3, 13.6, 13.8, 14, 14.3, 14.5, 14.8, 15.1, 15.3, 15.6, 15.9, 16.2, 16.5, 16.8, 17.1, 17.4, 17.7, 18, 18.3, 18.6],
            backgroundColor: ['red'],
            borderWidth: 2,
            borderColor: 'red',
            pointStyle: 'circle',
            pointRadius: 0,
            pointHoverRadius: 1
        }, {
            label: '0',
            data: [2.4, 2.6, 2.8, 2.9, 3.1, 3.3, 3.5, 3.8, 4, 4.3, 4.5, 4.8, 5.1, 5.4, 5.7, 6, 6.3, 6.5, 6.8, 7, 7.4, 7.7, 7.9, 8.1, 8.4, 8.6, 8.8, 9, 9.2, 9.4, 9.6, 9.8, 10, 10.2, 10.4, 10.6, 10.8, 11, 11.2, 11.4, 11.7, 11.9, 12.2, 12.4, 12.6, 12.9, 13.1, 13.4, 13.6, 13.8, 14.1, 14.3, 14.6, 14.8, 15.1, 15.4, 15.6, 15.9, 16.2, 16.5, 16.8, 17.2, 17.5, 17.8, 18.2, 18.5, 18.9, 19.2, 19.6, 20, 20.4, 20.8, 21.2, 21.6, 22, 22.4],
            backgroundColor: ['green'],
            borderWidth: 2,
            borderColor: 'green',
            pointStyle: 'circle',
            pointRadius: 0,
            pointHoverRadius: 1
        }, {
            label: '+1',
            data: [3, 3.1, 3.3, 3.6, 3.8, 4, 4.2, 4.5, 4.8, 5.1, 5.4, 5.8, 6.1, 6.4, 6.8, 7.1, 7.4, 7.7, 8, 8.3, 8.8, 9.1, 9.4, 9.6, 9.9, 10.2, 10.4, 10.7, 11, 11.2, 11.4, 11.7, 11.9, 12.1, 12.3, 12.6, 12.8, 13, 13.3, 13.5, 13.8, 14.1, 14.4, 14.7, 14.9, 15.2, 15.5, 15.8, 16, 16.3, 16.6, 16.9, 17.2, 17.5, 17.9, 18.2, 18.5, 18.9, 19.3, 19.7, 20.1, 20.5, 20.9, 21.3, 21.8, 22.2, 22.7, 23.1, 23.6, 24.1, 24.6, 25.1, 25.6, 26.1, 26.6, 27.2],
            backgroundColor: ['red'],
            borderWidth: 2,
            borderColor: 'red',
            pointStyle: 'circle',
            pointRadius: 0,
            pointHoverRadius: 1
        }, {
            label: '+2',
            data: [3.3, 3.5, 3.7, 3.9, 4.2, 4.4, 4.7, 5, 5.3, 5.6, 6, 6.3, 6.7, 7.1, 7.4, 7.8, 8.1, 8.5, 8.8, 9.1, 9.6, 9.9, 10.2, 10.5, 10.8, 11.1, 11.4, 11.7, 12, 12.2, 12.5, 12.8, 13, 13.3, 13.5, 13.7, 14, 14.2, 14.5, 14.8, 15.1, 15.4, 15.7, 16, 16.3, 16.6, 16.9, 17.2, 17.5, 17.8, 18.1, 18.4, 18.8, 19.1, 19.5, 19.9, 20.3, 20.7, 21.1, 21.6, 22, 22.5, 22.9, 23.4, 23.9, 24.4, 25, 25.5, 26, 26.6, 27.2, 27.8, 28.3, 28.9, 29.5, 30.1],
            backgroundColor: ['black'],
            borderWidth: 2,
            borderColor: 'black',
            pointStyle: 'circle',
            pointRadius: 0,
            pointHoverRadius: 1
        }]
    },
    options: {
        scales: {
            myScale: {
                position: 'right', // `axis` is determined by the position as `'y'`
            }
        }
    }
})

<?php endif;?>
</script>

<script>
    
     CKEDITOR.instances.ckeditor25.on('blur', function() {
        // Obtener el contenido del editor
        var dictamen = this.getData();
        
        // Llamar a la función updateConsulta
        updateConsulta('dictamen', <?php echo $details['appointment_id']; ?>, dictamen);
    });
</script>