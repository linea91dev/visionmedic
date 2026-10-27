<?php
    if (!isset($appt_base)) {
        $appt_base = 'doctor';
    }
    $patient_id = base64_decode($id_);
    $this->db->where('patient_id', $patient_id);
    $info = $this->db->get('patient')->result_array();
    foreach($info as $details):
    $files = array();
    if ($this->db->table_exists('patient_file')) {
        $this->db->where('patient_id', $patient_id);
        $this->db->order_by('patient_file_id', 'DESC');
        $files = $this->db->get('patient_file')->result_array();
    }
?>
<div class="todo-app-w">
    <div class="todo-sidebar">
        <div id="sticky">
            <div class="todo-sidebar-section" style="border-bottom:0px">
                <div class="todo-sidebar-section-contents">
                    <ul class="tasks-list">
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url().$appt_base;?>/patient_profile/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0002_write_pencil_new_edit"></i> Editar perfil </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items active" href="<?php echo base_url().$appt_base;?>/medical_history/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0299_address_book_contacts"></i> Historial <span class="side-active"></span></a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url().$appt_base;?>/medical_prescriptions/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0003_write_pencil_new_edit"></i> Recetas </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url().$appt_base;?>/patient_files/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0119_folder_open_full_documents"></i> Archivos </a>
                        </li>
                        <?php
                            $odonto = $this->db->get_where('clinic', array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->odonto;
                            if($odonto != ''):
                        ?>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url().$appt_base;?>/treatment/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0826_teeth_tooth_dental"></i> Planes de tratamiento </a>
                        </li>
                        <?php endif;?>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url().$appt_base;?>/patient_appointments/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0021_calendar_month_day_planner"></i> Citas </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url().$appt_base;?>/patient_financial/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0425_money_payment_dollar_cash"></i> Financiero </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="todo-content" style="margin-bottom:10%;">
        <h4 class="todo-content-header">
            <i class="batch-icon-arrow-right"></i><span>Historial - <?php echo $this->accounts_model->get_name('patient',$details['patient_id']);?></span>
        </h4>
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-info">
                    <span class="alert-title"><i class="batch-icon-spam"></i> Historial del paciente.</span>
                    <span class="alert-content">Aquí están las citas y los documentos agregados de este paciente.</span>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card-widget">
                    <h5 class="panel-content-title">Historial de citas</h5>
                    <span class="app-divider2"></span>
                    <div class="table-responsive">
                        <table class="table table-padded" id="user_data">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Paciente</th>
                                    <th>Especialista</th>
                                    <th>Fecha & Hora</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card-widget">
                    <h5 class="panel-content-title">Documentos agregados</h5>
                    <span class="app-divider2"></span>
                    <?php if (count($files) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-padded">
                            <thead>
                                <tr>
                                    <th>Documento</th>
                                    <th>Fecha</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($files as $file): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($file['old_name'] != '' ? $file['old_name'] : $file['name']); ?></td>
                                    <td><?php echo isset($file['date']) ? $file['date'] : ''; ?></td>
                                    <td>
                                        <a class="btn btn-primary btn-sm" target="_blank" href="<?php echo base_url().$appt_base;?>/patient_files/download/<?php echo $file['patient_file_id']; ?>">Ver</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <p>Aún no hay documentos agregados.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url();?>public/assets/theme/js/sticky-sidebar.js"></script>
<script src="<?php echo base_url();?>public/assets/theme/js/jquery.sticky.js"></script>
<script src="<?php echo base_url();?>public/assets/theme/js/PositionSticky/dist/PositionSticky.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#user_data').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url() . $appt_base . '/getTable/patient_appointments/'.$patient_id; ?>",
                type: "POST"
            },
            "columnDefs": [
                { "targets": 0, "orderable": false }
            ]
        });
    });
    var sidebar = new StickySidebar('#sticky', {topSpacing: 0});
</script>
<?php endforeach; ?>
