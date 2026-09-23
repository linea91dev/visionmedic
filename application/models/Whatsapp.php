<?php
// Update the path below to your autoload.php, 
// see https://getcomposer.org/doc/01-basic-usage.md 
require_once 'public/apis/Twilio/autoload.php'; 
 
use Twilio\Rest\Client; 


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Whatsapp extends CI_Model 
{
    function __construct() 
    {
      parent::__construct();
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