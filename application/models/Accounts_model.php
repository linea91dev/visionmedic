<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Accounts_model extends CI_Model 
{
    function __construct() 
    {
      parent::__construct();
    }

    function clear_cache() 
    {
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }
    
  
    
    function get_profession($id_){
        if($this->session->userdata('login_type') == 'doctor'){
            if($this->db->get_where('admin', array('admin_id' => $id_))->row()->gender == 'F'){
                return 'Doctora';
            }else{
                return 'Doctor';
            }
        }else
        {
            return $this->db->get_where('staff', array('staff_id' => $id_))->row()->charge;
        }
    }

    function formatDate()
    {
        $dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        return date('d')." de ".$meses[date('n')-1]." ".date('H:i A');
    }
    
    function delete_patient($patient_id)
    {
        
        /*
        $this->db->where('patient_id', $patient_id); 
        $photo = $this->db->get('patient')->row()->photo;
        
        unlink("public/uploads/patient_image/".$photo);
        
        $this->db->where('patient_id', $patient_id);
        $this->db->delete('gyneco_obstetrics');
        
         $this->db->where('patient_id', $patient_id);
        $this->db->delete('cetosis_history');
        
        $this->db->where('patient_id', $patient_id);
        $this->db->delete('cart');
        
        $this->db->where('patient_id', $patient_id);
        $this->db->delete('appointment');
        
        $this->db->where('patient_id', $patient_id);
        $this->db->delete('allergie');
        
        $this->db->where('patient_id', $patient_id);
        $this->db->delete('nutritional_history');
        
        $this->db->where('patient_id', $patient_id);
        $this->db->delete('nutriological');
        
        $this->db->where('patient_id', $patient_id);
        $this->db->delete('no_pathological');
        
        $this->db->where('patient_id', $patient_id);
        $this->db->delete('laboratory_result');
        
        $this->db->where('patient_id', $patient_id);
        $this->db->delete('medication_history');
        
        $this->db->where('patient_id', $patient_id);
        $this->db->delete('vaccination');
        
        $this->db->where('patient_id', $patient_id);
        $this->db->delete('psychiatric');
        
        $this->db->where('patient_id', $patient_id);
        $this->db->delete('record_family');
        
        $this->db->where('patient_id', $patient_id);
        $this->db->delete('vital_sign');
        
       
        
        $this->db->where('patient_id', $patient_id);
        $info = $this->db->get('patient_file')->result_array();
        
        foreach ($info as $patients){
        
        unlink("public/uploads/patient_files/".$patients['name']);
        
        
            }
            


        $this->db->where('patient_id', $patient_id);
        $this->db->delete('patient_file');
        
        $this->db->where('patient_id', $patient_id);
        $this->db->delete('patient');

        */
        
        $data['status']     =   0;
        $this->db->where('patient_id', $patient_id);
        $this->db->update('patient', $data);
        
    }
    
    function delete_staff($staff_id)
    {
        $this->log_model->delete_staff($staff_id);
        $data['status']     =   0;
        $this->db->where('staff_id',$staff_id);
        return $this->db->update('staff', $data);
    }
       
    function delete_doctor($admin_id)
    {
        
        $this->db->where('admin_id', $admin_id); 
        $photo = $this->db->get('admin')->row()->photo;
    
        
        $this->db->where('admin_id', $admin_id); 
        $signature = $this->db->get('admin')->row()->signature;
        
        $data['status']  =  0;
        $this->db->where('admin_id', $admin_id);
        $this->db->update('admin',$data);
    }
    
    function UR_exists($url)
    {
            $headers=get_headers($url);
            return stripos($headers[0],"200 OK")?true:false;
    }
    
    function create_patient()
    {
       include('public/apis/class.fileuploader.php');
       $md5 = md5(date('d-m-Y H:i:s'));
        $FileUploader_photo = new FileUploader('photo', array('uploadDir' => 'public/uploads/patient_image/'));
    	$upload_photo = $FileUploader_photo->upload();
    	if($upload_photo['isSuccess']) {
        	$files = $upload_photo['files'];
    	} else {
        	$warningss = $upload_photo['warnings'];
    	}
        
        if($_FILES['photo']['name'] != "")
        {
         $data['photo']        = $upload_photo['files'][0]['name'];
            
        }
        
        
        $password              = $this->getPassword();
        $data['first_name']    = $this->input->post('first_name');
        $data['second_name']     = $this->input->post('second_name'); 
        $data['third_name']     = $this->input->post('third_name'); 
        $data['last_name']     = $this->input->post('last_name');
        $data['username']      = $this->getUsername(strtolower($this->normalizeText($this->input->post('first_name')." ".$this->input->post('last_name'))));   
        $data['password']      = sha1($password);
        $data['second_last_name']     = $this->input->post('second_last_name'); 
        $data['married_last_name']     = $this->input->post('married_last_name'); 
        $data['dpi']         = $this->input->post('dpi'); 
        $data['phone']         = $this->input->post('phone');
        $data['whatsapp_status']         = $this->input->post('whatsapp_status');
        $data['phone_contact']         = $this->input->post('phone_contact');
        $data['email']         = $this->input->post('email');  
        $data['email_status']         = $this->input->post('email_status');
        $data['blood']         = $this->input->post('blood');    
        $data['date_of_birth'] = $this->input->post('date_of_birth');    
        $data['profession']    = $this->input->post('profession');    
        $data['status']        = 1;    
        $data['gender']        = $this->input->post('gender');  
        $data['dpi']        = $this->input->post('dpi');  
        $data['address']       = $this->input->post('address');    
        $data['clinic_id']     = $this->session->userdata('current_clinic');
        $data['date']        = $this->crud_model->formatDate();    
        $this->db->insert('patient', $data);
        move_uploaded_file($_FILES['photo']['tmp_name'], 'public/uploads/patient_image/' . $md5.str_replace(' ', '', $_FILES['photo']['name']));
        $patient_id = $this->db->insert_id();
        $this->log_model->new_patient($patient_id);
        
        if($this->input->post('email')!="")
        {

            require("public/apis/class.phpmailer.php");
            $mail = new PHPMailer(); 
            $mail->IsHTML(true);
            $mail->IsMail();
            $mail->CharSet = 'UTF-8';
            $mail->SetFrom('usuarios@medicaby.com', 'Notificaciones Medicaby');
            $mail->Subject = "Cuenta creada";
            $data_email = array(
                'email_msg' => "¡Hola ".str_replace(' ', '',$this->input->post('first_name'))."! Recibes esta notificación porque se ha creado una nueva cuenta de usuario en <b>".$this->system_name()."</b>, tus datos son los siguientes: <br><br><b>Usuario: </b>".$data['username']."<br><b>Contraseña:</b> ".$password."<br> Para iniciar sesión haz click aquí: ".base_url().'/login'
            );
            $mail->Body = $this->load->view('backend/mails/credentials.php',$data_email,TRUE);
            $mail->AddAddress($this->input->post('email'));
            if(!$mail->Send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            }

        }
      
        if($this->input->post('whatsapp_status') == 1)
        {
            //$this->whatsapp->submit_credentials($data['first_name'],$data['phone'] ,$data['username'] ,$password);
        }
        
    }
    
    function update_patient($patient_id)
    {
        $md5 = md5(date('d-m-Y H:i:s'));
       include('public/apis/class.fileuploader.php');
        $FileUploader_photo = new FileUploader('photo', array(
        	'uploadDir' => 'public/uploads/patient_image/'));
        $upload_photo = $FileUploader_photo->upload();
        if($upload_photo['isSuccess']) {
            $files = $upload_photo['files'];
        } else {
            $warningss = $upload_photo['warnings'];
        }
        
        if(!empty($upload_photo['files']))
        {
            $data['photo']         = $upload_photo['files'][0]['name'];
        }
        $data['first_name']    = $this->input->post('first_name');
        $data['second_name']     = $this->input->post('second_name'); 
        $data['third_name']     = $this->input->post('third_name'); 
        $data['last_name']     = $this->input->post('last_name');
        $data['second_last_name']     = $this->input->post('second_last_name'); 
        $data['married_last_name']     = $this->input->post('married_last_name');   
        $data['phone']         = $this->input->post('phone');
        $data['whatsapp_status']         = $this->input->post('whatsapp_status');
        $data['phone_contact']         = $this->input->post('phone_contact');
        $data['email']         = $this->input->post('email');  
        $data['email_status']         = $this->input->post('email_status');   
        $data['blood']         = $this->input->post('blood');    
        $data['date_of_birth'] = $this->input->post('date_of_birth');    
        $data['profession']    = $this->input->post('profession');    
           
        $data['gender']        = $this->input->post('gender');    
        $data['address']       = $this->input->post('address');  
        
        $data['father_name']    = $this->input->post('father_name');    
        $data['father_lastname']        = $this->input->post('father_lastname');    
        $data['father_phone']        = $this->input->post('father_phone');    
        $data['father_ocupation']       = $this->input->post('father_ocupation');  

        $data['mother_name']    = $this->input->post('mother_name');    
        $data['mother_lastname']        = $this->input->post('mother_lastname');    
        $data['mother_phone']        = $this->input->post('mother_phone');    
        $data['mother_ocupation']       = $this->input->post('mother_ocupation');  

        $data['tutor_name']    = $this->input->post('tutor_name');    
        $data['tutor_lastname']        = $this->input->post('tutor_lastname');    
        $data['tutor_phone']        = $this->input->post('tutor_phone');    
        $data['tutor_ocupation']       = $this->input->post('tutor_ocupation');  

        $this->db->where('patient_id',$patient_id);
        $this->db->update('patient', $data);
        move_uploaded_file($_FILES['photo']['tmp_name'], 'public/uploads/patient_image/' . $md5.str_replace(' ', '', $_FILES['photo']['name']));
        
    }
        
    
    function normalizeText($string) 
    {
    	$table = array(
        'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
        'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
        'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
        'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r',
    	);
    	return strtr($string, $table);
	}
	
    function getPassword()
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password = substr(str_shuffle($chars),0,8);
        return strtoupper($password);
    }
    
    function gender($id_)
    {
        if($this->db->get_where('admin', array('admin_id' => $id_))->row()->gender == 'F'){
            return 'Dra.';
        }else{
            return 'Dr.';
        }
    }
    
    function create_staff()
    {
       include('public/apis/class.fileuploader.php');
        
        $FileUploader_photo = new FileUploader('photo', array('uploadDir' => 'public/uploads/staff_image/'));
    	$upload_photo = $FileUploader_photo->upload();
    	if($upload_photo['isSuccess']) {
        	$files = $upload_photo['files'];
    	} else {
        	$warningss = $upload_photo['warnings'];
    	}
        
        if($upload_photo['files'][0]['name'] != "")
        {
            $data['photo']        = $upload_photo['files'][0]['name'];
        }
        $password = $this->getPassword();
        if($this->input->post('Facebook') == '1')
        {
            $data['facebook']      = $this->input->post('link_facebook');
        }
        
        $data['whatsapp']      = $this->input->post('Whatsapp');
        
        if($this->input->post('Instagram') == '1')
        {
            $data['instagram']     = $this->input->post('link_instagram');
        }
        $data['first_name']    = $this->input->post('first_name');
        $data['second_name']     = $this->input->post('second_name'); 
        $data['third_name']     = $this->input->post('third_name'); 
        $data['last_name']     = $this->input->post('last_name');
        $data['second_last_name']     = $this->input->post('second_last_name'); 
        $data['married_last_name']     = $this->input->post('married_last_name'); 
        $data['dpi']         = $this->input->post('dpi'); 
        $data['phone']         = $this->input->post('phone');    
        $data['email']         = $this->input->post('email');    
        $data['password']      = sha1($password);
        $data['date_of_birth'] = $this->input->post('date_of_birth');    
        $data['username']      = $this->getUsername(strtolower($this->normalizeText($this->input->post('first_name')." ".$this->input->post('last_name'))));    
        $data['status']        = 1;   
        $data['account']       = 1;
        $data['gender']        = $this->input->post('gender');
        $data['salary']        = $this->input->post('salary'); 
        $data['charge']        = $this->input->post('charge'); 


        $moduls = $this->db->get_where('staff',array('staff_id'=>$this->session->userdata('login_user_id')) )->row()->moduls;
        if($moduls == 1)
        ///---------Permisos de la navbar---------- //
        $moduls = $this->db->get_where('staff',array('staff_id'=>$this->session->userdata('login_user_id')) )->row()->moduls;
        if($moduls == 1)
        {
            $data['moduls']         = $this->input->post('moduls');
            $data['panel']          = 1;
            $data['chat']           = $this->input->post('chat');
            $data['appointments']   = $this->input->post('appointments');
            $data['patients']       = $this->input->post('patients');
            $data['doctors']        = $this->input->post('doctors');
            $data['staff']          = $this->input->post('staff');
            $data['inventory']      = $this->input->post('inventory');
            $data['financial']      = $this->input->post('financial');
            $data['reports']        = $this->input->post('reports');
            $data['settings']       = $this->input->post('settings');
        }else
        {
            $data['moduls']         = 0;
            $data['panel']          = 1;
            $data['chat']           = 1;
            $data['appointments']   = 1;
            $data['patients']       = 1;
            $data['doctors']        = 1;
            $data['staff']          = 1;
            $data['inventory']      = 0;
            $data['financial']      = 0;
            $data['reports']        = 0;
            $data['settings']       = 0;


        }


        $data['since']          = $this->formatDate();   
        $data['address']        = $this->input->post('address');
        
        $data['clinic_id']      = $this->session->userdata('current_clinic');
        $this->db->insert('staff', $data);
        $staff_id = $this->db->insert_id();
        $this->log_model->create_staff($staff_id);
        //-- Enviando correo de bienvenida
        require("public/apis/class.phpmailer.php");
        $mail = new PHPMailer(); 
        $mail->IsHTML(true);
        $mail->IsMail();
        $mail->CharSet = 'UTF-8';
        $mail->SetFrom('usuarios@medicaby.com', 'Notificaciones Medicaby');
        $mail->Subject = "Nueva cuenta registrada";
        $data_email = array(
            'email_msg' => "¡Hola ".str_replace(' ', '',$this->input->post('first_name'))."! Recibes esta notificación porque se ha creado una nueva cuenta de usuario en <b>".$this->system_name()."</b>, tus datos son los siguientes: <br><br><b>Usuario: </b>".$data['username']."<br><b>Contraseña:</b> ".$password."<br> Para iniciar sesión haz click aquí: ".base_url()
        );
        $mail->Body = $this->load->view('backend/mails/credentials.php',$data_email,TRUE);
        $mail->AddAddress($this->input->post('email'));
        if(!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }

        //$this->whatsapp->submit_credentials($data['first_name'],$data['phone'] ,$data['username'] ,$password);
        
        
    }
    
    function system_name()
    {
        return $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->name;
        
    }

    function system_email()
    {
        return $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->email;
        
    }
    
    
    function update_staff($staff_id)
    {
        
        $this->log_model->update_staff($staff_id);
       include('public/apis/class.fileuploader.php');
        $FileUploader_photo = new FileUploader('photo', array(
        	'uploadDir' => 'public/uploads/staff_image/'));
        $upload_photo = $FileUploader_photo->upload();
        if($upload_photo['isSuccess']) {
            $files = $upload_photo['files'];
        } else {
            $warningss = $upload_photo['warnings'];
        }
        
        if($upload_photo['files'][0]['name'] != "")
        {
            $data['photo']         = $upload_photo['files'][0]['name'];
        }
            
        if($this->input->post('Facebook') == '1')
        {
            $data['facebook']      = $this->input->post('link_facebook');
        }else{
            $data['facebook']     = '';
        }
        
        $data['whatsapp']      = $this->input->post('Whatsapp');
        
        if($this->input->post('Instagram') == '1')
        {
            $data['instagram']     = $this->input->post('link_instagram');
        }else{
            $data['instagram']     = '';
        }
        $data['first_name']    = $this->input->post('first_name'); 
        $data['second_name']     = $this->input->post('second_name'); 
        $data['third_name']     = $this->input->post('third_name'); 
        $data['last_name']     = $this->input->post('last_name');
        $data['second_last_name']     = $this->input->post('second_last_name'); 
        $data['married_last_name']     = $this->input->post('married_last_name'); 
        $data['dpi']         = $this->input->post('dpi'); 
        $data['phone']         = $this->input->post('phone');    
        $data['email']         = $this->input->post('email');    
        $data['date_of_birth'] = $this->input->post('date_of_birth');    
        $data['account']       = 1;
        $data['gender']        = $this->input->post('gender');    
        $data['address']       = $this->input->post('address');
        $data['salary']        = $this->input->post('salary'); 
        $data['address']        = $this->input->post('address');
        $data['since']          = $this->formatDate();   
        $data['charge']        = $this->input->post('charge'); 
        $data['clinic_id']      = $this->session->userdata('current_clinic');
        $this->db->where('staff_id',$staff_id);
        $this->db->update('staff', $data);
        move_uploaded_file($_FILES['photo']['tmp_name'], 'public/uploads/staff_image/' . $md5.str_replace(' ', '', $_FILES['photo']['name']));
    }
    
    
    function update_staff_modules($staff_id)
    {
        ///---------Permisos de la navbar---------- //
        $data['moduls']         = $this->input->post('moduls');
        $data['panel']          = 1;
        $data['chat']           = $this->input->post('chat');
        $data['appointments']   = 1;
        $data['patients']       = $this->input->post('patients');
        $data['doctors']        = $this->input->post('doctors');
        $data['staff']          = $this->input->post('staff');
        $data['inventory']      = $this->input->post('inventory');
        $data['financial']      = $this->input->post('financial');
        $data['reports']        = $this->input->post('reports');
        $data['settings']       = $this->input->post('settings');
        $data['clinic_id']      = $this->session->userdata('current_clinic');
        $this->db->where('staff_id',$staff_id);
        $this->db->update('staff', $data);
    }
    
    function create_doctor()
    {
        include('public/apis/class.fileuploader.php');
        
        $FileUploader_signature = new FileUploader('signature', array('uploadDir' => 'public/uploads/doctor_signature/'));
        $upload_signature = $FileUploader_signature->upload();
        if($upload_signature['isSuccess'])
        {$files = $upload_signature['files'];}
        else {$warnings = $upload_signature['warnings'];}
        
        $FileUploader_photo = new FileUploader('photo', array('uploadDir' => 'public/uploads/doctor_image/'));
    	$upload_photo = $FileUploader_photo->upload();
    	if($upload_photo['isSuccess']) {
        	$files = $upload_photo['files'];
    	} else {
        	$warningss = $upload_photo['warnings'];
    	}
        
        if($upload_photo['files'][0]['name'] != "")
        {   $data['photo']             = $upload_photo['files'][0]['name'];}
        if($upload_signature['files'][0]['name'] != "")
        {   $data['signature']         = $upload_signature['files'][0]['name'];}
        $password                   = $this->getPassword();
        $data['first_name']         = $this->input->post('first_name');    
        $data['second_name']        = $this->input->post('second_name');    
        $data['third_name']         = $this->input->post('third_name');    
        $data['last_name']          = $this->input->post('last_name');
        $data['second_last_name']   = $this->input->post('second_last_name');
        $data['married_last_name']  = $this->input->post('married_last_name');
        $data['dpi']                = $this->input->post('dpi'); 
        $data['phone']              = $this->input->post('phone');    
        $data['email']              = $this->input->post('email');    
        $data['password']           = sha1($password);
        $data['date_of_birth']      = $this->input->post('date_of_birth');    
        $data['username']           = $this->getUsername(strtolower($this->normalizeText($this->input->post('first_name')." ".$this->input->post('last_name'))));    
        $data['status']             = 1;    
        $data['salary']             = $this->input->post('salary');    
        $data['gender']             = $this->input->post('gender');    
        $data['specialty_1']        = $this->input->post('specialty_1');   
        $data['specialty_2']        = $this->input->post('specialty_2');   
        $data['address']            = $this->input->post('address');    
        $data['no_college']         = $this->input->post('no_college');   
        
        if($this->input->post('owner') == 1)
        {
         ///---------Permisos de la navbar---------- //
            $data['owner']              = $this->input->post('owner');
            $data['appointments']       = 1;
            $data['moduls']             = $this->input->post('moduls');
            $data['chat']               = $this->input->post('chat');
            $data['patients']           = $this->input->post('patients');
            $data['doctors']            = $this->input->post('doctors');
            $data['staff']              = $this->input->post('staff');
            $data['inventory']          = $this->input->post('inventory');
            $data['financial']          = $this->input->post('financial');
            $data['reports']            = $this->input->post('reports');
            $data['settings']           = $this->input->post('settings');
        }
        
        else{
            ///---------Permisos de la navbar---------- //
            $data['appointments']           = 1;
            $data['owner']              = 0;
            $data['moduls']             = 0;
            $data['chat']               = 1;
            $data['patients']           = 1;
            $data['doctors']            = 1;
            $data['staff']              = 1;
            $data['inventory']          = 0;
            $data['financial']          = 0;
            $data['reports']            = 0;
            $data['settings']           = 0;

        }

        
        $data['clinic_id']     = $this->session->userdata('current_clinic');
        if($this->input->post('Facebook') == '1')
        {
            $data['facebook']      = $this->input->post('link_facebook');
        }
        
        $data['whatsapp']      = $this->input->post('Whatsapp');
        
        if($this->input->post('Instagram') == '1')
        {
            $data['instagram']     = $this->input->post('link_instagram');
        }
        $this->db->insert('admin', $data);
        $doctor_id = $this->db->insert_id();
        $this->log_model->create_doctor($doctor_id);
        
        
        if($this->input->post('email')!="")
        {

            require("public/apis/class.phpmailer.php");
            $mail = new PHPMailer(); 
            $mail->IsHTML(true);
            $mail->IsMail();
            $mail->CharSet = 'UTF-8';
            $mail->SetFrom('no-reply@medicaby.com', 'Notificaciones Medicaby');
            $mail->Subject = "Cuenta creada";
            $data_email = array(
                'email_msg' => "¡Hola ".str_replace(' ', '',$this->input->post('first_name'))."! Recibes esta notificación porque se ha creado una nueva cuenta de usuario en <b>".$this->system_name()."</b>, tus datos son los siguientes: <br><br><b>Usuario: </b>".$data['username']."<br><b>Contraseña:</b> ".$password."<br> Para iniciar sesión haz click aquí: ".base_url().'/login'
            );
            $mail->Body = $this->load->view('backend/mails/credentials.php',$data_email,TRUE);
            $mail->AddAddress($this->input->post('email'));
            if(!$mail->Send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            }
        }
    }
    
    
    function diary ()
    {
        require("public/apis/class.phpmailer.php");
        $mail = new PHPMailer();
        $this->db->where('date', date('d/m/Y'));
        $this->db->where('status', 0);
        $this->db->or_where('status', 1);
        $this->db->or_where('status', 2);
        
        
        $this->db->group_by('doctor_id');
        $appointments = $this->db->get('appointment')->result_array();
        
        foreach($appointments as $appointment){
            
          
            $doctors = $this->db->get_where('admin', array( 'admin_id' => $appointment['doctor_id']))->row()->email;
            $name = $this->db->get_where('admin', array( 'admin_id' => $appointment['doctor_id']))->row()->first_name;
      
                  
                    $mail->IsHTML(true);
                    $mail->IsMail();
                    $mail->CharSet = 'UTF-8';
                    $mail->SetFrom('notificaciones@medicaby.com', 'Notificaciones Medicaby');
                    $mail->Subject = "Agenda de hoy";
                    $data_email = array(
                        'email_msg' => "¡Buenos dias ".$name."! Estas la agenda para el dia de hoy <b>".date('d/m/Y')."</b>",
                        'doctor_id' => $appointment['doctor_id']
                    );
                    $mail->Body = $this->load->view('backend/mails/diary.php',$data_email,TRUE);
                    $mail->AddAddress($doctors);
                    if(!$mail->Send()) {
                        echo "Mailer Error: " . $mail->ErrorInfo." ".$doctors;
                    }
                    
                    $mail->ClearAllRecipients();
               
                
                 echo $doctors."<br>";
        }
        
    }
    
        
    function solicite_data()
    {
        require("public/apis/class.phpmailer.php");
        
       if($this->input->post('password') != ""){
                $data['password']     = sha1($this->input->post('password'));
            }
        
        $mail = new PHPMailer();
        $this->db->or_where('status', 1);
        $this->db->or_where('clinic_id',  $this->session->userdata('current_clinic'));
        $clinic = $this->db->get('clinic')->result_array();
        

            $mail->IsHTML(true);
            $mail->IsMail();
            $mail->CharSet = 'UTF-8';
            $mail->SetFrom('usuarios@medicaby.com', 'Notificaciones de medicaby');
            $mail->Subject = "Solicitud de información medicaby";
            $data_email = array(
                'email_msg' => "¡Buenos días! Solicitud de la información de".$this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->name.", solicitada el <b>".date('d/m/Y')."</b>",
                'mod_appointments' => $this->input->post('mod_appointments'),  
                'mod_patients' => $this->input->post('mod_patients'),
                'mod_doctors' => $this->input->post('mod_doctors'),
                'mod_staff' => $this->input->post('mod_staff'),
                'mod_ingresos' => $this->input->post('mod_ingresos'),
                'mod_egresos' => $this->input->post('mod_egresos'),
                            );
            $mail->Body = $this->load->view('backend/mails/info.php',$data_email,TRUE);
            $mail->AddAddress('atezo@mayansource.com');
            
            if($mail->Send()) {
                

                
                
            }else
            {
                echo "Mailer Error: " . $mail->ErrorInfo." ".$doctors;
            }
            
            $mail->ClearAllRecipients();
       
        
         echo "<br>";
        
        
    }
    
    function update_doctor($admin_id)
    {
       include('public/apis/class.fileuploader.php');
        $this->log_model->update_doctor($admin_id);
    	$FileUploader_signature = new FileUploader('signature', array(
    		'uploadDir' => 'public/uploads/doctor_signature/'));
    	$upload_signature = $FileUploader_signature->upload();
    	if($upload_signature['isSuccess']) {
        	$files = $upload_signature['files'];
    	} else {
        	$warnings = $upload_signature['warnings'];
    	}
    	
    	
    	$FileUploader_photo = new FileUploader('photo', array(
    		'uploadDir' => 'public/uploads/doctor_image/'));
    	$upload_photo = $FileUploader_photo->upload();
    	if($upload_photo['isSuccess']) {
        	$files = $upload_photo['files'];
    	} else {
        	$warningss = $upload_photo['warnings'];
    	}
    
        if($upload_photo['files'][0]['name'] != "")
        {
            $data['photo']         = $upload_photo['files'][0]['name'];
        }
        
        if($upload_signature['files'][0]['name'] != "")
        {
            $data['signature']     = $upload_signature['files'][0]['name'];
        }
            
        $data['first_name']    = $this->input->post('first_name');    
        $data['second_name']     = $this->input->post('second_name'); 
        $data['third_name']     = $this->input->post('third_name'); 
        $data['last_name']     = $this->input->post('last_name'); 
        $data['second_last_name']     = $this->input->post('second_last_name'); 
        $data['married_last_name']     = $this->input->post('married_last_name'); 
        $data['dpi']         = $this->input->post('dpi'); 
        $data['phone']         = $this->input->post('phone');    
        $data['email']         = $this->input->post('email');    
        $data['date_of_birth'] = $this->input->post('date_of_birth');    
        $data['owner']         = $this->input->post('owner');
        $data['gender']        = $this->input->post('gender');    
        $data['specialty_1']   = $this->input->post('specialty_1');   
        $data['specialty_2']   = $this->input->post('specialty_2');
        //$data['username']      = $this->input->post('username');    
        $data['address']       = $this->input->post('address');    
        $data['no_college']    = $this->input->post('no_college'); 
        $data['salary']        = $this->input->post('salary'); 
        
        if($this->input->post('Facebook') == '1')
        {
            $data['facebook']      = $this->input->post('link_facebook');
        }
        else
        {
            $data['facebook']      = '';
        }
        
        $data['whatsapp']      = $this->input->post('Whatsapp');
        
        if($this->input->post('Instagram') == '1')
        {
            $data['instagram']     = $this->input->post('link_instagram');
        }
        else
        {
            $data['instagram']      = '';
        }
        $this->db->where('admin_id',$admin_id);
        $this->db->update('admin', $data);
        move_uploaded_file($_FILES['photo']['tmp_name'], 'public/uploads/doctor_image/' . $md5.str_replace(' ', '', $_FILES['photo']['name']));
        move_uploaded_file($_FILES['photo']['tmp_name'], 'public/uploads/doctor_signature/' . $md5.str_replace(' ', '', $_FILES['signature']['name']));

    }
    
    
    function update_doctor_profile($admin_id)
    {
        $md5 = md5(date('d-m-Y H:i:s'));
       include('public/apis/class.fileuploader.php');
        $this->log_model->update_doctor($admin_id);
    	$FileUploader_signature = new FileUploader('signature', array(
    		'uploadDir' => 'public/uploads/doctor_signature/'));
    	$upload_signature = $FileUploader_signature->upload();
    	if($upload_signature['isSuccess']) {
        	$files = $upload_signature['files'];
    	} else {
        	$warnings = $upload_signature['warnings'];
    	}
    	
    	
    	$FileUploader_photo = new FileUploader('photo', array(
    		'uploadDir' => 'public/uploads/doctor_image/'));
    	$upload_photo = $FileUploader_photo->upload();
    	if($upload_photo['isSuccess']) {
        	$files = $upload_photo['files'];
    	} else {
        	$warningss = $upload_photo['warnings'];
    	}
    
        if(!empty($upload_photo['files']))
        {
            $data['photo']         = $upload_photo['files'][0]['name'];
        }
        
        if(!empty($upload_signature['files']))
        {
            $data['signature']     = $upload_signature['files'][0]['name'];
        }
            
        $data['first_name']    = $this->input->post('first_name');    
        $data['second_name']     = $this->input->post('second_name'); 
        $data['third_name']     = $this->input->post('third_name'); 
        $data['last_name']     = $this->input->post('last_name'); 
        $data['second_last_name']     = $this->input->post('second_last_name'); 
        $data['married_last_name']     = $this->input->post('married_last_name'); 
        $data['dpi']         = $this->input->post('dpi'); 
        $data['phone']         = $this->input->post('phone');    
        $data['email']         = $this->input->post('email');    
        $data['date_of_birth'] = $this->input->post('date_of_birth');    
        if($this->crud_model->account_owner() == 1){
            $data['owner']         = $this->input->post('owner');    
        }
        $data['gender']        = $this->input->post('gender');    
        $data['specialty_1']   = $this->input->post('specialty_1');   
        $data['specialty_2']   = $this->input->post('specialty_2');
        $data['address']       = $this->input->post('address');    
        $data['no_college']    = $this->input->post('no_college'); 
        if($this->input->post('Facebook') == '1')
        {
            $data['facebook']      = $this->input->post('link_facebook');
        }
        else
        {
            $data['facebook']      = '';
        }
        
        $data['whatsapp']      = $this->input->post('Whatsapp');
        
        if($this->input->post('Instagram') == '1')
        {
            $data['instagram']     = $this->input->post('link_instagram');
        }
        else
        {
            $data['instagram']      = '';
        }
        $this->db->where('admin_id',$admin_id);
        $this->db->update('admin', $data);
        move_uploaded_file($_FILES['photo']['tmp_name'], 'public/uploads/doctor_image/' . $md5.str_replace(' ', '', $_FILES['photo']['name']));
        move_uploaded_file($_FILES['photo']['tmp_name'], 'public/uploads/doctor_signature/' . $md5.str_replace(' ', '', $_FILES['signature']['name']));

    }
    
    function update_doctor_modules($admin_id)
    {
         ///---------Permisos de la navbar---------- //
        $data['moduls']         = $this->input->post('moduls');
        $data['panel']          = $this->input->post('panel');
        $data['chat']           = $this->input->post('chat');
        $data['appointments']   = 1;
        $data['patients']       = $this->input->post('patients');
        $data['doctors']        = $this->input->post('doctors');
        $data['staff']          = $this->input->post('staff');
        $data['inventory']      = $this->input->post('inventory');
        $data['financial']      = $this->input->post('financial');
        $data['reports']        = $this->input->post('reports');
        $data['settings']       = $this->input->post('settings');
        $this->db->where('admin_id',$admin_id);
        $this->db->update('admin', $data);
    }
    
    function update_doctor_pass($admin_id)
    {
        
        if($this->input->post('new_pass') == $this->input->post('confirm_pass')){
            $data['password']     = sha1($this->input->post('new_pass'));
            $this->db->where('admin_id',$admin_id);
            $this->db->update('admin', $data);   
            $this->session->set_flashdata('flash_message' , "Contraseña actualizada correctamente.");
            redirect(base_url() . 'doctor/my_security/', 'refresh');   
        }else{
            $this->session->set_flashdata('flash_message' , "Hubo un error al actualizar la contraseña.");
            redirect(base_url() . 'doctor/my_security/', 'refresh');
        }
    }
    
    function update_doctor_pass_profile($admin_id)
    {
        if($this->input->post('new_pass') == $this->input->post('confirm_pass')){
            $data['password']     = sha1($this->input->post('new_pass'));
            $this->db->where('admin_id',$admin_id);
            $this->db->update('admin', $data);   
            $this->session->set_flashdata('flash_message' , "Contraseña actualizada correctamente.");
            redirect(base_url() . 'doctor/doctor_security/'.base64_encode($admin_id), 'refresh');   
        }else{
            $this->session->set_flashdata('flash_message' , "Hubo un error al actualizar la contraseña.");
            redirect(base_url() . 'doctor/doctor_security/'.base64_encode($admin_id), 'refresh');
        }
    }
    
    
    function update_staff_pass_profile($staff_id)
    {
        if($this->input->post('new_pass') == $this->input->post('confirm_pass')){
            $data['password']     = sha1($this->input->post('new_pass'));
            $this->db->where('staff_id',$staff_id);
            $this->db->update('staff', $data);   
            $this->session->set_flashdata('flash_message' , "Contraseña actualizada correctamente.");
            redirect(base_url() . $this->session->userdata('login_type').'/staff_security/'.base64_encode($staff_id), 'refresh');   
        }else{
            $this->session->set_flashdata('flash_message' , "Hubo un error al actualizar la contraseña.");
            redirect(base_url() . $this->session->userdata('login_type').'/staff_security/'.base64_encode($staff_id), 'refresh');
        }
    }

    function update_patient_pass($patient_id)
    {
        if($this->input->post('new_pass') == $this->input->post('confirm_pass')){
            $data['password']     = sha1($this->input->post('new_pass'));
            $this->db->where('patient_id',$patient_id);
            $this->db->update('patient', $data);   
            $this->session->set_flashdata('flash_message' , "Contraseña actualizada correctamente.");

            require("public/apis/class.phpmailer.php");
            $mail = new PHPMailer(); 
            $mail->IsHTML(true);
            $mail->IsMail();
            $mail->CharSet = 'UTF-8';
            $mail->SetFrom('usuarios@medicaby.com', 'Notificaciones Medicaby');
            $mail->Subject = "Cambio de clave";
            $data_email = array(
                'email_msg' => "¡Hola ".$this->input->post('first_name')."! Recibes esta notificación porque se ha cambiado tu clave de cuenta de usuario en <b>".$this->system_name()."</b>, tus datos son los siguientes: <br><br><b>Usuario: </b>".$this->db->get_where('patient', array('patient_id' => $patient_id))->row()->username."<br><b>Nueva clave:</b> ".$this->input->post('new_pass')."<br> Para iniciar sesión haz click aquí: ".base_url().'/login'
            );
            $mail->Body = $this->load->view('backend/mails/credentials.php',$data_email,TRUE);
            $mail->AddAddress($this->db->get_where('patient', array('patient_id' => $patient_id))->row()->email);
            if(!$mail->Send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            }
           
        }else{
            $this->session->set_flashdata('flash_message' , "Hubo un error al actualizar la contraseña.");
           
        }
           
        
    }
    
    
    function update_the_patient_pass($patient_id)
    {

            $data['password']     = sha1($this->input->post('new_pass'));
            $this->db->where('patient_id',$patient_id);
            $this->db->update('patient', $data);   
            $this->session->set_flashdata('flash_message' , "Contraseña actualizada correctamente.");

            redirect(base_url() . 'patient/patient_security/'.base64_encode($patient_id), 'refresh');   
        
    }
    
    function update_patient_pass_profile($admin_id)
    {
        if($this->input->post('new_pass') == $this->input->post('confirm_pass')){
            $data['password']     = sha1($this->input->post('new_pass'));
            $this->db->where('admin_id',$admin_id);
            $this->db->update('admin', $data);   
            $this->session->set_flashdata('flash_message' , "Contraseña actualizada correctamente.");
            redirect(base_url() . 'doctor/doctor_security/'.base64_encode($admin_id), 'refresh');   
        }else{
            $this->session->set_flashdata('flash_message' , "Hubo un error al actualizar la contraseña.");
            redirect(base_url() . 'doctor/doctor_security/'.base64_encode($admin_id), 'refresh');
        }
    }


    
    function getUsername($string= '')
    {
		  $pattern = " ";
		  $firstPart = strstr(strtolower($string), $pattern, true);
		  $secondPart = substr(strstr(strtolower($string), $pattern, false), 0,3);
		  $nrRand = rand(0, 100);
		  $username = trim($firstPart).trim($secondPart).trim($nrRand);
		  return $username; 
    }
    

    function get_lhfa($dob,$patient_id)
    {
        $apps = $this->db->get_where('appointment',array('patient_id'=>$patient_id))->result_array();
        $progress = array();
        foreach ($apps as $app) {
            # code...
            $fecha1 = explode("/", $dob);
            $fecha2 = explode("/", $app['date']);
          
            $date1 = new DateTime($fecha1[2].'-'.$fecha1[1].'-'.$fecha1[0]);
            $date2 = new DateTime($fecha2[2].'-'.$fecha2[1].'-'.$fecha2[0]);
            $diff = $date1->diff($date2);
            if($app['t'] != ""){
                $moths = ($diff->y*12)+$diff->m;
                array_push($progress,array('x'=>$moths,'y'=>$app['t']));
            }

        }
        
        echo json_encode($progress);
    }

    function get_wfa($dob,$patient_id)
    {
        $apps = $this->db->get_where('appointment',array('patient_id'=>$patient_id))->result_array();
        $progress = array();
        foreach ($apps as $app) {

            log_message('error','patiend date '.$dob);
            # code...
            $fecha1 = explode("/", $dob);
            $fecha2 = explode("/", $app['date']);
          
            $date1 = new DateTime($fecha1[2].'-'.$fecha1[1].'-'.$fecha1[0]);
            $date2 = new DateTime($fecha2[2].'-'.$fecha2[1].'-'.$fecha2[0]);
            $diff = $date1->diff($date2);
            if($app['w'] != ""){
                $moths = ($diff->y*12)+$diff->m;
                array_push($progress,array('x'=>$moths,'y'=>$app['w']));
            }

        }
        
        echo json_encode($progress);
    }


    function get_wfl($dob,$patient_id)
    {
        log_message('error','get_wfl  '.$dob);
        $apps = $this->db->get_where('appointment',array('patient_id'=>$patient_id))->result_array();
        $progress = array();
        foreach ($apps as $app) {
            # code...
            $fecha1 = explode("/", $dob);
            $fecha2 = explode("/", $app['date']);
          
            $date1 = new DateTime($fecha1[2].'-'.$fecha1[1].'-'.$fecha1[0]);
            $date2 = new DateTime($fecha2[2].'-'.$fecha2[1].'-'.$fecha2[0]);
            $diff = $date1->diff($date2);
            if($app['w'] != ""){
            
                array_push($progress,array('x'=>intval($app['t']),'y'=>intval($app['w'])));
            }

        }
        
        echo json_encode($progress);
    }


    function get_age($dob)
    {
        $hoy = date('Y-m-d');
        $fecha = explode("/", $dob);
        $date1 = new DateTime($hoy);
        $date2 = new DateTime($fecha[2].'-'.$fecha[1].'-'.$fecha[0]);
        $diff = $date1->diff($date2);


        if($diff->y > 1)
        {
           
            if($diff->m > 1)
            {
                return $diff->y." años y ".$diff->m." meses";
                
    
            }elseif($diff->m == 1)
            {

                return $diff->y." años y ".$diff->m."  mes";
    
            }elseif($diff->m == 0)
            {
                
                return $diff->y." años y ".$diff->m."  meses";
    
            }


        }elseif($diff->y == 1)
        {
            if($diff->m > 1)
            {
                return $diff->y." año y ".$diff->m." meses";
                
    
            }elseif($diff->m == 1)
            {

                return $diff->y." año y ".$diff->m."  mes";
    
            }elseif($diff->m == 0)
            {
                
                return $diff->y." año y ".$diff->m."  meses";
    
            }

        }elseif($diff->m > 1)
        {
            return $diff->m." meses";

        }elseif($diff->m == 1)
        {
            return $diff->m."  mes";

        }elseif($diff->d > 1)
        {
            return $diff->d." dias";

        }elseif($diff->d <= 1)
        {
            return $diff->d." dia";
        }

    }
    
       function get_age_card($dob)
    {

        $hoy =date('Y-m-d');
        $fecha = explode("/", $dob);
        $date1 = new DateTime($hoy);
        $date2 = new DateTime($fecha[2].'-'.$fecha[1].'-'.$fecha[0]);
        $diff = $date1->diff($date2);


        if($diff->y > 1)
        {
            if($diff->m > 1)
            {
                return $diff->y." años y ".$diff->m." meses";
                
    
            }elseif($diff->m == 1)
            {

                return $diff->y." años y ".$diff->m."  mes";
    
            }elseif($diff->m == 0)
            {
                
                return $diff->y." años y ".$diff->m."  meses";
    
            }

        }elseif($diff->y == 1)
        {
            if($diff->m > 1)
            {
                return $diff->y." año y ".$diff->m." meses";
                
    
            }elseif($diff->m == 1)
            {

                return $diff->y." año y ".$diff->m."  mes";
    
            }elseif($diff->m == 0)
            {
                
                return $diff->y." año y ".$diff->m."  meses";
    
            }

        }elseif($diff->m > 1)
        {
            return $diff->m." meses";

        }elseif($diff->m == 1)
        {
            return $diff->m."  mes";

        }elseif($diff->d > 1)
        {
            return $diff->d." dias";

        }elseif($diff->d <= 1)
        {
            return $diff->d." dia";
        }

       
    }
    
    
        function get_age_list($dob)
    {
        $hoy =date('Y-m-d');
        $fecha = explode("/", $dob);
        $date1 = new DateTime($hoy);
        $date2 = new DateTime($fecha[2].'-'.$fecha[1].'-'.$fecha[0]);
        $diff = $date1->diff($date2);


        if($diff->y > 1)
        {
            return $diff->y." años";

        }elseif($diff->y == 1)
        {
            return $diff->y." año";

        }elseif($diff->m > 1)
        {
            return $diff->m." meses";

        }elseif($diff->m == 1)
        {
            return $diff->m."  mes";

        }elseif($diff->d > 1)
        {
            return $diff->d." dias";

        }elseif($diff->d <= 1)
        {
            return $diff->d." dia";
        }

    }
    
    function percentage($gender, $clinic_id)
    {
        $cont = $this->db->get_where('patient',array('gender'=>$gender,'clinic_id'=>$clinic_id))->num_rows();
        $total = $this->db->get_where('patient',array('clinic_id'=>$clinic_id,'status'=>1))->num_rows();
        
        $porcentaje = ($cont/$total)*100;
        
        return $porcentaje;
    }
    
    function short_name($type, $user_id)
    {
        $first_name = $this->db->get_where($type, array(''.$type.''.'_id' => $user_id))->row()->first_name;
        $last_name  = $this->db->get_where($type, array(''.$type.''.'_id' => $user_id))->row()->last_name;
        return $first_name." ".$last_name;
    }
    
    function getirstname($type, $user_id)
    {
        $first_name = $this->db->get_where($type, array(''.$type.''.'_id' => $user_id))->row()->first_name;
        return $first_name;
    }
    
    function get_name($type, $user_id)
    {
        $first_name = $this->db->get_where($type, array(''.$type.''.'_id' => $user_id))->row()->first_name;
        $last_name  = $this->db->get_where($type, array(''.$type.''.'_id' => $user_id))->row()->last_name;
        return $first_name." ".$last_name;
    }
    
    function get_name_patient($type, $user_id)
    {
        $first_name     = $this->db->get_where($type, array(''.$type.''.'_id' => $user_id))->row()->first_name;
        $second_name    = $this->db->get_where($type, array(''.$type.''.'_id' => $user_id))->row()->second_name;
        $last_name      = $this->db->get_where($type, array(''.$type.''.'_id' => $user_id))->row()->last_name;
        $second_last_name    = $this->db->get_where($type, array(''.$type.''.'_id' => $user_id))->row()->second_last_name;
        return $first_name." ".$second_name." ".$last_name." ".$second_last_name;
    }

    function get_full_name($type, $user_id)
    {
        $patient = $this->db->get_where($type, array(''.$type.''.'_id' => $user_id))->row();
        $first_name =$patient->first_name;
        $second_name = $patient->second_name;
        $third_name = $patient->third_name;
        $last_name  = $patient->last_name;
        $second_last_name =  $patient->second_last_name;
        $married_last_name =  $patient->married_last_name;

        if($third_name != "")
            return $first_name." ".$second_name." ".$third_name." ".$last_name." ".$second_last_name;
        else
            return $first_name." ".$second_name." ".$last_name." ".$second_last_name;

    }
    
    function get_last_name($type, $user_id)
    {
        $last_name  = explode(" ",$this->db->get_where($type, array(''.$type.''.'_id' => $user_id))->row()->last_name);
        return $last_name[0];
    }
    
    function get_photo($type_, $user_id) 
    {
        if($type_ == 'admin'){
            $typ = 'doctor';
        }elseif($type_ == 'staff'){
            $typ = 'staff';
        }else{
            $typ = 'patient';
        }
        $initial = strtoupper($this->db->get_where($type_, array(''.$type_.''.'_id' => $user_id))->row()->first_name[0]);
        $status = 0;
        $this->db->where($type_.'_id',$user_id);
        $imgs = $this->db->get($type_)->row()->photo;
        if($this->UR_exists(base_url()."public/uploads/".$typ."_image/".$imgs) && $imgs != '')
        {
            $image = base_url() . 'public/uploads/'.$typ.'_image/'.$imgs;
        }else{
             $image = base_url() . 'public/uploads/avatars/'.$initial.'.svg';   
        }
        return $image;
    }
    
        function get_photo_third( $user_id) 
    {
        
        $initial = strtoupper($this->db->get_where('third', array('terceros_id' => $user_id))->row()->name[0]);
        $status = 0;
        $image = base_url() . 'public/uploads/avatars/'.$initial.'.svg';   
        
        return $image;
    }
    
    
    function check_mail()
    {
        
        $num = $this->db->get_where('admin', array('email' =>$this->input->post('mail')))->num_rows();
    
        $response = array(
        "available"  => $num
        
        );
            
        return $response;  
        
        
    }

 
}