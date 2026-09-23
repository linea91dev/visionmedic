<?php
    $clinic_id = $this->session->userdata('current_clinic');
    if($filter){
        $apply = base64_decode($filter);
    }
    $doctor_id = $this->session->userdata('doctor_id');
    $appointments = $this->crud_model->appointment_fondo_doc($doctor_id, $clinic_id)->result_array();
?>
<div class="todo-app-w">
    <div class="todo-sidebar2">
        <div id="sticky_left">
            <?php if($this->session->userdata('login_user_id') == 1):?>
            <div class="todo-sidebar-section">
                <h5 class="todo-sidebar-section-header">
                    <span>Seleccionar doctor</span><a class="todo-sidebar-section-toggle" href="#"><i class="batch-icon-user-2"></i></a>
                </h5>
                <div class="todo-sidebar-section-contents">
                    <ul class="tasks-list">
                        <li>
                            <form method="POST" action="<?php echo base_url();?>doctor/fondo_ojo">
                                <select class="itemName form-control select2" required="" name="doctor_id" onchange="submit()">
                                    <option value="">Seleccionar</option>
                                    <?php
                                        $this->db->where('status','1');
                                        $this->db->order_by('first_name', 'ASC');
                                        $query = $this->db->get('admin')->result_array();
                                        foreach($query as $pat):?>
                                    <option value="<?php echo $pat['admin_id'];?>" <?php if($pat['admin_id'] == $doctor_id) echo "selected";?>>
                                        <?php echo $this->accounts_model->get_name('admin', $pat['admin_id']);?>
                                    </option>
                                    <?php endforeach;?>
                                </select>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            <?php endif;?>
            <div class="todo-sidebar-section">
                <h5 class="todo-sidebar-section-header">
                    <span>Por estado</span><a class="todo-sidebar-section-toggle" href="#"><i class="batch-icon-revert"></i></a>
                </h5>
                <div class="todo-sidebar-section-contents">
                    <?php include 'appointment_state_list.php';?>
                </div>
            </div>
        </div>
    </div>
    <div class="todo-content" style="padding-bottom:10%">
        <h4 class="todo-content-header">
            <i class="batch-icon-arrow-right"></i><span>Fondo de ojo</span>
        </h4>
        <hr>
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-info">
                    <span class="alert-title"><i class="batch-icon-spam"></i> Citas enviadas a fondo de ojo.</span>
                    <span class="alert-content">Estas citas salieron de la lista del día. Ábrelas para retomarlas y finalizarlas, o devuélvelas a las citas del día.</span>
                </div>
            </div>
            <div class="col-sm-7">
                <div class="all-tasks-w">
                    <div class="tasks-section">
                        <ul class="tasks-list">
                            <?php if(count($appointments) == 0): ?>
                            <li style="padding:16px;">No hay citas en fondo de ojo.</li>
                            <?php endif; ?>
                            <?php foreach($appointments as $appointment): ?>
                            <div class="alert alert-fondo">
                                <span style="display:block;font-weight:bold;font-size:12px"><?php echo $this->crud_model->formatear($appointment['date']);?>
                                    - <?php echo date("g:i A", strtotime($appointment['time']));?></span>
                                <div class="pi-controls">
                                    <div class="pi-settings os-dropdown-trigger" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="batch-icon-ellipsis alert-fondo-text"></i>
                                    </div>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="<?php echo base_url();?>doctor/appointment_details/<?php echo base64_encode($appointment['appointment_id']);?>">Retomar</a>
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="devolver_cita('<?php echo $appointment['appointment_id'];?>')">Devolver a citas</a>
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="cancel_appointment('<?php echo $appointment['appointment_id'];?>')">Cancelar</a>
                                    </div>
                                </div>
                                <div class="pipeline-item">
                                    <div class="pi-body">
                                        <div class="avatar">
                                            <a href="<?php echo base_url();?>doctor/appointment_details/<?php echo base64_encode($appointment['appointment_id']);?>">
                                                <img alt="" src="<?php echo $this->accounts_model->get_photo('patient', $appointment['patient_id']);?>" width="45px" style="border-radius:25px">
                                            </a>
                                        </div>
                                        <div class="pi-info">
                                            <div class="h6 pi-name alert-fondo-text">
                                                <a href="<?php echo base_url();?>doctor/appointment_details/<?php echo base64_encode($appointment['appointment_id']);?>" class="alert-fondo-text" style="text-decoration:none;">
                                                    <?php echo $this->accounts_model->get_full_name('patient', $appointment['patient_id']);?>
                                                </a>
                                            </div>
                                            <div class="pi-sub alert-fondo-text">
                                                <?php if($appointment['practice'] > 0):?>
                                                <b>Práctica:</b>
                                                <?php echo $this->db->get_where('service', array('service_id' => $appointment['practice']))->row()->name;?>
                                                <?php else:?>
                                                <b>Práctica:</b> Otros servicios
                                                <?php endif;?>
                                                <span style="display:block"><b>Especialista:</b>
                                                    <?php echo $this->accounts_model->gender($appointment['doctor_id']).' '.$this->accounts_model->short_name('admin',$appointment['doctor_id']);?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pi-foot">
                                        <div class="tags">
                                            <a class="tag" href="<?php echo base_url();?>doctor/appointment_details/<?php echo base64_encode($appointment['appointment_id']);?>" data-toggle="tooltip" data-placement="right" title="" data-original-title="Retomar cita"><i class="picons-thin-icon-thin-0014_notebook_paper_todo alert-fondo-text"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function devolver_cita(appointment_id) {
    Swal.fire({
        title: '¿Devolver a citas?',
        text: "La cita volverá a la lista del día como confirmada.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Devolver',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>doctor/appointments/retomar/" + appointment_id;
        }
    })
}
function cancel_appointment(appointment_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "La cita será marcada como cancelada.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, cancelar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>doctor/appointments/cancel/" + appointment_id;
        }
    })
}
</script>
