    <div class="white-box">
        <div class="os-tabs-w">
            <div class="os-tabs-controls">
                <ul class="navx nav-tabs">
                    <li class="nav-item text-center">
                        <a class="nav-link " href="<?php echo base_url();?>staff/settings/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0049_settings_panel_equalizer_preferences"></i></div> <span>Configuración</span>
                        </a>
                    </li>
                     <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>staff/forms/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0064_bullet_list_view"></i></div> <span>Formularios</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>staff/clinics/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0047_home_flat"></i></div> <span>Sucursales</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link current" href="<?php echo base_url();?>staff/services/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0813_heart_vitals_pulse_rate_health"></i></div> <span>Servicios</span>
                        </a>
                    </li>
                    <?php  
                    
                        $odonto = $this->db->get_where('clinic', array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->odonto;
                        if($odonto != ''):
                    
                    ?>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>staff/thooth_procedures/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0826_teeth_tooth_dental"></i></div> <span>Procedimientos</span>
                        </a>
                    </li>
                        <?php endif;?>

                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>staff/specialties/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0825_stetoscope_doctor_hospital_ill"></i></div><span>Especialidades</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>staff/laboratories/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0817_tube_laboratory_chemistry"></i></div><span>Laboratorios</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>staff/surveys/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0065_bullet_list_view"></i></div><span>Encuestas</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="main-content">
        <div class="card-box padding0"> 
			<div class="card-h customPadding noborder">
		        <h5 class="card-caption">Gestionar servicios</h5><a class="btn btn-info pull-right"  href="javascript:void(0)" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_service_add/');" style="margin-right:45px">Nuevo</a>
		    </div>
		    <div class="card-b">
		        <div class="container-fluid">
    			    <div class="alert alert-info">
            		    <span class="alert-title"><i class="batch-icon-spam"></i> Agrega, actualiza y elimina tus servicios médicos.</span>
            		    <span class="alert-content">Todos los servicios que agregues en esta sección serán visualizados al momento de crear una nueva <span class="alert-lined"><a href="<?php echo base_url();?>staff/appointment/" style="color:#0044e9">cita</a>.</span></span>
    		        </div>  
		        </div>
		        <div class="row">
		            <div class="col-md-12 col-lg-12 col-xl-12 m-b-30">
				        <div class="support-tablist-content tab-content">
					        <div class="main-table-card">
						        <div class="table-responsive">
						            <table class="table custom-table table-striped">
										<thead style="color: #a2a5b9;">
											<tr>
											    <th>ID</th>
												<th>Nombre</th>
												<th>Descripción</th>
												<th>Costo</th>
												<th>Acciones</th>
											</tr>
							 		    </thead>
										<tbody>
										<?php 
										    $n = 1;
			                                $this->db->order_by('name', 'ASC');
			                                $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
                                            $services = $this->db->get('service')->result_array();
			                                foreach($services as $row):
			                            ?>
										    <tr style="font-family:'Poppins';font-size:14px;font-weight:bold;color:#4b4a55" class="">
											    <td><?php echo sprintf('%04d', $row['service_id']);?></td>
												<td><span style="font-weight:normal"><?php echo $row['name'];?></span></td>
									  	        <td><span style="font-weight:normal"><?php echo $row['description'];?></span></td>
											    <td><span class="badge badge-info">&bull; <?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;?> <?php echo number_format($row['cost'],2,".",",");?></span></td>
											    <td>
										            <a href="javascript:void(0);" style="text-decoration:none;" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_service/<?php echo $row['service_id'];?>');"><i style="vertical-align:-3px;color:#a7aabb;font-size:18px;font-weight:bold;" class="picons-thin-icon-thin-0002_write_pencil_new_edit"></i></a>
													<?php if($row['service_id'] != 21 && $row['service_id'] != 23 ):?>
												    	<a href="javascript:void(0);" style="text-decoration:none;" onclick="delete_service('<?php echo $row['service_id'];?>')"><i style="vertical-align:-3px;color:#a7aabb;font-size:18px;font-weight:bold;" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></a>
													<?php endif;?>
												  </td>
													
											</tr>
									    <?php endforeach;?>
										</tbody>
									</table>
								</div>
					        </div>
		                </div>
			        </div>	
				</div>	
			</div>	
		</div>
	</div>

<script type="text/javascript">
        function delete_service(service_id)
        {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción no puede deshacerse. ¿Aún así, desea continuar?",
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#9fd13b',
                cancelButtonColor: '#fd4f57',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) 
                {
                    location.href = "<?php echo base_url();?>staff/services/delete/"+service_id;
                }
            })
        }
    </script>