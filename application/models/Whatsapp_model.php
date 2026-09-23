<?php
// Update the path below to your autoload.php, 
// see https://getcomposer.org/doc/01-basic-usage.md 
require_once 'public/apis/Twilio/autoload.php'; 
 
use Twilio\Rest\Client; 


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Whatsapp_model extends CI_Model 
{
    function __construct() 
    {
      parent::__construct();
    }
 
 
   function send_whatsapp1($appointment_id = '35125115',$type= 'programar')
    {
        $whatsapp_status = $this->db->get_where('settings', array('type' => 'whatsapp_status'))->row()->description;
        
        if($whatsapp_status){
            
            $app = $this->db->get_where('appointment',array('appointment_id'=>$appointment_id))->row_array();
         
          $phone = '35125115';
                
                $d =  explode('/',$app['date']);
                setlocale(LC_TIME, 'es_ES.UTF-8');
                $nuevafecha = strftime('%A, %d de %B de %Y', strtotime($d[2].'-'.$d[1].'-'.$d[0])); // Formatea la fecha según el idioma y la región
                
                $msg = $this->db->get_where('settings', array('type' => 'msg_shedules'))->row()->description;
                $msg_val = array(
                        '[DOCTOR]' => $this->accounts_model->short_name('admin',$app['doctor_id']),
                        '[PACIENTE]' => $this->accounts_model->short_name('patient',$app['patient_id']),
                        '[HORA]' => date("h:i A", strtotime($app['time'])),
                        '[FECHA]' => $nuevafecha,
                        '[SERVICIO]' => $app['practice'] != 0?$this->db->get_where('service', array('service_id' =>$app['practice']))->row()->name:"Otros",
                        '[CLINICA]' => $this->db->get_where('clinic', array('clinic_id' =>$app['clinic_id']))->row()->name,
                        '[UBICACION]' => $this->db->get_where('clinic', array('clinic_id' =>$app['clinic_id']))->row()->address,
                        '[TELEFONO]' =>$this->db->get_where('clinic', array('clinic_id' =>$app['clinic_id']))->row()->phone,
                    );
                    
                    $msg = str_replace(array_keys($msg_val), array_values($msg_val), $msg);
                
                    $key = $this->db->get_where('settings', array('type' => 'msalerts_key'))->row()->description;
                    $token = $this->db->get_where('settings', array('type' => 'msalerts_token'))->row()->description;
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'http://chats.mayansource.com/sendMessage',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => 'api_key='.$key.'&messageType=1&token='.$token.'&phone=502'.$phone.'&chat='.urlencode($msg),
                    ));
                    $response = curl_exec($curl);
                    curl_close($curl);
                    $data = json_decode($response, true);
                    
                     
                     $data = array(
                        'phone' =>$phone,
                        'message' =>$msg,
                        'file' =>'',
                        'response' => $response,
                        'status' => $data['status'],
                        'user_type' => 'patient',
                        'user_id' => $app['patient_id']
                        );
                    
                    $this->db->insert('whatsapp_messages',$data);
                    
                     echo $response;   
                  
        }
      
    }
    
    
  function send_whatsapp($appointment_id,$type)
    {
        $whatsapp_status = $this->db->get_where('settings', array('type' => 'whatsapp_status'))->row()->description;
        
        if($whatsapp_status){
            
            $app = $this->db->get_where('appointment',array('appointment_id'=>$appointment_id))->row_array();
            
            if($type == 'programar')
            {
                $phone = $this->db->get_where('admin',array('admin_id'=>$app['doctor_id']))->row()->phone;
                
                $d =  explode('/',$app['date']);
                setlocale(LC_TIME, 'es_ES.UTF-8');
                $nuevafecha = strftime('%A, %d de %B de %Y', strtotime($d[2].'-'.$d[1].'-'.$d[0])); // Formatea la fecha según el idioma y la región
                
                $msg = $this->db->get_where('settings', array('type' => 'msg_shedules'))->row()->description;
                $msg_val = array(
                        '[DOCTOR]' => $this->accounts_model->short_name('admin',$app['doctor_id']),
                        '[PACIENTE]' => $this->accounts_model->short_name('patient',$app['patient_id']),
                        '[HORA]' => date("h:i A", strtotime($app['time'])),
                        '[FECHA]' => $nuevafecha,
                        '[SERVICIO]' => $app['practice'] != 0?$this->db->get_where('service', array('service_id' =>$app['practice']))->row()->name:"Otros",
                        '[CLINICA]' => $this->db->get_where('clinic', array('clinic_id' =>$app['clinic_id']))->row()->name,
                        '[UBICACION]' => $this->db->get_where('clinic', array('clinic_id' =>$app['clinic_id']))->row()->address,
                        '[TELEFONO]' =>$this->db->get_where('clinic', array('clinic_id' =>$app['clinic_id']))->row()->phone,
                    );
                    
                    $msg = str_replace(array_keys($msg_val), array_values($msg_val), $msg);
                
                    $key = $this->db->get_where('settings', array('type' => 'msalerts_key'))->row()->description;
                    $token = $this->db->get_where('settings', array('type' => 'msalerts_token'))->row()->description;
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'http://chats.mayansource.com/sendMessage',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => 'api_key='.$key.'&messageType=1&token='.$token.'&phone=502'.$phone.'&chat='.urlencode($msg),
                    ));
                    $response = curl_exec($curl);
                    curl_close($curl);
                    $data = json_decode($response, true);
                    
                      $data = array(
                        'phone' =>$phone,
                        'message' =>$msg,
                        'file' =>'',
                        'response' => $response,
                        'status' => $data['status'],
                        'user_type' => 'admin',
                        'user_id' => $app['doctor_id']
                        );
                    
                    $this->db->insert('whatsapp_messages',$data);
                    
                
                $phone = $this->db->get_where('patient',array('patient_id'=>$app['patient_id']))->row()->phone;
                $msg = $this->db->get_where('settings', array('type' => 'msg_shedules1'))->row()->description;
              
                $msg_val = array(
                        '[DOCTOR]' => $this->accounts_model->short_name('admin',$app['doctor_id']),
                        '[PACIENTE]' => $this->accounts_model->short_name('patient',$app['patient_id']),
                        '[HORA]' => date("h:i A", strtotime($app['time'])),
                        '[FECHA]' => $nuevafecha,
                        '[SERVICIO]' => $app['practice'] != 0 ? $this->db->get_where('service', array('service_id' =>$app['practice']))->row()->name:"Otros",
                        '[CLINICA]' => $this->db->get_where('clinic', array('clinic_id' =>$app['clinic_id']))->row()->name,
                        '[UBICACION]' => $this->db->get_where('clinic', array('clinic_id' =>$app['clinic_id']))->row()->address,
                        '[TELEFONO]' =>$this->db->get_where('clinic', array('clinic_id' =>$app['clinic_id']))->row()->phone,
                    );
                    
                    $msg = str_replace(array_keys($msg_val), array_values($msg_val), $msg);
                
                    $key = $this->db->get_where('settings', array('type' => 'msalerts_key'))->row()->description;
                    $token = $this->db->get_where('settings', array('type' => 'msalerts_token'))->row()->description;
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'http://chats.mayansource.com/sendMessage',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => 'api_key='.$key.'&messageType=1&token='.$token.'&phone=502'.$phone.'&chat='.urlencode($msg),
                    ));
                    $response = curl_exec($curl);
                    curl_close($curl);
                    $data = json_decode($response, true);
                    
                      $data = array(
                        'phone' =>$phone,
                        'message' =>$msg,
                        'file' =>'',
                        'response' => $response,
                        'status' => $data['status'],
                        'user_type' => 'patient',
                        'user_id' => $app['patient_id']
                        );
                    
                    $this->db->insert('whatsapp_messages',$data);
            
                    
            }
            
            
            if($type == 'recordatorio')
            {
                $key = $this->db->get_where('settings', array('type' => 'msalerts_key'))->row()->description;
                $token = $this->db->get_where('settings', array('type' => 'msalerts_token'))->row()->description;
                    
                $d =  explode('/',$app['date']);
                setlocale(LC_TIME, 'es_ES.UTF-8');
                $nuevafecha = strftime('%A, %d de %B de %Y', strtotime($d[2].'-'.$d[1].'-'.$d[0])); // Formatea la fecha según el idioma y la región
                
                $phone = $this->db->get_where('patient',array('patient_id'=>$app['patient_id']))->row()->phone;
                $msg = $this->db->get_where('settings', array('type' => 'msg_remember'))->row()->description;
              
                $msg_val = array(
                        '[DOCTOR]' => $this->accounts_model->short_name('admin',$app['doctor_id']),
                        '[PACIENTE]' => $this->accounts_model->short_name('patient',$app['patient_id']),
                        '[HORA]' => date("h:i A", strtotime($app['time'])),
                        '[FECHA]' => $nuevafecha,
                        '[SERVICIO]' => $app['practice'] != 0 ? $this->db->get_where('service', array('service_id' =>$app['practice']))->row()->name:"Otros",
                        '[CLINICA]' => $this->db->get_where('clinic', array('clinic_id' =>$app['clinic_id']))->row()->name,
                        '[UBICACION]' => $this->db->get_where('clinic', array('clinic_id' =>$app['clinic_id']))->row()->address,
                        '[TELEFONO]' =>$this->db->get_where('clinic', array('clinic_id' =>$app['clinic_id']))->row()->phone,
                    );
                    
                    $msg = str_replace(array_keys($msg_val), array_values($msg_val), $msg);
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'http://chats.mayansource.com/sendMessage',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => 'api_key='.$key.'&messageType=1&token='.$token.'&phone=502'.trim($phone).'&chat='.urlencode($msg),
                    ));
                    $response = curl_exec($curl);
                    curl_close($curl);
                    $data = json_decode($response, true);
                     $data = array(
                        'phone' =>trim($phone),
                        'message' =>$msg,
                        'file' =>'',
                        'response' => $response,
                        'status' => $data['status'],
                        'user_type' => 'patient',
                        'user_id' => $app['patient_id']
                        );
                    
                    $this->db->insert('whatsapp_messages',$data);
                 echo 'response '.$response.'<br>';   
                    
            }
            
            
        }
      
    }
    
    
 //mensaje de whatsapp para una cita confirmada.
    function submit_confirmation($param1, $param2)
    {
         $this->db->where('appointment_id', $param2);
        $arrs = $this->db->get('appointment')->result_array();
                  
                    foreach($arrs as $appointment)
                    {
                                       
                                       
                                    setlocale(LC_TIME, 'es_ES');  
                                    $número = $appointment['month'];  
                                    $fecha = DateTime::createFromFormat('!m', $número); 
                                    $mes = strftime("%B", $fecha->getTimestamp()); 
                                 
                                    $number = $this->db->get_where('patient', array('patient_id'=>$param1))->row()->phone;
                            
                             
                                    $sid    = "AC9dcbdd4676412f6d5f6c97407416ee37"; 
                                    $token  = "de84cac9c5e2a95ea38ef78125e2c212"; 
                                    $twilio = new Client($sid, $token); 
                                     
                                    $message = $twilio->messages 
                                                      ->create("whatsapp:+".$number, // to 
                                                               array( 
                                                                   "from" => "whatsapp:+14155238886",       
                                                                   "body" => 'Hola '. $this->db->get_where('patient', array('patient_id' => $appointment['patient_id']))->row()->first_name.', '.
                                                                             'tu cita a sido confirmada para el '.$appointment['day'].' de '. $mes. ' a las '.$appointment['time'].' horas, '.
                                                                              'para más información puedes comunicarte a nuestro número '.$this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->phone.' o al correo electónico '. 
                                                                              $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->email
                                                
                                                               ) 
                                                      ); 
                          
                   }
         
    }
    
    
     //mensaje de whatsapp para notificar una cita agendada.
        function submit_shedule($param1)
    {
         $this->db->where('appointment_id', $param1);
        $arrs = $this->db->get('appointment')->result_array();
                  
                    foreach($arrs as $appointment)
                    {
                                       
                                       
                                    setlocale(LC_TIME, 'es_ES');  
                                    $número = $appointment['month'];  
                                    $fecha = DateTime::createFromFormat('!m', $número); 
                                    $mes = strftime("%B", $fecha->getTimestamp()); 
                                 
                                    $number = $this->db->get_where('patient', array('patient_id'=>$appointment['patient_id']))->row()->phone;
                            
                             
                                    $sid    = "AC9dcbdd4676412f6d5f6c97407416ee37"; 
                                    $token  = "de84cac9c5e2a95ea38ef78125e2c212";  
                                    $twilio = new Client($sid, $token); 
                                     
                                    $message = $twilio->messages 
                                                      ->create("whatsapp:+".$number, // to 
                                                               array( 
                                                                "from" => "whatsapp:+14155238886",         
                                                                   "body" => 'Hola '. $this->db->get_where('patient', array('patient_id' => $appointment['patient_id']))->row()->first_name.', '.
                                                                             'tu cita a sido agendada para el '.$appointment['day'].' de '. $mes. ' a las '.$appointment['time'].' horas, '.
                                                                              'para más información puedes comunicarte a nuestro número '.$this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->phone.' o al correo electónico '. 
                                                                              $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->email
                                                
                                                               ) 
                                                      ); 
                          
                   }
         
    }
 


 //mensaje de whatsapp para una cita reprogramada.
        function submit_reshedule($param1)
    {
        $this->db->where('appointment_id', $param1);
        $arrs = $this->db->get('appointment')->result_array();
                  
                    foreach($arrs as $appointment)
                    {
                                       
                                       
                                    setlocale(LC_TIME, 'es_ES');  
                                    $número = $appointment['month'];  
                                    $fecha = DateTime::createFromFormat('!m', $número); 
                                    $mes = strftime("%B", $fecha->getTimestamp()); 
                                 
                                    $number = $this->db->get_where('patient', array('patient_id'=>$appointment['patient_id']))->row()->phone;
                            
                             
                                    $sid    = "AC9dcbdd4676412f6d5f6c97407416ee37"; 
                                    $token  = "de84cac9c5e2a95ea38ef78125e2c212"; 
                                    $twilio = new Client($sid, $token); 
                                     
                                    $message = $twilio->messages 
                                                      ->create("whatsapp:+".$number, // to 
                                                               array( 
                                                                   "from" => "whatsapp:+14155238886",    
                                                                   "body" => 'Hola '. $this->db->get_where('patient', array('patient_id' => $appointment['patient_id']))->row()->first_name.', '.
                                                                             'tu cita a sido reprogramada para el '.$appointment['day'].' de '. $mes. ' a las '.$appointment['time'].' horas, '.
                                                                              'para más información puedes comunicarte a nuestro número '.$this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->phone.' o al correo electónico '. 
                                                                              $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->email
                                                
                                                               ) 
                                                      ); 
                          
                   }
         
    }
    

     //mensaje de whatsapp con accesos.
     function submit_credentials($name, $phone, $user, $pass)
     {
                   
            $sid    = "AC9dcbdd4676412f6d5f6c97407416ee37"; 
            $token  = "de84cac9c5e2a95ea38ef78125e2c212"; 
            $twilio = new Client($sid, $token); 
            
            $message = $twilio->messages 
                            ->create("whatsapp:+".$phone, // to 
                                    array( 
                                        "from" => "whatsapp:+14155238886",    
                                        "body" => 'Hola '. $name.', tu cuenta a sido creada con exito puedes acceder con los siguientes datos Usuario: *'.$user.'* Contraseña: *'.$pass.
                                                  '* en '.base_url(). ' Para más información puedes comunicarte a nuestro número '.$this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->phone.' o al correo electrónico '. 
                                                    $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->email                   
                                    ) 
                            ); 
                           
                    
          
     }

    function submit_medical_prescription($param1)
    {
        
     
        $number = $this->db->get_where('patient', array('patient_id'=>$param1))->row()->phone;

 
         $sid    = "AC9dcbdd4676412f6d5f6c97407416ee37"; 
       $token  = "de84cac9c5e2a95ea38ef78125e2c212"; 
        $twilio = new Client($sid, $token); 
         
        $message = $twilio->messages 
                          ->create("whatsapp:+".$number, // to 
                                   array( 
                                       "from" => "whatsapp:+14155238886",    
                                       "body" => "Tu cita a finalizado, a continuacion encontraras tu receta medica preescrita por el Doctor en turno.",
                                       "MediaUrl" => "http://www.africau.edu/images/default/sample.pdf"
                                   ) 
                          ); 
         
    }

 
 
 
 
 
    
}