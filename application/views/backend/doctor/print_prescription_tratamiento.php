<?php
    $cita = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row();
    $patient_id = $cita->patient_id;
    $paciente = trim(preg_replace('/\s+/', ' ', $this->accounts_model->get_full_name('patient', $patient_id)));
    $fecha = $cita->date;
    if (preg_match('/^\d{4}-\d{2}-\d{2}/', $fecha)) {
        $fecha = date('d/m/Y', strtotime($fecha));
    }
    $plan_dx = array();
    $plan_tx = array();
    if ($this->db->table_exists('appointment_plan_dx')) {
        $plan_dx = $this->db->order_by('dx_id', 'ASC')->get_where('appointment_plan_dx', array('appointment_id' => $appointment_id))->result_array();
    }
    if ($this->db->table_exists('appointment_plan_tx')) {
        $plan_tx = $this->db->order_by('tx_id', 'ASC')->get_where('appointment_plan_tx', array('appointment_id' => $appointment_id))->result_array();
    }
    $fondo = base64_encode(file_get_contents(dirname(__FILE__).'/receta_fondo.jpg'));
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receta</title>
    <style>
        @page { size: letter; margin: 0; }
        html, body { margin: 0; padding: 0; background: #fff; }
        .sheet {
            position: relative;
            width: 7.05in;
            height: 10.8in;
            margin: 0.08in auto 0;
            overflow: hidden;
        }
        .sheet .fondo {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }
        .dato {
            position: absolute;
            z-index: 1;
            font-family: Arial, Helvetica, sans-serif;
            color: #1a1a1a;
        }
        .paciente {
            left: 23.2%;
            top: 17.3%;
            width: 68%;
            font-size: 15pt;
            line-height: 1;
        }
        .fecha {
            left: 19.8%;
            top: 26.0%;
            width: 70%;
            font-size: 15pt;
            line-height: 1;
        }
        .rp {
            left: 7%;
            top: 34.4%;
            width: 86%;
            height: 46%;
            font-size: 12pt;
            line-height: 1.35;
            overflow: hidden;
        }
        .rp p { margin: 0 0 8px 0; }
        .med { margin: 0 0 10px 0; }
        .med .nombre { font-weight: 700; font-size: 13pt; }
        .med .detalle { margin-top: 1px; }
        @media print {
            html, body { background: #fff; }
            .sheet { margin: 0.08in auto 0; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="sheet">
        <img class="fondo" alt="" src="data:image/jpeg;base64,<?php echo $fondo; ?>">
        <div class="dato paciente"><?php echo htmlspecialchars($paciente); ?></div>
        <div class="dato fecha"><?php echo htmlspecialchars($fecha); ?></div>
        <div class="dato rp">
            <?php
                $diagnosticos = array();
                foreach ($plan_dx as $dx) {
                    if (isset($dx['diagnosis']) && trim($dx['diagnosis']) != '') {
                        $diagnosticos[] = $dx['diagnosis'];
                    }
                }
            ?>
            <?php if (count($diagnosticos) > 0): ?>
            <p><b>Diagnóstico:</b> <?php echo htmlspecialchars(implode(', ', $diagnosticos)); ?></p>
            <?php endif; ?>
            <?php $n = 0; foreach ($plan_tx as $tx): ?>
                <?php if (!isset($tx['nombre']) || trim($tx['nombre']) == '') continue; $n++; ?>
                <div class="med">
                    <div class="nombre"><?php echo $n.'. '.htmlspecialchars($tx['nombre']); ?><?php if (trim($tx['cantidad']) != ''): ?> <span style="font-weight:400;">— <?php echo htmlspecialchars($tx['cantidad']); ?></span><?php endif; ?></div>
                    <?php
                        $linea = array();
                        if (trim($tx['principio']) != '') $linea[] = $tx['principio'];
                        if (trim($tx['presentacion']) != '') $linea[] = $tx['presentacion'];
                        $uso = array();
                        if (trim($tx['dosis']) != '') $uso[] = 'Dosis: '.$tx['dosis'];
                        if (trim($tx['frecuencia']) != '') $uso[] = 'Frecuencia: '.$tx['frecuencia'];
                        if (trim($tx['aplicacion']) != '') $uso[] = 'Aplicación: '.$tx['aplicacion'];
                        if (trim($tx['duracion']) != '') $uso[] = 'Duración: '.$tx['duracion'];
                    ?>
                    <?php if (count($linea) > 0): ?><div class="detalle"><?php echo htmlspecialchars(implode(' · ', $linea)); ?></div><?php endif; ?>
                    <?php if (count($uso) > 0): ?><div class="detalle"><?php echo htmlspecialchars(implode(' · ', $uso)); ?></div><?php endif; ?>
                </div>
            <?php endforeach; ?>
            <?php if (trim($cita->doctor_comment) != ''): ?>
            <p><b>Indicaciones:</b> <?php echo nl2br(htmlspecialchars($cita->doctor_comment)); ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
