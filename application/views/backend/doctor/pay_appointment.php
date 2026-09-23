    <style>
        @media (max-width: 768px) {
            .order-box {
                padding: 15px;
            }
            .order-box .order-items-table {
                text-align: center;
                border-bottom: none;
                margin-bottom: 0px;
            }
            .order-box .order-items-table .quantity-input .form-control {
                -webkit-box-flex: 1;
                    flex: 1;
            }
            .order-box .order-items-table .product-price {
                font-size: 1.5rem;
                color: #047bf8;
            }
            .order-box .order-items-table .product-image {
                max-width: 120px;
                max-height: 120px;
                margin: 0px auto;
            }
            .order-box .order-items-table .product-remove-btn {
                position: absolute;
                top: 10px;
                right: 0px;
                font-size: 24px;
            }
            .order-box .order-items-table .table thead {
                display: none;
            }
            .order-box .order-items-table .table tbody tr {
                display: block;
                border-bottom: 1px solid #eee;
                position: relative;
            }
            .order-box .order-items-table .table tbody tr td {
                display: block;
                border: none;
                padding: 5px;
            }
            .ecommerce-customer-info {
                margin-top: 20px;
            }
        }
        .box-style,.invoice-w, .order-box, .ecommerce-customer-info {
            border-radius: 6px;
            background-color: #fff;
            box-shadow: 0px 2px 4px rgba(126,142,177,0.12);
        }
        .order-box {
            padding: 30px;
        }
        .order-box .order-details-box {
            display: -webkit-box;
            display: flex;
            -webkit-box-pack: justify;
            justify-content: space-between;
            margin-bottom: 20px;
            -webkit-box-align: center;
            align-items: center;
        }
        .order-box .order-details-box .order-main-info span {
            display: block;
            color: #adb5bd;
            line-height: 1.3;
        }
        .order-box .order-details-box .order-main-info strong {
            display: block;
            font-size: 1.5rem;
            line-height: 1.3;
        }
        .order-box .order-details-box .order-sub-info span {
            display: block;
            color: #adb5bd;
            line-height: 1.3;
            font-size: 0.775rem;
        }
        .order-box .order-details-box .order-sub-info strong {
            display: block;
            font-size: 0.9rem;
            line-height: 1.3;
        }
        .order-box .order-controls {
            background-color: #FFF7EA;
            border: 1px solid #E9D9C1;
            padding: 10px;
            margin-bottom: 20px;
        }
        .order-box .order-controls .form-group {
            margin-right: 15px;
            padding-right: 15px;
            border-right: 1px solid rgba(0, 0, 0, 0.05);
        }
        .order-box .order-controls .form-group label {
            margin-right: 5px;
        }
        .order-box .order-controls .form-group:last-child {
            border-right: none;
            margin-right: 0px;
            padding-right: 0px;
            margin-left: auto;
        }
        .order-box .order-items-table {
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }
        .order-box .order-items-table .product-image {
            width: 70px;
            height: 70px;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center center;
        }
        .order-box .order-items-table .product-name {
            font-weight: 500;
            font-size: 1.25rem;
            line-height: 1.3;
        }
        .order-box .order-items-table .product-remove-btn {
            color: #E08989;
            font-size: 16px;
        }
        .order-box .order-items-table .product-details {
            color: #adb5bd;
            font-size: 0.8rem;
        }
        .order-box .order-items-table .product-details strong {
            color: #3E4B5B;
        }
        .order-box .order-items-table .product-details .color-box {
            width: 10px;
            height: 10px;
            display: inline-block;
            margin-left: 5px;
            margin-right: 10px;
        }
        .order-box .order-items-table .product-price {
            font-weight: 500;
            font-size: 1.25rem;
        }
        .order-box .order-items-table .quantity-input .input-group-text {
            padding-left: 5px !important;
            padding-right: 5px !important;
        }
        .order-box .order-items-table .quantity-input .form-control {
            -webkit-box-flex: 0;
            flex: 0 0 45px;
            text-align: center;
            font-weight: 500;
        }
        .order-box .order-section-heading {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .ecommerce-customer-info {
            padding: 30px;
        }
        .ecommerce-customer-info .ecommerce-customer-main-info {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        .ecommerce-customer-info .ecommerce-customer-main-info .ecc-avatar {
            width: 90px;
            height: 90px;
            background-size: cover;
            background-position: center center;
            border-radius: 50%;
            background-color: #fff;
            margin: 0px auto;
            box-shadow: 0px 0px 0px 10px #fff;
        }
        .ecommerce-customer-info .ecommerce-customer-main-info .ecc-name {
            margin-top: 10px;
            font-weight: 500;
            font-size: 1.25rem;
        }
        .ecommerce-customer-info .ecommerce-customer-sub-info {
            margin-bottom: 30px;
        }
        .ecommerce-customer-info .ecc-sub-info-row {
            margin-bottom: 10px;
        }
        .ecommerce-customer-info .ecc-sub-info-row + .ecc-sub-info-row {
            padding-top: 10px;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }
        .ecommerce-customer-info .ecc-sub-info-row .sub-info-label {
            display: block;
            color: #adb5bd;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.8rem;
            margin-bottom: 4px;
        }
        .ecommerce-customer-info .ecc-sub-info-row .sub-info-value {
            display: block;
        }
        .ecommerce-customer-info .ecc-sub-info-row .sub-info-value img {
            margin-right: 5px;
        }
        .ecommerce-customer-info .os-tabs-controls .nav {
            flex-wrap: nowrap;
        }
        .ecommerce-customer-info .os-tabs-controls .nav-link {
            white-space: nowrap;
            padding: 10px 0px;
        }
        .order-summary-row {
            display: -webkit-box;
            display: flex;
            -webkit-box-pack: justify;
                justify-content: space-between;
            -webkit-box-align: center;
                align-items: center;
        }
        .order-summary-row.as-total .order-summary-label {
            font-weight: 500;
            font-size: 1.25rem;
            color: #3E4B5B;
        }
        .order-summary-row.as-total .order-summary-value {
            font-weight: 500;
            font-size: 1.5rem;
        }
        .order-summary-row .order-summary-label {
            color: #adb5bd;
        }
        .order-summary-row .order-summary-label strong {
            display: block;
            color: #3E4B5B;
            font-size: 0.8rem;
        }
        .order-summary-row .order-summary-value {
            font-weight: 500;
        }
        .order-summary-row + .order-summary-row {
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            padding-top: 5px;
            margin-top: 5px;
        }
        .order-summary-row + .order-summary-row.as-total {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 3px solid #222;
        }
    </style>
     <link href="<?php echo base_url();?>public/assets/appointments/css/select2.css" rel="stylesheet" />
    <div id="main-content">
        <?php
        $currency = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
        $cart_total = 0;
        $_id = base64_decode($id_);
        $this->db->where('appointment_id', $_id);
        $num = $this->db->get('cart')->num_rows();
        $prescription_id = $this->db->get_where('prescription', array('appointment_id' => $_id))->num_rows();
        if($num==0){
        $this->db->where('appointment_id', $_id);
        $info = $this->db->get('appointment')->result_array();    
        foreach($info as $details):?>
        
        <div class="row">
            <div class="col-md-8">
                <div class="order-box">
                    <div class="order-details-box">
                        <div class="order-main-info">
                            <strong style="font-size:38px;"> Detalles de la cita</strong> 
                        </div>
                         <div class="dropdown" style="float:right">
                        <button class="btn btn-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="float:right; margin-top:15px;margin-right:10%;background:#0176fe; color:#fff; border:0px;border-radius:5px;-webkit-box-shadow: 0px 2px 14px rgba(1, 118, 254, 0.40); box-shadow: 0px 2px 14px rgba(1,118, 254, 0.40); ">
                            <i class="batch-icon-ellipsis"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width:auto; text-align:left;overflow-y:hidden">
                            <a class="dropdown-item"  href="<?php echo base_url();?>doctor/patient_profile/<?php echo base64_encode($details['patient_id']);?>">Perfil del paciente</a>
                            <?php if($prescription_id > 0):?>
                            <a class="dropdown-item" target="_blank"href="<?php echo base_url();?>doctor/print_prescription_details/<?php echo $_id;?>">Imprimir receta</a>
                            <?php endif;?>
                            <a class="dropdown-item" href="<?php echo base_url();?>doctor/sale_details/pdf/<?php echo $_id;?>/<?php echo $details['patient_id']?>">Descargar PDF</a>
                        </div>
                    </div>
                    </div>
                    <hr>
                     <h4>Cargos de la consulta</h4>
                    <hr style="width:700px">
                    <div>
                        <table style="width:90%">
                            <tbody >
                                <tr style="font-family:'Poppins';font-size:14px;">
                                <td >
                                    <b>Valor de la consulta:</b>
                                </td>
                                <td class="text-right">
                                    <strong><?php echo $currency.'. '.number_format($details['charges'],'2','.',','); ?></strong>
                                </td>
                                </tr>    
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <h4>Medicamentos</h4>
                    <div class="order-items-table">
                        <form action="<?php echo base_url();?>doctor/inventory/confirm_appointment" method="POST">
                            <input type="hidden" name="patient_id" value="<?php echo $details['patient_id']?>" />
                            <input type="hidden" name="method" value="1" />
                            <input type="hidden" name="appointment_id" value="<?php echo $_id;?>" />
                            
                            <div class="row"> 
                                <div class="col-md-12">
                                    <div>
                                       
                                        <div class="order-items-table">
                                        <style>
                    		                .dropdown-menu {
                    			                overflow-y: scroll;
                    			                max-height: 250px !important;
                    		                }
                    	                </style>
                                        <link rel="stylesheet" href="<?php echo base_url();?>public/assets/search/estilo.css">
                    					<div class="social-l col-lg-12 col m-b-30">
                                        
                    				<div class="col-md-12">
                                            <div class="col-sm-12"><hr/></div>
                    					    <div id="sales_order_entry_1">
                                                <div class="row"> 
                                                <div class="col-md-3" style="width: 100%;">
                                                    <select class="itemName form-control  select2" onchange="show_response(this.value)">
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
                                            <button type="button" id="add_entry_button" class="btn btn-info btn-sm" onclick="append_sales_order_entry()" disabled>Agregar otro producto</button>
                                        </div>
                    	 	                
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                     
                    <style>
		                .dropdown-menu {
			                overflow-y: scroll;
			                max-height: 250px !important;
		                }
	                </style>
                    <link rel="stylesheet" href="<?php echo base_url();?>public/assets/search/estilo.css">
					<div class="social-l col-lg-12 col m-b-30">

                    

                    </div>
                    <div class="col-sm-12" style="margin-top: 15px;">
                    <div class="order-foot">
                        <div class="row">
                            <div class="col-md-7">
                                
                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        <h5>Nota</h5>
                                        <div class="form-group">
                                            <textarea class="form-control" name="description" placeholder="Escribe una nota a esta consulta..." rows="7"></textarea>
                                        </div>
                                        <button class="btn btn-success" type="submit">Confirmar consulta</button>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-md-5" id="resumen">
                                <h5 class="order-section-heading">Resumen de la consulta</h5>
                             
                                <div class="order-summary-row">
                                    <div class="order-summary-label">
                                        <span>Método de pago</span>
                                    </div>
                                    <div class="order-summary-value"><?php echo 'n/d';?></div>
                                </div>
                                <div class="order-summary-row">
                                    <div class="order-summary-label">
                                        <span>Consulta</span>
                                    </div>
                                     <div  id="sb_total" class="order-summary-value" style="display:none"><?php echo $details['charges'] ;?></div>
                                    <div  class="order-summary-value"><?php echo $currency.'. '.$details['charges'] ;?></div>
                                </div>
                            
                                <div class="order-summary-row as-total" id="tot">
                                    <div class="order-summary-label"><span>Total</span></div>
                                    <div id="grand_total" class="order-summary-value"><?php echo $currency.'. '.number_format($details['charges'],'2','.',',');?></div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </form>   
                </div>
            </div>
            </div>
            
            <div class="col-md-4">
                <div class="ecommerce-customer-info">
                    <h3 style="color:#43485c">Detalles del paciente</h3><hr>
                    <div class="ecommerce-customer-main-info">
                        <div class="ecc-avatar" style="background-image: url(<?php echo $this->accounts_model->get_photo('patient',$details['patient_id']);?>)"></div>
                        <div class="ecc-name">
                            <?php echo $this->accounts_model->short_name('patient', $details['patient_id']);?>
                        </div>
                    </div>
                    <div class="ecommerce-customer-sub-info">
                        <div class="ecc-sub-info-row">
                            <div class="sub-info-label">
                                Correo
                            </div>
                            <div class="sub-info-value">
                               <?php echo $this->db->get_where('patient', array('patient_id'=>$details['patient_id']))->row()->email;?>
                            </div>
                        </div>
                        <div class="ecc-sub-info-row">
                            <div class="sub-info-label">
                                Celular
                            </div>
                            <div class="sub-info-value">
                                +502 <?php echo $this->db->get_where('patient', array('patient_id'=>$details['patient_id']))->row()->phone;?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="ecc-sub-info-row">
                            <div class="sub-info-label">
                                Dirección
                            </div>
                            <div class="sub-info-value">
                                <p><?php echo $this->db->get_where('patient', array('patient_id'=>$details['patient_id']))->row()->address;?></p>
                            </div>
                        </div>
                        <div class="ecc-sub-info-row">
                            <div class="sub-info-label">
                                Fecha y hora de la consulta
                            </div>
                            <div class="sub-info-value">
                                <span><?php echo $details['date']." ".$details['time'];?></span>
                            </div>
                        </div>
                        <div class="ecc-sub-info-row">
                            <div class="sub-info-label">
                                Responsable de la consulta
                            </div>
                            <div class="sub-info-value">
                                <span>
                                    <?php echo $this->accounts_model->short_name('admin',$details['doctor_id']);?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    <?php 
    
    endforeach; 
    
        }else
        {
        $cart_total = 0;
        $this->db->where('appointment_id', $_id);
        $info = $this->db->get('cart')->result_array();    
        foreach($info as $details): ?>
        <div class="row">
            <div class="col-md-8">
                <div class="order-box">
                    <div class="order-details-box">
                        <div class="order-main-info">
                            <strong style="font-size:38px;"> Detalles de la consulta</strong> 
                        </div>
                         <div class="dropdown" style="float:right">
                        <button class="btn btn-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="float:right; margin-top:15px;margin-right:10%;background:#0176fe; color:#fff; border:0px;border-radius:5px;-webkit-box-shadow: 0px 2px 14px rgba(1, 118, 254, 0.40); box-shadow: 0px 2px 14px rgba(1,118, 254, 0.40); ">
                            <i class="batch-icon-ellipsis"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width:auto; text-align:left;overflow-y:hidden">
                            <a class="dropdown-item" target="_blank" href="<?php echo base_url();?>doctor/patient_profile/<?php echo base64_encode($details['patient_id']);?>/">Perfil del paciente</a>
                            <a class="dropdown-item" href="<?php echo base_url();?>doctor/pay_appointment/email/<?php echo $_id;?>/<?php echo $details['patient_id']?>">Enviar recibo por correo</a>
                            <?php if($prescription_id > 0):?>
                            <a class="dropdown-item" target="_blank"href="<?php echo base_url();?>doctor/print_prescription_details/<?php echo $_id;?>">Imprimir receta</a>
                            <?php endif;?>
                            <a class="dropdown-item" target="_blank"href="<?php echo base_url();?>doctor/print_receipt/<?php echo $_id;?>/<?php echo $details['appointment_id']?>">Imprimir recibo</a>
                            <?php if($prescription_id > 0):?>
                            <a class="dropdown-item" href="<?php echo base_url();?>doctor/sale_details/pdf/<?php echo $_id;?>/<?php echo $details['patient_id']?>">Descargar PDF</a>
                            <?php endif;?>
                            
                        </div>
                    </div>
                    </div>
                    <hr>
                    <h4>Cargos de la consulta</h4>
                    <hr style="width:700px">
                    <div>
                        <table style="width:90%">
                            <tbody >
                                <tr style="font-family:'Poppins';font-size:14px;">
                                <td >
                                    <b>Valor de la consulta:</b>
                                </td>
                                <td class="text-right">
                                    <strong><?php echo $currency.'. '.number_format($appointment_total=$this->db->get_where('appointment', array('appointment_id' => $_id))->row()->charges,'2','.',','); ?></strong>
                                </td>
                                </tr>    
                            </tbody>
                        </table>
                    </div>
                    <hr>


					<div class="social-l col-lg-12 col m-b-30">
                    <?php 
                    
                        $detalles = unserialize($details['products']); 
                        $med_count = count($detalles);
                        if($med_count != 0):
                    
                    
                    ?>
                    
				<div class="col-md-12">
				                        <h4>Medicamentos</h4>
				                        <hr style="width:500px">
                    <div class="order-items-table">
                    <style>
		                .dropdown-menu {
			                overflow-y: scroll;
			                max-height: 250px !important;
		                }
	                </style>
                    <link rel="stylesheet" href="<?php echo base_url();?>public/assets/search/estilo.css">    
				    
                  <div class="row"> 
                    <div class="col-md-6" style="width: 100%;">
                        <strong>Producto</strong>
                    </div>
                    <div class="col-md-2" style="width: 10%;">
                        <strong>Precio</strong>
                    </div>
                    <div class="col-md-2" style="width: 9%;">
                        <strong>Cantidad</strong>
                    </div>
                    <div class="col-md-2" style="width: 9%;">
                        <strong>Subtotal</strong>
                    </div>
                </div>

                        <div class="col-sm-12"><hr/></div>
					        <?php  
                                foreach($detalles as $item): 
                                $cart_total += $item['ordered_quantity']*$item['selling_price'];
                            ?>
                            <div class="row"> 
                            
                                <div class="col-sm-12" >
                                    <div class="row"> 
                                <div class="col-md-6" style="width: 100%;">
                                    <div class="form-group">
                                        <?php echo $this->db->get_where('product', array('product_id' => $item['variant_id']))->row()->name;?>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                    <?php echo $currency.'. '.number_format($item['selling_price'],'2','.',',');?>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                    <?php echo $item['ordered_quantity'];?>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                    <?php echo $currency.'. '.number_format($item['ordered_quantity']*$item['selling_price'],'2','.',',');?>
                                    </div>
                                </div>
                             </div>
                            </div>
                            <hr>
                        </div>  
                        <?php endforeach;
                            
                        ?>
				    </div>

                    </div>
                    <?php  endif; ?>
                    
                    <div class="col-sm-12" style="margin-top: 15px;">
                    <div class="order-foot">
                        <div class="row">
                            <div class="col-md-7">
                                <h5>Nota</h5>
                                <div class="form-group">
                                    <textarea readonly class="form-control" style="background:#fff;" name="description" rows="7"><?php echo $details['description'];?></textarea>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <h5 class="order-section-heading">Resumen de la consulta</h5>
                                <div class="order-summary-row">
                                    <div class="order-summary-label">
                                        <span>Método de pago</span>
                                    </div>
                                    
                                    
                                    <div class="order-summary-value"><?php if($details['method'] == 1) echo 'Efectivo';if($details['method'] == 2) echo 'Tarjeta'; if($details['method'] ==1) echo 'Depósito'; else echo 'n/d';?></div>
                                </div>
                                <div class="order-summary-row">
                                    <div class="order-summary-label">
                                        <span>Consulta</span>
                                    </div>
                                    <div class="order-summary-value"><?php echo $currency.'. '.$appointment_total=$this->db->get_where('appointment', array('appointment_id' => $_id))->row()->charges;?></div>
                                </div>
                                <?php foreach($detalles as $item): ?>
                                <div class="order-summary-row">
                                    <div class="order-summary-label">
                                        <span><?php echo $this->db->get_where('product', array('product_id' => $item['variant_id']))->row()->name;?></span>
                                    </div>
                                    <div class="order-summary-value"> <?php echo $currency.'. '.number_format($item['ordered_quantity']*$item['selling_price'],'2','.',',');?></div>
                                </div>
                                <?php endforeach;?>
                                    <div class="order-summary-row as-total">
                                        <div class="order-summary-label"><span>Total</span></div>
                                        <div class="order-summary-value"><?php echo $currency.'. '.number_format($details['total'] + $appointment_total ,'2','.',',');?></div>
                                    </div>
                            </div>
                             <div class="col-sm-12" style="margin-top: 15px;">
                                <button type="button" class="btn btn-info" onclick="window.location.href='<?php echo base_url();?>doctor/print_receipt/<?php echo $_id;?>/<?php echo $details['appointment_id']?>'">Imprimir recibo</button>
                             </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            
            <div class="col-md-4">
                <div class="ecommerce-customer-info">
                    <h3 style="color:#43485c">Detalles del paciente</h3><hr>
                    <div class="ecommerce-customer-main-info">
                        <div class="ecc-avatar" style="background-image: url(<?php echo $this->accounts_model->get_photo('patient',$details['patient_id']);?>)"></div>
                        <div class="ecc-name">
                            <?php echo $this->accounts_model->short_name('patient', $details['patient_id']);?>
                        </div>
                    </div>
                    <div class="ecommerce-customer-sub-info">
                        <div class="ecc-sub-info-row">
                            <div class="sub-info-label">
                                Correo
                            </div>
                            <div class="sub-info-value">
                               <?php echo $this->db->get_where('patient', array('patient_id'=>$details['patient_id']))->row()->email;?>
                            </div>
                        </div>
                        <div class="ecc-sub-info-row">
                            <div class="sub-info-label">
                                Celular
                            </div>
                            <div class="sub-info-value">
                                +<?php echo $this->db->get_where('patient', array('patient_id'=>$details['patient_id']))->row()->phone;?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="ecc-sub-info-row">
                            <div class="sub-info-label">
                                Dirección
                            </div>
                            <div class="sub-info-value">
                                <p><?php echo $this->db->get_where('patient', array('patient_id'=>$details['patient_id']))->row()->address;?></p>
                            </div>
                        </div>
                        <div class="ecc-sub-info-row">
                            <div class="sub-info-label">
                                Fecha y hora de la consulta
                            </div>
                            <div class="sub-info-value">
                                <span><?php echo $details['date'];?></span>
                            </div>
                        </div>
                        <div class="ecc-sub-info-row">
                            <div class="sub-info-label">
                                Responsable de la consulta
                            </div>
                            <div class="sub-info-value">
                                <span>
                                    <? 
                                        if($details['user_type'] == 'admin')
                                        {
                                            echo $this->accounts_model->gender($details['user_id']);
                                        }
                                    ?>  
                                    <?php echo $this->accounts_model->short_name($details['user_type'],$details['user_id']);?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   
    <?php 
    endforeach; };
    ?>
    
    </div>
    <script src="<?php echo base_url();?>public/assets/theme/js/select2.min.js"></script>
    	<script type="text/javascript">

$('.itemName').select2();


        function send_email(app_id)
        {
            Swal.fire({
                title: 'Confirmar esta acción',
                text: "Se enviará un correo al paciente con la información de la compra. ¿Seguro deseas continuar?",
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#9fd13b',
                cancelButtonColor: '#fd4f57',
                confirmButtonText: 'Enviar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) 
                {
                    location.href = "<?php echo base_url();?>doctor/pay_appointment/email/"+app_id;
                }
            })
        }
    </script>
     <script src="<?php echo base_url();?>public/assets/search/bootstrap3-typeahead.js"></script>
    <script>

    </script>
    <script type="text/javascript">
    
    var count = 1;
 var total = 0;
  var totalSum = 0;
    function show_response(variant_id)
    {
        $.ajax({
            url: '<?php echo base_url();?>doctor/sales_order_entry_response/' + variant_id,
            success: function(response)
            {
                
                jQuery('#sales_order_entry_1').html(response);
                 $('#add_entry_button').prop('disabled' , false);
                
            }
        });
    }
    function append_sales_order_entry()
    {
        var selected_variants = '';
        $(".variant").each(function() {
            selected_variants += $(this).val() + '.';
          
        });
        count++;
        $.ajax({
            url: '<?php echo base_url();?>doctor/sales_order_append_entry_response/' + count + '/' + selected_variants,
            success: function(response)
            {
                jQuery('#sales_order_entry_append').append(response);
                $('#add_entry_button').prop('disabled' , true);
                              

            }
        });
    }
    function deleteParentElement(n)
    {
        n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
        calculate_grand_total();
    }
    

    </script>
 