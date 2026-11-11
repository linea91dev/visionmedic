<?php
    if (!isset($doc_type) || $doc_type != 'lentes') {
        include dirname(__FILE__).'/print_prescription_tratamiento.php';
        return;
    }
    include dirname(__FILE__).'/print_prescription_lentes.php';
    return;
