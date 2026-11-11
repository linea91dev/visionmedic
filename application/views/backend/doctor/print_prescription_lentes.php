<?php
    $cita = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row();
    $paciente = trim(preg_replace('/\s+/', ' ', $this->accounts_model->get_full_name('patient', $cita->patient_id)));
    $fecha = $cita->date;
    if (preg_match('/^\d{4}-\d{2}-\d{2}/', $fecha)) {
        $fecha = date('d/m/Y', strtotime($fecha));
    }
    $rx = array();
    if ($this->db->table_exists('appointment_oftalmology')) {
        $rx_row = $this->db->get_where('appointment_oftalmology', array('appointment_id' => $appointment_id))->row_array();
        if (is_array($rx_row)) {
            $rx = $rx_row;
        }
    }
    $rxv = function($key) use ($rx) {
        return isset($rx[$key]) ? trim($rx[$key]) : '';
    };
    $material = array();
    if ($rxv('rx_lente_monofocal') == '1') $material[] = 'Monofocal';
    if ($rxv('rx_lente_progresivo') == '1') $material[] = 'Progresivo';
    if ($rxv('rx_lente_bifocal') == '1') $material[] = 'Bifocal';
    if ($rxv('rx_lente_otro') == '1') $material[] = 'Otro';
    if ($rxv('rx_rec_policarbonato') == '1') $material[] = 'Policarbonato';
    $obs = array();
    if ($rxv('rx_comentario') != '') $obs[] = $rxv('rx_comentario');
    if ($rxv('rx_rec_filtro') == '1') $obs[] = 'Filtro de luz azul';
    if ($rxv('rx_rec_antireflejo') == '1') $obs[] = 'Antireflejo';
    if ($rxv('rx_rec_polarizado') == '1') $obs[] = 'Polarizado'.($rxv('rx_rec_polarizado_nota') != '' ? ' '.$rxv('rx_rec_polarizado_nota') : '');
    if ($rxv('rx_rec_sol') == '1') $obs[] = 'Lentes de sol';
    if ($rxv('rx_rec_tenido') == '1') $obs[] = 'Teñido'.($rxv('rx_rec_tenido_nota') != '' ? ' '.$rxv('rx_rec_tenido_nota') : '');
    if ($rxv('rx_rec_transitions') == '1') $obs[] = 'Transitions'.($rxv('rx_rec_transitions_nota') != '' ? ' '.$rxv('rx_rec_transitions_nota') : '');
    if ($rxv('rx_rec_otros') == '1') $obs[] = 'Otros';
    foreach (array('od' => 'OD', 'os' => 'OI') as $ojo => $ojo_label) {
        foreach (array('final' => 'Lejos', 'add' => 'Add') as $grupo => $grupo_label) {
            $prisma = $rxv('rx_'.$grupo.'_'.$ojo.'_prisma');
            $base = $rxv('rx_'.$grupo.'_'.$ojo.'_base');
            if ($prisma != '' || $base != '') {
                $obs[] = $grupo_label.' '.$ojo_label.' prisma '.$prisma.($base != '' ? ' base '.$base : '');
            }
        }
    }
    $fondo = base64_encode(file_get_contents(dirname(__FILE__).'/receta_lentes_fondo.jpg'));
    $celdas = array(
        array('top' => '33.68%', 'eye' => 'od', 'group' => 'final'),
        array('top' => '40.72%', 'eye' => 'os', 'group' => 'final'),
        array('top' => '47.90%', 'eye' => 'od', 'group' => 'add'),
        array('top' => '54.79%', 'eye' => 'os', 'group' => 'add')
    );
    $columnas = array(
        'esf' => array('left' => '21.97%', 'width' => '17.58%'),
        'cil' => array('left' => '40.23%', 'width' => '17.58%'),
        'eje' => array('left' => '58.69%', 'width' => '17.38%')
    );
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receta de lentes</title>
    <style>
        @page { size: letter landscape; margin: 0; }
        html, body { margin: 0; padding: 0; background: #fff; }
        .sheet {
            position: relative;
            width: 11in;
            height: 7.18in;
            margin: 0.66in auto 0;
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
            line-height: 1;
            white-space: nowrap;
            overflow: hidden;
        }
        .lugar { left: 25%; top: 21.2%; width: 44%; font-size: 13pt; }
        .paciente { left: 18%; top: 25.5%; width: 50%; font-size: 13pt; }
        .celda {
            position: absolute;
            z-index: 1;
            height: 5.8%;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13pt;
            font-weight: 700;
            color: #1a1a1a;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .dip { left: 14%; top: 63.2%; width: 78%; font-size: 13pt; }
        .material { left: 17.5%; top: 69.5%; width: 75%; font-size: 12pt; }
        .obs { left: 24%; top: 75.8%; width: 68%; font-size: 12pt; }
        @media print {
            html, body { background: #fff; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="sheet">
        <img class="fondo" alt="" src="data:image/jpeg;base64,<?php echo $fondo; ?>">
        <div class="dato lugar"><?php echo htmlspecialchars($fecha); ?></div>
        <div class="dato paciente"><?php echo htmlspecialchars($paciente); ?></div>
        <?php foreach ($celdas as $celda): ?>
            <?php foreach ($columnas as $parte => $col): ?>
            <div class="celda" style="left:<?php echo $col['left']; ?>;top:<?php echo $celda['top']; ?>;width:<?php echo $col['width']; ?>;"><?php echo htmlspecialchars($rxv('rx_'.$celda['group'].'_'.$celda['eye'].'_'.$parte)); ?></div>
            <?php endforeach; ?>
        <?php endforeach; ?>
        <div class="dato dip"><?php echo htmlspecialchars($rxv('rx_dip')); ?></div>
        <div class="dato material"><?php echo htmlspecialchars(implode(', ', $material)); ?></div>
        <div class="dato obs"><?php echo htmlspecialchars(implode('. ', $obs)); ?></div>
    </div>
</body>
</html>
