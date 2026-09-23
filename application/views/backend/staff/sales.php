    <div class="white-box">
        <div class="os-tabs-w">
            <div class="os-tabs-controls">
                <ul class="navx nav-tabs">
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>staff/inventory/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0820_medicine_drugs_ill_pill"></i></div> <span>Productos</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>staff/categories/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0172_structure_menu_submenu_navigation"></i></div> <span>Categorías</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link current" href="<?php echo base_url();?>staff/sales/">
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
                <div class="title-header">
		            <h3 class="module-title">Control de ventas</h3><br>
		            <?php if(!$this->crud_model->checkMobile()):?>
		                <a class="add-buton pull-right" href="<?php echo base_url();?>staff/new_sale/">+ Nueva venta</a>
		            <?php endif;?>
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
                                            <th>ID</th>
                                            <th>Paciente</th>
                                            <th>Responsable</th>
                                            <th>Método de pago</th>
                                            <th>Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                            <th>Fecha</th>
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
                url:"<?php echo base_url() . 'staff/getTable/sales'; ?>",  
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
    <script type="text/javascript">

    function delete_sale(sale_id)
    {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "También se eliminará toda la información asociada a esta venta.",
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#9fd13b',
            cancelButtonColor: '#fd4f57',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) 
            {
                location.href = "<?php echo base_url();?>staff/sales/delete/"+sale_id;
            }
        })
    }
    </script>
	