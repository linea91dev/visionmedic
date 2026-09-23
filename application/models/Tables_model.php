<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tables_model extends CI_Model 
{
    function __construct() 
    {
      parent::__construct();
    }
    
    
    function getTables($table = '', $param1 = '', $param2 = '', $param3 = '')
    {
        $fetch_data = $this->MakeTable($table, $param1, $param2, $param3);  
        
        $data = $this->getArrays($table,$fetch_data,$param1, $param2, $param3);    
       
        $output = array(  
            "draw"                      =>      intval($_POST["draw"]),  
            "recordsTotal"              =>      $this->GetAllData($table,$param1, $param2, $param3),  
            "recordsFiltered"           =>      $this->GetFilteredData($table,$param1, $param2, $param3),  
            "data"                      =>      $data  
        );  
        
        echo json_encode($output); 
    }
    
    function MakeTable($table,$param1, $param2, $param3)
	{  
        $this->MakeQuery($table,$param1, $param2, $param3);  
        if($_POST["length"] != -1)  
        {  
            $this->db->limit($_POST['length'], $_POST['start']);  
        }  
        $query = $this->db->get();  
        return $query->result();  
    }
    
    function MakeQuery($table,$param1, $param2, $param3)  
    {  
        $this->db->select("*");  
        
        if($table == 'my_appointments')
        {
            $this->db->order_by('order_date', 'ASC');
            $this->db->from("appointment");
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            $this->db->where('doctor_id',$this->session->userdata('login_user_id'));
            $this->db->where('status !=', 4);
            $this->db->where('status !=', 5);
        }
        
        elseif($table == 'doctor_appointments')
        {
            $this->db->order_by('order_date', 'ASC');
            $this->db->from("appointment");
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            $this->db->where('doctor_id',$param1);
            $this->db->where('status !=', 4);
            $this->db->where('status !=', 5);
        }
        
        elseif($table == 'patients')
        {
            $this->db->order_by('first_name', 'ASC');
            $this->db->from("patient");
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            $this->db->where('status !=', 0);
        }

        elseif($table == 'patients_sop')
        {
            $this->db->order_by('first_name', 'ASC');
            $this->db->from("patient");
            $this->db->where('status !=', 0);
        }
        
        elseif($table == 'financial')
        {
            $this->db->order_by('financial_id', 'DESC');
            $this->db->from("financial");
            $this->db->where('clinic_id', $this->session->userdata('current_clinic'));
        }
        
        elseif($table == 'activities')
        {
            $this->db->order_by('bitacora_id', 'DESC');
            $this->db->from("bitacora");
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            $this->db->where('user_id', $param1);
            $this->db->where('user_type', $param2);
        }
        
        elseif($table == 'patient_appointments')
        {
            $this->db->order_by('appointment_id','desc');
            $this->db->from("appointment");
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            $this->db->where('patient_id', $param1);
            $this->db->where('status !=', 5);
        }
        
        elseif($table == 'inventory')
        {
            $this->db->order_by('name', 'ASC');
            $this->db->from("product");
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
        }
        
        elseif($table == 'categories')
        {
            $this->db->order_by('category_id', 'ASC');
            $this->db->from("category");
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
        }
        
        
        elseif($table == 'sales')
        {
            $this->db->order_by('cart_id', 'DESC');
            $this->db->from("cart");
            $this->db->where('status','1');
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
        }
        
        
        //*****************
        if(isset($_POST["search"]["value"]))  
        {
            if($table == 'my_appointments' || $table == 'doctor_appointments')
            {
                $this->db->like("date", $_POST["search"]["value"]);  
            }
           elseif($table == 'patients')
            {
                $this->db->where("concat(first_name,' ',second_name,' ',last_name,' ',second_last_name) like '%". $_POST["search"]["value"]."%' and status = 1");
                $this->db->or_where("concat(first_name,' ',last_name) like '%". $_POST["search"]["value"]."%' and status = 1");
            }
            elseif($table == 'patients_sop')
            {
                $this->db->where("concat(first_name,' ',second_name,' ',last_name,' ',second_last_name) like '%". $_POST["search"]["value"]."%' and status = 1");
            }
            elseif($table == 'financial')
            {
               
                $this->db->like("description", $_POST["search"]["value"]);  
            }
            elseif($table == 'activities')
            {
                $this->db->like("message", $_POST["search"]["value"]);  
            }
            
            elseif($table == 'patient_appointments')
            {
                $this->db->like("date", $_POST["search"]["value"]);  
            }
            
            elseif($table == 'inventory')
            {
                $this->db->like("name", $_POST["search"]["value"]);  
            }
            
            elseif($table == 'categories')
            {
                $this->db->like("name", $_POST["search"]["value"]);  
            }
            
            elseif($table == 'sales')
            {
                $this->db->like("total", $_POST["search"]["value"]);  
            }
            
            
        }  
        if(isset($_POST["order"]))  
        {  
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
        }  
        else  
        {  
            if($table == 'my_appointments' || $table == 'doctor_appointments')
            {
                $this->db->order_by('order_date', 'ASC');  
            }
            elseif($table == 'patients' )
            {
                $this->db->order_by('first_name', 'ASC');  
            }
            elseif($table == 'patients_sop' )
            {
                $this->db->order_by('first_name', 'ASC');  
            }
            
            elseif($table == 'activities' )
            {
                $this->db->order_by('date', 'DESC');  
            }
            elseif($table == 'patient_appointments')
            {
                $this->db->order_by('appointment_id','desc');
            }
            elseif($table == 'sales')
            {
                $this->db->order_by('cart_id', 'DESC');
            }
        }  
    }
    
    function GetAllData($table,$param1, $param2, $param3)  
    {  
        if($table == 'my_appointments')
        {
            $this->db->select("*");  
            $this->db->from("appointment"); 
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            $this->db->where('doctor_id',$this->session->userdata('login_user_id'));
            $this->db->where('status !=', 4);
            $this->db->where('status !=', 5);
            return $this->db->count_all_results(); 
        }
        elseif($table == 'doctor_appointments')
        {
            $this->db->select("*");  
            $this->db->from("appointment"); 
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            $this->db->where('doctor_id',$param1);
            $this->db->where('status !=', 4);
            $this->db->where('status !=', 5);
            return $this->db->count_all_results(); 
        }
        elseif($table == 'patients')
        {
            $this->db->select("*");  
            $this->db->from("patient"); 
            $this->db->where('status !=', 0);
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            return $this->db->count_all_results(); 
        }
        elseif($table == 'patients_sop')
        {
            $this->db->select("*");  
            $this->db->from("patient"); 
            $this->db->where('status !=', 0);
            return $this->db->count_all_results(); 
        }
        elseif($table == 'financial')
        {
            $this->db->select("*");  
            $this->db->from("financial"); 
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            return $this->db->count_all_results(); 
        }
        elseif($table == 'activities')
        {
            $this->db->select("*");  
            $this->db->from("bitacora"); 
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            $this->db->where('user_id',$param1);
            $this->db->where('user_type',$param2);
            return $this->db->count_all_results(); 
        }
        elseif($table == 'patient_appointments')
        {
            $this->db->select("*");  
            $this->db->from("appointment"); 
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            $this->db->where('patient_id',$param1);
            $this->db->where('status !=', 5);
            return $this->db->count_all_results(); 
        }
        elseif($table == 'inventory')
        {
            $this->db->select("*");  
            $this->db->from("product"); 
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            return $this->db->count_all_results(); 
        }
        elseif($table == 'categories')
        {
            $this->db->select("*");  
            $this->db->from("category"); 
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            return $this->db->count_all_results(); 
        }
        elseif($table == 'sales')
        {
            $this->db->select("*");  
            $this->db->from("cart"); 
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            return $this->db->count_all_results(); 
        }
        //*******************
    }
    
    function GetFilteredData($table,$param1, $param2, $param3)
    {  
        $this->MakeQuery($table,$param1, $param2, $param3);  
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    
    
    function getArrays($table, $fetch_data,$param1, $param2, $param3)
    {
        if($table == 'my_appointments' || $table == 'doctor_appointments')
        {
           return $this->get_appointments($table, $fetch_data,$param1, $param2, $param3);
        }
        
        elseif($table == 'patients' )
        {
            return $this->get_patients($table, $fetch_data,$param1, $param2, $param3);
        }
        elseif($table == 'patients_sop' )
        {
            return $this->get_patients_sop($table, $fetch_data,$param1, $param2, $param3);
        }
        
        elseif($table == 'financial')
        {
            return $this->get_financial($table, $fetch_data,$param1, $param2, $param3);
        }
        
        elseif($table == 'activities')
        {
            return $this->get_bitacora($table, $fetch_data,$param1, $param2, $param3);
        }
        
        elseif($table == 'patient_appointments')
        {
            return $this->get_patient_apointments($table, $fetch_data,$param1, $param2, $param3);
        }
        
        elseif($table == 'inventory')
        {
            return $this->get_products($table, $fetch_data,$param1, $param2, $param3);
        }
        
        elseif($table == 'categories')
        {
            return $this->get_categories($table, $fetch_data,$param1, $param2, $param3);
        }
        
        elseif($table == 'sales')
        {
            return $this->get_sales($table, $fetch_data,$param1, $param2, $param3);
        }
        
        //*******************
    }
    
    
    
    function get_patients($table, $fetch_data,$param1, $param2, $param3)
    {
        $data = array();  
        foreach($fetch_data as $row)  
        {  
            $app_pt         = $this->crud_model->date_appointment($row->patient_id);
            $new            = $this->crud_model->num_appointments($row->patient_id);
            $sub_array      = array();  
            
            $sub_array[]    = '<span class="smaller lighter">'.sprintf('%04d', $row->patient_id).'</span>';
            
            $sub_array[]    = '<span class="smaller lighter">@'.$row->username.'</span>';
            
            $sub_array[]    = '<div class="user-with-avatar">
                                <img alt="" src="'.$this->accounts_model->get_photo('patient', $row->patient_id).'">
                                <span>'.$this->accounts_model->get_full_name('patient', $row->patient_id).'</span>
                               </div>';
            if($row->gender =='M')
            {
                $sub_array[]    = '<div class="patient-gender-male">Masculino</div>';    
            }
            else
            {
                $sub_array[]    = '<div class="patient-gender-female">Femenino</div>';
            }
            
            $satatus = '<div class="patient-contact">';
                if($row->whatsapp_status == 1)
                {
                    $satatus .= '<a href="https://wa.me/'.$row->phone.'" target="_blank" data-toggle="tooltip" data-placement="top" title="WhatsApp" class="no-decoration"><i class="icon-container picons-social-icon-whatsapp"></i></a>';
                }
            
            $satatus .= '<a href="tel:+502'.$row->phone.'" class="no-decoration" data-toggle="tooltip" data-placement="top" title="Llamar"><i class="icon-container picons-thin-icon-thin-0289_mobile_phone_call_ringing_nfc"></i></a>';
                
                if($row->email_status == 1)
                {
                    $satatus .= '<a href="mailto:'.$row->email.'" class="no-decoration" data-toggle="tooltip" data-placement="top" title="Correo" target="_blank"><i class="icon-container picons-social-icon-gmail"></i></a>';   
                }
            
            $satatus .= '</div>';
            
            $sub_array[]    = $satatus;
        
            $sub_array[]    = '<span class="smaller lighter">'.$this->crud_model->formatear2($app_pt).'<span>';      


            if($new < 2)
            {
                $sub_array[] = '<div class="status-pill new" data-title="Nuevo" data-toggle="tooltip" data-original-title="" title="Nuevo"></div>';
            }
            else
            {
                $sub_array[] = '<div class="status-pill frec" data-title="Frecuente" data-toggle="tooltip" data-original-title="" title="Frecuente"></div>';
            }
            
            $sub_array[] = '<div class="dropdown">
                                <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="batch-icon-ellipsis" style="color:#3634a9;font-size: 20px;"></i>
                                </div>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="'.base_url().$this->session->userdata('login_type').'/patient_profile/'.base64_encode($row->patient_id).'">Perfil</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="delete_patient(\''.$row->patient_id.'\')">Eliminar</a>
                                </div>
                            </div>';
            $data[] = $sub_array;  
        }
        return $data;
    }
    

    function get_patients_sop($table, $fetch_data,$param1, $param2, $param3)
    {
        $data = array();  
        foreach($fetch_data as $row)  
        {  
            $app_pt         = $this->crud_model->date_appointment($row->patient_id);
            $new            = $this->crud_model->num_appointments($row->patient_id);
            $sub_array      = array();  
            
            $sub_array[]    = '<span class="smaller lighter">'.sprintf('%04d', $row->patient_id).'</span>';
            
            $sub_array[]    = '<span class="smaller lighter">@'.$row->username.'</span>';
            
            $sub_array[]    = '<div class="user-with-avatar">
                                <img alt="" src="'.$this->accounts_model->get_photo('patient', $row->patient_id).'">
                                <span>'.$this->accounts_model->get_name('patient', $row->patient_id).'</span>
                               </div>';
            if($row->gender =='M')
            {
                $sub_array[]    = '<div class="patient-gender-male">Masculino</div>';    
            }
            else
            {
                $sub_array[]    = '<div class="patient-gender-female">Femenino</div>';
            }
            
            $satatus = '<div class="patient-contact">';
                if($row->whatsapp_status == 1)
                {
                    $satatus .= '<a href="https://wa.me/'.$row->phone.'" target="_blank" data-toggle="tooltip" data-placement="top" title="WhatsApp" class="no-decoration"><i class="icon-container picons-social-icon-whatsapp"></i></a>';
                }
            
            $satatus .= '<a href="tel:+502'.$row->phone.'" class="no-decoration" data-toggle="tooltip" data-placement="top" title="Llamar"><i class="icon-container picons-thin-icon-thin-0289_mobile_phone_call_ringing_nfc"></i></a>';
                
                if($row->email_status == 1)
                {
                    $satatus .= '<a href="mailto:'.$row->email.'" class="no-decoration" data-toggle="tooltip" data-placement="top" title="Correo" target="_blank"><i class="icon-container picons-social-icon-gmail"></i></a>';   
                }
            
            $satatus .= '</div>';
            
            $sub_array[]    = $satatus;
        
            $sub_array[]    = '<span class="smaller lighter">'.$this->crud_model->formatear2($app_pt).'<span>';      


            if($new < 2)
            {
                $sub_array[] = '<div class="status-pill new" data-title="Nuevo" data-toggle="tooltip" data-original-title="" title="Nuevo"></div>';
            }
            else
            {
                $sub_array[] = '<div class="status-pill frec" data-title="Frecuente" data-toggle="tooltip" data-original-title="" title="Frecuente"></div>';
            }
            
            $sub_array[] = '<div class="dropdown">
                                <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="batch-icon-ellipsis" style="color:#3634a9;font-size: 20px;"></i>
                                </div>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="'.base_url().$this->session->userdata('login_type').'/patient_profile/'.base64_encode($row->patient_id).'">Perfil</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="delete_patient(\''.$row->patient_id.'\')">Eliminar</a>
                                </div>
                            </div>';
            $data[] = $sub_array;  
        }
        return $data;
    }
    
    function get_appointments($table, $fetch_data,$param1, $param2, $param3)
    {
        $data = array();  
           foreach($fetch_data as $row)  
           {  
                $sub_array = array();  
                $sub_array[] = '<a href="'.base_url().$this->session->userdata('login_type').'/appointment_details/'.base64_encode($row->appointment_id).'"><img src="'.$this->accounts_model->get_photo("patient",$row->patient_id).'" width="35px" style="padding-right:6px">'.$this->accounts_model->short_name("patient", $row->patient_id).'</a>';  
                            
                $sub_array[] = $this->accounts_model->gender($row->doctor_id).' '.$this->accounts_model->short_name('admin',$row->doctor_id);
                
                $status = "";
                if($row->time < '12:00')
                {
                    $status = '<span class="shadow-none badge badge-primary">'.$this->crud_model->formatear($row->date).' - '.$row->time.' AM </span>';
                }
                else
                {
                    $status = '<span class="shadow-none badge badge-primary">'.$this->crud_model->formatear($row->date).' - '.$row->time.' PM </span>';
                }
                
                $sub_array[] = $status;
                
                $satatus = "";
                if($row->status == 0)
                {
                    $satatus = '<span class="badge badge-celeste" style="color: #fff;background-color: #5bb3f5;">Pendiente</span>';
                }
                elseif($row->status == 1)
                {
                    $satatus = '<span class="badge badge-verde" style="color: #fff;background-color: #528410;">Confirmada</span>';
                }
                elseif($row->status == 2)
                {
                    $satatus = '<span class="badge badge-rosa" style="color: #fff;background-color: #e0345e;">Cancelada</span>';
                }
                elseif($row->status == 3)
                {
                    $satatus = '<span class="badge badge-marron" style="color: #fff;background-color: #a66767;">Reprogramada</span>';
                }
                
                elseif($row->status == 10)
                {
                    $satatus = '<span class="badge badge-amarillo" style="color: #fff;background-color: #e6b517;">Pendiente de cobro</span>';
                }
                
                $sub_array[] = $satatus;
                $data[] = $sub_array;  
           }
           return $data;
    }
    
    function get_financial($table, $fetch_data,$param1, $param2, $param3)
    {
        $currency = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
        $data = array();  
       foreach($fetch_data as $row)  
       {  
            
            $sub_array = array();  
            $sub_array[] = '<div class="text-right">'.$row->financial_id.'</div>';
            $sub_array[] = '<span class="smaller lighter">'.$row->date.'</span>';
            $sub_array[] = '<div class="user-with-avatar">
                                <i class="finance-icon picons-thin-icon-thin-0383_graph_columns_growth_statistics"></i> <span class="smaller lighter">'.$row->description.'</span>
                            </div>';
            if($row->type == 1)
            {
                $sub_array[] = '<div class="patient-gender-male">Ingreso</div>';
            }
            else
            {
                $sub_array[] = '<div class="patient-gender-female">Egreso</div>';
            }
            
            if($param1 != 'report')
            {
                $satatus = "";
                if($row->invoice_file != '')
                {
                    $satatus = '<a href="'.base_url().$this->session->userdata('login_type').'/financial/invoice/'.$row->financial_id.'"><i class="picons-thin-icon-thin-0122_download_file_computer_drive" style="color:#0176fe" data-toggle="tooltip" data-placement="top" title="" data-original-title="Factura"></i></a>';
                }
                if($row->reference_file != '')
                {
                    $satatus .= '<a href="'.base_url().$this->session->userdata('login_type').'/financial/reference/'.$row->financial_id.'"><i class="picons-thin-icon-thin-0096_file_attachment" style="color:#0176fe" data-toggle="tooltip" data-placement="top" title="" data-original-title="Comprobante"></i></a>'; 
                }
                
                $satatus .= '<a href="javascript:void(0);" onclick="modal_lg(\''.base_url().'modal/popup/modal_income/'.$row->financial_id.'\');"><i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i></a>
				             <a href="javascript:void(0);" onclick="delete_income(\''.$row->financial_id.'\')"><i class="picons-thin-icon-thin-0057_bin_trash_recycle_delete_garbage_full"></i></a>';
                
                $sub_array[] = $satatus;
            }
            
            if($row->type == 1)
            {
                $sub_array[] = '<div class="text-right" style="width:200px"><span class="income"> + '.$currency.'. '.number_format($row->amount,2,'.',',').'</span></div>';    
            }
            else
            {
                $sub_array[] = '<div class="text-right" style=" width:200px;text-align:right"><span class="expense"> - '.$currency.'. '.number_format($row->amount,2,'.',',').'</span></div>';    
            }
            $data[] = $sub_array;  
        }
        
        return $data;
    }
    
    function get_bitacora($table, $fetch_data,$param1, $param2, $param3)
    {
        $data = array();  
        foreach($fetch_data as $row)  
        {  
            $sub_array = array();  
            $sub_array[] = '<div style="font-family:\'Poppins\';font-size:14px;font-weight:bold;color:#4b4a55" class="">'.$row->message.'</div>';
            $sub_array[] = '<div class="text-right"><span class="smaller lighter">'.$row->date.'</span></div>';
            $data[] = $sub_array; 
        }  
        
    
        return $data;
    }
    
    function get_patient_apointments($table, $fetch_data,$param1, $param2, $param3)
    {
        $data = array();  
        $n = 1;
        foreach($fetch_data as $row)  
        {  
            $sub_array = array();  
            $sub_array[] = $n++;
            if($row->treatment_id > 0){
                $sub_array[] = '<a href="'.base_url().$this->session->userdata('login_type').'/treatment_details/'.base64_encode($row->treatment_id).'">
                <img src="'.$this->accounts_model->get_photo('patient', $row->patient_id).'" width="35px" style="padding-right:6px"> 
                                '.$this->accounts_model->short_name('patient', $row->patient_id).'</a>';    
            }
            else
            {
                $sub_array[] = '<a href="'.base_url().$this->session->userdata('login_type').'/appointment_details/'.base64_encode($row->appointment_id).'">
                <img src="'.$this->accounts_model->get_photo('patient', $row->patient_id).'" width="35px" style="padding-right:6px"> 
                                '.$this->accounts_model->short_name('patient', $row->patient_id).'</a>';
                            
            }
            
            $sub_array[] = $this->accounts_model->gender($row->doctor_id).' '.$this->accounts_model->short_name('admin',$row->doctor_id);
            $satatus = '<div class="precio-ingreso">'.$this->crud_model->formatear($row->date).' - '.$row->time.' ';
            if($row->time < '12:00')
            {
                $satatus .= ' AM </div>';
            }
            else
            {
                $satatus .= ' PM </div>';
            }
            $sub_array[] = $satatus;
            
            if($row->status == '0')
            {
                $sub_array[] = '<span class="badge badge-celeste" style="color: #fff;background-color: #5bb3f5;">Pendiente</span>';
            }
            elseif($row->status == '1')
            {
                $sub_array[] = '<span class="badge badge-verde" style="color: #fff;background-color: #528410 ;">Confirmada</span>';
            }
            elseif($row->status == '2')
            {
                $sub_array[] = '<span class="badge badge-rosa" style="color: #fff;background-color: #e0345e;">Cancelada</span>';
            }
            elseif($row->status == '3')
            {
                $sub_array[] = '<span class="badge badge-marron" style="color: #fff;background-color: #a66767;">Reprogramada</span>';
            }
            elseif($row->status == '4')
            {
                $sub_array[] = '<span class="badge badge-azul" style="color: #fff;background-color: #0044e9;">Finalizada</span>';
            }
            elseif($row->status == '10')
            {
                $sub_array[] = '<span class="badge badge-amarillo" style="color: #fff;background-color: #e6b517;">Pendiente de cobro</span>';
            }
            
        
            $data[] = $sub_array; 
        }  
        
       return $data;
    }
    
    function get_products($table, $fetch_data,$param1, $param2, $param3)
    {
        $data = array();  
        $currency = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
        foreach($fetch_data as $row)  
        {  
            $categ_name = $this->db->get_where('category', array('category_id'=>$row->category_id))->row()->name;
            $sub_array = array();  
            $sub_array[] =  '<span class="smaller lighter">'.sprintf('%04d', $row->product_id).'</span>';
            $sub_array[] =  '<span class="smaller lighter">'.$row->code.'</span>';
            $sub_array[] =  '<div><img style="max-width:45px" alt="" src="'.$this->crud_model->getProductImage($row->product_id).'"><span class="smaller lighter">'.$row->name.'</span></div>';
            $sub_array[] =  '<span class="smaller lighter">'.$row->expiration_date.'</span>';
            $sub_array[] =  '<span style="color:#99bf2d;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;">'.$categ_name.'</span>';
            $sub_array[] =  '<span class="smaller lighter">'.$currency.'. '.number_format($row->cost, 2, '.', ',').'</span>';
            $sub_array[] =  '<span class="smaller lighter">'.$currency.'. '.number_format($row->price, 2, '.', ',').'</span>';
            $sub_array[] =  '<span class="smaller lighter">'.$row->stock.'</span>';
            
            
            if($row->stock > $row->amount_alert)
            {
                $sub_array[] = '<span class="status-pill green" data-toggle="tooltip" data-placement="top" title="Producto disponible"></span>'; 
            }
            if($row->stock <= $row->amount_alert && $row->stock > 0 )
            {
                $sub_array[] = '<span class="status-pill yellow" data-toggle="tooltip" data-placement="top" title="Producto en alerta"></span>';
            }
            
            if($row->stock <= 0)
            {
                $sub_array[] = '<span class="status-pill red" data-toggle="tooltip" data-placement="top" title="Producto agotado"></span>';
            }
            
            $sub_array[] = '<div class="dropdown"><div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="batch-icon-ellipsis" style="color:#3634a9;font-size: 20px;"></i>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"><a class="dropdown-item" href="javascript:void(0);" onclick="modal_lg(\''.base_url().'modal/popup/modal_inventory/'.$row->product_id.'\');">Editar</a>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="delete_inventory(\''.$row->product_id.'\')">Eliminar</a></div>
                            </div>';
            $data[] = $sub_array; 
        }  
        
       return $data;
    }
    
    function get_categories($table, $fetch_data,$param1, $param2, $param3)
    {
        $data = array();  
        $n = 1;
        foreach($fetch_data as $row)  
        {  
            $consulta = $this->db->get_where('product', array('category_id' => $row->category_id))->num_rows();   
            $sub_array = array();  
            $sub_array[] =  $n++;
            $sub_array[] =  '<span class="smaller lighter">'.$row->name.'</span>';
            $sub_array[] =  '<span class="smaller lighter">'.$row->description.'</span>';
            $sub_array[] =  '<span class="badge badge-primary">'.$consulta.'</span>';
            
            $sub_array[] =  '<div class="dropdown">
                                <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="batch-icon-ellipsis" style="color:#3634a9;font-size: 20px;"></i>
                                </div>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="modal_lg(\''.base_url().'modal/popup/modal_category/'.$row->category_id.'\');">Editar</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="delete_category(\''.$row->category_id.'\')">Eliminar</a>
                                </div>
                            </div>';
            $data[] = $sub_array; 
        }  
        
       return $data;
    }
    
    
    function get_sales($table, $fetch_data,$param1, $param2, $param3)
    {
        $data = array();  
        $currency = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
        $n = 1;
        foreach($fetch_data as $row)  
        {  
            $sub_array = array();  
            $sub_array[] =  '<span class="smaller lighter">'.'CRT-'.$n++.'</span>';
            $sub_array[] =  '<div class="user-with-avatar">
                                <img alt="" src="'.$this->accounts_model->get_photo('patient',$row->patient_id).'"><span class="smaller lighter">'.$this->accounts_model->short_name('patient',$row->patient_id).'</span>
                            </div>';
            $sub_array[] =  '<div class="user-with-avatar">
                                <img alt="" src="'.$this->accounts_model->get_photo($row->user_type,$row->user_id).'"><span class="smaller lighter">'.$this->accounts_model->short_name($row->user_type,$row->user_id).'</span>
                            </div>';
                            
            $status =  '<span style="color:#99bf2d;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;">';
                        if($row->payment_type == 1){
                        $status .= 'Efectivo';
                        }
                        elseif($row->payment_type == 2)
                        {
                         $status .= 'Tarjeta';
                        }
                        
                        elseif($row->payment_type == 3)
                        {
                            $status.= 'Depósito';
                        }
                        elseif($row->payment_type == 0 | $row->payment_type == "") 
                        {
                           $status.= 'n/d';
                        }
                    
                        $status.= '</span>';
            $sub_array[] = $status;
            
        
            $sub_array[] = '<span class="smaller lighter">'.$currency.'. '.number_format($row->total,'2','.',',').'</span>';
            $sub_array[] = '<span class="smaller lighter">'.$row->date.'</span>';
            $sub_array[] = '<div class="dropdown">
                                <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="batch-icon-ellipsis" style="color:#00a0ff;font-size: 20px;"></i>
                                </div>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="'.base_url().$this->session->userdata('login_type').'/sale_details/'.base64_encode($row->cart_id).'">Detalles</a><a class="dropdown-item" href="javascript:void(0);" onclick="delete_sale(\''.base64_encode($row->cart_id).'\')">Eliminar</a>
                                </div>
                            </div>';
            $data[] = $sub_array; 
        }  
        
       return $data;
    }
}
