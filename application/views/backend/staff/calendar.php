    <div class="app-side">
        <div class="app-side-i">
            <div id="main-content" style="width: 100%;">
                <div class="card-widget">
                    <h4 class="panel-content-title">Seleccionar doctor</h4>
                    <span class="app-divider2"></span>
                    <form id="filters" method="POST" action="<?php echo base_url();?>staff/calendar">
                            <select class="itemName form-control select2" required="" style="width:100%;" name="doctor_id" onchange="submit()">
							    <option value="">Seleccionar</option>
						        <?php 
					    	        $this->db->where('status','1');
							        $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
								    $this->db->order_by('first_name', 'ASC');
							        $query = $this->db->get('admin')->result_array();
                                    foreach($query as $pat):?>
								    <option value="<?php echo $pat['admin_id'];?>" <?php if($pat['admin_id'] == $doctor_id) echo "selected";?>><?php echo $this->accounts_model->get_name('admin', $pat['admin_id']);?></option>
								<?php endforeach;?>
                            </select>
		               </form>
                </div>
                <div class="card-widget">
					<div class="card-body">
					    <div class="status-pill rosa" style="width: 18px;height: 18px;background:#5bb3f5;" data-title="Pendiente" data-toggle="tooltip" data-original-title="" title=""></div>
					    <div class="status-pill rosa" style="width: 18px;height: 18px;background:#528410;" data-title="Confirmada" data-toggle="tooltip" data-original-title="" title=""></div>
					    <div class="status-pill rosa" style="width: 18px;height: 18px;background:#e0345e;" data-title="Cancelada" data-toggle="tooltip" data-original-title="" title=""></div>
					    <div class="status-pill rosa" style="width: 18px;height: 18px;background:#a66767;" data-title="Reprogramada" data-toggle="tooltip" data-original-title="" title=""></div>
					    <div class="status-pill rosa" style="width: 18px;height: 18px;background:#0044e9;" data-title="Finalizada" data-toggle="tooltip" data-original-title="" title=""></div>
					    <div class="status-pill rosa" style="width: 18px;height: 18px;background:#6342ff;" data-title="Eventos" data-toggle="tooltip" data-original-title="" title=""></div>
					    <div class="status-pill rosa" style="width: 18px;height: 18px;background:#e6b517;" data-title="Pendiente de pago" data-toggle="tooltip" data-original-title="" title=""></div>
						<div id="kt_calendar"></div>
					</div>
				</div>
    	    </div>
        </div>
    </div>
    <?php $get_appointments = $this->appointment_model->get_now_doctor( $this->session->userdata('current_clinic'), $doctor_id); ?>
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
                    locale: 'es',
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
                    buttonText:
                    {
                        today: 'Hoy'
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


 