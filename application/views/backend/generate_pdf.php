<!doctype html>
<html>
<head>
</head>
<?php 
        
	$doctor_id = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->doctor_id;
	$patient_birth = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->date_of_birth;
	$prescription_date = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->date;
	$practice_id = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->practice;
	if($practice_id > 0){
	    $practice_name = 'Otros servicios';
	}else{
	    $practice_name = $this->db->get_where('service', array('service_id' => $practice_id))->row()->name;
	}
	$prescription_time = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->time;
	$colegiado = $this->db->get_where('admin', array('admin_id' => $doctor_id))->row()->no_college;
    $specialty_id_1 = $this->db->get_where('admin', array('admin_id' => $doctor_id))->row()->specialty_1;
    $specialty_id_2 = $this->db->get_where('admin', array('admin_id' => $doctor_id))->row()->specialty_2;
    $specialty_1 = $this->db->get_where('specialtie', array('specialtie_id' => $specialty_id_1))->row()->name;
    if($specialty_id_2 > 0)
    {
        $specialty_2 = $this->db->get_where('specialtie', array('specialtie_id' => $specialty_id_2))->row()->name;
    }
    $appointment_comment = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->doctor_comment;
	?>
<body>
    <div style="width:100%; font-size: 16px; line-height: 24px; font-family: 'nunito'; color: #555;">
	<table cellpadding="0" cellspacing="0" style="width: 100%;line-height: inherit;text-align: left;">
            <tr>
                <td colspan="2">
                    <table  style="width: 100%;line-height: inherit;text-align: left;">
                        <tr>
                            <td style="padding-bottom: 20px; vertical-align: top;">
                                <img src="<?php echo base_url();?>public/uploads/<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->logo;?>" alt="Medicaby" style="max-width:15%;">
                            </td>
                            <td style="padding-bottom: 20px; vertical-align: top;text-align:center;padding-top:5px;">
                                <p><?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->name;?></p>
                                <p><small style="font-weight:bold; text-transform:uppercase"><?php echo $specialty_1;?> <?php if($specialty_id_2 > 0):?>- <?php echo $specialty_2;?><?php endif;?></small></p>
                                <p>Colegiado: <b><?php echo $colegiado;?></b></p>
                            </td>
                            <td style="text-align: right;" >
                                <p style="font-size: 12px;"><b>Receta de Medicamentos</b></p>
                                <p style="font-size: 12px;">Generado por: <b>Medicaby</b></p>
                                <p style="font-size: 12px;">Impreso por: <b>
                                <?php if($this->session->userdata('login_type') == 'staff'): echo $this->accounts_model->short_name('staff',$this->session->userdata('login_user_id'));
                                elseif($this->session->userdata('login_type') == 'patient'): echo $this->accounts_model->short_name('patient',$this->session->userdata('login_user_id'));
                                else: echo $this->accounts_model->short_name('admin',$this->session->userdata('login_user_id')); endif;?></b></p>
                                <p style="font-size: 12px;">Fecha: <b><?php echo date('d/m/Y g:i A');?></b></p>
                                <p style="font-size: 12px;">Correlativo: <b><?php echo $appointment_id;?></b></p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
            </tr>
            <tr>
                <td colspan="2">
                    <table  style="width: 100%;line-height: inherit;text-align: left;">
                        <tr style="">
                            <td style="padding-top:15px;padding-bottom: 15px; border-top: 2px solid black; border-bottom: 2px solid black;">
                                <p style="font-size: 12px;">Paciente: <b><span><?php echo $this->accounts_model->short_name('patient',$patient_id);?></span></b></p>
                                <p style="font-size: 12px;">Motivo de Consulta: <b><?php echo $practice_name;?></b></p>
                            </td>
                            <td style="padding-top:15px;padding-bottom: 15px; border-top: 2px solid black; border-bottom: 2px solid black;">
                                <div style="font-size: 12px;">Género: <b><?php echo $this->crud_model->get_gender($patient_id);?></b></div>
                            </td>
                            <td style="padding-top:15px;text-align: right;padding-bottom: 15px;border-top: 2px solid black; border-bottom: 2px solid black;margin-bottom:50px;font-size:12px">
								Fecha de Nacimiento: <b><?php echo date('d/m/Y', strtotime($patient_birth));?></b><br>
                                Fecha de consulta: <b><?php echo $prescription_date." ".date("g:i A", strtotime($prescription_time));?></b>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
		</table>
		<br>
        <table cellpadding="0" cellspacing="0"  style="width: 100%;line-height: inherit;text-align: left;">
            <tr>
                <td style="background: #eee;font-style:italic; font-weight:bold;padding:5px;" colspan="4">
                    Medicamentos
                </td>
            </tr>
            <?php
                $data_info = $this->db->get_where('prescription', array('appointment_id' => $appointment_id))->result_array();
                foreach($data_info as $details):
            ?>
                <tr>
                    <td colspan="4" style="padding-top:15px;font-size: 12px;">
                        <b style="font-size: 12px;"><?php echo $details['medicine'];?></b><br>
                        <?php echo $details['quantity'];?> <?php echo $details['frequency'];?> durante <?php echo $details['duration'];?>.
                    </td>
                </tr>
            <?php endforeach;?>
            <tr>
                <td colspan="4" style="padding-top:20px;font-size: 12px;">
                    Si ocurre una reacción alérgica, suspender el medicamento.
                </td>
            </tr>
            <?php if($appointment_comment != ''):?>
            <tr>
                <td colspan="4" style="padding-top:30px;font-size: 12px;">
                    <b>Instrucciones Médicas:</b><br>
                    <?php echo $appointment_comment;?>
                </td>
            </tr>
            <?php endif;?>
            <tr>
                <td colspan="2" style="padding-top:30px;"></td>
                <td colspan="2" style="padding-top:30px;text-align:right;">
                    <?php if($this->db->get_where('admin', array('admin_id' => $doctor_id))->row()->signature!= ""):?>
                      <img src="<?php echo base_url();?>public/uploads/doctor_signature/<?php echo $this->db->get_where('admin', array('admin_id' => $doctor_id))->row()->signature; ?>" alt="<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->name;?>" style="width:20%;">
                    <?php endif;?>
                    <div style="text-align:center; border-top:2px solid black; width:200px;">
                   <b style="right:10px"><?php echo $this->accounts_model->gender($doctor_id);?> <?php echo $this->accounts_model->short_name('admin',$doctor_id);?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
                    </div>
                </td>
            </tr>
        </table>
		<table cellpadding="0" cellspacing="0"  style="width: 100%;line-height: inherit;text-align: left;padding-top:30px">
            <tr>
                <td colspan="2" style="padding-bottom: 40px;border-top:2px solid black;">
                    <table  style="width: 100%;line-height: inherit;text-align: left;vertical-align:top">
                        <tr>
                            <td style="font-size: 12px;">
                                <b>Dirección:</b><br>
                                <?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->address;?>
                            </td>
                            <td style="font-size: 12px;">
                                <b>Teléfono:</b><br>
                                <?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->phone;?>
                            </td>
                            <?php $sys_name = $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?>
                            <td style="text-align: right;font-size: 12px;">
								Receta electrónica generada con <?php echo $sys_name;?><br>
                              <b><?php echo base_url();?></b>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
		</table>
    </div> 
</body>

</html>
