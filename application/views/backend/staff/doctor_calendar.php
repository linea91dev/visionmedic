<?php 
    $doctor_id = $id_;
    $this->db->where('admin_id', $doctor_id);
    $info = $this->db->get('admin')->result_array();    
    foreach($info as $details): 
?>
    <div class="todo-app-w">
        <div class="todo-sidebar">
        <div id="sticky">
            <div class="todo-sidebar-section" style="border-bottom:0px">
                <div class="todo-sidebar-section-contents">
                    <ul class="tasks-list">
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>staff/doctor_profile/<?php echo base64_encode($details['admin_id']);?>/"><i style="padding-right: 10px;    font-size: 22px;" class="picons-thin-icon-thin-0002_write_pencil_new_edit"></i><?php if($owner == 1):?> Editar perfil <?php else:?> Ver perfil<?php endif;?></a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>staff/notifications/<?php echo base64_encode($details['admin_id']);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0543_world_earth_worldwide_location_travel"></i> Notificaciones </a>
                        </li>
                        <?php if($owner == 1):?>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>staff/doctor_security/<?php echo base64_encode($details['admin_id']);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0705_user_profile_security_password_permissions"></i> Contraseña y seguridad </a>
                        </li>
                        <?php endif;?>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>staff/doctor_activity/<?php echo base64_encode($details['admin_id']);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0244_text_bullets_list"></i> Registro de Actividad </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items active" href="<?php echo base_url();?>staff/doctor_calendar/<?php echo base64_encode($details['admin_id']);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i> Calendario <span class="side-active"></span></a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>staff/doctor_appointments/<?php echo base64_encode($details['admin_id']);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0021_calendar_month_day_planner"></i> Citas </a>
                        </li>
                        <?php if($owner == 1):?>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>staff/doctor_permissions/<?php echo base64_encode($details['admin_id']);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0015_fountain_pen"></i> Permisos </a>
                        </li>
                        <?php endif;?>
                    </ul>
                </div>
                </div>
            </div>
        </div>
        <div class="todo-content">
            <div class="row">
                <div class="col-sm-12" style="float: none; margin: 0 auto;">
                    <h4 class="todo-content-header">
                        <i class="batch-icon-arrow-right"></i><span>Agenda en Medicaby - <?php echo $this->accounts_model->get_name('admin',$details['admin_id']);?>.</span>
                    </h4>
                    
                    <div class="alert alert-info">
                        <span class="alert-title"><i class="batch-icon-spam"></i> Registro de agenda diaria.</span>
                        <span class="alert-content">Aquí podrás visualizar todas las actividades que tenga el doctor dentro de <span class="alert-lined"><a href="javascript:void(0);" style="color:#0044e9">Medicaby</a></span>.</span>
                    </div>  
                <br>
                <div class="app-side" style="background-color:#f9fbfc;">
                    <div class="app-side-i">
                        <div id="main-content" style="width: 100%;">
                            <div class="card-widget">
            					<div class="card-body">
            						<div id="kt_calendar"></div>
            					</div>
            				</div>
                	    </div>
                    </div>
                </div>
                
    <?php $get_appointments = $this->appointment_model->get_aptms_doctor($this->session->userdata('current_clinic'), $doctor_id);?>
    <script>
        var KTCalendarBasic = function() {
        return {
            init: function() {
                var todayDate = moment().startOf('day');
                var YM = todayDate.format('YYYY-MM');
                var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
                var TODAY = todayDate.format('YYYY-MM-DD');
                var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');

                var calendarEl = document.getElementById('kt_calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    plugins: [ 'bootstrap', 'interaction', 'dayGrid', 'timeGrid', 'list' ],
                    themeSystem: 'bootstrap',
                    isRTL: KTUtil.isRTL(),
                    timeFormat: 'h:mm t',
                    header: {
                        left: 'title',
                        center: 'dayGridMonth,timeGridWeek,timeGridDay,list',
                        right: 'prev,next today'
                    },
                    height: 900,
                    contentHeight: '100%',
                    displayEventEnd:true,
                    displayEventTime: true,
                    eventLimitText: "",
                    eventLimit: true, 
                    aspectRatio: 3,
                    nowIndicator: true,
                    eventTimeFormat: {
                      hour: "numeric",
                      minute: "2-digit",
                      meridiem: "short",
                    },
                    now: TODAY + 'T09:25:00', // just for demo
                    views: {
                        month: {
                        eventLimit: 3,
                    },
                        dayGridMonth: { buttonText: 'Mes' },
                        timeGridWeek: { buttonText: 'Semana' },
                        timeGridDay: { buttonText: 'Día' },
                        list: { buttonText: 'Lista' }
                    },
                    defaultView: 'dayGridMonth',
                    defaultDate: TODAY,
                    editable: false,
                    eventLimit: true,
                    navLinks: true,
                    events: [
                    <?php foreach($get_appointments as $app):?> 
                        {
                            id: '<?php echo $app['appointment_id']; ?>',
                            title: '<?php echo $this->appointment_model->getTitle($app['appointment_id'],$app['status']);?>',
                            start: '<?php echo $this->appointment_model->calendar_start_date($app['date'], $app['time']);?>',
                            end: '<?php echo $this->appointment_model->calendar_end_date($app['date'], $app['time']);?>',
                            description: '',
                            className: "<?php echo $this->appointment_model->get_status($app['status']);?>"
                        },
                    <?php endforeach; ?>
                ],
                eventRender: function(info) {
                    var element = $(info.el);

                    if (info.event.extendedProps && info.event.extendedProps.description) {
                        if (element.hasClass('fc-day-grid-event')) {
                            element.data('content', info.event.extendedProps.description);
                            element.data('placement', 'top');
                            KTApp.initPopover(element);
                        } else if (element.hasClass('fc-time-grid-event')) {
                            element.find('.fc-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                        } else if (element.find('.fc-list-item-title').lenght !== 0) {
                            element.find('.fc-list-item-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                        }
                    }
                },
                eventClick:  function(into, jsEvent, view) {
                    showAjaxModal('<?php echo base_url();?>modal/popup/modal_details/'+into.event.id);
                },
                
            });
            calendar.render();
        }
    };
}();

jQuery(document).ready(function() {
    KTCalendarBasic.init();
});
</script>
<script src="<?php echo base_url();?>public/assets/calendar/js/scripts.bundle.js"></script>
<script src="<?php echo base_url();?>public/assets/calendar/js/fullcalendar.bundle.js"></script>

<?php endforeach;?>
 