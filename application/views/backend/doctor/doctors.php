<?php 
    $week_days  = $this->crud_model->date_week(date('Y-m-d'));
    $week_name_days  = $this->crud_model->panelDate();
    $owner = $this->crud_model->account_owner();
?>
	<div id="main-content">
		
		    <?php if(count($doctors) > 0):?>
		    <div class="row">
		        <div class="col-sm-12">
		        <div class="title-header">
		            <h3 class="module-title">Doctores registrados</h3>
		            
		            <a class="add-buton pull-right" href="<?php echo base_url();?>doctor/new_doctor">+ Agregar Doctor</a>
		            
		        </div>
		    </div>
		    
		        <?php foreach($doctors as $row):?>
    		        <div class="col-sm-3">
    		        <div class="profile-tile profile-tile-inlined">
    		            <div class="profile-tile-box">
    		                <div class="tile-controls">
                                <div class="tile-settings os-dropdown-trigger">
                                    <i class="batch-icon-ellipsis"></i>
                                    <div class="os-dropdown">
                                        <div class="icon-w">
                                            <i class="picons-thin-icon-thin-0699_user_profile_avatar_man_male"></i>
                                        </div>
                                        <ul>
                                            <li><a href="<?php echo base_url();?>doctor/doctor_profile/<?php echo base64_encode($row['admin_id']);?>/"><i class="picons-thin-icon-thin-0699_user_profile_avatar_man_male"></i><span>Perfil</span></a></li>
                                            <li><a href="javascript:void(0);" onclick="delete_doctor('<?php echo $row['admin_id'];?>');"><i class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i><span>Eliminar</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
    		                <div class="pt-avatar-w"><img alt="" src="<?php echo $this->accounts_model->get_photo('admin', $row['admin_id']);?>"></div>
    		                <div class="pt-user-last"><?php echo $this->accounts_model->gender($row['admin_id']);?> <?php echo $this->accounts_model->short_name('admin', $row['admin_id']);?>.</div>
    		                <span class="badge badge-warning">@<?php echo $row['username'];?></span>
    		                <div class="pt-user-med">
    		                    <?php 
    		                        if($row['specialty_1'] > 0)
									{
    		                            echo $this->crud_model->getSpecialty($row['specialty_1']);   
    		                        }
    		                        if($row['specialty_2'] > 0)
									{
    		                            echo ' <span><i data-toggle="tooltip" data-placement="top" title="'.$this->crud_model->getSpecialty($row['specialty_2']).'" class="special picons-thin-icon-thin-0151_plus_add_new"></i></span>';   
    		                        }
    		                    ?>
    		                </div>
    		                <div class="pt-user-social">
    		                    <?php if($row['whatsapp'] == 1):?>
    		                        <a href="https://wa.me/502<?php echo $row['phone'];?>" target="_blank" class="no-decoration"><i class="icon-container picons-social-icon-whatsapp"></i></a>
    		                    <?php endif;?>
    		                    <?php if($row['facebook'] != ''):?>
    		                        <a href="<?php echo $row['facebook'];?>" class="no-decoration" target="_blank"><i class="icon-container picons-social-icon-facebook"></i></a>
    		                    <?php endif;?>
    		                    <?php if($row['instagram'] != ''):?>
        		                    <a href="<?php echo $row['instagram'];?>" class="no-decoration" target="_blank"><i class="icon-container picons-social-icon-instagram"></i></a>
    		                    <?php endif;?>
    		                    
    		                    <?php if($row['whatsapp'] != 1 && $row['facebook'] == '' && $row['instagram'] == ''):?>
    		                    <br>
    		                    <?php endif;?>
    		                </div>
    		                <div class="pt-user-name" onclick="window.location.href='<?php echo base_url();?>doctor/messages/<?php echo $row['username'];?>';">Mensaje</div>
    		            </div>
    		        </div>
    		    </div>
		        <?php endforeach;?>
		        </div>
		    <?php else:?>
                <div class="card-box">
		            <center><br><br><br>
		             <?php if($owner == 1):?>
		            <a class="add-buton pull-right" href="<?php echo base_url();?>doctor/new_doctor">+ Agregar Doctor</a>
		            <?php endif;?>
		                <h4 style="text-align:center;color:#4d4a81;margin-top:2%;">Aún no se tienen médicos registrados</h4>
                        <img src="<?php echo base_url();?>public/uploads/doctors.svg" style="width:18%"/>
                    </center>
                </div>
            
		    <?php endif;?>
		
	</div>


    <script type="text/javascript">
        $('.os-dropdown-trigger').on('mouseenter', function () {
        $(this).addClass('over');
    });
    $('.os-dropdown-trigger').on('mouseleave', function () {
        $(this).removeClass('over');
    });
  
    function delete_doctor(doctor_id)
    {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "También se eliminará toda la información asociada a este doctor.",
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#9fd13b',
            cancelButtonColor: '#fd4f57',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) 
            {
                location.href = "<?php echo base_url();?>doctor/doctors/delete/"+doctor_id;
            }
        })
    }
    </script>