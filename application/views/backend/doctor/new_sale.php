
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
									<select class="form-control form-control-sm" style="min-width:100%" name="patient_id"  required="">
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
                            <div class="col-md-12 mb-4">
                                <h5>Nota: </h5>
                                <div class="form-group">
                                    <textarea class="form-control" name="description" placeholder="Escribe una nota a esta venta..." rows="7"></textarea>
                                </div>
                                <button class="btn btn-success" type="submit">Confirmar venta</button>
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
    </script>
 