<?php
$rx_apps = $this->db->select('appointment_id, doctor_id, date, time, comment')
    ->order_by('appointment_id', 'DESC')
    ->get_where('appointment', array('patient_id' => $patient_id))
    ->result_array();
$rx_ids = array();
foreach ($rx_apps as $rx_app) {
    $rx_ids[] = $rx_app['appointment_id'];
}
$rx_med_ids = array();
$rx_lens_ids = array();
if (count($rx_ids) > 0) {
    if ($this->db->table_exists('appointment_plan_dx')) {
        $rx_rows = $this->db->select('appointment_id')->where_in('appointment_id', $rx_ids)->get('appointment_plan_dx')->result_array();
        foreach ($rx_rows as $rx_row) {
            $rx_med_ids[$rx_row['appointment_id']] = true;
        }
    }
    if ($this->db->table_exists('appointment_plan_tx')) {
        $rx_rows = $this->db->select('appointment_id')->where_in('appointment_id', $rx_ids)->get('appointment_plan_tx')->result_array();
        foreach ($rx_rows as $rx_row) {
            $rx_med_ids[$rx_row['appointment_id']] = true;
        }
    }
    if ($this->db->table_exists('appointment_oftalmology')) {
        $rx_oft = $this->db->where_in('appointment_id', $rx_ids)->get('appointment_oftalmology')->result_array();
        $rx_text = array(
            'rx_comentario', 'rx_dip',
            'rx_final_od_esf', 'rx_final_od_cil', 'rx_final_od_eje', 'rx_final_od_prisma', 'rx_final_od_base',
            'rx_final_os_esf', 'rx_final_os_cil', 'rx_final_os_eje', 'rx_final_os_prisma', 'rx_final_os_base',
            'rx_add_od_esf', 'rx_add_od_cil', 'rx_add_od_eje', 'rx_add_od_prisma', 'rx_add_od_base',
            'rx_add_os_esf', 'rx_add_os_cil', 'rx_add_os_eje', 'rx_add_os_prisma', 'rx_add_os_base'
        );
        $rx_flags = array(
            'rx_lente_monofocal', 'rx_lente_progresivo', 'rx_lente_bifocal', 'rx_lente_otro',
            'rx_rec_filtro', 'rx_rec_antireflejo', 'rx_rec_polarizado', 'rx_rec_policarbonato',
            'rx_rec_sol', 'rx_rec_tenido', 'rx_rec_transitions', 'rx_rec_otros'
        );
        foreach ($rx_oft as $rx_row) {
            $rx_has = false;
            foreach ($rx_text as $rx_key) {
                if (isset($rx_row[$rx_key]) && trim($rx_row[$rx_key]) !== '') {
                    $rx_has = true;
                    break;
                }
            }
            if (!$rx_has) {
                foreach ($rx_flags as $rx_key) {
                    if (isset($rx_row[$rx_key]) && $rx_row[$rx_key] == '1') {
                        $rx_has = true;
                        break;
                    }
                }
            }
            if ($rx_has) {
                $rx_lens_ids[$rx_row['appointment_id']] = true;
            }
        }
    }
}
$rx_sections = array(
    array('title' => 'Recetas de medicamentos', 'ids' => $rx_med_ids, 'doc' => 'tratamiento', 'empty' => 'Aún no hay recetas de medicamentos.'),
    array('title' => 'Recetas de lentes', 'ids' => $rx_lens_ids, 'doc' => 'lentes', 'empty' => 'Aún no hay recetas de lentes.')
);
?>
<?php foreach ($rx_sections as $rx_section): ?>
<div class="col-sm-12">
    <div class="card-widget">
        <h5 class="panel-content-title"><?php echo $rx_section['title']; ?></h5>
        <span class="app-divider2"></span>
        <?php
            $rx_found = false;
            foreach ($rx_apps as $rx_app) {
                if (isset($rx_section['ids'][$rx_app['appointment_id']])) {
                    $rx_found = true;
                    break;
                }
            }
        ?>
        <?php if ($rx_found): ?>
        <div class="table-responsive">
            <table class="table table-padded">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Especialista</th>
                        <th>Motivo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rx_apps as $rx_app): ?>
                    <?php if (!isset($rx_section['ids'][$rx_app['appointment_id']])) continue; ?>
                    <tr>
                        <td><?php echo $rx_app['date']; ?> <?php echo $rx_app['time']; ?></td>
                        <td><?php echo $this->accounts_model->short_name('admin', $rx_app['doctor_id']); ?></td>
                        <td><?php echo $rx_app['comment']; ?></td>
                        <td>
                            <a class="btn btn-primary btn-sm" target="_blank" href="<?php echo base_url().$rx_base; ?>/print_prescription_details/<?php echo $rx_app['appointment_id']; ?>/<?php echo $rx_section['doc']; ?>">Imprimir</a>
                            <a class="btn btn-info btn-sm" href="<?php echo base_url().$rx_base; ?>/appointment_details/<?php echo base64_encode($rx_app['appointment_id']); ?>">Ver cita</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <p><?php echo $rx_section['empty']; ?></p>
        <?php endif; ?>
    </div>
</div>
<?php endforeach; ?>
