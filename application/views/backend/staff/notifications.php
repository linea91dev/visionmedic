    <?php    $staff_id = $id_; ?>
    <div class="todo-app-w">
        <div class="todo-sidebar">
        <div id="sticky">
            <div class="todo-sidebar-section" style="border-bottom:0px">
                <div class="todo-sidebar-section-contents">
                    <ul class="tasks-list">
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>staff/doctor_profile/<?php echo base64_encode($staff_id);?>/"><i style="padding-right: 10px;    font-size: 22px;" class="picons-thin-icon-thin-0002_write_pencil_new_edit"></i><?php if($owner == 1):?> Editar perfil <?php else:?> Ver perfil<?php endif;?></a>
                        </li>
                        <li class="side-li">
                            <a class="side-items active" href="<?php echo base_url();?>staff/notifications/<?php echo base64_encode($staff_id);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0543_world_earth_worldwide_location_travel"></i> Notificaciones <span class="side-active"></span> </a>
                        </li>
                        <?php if($owner == 1):?>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>staff/doctor_security/<?php echo base64_encode($staff_id);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0705_user_profile_security_password_permissions"></i> Contraseña y seguridad </a>
                        </li>
                        <?php endif;?>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>staff/doctor_activity/<?php echo base64_encode($staff_id);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0244_text_bullets_list"></i> Registro de Actividad </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>staff/doctor_calendar/<?php echo base64_encode($staff_id);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i> Calendario </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>staff/doctor_appointments/<?php echo base64_encode($staff_id);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0021_calendar_month_day_planner"></i> Citas </a>
                        </li>
                        <?php if($owner == 1):?>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>staff/doctor_permissions/<?php echo base64_encode($staff_id);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0015_fountain_pen"></i> Permisos </a>
                        </li>
                        <?php endif;?>
                    </ul>
                </div>
                </div>
            </div>
        </div>
    <div class="todo-content">
       
        <div class="row">
            <div class="col-sm-9" style="float: none; margin: 0 auto;">
                 <h4 class="todo-content-header">
                    <i class="batch-icon-arrow-right"></i><span>Centro de notificaciones - <?php echo $this->session->userdata('login_user_id').$this->accounts_model->get_name('staff',$staff_id);?></span>
                </h4>
                <div class="alert alert-info">
                    <span class="alert-title"><i class="batch-icon-spam"></i> Mantente informado.</span>
                    <span class="alert-content">Aquí podrás visualizar todas las notificaciones de <span class="alert-lined"><a href="javascript:void(0);" style="color:#0044e9">Medicaby</a></span> y así mantenerte al tanto de lo que sucede, puedes eliminarlas o marcarlas como leídas.</span>
                </div>  
                <br>
                <div class="tasks-section" style="background: #fff; border-radius: 10px; padding: 12px;">
                    <?php 
                      $this->db->order_by('notification_id', 'DESC');
                      $notifications = $this->db->get_where('notification', array('to_user' => $staff_id,'to_type' => 'staff'));
                        if($notifications->num_rows() > 0):
                        ?>
                        <div class="tasks-list-w">
                            <ul class="tasks-list">
                                <?php
                                    foreach($notifications->result_array() as $dm):
                                ?>
                                <a style="text-decoration:none;color:#000" href="<?php echo $dm['url'];?>">
                                    <li class="draggable-task <?php if($dm['read_status'] == 0):?> danger <?php else:?> success <?php endif;?>">
                                        <div class="todo-task-drag drag-handle">
                                            <i class="os-icon os-icon-hamburger-menu-2 drag-handle"></i>
                                        </div>
                                        <div class="todo-task success">
                                            <span><?php echo $dm['message'];?> </span><br><small><?php echo $dm['date'];?></small>
                                            <?php if($dm['to_user'] == $this->session->userdata('login_user_id')):?>
                                            <div class="todo-task-buttons">
                                                <?php if($dm['read_status'] == 0):?>
                                                    <a class="task-btn-done" onclick="mark_read(<?php echo $dm['notification_id'];?>)" href="javascript:void(0);"><span>Marcar como leída</span><i class="picons-thin-icon-thin-0154_ok_successful_check"></i></a>
                                                <?php endif;?>
                                                <a class="task-btn-delete" onclick="delete_this(<?php echo $dm['notification_id'];?>)" href="javascript:void(0);"><span>Eliminar</span><i class="picons-thin-icon-thin-0057_bin_trash_recycle_delete_garbage_full"></i></a>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </li>
                                </a>
                                <?php endforeach;?>
                            </ul>
                        </div>
                        <?php else:?>
                            <div class="tasks-list-w">
                                No tienes notificaciones.
                            </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url();?>public/assets/back/js/jquery-3.1.1.min.js"></script>
    
	    
    <script>
        $('.ae-side-menu-toggler').on('click', function () {
            $('.app-side').toggleClass('compact-side-menu');
        });
        if ($('.app-side').length) {
            if (is_display_type('phone') || is_display_type('tablet')) {
                $('.app-side').addClass('compact-side-menu');
            }
        }
    </script>
 






 
 
    
    <script type="text/javascript">
        function mark_read(notification_id)
        {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "La notificación se marcará como leída",
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#9fd13b',
                cancelButtonColor: '#fd4f57',
                confirmButtonText: 'Sí, confirmar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) 
                {
                    location.href = "<?php echo base_url();?>staff/notifications/mark_read/"+notification_id;
                }
            })
        }
        function delete_this(notification_id)
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
                    location.href = "<?php echo base_url();?>staff/notifications/delete/"+notification_id;
                }
            })
        }
    </script>