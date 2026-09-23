<?php

include 'phpexcel/vendor/autoload.php';

defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;

class Importar extends CI_Controller {
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('user_agent');
        $this->load->library('session'); 
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache'); 
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

    }

    public function index() {
        $this->load->view('importar_excel');
    }

    public function excel() {

        if (!isset($_FILES['archivo'])) {
            show_error('No se envió archivo');
        }

        $archivo = $_FILES['archivo']['tmp_name'];

        $spreadsheet = IOFactory::load($archivo);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        // Quitar encabezado
        unset($rows[0]);

        foreach ($rows as $row) {

            /*
              A = No. Aro   -> $row[0]
              B = Nombre   -> $row[1]
              C = Costo    -> $row[2]
              D = Público  -> $row[3]
            */

            $code = trim($row[0]);
            $name = trim($row[1]);
            if ($name === '') continue;

            $cost  = $this->limpiar_moneda($row[2]);
            $price = $this->limpiar_moneda($row[3]);

            // Buscar producto por nombre
            $product = $this->db
                ->where('code', $code)
                ->get('product')
                ->row();

            if ($product) {

                // 🔁 Existe → sumar stock
                $this->db->set('stock', 'stock + 1', FALSE)
                         ->where('product_id', $product->product_id)
                         ->update('product');

            } else {

                // ➕ Nuevo producto
                $data = [
                    'name'            => $name,
                    'category_id'     => 14,          // default o variable
                    'clinic_id'       => 1,           // default o variable
                    'code'            => $code,       // código
                    'cost'            => $cost,
                    'price'           => $price,
                    'expiration_date' => null,        // si no viene en Excel
                    'stock'           => 1,
                    'amount_alert'    => 2,
                    'description'     => null,
                    'image'           => null
                ];

                $this->db->insert('product', $data);
            }
        }

        echo "Importación completada correctamente";
    }

    private function limpiar_moneda($valor) {
        $valor = str_replace(['Q', ',', ' '], '', $valor);
        return floatval($valor);
    }
}
