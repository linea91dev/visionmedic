<?php 

    if (!defined('BASEPATH')) 
    exit('No direct script access allowed');
    include_once(dirname(__FILE__).'/Drive.php');
class Doctor extends Drive
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('user_agent');
        $this->load->library('session'); 
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache'); 
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

    }
    
    public function index() 
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if ($this->session->userdata('doctor_login') == 1)
        {
            redirect(base_url() . 'doctor/panel/', 'refresh');
        }
    }

    function password_change()
    {
        $data['password'] = sha1($this->input->post('pass'));
        $this->db->where('admin_id', $this->input->post('id'));
        $this->db->update('admin', $data);
    }
    
    function password_change_pass()
    {
        $data['password'] = sha1($this->input->post('pass'));
        $this->db->where('staff_id', $this->input->post('id'));
        $this->db->update('staff', $data);
    }
    
    function password_change_patient()
    {
       
            $data['password'] = sha1($this->input->post('pass'));
            $this->db->where('patient_id', $this->input->post('id'));
            $this->db->update('patient', $data);

    }
    
    
    
    function sales_order_entry_response($variant_id , $count=1)
    {
        $page_data['variant_id']    =   $variant_id;
        $page_data['count']         =   $count;
        $this->load->view('backend/doctor/sales_order_entry' , $page_data);
    }
    
    
    function notifications($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'delete')
        {
            $this->db->where('notification_id', $param2);
            $this->db->delete('notification');
            $this->session->set_flashdata('flash_message' , "Notificación eliminada correctamente.");
            redirect(base_url() . 'doctor/notifications/', 'refresh');
        }
        if($param1 == 'mark_read')
        {
            $data['read_status'] = 1;    
            $this->db->where('notification_id', $param2);
            $this->db->update('notification', $data);
            $this->session->set_flashdata('flash_message' , "Notificación actualizada correctamente.");
            redirect(base_url() . 'doctor/notifications/', 'refresh');
        }
        
        $page_data['id_']           = base64_decode($param1);
        $page_data['owner']         = $this->crud_model->account_owner();
        $page_data['page_name']   = 'notifications';
        $page_data['page_title']  = "Mis notificaciones";
        $this->load->view('backend/index', $page_data);
    }
    
        function send_diary()
    {
        $this->accounts_model->diary();
    }
    
    
    function sales_order_append_entry_response($count , $selected_variants)
    {
        $page_data['count']                 =   $count;
        $page_data['selected_variants']     =   $selected_variants;
        $this->load->view('backend/doctor/sales_order_append_entry' , $page_data);
    }

    
    function force_download_messages($file_name)
    {
        $this->load->helper('download');
        $data = file_get_contents("public/uploads/messages_files/" . $file_name);

        $name = $this->db->get_where('message',array('file_name'=>$file_name))->row()->original_file_name;

        if($name !="")
            force_download($name, $data);
        else
            force_download($file_name, $data);
    }
    
    
    /*
    function getTest()
    {
        $get_appointments = $this->appointment_model->get_now();
        foreach($get_appointments as $app)
        {
            echo $this->crud_model->get_service($app['practice'])." - ".$this->accounts_model->short_name('patient',$app['patient_id'])."<br>";
            echo $this->appointment_model->calendar_start_date($app['date'], $app['time'])."<br>";
            echo $this->appointment_model->calendar_end_date($app['date'], $app['time'])."<br>-----------------------------------<br>";
        }
    }
    */
    

    function get_contacts()
    {
        $html  ="";
        if($this->input->post('b'))
        {       
            $like = $this->input->post('b');
            $query = $this->db->query('SELECT admin_id, username, type, first_name, phone, status FROM admin WHERE status = "1" AND first_name LIKE "%'.$like.'%" OR last_name LIKE "%'.$like.'%"')->result_array();
            $query2 = $this->db->query('SELECT staff_id, username, type, first_name, phone, status FROM staff WHERE status = "1" AND first_name LIKE "%'.$like.'%" OR last_name LIKE "%'.$like.'%"')->result_array();
            $query3 = $this->db->query('SELECT patient_id, username, type, first_name, phone, status FROM patient WHERE status = "1" AND first_name LIKE "%'.$like.'%" OR last_name LIKE "%'.$like.'%"')->result_array();
  
                if(count($query) > 0)
                {
                    foreach ($query as $row) 
                    {
                        
                        $type = 'admin';
                      
                        $html  .= ' <li>
                        <div class="contact-box">
                        <div class="profile'; 
                        
                        if($this->crud_model->check_online_status($type, $row['admin_id']) > 0)
                        {
                            $html  .= ' online';
                        }else
                        {
                            $html  .= ' busy';
                        }
                        
                        $html  .= ' bg-size" style="background-image: url('.$this->accounts_model->get_photo($type, $row['admin_id']).'); background-size: cover; background-position: center center; display: block;">
                            </div>
                          <div class="details">
                            <h5>'.$this->accounts_model->short_name($type,$row['admin_id']).'</h5><h6>'.$row['phone'].'</h6>
                          </div>
                          <div class="contact-action">
                            <a class="icon-btn btn-outline-primary btn-sm button-effect" href='.base_url().'doctor/chat_messages/'.$row['username'].'><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg></a>
                          </div>
                        </div>
                      </li>';


                       
                    }

                }

                if(count($query2) > 0)
                {
                    foreach ($query2 as $row2) 
                    {
                        
                        $type = 'staff';
                        $html  .= ' <li>
                        <div class="contact-box">
                        <div class="profile'; 
                        
                        if($this->crud_model->check_online_status($type, $row2['staff_id']) > 0)
                        {
                            $html  .= ' online';
                        }else
                        {
                            $html  .= ' busy';
                        }
                        
                        $html  .= ' bg-size" style="background-image: url('.$this->accounts_model->get_photo($type, $row2['staff_id']).'); background-size: cover; background-position: center center; display: block;">
                            </div>
                          <div class="details">
                            <h5>'.$this->accounts_model->short_name($type,$row2['staff_id']).'</h5><h6>'.$row2['phone'].'</h6>
                          </div>
                          <div class="contact-action">
                            <a class="icon-btn btn-outline-primary btn-sm button-effect" href='.base_url().'doctor/chat_messages/'.$row2['username'].'><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg></a>
                          </div>
                        </div>
                      </li>';
                        
                    }

                }

                if(count($query3) > 0)
                {
                    foreach ($query3 as $row3) 
                    {
                        
                        $type = 'patient';
                        $html  .= ' <li>
                        <div class="contact-box">
                        <div class="profile'; 
                        
                        if($this->crud_model->check_online_status($type, $row3['patient_id']) > 0)
                        {
                            $html  .= ' online';
                        }else
                        {
                            $html  .= ' busy';
                        }
                        
                        $html  .= ' bg-size" style="background-image: url('.$this->accounts_model->get_photo($type, $row3['patient_id']).'); background-size: cover; background-position: center center; display: block;">
                            </div>
                          <div class="details">
                            <h5>'.$this->accounts_model->short_name($type,$row3['patient_id']).'</h5><h6>'.$row3['phone'].'</h6>
                          </div>
                          <div class="contact-action">
                            <a class="icon-btn btn-outline-primary btn-sm button-effect" href='.base_url().'doctor/chat_messages/'.$row3['username'].'><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg></a>
                          </div>
                        </div>
                      </li>';
                        
                    }

                }
                
                if(count($query) == 0 && count($query2) == 0 && count($query3) == 0  )
                {
                   $html .= '<div id="main-content">
                                <br><br>
                        	    <div class="row">
                        			<div class="main-table-card col-sm-12 m-b-30">
                        				<div class="card-box" style="border:0;"> 
                        					<div class="card-b" style="padding: 20px;">
                        					                                <h1 style="text-align:center;font-size:22px; font-weight:normal">Lo sentimos, no encontramos ninguna coincidencia para <b>'.$like.' </b> 😕 <br><br> <img src="https://miaula.com.gt/demo/uploads/no_results.png" style="width:50%"></h1>
                                                					</div>
                        				</div>
                        			</div>
                        		</div>
                        	</div>';
                }

                
            }

            echo $html;
    }
  
  
    function create_odonto_treatment()
    {   
        $this->appointment_model->create_odonto_treatment($this->session->userdata('login_user_id'),$this->session->userdata('login_type'));
    }
    
    

    /*
    function get_patients()
    {
        $json = [];
        $query = $this->db->get('patient')->result_array();
        foreach($query as $row)
        {
            $json[] = ['id'=>$row['patient_id'], 'text'=> $row['first_name']." ".$row['last_name']];
        }
        echo json_encode($json);
    }
    */
    
       function search($param1 = '', $param2 = '')
       {
        if($param1 == 'find'){
            redirect(base_url() . 'doctor/search_results?key='.urlencode($this->input->post('search_key')), 'refresh');   
        }
        }
    
    function search_results($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        
        if($_GET['key'] != ''){
            $page_data['like'] = urldecode($_GET['key']);   
        }else
        {
             $page_data['like'] = "";   
        }
         
        $page_data['page_name']   = 'search_results';
        $page_data['page_title']  = "Resultados de la búsqueda";
        $this->load->view('backend/index', $page_data);
    }
    
    function print_prescription($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $this->log_model->print_prescription($param1);
        $page_data['prescription_id']   = $param1;
        $this->load->view('backend/doctor/print_prescription', $page_data);
    }
    
    function print_prescription_details($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['appointment_id']    = $param1;
        $this->load->view('backend/doctor/print_prescription_details', $page_data);
    }
    function print_dictamen_details($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['appointment_id']    = $param1;
        $this->load->view('backend/doctor/print_dictamen_details', $page_data);
    }
    
    function print_receipt($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['appointment_id']    = $param1;
        $page_data['sale_id']           = $param2;
        $this->load->view('backend/doctor/print_receipt', $page_data);
    }
    
    
    function print_receipt2($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['cart_id']           = $param1;
        $page_data['patient_id']         = $param2;
        $this->load->view('backend/doctor/print_receipt2', $page_data);
    }
    
    function survey_results($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['codigo'] =  $param1;
        $page_data['page_name']   = 'survey_results';
        $page_data['page_title']  = "Resultados de la encuesta";
        $this->load->view('backend/index', $page_data);
    }
    
    function prescription_details($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']   = 'prescription_details';
        $page_data['page_title']  = "Detalles de la Receta";
        $this->load->view('backend/index', $page_data);
    }
    /*
    function subscription($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'create')
        {
            $data['clinic_id']      = $this->session->userdata('current_clinic');
            $data['code']           = strtoupper(substr(md5(rand()), 0, 8));
            $data['expiration']     = '';
            $data['method']         = $this->input->post('response');
            $data['purchase_date']  = date('d/m/Y');
            $data['confirmed_date'] = '';
            $data['comment']        = $this->input->post('comment');
            if($this->input->post('isAnual') == '1'){
                $data['total_amount']   = $this->input->post('totalPrice')*12;
            }else{
                $data['total_amount']   = $this->input->post('totalPrice');   
            }
            $data['status']         = 0;
            $this->db->insert('suscription', $data);
            $this->session->set_flashdata('flash_message' , "Acción completada correctamente.");
            redirect(base_url() . 'doctor/confirmed/'.$data['code'], 'refresh');
        }
        if($param1 == 'cancel'){
            $this->db->where('code', $param2);
            $this->db->delete('suscription');
            $this->session->set_flashdata('flash_message' , "Factura cancelada correctamente.");
            redirect(base_url() . 'doctor/subscription/', 'refresh');
        }
        $page_data['page_name']   = 'subscription';
        $page_data['page_title']  = "Tu suscripción";
        $this->load->view('backend/index', $page_data);
    }
    */
    
    function confirmed($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['type'] = $param2;
        $page_data['code'] = $param1;
        $page_data['page_name']   = 'confirmed';
        $page_data['page_title']  = "Tu suscripción ha sido confirmada";
        $this->load->view('backend/index', $page_data);
    }
    
    function get_reply($code = '', $patient_id = '')
    {
        $questions = $this->db->get_where('question', array('survey_id' => $code))->result_array();
        foreach($questions as $rows)
        {
            $html = '<div class="card-box m-b-30">
                <div class="card-h">
                	<h2 class="card-caption"> 
                		 <span>'. $rows['question'].'</span>
                	</h2>
                </div>
                <table class="table table-bordered">';
                    
                    $submitted_answer = $this->db->get_where('survery_result', array('survey_id' => $code,'patient_id' => $patient_id))->result_array();
                	foreach ($submitted_answer as $row_answer)
                	{
                		                
                		$html .= '
                		<tr>
                            <td>';
                                $reply = json_decode($row_answer['answer_script'], true);
                                foreach($reply as $repl)
                                {
                                    if ($rows['question_id']== $repl['question_id'])
                                    {
                                        $v1 = str_replace('["','',$repl['submitted_answer']);
                                        $v2 = str_replace('"]','',$v1);
                                        $type = $this->db->get_where('question', array('question_id' => $repl['question_id']))->row()->type;
                                        $html .= $v2;
                                    }
                                }
                        $html .= '</td>
                		 </tr>';
                	}
                $html .= '</table>
            </div>';
            echo $html;
	   }
    }
    
    function update_medication_table($patient_id)
    {
        $refresh_query  = $this->db->order_by('medication_history_id', 'desc')->get_where('medication_history',array('patient_id' => $patient_id));
        if($refresh_query->num_rows() > 0)
        {
            $html_table = '
                <table class="table">';
                
		    foreach($refresh_query->result_array() as $row)
		    {
		        $html_table .= '
    		        <tr>
        		        <td>'.$row['name'].'</td>
				        <td><i style="color:#fd4f57;font-weight:bold;" onClick="delete_element('.$row['medication_history_id'].')" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></td>
		            </tr';   
		    }
		    $html_table .='</table>';
            echo $html_table;
        }else{
            echo '<br><center><img alt="Medicamentos" src="'.base_url().'public/uploads/medicamentos.svg" style="width:200px"></center><br><center>Sin historial de medicamentos.</center><br>';
        }
    }
    
    
    function medication_history($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'delete')
        {
            $this->db->where('medication_history_id', $param2);
            $this->db->delete('medication_history');
            return true;
        }
        if($param1 == 'create')
        {
            $data['name']             = $this->input->post('medicament');
            $data['prescription_id']  = 0;
            $data['date']             = $this->crud_model->formatDate();
            $data['patient_id']       = $this->input->post('patient_id');
            $this->db->insert('medication_history', $data);
            return true;
        }
        $page_data['page_name']   = 'medication_history';
        $page_data['page_title']  = "Medicaciones";
        $this->load->view('backend/index', $page_data);
    }
    
    function update_allergie_table($patient_id)
    {
        $refresh_query  = $this->db->order_by('allergie_id', 'desc')->get_where('allergie',array('patient_id' => $patient_id));
        if($refresh_query->num_rows() > 0)
        {
            $html_table = '
                <table class="table">';
		    foreach($refresh_query->result_array() as $row)
		    {
		        $html_table .= '
    		        <tr>
        		        <td>'.$row['name'].'</td>
		            </tr';   
		    }
		    $html_table .='</table>';
            echo $html_table;
        }else{
            echo '';
        }
    }
    
    
    function update_prescription_table($appointment_id)
    {

        $status = $this->db->get_where('appointment', array('appointment_id'=>$appointment_id))->row()->status;

        $refresh_query  = $this->db->get_where('prescription',array('appointment_id' => $appointment_id));
        if($refresh_query->num_rows() > 0)
        {
            $html_table = '
                <table class="table">
		            <tr style="background-color:#f9fbfc; color:#59636d">
        				<th>Medicamento</th>
				        <th>Tomar</th>
				        <th>Frecuencia</th>
				        <th>Duración</th>';

                    if($status == 1 || $status == 0)
				        $html_table .= '<th>-</th>';
                        $html_table .= '</tr>';
		    foreach($refresh_query->result_array() as $row)
		    {
		        $html_table .= '
    		        <tr>
        		        <td>'.$row['medicine'].'</td>
				        <td>'.$row['quantity'].'</td>
				        <td>'.$row['frequency'].'</td>
				        <td>'.$row['duration'].'</td>';

                        if($status == 1 || $status == 0)
				        $html_table .= '<td><i style="color:#fd4f57;font-weight:bold;" onClick="delete_element('.$row['prescription_id'].','.$appointment_id.')" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></td>';
                        
                        
                        $html_table .= '</tr>';   
		    }
		    $html_table .='</table>';
            
            echo $html_table;
        }else{
            echo '<div class="col-sm-12"><br><center><h5 class="poppins">Aún no hay medicamentos preescritos</h5><br><img src="'.base_url().'public/uploads/medicamentos.svg" style="max-width:20%;"></center></div>';
        }
    }
    
    
        function update_prescription_sale($appointment_id)
    {
        $refresh_query  = $this->db->get_where('prescription',array('appointment_id' => $appointment_id));
        if($refresh_query->num_rows() > 0)
        {
            $html_table = '
                <table class="table">
		            <tr style="background-color:#f9fbfc; color:#59636d">
        				<th>Medicamento</th>
				        <th>Tomar</th>
				        <th>Frecuencia</th>
				        <th>Duración</th>
				        <th>-</th>
		            </tr>';
		    foreach($refresh_query->result_array() as $row)
		    {
		        $html_table .= '
    		        <tr>
        		        <td>'.$row['medicine'].'</td>
				        <td>'.$row['quantity'].'</td>
				        <td>'.$row['frequency'].'</td>
				        <td>'.$row['duration'].'</td>
				        <td><i style="color:#fd4f57;font-weight:bold;" onClick="delete_element('.$row['prescription_id'].')" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></td>
		            </tr>';   
		    }
		    $html_table .='</table>';
            echo $html_table;
        }else{
            echo '';
        }
    }
    
    
    ///////Dientes tabla ////////
    
    
    function tooth()
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_urld(), 'refresh');
        }
        


        $checked = $this->input->post('process');
        $total_checked_values = count($checked);
        $permissions = '';
        for ($i = 0; $i < $total_checked_values; $i++) 
        {


            $data['doctor_id']           = $this->input->post('doctor_id');
            $data['patient_id']          = $this->input->post('patient_id');
            $data['appointment_id']      = $this->input->post('appointment_id');
            $data['tooth_id']            = $this->input->post('tooth_id');
            $data['face']                = $this->input->post('face');
            $data['date']                = $this->crud_model->formatDate();
            $data['diagnosis']           = $this->input->post('diagnosis');
            $data['process']             = $checked[$i];
            $data['commentary']          = $this->input->post('commentary');
            $data['status']              = 0;
            log_message('error', $checked[$i]);
            $this->db->insert('treatment', $data);

        }
            return true; 
             
    }
    
    
    function delete_tooth_treatment($param1 = '' )
    {
     if($this-> session->userdata('doctor_login') != 1){
            redirect(base_url(), 'refresh');
        }
        
        $this->db->where('tooth_treatment_id', $param1);
        $this->db->delete('tooth_treatment');
        return true;
        
    }
    
    function set_status_treatment($param1 = '', $param2 = '')
    {
        if($this-> session->userdata('doctor_login') != 1){
            redirect(base_url(), 'refresh');
        }
        
        $data['status']     = 1;
        $this->db->where('tooth_treatment_id', $param1);
        $this->db->update('tooth_treatment', $data);
        
        $data22['status']     = 1;
        $this->db->where('treatment_id', $param2);
        $this->db->update('odonto_treatment', $data22);
        return true;
        
    }
    
    function prescriptions($param1 = '', $param2 = '')
    {
        if($param1 == 'delete')
        {
            $this->db->where('prescription_id', $param2);
            $this->db->delete('prescription');
            
            $this->db->where('prescription_id', $param2);
            $this->db->delete('medication_history');
            
            return true;
        }
        if($param1 == 'create')
        {
            $patient_id = $this->db->get_where('appointment', array('appointment_id' => $this->input->post('appointment_id')))->row()->patient_id;
            $data['medicine']  = $this->input->post('medicine');
            $data['quantity']  = $this->input->post('quantity');
            $data['frequency'] = $this->input->post('frequency');
            $data['duration']  = $this->input->post('duration');
            $data['patient_id']= $this->input->post('patient_id');
            $data['date']      = $this->crud_model->formatDate();
            
            $data['appointment_id']  = $this->input->post('appointment_id');
            $this->db->insert('prescription', $data);
            $prescription_id = $this->db->insert_id();
            
            $data2['name'] = $data['medicine'];
            $data2['prescription_id'] = $prescription_id;
            $data2['patient_id'] = $patient_id;
            $data2['date'] = $this->crud_model->formatDate();
            $this->db->insert('medication_history', $data2);
            return true;
        }
        $page_data['page_name']   = 'prescriptions';
        $page_data['page_title']  = "Recetas";
        $this->load->view('backend/index', $page_data);
    }
    
  
    
    

    function forms($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'apply'){
            $this->crud_model->apply_forms();
            $this->session->set_flashdata('flash_message' , "Formularios aplicados correctamente.");
            redirect(base_url() . 'doctor/forms/', 'refresh');
        }
        $page_data['page_name']   = 'forms';
        $page_data['page_title']  = "Formularios";
        $this->load->view('backend/index', $page_data);
    }
    
    function sale_details($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        
        if($param1 == 'email')
        {
            $patient_id         = $param3;//$this->db->get_where('cart', array('appointment_id' => $param2))->row()->patient_id;
            $sale_id            = $this->db->get_where('cart', array('appointment_id' => $param2))->row()->cart_id;
            $prescription_name  = str_replace(' ','_', $this->accounts_model->get_name('patient', $patient_id));
            
            $data = array(
                'appointment_id' => $param2,
                'sale_id' => $sale_id,
                'patient_id' => $patient_id
            );
            
            $html = $this->load->view('backend/pdf_recipe.php',$data,TRUE); 
            $pdfFilePath = "recibo_de_venta-".$prescription_name.".pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('c', 'A4'); 
            $mpdf->packTableData = true;
            $mpdf->WriteHTML($html,2);
            $mpdf->Output('public/uploads/'.$pdfFilePath, "F");

            $email = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->email;

            log_message('error', $email);
            $patient_name = $this->accounts_model->short_name('patient',$patient_id);
            require("public/apis/class.phpmailer.php");
            $mail = new PHPMailer(); 
            $mail->IsHTML(true);
            $mail->IsMail();
            $mail->CharSet = 'UTF-8';
            $mail->AddAttachment('public/uploads/'.$pdfFilePath,$pdfFilePath);   
            $mail->SetFrom('no-reply@medicaby.com', 'Notificaciones Medicaby');
            $mail->Subject = '=?UTF-8?B?' . base64_encode("Recibo electrónico") . '?=';
            $data2 = array(
                'patient_name' => $patient_name,
                'patient_id' => $patient_id,
            );
            $mail->Body = $this->load->view('backend/mails/receipt.php',$data2,TRUE);
            $mail->AddAddress($email);
            if($email != ''){
                if(!$mail->Send()){
                    echo "Mailer Error: " . $mail->ErrorInfo;
                }       
            }
            unlink("public/uploads/" . $pdfFilePath);
            
            $this->session->set_flashdata('flash_message' , "Correo enviado correctamente.");
            redirect(base_url() . 'doctor/sale_details/'.base64_encode($sale_id), 'refresh');
        }
        
        
        if($param1 == 'email2')
        {
            $patient_id         = $param3;//$this->db->get_where('cart', array('appointment_id' => $param2))->row()->patient_id;
            $sale_id            = $param2;
            $prescription_name  = str_replace(' ','_', $this->accounts_model->get_name('patient', $patient_id));
            
            $data = array(
                'sale_id' => $sale_id,
                'patient_id' => $patient_id
            );
            
            $html = $this->load->view('backend/pdf_recipe2.php',$data,TRUE); 
            $pdfFilePath = "recibo_de_venta-".$prescription_name.".pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('c', 'A4'); 
            $mpdf->packTableData = true;
            $mpdf->WriteHTML($html,2);
            $mpdf->Output('public/uploads/'.$pdfFilePath, "F");

            $email = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->email;

            log_message('error', $email);
            $patient_name = $this->accounts_model->short_name('patient',$patient_id);
            require("public/apis/class.phpmailer.php");
            $mail = new PHPMailer(); 
            $mail->IsHTML(true);
            $mail->IsMail();
            $mail->CharSet = 'UTF-8';
            $mail->AddAttachment('public/uploads/'.$pdfFilePath,$pdfFilePath);   
            $mail->SetFrom('no-reply@medicaby.com', 'Notificaciones Medicaby');
            $mail->Subject = '=?UTF-8?B?' . base64_encode("Recibo electrónico") . '?=';
            $data2 = array(
                'patient_name' => $patient_name,
                'patient_id' => $patient_id,
            );
            $mail->Body = $this->load->view('backend/mails/receipt.php',$data2,TRUE);
            $mail->AddAddress($email);
            if($email != ''){
                if(!$mail->Send()){
                    echo "Mailer Error: " . $mail->ErrorInfo;
                }       
            }
            unlink("public/uploads/" . $pdfFilePath);
            
            $this->session->set_flashdata('flash_message' , "Correo enviado correctamente.");
            redirect(base_url() . 'doctor/sale_details/'.base64_encode($param2), 'refresh');
        }
        
        
        if($param1 == 'pdf')
        {
            $patient_id         = $param3;//$this->db->get_where('cart', array('appointment_id' => $param2))->row()->patient_id;
            $sale_id            = $this->db->get_where('cart', array('appointment_id' => $param2))->row()->cart_id;
            $prescription_name  = str_replace(' ','_', $this->accounts_model->get_name('patient', $patient_id));
            
            $data = array(
                'appointment_id' => $param2,
                'sale_id' => $sale_id,
                'patient_id' => $patient_id
            );
            $html = $this->load->view('backend/pdf_recipe.php',$data,TRUE); 
            $pdfFilePath = "recibo_de_venta-".$prescription_name.".pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('c', 'A4'); 
            $mpdf->packTableData = true;
            $mpdf->WriteHTML($html,2);
            $mpdf->Output($pdfFilePath, "D");     
        }
        
         if($param1 == 'pdf2')
        {
            $patient_id         = $param3;//$this->db->get_where('cart', array('appointment_id' => $param2))->row()->patient_id;
            $sale_id            = $param2;
            $prescription_name  = str_replace(' ','_', $this->accounts_model->get_name('patient', $patient_id));
            
            $data = array(
                'sale_id' => $param2,
                'patient_id' => $patient_id
            );
            $html = $this->load->view('backend/pdf_recipe2.php',$data,TRUE); 
            $pdfFilePath = "recibo_de_venta-".$prescription_name.".pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('c', 'A4'); 
            $mpdf->packTableData = true;
            $mpdf->WriteHTML($html,2);
            $mpdf->Output($pdfFilePath, "D");     
        }
        
        $page_data['id_']         = $param1;
        $page_data['page_name']   = 'sale_details';
        $page_data['page_title']  = "Detalles de la venta";
        $this->load->view('backend/index', $page_data);
    }
    
    
    
    function sale_details_financial($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        
        if($param1 == 'email')
        {
            $patient_id         = $param3;//$this->db->get_where('cart', array('appointment_id' => $param2))->row()->patient_id;
            $sale_id            = $this->db->get_where('cart', array('appointment_id' => $param2))->row()->cart_id;
            $prescription_name  = str_replace(' ','_', $this->accounts_model->get_name('patient', $patient_id));
            
            $data = array(
                'appointment_id' => $param2,
                'sale_id' => $sale_id
            );
            
            $html = $this->load->view('backend/pdf_recipe.php',$data,TRUE); 
            $pdfFilePath = "recibo_de_venta-".$prescription_name.".pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('c', 'A4'); 
            $mpdf->packTableData = true;
            $mpdf->WriteHTML($html,2);
            $mpdf->Output('public/uploads/'.$pdfFilePath, "F");

            $email = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->email;

            log_message('error', $email);
            $patient_name = $this->accounts_model->short_name('patient',$patient_id);
            require("public/apis/class.phpmailer.php");
            $mail = new PHPMailer(); 
            $mail->IsHTML(true);
            $mail->IsMail();
            $mail->CharSet = 'UTF-8';
            $mail->AddAttachment('public/uploads/'.$pdfFilePath,$pdfFilePath);   
            $mail->SetFrom('no-reply@medicaby.com', 'Notificaciones Medicaby');
            $mail->Subject = '=?UTF-8?B?' . base64_encode("Recibo electrónico") . '?=';
            $data2 = array(
                'patient_name' => $patient_name,
                'patient_id' => $patient_id,
            );
            $mail->Body = $this->load->view('backend/mails/receipt.php',$data2,TRUE);
            $mail->AddAddress($email);
            if($email != ''){
                if(!$mail->Send()){
                    echo "Mailer Error: " . $mail->ErrorInfo;
                }       
            }
            unlink("public/uploads/" . $pdfFilePath);
            
            $this->session->set_flashdata('flash_message' , "Correo enviado correctamente.");
            redirect(base_url() . 'patient/patient_financial/'.base64_encode($patient_id), 'refresh');
        }
        
        
        if($param1 == 'pdf')
        {
            $patient_id         = $param3;//$this->db->get_where('cart', array('appointment_id' => $param2))->row()->patient_id;
            $sale_id            = $this->db->get_where('cart', array('appointment_id' => $param2))->row()->cart_id;
            $prescription_name  = str_replace(' ','_', $this->accounts_model->get_name('patient', $patient_id));
            
            $data = array(
                'appointment_id' => $param2,
                'sale_id' => $sale_id
            );
            $html = $this->load->view('backend/pdf_recipe.php',$data,TRUE); 
            $pdfFilePath = "recibo_de_venta-".$prescription_name.".pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('c', 'A4'); 
            $mpdf->packTableData = true;
            $mpdf->WriteHTML($html,2);
            $mpdf->Output($pdfFilePath, "D");     
        }


        if($param1 == 'email2')
        {
            $patient_id         = $param3;//$this->db->get_where('cart', array('appointment_id' => $param2))->row()->patient_id;
            $sale_id            = $param2;
            $prescription_name  = str_replace(' ','_', $this->accounts_model->get_name('patient', $patient_id));
            
            $data = array(
                'sale_id' => $sale_id,
                'patient_id' => $patient_id
            );
            
            $html = $this->load->view('backend/pdf_recipe2.php',$data,TRUE); 
            $pdfFilePath = "recibo_de_venta-".$prescription_name.".pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('c', 'A4'); 
            $mpdf->packTableData = true;
            $mpdf->WriteHTML($html,2);
            $mpdf->Output('public/uploads/'.$pdfFilePath, "F");

            $email = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->email;

            log_message('error', $email);
            $patient_name = $this->accounts_model->short_name('patient',$patient_id);
            require("public/apis/class.phpmailer.php");
            $mail = new PHPMailer(); 
            $mail->IsHTML(true);
            $mail->IsMail();
            $mail->CharSet = 'UTF-8';
            $mail->AddAttachment('public/uploads/'.$pdfFilePath,$pdfFilePath);   
            $mail->SetFrom('no-reply@medicaby.com', 'Notificaciones Medicaby');
            $mail->Subject = '=?UTF-8?B?' . base64_encode("Recibo electrónico") . '?=';
            $data2 = array(
                'patient_name' => $patient_name,
                'patient_id' => $patient_id,
            );
            $mail->Body = $this->load->view('backend/mails/receipt.php',$data2,TRUE);
            $mail->AddAddress($email);
            if($email != ''){
                if(!$mail->Send()){
                    echo "Mailer Error: " . $mail->ErrorInfo;
                }       
            }
            unlink("public/uploads/" . $pdfFilePath);
            
            $this->session->set_flashdata('flash_message' , "Correo enviado correctamente.");
            redirect(base_url() . 'staff/sale_details/'.base64_encode($param2), 'refresh');
        }
        

        if($param1 == 'pdf2')
        {
            $patient_id         = $param3;//$this->db->get_where('cart', array('appointment_id' => $param2))->row()->patient_id;
            $sale_id            = $param2;
            $prescription_name  = str_replace(' ','_', $this->accounts_model->get_name('patient', $patient_id));
            
            $data = array(
                'sale_id' => $param2,
                'patient_id' => $patient_id
            );
            $html = $this->load->view('backend/pdf_recipe2.php',$data,TRUE); 
            $pdfFilePath = "recibo_de_venta-".$prescription_name.".pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('c', 'A4'); 
            $mpdf->packTableData = true;
            $mpdf->WriteHTML($html,2);
            $mpdf->Output($pdfFilePath, "D");     
        }
    }
    
    /*
    function appointment_payment($param1 = '', $param2 = ''){
        
        if($param1 == "appointment"){
            
        $data['amount']         = $this->input->post('amount');
        $data['description']    = $this->input->post('description');    
        $data['reference']      = $this->input->post('reference');
        $data['clinic_id']      = $this->session->userdata('current_clinic');
        $data['appointment_id'] = $this->input->post('appointment_id');
        $data['patient_id']     = $this->input->post('patient_id');
        $data['method']         = $this->input->post('method');
        $data['date']           = date('d/m/Y');
        
        $this->db->insert('income', $data);
        $this->session->set_flashdata('flash_message' , "El pago se realizo con exito!!! ");
        
        $this->db->where('appointment_id',$param2);
        $charges = $this->db->get('appointment')->row()->sub_total;
                    if($charges ==  $this->input->post('amount'))
                    {
                    $data2['status'] = 4;
                    $data2['sub_total'] = $charges- $this->input->post('amount');
                    $this->db->where('appointment_id', $param2);
                    $this->db->update('appointment', $data2);
                    }else
                    {
                    $data2['sub_total'] = $charges- $this->input->post('amount');
                    $this->db->where('appointment_id', $param2);
                    $this->db->update('appointment', $data2);

                        
                    }
        
        }
        redirect(base_url() . 'doctor/pending_payment/', 'refresh');
       
    }
    */
   
    
    function inventory($param1 = '', $param2 = '')
    { 
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        
        
        if($param1 == "confirm_appointment")
        {
            $data['month']        =   date('m');
            $data['day']          =   date('d');
            $data['year']         =   date('Y');
            $data['date']         =   $this->crud_model->formatDate();
            $data['user_id']      =  $this->session->userdata('login_user_id');
            $data['user_type']    =  'admin';
            $data['clinic_id']    =   $this->session->userdata('current_clinic');
            $data['patient_id']   =   $this->input->post('patient_id');
            $data['status']       =   1;
            $data['payment_type'] =   $this->input->post('method');
            $data['description']  =   $this->input->post('description');
            $data['appointment_id']  =   $this->input->post('appointment_id');

            $variant_ids        =   $this->input->post('variant_id');
            $selling_prices     =   $this->input->post('selling_price');
            $ordered_quantities =   $this->input->post('qty');
            $discounts          =   0;
   
            $number_of_entries   =   sizeof($variant_ids);
            $sales_order_entries =   array();
            $total_amount        =   0;
            for($i = 0; $i < $number_of_entries; $i++) 
            {
                $stock = $this->db->get_where('product', array('product_id' => $variant_ids[$i]))->row()->stock;
                
                $dbs['stock'] = $stock-$ordered_quantities[$i];
                $this->db->where('product_id',$variant_ids[$i]);
                $this->db->update('product', $dbs);
                $entry_amount    =   $selling_prices[$i] * $ordered_quantities[$i];
                $amount_with_tax =   $entry_amount + ($entry_amount * ($tax_values[$i] / 100));
                $sub_total       =   $amount_with_tax - ($amount_with_tax * ($discounts[$i] / 100));
                $new_order_entry    =   array(
                    'variant_id' => $variant_ids[$i],
                    'selling_price' => $selling_prices[$i],
                    'ordered_quantity' => $ordered_quantities[$i],
                    'discount' => $discounts[$i],
                    'sub_total' => $sub_total
                );
                $total_amount += $sub_total;
                array_push($sales_order_entries , $new_order_entry);
            }

            $data['total']   =   round($total_amount , 2);
            $data['products']  =   serialize($sales_order_entries);
            $this->db->insert('cart' , $data);

         
            $totappointment = $this->db->get_where('appointment', array('appointment_id'=>$this->input->post('appointment_id')))->row()->charges;
            $data3['appointment_id']  = $this->input->post('appointment_id');
            $data3['patient_id']   =   $this->input->post('patient_id');
            $data3['description'] = 'Cita #'.$this->input->post('appointment_id');
            $data3['amount']      = $totappointment + round($total_amount , 2);
            $data3['method']      = $this->input->post('method');
            $data3['clinic_id']   = $this->session->userdata('current_clinic'); 
            $data3['date']        = date('d/m/Y');
            $data3['user_id']     = $this->session->userdata('login_user_id');
            $data3['user_type']   = $this->session->userdata('login_type');
            $data3['type']        = 1;
            $this->db->insert('financial',$data3);
            
            
            
            $data4['status']=4;
            $this->db->where('appointment_id',$this->input->post('appointment_id'));
            $this->db->update('appointment',$data4);
            
            
            $this->log_model->new_sale($this->input->post('patient_id'),round($total_amount , 2));
            $this->session->set_flashdata('flash_message' , "Datos guardados correctamente");
            redirect(base_url() . 'doctor/pending_payment/'.base64_encode($this->input->post('appointment_id')), 'refresh');
        }
        
        if($param1 == "confirm")
        {
            $data['month']        =   date('m');
            $data['day']          =   date('d');
            $data['year']         =   date('Y');
            $data['date']         =   $this->crud_model->formatDate();
            $data['user_id']      =   $this->session->userdata('login_user_id');
            $data['user_type']    =  'admin';
            $data['clinic_id']    =   $this->session->userdata('current_clinic');
            $data['patient_id']   =   $this->input->post('patient_id');
            $data['status']       =   1;
            $data['payment_type'] =   $this->input->post('method');
            $data['description']  =   $this->input->post('description');


            $variant_ids        =   $this->input->post('variant_id');
            $selling_prices     =   $this->input->post('selling_price');
            $ordered_quantities =   $this->input->post('qty');
            $discounts          =   0;
   
            $number_of_entries   =   sizeof($variant_ids);
            $sales_order_entries =   array();
            $total_amount        =   0;
            for($i = 0; $i < $number_of_entries; $i++) 
            {
                $stock = $this->db->get_where('product', array('product_id' => $variant_ids[$i]))->row()->stock;
                
                $dbs['stock'] = $stock-$ordered_quantities[$i];
                $this->db->where('product_id',$variant_ids[$i]);
                $this->db->update('product', $dbs);
                $entry_amount    =   $selling_prices[$i] * $ordered_quantities[$i];
                $amount_with_tax =   $entry_amount + ($entry_amount * ($tax_values[$i] / 100));
                $sub_total       =   $amount_with_tax - ($amount_with_tax * ($discounts[$i] / 100));
                $new_order_entry    =   array(
                    'variant_id' => $variant_ids[$i],
                    'selling_price' => $selling_prices[$i],
                    'ordered_quantity' => $ordered_quantities[$i],
                    'discount' => $discounts[$i],
                    'sub_total' => $sub_total
                );
                $total_amount += $sub_total;
                array_push($sales_order_entries , $new_order_entry);
            }
            $data['total']   =   round($total_amount , 2);
            $data['products']  =   serialize($sales_order_entries);
            $this->db->insert('cart' , $data);
            $id_cart = $this->db->insert_id();
            
            
            $data2['patient_id']   =   $this->input->post('patient_id');
            $data2['description'] = $this->input->post('description');
            $data2['amount']      = round($total_amount , 2);
            $data2['method']      = $this->input->post('method');
            $data2['clinic_id']   = $this->session->userdata('current_clinic'); 
            $data2['date']        = date('d/m/Y');
            $data2['user_id']     = $this->session->userdata('login_user_id');
            $data2['user_type']   = $this->session->userdata('login_type');
            $data2['cart_id']   = $id_cart;
            $this->db->insert('financial',$data2);
            $this->log_model->new_sale($this->input->post('patient_id'),round($total_amount , 2));
            $this->session->set_flashdata('flash_message' , "La venta se registro correctamente");
            redirect(base_url() . 'doctor/sales/', 'refresh');
        }
        if($param1 == 'delete_product'){
            $this->db->where('cart_item_id', $param2);
            $this->db->delete('cart_items');
        }
        if($param1 == 'add_product')
        {
            $product_id = $this->db->get_where('product', array('name' => $this->input->post('product')))->row()->product_id;
            
            $qry = $this->db->get_where('cart_items', array('cart_token' => $this->input->post('src_token'), 'product' => $product_id));
            if($qry->num_rows() > 0){
                $qty = $qry->row()->quantity;
                $data['quantity'] = $qty+$this->input->post('quantity');
                $this->db->where('product', $product_id);
                $this->db->update('cart_items',$data);
            }else{
                $data['product']  = $product_id;
                $data['cart_token'] = $this->input->post('src_token');
                $data['quantity'] = $this->input->post('quantity');
                $this->db->insert('cart_items',$data);
            }
        }
        if($param1 == 'sale'){
            $this->session->set_flashdata('flash_message' , "Producto agregado correctamente.");
            redirect(base_url() . 'doctor/new_sale/'.base64_encode(json_encode($this->input->post('product'))), 'refresh');
        }
         if($param1 == 'create')
        {
            $this->crud_model->create_inventory();
            $this->session->set_flashdata('flash_message' , "Producto agregado correctamente.");
            redirect(base_url() . 'doctor/inventory/', 'refresh');
        }
        
         if($param1 == 'update')
        {
            $this->crud_model->update_inventory($param2);
            $this->session->set_flashdata('flash_message' , "Producto actualizado correctamente.");
            redirect(base_url() . 'doctor/inventory/', 'refresh');
        }
        
        if($param1 == 'delete')
        {
            $this->crud_model->delete_inventory($param2);
            $this->session->set_flashdata('flash_message' , "Producto eliminado correctamente.");
            redirect(base_url() . 'doctor/inventory/', 'refresh');
        }
        
        
        $page_data['page_name']   = 'inventory';
        $page_data['page_title']  = "Inventario";
        $this->load->view('backend/index', $page_data);
    }
    
    function categories($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        
        if($param1 == 'create')
        {
            $this->crud_model->create_category();
            $this->session->set_flashdata('flash_message' , "Categoría agregada correctamente.");
            redirect(base_url() . 'doctor/categories/', 'refresh');
        }
        
         if($param1 == 'update')
        {
            $this->crud_model->update_category($param2);
            $this->session->set_flashdata('flash_message' , "Categoría actualizada correctamente.");
            redirect(base_url() . 'doctor/categories/', 'refresh');
        }
        
        if($param1 == 'delete')
        {
            $this->crud_model->delete_category($param2);
            $this->session->set_flashdata('flash_message' , "Categoría eliminada correctamente.");
            redirect(base_url() . 'doctor/categories/', 'refresh');
            
        }
        
        $page_data['page_name']   = 'categories';
        $page_data['page_title']  = "Categorías de productos";
        $this->load->view('backend/index', $page_data);
    }
    
    function sales($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        
        if($param1 == 'delete')
        {
            
            $id = base64_decode($param2);
            
            // Obtener productos del carrito (deserializados)
            $cart = $this->db->get_where('cart', array('cart_id' => $id))->row();
            $products = unserialize($cart->products);
            
            if (!empty($products)) {
                foreach ($products as $item) {
                    $variantId = $item['variant_id'];
                    $orderedQty = $item['ordered_quantity'];
            
                    // Obtener stock actual del producto
                    $product = $this->db->get_where('product', array('product_id' => $variantId))->row();
                    if ($product) {
                        $currentStock = $product->stock;
            
                        // Sumar la cantidad vendida de vuelta al stock
                        $newStock = $currentStock + $orderedQty;
            
                        // Actualizar stock en la tabla product
                        $this->db->where('product_id', $variantId);
                        $this->db->update('product', array('stock' => $newStock));
                    }
                }
            }
            
            // Finalmente, actualizar el carrito como eliminado
            $this->db->where('cart_id', $id);
            $this->db->update('cart', array('status' => 0));

            $this->session->set_flashdata('flash_message' , "Venta eliminada correctamente.");
            redirect(base_url() . 'doctor/sales/', 'refresh');
        }
        
        
        
        
        $page_data['page_name']   = 'sales';
        $page_data['page_title']  = "Administrar ventas";
        $this->load->view('backend/index', $page_data);
    }
    
    function new_sale($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['sale_data']   = base64_decode($param1);
        $page_data['page_name']   = 'new_sale';
        $page_data['page_title']  = "Nueva venta";
        $this->load->view('backend/index', $page_data);
    }
    
    function panel($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']   = 'panel';
        $page_data['page_title']  = "Tablero";
        $this->load->view('backend/index', $page_data);
    }
    
    function appointment($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'finish')
        {
            $this->appointment_model->finish_appointment();   
            $this->session->set_flashdata('flash_message' , "Cita finalizada y archivada correctamente.");
            redirect(base_url() . 'doctor/appointments/', 'refresh');
        }
        if($param1 == 'create')
        {
            $this->appointment_model->create_appointment();
            $this->session->set_flashdata('flash_message' , "Cita agendada correctamente.");
            redirect(base_url() . 'doctor/appointments/', 'refresh');
        }
        if($this->session->userdata('login_user_id') == 1)
        {
            $page_data['page_name']   = 'appointment_doctor';
        }else {
            $page_data['page_name']   = 'appointment';
        }
        
        $page_data['page_title']  = "Agendar cita";
        $this->load->view('backend/index', $page_data);
    }
    
    function appointment_details_card($param1 = '', $param2 = '')
    {
        
        $app = $this->db->get_where('appointment',array('appointment_id'=>base64_decode($param1)))->result_array();
        foreach($app as $ap)
        {
        
                        $originalDate = $this->db->get_where('patient',array('patient_id'=>$ap['patient_id']))->row()->date_of_birth;
                        $newDate = date("d-m-Y", strtotime($originalDate));
                        $age = $this->accounts_model->get_age_card($originalDate);
                        
                        
                        if($this->db->get_where('patient',array('patient_id'=>$ap['patient_id']))->row()->gender == "M"):
                        $gender = 'Masculino'; 
                        else:
                            $gender =  'Femenino'; 
                        endif;
                         $phone = $this->db->get_where('patient',array('patient_id'=>$ap['patient_id']))->row()->phone;
                        if($this->db->get_where('patient',array('patient_id'=>$ap['patient_id']))->row()->marital_status == 0):
                            $civil = 'Soltero'; 
                        else:
                            $civil =  'Casado'; 
                        endif;
                         $adress = $this->db->get_where('patient',array('patient_id'=>$ap['patient_id']))->row()->address;
                         $date = $this->db->get_where('patient',array('patient_id'=>$ap['patient_id']))->row()->date;
                        
            $html = '<div  id="sticky"> 
            
            <div class="alert alert-white" style="margin-top: 42px;">
                    <span style="display:block;font-weight:bold;font-size:18px;font-family:"Poppins", sans-serif">Detalles de la cita:</span>
                        <div class="pi-controls">
                            <div class="pi-settings os-dropdown-trigger">
                                <i class="batch-icon-minus alert-rep-text"></i>
                            </div>
                        </div>
                        <div class="pipeline-item">
                            <div class="pi-body">
                                <div class="avatar" style="margin-right: 30px;">
                                    <img alt="" src="'.$this->accounts_model->get_photo('patient', $ap['patient_id']).'" width="65px" style="border-radius:25px;">
                                </div>
                                <div class="pi-info">
                                    <div class="h5 pi-name alert-rep-text">'.$this->accounts_model->get_full_name('patient', $ap['patient_id']).'</div>
                                    <div class="badge badge-success">Paciente nuevo.</div>
                                </div>
                            </div><hr>
                               <div class="">
                                <ul>
                                    <li><b>Fecha de registro:</b> '.$date.'</li>
                                    <li><b>Edad:</b> '.$age.'</li>
                                    <li><b>Género:</b> '.$gender.'</li>
                                    <li><b>Celular:</b> '.$phone.'</li>
                                    <li><b>Estado civil:</b> '.$civil.'</li>
                                    <li><b>Dirección:</b> '.$adress.'</li>
                                </ul>
                                <div class="alert alert-rep">
                                    <b>Motivo, molestias o síntomas del paciente:</b>
                                    <span style="display:block">'.$ap['comment'].'</span>
                                </div>';
                                if($ap['practice'] != 23 )
                                {
                                    $html .= ' <a class="btn btn-success" href="'.base_url().'doctor/appointment_details/'.base64_encode($ap['appointment_id']).'"><i class="picons-thin-icon-thin-0133_arrow_right_next"></i> Ingresar a la cita</a>';
                                }else
                                {
                                    $html .= ' <a class="btn btn-success" href="'.base_url().'doctor/treatment_details/'.base64_encode($ap['treatment_id']).'"><i class="picons-thin-icon-thin-0133_arrow_right_next"></i> Ingresar al tratamiento</a>';

                                }
                            $html .= '</div>
                        </div>
                    </div>
                    </div>';
        }
                echo $html;
        
     

    }

    
    function patient_treatment($param1 = '', $param2 = '')
    {
        
        $treatment = $this->db->get_where('odonto_treatment',array('patient_id'=>$param1,'status'=>1));

        if($treatment->num_rows()> 0 )
        {
            $html = '<div id="select_treatment"> <h3 class="main_question">Seleccione un tratamiento</h3>
                <div class = "row">
                <div class="col-md-12">
                <div class="form-group">
                        <select class="itemName2 form-control select2"  style="width:100%" name="select_treatment" required="" onchange="new_treatment(this.value)">
                            <option value="">Seleccionar</option>';

                            foreach($treatment->result_array() as $tr){
                          
                                $html .= ' <option value="'.$tr['treatment_id'].'">'.$tr['name'].'</option>';
                                        
                               
                                           }
           
                        $html .= ' <option value="0" >Nuevo tratamiento</option>
                        
                        </select>
                    </div>
                    </div>
                </div>
                </div>
                
                <div id="new_treatment" style="display:none"><h3 class="main_question"><strong>5/5</strong>Nuevo tratamiento</h3>
            <div class="form-group">
                <label>Nombre del plan</label>
                <input type="text" name="name_treatment" class="form-control" id="name_treatment" >
            </div>
            <br>
            <div class="form-group">
                <label>Tipo de tratamiento:</label>
                <div class="input-group">
                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                        <input class="radiobutton" type="radio" name="type_treatment" id="infantil" value="0"  >
                        <label class="radiobutton-label" for="infantil">Infantil</label>
                    </div> 
                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                        <input class="radiobutton" type="radio" name="type_treatment" id="adulto" value="1" >
                        <label class="radiobutton-label" for="adulto">Adulto</label>
                    </div>
                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                        <input class="radiobutton" type="radio" name="type_treatment" id="mixto" value="2">
                        <label class="radiobutton-label" for="mixto">Mixto</label>
                    </div>
                </div>
            </div>
            <input type="hidden" name="patient_id" value="'.$param1.'">
            </div>
            ';

        }else
        {
            
                        
            $html = '<h3 class="main_question"><strong>5/5</strong>Nuevo tratamiento</h3>
            <div class="form-group">
                <label>Nombre del plan</label>
                <input type="text" name="name_treatment" class="form-control" required="" >
            </div>
            <br>
            <div class="form-group">
                <label>Tipo de tratamiento:</label>
                <div class="input-group">
                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                        <input class="radiobutton" type="radio" name="type_treatment" id="infantil" value="0"  required="">
                        <label class="radiobutton-label" for="infantil">Infantil</label>
                    </div>
                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                        <input class="radiobutton" type="radio" name="type_treatment" id="adulto" value="1" required="">
                        <label class="radiobutton-label" for="adulto">Adulto</label>
                    </div>
                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                        <input class="radiobutton" type="radio" name="type_treatment" id="mixto" value="2" required="">
                        <label class="radiobutton-label" for="mixto">Mixto</label>
                    </div>
                </div>
            </div>
            <input type="hidden" name="patient_id" value="'.$param1.'">';
        }
                echo $html;

    }
    
    
   
        function appointment_patients($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'finish')
        {
            $this->appointment_model->finish_appointment();   
            $this->session->set_flashdata('flash_message' , "Cita finalizada y archivada correctamente.");
            redirect(base_url() . 'doctor/archived/', 'refresh');
        }
        if($param1 == 'create')
        {
            $this->appointment_model->create_appointment();
            $this->session->set_flashdata('flash_message' , "Cita agendada correctamente.");
            redirect(base_url() . 'doctor/patients/profile/'.$param2, 'refresh');
        }
        $page_data['id_']   = $param1;
        $page_data['page_name']   = 'appointment_patients';
        $page_data['page_title']  = "Agendar cita";
        $this->load->view('backend/index', $page_data);
    }
    
    function appointment_details($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['id_'] = $param1;
        $page_data['page_name']   = 'appointment_details';
        $page_data['page_title']  = "Detalles de la Cita";
        $this->load->view('backend/index', $page_data);
    }
    
    function chat($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'send_message')
        {
            $this->session->set_flashdata('flash_message' , "Mensaje enviado correctamente.");
            $this->chat_model->send_chat_message($this->input->post('thread_code'));
            redirect(base_url() . 'doctor/messages/' . $this->input->post('redirect'), 'refresh');
        }
        if($param1 == 'delete')
        {
            $this->chat_model->delete_chat($param2);
            $this->session->set_flashdata('flash_message' , "Mensaje eliminado correctamente.");
            redirect(base_url() . 'doctor/chat/', 'refresh');
        }  
        if($param1 == 'delete_single')
        {
            $this->chat_model->delete_single_chat($param2);
            $this->session->set_flashdata('flash_message' , "Mensaje eliminado correctamente.");
            redirect(base_url() . 'doctor/messages/'.$param3, 'refresh');
        }  
        $page_data['page_name']   = 'chat';
        $page_data['page_title']  = "Chat";
        $this->load->view('backend/doctor/chat', $page_data);
    }
    

    
    function messages($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        
        
        if(isset($_GET['notify'])){
            $update['read_status'] = 1;
            $this->db->where('message_id', $_GET['notify']);
            $this->db->update('message',$update);
        }
        $page_data['username'] = $param1;
        $page_data['page_name']   = 'messages';
        $page_data['page_title']  = "Mensajes";
        $this->load->view('backend/doctor/messages', $page_data);
    }
    
    function soon($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        if($this->input->post('date') != '')
        {
             $page_data['filter']         = base64_encode($this->input->post('date'));
        }else
        {
            $page_data['filter']            = false;
        }

        if($this->input->post('doctor_id') != '')
        {
            $this->session->set_userdata('doctor_id', $this->input->post('doctor_id'));
        }

        $page_data['page_name']   = 'soon';
        $page_data['page_title']  = "Próximas citas";
        $this->load->view('backend/index', $page_data);
    }
    
     function rescheduled($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        if($this->input->post('date') != '')
        {
             $page_data['filter']         = base64_encode($this->input->post('date'));
        }else
        {
            $page_data['filter']            = false;
        }

        if($this->input->post('doctor_id') != '')
        {
            $this->session->set_userdata('doctor_id', $this->input->post('doctor_id'));
        }

        $page_data['page_name']   = 'rescheduled';
        $page_data['page_title']  = "Citas Reprogramadas";
        $this->load->view('backend/index', $page_data);
    }
    
    function cancelled($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        if($this->input->post('date') != '')
        {
             $page_data['filter']         = base64_encode($this->input->post('date'));
        }else
        {
            $page_data['filter']            = false;
        }

        if($this->input->post('doctor_id') != '')
        {
            $this->session->set_userdata('doctor_id', $this->input->post('doctor_id'));
        }
        $page_data['page_name']   = 'cancelled';
        $page_data['page_title']  = "Citas Canceladas";
        $this->load->view('backend/index', $page_data);
    }
    
    function archived($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        if($this->input->post('date') != '')
        {
             $page_data['filter']         = base64_encode($this->input->post('date'));
        }else
        {
            $page_data['filter']            = false;
        }

        if($this->input->post('doctor_id') != '')
        {
            $this->session->set_userdata('doctor_id', $this->input->post('doctor_id'));
        }

        $page_data['page_name']   = 'archived';
        $page_data['page_title']  = "Citas Archivadas";
        $this->load->view('backend/index', $page_data);
    }
    
        function mail_view($param1 = ''){
            
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $data = array(
                'appointment_id' => $param1,
            );
        $this->load->view('backend/mails/mail_view.php',$data);
        
        }
        
        
        
    function appointments($param1 = '', $param2 = '') 
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'start')
        {
            $this->appointment_model->start_appointment(base64_decode($param2));
            $this->session->set_flashdata('flash_message' , "La cita ha comenzado.");
            redirect(base_url() . 'doctor/appointment_details/'.$param2, 'refresh');
        }
        if($param1 == 'confirm')
        {
            $patient_id = $this->db->get_where('appointment', array('appointment_id' => $param2))->row()->patient_id;
            
             $email_status = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->email_status;
             
            
            $this->log_model->confirm_appointment($param2);
            $this->appointment_model->confirm_appointment($param2);
            $this->notify_model->confirm_appointment($param2);

            $w_status = $this->db->get_where('patient', array('patient_id'=>$patient_id ))->row()->whatsapp_status;
            log_message('error',$w_status);
            if($w_status == 1)
            {
              //  $this->whatsapp->submit_confirmation($patient_id, $param2);
            }
          
          
          
            if($email_status==1)
            {          
                $email = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->email;
                require("public/apis/class.phpmailer.php");
                $mail = new PHPMailer(); 
                $mail->IsHTML(true);
                $mail->IsMail();
                $mail->CharSet = 'UTF-8';
                $mail->SetFrom($this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->email, 'Confirmación de cita');
                $mail->Subject = 'Confirmacion de cita - '.$this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->name;
                $data = array(
                    'appointment_id' => $param2,
                );
            
                $mail->Body = $this->load->view('backend/mails/confirm_appointment.php',$data,true);
                $mail->AddAddress($email);
                if($email != ''){
                    if(!$mail->Send()) {
                        $this->session->set_flashdata('flash_message' , "La cita no se pudo confirmar");
                        redirect(base_url() . 'doctor/appointments/', 'refresh');
                    }else
                    {
                        $this->session->set_flashdata('flash_message' , "Cita confirmada correctamente.");
                        redirect(base_url() . 'doctor/appointments/', 'refresh');
                    }
                }
            }else
            {
                  $this->session->set_flashdata('flash_message' , "Cita confirmada correctamente.");
                  redirect(base_url() . 'doctor/appointments/', 'refresh');
            }
            
        }
        if($param1 == 'remainder')
        {
            $patient_id = $this->db->get_where('appointment', array('appointment_id' => $param2))->row()->patient_id;
            
            $this->whatsapp->submit_remainder($patient_id, $param2);
            redirect(base_url() . 'doctor/archived/', 'refresh');
        }
        
        if($param1 == 'confirm_appointment_det')
        {
            $this->log_model->confirm_appointment($param2);
            $this->appointment_model->confirm_appointment($param2);
            $this->notify_model->confirm_appointment($param2);
            $this->session->set_flashdata('flash_message' , "Cita confirmada correctamente.");
            redirect(base_url() . 'doctor/appointment_details/'.base64_encode($param2), 'refresh');
        }
        if($param1 == 'cancel')
        {
            $this->log_model->cancel_appointment($param2);
            $this->appointment_model->cancel_appointment($param2);
            $this->notify_model->cancel_appointment($param2);
            $this->session->set_flashdata('flash_message' , "Cita cancelada correctamente.");
            redirect(base_url() . 'doctor/appointments/', 'refresh');
        }
        if($param1 == 'change')
        {
            $this->log_model->reschedule_appointment($param2);
            $this->appointment_model->reschedule_appointment($param2);
            $this->notify_model->reschedule_appointment($param2);
            $this->session->set_flashdata('flash_message' , "Cita reprogramada correctamente.");
            redirect(base_url() . 'doctor/appointments/', 'refresh');
        }
        if($param1 == 'delete')
        {
            $this->log_model->delete_appointment($param2);
            $this->notify_model->delete_appointment($param2);
            $this->appointment_model->delete_appointment($param2);
            $this->session->set_flashdata('flash_message' , "Cita eliminada correctamente.");
            redirect(base_url() . 'doctor/cancelled/', 'refresh');
        }
        if($param1 == 'delete_calendar')
        {
            $this->log_model->delete_appointment($param2);
            $this->notify_model->delete_appointment($param2);
            $this->appointment_model->delete_appointment($param2);
            $this->session->set_flashdata('flash_message' , "Eliminado correctamente.");
            redirect(base_url() . 'doctor/calendar/', 'refresh');
        }

        if($this->input->post('date') != '')
        {
             $page_data['filter']         = base64_encode($this->input->post('date'));
        }else
        {
            $page_data['filter']            = false;
        }

        if($this->input->post('doctor_id') != '')
        {
            $this->session->set_userdata('doctor_id', $this->input->post('doctor_id'));
        }

        $page_data['page_name']         = 'appointments';
        
        $page_data['page_title']        = "Citas";
        $this->load->view('backend/index', $page_data);
    }
    
    
    function pending_payment(){
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        if($this->input->post('date') != '')
        {
             $page_data['filter']         = base64_encode($this->input->post('date'));
        }else
        {
            $page_data['filter']            = false;
        }

        if($this->input->post('doctor_id') != '')
        {
            $this->session->set_userdata('doctor_id', $this->input->post('doctor_id'));
        }


        $page_data['page_name']     ='pending_payment';
        $page_data['page_title']    ='Citas pendientes de pago';
        $this->load->view('backend/index', $page_data);
        }
    
    
    
    function clinics($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'update')
        {
            $this->log_model->update_clinic($param2);
            $this->crud_model->update_clinic($param2);
            $this->session->set_flashdata('flash_message' , "Clínica actualizada correctamente.");
            redirect(base_url() . 'doctor/clinics/', 'refresh');
        }
        if($param1 == 'create')
        {
            $this->crud_model->create_clinic();
            $this->session->set_flashdata('flash_message' , "Clínica agregada correctamente.");
            redirect(base_url() . 'doctor/clinics/', 'refresh');
        }
        if($param1 == 'delete')
        {
            $this->crud_model->delete_clinic($param2);
            $this->session->set_flashdata('flash_message' , "Clínica eliminada correctamente.");
            redirect(base_url() . 'doctor/clinics/', 'refresh');
        }
        $page_data['page_name']  = 'clinics';
        $page_data['page_title'] = "Clínicas";
        $this->load->view('backend/index', $page_data); 
    }
    
    function patients($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        if($param1 == 'change_pass')
        {
            $this->accounts_model->update_patient_pass($param2);
            redirect(base_url() . 'doctor/patient_security/'.base64_encode($param2), 'refresh');   
        }

        if($param1 == 'allergies')
        {
            $data['patient_id'] = $this->input->post('patient_id');
            $data['name'] = $this->input->post('name');
            $data['date'] = $this->crud_model->formatDate();
            return $this->db->insert('allergie', $data);
        }
        
        if($param1 == 'delete_allergie')
        {
            $patient_id = base64_encode($this->db->get_where('allergie', array('allergie_id'=>$param2))->row()->patient_id);
            $this->crud_model->delete_allergie($param2);
            $this->session->set_flashdata('flash_message' , "Alergia eliminada correctamente.");
            redirect(base_url() . 'doctor/medical_history/'.$patient_id.'/', 'refresh');
        }
        
        if($param1 == 'create_pathological')
        {
            $pat = base64_encode($param2);
            $this->crud_model->create_pathological();
            $this->session->set_flashdata('flash_message' , "Antecedentes patológicos agregados correctamente.");
            redirect(base_url() . 'doctor/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'update_pathological')
        {
            $pat = base64_encode($param2);
            $this->crud_model->update_pathological($param2);
            $this->session->set_flashdata('flash_message' , "Antecedentes patológicos actualizados correctamente.");
            redirect(base_url() . 'doctor/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'create_no_pathological')
        {
            $pat = base64_encode($param2);
            $this->crud_model->create_no_pathological();
            $this->session->set_flashdata('flash_message' , "Antecedentes no patológicos agregados correctamente.");
            redirect(base_url() . 'doctor/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'update_no_pathological')
        {
            $pat = base64_encode($param2);
            $this->crud_model->update_no_pathological($param2);
            $this->session->set_flashdata('flash_message' , "Antecedentes no patológicos actualizados correctamente.");
            redirect(base_url() . 'doctor/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'create_recordfamily')
        {
            $pat = base64_encode($param2);
            $this->crud_model->create_recordfamily();
            $this->session->set_flashdata('flash_message' , "Antecedentes heredofamiliares agregados correctamente.");
            redirect(base_url() . 'doctor/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'update_recordfamily')
        {
            $pat = base64_encode($param2);
            $this->crud_model->update_recordfamily($param2);
            $this->session->set_flashdata('flash_message' , "Antecedentes heredofamiliares actualizados correctamente.");
            redirect(base_url() . 'doctor/medical_history/'.$pat.'/', 'refresh');
        }
      
        if($param1 == 'create_psychiatric')
        {
            $pat = base64_encode($param2);
            $this->crud_model->create_psychiatric();
            $this->session->set_flashdata('flash_message' , "Antecedentes psiquiátricos agregados correctamente.");
            redirect(base_url() . 'doctor/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'update_psychiatric')
        {
            $pat = base64_encode($param2);
            $this->crud_model->update_psychiatric($param2);
            $this->session->set_flashdata('flash_message' , "Antecedentes psiquiátricos actualizados correctamente.");
            redirect(base_url() . 'doctor/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'create_vaccination')
        {
            $pat = base64_encode($param2);
            $this->crud_model->create_vaccination();
            $this->session->set_flashdata('flash_message' , "Esquema de vacunación agregado correctamente.");
            redirect(base_url() . 'doctor/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'update_vaccination')
        {
            $pat = base64_encode($param2);
            $this->crud_model->update_vaccination($param2);
            $this->session->set_flashdata('flash_message' , "Esquema de vacunación actualizado correctamente.");
            redirect(base_url() . 'doctor/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'create_nutriological')
        {
            $pat = base64_encode($param2);
            $this->crud_model->create_nutriological();
            $this->session->set_flashdata('flash_message' , "Antecedentes nutriológicos agregados correctamente.");
            redirect(base_url() . 'doctor/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'update_nutriological')
        {
            $pat = base64_encode($param2);
            $this->crud_model->update_nutriological($param2);
            $this->session->set_flashdata('flash_message' , "Antecedentes nutriológicos actualizados correctamente.");
            redirect(base_url() . 'doctor/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'create_obstetric')
        {
            $pat = base64_encode($param2);
            $this->crud_model->create_obstetric();
            $this->session->set_flashdata('flash_message' , "Antecedentes gineco-obstétricos agregados correctamente.");
            redirect(base_url() . 'doctor/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'update_obstetric')
        {
            $pat = base64_encode($param2);
            $this->crud_model->update_obstetric($param2);
            $this->session->set_flashdata('flash_message' , "Antecedentes gineco-obstétricos actualizados correctamente.");
            redirect(base_url() . 'doctor/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'create_perinatal')
        {
            $pat = base64_encode($param2);
            $this->crud_model->create_perinatal();
            $this->session->set_flashdata('flash_message' , "Antecedentes perinatales agregados correctamente.");
            redirect(base_url() . 'doctor/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'update_perinatal')
        {
            $pat = base64_encode($param2);
            $this->crud_model->update_perinatal($param2);
            $this->session->set_flashdata('flash_message' , "Antecedentes perinatales actualizados correctamente.");
            redirect(base_url() . 'doctor/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'create_postnatal')
        {
            $pat = base64_encode($param2);
            $this->crud_model->create_postnatal();
            $this->session->set_flashdata('flash_message' , "Antecedentes postnatales agregados correctamente.");
            redirect(base_url() . 'doctor/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'update_postnatal')
        {
            $pat = base64_encode($param2);
            $this->crud_model->update_postnatal($param2);
            $this->session->set_flashdata('flash_message' , "Antecedentes postnatales actualizados correctamente.");
            redirect(base_url() . 'doctor/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'create')
        {
            $this->accounts_model->create_patient();
            $this->session->set_flashdata('flash_message' , "Paciente agregado correctamente.");
            redirect(base_url() . 'doctor/patients/', 'refresh');
        }
        if($param1 == 'update')
        {
            $this->log_model->update_patient($param2);
            $this->accounts_model->update_patient($param2);
            $this->session->set_flashdata('flash_message' , "Paciente actualizado correctamente.");
            if($this->input->post('profile') == 1)
            redirect(base_url() . 'doctor/patient_profile/'.base64_encode($param2), 'refresh');
            if($this->input->post('profile') == 2)
            redirect(base_url() . 'doctor/patients/', 'refresh');
        }
        if($param1 == 'delete')
        {
            $this->log_model->delete_patient($param2);
            $this->accounts_model->delete_patient($param2,true);
            $this->session->set_flashdata('flash_message' , "Paciente eliminado correctamente.");
            redirect(base_url() . 'doctor/patients/', 'refresh');
        }
        
         if($param1 == 'profile')
        {
            $page_data['id_']   = $param2;
        }
        
        
        $page_data['page_name']   = 'patients';
        $page_data['page_title']  = "Pacientes";
        $this->load->view('backend/index', $page_data);
    }
    
    
    function check_m()
    {
        
        
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        
        $response = $this->accounts_model->check_mail();
        
         header('Content-type: application/json; charset=utf-8');
         echo json_encode($response);
         exit();
    }
    
    
    
    
    function doctors($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'doctor_auth_link'){
            $this->security_model->updateSecret(base64_decode($param2));
            $this->session->set_flashdata('flash_message' , "Autenticación activada correctamente.");
            redirect(base_url() . 'doctor/doctor_security/'.base64_encode($param2), 'refresh');
        }
        if($param1 == 'remove_auth'){
            $this->security_model->remove_auth();
            $this->session->set_flashdata('flash_message' , "Autenticación desactivada correctamente.");
            redirect(base_url() . 'doctor/my_security/', 'refresh');
        }
        
        if($param1 == 'remove_auth_doctor'){
            $this->security_model->remove_authDoctor($param2);
            $this->session->set_flashdata('flash_message' , "Autenticación desactivada correctamente.");
            redirect(base_url() . 'doctor/doctor_security/'.base64_encode($param2), 'refresh');
        }
        
        if($param1 == 'create')
        {
            $this->accounts_model->create_doctor();
            $this->session->set_flashdata('flash_message' , "Doctor agregado correctamente.");
            redirect(base_url() . 'doctor/doctors/', 'refresh');
        }
        if($param1 == 'update')
        {
            $this->accounts_model->update_doctor($param2);
            $this->session->set_flashdata('flash_message' , "Doctor actualizado correctamente.");
            redirect(base_url() . 'doctor/doctors/', 'refresh');
        }
        
        if($param1 == 'update_profile')
        {
            $this->accounts_model->update_doctor_profile($param2);
            $this->session->set_flashdata('flash_message' , "Datos actualizados correctamente.");
            redirect(base_url() . 'doctor/my_profile/', 'refresh');
        }
        
        if($param1 == 'update_doctor_modules')
        {
            $this->accounts_model->update_doctor_modules($param2);
            $this->session->set_flashdata('flash_message' , "Datos actualizados correctamente.");
            redirect(base_url() . 'doctor/doctor_permissions/'.base64_encode($param2).'/', 'refresh');
        }
        
        if($param1 == 'update_profile_modules')
        {
            $this->accounts_model->update_doctor_modules($param2);
            $this->session->set_flashdata('flash_message' , "Datos actualizados correctamente.");
            redirect(base_url() . 'doctor/my_permissions/', 'refresh');
        }
        
        if($param1 == 'update_password')
        {
            $this->accounts_model->update_doctor_pass($param2);
        }
        
        if($param1 == 'update_password_profile')
        {
            $this->accounts_model->update_doctor_pass_profile($param2);  
        }
        
        if($param1 == 'delete')
        {
            $this->log_model->delete_doctor($param2);
            $this->accounts_model->delete_doctor($param2);
            $this->session->set_flashdata('flash_message' , "Doctor eliminado correctamente.");
            redirect(base_url() . 'doctor/doctors/', 'refresh');
        }
        
        if($param1 == 'remove_sessions')
        {
            $this->security_model->remove_sessionsDoctor($param2);
            $this->session->set_flashdata('flash_message' , "Sessiones eliminadas correctamente, por favor inicie sesión nuevamente");
            redirect(base_url() . 'doctor/my_security/', 'refresh');
        }
        
        if($param1 == 'remove_sessions_patient')
        {
            $this->security_model->remove_sessionsPa($param2);
            $this->session->set_flashdata('flash_message' , "Sessiones eliminadas correctamente");
            redirect(base_url() . 'doctor/patient_security/'.base64_encode($param2), 'refresh');
        }
        
        
        if($param1 == 'remove_sessions_staff')
        {
            $this->security_model->remove_sessionsStaff($param2);
            $this->session->set_flashdata('flash_message' , "Sessiones eliminadas correctamente");
            redirect(base_url() . 'doctor/staff_security/'.base64_encode($param2), 'refresh');
        }
        
        if($param1 == 'remove_sessions_doc')
        {
            $this->security_model->remove_sessionsDoctor($param2);
            $this->session->set_flashdata('flash_message' , "Sessiones eliminadas correctamente");
            redirect(base_url() . 'doctor/doctor_security/'.base64_encode($param2).'/', 'refresh');
        }
        if($this->session->userdata('login_user_id') == 1)
        {
            $page_data['doctors']      = $this->crud_model->getDoctors_sop();
        }else {
            $page_data['doctors']      = $this->crud_model->getDoctors();
        }
        $page_data['page_name']   = 'doctors';
        $page_data['page_title']  = "Doctores";
        $this->load->view('backend/index', $page_data);
    }
    
    function doctor_profile($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['id_']           = base64_decode($param1);
        $page_data['owner']         = $this->crud_model->account_owner();
        $page_data['page_name']     = 'doctor_profile';
        $page_data['page_title']    = "Perfil de Doctor";
        $this->load->view('backend/index', $page_data);
    }
    
    function change($clinic_id = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $set_id = base64_decode($clinic_id);
        $refer =  $this->agent->referrer();
        $this->session->set_userdata('current_clinic', $set_id);
        redirect($refer, 'refresh');
    }
    
    function filter($date = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        redirect(base_url() . 'doctor/appointments/'.base64_encode($this->input->post('date')), 'refresh');
    }
    
    function staff($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'create')
        {
            $this->accounts_model->create_staff();
            $this->session->set_flashdata('flash_message' , "Usuario agregado correctamente.");
            redirect(base_url() . 'doctor/staff/', 'refresh');
        }
        if($param1 == 'update')
        {
            $this->accounts_model->update_staff($param2);
            $this->session->set_flashdata('flash_message' , "Datos de usuario actualizados correctamente.");
            redirect(base_url() . 'doctor/staff_profile/'.base64_encode($param2), 'refresh');
        }
        if($param1 == 'update_staff_modules')
        {
            $this->accounts_model->update_staff_modules($param2);
            $this->session->set_flashdata('flash_message' , "Datos de usuario actualizados correctamente.");
            redirect(base_url() . 'doctor/staff_permissions/'.base64_encode($param2).'/', 'refresh');
        }
        
        if($param1 == 'remove_auth_staff'){
            $this->security_model->remove_authStaff($param2);
            $this->session->set_flashdata('flash_message' , "Autenticación desactivada correctamente.");
            redirect(base_url() . 'doctor/staff_security/'.base64_encode($param2), 'refresh');
        }
        if($param1 == 'update_password_staff')
        {
            $this->accounts_model->update_staff_pass_profile($param2);  
        }
        
        if($param1 == 'delete')
        {
            $this->accounts_model->delete_staff($param2);
            $this->session->set_flashdata('flash_message' , "Datos de usuario eliminados correctamente.");
            redirect(base_url() . 'doctor/staff/', 'refresh');
        }
        if($this->session->userdata('login_user_id') == 1)
        {
            $page_data['staff']       = $this->crud_model->getStaffList_sop();
        }else
        {
            $page_data['staff']       = $this->crud_model->getStaffList();
        }
        $page_data['page_name']   = 'staff';
        $page_data['page_title']  = "Equipo";
        $this->load->view('backend/index', $page_data);
    }
    
    function financial($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'invoice')
        {
            $file_name  = $this->db->get_where('financial', array('financial_id' => $param2))->row()->invoice_file;
            $info = file_get_contents("public/uploads/income_image/" . $file_name);
            force_download($file_name, $info);
        }
        if($param1 == 'reference')
        {
            $file_name  = $this->db->get_where('financial', array('financial_id' => $param2))->row()->reference_file;
            $info = file_get_contents("public/uploads/income_image/" . $file_name);
            force_download($file_name, $info);
        }
        if($param1 == 'create')
        {
            $this->crud_model->create_financial();
            
            $this->session->set_flashdata('flash_message' , "Datos agregados correctamente.");
            redirect(base_url() . 'doctor/financial/', 'refresh');
        }
       if($param1 == 'update')
        {
            $this->crud_model->update_income($param2);
            $this->session->set_flashdata('flash_message' , "Datos actualizados correctamente.");
            redirect(base_url() . 'doctor/financial/', 'refresh');
        }
        if($param1 == 'delete')
        {
            $this->crud_model->delete_income($param2);
            $this->session->set_flashdata('flash_message' , "Datos eliminados correctamente.");
            redirect(base_url() . 'doctor/financial/', 'refresh');
        }
        
        if($this->input->post('filtro') == 1)
        {
            $ingreso_hoy = 1;
        }
        if($this->input->post('filtro') == 2)
        {
            $semana = 1;
        }
        if($this->input->post('filtro') == 3)
        {
            $dias = 1;
        }

        $page_data['page_name']   = 'financial';
        $page_data['page_title']  = "Financiero";
        $this->load->view('backend/index', $page_data);
    } 
    

    function reports($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if(!empty($this->input->post('user_type')))
        {
            $tipo = explode(",",$this->input->post('user_type'));
            $page_data['_id']         = $tipo[0];
            $page_data['type']        = $tipo[1];    
            $this->log_model->activity_report();
        }
        
        else{
            $page_data['_id'] = 0;
        }
        
        $page_data['page_name']   = 'reports';
        $page_data['page_title']  = "Reportes";
        $this->load->view('backend/index', $page_data);
    } 
    
    function appointment_reports($param1 = '', $param2 = '')
    {
        if($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($this->input->post('doctor_id') != '')
        {
            $this->log_model->appointment_report();
        }

        if($this->input->post('doctor_id'))
            $page_data['doctor_id']    = $this->input->post('doctor_id');
        else
            $page_data['doctor_id']    = $this->session->userdata('login_user_id');

        
        $page_data['fecha1']    = $this->input->post('fecha1');
        $page_data['fecha2']    = $this->input->post('fecha2');
        
        
        $page_data['page_name']   = 'appointment_reports';
        $page_data['page_title']  = "Reporte de citas";
        $this->load->view('backend/index', $page_data);
    }
    
    function inventory_reports($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['fecha1']    = $this->input->post('fecha1');
        $page_data['fecha2']    = $this->input->post('fecha2');
        
        $page_data['page_name']   = 'inventory_reports';
        $page_data['page_title']  = "Reporte de inventario";
        $this->load->view('backend/index', $page_data);
    }
    
    function financial_reports($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        
        if($this->input->post('fecha1') != '')
        {
            $this->log_model->financial_report();
        }
        
        
        if($this->input->post('fecha1') == '' && $this->input->post('fecha2') == '' )
        {
            $anioActual = date("Y");
            $mesActual = date("m");
            $cantidadDias = cal_days_in_month(CAL_GREGORIAN, $mesActual, $anioActual);
            $fecha = $cantidadDias.'/'.$mesActual.'/'.$anioActual;
            $hoy = '01/'.$mesActual.'/'.$anioActual;
            
            $page_data['fecha1']      =  $hoy;
            $page_data['fecha2']      =  $fecha;
            
        }else
        {
            
        $page_data['fecha1']      = $this->input->post('fecha1');
        $page_data['fecha2']      = $this->input->post('fecha2');
        }
        
        

        $page_data['page_name']   = 'financial_reports';
        $page_data['page_title']  = "Reporte de finanzas";
        $this->load->view('backend/index', $page_data);
    }
    
    function settings($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'sessions')
        {
            $this->log_model->delete_session();
            $this->db->truncate('ci_sessions');    
            $this->session->set_flashdata('flash_message' , "Cambios aplicados correctamente.");
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'apply')
        {
            $this->crud_model->update_settings();
            $this->session->set_flashdata('flash_message' , "Cambios aplicados correctamente.");
            redirect(base_url() . 'doctor/settings/', 'refresh');
        }
        $page_data['page_name']   = 'settings';
        $page_data['page_title']  = "Configuración";
        $this->load->view('backend/index', $page_data);
    }
    
    function services($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'create')
        {
            $this->crud_model->create_service();
            $this->session->set_flashdata('flash_message' , "Servicio agregado correctamente.");
            redirect(base_url() . 'doctor/services/', 'refresh');
        }
        
        if($param1 == 'update')
        {
            $this->crud_model->update_service($param2);
            $this->session->set_flashdata('flash_message' , "Servicios actualizados correctamente.");
            redirect(base_url() . 'doctor/services/', 'refresh');
        }
        
          if($param1 == 'delete')
        {
            $this->log_model->delete_service($param2);
            $this->crud_model->delete_service($param2);
            $this->session->set_flashdata('flash_message' , "Servicios eliminados correctamente.");
            redirect(base_url() . 'doctor/services/', 'refresh');
        }
        
        $page_data['page_name']   = 'services';
        $page_data['page_title']  = "Servicios";
        $this->load->view('backend/index', $page_data);
    }
    
    function profile($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']   = 'profile';
        $page_data['page_title']  = "Perfil";
        $this->load->view('backend/index', $page_data);
    }
    
    function calendar($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']   = 'calendar';
        $page_data['page_title']  = "Calendario de citas";
        $this->load->view('backend/index', $page_data);
    }
    

    function patient_profile($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['id_'] = $param1;
        $page_data['page_name']   = 'patient_profile';
        $page_data['page_title']  = "Perfil del Paciente ";
        $this->load->view('backend/index', $page_data);
    }
    
    function treatment($param1 = '', $param2 = '')
    {
        $odonto = $this->db->get_where('clinic', array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->odonto;
        
        if ($this->session->userdata('doctor_login') != 1 || $odonto == '')
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['id_'] = $param1;
        $page_data['page_name']   = 'treatment';
        $page_data['page_title']  = "Planes de tratamiento";
        $this->load->view('backend/index', $page_data);
    }
    
    function treatment_details($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['id_']         = $param1;
        $page_data['page_name']   = 'treatment_details';
        $page_data['page_title']  = "Plan de tratamiento";
        $this->load->view('backend/index', $page_data);
    }
    
    function add_tooth()
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_urld(), 'refresh');
        }
        $checked = $this->input->post('process');
        $total_checked_values = count($checked);
        $permissions = '';
        for ($i = 0; $i < $total_checked_values; $i++) 
        {
            $data['odonto_treatment_id']  = $this->input->post('treatment_id');
            $data['tooth_id']             = $this->input->post('tooth_id');
            $data['date']                 = $this->crud_model->formatDate();
            $data['comment']              = $this->input->post('commentary');
            $data['process']              = $checked[$i];
            $data['status']               = 0;
            $this->db->insert('tooth_treatment', $data);
        }
        $this->session->set_flashdata('flash_message' , "Servicio agregado correctamente.");
        redirect(base_url() . 'doctor/treatment_details/'.base64_encode($this->input->post('treatment_id')), 'refresh');
    }
    
    
    
    function update_treatment($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        
        if($param1 == 'add_pay_credit')
        {
            $this->crud_model->insert_pay_credit();
            $this->session->set_flashdata('flash_message' , "Abono agregado correctamente.");
            redirect(base_url() . 'doctor/treatment_details/'.base64_encode($this->input->post('treatment_id')), 'refresh');
        }
        
        if($param1 == 'delete')
        {
            $this->crud_model->delete_pay_credit($param2);
            return true;
        }
        
        if($param1 == 'close_treatment')
        {
            $data['status']             = 2;
            $this->db->where('treatment_id', $param2);
            $this->db->update('odonto_treatment', $data);
            
            $data22['status']             = 4;
            $this->db->where('treatment_id', $param2);
            $this->db->update('appointment', $data22);
            
            $this->session->set_flashdata('flash_message' , "Se ha finalizado el tratamiento correctamente.");
            redirect(base_url() . 'doctor/treatment/'.base64_encode($param3), 'refresh');
        }
        
        if($param1 == 'end_appointment')
        {
            $data22['status']             = 4;
            $this->db->where('treatment_id', $param2);
            $this->db->update('appointment', $data22);
            $this->session->set_flashdata('flash_message' , "Se ha marcado como finalizada la cita.");
            redirect(base_url() . 'doctor/treatment/'.base64_encode($param3), 'refresh');
            
        }
        
        if($param1 == 'not_consult')
        {
            $data33['practice']             = '';
            $this->db->where('appointment_id', $param2);
            $this->db->update('appointment', $data33);
            redirect(base_url() . 'doctor/treatment_details/'.base64_encode($param3), 'refresh');
        }
        
        if($param1 == 'add_consult')
        {
            $data33['practice']             = 23;
            $this->db->where('appointment_id', $param2);
            $this->db->update('appointment', $data33);
            redirect(base_url() . 'doctor/treatment_details/'.base64_encode($param3), 'refresh');
        }
        
        else
        {
            if($this->input->post('discount') <= $this->input->post('saldo_final'))
            {
                $data['discount']                   = $this->input->post('discount');
                $data['commentary_priv']            = $this->input->post('commentary2');
                $this->db->where('treatment_id', $this->input->post('treatment_id'));
                $this->db->update('odonto_treatment', $data);
                
                $data22['doctor_comment']           = $this->input->post('commentary');
                $this->db->where('appointment_id', $this->input->post('appointment_id'));
                $this->db->update('appointment', $data22);
                
                $this->session->set_flashdata('flash_message' , "Cambios agregados correctamente.");
                redirect(base_url() . 'doctor/treatment_details/'.base64_encode($this->input->post('treatment_id')), 'refresh');
            }
            else
            {
                $this->session->set_flashdata('error_message' , "El descuento no puede ser mayor al saldo restante");
                redirect(base_url() . 'doctor/treatment_details/'.base64_encode($this->input->post('treatment_id')), 'refresh');
            }
        }
        
    }
    
    
    function staff_profile($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['id_']         = $param1;
        $page_data['page_name']   = 'staff_profile';
        $page_data['page_title']  = "Perfil del Usuario ";
        $this->load->view('backend/index', $page_data);
    }
    
    function medical_history($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['id_'] = $param1;
        $page_data['page_name']   = 'medical_history';
        $page_data['page_title']  = "Historial médico";
        $this->load->view('backend/index', $page_data);
    }
    
    /*
    function get_weight()
    {
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        $patient_id = $_GET['id'];
        
        $result = '{
            "labels": ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            "data": {
                "quantity": ['.$this->results($patient_id,'01',date('Y')).','.$this->results($patient_id,'02',date('Y')).', '.$this->results($patient_id,'03',date('Y')).', '.$this->results($patient_id,'04',date('Y')).', '.$this->results($patient_id,'05',date('Y')).', '.$this->results($patient_id,'06',date('Y')).', '.$this->results($patient_id,'07',date('Y')).', '.$this->results($patient_id,'08',date('Y')).', '.$this->results($patient_id,'09',date('Y')).', '.$this->results($patient_id,'10',date('Y')).', '.$this->results($patient_id,'11',date('Y')).', '.$this->results($patient_id,'12',date('Y')).']
            }
        }';
        echo $result;
    }
    */
    

        function setFormat($fecha)
    {
        $date = explode("/", $fecha);
        $dia  = $date[1];
        $mes  = $date[0];
        $anio = $date[2];
        $string_month = "";
        $string_day   = "";
        
        if($mes <= 9){
            $string_month = str_replace("0","",$mes);
        }else{
            $string_month = $mes;
        }
        if($dia <= 9){
            $string_day = $dia;
        }else{
            $string_day = $dia;
        }
        
        return $string_day."/".$string_month.'/'.$anio;
    }
    
    function medical_prescriptions($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'pdf')
        {
            $patient_id = $this->db->get_where('appointment', array('appointment_id' => $param2))->row()->patient_id;
            $this->log_model->download_pdf($patient_id);
            $prescription_name = str_replace(' ','_', $this->accounts_model->get_name('patient', $patient_id));
            $data = array(
                'appointment_id' => $param2,
                'patient_id' => $patient_id, 
            );
            
            $hoy = date('d-m-Y_h:i:s');
            $html = $this->load->view('backend/generate_pdf.php',$data,TRUE); 
            $pdfFilePath = "prescripcion_medica-".$prescription_name.".pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('c', 'A4'); 
            $mpdf->packTableData = true;
            $mpdf->WriteHTML($html,2);
            $mpdf->Output($pdfFilePath, "D");  
            
        }
        if($param1 == 'send')
        {
            $patient_id = $this->db->get_where('prescription', array('prescription_id' => $param2))->row()->patient_id;
            $prescription_name = str_replace(' ','_', $this->accounts_model->get_name('patient', $patient_id));
            $data = array(
                'prescription_id' => $param2
            );
            $hoy = date('d-m-Y_h:i:s');
            $html = $this->load->view('backend/generate_pdf.php',$data,TRUE); 
            $pdfFilePath = "prescripcion_medica-".$prescription_name.".pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('c', 'A4'); 
            $mpdf->packTableData = true;
            $mpdf->WriteHTML($html,2);
            $mpdf->Output($pdfFilePath, "F");  
            
            $patient_id = $this->db->get_where('prescription', array('prescription_id' => $param2))->row()->patient_id;
            $email = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->email;
            
            require("public/apis/class.phpmailer.php");
            $mail = new PHPMailer(); 
            $mail->IsHTML(true);
            $mail->IsMail();
            $mail->CharSet = 'UTF-8';
            $mail->AddAttachment($pdfFilePath,$pdfFilePath); 
            $mail->SetFrom($this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->email, 'Confirmación de cita');
            $mail->Subject = '=?UTF-8?B?' . base64_encode("Receta médica electrónica") . '?=';
            $data = array(
                'patient_id' => $patient_id,
            );
        
            $mail->Body = $this->load->view('backend/mails/prescription.php',$data,TRUE);
            $mail->AddAddress($email);
            
            if($email != ''){
                if(!$mail->Send()) {
                    $this->session->set_flashdata('flash_message' , "La cita no se pudo confirmar");
                    redirect(base_url() . 'doctor/appointments/', 'refresh');
                }else
                {
                    $this->session->set_flashdata('flash_message' , "Cita confirmada correctamente.");
                    redirect(base_url() . 'doctor/appointments/', 'refresh');
                }
            }
            
            unlink($pdfFilePath);

        }
        $page_data['id_'] = $param1;
        $page_data['page_name']   = 'medical_prescriptions';
        $page_data['page_title']  = "Recetas";
        $this->load->view('backend/index', $page_data);
    }
    
    
    function patient_security($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['id_'] = $param1;
        $page_data['page_name']   = 'patient_security';
        $page_data['page_title']  = "Seguridad";
        $this->load->view('backend/index', $page_data);
    }
    
    function refresh_patient_files($patient_id)
    {
        $refresh_query  = $this->db->get_where('patient_file',array('patient_id' => $patient_id));
        if($refresh_query->num_rows() > 0)
        {
		    foreach($refresh_query->result_array() as $row)
		    {

               /*
		        $html_table .= '
    		        <div class="col-sm-6">
    				    <a target="_blanck" href="'.base_url().'public/uploads/patient_files/'.$row['name'].'" class="v-project-files">
							<img src="'.$this->crud_model->get_format($row['format']).'" style="max-width:35px">
    					    <p class="v-project-files-name" data-toggle="tooltip" data-placement="top" title="'.$row['old_name'].'">'.substr($row['old_name'],0,30).' <span>'.$row['size'].' <object style="z-index:999"><a style="text-decoration:none;" href="javascript:void(0);" onclick="confirm_delete('."'".$row['name']."'"."".')"><i style="font-size:16px;font-weight:bold;color:#fd4f57" class="picons-thin-icon-thin-0057_bin_trash_recycle_delete_garbage_full"></i></a></object></span> </p>
						</a>
				    </div>';  */ 



                   $html_table = '
                   <div class="col-sm-6">
                   <div class="support-ticket">
                       <a href="javascript:void(0);" style="text-decoration:none;color:#556180" onclick="showSharedFiles(1)">
                           <div class="st-body">
                               <div class="avatar">
                                   <img src="https://guateapps.app/rocket/public/uploads/98864e6d123df51d90cd3d560b44ce32folder.svg" style="max-width:30px">
                               </div>
                               <div class="ticket-content">
                                   <div class="ticket-description">
                                       <div class="os-progress-bar primary">
                                           <div class="bar-labels">
                                               <div class="bar-label-left">
                                                   <span class="bigger">Shared with me</span>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </a>
                   </div>
             
              '; 
		    }





            echo $html_table;
        }else{
            echo '<div class="col-sm-12"><br><center><h5 class="poppins">Aún no hay archivos subidos</h5><br><img src="'.base_url().'public/uploads/archivos_compartidos.svg" style="max-width:20%;"></center></div>';
        }
    }
    
    function patient_files($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'download'){
            $patient_id = $this->db->get_where('patient_file', array('patient_file_id' => $param2))->row()->patient_id;
            $this->log_model->download_file($patient_id);
            $file_name  = $this->db->get_where('patient_file', array('patient_file_id' => $param2))->row()->name;
            $old_name  = $this->db->get_where('patient_file', array('patient_file_id' => $param2))->row()->old_name;
            $info = file_get_contents("public/uploads/patient_files/" . $file_name);
            force_download($old_name, $info);
        }
        if($param1 == 'delete')
        {
            $patient_id = $this->db->get_where('patient_file', array('patient_file_id' => $param2))->row()->patient_id;   
            $file_name  = $this->db->get_where('patient_file', array('patient_file_id' => $param2))->row()->name; 
            $this->db->where('patient_file_id', $param2);
            $this->db->delete('patient_file');
            unlink("public/uploads/patient_files/" . $file_name);
            $this->session->set_flashdata('flash_message' , "Archivo eliminado correctamente.");
            redirect(base_url() . 'doctor/patient_files/'.base64_encode($patient_id), 'refresh');
        }
        if($param1 == 'ajax_upload'){

            parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
            
            $this->log_model->file_uploaded($_GET['patient_id']);
            
            include('public/apis/class.fileuploader.php');
            $FileUploader = new FileUploader('files', array(
                'uploadDir' => './public/uploads/patient_files/',
                'replace' => true,
            ));
            $data = $FileUploader->upload();
            
            $insert_data['patient_id']      = $_GET['patient_id']; 
            $insert_data['name']            = $data['files'][0]['name'];
            $insert_data['format']          = $data['files'][0]['extension'];
            $insert_data['size']            = $data['files'][0]['size2'];
            $insert_data['old_name']        = $data['files'][0]['old_name'];
            $insert_data['date']            = $this->crud_model->formatDate();
            $this->db->insert('patient_file', $insert_data);



	        echo json_encode($data);
	        exit;
        }

        $patient_folder = $this->db->get_where('patient',array('patient_id'=>base64_decode($param1)))->row()->folder;
        $have_folder = $this->db->get_where('settings',array('type'=>'folderId'))->row()->description;

        if ($patient_folder == 0 && $have_folder != '') 
        {
            log_message('error','Paciente carpeta');
            $this->createPatientFolder(base64_decode($param1));

        }
        $page_data['id_'] = $param1;
        $page_data['page_name']   = 'patient_files';
        $page_data['page_title']  = "Archivos del Paciente";
        $this->load->view('backend/index', $page_data);
    }
    
    function patient_appointments($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['id_'] = $param1;
        $page_data['page_name']   = 'patient_appointments';
        $page_data['page_title']  = "Citas del Paciente";
        $this->load->view('backend/index', $page_data);
    }
    
    function patient_financial($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'email')
        {
            $data = array(
                'income_id' => $param2
            );
            $hoy = date('d-m-Y_h:i:s');
            $html = $this->load->view('backend/generate_invoice.php',$data,TRUE); 
            $pdfFilePath = "recibo_Medicaby-".$hoy.".pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('utf-8', 'A4'); 
            $mpdf->packTableData = true;
            $mpdf->WriteHTML($html,2);
            $mpdf->Output('public/uploads/'.$pdfFilePath, "F");

            $patient_id = $this->db->get_where('financial', array('financial_id' => $param2))->row()->patient_id;
            $email = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->email;
            $patient_name = $this->accounts_model->short_name('patient',$patient_id);
            require("public/apis/class.phpmailer.php");
            $mail = new PHPMailer(); 
            $mail->IsHTML(true);
            $mail->IsMail();
            $mail->CharSet = 'UTF-8';
            $mail->AddAttachment('public/uploads/'.$pdfFilePath,$pdfFilePath);   
            $mail->SetFrom('no-reply@medicaby.com', 'Notificaciones Medicaby');
            $mail->Subject = 'Recibo electrónico - Medicaby';
            $data = array(
                'patient_name' => $patient_name,
                'patient_id' => $patient_id,
            );
            $mail->Body = $this->load->view('backend/mails/invoice.php',$data,TRUE);
            $mail->AddAddress($email);
            if($email != ''){
                if(!$mail->Send()) {
                    echo "Mailer Error: " . $mail->ErrorInfo;
                }       
            }
            
            unlink("public/uploads/" . $pdfFilePath);
            
            $this->session->set_flashdata('flash_message' , "Correo enviado correctamente.");

        }
        if($param1 == 'pdf')
        {
            $data = array(
                'income_id' => $param2
            );
            $hoy = date('d-m-Y_h:i:s');
            $html = $this->load->view('backend/generate_invoice.php',$data,TRUE); 
            $pdfFilePath = "recibo_Medicaby-".$hoy.".pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('utf-8', 'A4'); 
            $mpdf->packTableData = true;
            $mpdf->WriteHTML($html,2);
            $mpdf->Output($pdfFilePath, "D");
            
        }
        $page_data['id_'] = $param1;
        $page_data['page_name']   = 'patient_financial';
        $page_data['page_title']  = "Financiero";
        $this->load->view('backend/index', $page_data);
    }
    
    function specialties($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        
        if($param1 == 'create')
        {
            $this->crud_model->create_specialtie();
            $this->session->set_flashdata('flash_message' , "Especialidad agregada correctamente.");
            redirect(base_url() . 'doctor/specialties/', 'refresh');
        }
        
        if($param1 == 'update')
        {
            $this->crud_model->update_specialtie($param2);
            $this->session->set_flashdata('flash_message' , "Especialidad actualizada correctamente.");
            redirect(base_url() . 'doctor/specialties/', 'refresh');
        }
        
        if($param1 == 'delete')
        {
            $this->crud_model->delete_specialtie($param2);
            $this->session->set_flashdata('flash_message' , "Especialidad eliminada correctamente.");
            redirect(base_url() . 'doctor/specialties/', 'refresh');
        }
        $page_data['page_name']   = 'specialties';
        $page_data['page_title']  = "Especialidades";
        $this->load->view('backend/index', $page_data);
    }
    
   function laboratories($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        
        if($param1 == 'create')
        {
            $this->crud_model->create_laboratory();
            $this->session->set_flashdata('flash_message' , "Laboratorio agregado correctamente.");
            redirect(base_url() . 'doctor/laboratories/', 'refresh');
        }
        
         if($param1 == 'update')
        {
            $this->crud_model->update_laboratory($param2);
            $this->session->set_flashdata('flash_message' , "Laboratorio actualizado correctamente.");
            redirect(base_url() . 'doctor/laboratories/', 'refresh');
        }
        
        if($param1 == 'delete')
        {
            $this->crud_model->delete_laboratory($param2);
            $this->session->set_flashdata('flash_message' , "Laboratorio eliminado correctamente.");
            redirect(base_url() . 'doctor/laboratories/', 'refresh');
        }
        
        $page_data['page_name']   = 'laboratories';
        $page_data['page_title']  = "Laboratorios";
        $this->load->view('backend/index', $page_data);
    }
    

     function surveys($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        
        if($param1 == 'create')
        {
            
            $survey_id = $this->crud_model->create_survey();
            $this->session->set_flashdata('flash_message' , "Encuesta creada correctamente.");
            redirect(base_url() . 'doctor/question_board/'.$survey_id.'/', 'refresh');
        }
        
         if($param1 == 'update')
        {
            $this->log_model->update_survey($param2);
            $this->crud_model->update_survey($param2);
            $this->session->set_flashdata('flash_message' , "Encuesta actualizada correctamente.");
            redirect(base_url() . 'doctor/question_board/'.$param2.'/', 'refresh');
        }
        
        if($param1 == 'delete')
        {
            $this->crud_model->delete_survey($param2);
            $this->crud_model->delete_questions($param2);
            $this->session->set_flashdata('flash_message' , "Encuesta eliminada correctamente.");
            redirect(base_url() . 'doctor/surveys/', 'refresh');
        }
        
        $page_data['page_name']   = 'surveys';
        $page_data['page_title']  = "Encuestas";
        $this->load->view('backend/index', $page_data);
    }
    
      
    function question_board($codigo = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        
        $page_data['page_name']  = 'question_board';
        $page_data['page_title'] =  "Tablero";
        $page_data['codigo'] =  $codigo;
        $this->load->view('backend/index', $page_data);
    }
    
    
    
    function multiple_choice($param1 = '',$param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        
        if($param1 == 'create')
        {
            $this->crud_model->create_multiple_choice($param2);
            $this->session->set_flashdata('flash_message' , "Pregunta creada correctamente.");
            redirect(base_url() . 'doctor/questions/'.$param2.'/', 'refresh');
        }
        
        $page_data['page_name']  = 'multiple_choice';
        $page_data['page_title'] =  "Preguntas multiples";
        $page_data['codigo'] =  $param1;
        $this->load->view('backend/index', $page_data);
    }
    
    function questions($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        
        if($param1 == 'text')
        {
            $this->crud_model->create_text($param2);
            $this->session->set_flashdata('flash_message' , "Pregunta creada correctamente.");
            redirect(base_url() . 'doctor/questions/'.$param2.'/', 'refresh');
        }
        
        if($param1 == 'satisfaction')
        {
            $this->crud_model->create_satisfaction($param2);
            $this->session->set_flashdata('flash_message' , "Pregunta creada correctamente.");
            redirect(base_url() . 'doctor/questions/'.$param2.'/', 'refresh');
        }
        
        if($param1 == 'update')
        {
            $id_survey = $this->db->get_where('question', array('question_id' => $param2))->row()->survey_id;
            $this->crud_model->update_question($param2);
            $this->session->set_flashdata('flash_message' , "Pregunta actualizada correctamente.");
            redirect(base_url() . 'doctor/questions/'.$id_survey.'/', 'refresh');
        }
        
        if($param1 == 'delete')
        {
            $id_survey = $this->db->get_where('question', array('question_id' => $param2))->row()->survey_id;
            $this->crud_model->delete_question($param2);
            $this->session->set_flashdata('flash_message' , "Pregunta eliminada correctamente.");
            redirect(base_url() . 'doctor/questions/'.$id_survey.'/', 'refresh');
        }
        
        $page_data['page_name']  = 'questions';
        $page_data['page_title'] =  "Preguntas";
        $page_data['codigo'] =  $param1;
        $this->load->view('backend/index', $page_data);
    }
    
    
    function update_multiple($param1 = '',$param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }   
        
        if($param1 == 'update')
        {
            $id_survey = $this->db->get_where('question', array('question_id' => $param2))->row()->survey_id;
            $page_data['codigo'] =  $param2;
            $this->crud_model->update_multiple_choice($param2);
            $this->session->set_flashdata('flash_message' , "Pregunta actualizada correctamente.");
            redirect(base_url() . 'doctor/update_multiple/'.$param2.'/'.$id_survey.'/', 'refresh');
        }
        $page_data['codigo']        = $param1;
        $page_data['surv_id']       = $param2;
        $page_data['page_name']     = 'update_multiple';
        $page_data['page_title']    = "Actualizar pregunta";
        $this->load->view('backend/index', $page_data);
    }
    
    
    function hour_busy($param1 = '', $param2 = '')
    {

        $this->db->where('date',$this->input->post('date'));
        $this->db->where('status !=',2);
        $this->db->where('status !=',3);
        $this->db->where('status !=',4);
        $this->db->where('doctor_id',$this->input->post('doctor_id'));
        
        $query =  $this->db->get('appointment')->result_array();
        
        
        header('Content-type: application/json; charset=utf-8');
         echo json_encode($query);
         exit();
         
       
    }
    
    
   /*
    
    
   function solicite_data()
    {
        
          $this->accounts_model->solicite_data();
        
    }

    */
    

    
    
    function total_inventario()
    {
        $query = $this->db->get_where('product', array('clinic_id' => $this->session->userdata('current_clinic')));
        $currency = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
        if($query->num_rows()>0){
            $html_table = '
                    <table class="table table-padded demo" id="mainTable">
                    <thead style="background-color:#f9fbfc; color:#59636d;">
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Codigo</th>
                        <th>Precio&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th>Fecha Expiración</th>
                        <th>Existencias</th>
                        <th>Descripción</th>
                    </thead>
                    <tbody>';
       
        
        foreach($query->result_array() as $row)
        {
            $html_table .= '
                <tr style="font-size:14px;" class="">
                    <td>'.$row['product_id'].'</td>
                    <td>'.$row['name'].'</td>
                    <td>'.$row['code'].'</td>
                    <td style="width: 70px;">'.$currency.'. '.number_format($row['price'],'2','.',',').'</td>
                    <td>'.$row['expiration_date'].'</td>
                    <td>'.$row['stock'].'</td>
                    <td>'.$row['description'].'</td>
                </tr>';
        }
        
        $html_table .='<tbody></table>';
        echo $html_table;
        }else{
            $html_table = '

                                     table class="table table-padded demo" id="mainTable">
            					        <thead>
            					            <th>Paciente</th>
            					            <th>Especialista</th>
            					            <th>Fecha & Hora</th>
            					            <th>Estado</th>
            					        </thead>
                                        <tbody>';
                                        
                                        
        $html_table .='</tbody></table>';
        echo $html_table;
        }
        
    }
    
    function vencido_inventario()
    {
        $query =  $this->crud_model->product_expiration22($this->session->userdata('current_clinic'),date('d/m/Y'));
        $currency = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
        if(count($query)>0){
            $html_table = '
                    <table class="table table-padded demo" id="mainTable">
                    <thead style="background-color:#f9fbfc; color:#59636d;">
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Codigo</th>
                        <th>Precio&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th>Fecha Expiración</th>
                        <th>Existencias</th>
                        <th>Descripción</th>
                    </thead>
                    <tbody>';
       
        
        foreach($query as $row)
        {
            $html_table .= '
                <tr>
                    <td>'.$row['product_id'].'</td>
                    <td>'.$row['name'].'</td>
                    <td>'.$row['code'].'</td>
                    <td>'.$currency.'. '.number_format($row['price'],'2', '.', ',').'</td>
                    <td>'.$row['expiration_date'].'</td>
                    <td>'.$row['stock'].'</td>
                    <td>'.$row['description'].'</td>
                </tr>';
        }
        
        $html_table .='</tbody></table>';
        echo $html_table;
        }else{
           $html_table = '

                                    <table class="table table-padded demo" id="mainTable">
            					        <thead>
            					            <th>Paciente</th>
            					            <th>Especialista</th>
            					            <th>Fecha & Hora</th>
            					            <th>Estado</th>
            					        </thead>
                                        <tbody>';
                                        
                                        
        $html_table .='</tbody></table>';
        echo $html_table;
        }
        
    }
    
    function vencer_inventario(){
        
        $fecha_cambiada = mktime(0,0,0,date("m")+0,date("d")+30,date("Y")+0);
        $fecha = date("d/m/Y",$fecha_cambiada);
        $currency = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
        $query = $this->crud_model->product_expiration($this->session->userdata('current_clinic'),date('d/m/Y'),$fecha);
        
         if(count($query)>0){
            $html_table = '
                    <table class="table table-padded demo" id="mainTable">
                    <thead style="background-color:#f9fbfc; color:#59636d;">
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Codigo</th>
                        <th>Precio&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th>Fecha Expiración</th>
                        <th>Existencias</th>
                        <th>Descripción</th>
                    </thead>
                    <tbody>';
        
        foreach($query as $row)
        {
            $html_table .= '
                <tr>
                    <td>'.$row['product_id'].'</td>
                    <td>'.$row['name'].'</td>
                    <td>'.$row['code'].'</td>
                    <td>'.$currency.'. '.number_format($row['price'],'2','.',',').'</td>
                    <td>'.$row['expiration_date'].'</td>
                    <td>'.$row['stock'].'</td>
                    <td>'.$row['description'].'</td>
                </tr>';
        }
        
        $html_table .='</tboy></table>';
        echo $html_table;
        }else{
            $html_table = '

                                    <table class="table table-padded demo" id="mainTable">
            					        <thead>
            					            <th>Paciente</th>
            					            <th>Especialista</th>
            					            <th>Fecha & Hora</th>
            					            <th>Estado</th>
            					        </thead>
                                        <tbody>';
                                        
                                        
        $html_table .='</tbody></table>';
        echo $html_table;
        }
        
    }
    
    function agotado_inventario()
    {
    $currency = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;  
    
    $query = $this->db->get_where('product', array('stock' => 0, 'clinic_id' => $this->session->userdata('current_clinic'))); 
    
    if($query->num_rows()>0){
            $html_table = '
                    <table class="table table-padded demo" id="mainTable">
                    <thead style="background-color:#f9fbfc; color:#59636d;">
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Codigo</th>
                        <th>Precio&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th>Fecha Expiración</th>
                        <th>Existencias</th>
                        <th>Descripción</th>
                    </thead>
                    <tbody>';
       
        
        foreach($query->result_array() as $row)
        {
            $html_table .= '
                <tr>
                    <td>'.$row['product_id'].'</td>
                    <td>'.$row['name'].'</td>
                    <td>'.$row['code'].'</td>
                    <td>'.$currency.'. '.number_format($row['price'],'2','.',',').'</td>
                    <td>'.$row['expiration_date'].'</td>
                    <td>'.$row['stock'].'</td>
                    <td>'.$row['description'].'</td>
                </tr>';
        }
        
        $html_table .='</tbody></table>';
        echo $html_table;
        }else{
             $html_table = '

                                     <table class="table table-padded demo" id="mainTable">
            					        <thead>
            					            <th>Paciente</th>
            					            <th>Especialista</th>
            					            <th>Fecha & Hora</th>
            					            <th>Estado</th>
            					        </thead>
                                        <tbody>';
                                        
                                        
        $html_table .='</tbody></table>';
        echo $html_table;
        }
        
    }
    
    
    function pay_appointment($param1 = '',$param2 = '',$param3 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        if($param1 == 'email')
        {
            $patient_id         = $param3;//$this->db->get_where('cart', array('appointment_id' => $param2))->row()->patient_id;
            $sale_id            = $this->db->get_where('cart', array('appointment_id' => $param2))->row()->cart_id;
            $prescription_name  = str_replace(' ','_', $this->accounts_model->get_name('patient', $patient_id));
            
            $data = array(
                'appointment_id' => $param2,
                'sale_id' => $sale_id,
                'patient_id' => $patient_id
            );
            
            $html = $this->load->view('backend/pdf_recipe.php',$data,TRUE); 
            $pdfFilePath = "recibo_de_venta-".$prescription_name.".pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('c', 'A4'); 
            $mpdf->packTableData = true;
            $mpdf->WriteHTML($html,2);
            $mpdf->Output('public/uploads/'.$pdfFilePath, "F");

            $email = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->email;

            log_message('error', $email);
            $patient_name = $this->accounts_model->short_name('patient',$patient_id);
            require("public/apis/class.phpmailer.php");
            $mail = new PHPMailer(); 
            $mail->IsHTML(true);
            $mail->IsMail();
            $mail->CharSet = 'UTF-8';
            $mail->AddAttachment('public/uploads/'.$pdfFilePath,$pdfFilePath);   
            $mail->SetFrom('no-reply@medicaby.com', 'Notificaciones Medicaby');
            $mail->Subject = '=?UTF-8?B?' . base64_encode("Recibo electrónico") . '?=';
            $data2 = array(
                'patient_name' => $patient_name,
                'patient_id' => $patient_id,
            );
            $mail->Body = $this->load->view('backend/mails/receipt.php',$data2,TRUE);
            $mail->AddAddress($email);
            if($email != ''){
                if(!$mail->Send()){
                    echo "Mailer Error: " . $mail->ErrorInfo;
                }       
            }
            unlink("public/uploads/" . $pdfFilePath);
            
            $this->session->set_flashdata('flash_message' , "Correo enviado correctamente.");
            redirect(base_url() . 'doctor/pay_appointment/'.base64_encode($param2), 'refresh');
        }

        $page_data['id_']         = $param1;
        $page_data['page_name']   = 'pay_appointment';
        $page_data['page_title']  = "Detalles de la venta";
        $this->load->view('backend/index', $page_data);
        
    }
    

    
    function new_doctor($param1 = '',$param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        
        $page_data['page_name']     = 'new_doctor';
        $page_data['page_title']    = 'Nueva cuenta de doctor';
        $this->load->view('backend/index', $page_data);
    }
    
    
    function doctor_security($param1 = '',$param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['id_']           = base64_decode($param1);
        $page_data['owner']         = $this->crud_model->account_owner();
        $page_data['page_name']     = 'doctor_security';
        $page_data['page_title']    = 'Seguridad';
        $this->load->view('backend/index', $page_data);
    }
    
    function doctor_calendar($param1 = '',$param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['id_']           = base64_decode($param1);
        $page_data['owner']         = $this->crud_model->account_owner();
        $page_data['page_name']     = 'doctor_calendar';
        $page_data['page_title']    = 'Agenda';
        $this->load->view('backend/index', $page_data);
    }
    
    function doctor_appointments($param1 = '',$param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['id_']           = base64_decode($param1);
        $page_data['owner']         = $this->crud_model->account_owner();
        $page_data['page_name']     = 'doctor_appointments';
        $page_data['page_title']    = 'Citas';
        $this->load->view('backend/index', $page_data);
    }
    
    
    function doctor_permissions($param1 = '',$param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['id_']           = base64_decode($param1);
        $page_data['owner']         = $this->crud_model->account_owner();
        $page_data['page_name']     = 'doctor_permissions';
        $page_data['page_title']    = 'Permisos';
        $this->load->view('backend/index', $page_data);
    }
    
    
    function doctor_activity($param1 = '',$param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['id_']           = base64_decode($param1);
        $page_data['owner']         = $this->crud_model->account_owner();
        $page_data['page_name']     = 'doctor_activity';
        $page_data['page_title']    = 'Actividades';
        $this->load->view('backend/index', $page_data);
    }

    function activity($param1 = '',$param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        if($param1 == 'create')
        {
            $this->appointment_model->create_act();
            redirect(base_url() . 'doctor/panel/', 'refresh');
        }
       
    }
    
    
    function my_profile($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['owner']         = $this->crud_model->account_owner();
        $page_data['page_name']     = 'my_profile';
        $page_data['page_title']    = "Mi Perfil";
        $this->load->view('backend/index', $page_data);
    }
    
    function staff_notifications($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['id_']         = $param1;
        $page_data['page_name']   = 'staff_notifications';
        $page_data['page_title']  = "Notificaciones del Usuario ";
        $this->load->view('backend/index', $page_data);
    }
    
    function staff_security($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['id_']         = $param1;
        $page_data['owner']       = $this->crud_model->account_owner();
        $page_data['page_name']   = 'staff_security';
        $page_data['page_title']  = "Contraseña y seguridad del Usuario ";
        $this->load->view('backend/index', $page_data);
    }
    
    
    function staff_activity($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['id_']         = $param1;
        $page_data['page_name']   = 'staff_activity';
        $page_data['page_title']  = "Actividades del Usuario ";
        $this->load->view('backend/index', $page_data);
    }
    
    
    function my_notifications($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'delete')
        {
            $this->db->where('notification_id', $param2);
            $this->db->delete('notification');
            $this->session->set_flashdata('flash_message' , "Notificación eliminada correctamente.");
            redirect(base_url() . 'doctor/my_notifications/', 'refresh');
        }
        if($param1 == 'mark_read')
        {
            $data['read_status'] = 1;    
            $this->db->where('notification_id', $param2);
            $this->db->update('notification', $data);
            $this->session->set_flashdata('flash_message' , "Notificación actualizada correctamente.");
            redirect(base_url() . 'doctor/my_notifications/', 'refresh');
        }

        if($param1 == 'read')
        {
            $data['read_status'] = 1;    
            $this->db->where('to_user', $param2);
            $this->db->update('notification', $data);
        }


        $page_data['owner']         = $this->crud_model->account_owner();
        $page_data['page_name']   = 'my_notifications';
        $page_data['page_title']  = "Mis notificaciones";
        $this->load->view('backend/index', $page_data);
    }
    
    
     
    function my_security($param1 = '',$param2 = '')
     {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']     = 'my_security';
        $page_data['page_title']    = 'Seguridad';
        $this->load->view('backend/index', $page_data);
    }
    
        
    function my_activity($param1 = '',$param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']     = 'my_activity';
        $page_data['page_title']    = 'Mis actividades';
        $this->load->view('backend/index', $page_data);
    }
    
    
    function my_calendar($param1 = '',$param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']     = 'my_calendar';
        $page_data['page_title']    = 'Agenda';
        $this->load->view('backend/index', $page_data);
    }
    
    function my_appointments($param1 = '',$param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']     = 'my_appointments';
        $page_data['page_title']    = 'Citas';
        $this->load->view('backend/index', $page_data);
    }
    
    function my_permissions($param1 = '',$param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']     = 'my_permissions';
        $page_data['page_title']    = 'Permisos';
        $this->load->view('backend/index', $page_data);
    }
    
    function getTable($table = '' ,$param1 = '' ,$param2 = '' ,$param3 = '')
    {
        return $this->tables_model->getTables($table,$param1,$param2,$param3);   
    }
    
    
    function staff_permissions($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['id_']         = $param1;
        $page_data['page_name']   = 'staff_permissions';
        $page_data['page_title']  = "Permisos del Usuario ";
        $this->load->view('backend/index', $page_data);
    }
    
     function treatments_status($treatment_id)
    {
        $this->db->order_by('tooth_treatment_id', 'DESC');
        $this->db->where('odonto_treatment_id', $treatment_id);
        $treat = $this->db->get('tooth_treatment')->result_array();
        $stt = '';
        
        foreach($treat as $rs)
        {
            if($rs['status'] == 1)
            {
                $stt = 0;
            }
            else
            {
                $stt = 1;
            }
        }
        
        return $stt;
    }
    
    
    function treatmentss($treatment_id)
    {
        $this->db->where('odonto_treatment_id', $treatment_id);
        $detalles = $this->db->get('tooth_treatment')->num_rows();
        return $detalles;
    }
    
    
    function treatment_archive($param1 = '' ,$param2 = '' ,$param3 = '')
    {
         if ($this->session->userdata('doctor_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        
        if($param1 == 'email')
        {
            $patient_id         = $param3;
            $treatment_name     = str_replace(' ','_', $this->accounts_model->get_name('patient', $patient_id));
            
            $data = array(
                'treatment_id' => $param2,
                'patient_id' => $patient_id
            );
            $html = $this->load->view('backend/pdf_treatment.php',$data,TRUE); 
            $pdfFilePath = "Tratamiento_dental-".$treatment_name.".pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('c', 'A4'); 
            $mpdf->packTableData = true;
            $mpdf->WriteHTML($html,2);
            $mpdf->Output('public/uploads/'.$pdfFilePath, "F");

            $email = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->email;

            log_message('error', $email);
            $patient_name = $this->accounts_model->short_name('patient',$patient_id);
            require("public/apis/class.phpmailer.php");
            $mail = new PHPMailer(); 
            $mail->IsHTML(true);
            $mail->IsMail();
            $mail->CharSet = 'UTF-8';
            $mail->AddAttachment('public/uploads/'.$pdfFilePath,$pdfFilePath);   
            $mail->SetFrom('no-reply@medicaby.com', 'Notificaciones Medicaby');
            $mail->Subject = '=?UTF-8?B?' . base64_encode("Recibo electrónico") . '?=';
            $data2 = array(
                'patient_name' => $patient_name,
                'patient_id' => $patient_id,
            );
            $mail->Body = $this->load->view('backend/mails/receipt2.php',$data2,TRUE);
            $mail->AddAddress($email);
            if($email != ''){
                if(!$mail->Send()){
                    echo "Mailer Error: " . $mail->ErrorInfo;
                }       
            }
            unlink("public/uploads/" . $pdfFilePath);
            
            $this->session->set_flashdata('flash_message' , "Correo enviado correctamente.");
            redirect(base_url() . 'doctor/treatment/'.base64_encode($patient_id), 'refresh');
        }
        
        
        if($param1 == 'pdf')
        {
            $patient_id         = $param3;
            $treatment_name     = str_replace(' ','_', $this->accounts_model->get_name('patient', $patient_id));
            
            $data = array(
                'treatment_id' => $param2,
                'patient_id' => $patient_id
            );
            $html = $this->load->view('backend/pdf_treatment.php',$data,TRUE); 
            $pdfFilePath = "Tratamiento_dental-".$treatment_name.".pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('c', 'A4'); 
            $mpdf->packTableData = true;
            $mpdf->WriteHTML($html,2);
            $mpdf->Output($pdfFilePath, "D");  
        }
        
       
        if($param1 == 'delete')
        {
            return $this->appointment_model->delete_treatment($param2); 
        }
        
    }


    function thooth_procedures($param1 = '', $param2 = '')
    {
        $odonto = $this->db->get_where('clinic', array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->odonto;
        
        if ($this->session->userdata('doctor_login') != 1 || $odonto == "")
        {
            redirect(base_url(), 'refresh');
        }

        if($param1 == 'create')
        {
            $this->crud_model->create_process();
            $this->session->set_flashdata('flash_message' , "Procedimiento agregado correctamente.");
            redirect(base_url() . 'doctor/thooth_procedures/', 'refresh');
        }
        
        if($param1 == 'update')
        {
            $this->crud_model->update_process($param2);
            $this->session->set_flashdata('flash_message' , "Procedimiento actualizado correctamente.");
            redirect(base_url() . 'doctor/thooth_procedures/', 'refresh');
        }
        
          if($param1 == 'delete')
        {
            
            $this->crud_model->delete_process($param2);
            $this->session->set_flashdata('flash_message' , "Procedimiento eliminado correctamente.");
            redirect(base_url() . 'doctor/thooth_procedures/', 'refresh');
        }
        
        $page_data['page_name']   = 'thooth_procedures';
        $page_data['page_title']  = "Procedimientos dentales";
        $this->load->view('backend/index', $page_data);
    }


    function save_antecedent()
    {
        $type = $this->input->post('type');
        $allowed = array('md', 'qx', 'alg', 'trx', 'fam');
        if (!in_array($type, $allowed, true)) {
            return;
        }
        $data = array(
            'patient_id' => $this->input->post('patient_id'),
            'type' => $type,
            'item' => $this->input->post('item'),
            'treatment' => $this->input->post('treatment'),
            'notes' => $this->input->post('notes')
        );
        $antecedent_id = $this->input->post('antecedent_id');
        if ($antecedent_id != '' && is_numeric($antecedent_id)) {
            $this->db->where('antecedent_id', $antecedent_id);
            $this->db->update('patient_antecedent', $data);
            echo $antecedent_id;
            return;
        }
        $this->db->insert('patient_antecedent', $data);
        echo $this->db->insert_id();
    }

    function delete_antecedent($antecedent_id = '')
    {
        if ($antecedent_id == '') {
            return;
        }
        $this->db->where('antecedent_id', $antecedent_id);
        $this->db->delete('patient_antecedent');
    }

    function patient_app()
    {
       $id= $this->input->post('id'); 
       $cl= $this->input->post('cl');    
       $data[$cl] = $this->input->post('value');

       $oft_fields = array(
            'od_avsc', 'od_avcc', 'od_avph', 'od_meo', 'od_pio', 'od_pupilas',
            'os_avsc', 'os_avcc', 'os_avph', 'os_meo', 'os_pio', 'os_pupilas',
            'oft_vias_lagrimales_od', 'oft_vias_lagrimales_os',
            'oft_parpados_pestanas_od', 'oft_parpados_pestanas_os',
            'oft_conjuntiva_od', 'oft_conjuntiva_os',
            'oft_esclera_cornea_od', 'oft_esclera_cornea_os',
            'oft_camara_anterior_od', 'oft_camara_anterior_os',
            'oft_iris_od', 'oft_iris_os',
            'oft_cristalino_od', 'oft_cristalino_os',
            'oft_gonioscopia_od', 'oft_gonioscopia_os',
            'oft_vitreo_od', 'oft_vitreo_os',
            'oft_nervio_optico_od', 'oft_nervio_optico_os',
            'oft_retina_p_post_od', 'oft_retina_p_post_os',
            'oft_retina_periferica_od', 'oft_retina_periferica_os',
            'oft_ic', 'oft_tx',
            'lens_od_esf', 'lens_od_cil', 'lens_od_eje', 'lens_od_add',
            'lens_os_esf', 'lens_os_cil', 'lens_os_eje', 'lens_os_add',
            'ro_od_esf', 'ro_od_cil', 'ro_od_eje', 'ro_od_add',
            'ro_os_esf', 'ro_os_cil', 'ro_os_eje', 'ro_os_add',
            'rs_od_esf', 'rs_od_cil', 'rs_od_eje', 'rs_od_add',
            'rs_os_esf', 'rs_os_cil', 'rs_os_eje', 'rs_os_add',
            'rf_od_esf', 'rf_od_cil', 'rf_od_eje', 'rf_od_add',
            'rf_os_esf', 'rf_os_cil', 'rf_os_eje', 'rf_os_add',
            'rc_od_esf', 'rc_od_cil', 'rc_od_eje', 'rc_od_add',
            'rc_os_esf', 'rc_os_cil', 'rc_os_eje', 'rc_os_add',
            'graf_od_externo', 'graf_os_externo', 'graf_od_fondo', 'graf_os_fondo',
            'kera_od_k1', 'kera_od_k1_eje', 'kera_od_k1_nomarca', 'kera_od_k1_irregular', 'kera_od_kprom',
            'kera_od_k2', 'kera_od_k2_eje', 'kera_od_k2_nomarca', 'kera_od_k2_irregular',
            'kera_os_k1', 'kera_os_k1_eje', 'kera_os_k1_nomarca', 'kera_os_k1_irregular', 'kera_os_kprom',
            'kera_os_k2', 'kera_os_k2_eje', 'kera_os_k2_nomarca', 'kera_os_k2_irregular',
            'ar_od_esf', 'ar_od_cil', 'ar_od_eje', 'ar_od_nomarca', 'ar_od_dip',
            'ar_os_esf', 'ar_os_cil', 'ar_os_eje', 'ar_os_nomarca', 'ar_os_dip',
            'ar_notas_ojo', 'ar_notas', 'ar_diferido',
            'av_od_avl_sc', 'av_od_avl_cc', 'av_od_avc_sc', 'av_od_avc_cc', 'av_od_avl_ph',
            'av_os_avl_sc', 'av_os_avl_cc', 'av_os_avc_sc', 'av_os_avc_cc', 'av_os_avl_ph',
            'av_optotipo', 'av_notas_ojo', 'av_notas', 'av_diferido',
            'seg_vias_od', 'seg_vias_os', 'seg_parpados_od', 'seg_parpados_os',
            'seg_conjuntiva_od', 'seg_conjuntiva_os', 'seg_esclera_od', 'seg_esclera_os',
            'seg_cornea_od', 'seg_cornea_os', 'seg_camara_od', 'seg_camara_os',
            'seg_iris_od', 'seg_iris_os', 'seg_pupila_od', 'seg_pupila_os',
            'seg_cristalino_od', 'seg_cristalino_os',
            'seg_vias_od_nota', 'seg_vias_os_nota', 'seg_parpados_od_nota', 'seg_parpados_os_nota',
            'seg_conjuntiva_od_nota', 'seg_conjuntiva_os_nota', 'seg_esclera_od_nota', 'seg_esclera_os_nota',
            'seg_cornea_od_nota', 'seg_cornea_os_nota', 'seg_camara_od_nota', 'seg_camara_os_nota',
            'seg_iris_od_nota', 'seg_iris_os_nota', 'seg_pupila_od_nota', 'seg_pupila_os_nota',
            'seg_cristalino_od_nota', 'seg_cristalino_os_nota'
       );

       if (in_array($cl, $oft_fields, true)) {
            $existing = $this->db->get_where('appointment_oftalmology', array('appointment_id' => $id))->row_array();
            if (!is_array($existing) || empty($existing)) {
                $this->db->insert('appointment_oftalmology', array('appointment_id' => $id));
            }
            $this->db->where("appointment_id", $id);
            $this->db->update("appointment_oftalmology", $data);
            return;
       }

       $this->db->where("appointment_id",$id);
       $this->db->update("appointment",$data);
    }


    function patient_vitals()
    {

        $id= $this->input->post('id'); 
       //Insert Signos vitales.
       $this->db->where('appointment_id', $id);
       $signs = $this->db->get('vital_sign')->result_array();
       if(count($signs)<1)
       {
           
            $cl= $this->input->post('cl');  
            $data['appointment_id'] = $id;  
            $data[$cl] = $this->input->post('value');
            $this->db->insert('vital_sign', $data);
       }else 
       {
           
            $cl= $this->input->post('cl');    
            $data[$cl] = $this->input->post('value');

            $this->db->where("appointment_id",$id);
            $this->db->update("vital_sign",$data);
           
       }
  
    }

    function updateDataPatient()
    {
       $id= $this->input->post('id'); 
       $cl= $this->input->post('cl');    
       $data[$cl] = $this->input->post('value');

       $this->db->where("patient_id",$id);
       $this->db->update("patient",$data);

    }


    function test_email()
    {
        if($this->session->userdata('current_clinic'))
        {
            
            
            $survey_status = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->send_survey;
            if($survey_status == 1)
            {
                
               
                
                $survey_id = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->survey_id;
                
                $email = 'jags.santiago@gmail.com';
    
                $service_id = 32;
                if($service_id > 0)
                {
                    $service_name = $this->db->get_where('service', array('service_id' => $service_id))->row()->name;
                }else
                {
                    $service_name = "Otros servicios";
                }
    
                if($email != '' )
                {
                    
                     //echo 'XD3 '.$survey_id.'-'.$service_id.' - '.$email;  
                     
                    require("public/apis/class.phpmailer.php");
                    $mail = new PHPMailer(); 
                    $mail->IsHTML(true);
                    $mail->IsMail();
                    $mail->CharSet = 'UTF-8';
                    $mail->SetFrom('no-reply@medicaby.com', 'Notificaciones Medicaby');
                    $mail->Subject = 'Encuesta de servicio - Medicaby';
                    $data = array(
                        'survey_id' => $survey_id,
                        'patient_id' => 1213,
                        'appointment_id' => 6189,
                        'service_name' => $service_name
                    );
                    $mail->Body = $this->load->view('backend/mails/survey.php',$data,TRUE);
                    $mail->AddAddress($email);
                    if($email != ''){
                        if(!$mail->Send()) {
                            echo "Mailer Error: " . $mail->ErrorInfo;
                        }     
                        else {
                            $mail->ClearAddresses();
                            echo "Your request has been submitted successfully";
                        }
                    }
                    
                    

                }
               
            }
        }
    }


    public function email()
    {


        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'notificaciones.medicaby@gmail.com',
            'smtp_pass' => 'cxtpqqtcadmzwsaw',
            'mailtype'  => 'html', 
            'charset'   => 'utf-8',
            'wordwrap' => true
        );
        $this->load->library('email', $config);
        $this->email->initialize($config);
    
        $this->email->set_newline("\r\n");
        
        $this->email->from('notificaciones.medicaby@gmail.com', 'Correo electrónico');
    
        $this->email->to( 'atezo@mayansource.com' );
    
        $this->email->subject('Cuenta registrada');
    
        $this->email->message('nuevo correo');
        if ($this->email->send()) {
            echo 'enviado';
        } else {
            show_error($this->email->print_debugger());
        }
        

    }

    function whatsapp_test()
    {
        $this->whatsapp_model->send_whatsapp1('59','programar');
    }

    function recordatorios()
    {
        $fecha_ac = date('d-m-Y');
        $fecha = date("d/m/Y",strtotime($fecha_ac."+ 1 days")); 
        $appointments =  $this->db->where_in('status',array(0,1))->get_where('appointment',array('date'=>$fecha))->result_array();
        echo $fecha.'<br>'; 
        foreach($appointments as $row)
        {
            log_message('error','Recordatorio '.$row['appointment_id']);
            echo $row['appointment_id'].' '.'<br>';
            $this->whatsapp_model->send_whatsapp($row['appointment_id'],'recordatorio');
            
        }
        
    }


  function saveCert()
    {
        $patient_cert_id = $this->input->post('patient_cert_id');
        
        $data = array(
                'patient_id' =>$this->input->post('patient_id'),
                'contenido'=>$this->input->post('patient_id'),
            );
            
            
        if($this->input->post('patient_cert_id') == 0)
        {
            $this->db->insert('patient_cert',$data);
            $patient_cert_id = $this->db->insert_id();
        }else
        {
            $this->db->where('patient_cert_id',$this->input->post('patient_cert_id'));
            $this->db->update('patient_cert',$data);
        }
        
        echo $patient_cert_id;
        exit();
                
        
    }



    


}