<link rel="stylesheet" href="<?php echo base_url();?>public/assets/search/estilo.css">

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
                                        <a href="<?php echo base_url(); ?>staff/patient_profile/<?php echo base64_encode($patient_id); ?>" style="font-size:20px;color:black;text-decoration:none;"><?php echo $this->accounts_model->get_full_name('patient',$patient_id);?></a>
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
                                                        <input onchange="updateDataPatient('father_phone',<?php echo  $patient_id ?>,this.value)" type="text" placeholder="Telefono" class="form-control" value="<?php echo $pat->father_phone; ?>"></input>
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
                                                        <input onchange="updateDataPatient('mother_phone',<?php echo  $patient_id ?>,this.value)" type="text" class="form-control" placeholder="Telefono" value="<?php echo $pat->mother_phone;?>"> </input>
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
                                                        <input onchange="updateDataPatient('tutor_phone',<?php echo  $patient_id ?>,this.value)" type="text" class="form-control" placeholder="Telefono" value="<?php echo $pat->tutor_phone;?>"> </input>
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
                                                            <a class="btn btn-success custom-radius full-width" href="<?php echo base_url();?>staff/patient_profile/<?php echo  base64_encode($patient_id);?>">
                                                                Ir al perfil
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-4">
                                                        <div class="form-group">
                                                            <a class="btn btn-primary custom-radius full-width" href="<?php echo base_url();?>staff/medical_history/<?php echo  base64_encode($patient_id);?>">
                                                                Historial
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-4 col-md-6">
                                                        <div class="form-group">
                                                            <a class="btn btn-danger custom-radius full-width" href="<?php echo base_url();?>staff/patient_files/<?php echo  base64_encode($patient_id);?> ">
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

            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <?php $citas = $this->db->get_where('appointment',array('patient_id'=>$det['patient_id']))->result_array();?>
                <?php foreach ($citas as $c): ?>

                <li class="nav-item">
                    <a class="nav-link " data-toggle="tab" href="#c-<?php echo $c['appointment_id']?>" id="d-<?php echo $c['appointment_id']?>"><?php echo $c['date']?></a>
                </li>

                <?php endforeach;?>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <?php foreach ($citas as $details): ?>

                <div class="tab-pane container " id="c-<?php echo $details['appointment_id']?>">

                    <form action="<?php echo base_url();?>staff/appointment/finish" method="POST">
                        <input type="hidden" name="appointment_id" id="appointment_id" value="<?php echo $details['appointment_id'];?>">
                        <input type="hidden" name="patient_id" id="patient_id" value="<?php echo $this->db->get_where('patient', array('patient_id' => $det['patient_id']))->row()->patient_id; ?>">
                        <script>
                        var base_url = '<?php echo base_url();?>';
                        var appointment_id = '<?php echo $appointment_id;?>';
                        </script>
                        <br>
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
                                        <textarea cols="80" class="form-control" name="instructions" rows="1" onchange="updateConsulta('mc',<?php echo $details['appointment_id'] ?>,this.value)"><?php echo $details['mc']; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <b>Historia de la enfermedad:</b>
                                        <textarea cols="80" class="form-control" name="ckplan" rows="5" onchange="updateConsulta('he',<?php echo $details['appointment_id'] ?>,this.value)"><?php   echo $details['he']?>
                                        </textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <b>Examen físico:</b>
                                        <textarea cols="80" class="form-control" name="instructions" rows="25" onchange="updateConsulta('ef',<?php echo $details['appointment_id'] ?>,this.value)"><?php    echo $details['ef']; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6 row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <b>W:</b>
                                            <input class="form-control" name="instructions" onchange="updateConsulta('w',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['w'];?>"></input>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <b>T:</b>
                                            <input class="form-control" name="instructions" onchange="updateConsulta('t',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['t'];?>"></input>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <b>CC:</b>
                                            <input class="form-control" name="instructions" onchange="updateConsulta('cc',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['cc'];?>"></input>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <b>IMC:</b>
                                            <input class="form-control" name="instructions" onchange="updateConsulta('imc',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['imc'];?>"></input>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <b>Temp:</b>
                                            <input class="form-control" name="instructions" onchange="updateConsulta('temp',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['temp'];?>"></input>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <b>FR:</b>
                                            <input class="form-control" name="instructions" onchange="updateConsulta('fr',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['fr'];?>"></input>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <b>FC:</b>
                                            <input class="form-control" name="instructions" onchange="updateConsulta('fc',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['fc'];?>"></input>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <b>PA:</b>
                                            <input class="form-control" name="instructions" onchange="updateConsulta('pa',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['pa'];?>"></input>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <b>SO2:</b>
                                            <input class="form-control" name="instructions" onchange="updateConsulta('so2',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['so2'];?>"></input>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <b>LABORATORIOS:</b>
                                        <textarea cols="80" class="form-control" name="ckplan" rows="12" onchange="updateConsulta('lab',<?php echo $details['appointment_id'] ?>,this.value)"><?php   echo $details['lab']?></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6 row">
                                    <b>Adecuaciones nutricionales</b>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <b>W/T:</b>
                                            <input class="form-control" name="instructions" onchange="updateConsulta('w/t',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['w/t'];?>"></input>
                                        </div>
                                        <div class="form-group">
                                            <b>W/E:</b>
                                            <input class="form-control" name="instructions" onchange="updateConsulta('w/e',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['w/e'];?>"></input>
                                        </div>
                                        <div class="form-group">
                                            <b>T/E:</b>
                                            <input class="form-control" name="instructions" onchange="updateConsulta('t/e',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['t/e'];?>"></input>
                                        </div>
                                        <div class="form-group">
                                            <b>CC/E:</b>
                                            <input class="form-control" name="instructions" onchange="updateConsulta('cc/e',<?php echo $details['appointment_id'] ?>,this.value)" value="<?php echo $details['cc/e'];?>"></input>
                                        </div>
                                    </div>
                                </div>
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
                            <h5 class="panel-content-title">Receta de medicamentos</h5>
                            <span class="app-divider2"></span>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row" style="overflow-y:auto">
                                        <?php if($details['status'] == 1 && $details['appointment_id'] == $appointment_id):?>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Medicamento</label>
                                                <input type="text" class="form-control" placeholder="Medicamento" autocomplete="off" id="medicine" />
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Tomar</label>
                                                <input type="text" class="form-control" autocomplete="off" id="drink" placeholder="Cantidad" />
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Frecuencia</label>
                                                <input type="text" class="form-control" autocomplete="off" id="frequency" placeholder="Cada " />
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Duración</label>
                                                <input type="text" class="form-control" autocomplete="off" id="duration" placeholder="Durante" />
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <a class="btn btn-info" onclick="submit_recet(<?php echo $details['appointment_id']?>)" href="javascript:void(0);">+</a>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        <div class="col-sm-12" id="table_results_<?php echo $details['appointment_id']?>">
                                            <?php 
                                                    $refresh_query  = $this->db->get_where('prescription',array('appointment_id' => $details['appointment_id']));
                                                    if($refresh_query->num_rows() > 0)
                                                    {
                                                        $html_table = '
                                                            <table class="table">
                                                                <tr style="background-color:#f9fbfc; color:#59636d">
                                                                    <th>Medicamento</th>
                                                                    <th>Tomar</th>
                                                                    <th>Frecuencia</th>
                                                                    <th>Duración</th>';
                                            
                                                                if($status == 1 || $status == 0)
                                                                    $html_table .= '<th>-</th>';
                                                                    $html_table .= '</tr>';
                                                        foreach($refresh_query->result_array() as $row)
                                                        {
                                                            $html_table .= '
                                                                <tr>
                                                                    <td>'.$row['medicine'].'</td>
                                                                    <td>'.$row['quantity'].'</td>
                                                                    <td>'.$row['frequency'].'</td>
                                                                    <td>'.$row['duration'].'</td>';
                                            
                                                                    if($status == 1 || $status == 0)
                                                                    $html_table .= '<td><i style="color:#fd4f57;font-weight:bold;" onClick="delete_element('.$row['prescription_id'].','.$details['appointment_id'].')" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></td>';
                                                                    
                                                                    
                                                                    $html_table .= '</tr>';   
                                                        }
                                                        $html_table .='</table>';
                                                        
                                                        echo $html_table;
                                                    }else{
                                                        echo '<div class="col-sm-12"><br><center><h5 class="poppins">Aún no hay medicamentos preescritos</h5><br><img src="'.base_url().'public/uploads/medicamentos.svg" style="max-width:20%;"></center></div>';
                                                    }
                                                
                                                
                                                
                                                ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <a class="btn btn-success" target="_blank" href="<?php echo base_url();?>staff/print_prescription_details/<?php echo $details['appointment_id'];?>">Imprimir
                                        receta</a>
                                </div>
                            </div>
                        </div>
                        <?php if ($this->crud_model->check_item('nutri') == 1): ?>
                        <div class="card-widget" style="border: 1px solid #c6c6cc;">
                            <h5 class="panel-content-title">Seguimiento nutriológico</h5>
                            <span class="app-divider2"></span>
                            <div class="row">
                                <?php include 'nutriology.php';?>
                            </div>
                        </div>
                        <?php endif;?>
                        <?php if ($this->crud_model->check_item('cetosis') == 1): ?>
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
                                        <span style="text-align:left"><b>Practica:</b> </span>
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
                                            if($details['status']!= 4 && $details['status'] != 10  ):
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
                                            <input id="totalGeneral_<?php echo $details['appointment_id']?>" type="hidden" name="total_appointment" value="150">
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