    <?php
        $this->db->where('product_id', $param2);
        $products = $this->db->get('product')->result_array();
        foreach($products as $row):
    ?>
        <div class="modal-content animated fadeInDown">
	         <div class="modal-header" style="background-color:#fff;" >
    			<h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';">
			    <span style="vertical-align:-3px">Actualizar producto</span></h4>
			    <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo base_url();?>doctor/inventory/update/<?php echo $row['product_id'];?>" method="POST"  enctype="multipart/form-data">
			    <div class="modal-body">
					    <div class="form-group">
		                    <div class="container">
		                        <div class="row">
		                            <div class="col-sm-9">
		                                <div class="form-group m-b-15">
        		                            <label for="simpleinput">Producto</label>
		                                    <input type="text" name="name" required="" value="<?php echo $row['name'] ?>" class="form-control">
		                                </div>
		                            </div>
		                            <div class="col-sm-3">
		                                <div class="form-group m-b-15">
        		                            <label for="simpleinput">Código</label>
		                                    <input type="text" name="code" required="" value="<?php echo $row['code'] ?>" class="form-control">
		                                </div>
		                            </div>
		                            <div class="col-sm-6">
		                                <div class="form-group m-b-15">
        		                            <label for="simpleinput">Imagén</label>
        		                            <label class="labelx" for="apply"><input type="file" name="image" class="inputx" id="apply" accept="image/*">Seleccionar</label>
    		                                <small id="fileResponse"></small>
		                                </div>
		                            </div>
		                            <div class="col-sm-6">
		                                <div class="form-group m-b-15">
        		                            <label for="simpleinput">Categoría</label>
		                                    <div class="form-group">
										        <select class="itemName form-control" style="width:100%" required="" name="category_id">
										            <option value="">Seleccionar</option>
										            <?php 
            									        $categories = $this->db->get('category')->result_array();
            									        foreach($categories as $cat):
            									    ?>
									                    <option value="<?php echo $cat['category_id'];?>" <?php if($cat['category_id'] == $row['category_id']) echo "selected";?> ><?php echo $cat['name'];?></option>
									                <?php endforeach;?>
										        </select>
										    </div>
		                                </div>
		                            </div>
		                            <div class="col-sm-6">
		                                <div class="form-group date-time-picker m-b-15">
        		                            <label for="simpleinvput">Fecha de vencimiento</label>
		                                    <div class="input-group date datepicker" id="ckerExample">
    									        <input type="text" name="expiration_date" class="form-control" required="" value="<?php echo $row['expiration_date'];?>" ><span style="display:none;" class="input-group-addon"><i  data-feather="calendar"></i></span>
								            </div>
		                                </div>
		                            </div>
		                            <div class="col-sm-6">
		                                <div class="form-group m-b-15">
        		                            <label for="simpleinput">Costo</label>
		                                    <input type="number" name="cost" required="" value="<?php echo $row['cost'] ?>" class="form-control">
		                                </div>
		                            </div>
		                            <div class="col-sm-6">
		                                <div class="form-group m-b-15">
        		                            <label for="simpleinput">Precio</label>
		                                    <input type="number" name="price" required="" value="<?php echo $row['price'] ?>" class="form-control">
		                                </div>
		                            </div>
		                            <div class="col-sm-6">
		                                <div class="form-group m-b-15">
        		                            <label for="simpleinput">Cantidad disponible</label>
		                                    <input type="number" name="stock" required="" value="<?php echo $row['stock'] ?>" class="form-control">
		                                </div>
		                            </div>
		                            <div class="col-sm-12">
		                                <div class="form-group m-b-15">
        		                            <label for="simpleinput">Cantidad en alerta</label>
		                                    <input type="number" name="amount_alert" required="" value="<?php echo $row['amount_alert'] ?>" class="form-control">
		                                </div>
		                            </div>
		                             <div class="col-sm-12">
		                                <div class="form-group m-b-15">
        		                            <label for="simpleinput">Descripción</label>
		                                    <textarea type="text" name="description" class="form-control"><?php echo $row['description']?></textarea>
		                                </div>
		                            </div>
		                        </div>
		                    </div>
    		            </div> 		
		        </div>
				<div class="modal-footer">
				    <button type="submit" class="button-confirm">Actualizar</button>
				</div>
			</form>	    </div>
	<?php endforeach;?>
	
	<script>
	document.getElementById('apply').onchange = function () {
   var filename = this.value.replace(/C:\\fakepath\\/i, '')
   $( "#fileResponse" ).html('<b>Archivo seleccionado:</b> '+filename);
};
        $(function() {
            'use strict';
            if($('#ckerExample').length) {
                var date = new Date();
                var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
                $('#ckerExample').datepicker({
                    format: "dd/mm/yyyy",
                    todayHighlight: true,
                    autoclose: true
                });
            }
        });
    </script>























