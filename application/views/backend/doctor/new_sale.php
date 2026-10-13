
    <div id="main-content">
        <link href="<?php echo base_url();?>public/assets/appointments/css/select2.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    
    <form action="<?php echo base_url();?>doctor/inventory/confirm" method="POST">
        <div class="row"> 
            <div class="col-md-12">
                <div class="order-box">
                    <div class="order-details-box">
                        <div class="order-main-info">
                            <strong style="font-size:38px;">Formulario de ventas</strong>
                        </div>
                    </div>
                    <hr>
                    <div class="order-items-table">
                    <style>
		                .dropdown-menu {
			                overflow-y: scroll;
			                max-height: 250px !important;
		                }
	                </style>
                    <link rel="stylesheet" href="<?php echo base_url();?>public/assets/search/estilo.css">
					<div class="social-l col-lg-12 col m-b-30">
					    <div class="order-controls">
                            <div class="form-inline">
                                <div class="form-group">
                                    <label for="">Paciente</label>
                                    <div style="margin-bottom:8px;">
                                        <label style="margin-right:12px;font-weight:400;"><input type="radio" name="patient_type" value="existente" checked onchange="toggleNewPatient()"> Existente</label>
                                        <label style="font-weight:400;"><input type="radio" name="patient_type" value="nuevo" onchange="toggleNewPatient()"> Nuevo</label>
                                    </div>
									<select class="form-control form-control-sm" style="min-width:100%" name="patient_id" id="patient_id" required="">
										<option value=""  >Seleccionar</option>
										            <?php 
										                $query = $this->db->get_where('patient', array('status' => '1','clinic_id' => $this->session->userdata('current_clinic')))->result_array();
                                                        foreach($query as $pat):
                                                    ?>
										                <option value="<?php echo $pat['patient_id'];?>"><?php echo $this->accounts_model->get_name('patient', $pat['patient_id']);?></option>
										            <?php endforeach;?>
										        </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control form-control-sm" name="method" required="">
                                    <option value="">Método de pago</option>
                                    <option value="1">Efectivo</option>
                                    <option value="2">Tarjeta</option>
                                    <option value="3">Depósito</option>
                                </select>
                            </div>
                        </div>
                        <div id="new_patient_fields" style="display:none;width:100%;margin-top:10px;">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>Primer nombre</label>
                                        <input type="text" class="form-control" name="first_name" id="sale_first_name">
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Segundo nombre</label>
                                        <input type="text" class="form-control" name="second_name">
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Primer apellido</label>
                                        <input type="text" class="form-control" name="last_name" id="sale_last_name">
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Segundo apellido</label>
                                        <input type="text" class="form-control" name="second_last_name">
                                    </div>
                                    <div class="col-sm-3" style="margin-top:8px;">
                                        <label>Teléfono</label>
                                        <input type="text" class="form-control" name="phone" id="sale_phone" maxlength="15">
                                    </div>
                                </div>
                            </div>
                    </div>
                    
                    
					    <div class="col-md-12">
                  <div class="row" style="overflow-x:auto"> 
                    <div class="col-md-3" style="width: 100%;">
                        <strong>Producto</strong>
                    </div>
                    <div class="col-md-2" style="width: 10%;">
                        <strong>Precio</strong>
                    </div>
                    <div class="col-md-2" style="width: 9%; text-align: center;">
                        <strong>Stock</strong>
                    </div>
                    <div class="col-md-2" style="width: 9%;">
                        <strong>Cantidad</strong>
                    </div>
                    <div class="col-md-2" style="width: 12%; text-align: center;">
                        <strong>Sub total</strong>
                    </div>
                    <div class="col-md-1" style="width: 12%; text-align: center;">
                        <strong>Acciones</strong>
                    </div>
                </div>

                    <div class="col-sm-12"><hr/></div>
					    <div id="sales_order_entry_1">
                            <div class="row"> 
                                <div class="col-md-3" style="width: 100%;">
                                    <select class="itemName form-control select2" onchange="show_response(this.value)">
                                        <option value="">Seleccione</option>
                                        <?php 
                                            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
                                            $products = $this->db->get('product')->result_array();
                                            foreach($products as $row):
                                            $stock_quantity = $row['stock'];
                                        ?>
                                            <option value="<?php echo $row['product_id'];?>" <?php if($stock_quantity == 0) echo 'disabled';?>>
                                                <?php echo  $row['name']; ?>
                                                <?php if($stock_quantity == 0) echo '[' . "Sin existencias" . ']';?>
                                            </option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div class="col-sm-2" style="width: 10%;">
                                    <input id="" type="text" class="form-control" disabled="disabled">
                                </div>
                                <div class="col-sm-2" style="width: 9%;">
                                    
                                </div>
                                <div class="col-sm-2" style="width: 9%;">
                                    <input id="" type="text" class="form-control" disabled="disabled">
                                </div>
                                <div class="col-sm-2" style="width: 12%;">
                                    <input id="" type="text" class="form-control" disabled="disabled">
                                </div>
                                <div class="col-sm-1" style="width: 2%;">
                                    <center><i class="batch-icon-bin-3" style="color: #676767; cursor: pointer;"
                                        onclick="deleteParentElement(this)"></i></center>
                                </div>
                        </div>                    
                    </div>
                    <div id="sales_order_entry_append"></div>
				    </div>
				     <div class="col-sm-12" style="margin-top: 15px;">
                        <button type="button" id="add_entry_button" class="btn btn-info btn-sm" onclick="append_sales_order_entry()">Agregar otro producto</button>
                    </div>
	 	                
                    </div>
                    <div class="col-sm-12" style="margin-top: 15px;">
                    <div class="order-foot">
                        <div class="row">
                            <div class="col-md-7 mb-4">
                                <h5>Nota: </h5>
                                <div class="form-group">
                                    <textarea class="form-control" name="description" placeholder="Escribe una nota a esta venta..." rows="7"></textarea>
                                </div>
                            </div>
                            <div class="col-md-5 mb-4">
                                <h5>Pago</h5>
                                <div class="order-summary-row">
                                    <div class="order-summary-label"><span>Total</span></div>
                                    <div class="order-summary-value" id="grand_total">0.00</div>
                                </div>
                                <input type="hidden" name="sale_total" id="sale_total_raw" value="0">
                                <div class="form-group" style="margin-top:12px;">
                                    <label>Anticipo</label>
                                    <input type="number" step="0.01" min="0" class="form-control" name="anticipo" id="anticipo" placeholder="Vacío = cobrar el total" onkeyup="updateSaldo()" onchange="updateSaldo()">
                                </div>
                                <div class="order-summary-row">
                                    <div class="order-summary-label"><span>Saldo pendiente</span></div>
                                    <div class="order-summary-value" id="saldo_pendiente">0.00</div>
                                </div>
                                <button class="btn btn-success" type="submit" style="margin-top:12px;">Confirmar venta</button>
                            </div>
                            
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
    </div>
    <script src="<?php echo base_url();?>public/assets/search/bootstrap3-typeahead.js"></script>
    <script>
        $('.itemName').select2();
        $('.itemName1').select2();
        function toggleNewPatient() {
            var isNew = $('input[name="patient_type"]:checked').val() == 'nuevo';
            $('#new_patient_fields').toggle(isNew);
            $('#patient_id').prop('required', !isNew).prop('disabled', isNew);
            $('#sale_first_name, #sale_last_name, #sale_phone').prop('required', isNew);
        }
    </script>
    <script type="text/javascript">
    var count = 1;

    function show_response(variant_id)
    {
        $.ajax({
            url: '<?php echo base_url();?>doctor/sales_order_entry_response/' + variant_id,
            success: function(response)
            {
                jQuery('#sales_order_entry_1').html(response);
            }
        });
    }
    function append_sales_order_entry()
    {
        var selected_variants = '';
        $(".variant").each(function() {
            selected_variants += $(this).val() + '.';
            console.log(selected_variants);
        });
        count++;
        $.ajax({
            url: '<?php echo base_url();?>doctor/sales_order_append_entry_response/' + count + '/' + selected_variants,
            success: function(response)
            {
                jQuery('#sales_order_entry_append').append(response);
            }
        });
    }
    function deleteParentElement(n)
    {
        n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
        calculate_grand_total();
    }
    function updateSaldo()
    {
        var text = $('#grand_total').text() || '0';
        var total = parseFloat(String(text).replace(/[^0-9.\-]/g, '')) || 0;
        $('#sale_total_raw').val(total.toFixed(2));
        var raw = $('#anticipo').val();
        var paid = raw === '' ? total : parseFloat(String(raw).replace(',', '.'));
        if (isNaN(paid) || paid < 0) paid = 0;
        if (paid > total) paid = total;
        var saldo = Math.round((total - paid) * 100) / 100;
        $('#saldo_pendiente').text(saldo.toFixed(2));
    }
    </script>
 