    <aside class="side-nav side-nav-small scroll" id="nav" <?php if(!$this->crud_model->checkMobile()):?> style="overflow-y: auto!important;" <?php endif;?>>
	    <div class="smartphone-menu-trigger"><i class="dripicons-align-justify"></i></div>
		<div class="closeSideNav"><i class="dripicons-cross"></i></div>
		<ul class="side-nav-wrapper">

			<li class="brand">
				<a  href="<?php echo base_url();?>staff/appointments/">
					<img src="<?php echo base_url();?>public/uploads/<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->logo; ?>"  style="width:50px;margin:0px;" alt="<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->name; ?>">
				</a>
			</li>

			<li class="movil_brand">
				<a style="text-align:center;" href="<?php echo base_url();?>staff/appointments/">
					<center><img src="<?php echo base_url();?>public/uploads/<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->logo; ?>" style=" object-fit: scale-down; width: 50px; height: 50px;"  alt="<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->name; ?>"></center>
				</a>
			</li>

			<?php 
			    
                $staff_id = $this->session->userdata('login_user_id');
                $this->db->where('staff_id', $staff_id);
                $info = $this->db->get('staff')->result_array();
                foreach($info as $details):
            ?>
			<?php if ($details['panel'] == 1):?>

			
			<?php endif; if ($details['appointments'] == 1):?>
			<li class="sideBox-item" data-toggle="tooltip" data-placement="right" title="Citas">
				<a href="<?php echo base_url();?>staff/appointments/" <?php if($page_name == 'calendar' ||$page_name == 'appointment_details' || $page_name == 'appointments' || $page_name == 'pending_payment' || $page_name == 'soon' || $page_name == 'rescheduled' || $page_name == 'cancelled' || $page_name == 'archived'):?> class="currentPage"<?php endif;?>>
					<i class="iconBox picons-thin-icon-thin-0021_calendar_month_day_planner"></i>
					<span class="sideBox-item-name">Citas</span>
				</a>
			</li>
			
			<?php endif; if ($details['chat'] == 1):?>
			<li class="sideBox-item" data-toggle="tooltip" data-placement="right" title="Chat">
				<a href="<?php echo base_url();?>staff/chat/" <?php if($page_name == 'chat' || $page_name == 'messages'):?> class="currentPage" <?php endif;?>>
				    <i class="iconBox picons-thin-icon-thin-0277_chat_message_comment_bubble_like_favorite"></i>
					<span class="sideBox-item-name">Chat</span>
				</a>
			</li>
			<?php endif; if ($details['patients'] == 1):?>
			<li class="sideBox-item" data-toggle="tooltip" data-placement="right" title="Pacientes">
				<a href="<?php echo base_url();?>staff/patients/" <?php if($page_name == 'prescription_details' || $page_name == 'patients' || $page_name == 'patient_profile' || $page_name == 'medical_history' || $page_name == 'medical_prescriptions' || $page_name == 'patient_files' || $page_name == 'patient_appointments' || $page_name == 'patient_financial' || $page_name == 'patient_security' || $page_name == 'treatment' || $page_name == 'treatment_details'):?>class="currentPage"<?php endif;?>>
				    <i class="iconBox picons-thin-icon-thin-0704_users_profile_group_couple_man_woman"></i>
					<span class="sideBox-item-name">Pacientes</span>
				</a>
			</li>

			<?php endif; if ($details['doctors'] == 1):?>
			<li class="sideBox-item" data-toggle="tooltip" data-placement="right" title="Doctores">
				<a href="<?php echo base_url();?>staff/doctors/" <?php if($page_name == 'new_doctor' || $page_name == 'doctors' || $page_name == 'doctor_profile' || $page_name == 'doctor_appointments'):?>class="currentPage"<?php endif;?>>
					<i class="iconBox picons-thin-icon-thin-0825_stetoscope_doctor_hospital_ill"></i>
					<span class="sideBox-item-name">Doctores</span>
				</a>
			</li>
			<?php endif; if ($details['staff'] == 1):?>
			<li class="sideBox-item" data-toggle="tooltip" data-placement="right" title="Equipo">
				<a href="<?php echo base_url();?>staff/staff/" <?php if($page_name == 'staff' || $page_name == 'staff_profile' || $page_name == 'staff_notifications' || $page_name == 'staff_security' || $page_name == 'staff_activity' || $page_name == 'staff_permissions'):?>class="currentPage"<?php endif;?>>
					<i class="iconBox picons-thin-icon-thin-0723_nurse_medicine_hospital_doctor"></i>
					<span class="sideBox-item-name">Equipo</span>
				</a>
			</li>
			<?php endif; if ($details['inventory'] == 1):?>
			<?php if($this->crud_model->check_item('product_module') == 1): ?>
			<li class="sideBox-item" data-toggle="tooltip" data-placement="right" title="Inventario">
				<a href="<?php echo base_url();?>staff/inventory/" <?php if($page_name == 'new_sale'  || $page_name == 'inventory' || $page_name == 'categories' || $page_name == 'sales' || $page_name == 'sale_details'):?>class="currentPage"<?php endif;?>>
					<i class="iconBox picons-thin-icon-thin-0820_medicine_drugs_ill_pill"></i>
					<span class="sideBox-item-name">Inventario</span>
			    </a>
			</li><?php endif; ?>
			<?php endif; if ($details['financial'] == 1):?>
			<li class="sideBox-item" data-toggle="tooltip" data-placement="right" title="Finanzas">
				<a href="<?php echo base_url();?>staff/financial/" <?php if($page_name == 'financial'):?>class="currentPage"<?php endif;?>>
					<i class="iconBox picons-thin-icon-thin-0406_money_dollar_euro_currency_exchange_cash"></i>
					<span class="sideBox-item-name">Finanzas</span>
			    </a>
			</li>
			<?php endif; if ($details['reports'] == 1):?>
			<li class="sideBox-item" data-toggle="tooltip" data-placement="right" title="Reportes">
				<a href="<?php echo base_url();?>staff/financial_reports/" <?php if($page_name == 'reports' || $page_name == 'financial_reports' || $page_name == 'appointment_reports' || $page_name == 'inventory_reports'):?>class="currentPage"<?php endif;?>>
					<i class="iconBox picons-thin-icon-thin-0397_analytics_graph_line_statistics_presentation_keynote"></i>
					<span class="sideBox-item-name">Reportes</span>
				</a> 
			</li>
			<?php endif; if ($details['settings'] == 1):?>
			<li class="sideBox-item" data-toggle="tooltip" data-placement="right" title="Configuración">
				<a href="<?php echo base_url();?>staff/settings/" <?php if($page_name == 'survey_results' || $page_name == 'question_board' || $page_name == 'questions' || $page_name == 'forms' || $page_name == 'confirmed' || $page_name == 'subscription' || $page_name == 'settings' || $page_name == 'specialties' || $page_name == 'laboratories' || $page_name == 'clinics' || $page_name == 'services' || $page_name == 'specialties' || $page_name == 'laboratories' || $page_name == 'surveys' || $page_name == 'thooth_procedures'):?>class="currentPage"<?php endif;?>>
					<i class="iconBox picons-thin-icon-thin-0049_settings_panel_equalizer_preferences"></i>
					<span class="sideBox-item-name">Configuración</span>
				</a>
			</li>
			<?php endif; if ($details['appointments'] == 1):?>
			<li class="sideBox-item" data-toggle="tooltip" data-placement="right" title="Nueva cita" >
                <a style="font-size:15px;padding-left: 20px;text-align:center;" href="<?php echo base_url();?>staff/appointment/">
            	    <div class="third-floated-btn new_app">
                        <i class="batch-icon-compose" style="color:#fff"></i>
                    </div>
                </a>
			</li>
			<?php endif;?>
			<?php endforeach;?>
	    </ul>
	</aside>