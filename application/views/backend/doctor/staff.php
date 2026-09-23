	<div id="main-content">
	    <?php if(count($staff)> 0):?>
		<div class="row">
		    <div class="col-sm-12">
		        <div class="title-header">
		            <h3 class="module-title">Personal registrado</h3>
		            <a class="add-buton pull-right" href="javascript:void(0);" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_new_staff');">+ Agregar Personal</a>
		        </div>
		    </div>
		    <?php foreach($staff as $row):?>
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
                                            <li><a href="<?php echo base_url();?>doctor/staff_profile/<?php echo base64_encode($row['staff_id']);?>/"><i class="picons-thin-icon-thin-0699_user_profile_avatar_man_male"></i><span>Perfil</span></a></li>
                                            <li><a href="javascript:void(0);" onclick="delete_staff('<?php echo $row['staff_id'];?>');"><i class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i><span>Eliminar</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
    		                <div class="pt-avatar-w"><img style="width: 60px;height: 60px;" src="<?php echo $this->accounts_model->get_photo('staff', $row['staff_id']);?>"></div>
    		                <div class="pt-user-last"><?php echo $this->accounts_model->short_name('staff', $row['staff_id']);?>.</div>
    		                <span class="badge badge-info">@<?php echo $row['username'];?></span><br><br>
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
    		                    
    		                </div>
    		                <div class="pt-user-name" onclick="window.location.href='<?php echo base_url();?>doctor/messages/<?php echo $row['username'];?>';">Mensaje</div>
    		            </div>
    		        </div>
    		    </div>
		    <?php endforeach;?>
		</div>
		<?php else:?>
		<div class="row">
		    <div class="col-sm-12">
		        <div class="title-header">
		            <h3 class="module-title">Personal registrado</h3>
		            <a class="add-buton pull-right" href="javascript:void(0);" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_new_staff');">+ Agregar Personal</a>
		        </div>
		    </div>
		    <div class="col-sm-12">
		        <div class="card-box">
                    <center><br>
                        <h4 style="text-align:center;color:#4d4a81;margin-top:2%;">Aún no se tiene personal registrado</h4><br>
                        <img src="<?php echo base_url();?>public/uploads/personal.svg" style="width:15%"/>
                    </center>
                </div>
            </div>
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
    </script>
    
    	<script type="text/javascript">

     function delete_staff(staff_id)
        {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "También se eliminará toda la información asociada a este usuario.",
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#9fd13b',
                cancelButtonColor: '#fd4f57',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) 
                {
                    location.href = "<?php echo base_url();?>doctor/staff/delete/"+staff_id;
                }
            })
        }
    
   /*     $(document).ready(function() {
	        $('input[name="photo"]').fileuploader({
	            theme: 'default',
		    });
		    $('input[name="signature"]').fileuploader({
	            theme: 'default',
		    });
        });
     */   
        

  </script>