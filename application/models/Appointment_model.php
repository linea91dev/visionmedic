<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Appointment_model extends CI_Model 
{
    function __construct() 
    {
      parent::__construct();
    }
    
    function get_now($clinic_id)
    {
        $this->db->order_by('appointment_id','asc');
        $this->db->where('clinic_id',$clinic_id);
        $this->db->where('status !=',4);
        $this->db->where('status !=',10);
        $appointments = $this->db->get('appointment')->result_array();
        return $appointments;
    }
    
    function get_now_doctor($clinic_id, $doctor_id)
    {
        $this->db->order_by('appointment_id','asc');
        $this->db->where('doctor_id',$doctor_id);
        $this->db->where('clinic_id',$clinic_id);
        $this->db->where('status !=',4);
        $this->db->where('status !=',10);
        $appointments = $this->db->get('appointment')->result_array();
        return $appointments;
    }
    
    function get_aptms_doctor($clinic_id, $doctor_id)
    {
        $this->db->order_by('appointment_id','asc');
        $this->db->where('clinic_id',$clinic_id);
        $this->db->where('doctor_id',$doctor_id);
        $this->db->where('status !=',4);
        $this->db->where('status !=',10);
        $appointments = $this->db->get('appointment')->result_array();
        return $appointments;
    }
    
    function getTitle($appointment_id, $status){
        $title = '';
        if($status != 5){
            $practice = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->practice;
            $patient  = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->patient_id;
            $title    = $this->crud_model->get_service($practice).' - '.$this->accounts_model->short_name('patient',$patient);
        }else{
            $title = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->Title;
        }
        return $title;
    }
    
    function finish_appointment()
    {
        $data['doctor_comment']       = $this->input->post('instructions');
        $data['charges']              = $this->input->post('total_appointment');
        $data['sub_total']            = $this->input->post('total_appointment');
        $data['reason']               = $this->input->post('reason');
        $data['status']               = 10;
        $data['physical_exploration'] = $this->input->post('exploration');
        $data['treatment_plan']       = $this->input->post('ckplan');
        $data['duration']             = $this->input->post('final_time');
        $this->db->where('appointment_id', $this->input->post('appointment_id'));
        $this->db->update('appointment', $data);
        $patient_id = $this->db->get_where('appointment', array('appointment_id' => $this->input->post('appointment_id')))->row()->patient_id;
        
        //Insert Seguimiento nutriológico
        $data4['weight']          = $this->input->post('weight');
        $data4['grease']          = $this->input->post('grease');
        $data4['waist']           = $this->input->post('waist');
        $data4['water']           = $this->input->post('water');
        $data4['muscle']          = $this->input->post('muscle');
        $data4['abdomen']         = $this->input->post('abdomen');
        $data4['patient_id']      = $patient_id;
        $data4['appointment_id']  = $this->input->post('appointment_id');
        $data4['date']  = $this->crud_model->formatDate();
        $this->db->insert('nutritional_history', $data4);
        
        
        //Insert Cetosis
        $data5['satiety']         = $this->input->post('satiety');
        $data5['cramps']          = $this->input->post('cramps');
        $data5['diarrhea']        = $this->input->post('diarrhea');
        $data5['depressed']       = $this->input->post('depressed');
        $data5['tolerance']       = $this->input->post('tolerance');
        $data5['constipation']    = $this->input->post('constipation');
        $data5['vertigo']         = $this->input->post('vertigo');
        $data5['anxiety']         = $this->input->post('anxiety');
        $data5['irritability']    = $this->input->post('irritability');
        $data5['impulse']         = $this->input->post('impulse');
        $data5['halitosis']       = $this->input->post('halitosis');
        $data5['hunger']          = $this->input->post('hunger');
        $data5['sleep_problems']  = $this->input->post('sleep_problems');
        $data5['impatient']       = $this->input->post('impatient');
        $data5['stimulants']      = $this->input->post('stimulants');
        $data5['migraine']        = $this->input->post('migraine');
        $data5['tiredness']       = $this->input->post('tiredness');
        $data5['concentration']   = $this->input->post('concentration');
        $data5['aggression']      = $this->input->post('aggression');
        $data5['patient_id']      = $patient_id;
        $data5['appointment_id']  = $this->input->post('appointment_id');
        $data5['date']  = $this->crud_model->formatDate();
        $this->db->insert('cetosis_history', $data5);
        
        
        $survey_status = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->send_survey;
        if($survey_status == 1)
        {
            $survey_id = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->survey_id;
            
            $email = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->email;

            $service_id = $this->db->get_where('appointment', array('appointment_id' => $this->input->post('appointment_id')))->row()->practice;
            if($service_id > 0)
            {
                $service_name = $this->db->get_where('service', array('service_id' => $service_id))->row()->name;
            }else
            {
                $service_name = "Otros servicios";
            }

            if($email != '' )
            {
                require("public/apis/class.phpmailer.php");
                $mail = new PHPMailer(); 
                $mail->IsHTML(true);
                $mail->IsMail();
                $mail->CharSet = 'UTF-8';
                $mail->SetFrom('no-reply@medicaby.com', 'Notificaciones Medicaby');
                $mail->Subject = 'Encuesta de servicio - Medicaby';
                $data = array(
                    'survey_id' => $survey_id,
                    'patient_id' => $patient_id,
                    'appointment_id' => $this->input->post('appointment_id'),
                    'service_name' => $service_name
                );
                $mail->Body = $this->load->view('backend/mails/survey.php',$data,TRUE);
                $mail->AddAddress($email);
                if($email != ''){
                    if(!$mail->Send()) {
                        echo "Mailer Error: " . $mail->ErrorInfo;
                    }       
                }
            }
           
        }
    }
     
    function calendar_start_date($date, $time)
    {
        $received = explode('/',$date);
        $received_day    = $received[0];
  
        $received_month  = $received[1];
   
        $received_year   = $received[2];
        $return_date = $received_year."-".$received_month."-".$received_day."T".$time.":00-06:00";
        return $return_date;
    }
    
    function calendar_end_date($date, $time)
    {
        $interval        = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->time_interval;
        $ex_time         = explode(':', $time);
        $hour            = $ex_time[0];
        $other = '';
        $new_hora        = '';
        
        $temp = 0;
        if($hour < 10){
            $new_hora = str_replace("0","", $hour);
        }else{
            $new_hora = $hour;
        }
        $minutes = 0;
        $mins         = $ex_time[1]+$interval;
        if($mins >= 60)
        {
            $other = $new_hora+1;
            $temp=$mins-60;
            
            if($temp == 0 )
            {
                
                 $minutes = $temp.'0';
                
            }else
            {
                
                 $minutes = $temp;
                
            }
           
        }else{
            $minutes = $mins;
            $other = $new_hora;
        }
        $received        = explode('/',$date);
        $received_day    = $received[0];
     
        $received_month  = $received[1];
    
        $received_year   = $received[2];
        if($other < 10){
            $return_date = $received_year."-".$received_month."-".$received_day."T0".$other.":".$minutes.":00-06:00";   
        }else{
            $return_date = $received_year."-".$received_month."-".$received_day."T".$other.":".$minutes.":00-06:00";
        }
        return $return_date;
    }
    
    
    
    function start_appointment($appointment_id)
    {
        $data['start_status'] = 1;
        $this->db->where('appointment_id', $appointment_id);
        $this->db->update('appointment', $data);
    }
    
    function get_status($status)
    {
        $return = '';
        if($status == 0)
        {
            $return = 'fc-event-warning fc-event-solid-pending';
        }
        else if($status == 1){
            $return = 'fc-event-warning fc-event-solid-confirmed';
        }
        else if($status == 2){
            $return = 'fc-event-warning fc-event-solid-cancelled';
        }
        else if($status == 3){
            $return = 'fc-event-warning fc-event-solid-repro';
        }else if($status == 5){
            $return = 'fc-event-danger fc-event-solid-warning';
        }else {
            $return = 'bg-pending';
        }
        return $return;
    }

    function create_appointment()
    {
        require("public/apis/class.phpmailer.php");
        $mail = new PHPMailer(); 
                    
        $treatment_id = '';
        if($this->input->post('practice_id') == 23)
        {

            if($this->input->post('name_treatment') != ''){
                $datat['name'] = $this->input->post('name_treatment');
                $datat['type'] = $this->input->post('type_treatment');
                $datat['date'] = $this->crud_model->formatDate();
                $datat['patient_id'] = $this->input->post('patient_id');
                $datat['doctor_id'] = $this->session->userdata('login_user_id');
                $this->db->insert('odonto_treatment', $datat);
                $treatment_id = $this->db->insert_id();
              
            }else
            {

                $treatment_id = $this->input->post('select_treatment');


            }
        }



        $post_date   = explode('/',$this->input->post('date_picked'));
        $order_day   = $post_date[0];
        $order_month = $post_date[1];
        $order_year  = $post_date[2];
        if($order_day <= 9){
            $order_day = "0".$order_day;
        }
        if($order_month <= 9){
            $order_month = "0".$order_month;
        }
        $order_date = $order_year."-".$order_month."-".$order_day." ".$this->input->post('radio').":00";
        if($this->input->post('patient_type') == '0')
        {
            $data['patient_id']   = $this->input->post('patient_id');   
            $email = $this->db->get_where('patient',array('patient_id'=>$this->input->post('patient_id')))->row()->email;
        }else{

            $password              = $this->accounts_model->getPassword();
            $data2['first_name']    = $this->input->post('first_name');
            $data2['second_name']     = $this->input->post('second_name');
            $data2['third_name']     = $this->input->post('third_name');
            $data2['last_name']     = $this->input->post('last_name');
            $data2['second_last_name']     = $this->input->post('second_last_name'); 
            $data2['password']      = sha1($password);
            $data2['username']      = $this->accounts_model->getUsername(strtolower($this->accounts_model->normalizeText($this->input->post('first_name')." ".$this->input->post('last_name'))));
            $data2['email']         = $this->input->post('email');
            $data2['dpi']         = $this->input->post('dpi');
            $data2['phone']         = $this->input->post('phone');
            $data2['gender']        = $this->input->post('gender');
            $data2['address']        = $this->input->post('address');
            $data2['marital_status']        = $this->input->post('marital_status');
            $data2['status']        = 1;
            $data2['date_of_birth'] = $this->input->post('date_of_birth');
            $data2['clinic_id']     =  $this->session->userdata('current_clinic');
            $data2['date']        = $this->crud_model->formatDate();


            $this->db->insert('patient', $data2);
            $patient_id = $this->db->insert_id();
            $data['patient_id']   = $patient_id;   
            
            
             $email = $this->input->post('email');
            
              if($this->input->post('email') != "")
                {
                    
                    $mail->IsHTML(true);
                    $mail->IsMail();
                    $mail->CharSet = 'UTF-8';
                    $mail->SetFrom('notificaciones@medicaby.com', 'Notificaciones Medicaby');
                    $mail->Subject = "Cuenta creada";
                    $data_email = array(
                        'email_msg' => "¡Hola ".str_replace(' ', '',$this->input->post('first_name'))."! Recibes esta notificación porque se ha creado una nueva cuenta de usuario en <b>".$this->accounts_model->system_name()."</b>, tus datos son los siguientes: <br><br><b>Usuario: </b>".$data2['username']."<br><b>Contraseña:</b> ".$password."<br> Para iniciar sesión haz click aquí: ".base_url().'/login'
                    );
                    $mail->Body = $this->load->view('backend/mails/credentials.php',$data_email,TRUE);
                    $mail->AddAddress($this->input->post('email'));
                    if(!$mail->Send()) {
                        echo "Mailer Error: " . $mail->ErrorInfo;
                          $mail->clearAddresses();
                    }
       
                }

        }
        $data['order_date']   = $order_date;
        if($this->session->userdata('login_type') == 'doctor' && $this->session->userdata('login_user_id') != 1){
            $data['doctor_id']     = $this->session->userdata('login_user_id');
        }else{
            $data['doctor_id']     = $this->input->post('doctor_id');   
        }



        $data['practice']     = $this->input->post('practice_id');
        $data['date']         = $this->input->post('date_picked');
        $data['comment']      = $this->input->post('comment');
        $data['time']         = $this->input->post('radio');
        $data['clinic_id']    = $this->session->userdata('current_clinic');
        $data['treatment_id']    = $treatment_id;
        $data['system_date']  = $this->crud_model->formatDate();
        $date = explode('/',$this->input->post('date_picked'));
        $day = $date[0];
        $month = $date[1];
        $year = $date[2];
        
        $data['day']         = $day;
        $data['month']       = $month;
        $data['year']        = $year;
        $this->db->insert('appointment', $data);
        $app_id = $this->db->insert_id();
        $this->log_model->new_appointment($data['patient_id'],$this->input->post('practice_id'));
         $this->whatsapp_model->send_whatsapp($app_id,'programar');
        if($email != "")
        {
            
                $mail->IsHTML(true);
                $mail->IsMail();
                $mail->CharSet = 'UTF-8';
                $mail->SetFrom('notificaciones@medicaby.com', 'Cita programada');
                $mail->Subject = 'Cita programada';
                $data = array(
                    'appointment_id' => $app_id,
                );
            
                $mail->Body = $this->load->view('backend/mails/shedule_appointment.php',$data,true);
                $mail->AddAddress($email);
               
                if(!$mail->Send()) {
                  echo "Mailer Error: " . $mail->ErrorInfo;
                }
           

        }




    }
    
    
        function create_act()
    {
        $time = "";
        if($this->input->post('morning') != ''){
            $time = $this->input->post('morning');
        }elseif($this->input->post('afternoon') != ''){
            $time = $this->input->post('afternoon');
        }

        $data['doctor_id']     = $this->input->post('doctor_id');   
        $data['comment']      = $this->input->post('comment');
        $data['Title']      = $this->input->post('titulo');
        $data['time']         = date("H:i", strtotime($time));
        $data['clinic_id']    = $this->session->userdata('current_clinic');
        $data['system_date']  = $this->crud_model->formatDate();
        $data['status'] = 5;
        $date = explode('/',$this->input->post('date'));
        $day = $date[0];
        $month = $date[1];
        $year = $date[2];
        $data['date']         = $this->input->post('date');
        $data['day']         = $day;
        $data['month']       = $month;
        $data['year']        = $year;
        $this->db->insert('appointment', $data);
        $this->log_model->new_appointment($this->input->post('patient_id'),$this->input->post('practice_id'));
    }
    
    function reschedule_appointment($appointment_id)
    {
        $time = "";
        if($this->input->post('morning') != ''){
            $time = date( "H:i", strtotime($this->input->post('morning')));
        }elseif($this->input->post('afternoon') != ''){
            $time = date( "H:i", strtotime($this->input->post('afternoon')));
        }

        //--------------------------------------------------------
        $data['patient_id']   = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->patient_id;   
        $data['doctor_id']   = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->doctor_id;   
        $data['treatment_id']   = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->treatment_id;   
        $data['order_date']   = date('Y-m-d H:i:s');
        $data['practice']     = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->practice;
        $data['date']         = $this->input->post('date');
        $data['comment']      = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->comment;
        $date = explode('/',$this->input->post('date'));
        $data['time']         = $time;
        $data['day']          = $date[1];
        $data['month']        = $date[0];
        $data['year']         = $date[2];
        $data['status']   = 0;
        $data['comments'] = $this->input->post('comments');
        $data['clinic_id']    = $this->session->userdata('current_clinic');
        $data['system_date']  = $this->crud_model->formatDate();

        $this->db->insert('appointment', $data);
        $app_id = $this->db->insert_id();



        $data2['status']   = 3;
        $this->db->where('appointment_id', $appointment_id);
        $this->db->update('appointment', $data2);


    }
    
    function cancel_appointment($appointment_id)
    {
        $data['status'] = 2;
        $this->db->where('appointment_id', $appointment_id);
        $this->db->update('appointment', $data);
    }
    
    function confirm_appointment($appointment_id)
    {
        $data['status'] = 1;
        $this->db->where('appointment_id', $appointment_id);
        $this->db->update('appointment', $data);
    }
    
    function delete_appointment($appointment_id)
    {
        $this->db->where('appointment_id', $appointment_id);
        $this->db->delete('appointment');
        
        $this->db->where('appointment_id', $appointment_id);
        $this->db->delete('prescription');
        
        $this->db->where('appointment_id', $appointment_id);
        $this->db->delete('financial');
        
    }
    
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
    
    
    function delete_treatment($treatment_id)
    {
        $appoints            = $this->db->get_where('appointment', array('treatment_id' => $treatment_id))->result_array();
        foreach($appoints as $rs)
        {
            $this->db->where('appointment_id', $rs['appointment_id']);
            $this->db->delete('prescription');
        }
        
        $this->db->where('treatment_id', $treatment_id);
        $this->db->delete('odonto_treatment');
        
        $this->db->where('odonto_treatment_id', $treatment_id);
        $this->db->delete('tooth_treatment');
        
        $this->db->where('tooth_treatment_id', $treatment_id);
        $this->db->delete('payment_credit');
        
        $this->db->where('treatment_id', $treatment_id);
        $this->db->delete('financial');
        
        $this->db->where('treatment_id', $treatment_id);
        $this->db->delete('appointment');
        
        return true;
    }
    
    
    
    function create_odonto_treatment($doctor_id, $login_type)
    {
        if($this->input->post('name') != '')
        {
            $data['name']           = $this->input->post('name');
            $data['type']           = $this->input->post('type');
            $data['date']           = $this->crud_model->formatDate();
            $data['patient_id']     = $this->input->post('patient_id');
            $data['doctor_id']      = $doctor_id;
            $this->db->insert('odonto_treatment', $data);
            $id = $this->db->insert_id();
                
                $post_date          = explode('/',$this->input->post('date'));
                $order_day          = $post_date[0];
                $order_month        = $post_date[1];
                $order_year         = $post_date[2];
                if($order_day <= 9){
                    $order_day      = "0".$order_day;
                }
                if($order_month <= 9){
                    $order_month    = "0".$order_month;
                }
                
                $time = "";
                if($this->input->post('morning') != '')
                {
                    $time           = date("H:i", strtotime($this->input->post('morning')));
                }elseif($this->input->post('afternoon') != ''){
                    $time           = date("H:i", strtotime($this->input->post('afternoon')));
                }

                $order_date             = $order_year."-".$order_month."-".$order_day." ".$time.":00";
                $datas['patient_id']    = $this->input->post('patient_id');
                $datas['doctor_id']     = $doctor_id;
                $datas['order_date']    = $order_date;
                $datas['practice']      = '23';
                $datas['date']          = $this->input->post('date');//
                $datas['comment']       = 'Cita desde tratamiento';
                
                $datas['time']          = $time;
                $datas['clinic_id']     = $this->session->userdata('current_clinic');
                $datas['treatment_id']  = $id;
                $datas['system_date']   = $this->crud_model->formatDate();
                
                $date                   = explode('/',$this->input->post('date'));//
                $day = $date[0];
                $month = $date[1];
                $year = $date[2];
                $datas['day']           = $day;
                $datas['month']         = $month;
                $datas['year']          = $year;
                $this->db->insert('appointment', $datas);
            
            $this->session->set_flashdata('flash_message' , "Tratamiento creado correctamente.");
            redirect(base_url().$login_type.'/treatment_details/'.base64_encode($id), 'refresh');
            
        }
        elseif($this->input->post('treatment_id') != '')
        {
            
                $post_date              = explode('/',$this->input->post('date'));
                $order_day              = $post_date[0];
                $order_month            = $post_date[1];
                $order_year             = $post_date[2];
                if($order_day <= 9){
                    $order_day          = "0".$order_day;
                }
                if($order_month <= 9){
                    $order_month        = "0".$order_month;
                }
                $time = "";
                if($this->input->post('morning') != ''){
                    $time               = date("H:i", strtotime($this->input->post('morning')));
                }elseif($this->input->post('afternoon') != ''){
                    $time               = date("H:i", strtotime($this->input->post('afternoon')));
                }
                $order_date             = $order_year."-".$order_month."-".$order_day." ".$time.":00";
                $datas['patient_id']    = $this->input->post('patient_id');
                $datas['doctor_id']     = $doctor_id;
                $datas['order_date']    = $order_date;
                $datas['practice']      = '23';
                $datas['date']          = $this->input->post('date');//
                $datas['comment']       = 'Cita desde tratamiento';
                $datas['time']          = $time;//
                $datas['clinic_id']     = $this->session->userdata('current_clinic');
                $datas['treatment_id']  = $this->input->post('treatment_id');
                $datas['system_date']   = $this->crud_model->formatDate();
                
                $date                   = explode('/',$this->input->post('date'));//
                $day                    = $date[0];
                $month                  = $date[1];
                $year                   = $date[2];
                $datas['day']           = $day;
                $datas['month']         = $month;
                $datas['year']          = $year;
                $this->db->insert('appointment', $datas);
                
                $this->session->set_flashdata('flash_message' , "Cita asignada correctamente al tratamiento.");
                redirect(base_url().$login_type.'/treatment_details/'.base64_encode($this->input->post('treatment_id')), 'refresh');
        }
        
        else
        {
             $this->session->set_flashdata('error_message' , "Por favor, inténtelo de nuevo");
             redirect(base_url() .$login_type.'/panel/', 'refresh');
        }
    }
}