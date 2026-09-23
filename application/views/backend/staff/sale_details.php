    <div id="main-content">
        <?php
        $currency = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
        $cart_total = 0;
        $cart_id = base64_decode($id_);
        $this->db->where('cart_id', $cart_id);
        $info = $this->db->get('cart')->result_array();    
        foreach($info as $details):
        $prescription_id = $this->db->get_where('prescription', array('appointment_id' => $details['appointment_id']))->num_rows();?>
        
        <div class="row">
            <div class="col-md-8">
                <div class="order-box">
                    <div class="order-details-box">
                        <div class="order-main-info">
                            <strong style="font-size:25px;"> Detalles de venta</strong> 
                        </div>
                         <div class="dropdown" style="float:right">
                        <button class="btn btn-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="float:right; margin-top:15px;margin-right:10%;background:#0176fe; color:#fff; border:0px;border-radius:5px;-webkit-box-shadow: 0px 2px 14px rgba(1, 118, 254, 0.40); box-shadow: 0px 2px 14px rgba(1,118, 254, 0.40); ">
                            <i class="batch-icon-ellipsis"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width:auto; text-align:left;overflow-y:hidden">
                            <a class="dropdown-item" target="_blank" href="<?php echo base_url();?>staff/patient_profile/<?php echo base64_encode($details['patient_id']);?>/">Perfil del paciente</a>
                            <?php if($details['appointment_id'] != ''):?>
                            <a class="dropdown-item" target="_blank"href="<?php echo base_url();?>staff/print_receipt/<?php echo $details['appointment_id'];?>/<?php echo $details['patient_id'];?>">Imprimir recibo</a>
                            <?php if($prescription_id > 0):?>
                                <a class="dropdown-item" target="_blank"href="<?php echo base_url();?>staff/print_prescription_details/<?php echo $details['appointment_id'];?>">Imprimir receta</a>
                            <?php endif;?>
                            <a class="dropdown-item" href="<?php echo base_url();?>staff/sale_details/pdf/<?php echo $details['appointment_id'];?>/<?php echo $details['patient_id'];?>">Descargar PDF</a>
                            <a class="dropdown-item" href="javascript:void(0);" onclick="send_email(<?php echo $details['appointment_id'];?>,'<?php echo $details['patient_id'];?>')">Enviar por correo</a>
                            <?php elseif($details['appointment_id'] == null):?>
                            <a class="dropdown-item" target="_blank"href="<?php echo base_url();?>staff/print_receipt2/<?php echo $cart_id;?>/<?php echo $details['patient_id'];?>">Imprimir recibo</a>
                            <a class="dropdown-item" href="<?php echo base_url();?>staff/sale_details/pdf2/<?php echo $cart_id;?>/<?php echo $details['patient_id'];?>">Descargar PDF</a>
                            <a class="dropdown-item" href="javascript:void(0);" onclick="send_email_sin_receta(<?php echo $cart_id;?>,'<?php echo $details['patient_id'];?>')">Enviar por correo</a>
                            <?php endif;?>
                            
                        </div>
                    </div>
                    </div>
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
                  <div class="row"> 
                  <div class="table-responsive">
                  <table class="table">
                      
                          
                      
                      <tbody>
                          <tr>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                          </tr>
                      <?php  $detalles = unserialize($details['products']);  
                                foreach($detalles as $item): 
                                $cart_total += $item['ordered_quantity']*$item['selling_price'];
                            ?>
                      <tr>
                        <td style="display: table-cell;">
                            <div class="form-group">
                                <input id="" type="text" style="background:#fff;" value="<?php echo $this->db->get_where('product', array('product_id' => $item['variant_id']))->row()->name;?>" class="form-control" disabled="disabled">
                            </div>
                        </td>
                        <td style="display: table-cell;">
                            <div class="form-group">
                                <input id="" type="text" style="background:#fff;" value="<?php echo $currency.'. '.number_format($item['selling_price'],'2','.',',');?>" class="form-control" disabled="disabled">
                            </div>
                        </td>
                        <td style="display: table-cell;">
                            <div class="form-group">
                                <input id="" type="text" style="background:#fff;" value="<?php echo $item['ordered_quantity'];?>"  class="form-control" disabled="disabled">
                            </div>
                        </td>
                        <td style="display: table-cell;">
                            <div class="form-group">
                                <input id="" type="text" style="background:#fff;" value="<?php echo $currency.'. '.number_format($item['ordered_quantity']*$item['selling_price'],'2','.',',');?>"  class="form-control" disabled="disabled">
                            </div>
                        </td>
                      </tr>
                      <?php endforeach;?>
                      </tbody>
                  </table>
                  </div>
                  
                </div>

                        <div class="col-sm-12"><hr/></div>
					        
                            
				    </div>

                    </div>
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
                                <h5 class="order-section-heading">Resumen de la venta</h5>
                                <div class="order-summary-row">
                                    <div class="order-summary-label">
                                        <span>Método de pago</span>
                                    </div>
                                    <div class="order-summary-value"><?php if($details['payment_type'] == 1) echo 'Efectivo'; elseif($details['payment_type'] == 2) echo 'Tarjeta';  elseif($details['payment_type'] == 3) echo 'Depósito'; else echo 'n/d';?></div>
                                    </div>
                                    <div class="order-summary-row as-total">
                                        <div class="order-summary-label"><span>Total</span></div>
                                        <div class="order-summary-value"><?php echo $currency.'. '.number_format($details['total'],'2','.',',');?></div>
                                    </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            
            <div class="col-md-4">
                <div class="ecommerce-customer-info">
                    <h5 style="color:#43485c">Detalles del paciente</h5><hr>
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
                                <?php echo $this->db->get_where('patient', array('patient_id'=>$details['patient_id']))->row()->phone;?>
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
                                Fecha y hora de la venta
                            </div>
                            <div class="sub-info-value">
                                <span><?php echo $details['date'];?></span>
                            </div>
                        </div>
                        <div class="ecc-sub-info-row">
                            <div class="sub-info-label">
                                Responsable de la venta
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
    </div>
    <?php endforeach; ?>
    
    
    	<script type="text/javascript">
        function send_email(sale_id, element_id2)
        {
            Swal.fire({
                title: 'Confirmar esta acción',
                text: "Se enviará un correo al paciente con la información de la compra con su receta, si la tuviera. ¿Seguro deseas continuar?",
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#9fd13b',
                cancelButtonColor: '#fd4f57',
                confirmButtonText: 'Enviar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) 
                {
                    location.href = "<?php echo base_url();?>staff/sale_details/email/"+sale_id+'/'+element_id2;
                }
            })
        }
    </script>
    
    
    
    	<script type="text/javascript">
        function send_email_sin_receta(sale_id, element_id2)
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
                    location.href = "<?php echo base_url();?>staff/sale_details/email2/"+sale_id+'/'+element_id2;
                }
            })
        }
    </script>