    <div class="white-box">
        <div class="os-tabs-w">
            <div class="os-tabs-controls">
                <ul class="navx nav-tabs">
                    <li class="nav-item text-center">
                        <a class="nav-link current" href="<?php echo base_url();?>staff/inventory/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0820_medicine_drugs_ill_pill"></i></div> <span>Productos</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>staff/categories/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0172_structure_menu_submenu_navigation"></i></div> <span>Categorías</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>staff/sales/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0466_shopping_cart_basket_store_successful"></i></div><span>Ventas</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="main-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="title-header"><br>
		            <h3 class="module-title">Control de inventario</h3>
		            <a class="add-buton pull-right" href="javascript:void(0);" data-toggle="modal" data-target="#1new_product">+ Nuevo Producto</a>
		        </div>
            </div>
            <div class="col-md-12">
		        <div class="card-b">
		            <div class="row">
		                <div class="col-sm-12">
		                    <div class="table-responsive">
		                        <table class="table table-padded" id="user_data">
            	    			    <thead>
                                        <tr>
                                            <th class="text-right">#</th>
                                            <th>Codigo</th>
                                            <th>Nombre del producto</th>
        						            <th>Vencimiento</th>
        						            <th>Categoria</th>
        						            <th>Costo&nbsp;&nbsp;&nbsp;</th>
        						            <th>Precio&nbsp;&nbsp;&nbsp;</th>
        						            <th>Stock</th>
        						            <th>Disponibilidad</th>
        						            <th>Acciones</th>
                                        </tr>
                                    </thead>
            				    </table>
		                    </div>
		                </div>
		            </div>
		        </div> 
	        </div>
	    </div>
	</div>
	
	<script type="text/javascript" language="javascript" >  
        $(document).ready(function(){  
        var dataTable = $('#user_data').DataTable({  
            "processing":true,  
            "serverSide":true,  
            "order":[],  
            "ajax":{  
                url:"<?php echo base_url() . 'staff/getTable/inventory'; ?>",  
                type:"POST"  
            },  
            
                "columnDefs":[  
                {  
                    "targets":0,  
                    "orderable":false,  
                },],  
            });  
        });  
    </script>
    
    
    
    <script src="<?php echo base_url();?>public/assets/back/js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/back/js/colorPick.js"></script>
	<script src="<?php echo base_url();?>public/assets/back/js/moment.min.js"></script>
	<script src="<?php echo base_url();?>public/assets/back/js/tempusdominus-bootstrap-4.js"></script>
	<script src="<?php echo base_url();?>public/assets/back/js/timepicker.js"></script>
	<script src="<?php echo base_url();?>public/assets/back/js/settings.js"></script>
    <script type="text/javascript">
        $(function()
        {
            <?php if($this->crud_model->check_item('send_survey') == 0):?>
                $("#send_survey").hide();
            <?php endif;?>
            <?php if($this->crud_model->check_item('send_schedule') == 0):?>
                $("#send_schedule").hide();
            <?php endif;?>
            <?php if($this->crud_model->check_item('send_reminder') == 0):?>
                $("#send_reminder").hide();
            <?php endif;?>
        });
  </script>
  
    
    <div class="modal" id="1new_product">
		<div class="modal-dialog modal-dialog-centered modal-lg" >
			<div class="modal-content animated fadeInDown">
			    <form action="<?php echo base_url();?>staff/inventory/create" method="POST" enctype="multipart/form-data">
				    <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;" >
					    <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i> Agregar nuevo producto a inventario.</span></h4>
    					<button type="button" class="close" data-dismiss="modal">&times;</button>
				    </div>
				    <div class="modal-body">
					    <div class="form-group">
		                    <div class="container">
		                        <div class="row">
		                            <div class="col-sm-12">
		                                <div class="form-group m-b-15">
        		                            <label for="simpleinput">Producto</label>
		                                    <input type="text" name="name" required="" class="form-control">
		                                </div>
		                            </div>
		                            <div class="col-sm-4">
		                                <div class="form-group m-b-15">
        		                            <label for="simpleinput">Imagén</label>
        		                            <label class="labelx" for="apply"><input type="file" name="image" class="inputx" id="apply" accept="image/*">Seleccionar</label>
                                            <small id="fileResponse"></small>
		                                </div>
		                            </div>
		                            <div class="col-sm-4">
		                                <div class="form-group m-b-15">
        		                            <label for="simpleinput">Código</label>
		                                    <input type="text" name="code" required="" class="form-control">
		                                </div>
		                            </div>
		                            <div class="col-sm-4">
		                                <div class="form-group m-b-15">
        		                            <label for="simpleinput">Categoría</label>
		                                    <div class="form-group">
										        <select class="itemName form-control" style="width:100%" required="" name="category_id">
										            <option value="">Seleccionar</option>
										            <?php 
            									        $categories = $this->db->get('category')->result_array();
            									        foreach($categories as $cat):
            									    ?>
									                    <option value="<?php echo $cat['category_id'];?>"><?php echo $cat['name'];?></option>
									                <?php endforeach;?>
										        </select>
										    </div>
		                                </div>
		                            </div>
		                            <div class="col-sm-6">
		                                <div class="form-group date-time-picker m-b-15">
        		                            <label for="simpleinvput">Fecha de vencimiento</label>
		                                    <div class="input-group date datepicker" id="datePickerExample">
    									        <input type="text" name="expiration_date" required="" class="form-control"><span style="display:none;" class="input-group-addon"><i  data-feather="calendar"></i></span>
								            </div>
		                                </div>
		                            </div>
		                            <div class="col-sm-6">
		                                <div class="form-group m-b-15">
        		                            <label for="simpleinput">Costo</label>
		                                    <input type="number" name="cost" required="" class="form-control">
		                                </div>
		                            </div>
		                            <div class="col-sm-6">
		                                <div class="form-group m-b-15">
        		                            <label for="simpleinput">Precio</label>
		                                    <input type="number" name="price" required="" class="form-control">
		                                </div>
		                            </div>
		                            
		                            <div class="col-sm-6">
		                                <div class="form-group m-b-15">
        		                            <label for="simpleinput">Cantidad disponible</label>
		                                    <input type="number" name="stock" required="" class="form-control">
		                                </div>
		                            </div>
		                            <div class="col-sm-6">
		                                <div class="form-group m-b-15">
        		                            <label for="simpleinput">Cantidad en alerta</label>
		                                    <input type="number" name="amount_alert" required="" class="form-control">
		                                </div>
		                            </div>
		                             <div class="col-sm-12">
		                                <div class="form-group m-b-15">
        		                            <label for="simpleinput">Descripción</label>
		                                    <textarea type="text" name="description" class="form-control"></textarea>
		                                </div>
		                            </div>
		                        </div>
		                    </div>
    		            </div> 
		            </div>
				    <div class="modal-footer">
					        <button type="submit" class="button-confirm">Guardar</button>
				    </div>
				</form>
			</div>
		</div>
	</div>
	<link href="<?php echo base_url();?>public/assets/appointments/css/select2.css" rel="stylesheet" />
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
	
	<script type="text/javascript">
        $('.itemName').select2();
    </script>
    
    <script>
    document.getElementById('apply').onchange = function () {
   var filename = this.value.replace(/C:\\fakepath\\/i, '')
   $( "#fileResponse" ).html('<b>Archivo seleccionado:</b> '+filename);
};
       
    </script>
    

    <script type="text/javascript">
        function delete_inventory(product_id)
        {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "También se eliminará toda la información asociada al producto.",
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#9fd13b',
                cancelButtonColor: '#fd4f57',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) 
                {
                    location.href = "<?php echo base_url();?>staff/inventory/delete/"+product_id;
                }
            })
        }
    </script>