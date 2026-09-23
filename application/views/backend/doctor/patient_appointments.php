<?php 
    $patient_id = base64_decode($id_);
    $this->db->where('patient_id', $patient_id);
    $info = $this->db->get('patient')->result_array();    
    foreach($info as $details):
?>
    <div class="todo-app-w">
        <div class="todo-sidebar">
        <div id="sticky">
            <div class="todo-sidebar-section" style="border-bottom:0px">
                <div class="todo-sidebar-section-contents">
                    <ul class="tasks-list">
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/patient_profile/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0002_write_pencil_new_edit"></i> Editar perfil </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/medical_history/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0299_address_book_contacts"></i> Historial </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/patient_security/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0705_user_profile_security_password_permissions"></i> Contraseña y seguridad </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/medical_prescriptions/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0003_write_pencil_new_edit"></i> Recetas </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/patient_files/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0119_folder_open_full_documents"></i> Archivos </a>
                        </li>
                        <?php  
                            $odonto = $this->db->get_where('clinic', array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->odonto;
                            if($odonto != ''):
                        ?>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/treatment/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0826_teeth_tooth_dental"></i> Planes de tratamiento </a>
                        </li>
                        <?php endif;?>
                        <li class="side-li">
                            <a class="side-items active" href="<?php echo base_url();?>doctor/patient_appointments/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0021_calendar_month_day_planner"></i> Citas <span class="side-active"></span></a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/patient_financial/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0425_money_payment_dollar_cash"></i> Financiero </a>
                        </li>
                        <li class="side-li" style="border:none"></li>
                        <li class="side-li" style="border:none"></li>
                    </ul>
                </div>
            </div>
            </div>
        </div>
    <div class="todo-content">
        <h4 class="todo-content-header">
            <i class="batch-icon-arrow-right"></i><span>Historial de citas - <?php echo $this->accounts_model->get_name('patient',$details['patient_id']);?></span>
        </h4>
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-info">
                    <span class="alert-title"><i class="batch-icon-spam"></i> Historial de citas.</span>
                    <span class="alert-content">Gestiona todas las citas que haz tenido con tu paciente desde el primer <span class="alert-lined"><a href="javascript:void(0);" style="color:#0044e9">día</a>.</span></span>
                </div>  
            </div>
            <div class="col-sm-12">
                <div class="row">
		            <div class="col-sm-12 col-xl-3">
		                <a class="element-box el-tablo centered trend-in-corner smaller" href="javascript:void(0);" style="cursor:pointer;">
                            <div class="label">
                                Citas reprogramadas
                            </div>
                            <div class="value">
                                <?php echo $this->db->get_where('appointment',array('clinic_id'=>$this->session->userdata('current_clinic'),'patient_id'=>$patient_id,'status'=> 3))->num_rows(); ?>
                            </div>
                        </a>
			        </div>
			        <div class="col-sm-12 col-xl-3">
			            <a class="element-box el-tablo centered trend-in-corner smaller" href="javascript:void(0);" style="cursor:pointer;">
                            <div class="label">
                                Citas canceladas
                            </div>
                            <div class="value">
                                <?php echo $this->db->get_where('appointment',array('clinic_id'=>$this->session->userdata('current_clinic'),'patient_id'=>$patient_id,'status'=> 2))->num_rows(); ?>
                            </div>
                        </a>
			        </div>
			        <div class="col-sm-12 col-xl-3">
			            <a class="element-box el-tablo centered trend-in-corner smaller" href="javascript:void(0);" style="cursor:pointer;">
                            <div class="label">
                                Citas finalizadas
                            </div>
                            <div class="value">
                                <?php echo $this->db->get_where('appointment',array('clinic_id'=>$this->session->userdata('current_clinic'),'patient_id'=>$patient_id,'status'=> 1))->num_rows(); ?>
                            </div>
                        </a>
			        </div>
			        <div class="col-sm-12 col-xl-3">
			            <a class="element-box el-tablo centered trend-in-corner smaller" href="javascript:void(0);" style="cursor:pointer;">
                            <div class="label">
                                Citas pendientes y confirmadas
                            </div>
                            <div class="value">
                                <?php echo $this->crud_model->count_patient_archived($patient_id); ?>
                            </div>
                        </a>
			        </div>
			    </div><br>
            </div>
            <div class="col-sm-12">
                <div class="tasks-section">
                    <div class="table-responsive">
                	    <table class="table table-padded" id="user_data">
            	            <thead>
                                <tr>
                                   <th>#</th>
        					       <th>Paciente</th>
            					   <th>Especialista</th>
            					   <th>Fecha & Hora</th>
            					   <th>Estado</th>
                                </tr>
                            </thead>
            			</table>
            	    </div>
                </div>
            </div>
        </div>
    </div>
</div>
   
    
    <script src="<?php echo base_url();?>public/assets/theme/js/sticky-sidebar.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/jquery.sticky.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/PositionSticky/dist/PositionSticky.js"></script>
    <script type="text/javascript" language="javascript" >  
        $(document).ready(function(){  
        var dataTable = $('#user_data').DataTable({  
            "processing":true,  
            "serverSide":true,  
            "order":[],  
            "ajax":{  
                url:"<?php echo base_url() . 'doctor/getTable/patient_appointments/'.$patient_id; ?>",  
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
    <script>
    var sidebar = new StickySidebar('#sticky', {topSpacing: 0});
        $('.ae-side-menu-toggler').on('click', function () {
            $('.app-side').toggleClass('compact-side-menu');
        });
        if ($('.app-side').length) {
            if (is_display_type('phone') || is_display_type('tablet')) {
                $('.app-side').addClass('compact-side-menu');
            }
        }
    </script>
<?php  endforeach; ?>