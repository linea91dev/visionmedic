<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model extends CI_Model 
{
    function __construct() 
    {
      parent::__construct();
    }
    
    function getPercentage($total, $cant)
    {
        if($total>0)
        {
            $total = (100 * $cant)/$total;
            if($total>0)
            {
                return round($total, 0, PHP_ROUND_HALF_EVEN);
            }
            else
            {
                return 0;
            }
        }else
        {
            return 0;
        }
    }

    function checkMobile(){
        require_once "public/apis/detect/Mobile_Detect.php";
        $detect = new Mobile_Detect();
        if ($detect->isMobile() || $detect->isTablet() || $detect->isAndroidOS()) {
            return true;
        }else{
            return false;
        }
    }

    function getSpecialty($specialtie){
        return $this->db->get_where('specialtie', array('specialtie_id' => $specialtie))->row()->name;
    }
    
    function getDoctors(){
        return $this->db->query('SELECT * FROM admin WHERE status != "0" AND clinic_id = "'.$this->session->userdata('current_clinic').'" AND  admin_id != 1')->result_array();
    }
    
    function getStaffDoctors(){
        return $this->db->query('SELECT * FROM admin WHERE status != "0" AND clinic_id ="'.$this->session->userdata('current_clinic').'"')->result_array();
    }
    
    function formatDate2()
    {
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
        return date('d')." de ".$meses[date('n')-1].". a las ".date('H:i A');
    }
    
    function getStaffList(){
        $query = $this->db->query('SELECT * FROM staff WHERE status != "0" AND clinic_id ="'.$this->session->userdata('current_clinic').'"')->result_array();
        return $query;
    }

    function getStaffListStaff(){
        $query = $this->db->query('SELECT * FROM staff WHERE status != "0" AND staff_id != "'.$this->session->userdata('login_user_id').'" AND clinic_id ="'.$this->session->userdata('current_clinic').'"')->result_array();
        return $query;
    }
    
    function checkSubscription(){
        $query = $this->db->get_where('suscription', array('clinic_id' => $this->session->userdata('current_clinic'), 'status' => 0));        
        return $query;
    }
    
    function getAccountInfo($column, $method)
    {
        return $this->db->get_where('payment_method', array('slug' => $method))->row()->$column;
    }
    
    function date_week($u_date) 
    {
        $date_obj = new DateTime($u_date); // Crear un objeto de fecha
        $num_day = intval($date_obj->format('w')); // 0-dom, 1-lun, ... 6-sab
        $date_obj->modify("-$num_day day"); // Posicionar el objeto en domingo
        $wdays = array();
        for($i=0; $i<14; $i++) {
            $wdays[] = $date_obj->format('Y-m-d');
            $date_obj->modify('+1 day'); // Incrementar el objeto 1 dia
        }
        return $wdays;
    }
    
    function set_online_status($user_type, $user_id)
    {
        $session    = session_id();
        $time       = time();
        $time_check = $time-300;
        $this->db->where('session', $session);
        $count = $this->db->get('online_users')->num_rows();
        if($count == 0)
        { 
            $data['time'] = $time;
            $data['type'] = $user_type;
            $data['id_usuario'] = $user_id;
            $data['gp'] = $user_id."-".$user_type;
            $data['session'] = $session;
            $this->db->insert('online_users',$data);
        }
        else 
        {
            $data['session'] = $session;
            $data['time'] = $time;
            $data['gp'] = $user_id."-".$user_type;
            $data['id_usuario'] = $user_id;
            $data['type'] = $user_type;
            $this->db->where('session', $session);
            $this->db->update('online_users', $data);
        }  
        $this->db->where('time <', $time_check);
        $this->db->delete('online_users');
    }
    
    
    function get_questions($survey_id)
    {
        $questions = $this->db->get_where('question', array('survey_id' => $survey_id))->result_array();
		$string = "";
	    foreach($questions as $row)
	    {
	        $string .= "'".$row['question']."'".",";
	    }
	    return $string;
    }

    function get_total_appointments()
    {
            $clinic_id = $this->session->userdata('current_clinic');
            $inicial   = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->morning;
            $final     = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->b_morning;
            $inicial2  = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->afternoon;
            $final2    = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->b_afternoon;
            $intervalo = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->time_interval;
            
            
            $horas = $this->interval($inicial, $final, $intervalo);
            $cont = 0;
            for($i = 0; $i < count($horas); $i++)
            {
                $cont++;
                
                
            }
            
            
            $horas2 =  $this->interval($inicial2, $final2, $intervalo);
            
            for($i = 0; $i < count($horas2); $i++)
            {
                $cont++;
                
                
            }
            
            return $cont;

    }
    
     function intervalo($hora_inicio, $hora_fin, $intervalo) 
    {
        $hora_inicio = new DateTime($hora_inicio );
        $hora_fin    = new DateTime($hora_fin );
        $hora_fin->modify('+1 second'); // Añadimos 1 segundo para que nos muestre $hora_fin
        // Si la hora de inicio es superior a la hora fin
        // añadimos un día más a la hora fin
        if ($hora_inicio > $hora_fin) 
        {        
            $hora_fin->modify('+1 day');
        }
        // Establecemos el intervalo en minutos        
        $intervalo = new DateInterval('PT'.$intervalo.'M');
        // Sacamos los periodos entre las horas
        $periodo   = new DatePeriod($hora_inicio, $intervalo, $hora_fin);        
        foreach( $periodo as $hora ) 
        {
            // Guardamos las horas intervalos 
            $horas[] =  $hora->format('H:i');
        }
        return $horas;
    }
    
        function get_total_appointments_today()
    {
            $clinic_id = $this->session->userdata('current_clinic');
            $inicial   = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->morning;
            $final     = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->b_morning;
            $inicial2  = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->afternoon;
            $final2    = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->b_afternoon;
            $intervalo = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->time_interval;
            
            
            $horas = $this->interval($inicial, $final, $intervalo);
            $cont = 0;
            $var = date('H:i');
            $past=0;
            for($i = 0; $i < count($horas); $i++)
            {
                
                if($horas[$i]<$var)
                {
                    $past++;
                }
                $cont++;
                
                
            }
            
            
            $horas2 =  $this->interval($inicial2, $final2, $intervalo);
            
            for($i = 0; $i < count($horas2); $i++)
            {
                if($horas2[$i]<$var)
                {
                    $past++;
                }
                $cont++;
                
                
            }
            
            return $past;

    }

    function fill_week($date){
        $explode_date = explode('-', $date);
        $this->db->where('day',$explode_date[2]);
        $this->db->where('month',$explode_date[1]);
        $this->db->where('year',$explode_date[0]);
        
        $this->db->where('status !=', 4);
        $this->db->where('status !=', 5);
        $this->db->where('status !=', 6);
        $this->db->where('doctor_id', $this->session->userdata('login_user_id'));
        $this->db->where('clinic_id', $this->session->userdata('current_clinic'));
        $nums = $this->db->get('appointment')->num_rows();
        return $nums;
        
    }
    
    
    function fill_week_doc_past($date,$doctor_id){
         $this->db->where('doctor_id',$doctor_id);
        $explode_date = explode('-', $date);
        $this->db->where('day',$explode_date[2]);
        $this->db->where('month',$explode_date[1]);
        $this->db->where('year',$explode_date[0]);
        $this->db->where('status', 4);
        $nums = $this->db->get('appointment')->num_rows();
        return $nums;
    }
    
    function fill_week_doc($date,$doctor_id){
       
        $this->db->where('doctor_id',$doctor_id);
        $explode_date = explode('-', $date);
        $this->db->where('day',$explode_date[2]);
        $this->db->where('month',$explode_date[1]);
        $this->db->where('year',$explode_date[0]);
        $this->db->where('status !=', 2);
        $this->db->where('status !=', 4);
        $this->db->where('status !=', 5);
        $this->db->where('status !=', 6);
       
        $appoint = $this->db->get('appointment')->result_array();
        
		$cont = 0;
		$var = date('H:i');
		
	    foreach($appoint as $row)
	    {
	        if($row['time'] > $var){
	              $cont++;
	        }else
	        {
	            
	            $data['past_status'] = 1;
	            $data['status'] = 4;
	            $this->db->where('appointment_id',$row['appointment_id']);
	            $this->db->update('appointment', $data);
	        }
	      
	    }
       
        $stotal = ($this->get_total_appointments_today()+ $cont);
        
        $total =$this->get_total_appointments() -$stotal;
        
        return $total;
    }
    
    function past_appointment($appointent_id){
       

       
        $appoint = $this->db->get_where('appointment', array('appointment_id'=>$appointment_id))->row()->time;
        
		$cont = 0;
		$var = date('H:i');

	        if($row['time'] > $var){

	            $data['past_status'] = 1;
	            $this->db->where('appointment_id',$row['appointment_id']);
	            $this->db->update('appointment', $data);
	        }
	      
	    
       
        $stotal = ($this->get_total_appointments_today()+ $cont);
        
        $total =$this->get_total_appointments() -$stotal;
        
        return $total;
    }
    
    function fill_week_doc_future($date,$doctor_id){
       
        $this->db->where('doctor_id',$doctor_id);
        $explode_date = explode('-', $date);
        $this->db->where('day',$explode_date[2]);
        $this->db->where('month',$explode_date[1]);
        $this->db->where('year',$explode_date[0]);
        $this->db->where('status !=', 2);
        $this->db->where('status !=', 4);
        $this->db->where('status !=', 5);
        $this->db->where('status !=', 6);
       
        $appoint = $this->db->get('appointment')->num_rows();
        
        $total =  $this->get_total_appointments();
        return $total - $appoint;
    }

    function get_month()
    {

        $anioActual = date("Y");
        $mesActual = date("n");
        $cantidadDias = cal_days_in_month(CAL_GREGORIAN, $mesActual, $anioActual);
       
       for($i=1;$i<=$cantidadDias;$i++)
       echo $i.',';

    }


    function get_month_income()
    {

        $anioActual = date("Y");
        $mesActual = date("m");
        $cantidadDias = cal_days_in_month(CAL_GREGORIAN, $mesActual, $anioActual);
       
       for($i=1;$i<=$cantidadDias;$i++)
       {

        if($i<10)
            $d='0'.$i;
        else
            $d=$i;
            
            $date = $d.'/'.$mesActual.'/'.$anioActual;

            $sql = 'SELECT SUM(amount) as Total, type FROM `financial` where date ="'.$date.'" and type = 1 and clinic_id = '.$this->session->userdata('current_clinic');
        
            $res = $this->db->query($sql)->row()->Total;

            if($res)
            {
                echo $res.',';
            }else
            {
                echo '0,';

            }

       }
      

    }


    function get_month_expense()
    {

        $anioActual = date("Y");
        $mesActual = date("m");
        $cantidadDias = cal_days_in_month(CAL_GREGORIAN, $mesActual, $anioActual);
       
       for($i=1;$i<=$cantidadDias;$i++)
       {

        if($i<10)
            $d='0'.$i;
        else
            $d=$i;
            
            $date = $d.'/'.$mesActual.'/'.$anioActual;

            $sql = 'SELECT SUM(amount) as Total, type FROM `financial` where date ="'.$date.'" and type = 0 and clinic_id = '.$this->session->userdata('current_clinic');
        
            $res = $this->db->query($sql)->row()->Total;


            if($res)
            {
                echo '-'.$res.',';
            }else
            {
                echo '0,';

            }
       }
      

    }

    function get_financial()
    {
        
        $this->db->order_by('date', 'desc');
        $res = $this->db->get('financial')->result_array();
        return $res;
    }


    function get_balance()
    {

        $sql = 'SELECT SUM(amount) as total FROM `financial` where type = 1 and clinic_id = '.$this->session->userdata('current_clinic');
        $income_total = $this->db->query($sql)->row()->total;

        $sql = 'SELECT SUM(amount) as total FROM `financial` where type = 0 and clinic_id = '.$this->session->userdata('current_clinic');
        $expense_total = $this->db->query($sql)->row()->total;
     
        $total = $income_total - $expense_total;
        return number_format ( $total , 2,'.',',' );

    }


    function get_financial_report($fecha1, $fecha2)
    {
        
        $sql = "SELECT * FROM `financial` where str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y') ORDER BY financial_id DESC";
        $res = $this->db->query($sql, array($fecha1,$fecha2))->result_array();
        return $res;

    }




    function get_month_report($date1, $date2)
    {

        $explode = explode('/',$date1);
        $fecha1 = $explode[2].'-'.$explode[1].'-'.$explode[0];


        $explode2 = explode('/',$date2);
        $fecha2 = $explode2[2].'-'.$explode2[1].'-'.$explode2[0];
        
        for($i=$fecha1;$i<=$fecha2;$i = date("Y-m-d", strtotime($i ."+ 1 days")))
        {
            echo substr($i, -2).','; 
         //aca puedes comparar $i a una fecha en la bd y guardar el resultado en un arreglo
        
        }

    }

    function get_month_expense_report($date1, $date2)
    {

        $explode = explode('/',$date1);
        $fecha1 = $explode[2].'-'.$explode[1].'-'.$explode[0];


        $explode2 = explode('/',$date2);
        $fecha2 = $explode2[2].'-'.$explode2[1].'-'.$explode2[0];
        
        for($i=$fecha1;$i<=$fecha2;$i = date("Y-m-d", strtotime($i ."+ 1 days")))
        {
            $d = date("d/m/Y", strtotime($i)); 

            $sql = 'SELECT SUM(amount) as Total, type FROM `financial` where date ="'.$d.'" and type = 0 and clinic_id = '.$this->session->userdata('current_clinic');
        
            $res = $this->db->query($sql)->row()->Total;


            if($res)
            {
                echo '-'.$res.',';
            }else
            {
                echo '0,';

            }
        
        }
      

    }

    
    function get_month_income_report($date1, $date2)
    {

        $explode = explode('/',$date1);
        $fecha1 = $explode[2].'-'.$explode[1].'-'.$explode[0];


        $explode2 = explode('/',$date2);
        $fecha2 = $explode2[2].'-'.$explode2[1].'-'.$explode2[0];
        
        for($i=$fecha1;$i<=$fecha2;$i = date("Y-m-d", strtotime($i ."+ 1 days")))
        {
            $d = date("d/m/Y", strtotime($i)); 

            $sql = 'SELECT SUM(amount) as Total, type FROM `financial` where date ="'.$d.'" and type = 1 and clinic_id = '.$this->session->userdata('current_clinic');
        
            $res = $this->db->query($sql)->row()->Total;


            if($res)
            {
                echo $res.',';
            }else
            {
                echo '0,';

            }
        
        }
      

    }

    function get_expense_report($date1, $date2)
    {

        $sql = "SELECT SUM(amount) as Total FROM `financial` where clinic_id = ".$this->session->userdata('current_clinic')." AND type = 0 AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y') ORDER BY financial_id DESC";
        $res = $this->db->query($sql, array($date1,$date2))->row()->Total;
       
        if($res>0)
            return number_format( $res,2,'.',',');
        else
            return number_format(0,2,'.',',');
      

    }

    function get_income_report($date1, $date2)
    {
        
        $sql = "SELECT SUM(amount) as Total FROM `financial` where clinic_id = ".$this->session->userdata('current_clinic')." AND  type = 1 AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y') ORDER BY financial_id DESC";
        $res = $this->db->query($sql, array($date1,$date2))->row()->Total;
       
        if($res>0)
            return number_format( $res,2,'.',',');
        else
            return number_format(0,2,'.',',');

    }

    function get_month_appoitments_report($doctor_id ,$date1, $date2)
    {

        $explode = explode('/',$date1);
        $fecha1 = $explode[2].'-'.$explode[1].'-'.$explode[0];


        $explode2 = explode('/',$date2);
        $fecha2 = $explode2[2].'-'.$explode2[1].'-'.$explode2[0];
        
        for($i=$fecha1;$i<=$fecha2;$i = date("Y-m-d", strtotime($i ."+ 1 days")))
        {
            $d = date("d/m/Y", strtotime($i)); 

            $sql = 'SELECT * FROM `appointment` where clinic_id ="'.$this->session->userdata('current_clinic').'" and date ="'.$d.'" and doctor_id ="'.$doctor_id.'";';
        
            $res = $this->db->query($sql)->num_rows();


            if($res)
            {
                echo $res.',';
            }else
            {
                echo '0,';

            }
        
        }
    }

    function get_month_appoitments_genderMale_report($doctor_id ,$date1, $date2)
    {
        $total = 0;
        $sql = "SELECT * FROM `appointment` where clinic_id = ? And doctor_id = ? AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y')";
        $res = $this->db->query($sql, array($this->session->userdata('current_clinic'), $doctor_id,$date1,$date2))->result_array();
       
            foreach($res as $r)
            {
                if($r['patient_id'])
                {
                    $gender = $this->db->get_where('patient',array('patient_id'=>$r['patient_id']))->row()->gender;
                     if(  $gender == 'M' )
                     {
                         $total++;

                     }
                    
                }
            }

            echo $total;

    }


    function get_month_appoitments_genderFamale_report($doctor_id ,$date1, $date2)
    {
        $total = 0;
        $sql = "SELECT * FROM `appointment` where clinic_id = ? And doctor_id = ? AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y')";
        $res = $this->db->query($sql, array($this->session->userdata('current_clinic'), $doctor_id,$date1,$date2))->result_array();
       
            foreach($res as $r)
            {
                if($r['patient_id'])
                {
                    $gender = $this->db->get_where('patient',array('patient_id'=>$r['patient_id']))->row()->gender;
                     if(  $gender == 'F' )
                     {
                         $total++;

                     }
                    
                }
            }

            echo $total;

    }



    
    function get_week()
    {
        if(date('D')!='Sun'){    
            $staticstart = date('d/m/Y',strtotime('last Sunday'));    
        }else{
            $staticstart = date('d/m/Y');   
        }
        if(date('D') != 'Sat') {
            $staticfinish = date('d/m/Y',strtotime('next Saturday'));
        }else{
            $staticfinish = date('d/m/Y');
        }
        $explode = explode('/',$staticstart);
        $explode2 = explode('/',$staticfinish);
        $start_day = $explode[0];
        $end_day = $explode2[0];
        $mes = date('m');
        if($mes == '01'){
            $month = 'enero';
        }elseif($mes == '02'){
            $month = 'febrero';
        }elseif($mes == '03'){
            $month = 'marzo';
        }elseif($mes == '04'){
            $month = 'abril';
        }elseif($mes == '05'){
            $month = 'mayo';
        }elseif($mes == '06'){
            $month = 'junio';
        }elseif($mes == '07'){
            $month = 'julio';
        }elseif($mes == '08'){
            $month = 'agosto';
        }elseif($mes == '09'){
            $month = 'septiembre';
        }elseif($mes == '10'){
            $month = 'octubre';
        }elseif($mes == '11'){
            $month = 'noviembre';
        }elseif($mes == '12'){
            $month = 'diciembre';
        }
        return 'del '.$start_day.' al '.$end_day." de ".$month;
    }


 function get_date()
    {
        if(date('D')!='Sun'){    
            $staticstart = date('d/m/Y',strtotime('last Sunday'));    
        }else{
            $staticstart = date('d/m/Y');   
        }
        if(date('D') != 'Sat') {
            $staticfinish = date('d/m/Y',strtotime('next Saturday'));
        }else{
            $staticfinish = date('d/m/Y');
        }
        $explode = explode('/',$staticstart);
        $explode2 = explode('/',$staticfinish);
        $start_day = $explode[0];
        $end_day = $explode2[0];
        $mes = date('m');
        if($mes == '01'){
            $month = 'enero';
        }elseif($mes == '02'){
            $month = 'febrero';
        }elseif($mes == '03'){
            $month = 'marzo';
        }elseif($mes == '04'){
            $month = 'abril';
        }elseif($mes == '05'){
            $month = 'mayo';
        }elseif($mes == '06'){
            $month = 'junio';
        }elseif($mes == '07'){
            $month = 'julio';
        }elseif($mes == '08'){
            $month = 'agosto';
        }elseif($mes == '09'){
            $month = 'septiembre';
        }elseif($mes == '10'){
            $month = 'octubre';
        }elseif($mes == '11'){
            $month = 'noviembre';
        }elseif($mes == '12'){
            $month = 'diciembre';
        }
        return $end_day." de ".$month;
    }


    function clear_cache() 
    {
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }
    
    function get_products()
    {
	    $this->db->order_by('name', 'ASC');
		$this->db->where('clinic_id',$this->session->userdata('current_clinic'));
		$products = $this->db->get('product')->result_array();
		$string = "";
	    foreach($products as $row)
	    {
	        $string .= "'".$row['name']."'".",";
	    }
	    return $string;
    }
    
    function get_gender($patient_id)
    {
        if($this->db->get_where('patient', array('patient_id' => $patient_id))->row()->gender == 'M'){
            return 'Masculino';
        }else{
            return 'Femenino';
        }
    }
    
    function get_format($extension)
    {
        if($extension == 'xlsx' || $extension == 'xlsm' || $extension == 'xltx' || $extension == 'xltm'){
            return base_url().'public/uploads/icons/excel.svg';
        }
        elseif($extension == 'docm' || $extension == 'docx' || $extension == 'dotx' || $extension == 'dotm'){
            return base_url().'public/uploads/icons/word.svg';
        }
        elseif($extension == 'pdf'){
            return base_url().'public/uploads/icons/pdf.svg';
        }
        elseif($extension == 'xlsx' || $extension == 'xlsm' || $extension == 'xltx' || $extension == 'xltm'){
            return base_url().'public/uploads/icons/excel.svg';
        }
        elseif($extension == 'txt'){
            return base_url().'public/uploads/icons/txt.svg';
        }
        elseif($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'JPEG' || $extension == 'gif'){
            return base_url().'public/uploads/icons/img.svg';   
        }
        elseif($extension == 'pptx' || $extension == 'pptm' || $extension == 'potx' || $extension == 'potm' || $extension == 'ppam' || $extension == 'ppsx' || $extension == 'ppsm' || $extension == 'sldx' || $extension == 'sldm'){
            return base_url().'public/uploads/icons/power.svg';   
        }else{
            return base_url().'public/uploads/icons/all.svg';   
        }
    }
    function getCode() 
    {
        return strtoupper(substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10)); 
    }

    function update_settings()
    { 
        $code= $this->db->get_where('clinic',array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->code;
        $dataUpdate['currency'] = $this->input->post('currency');
        $dataUpdate['code']=$code;
        $result = $this->send_api_update($dataUpdate);

        include('public/apis/class.fileuploader.php');
        
        $FileUploader = new FileUploader('logo', array(
            'uploadDir' => './public/uploads/',
        ));
        $logo_data = $FileUploader->upload();
        if(!empty($logo_data['files'])){
            $data['logo']               = $logo_data['files'][0]['name'];   
        }
        $data['theme']              = $this->input->post('theme');
        $data['currency']           = $this->input->post('currency');
        $data['send_survey']        = $this->input->post('send_survey');
        $data['survey_id']          = $this->input->post('survey_id');
        $data['send_schedule']      = $this->input->post('send_schedule');
        $data['hour']               = $this->input->post('hour');
        $data['product_module']     = $this->input->post('product_module');
        $data['send_reminder']      = $this->input->post('send_reminder');
        $data['reminder']           = $this->input->post('reminder');
        $data['template']           = $this->input->post('template');
        $data['area_code']           = $this->input->post('area');
        $data['country_code']        = $this->input->post('code');
        $data['sms_confirm']        = $this->input->post('sms_confirm');
     
        $this->db->where('clinic_id', $this->session->userdata('current_clinic'));
        $this->db->update('clinic', $data);
    }

    function send_api_update($data_array){
        /* $domain= $this->db->get_where('clinic',array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->domain;

        log_message('error', $domain); */
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://medicaby.com/api/updateContract",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data_array,
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    return $response; 
    }
    
    function theme(){
        $current = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->theme;
        return $current;
    }
    
    function check_item($item)
    {
        return $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->$item;    
    }
    
    function apply_forms()
    {
        $data['pathological']     = $this->input->post('pathological');
        $data['non_pathological'] = $this->input->post('non_pathological');
        $data['hereditary']       = $this->input->post('hereditary');
        $data['obstetrics']       = $this->input->post('obstetrics');
        $data['psychiatric']      = $this->input->post('psychiatric');
        $data['diet']             = $this->input->post('diet');
        $data['vaccination']      = $this->input->post('vaccination');
        $data['perinatal']        = $this->input->post('perinatal');
        $data['postnatal']        = $this->input->post('postnatal');
        $data['sistema_m']        = $this->input->post('sistema');
        log_message('error',  $this->input->post('sistema'));
        
        if($this->input->post('signs') == 1)
        {
            if($this->input->post('height') == 0 && $this->input->post('weight') == 0 && $this->input->post('temperature') == 0 && $this->input->post('frequency') == 0 && $this->input->post('systolic') == 0 && $this->input->post('diastolic') == 0 && $this->input->post('heart') == 0 && $this->input->post('mass') == 0 && $this->input->post('percentage') == 0 && $this->input->post('muscle') == 0 && $this->input->post('head') == 0 && $this->input->post('saturation') == 0){
                $data['signs']            = 0;
               
                $data['height']           = $this->input->post('height');
                $data['weight']           = $this->input->post('weight');
                $data['temperature']      = $this->input->post('temperature');
                $data['frequency']        = $this->input->post('frequency');
                $data['systolic']         = $this->input->post('systolic');
                $data['diastolic']        = $this->input->post('diastolic');
                $data['heart']            = $this->input->post('heart');
                $data['mass']             = $this->input->post('mass');
                $data['percentage']       = $this->input->post('percentage');
                $data['muscle']           = $this->input->post('muscle');
                $data['head']             = $this->input->post('head');
                $data['saturation']       = $this->input->post('saturation');}
            else{
                $data['signs']            = $this->input->post('signs');
                $data['height']           = $this->input->post('height');
                $data['weight']           = $this->input->post('weight');
                $data['temperature']      = $this->input->post('temperature');
                $data['frequency']        = $this->input->post('frequency');
                $data['systolic']         = $this->input->post('systolic');
                $data['diastolic']        = $this->input->post('diastolic');
                $data['heart']            = $this->input->post('heart');
                $data['mass']             = $this->input->post('mass');
                $data['percentage']       = $this->input->post('percentage');
                $data['muscle']           = $this->input->post('muscle');
                $data['head']             = $this->input->post('head');
                $data['saturation']       = $this->input->post('saturation');}
            
            }
        if($this->input->post('signs') == 0){
            $data['signs']            = $this->input->post('signs');
            $data['height']           = 0;
            $data['weight']           = 0;
            $data['temperature']      = 0;
            $data['frequency']        = 0;
            $data['systolic']         = 0;
            $data['diastolic']        = 0;
            $data['heart']            = 0;
            $data['mass']             = 0;
            $data['percentage']       = 0;
            $data['muscle']           = 0;
            $data['head']             = 0;
            $data['saturation']       = 0;}
            
            
        if($this->input->post('labs') == 1){
            if( $this->input->post('erythrocytes') == 0 && $this->input->post('hematocrit') == 0 && $this->input->post('hemoglobin') == 0 && $this->input->post('blood_cells') == 0 && $this->input->post('platelets') == 0 && $this->input->post('reticulocytes') == 0 && $this->input->post('nitrogen') == 0 && $this->input->post('co2') == 0 && $this->input->post('chloride') == 0 && $this->input->post('potassium') == 0 && $this->input->post('sodium') == 0 && $this->input->post('glucose') == 0 && $this->input->post('creatinine') == 0 && $this->input->post('calcium') == 0 && $this->input->post('cholesterol') == 0 && $this->input->post('vldl') == 0 && $this->input->post('ldl') == 0 && $this->input->post('hdl') == 0 && $this->input->post('triglycerides') == 0){
                $data['labs']             = 0;
                $data['erythrocytes']     = $this->input->post('erythrocytes');
                $data['hematocrit']       = $this->input->post('hematocrit');
                $data['hemoglobin']       = $this->input->post('hemoglobin');
                $data['blood_cells']      = $this->input->post('blood_cells');
                $data['platelets']        = $this->input->post('platelets');
                $data['reticulocytes']    = $this->input->post('reticulocytes');
                $data['nitrogen']         = $this->input->post('nitrogen');
                $data['co2']              = $this->input->post('co2');
                $data['chloride']         = $this->input->post('chloride');
                $data['potassium']        = $this->input->post('potassium');
                $data['sodium']           = $this->input->post('sodium');
                $data['glucose']          = $this->input->post('glucose');
                $data['creatinine']       = $this->input->post('creatinine');
                $data['calcium']          = $this->input->post('calcium');
                $data['cholesterol']      = $this->input->post('cholesterol');
                $data['vldl']             = $this->input->post('vldl');
                $data['ldl']              = $this->input->post('ldl');
                $data['hdl']              = $this->input->post('hdl');
                $data['triglycerides']    = $this->input->post('triglycerides');}
            else{
                $data['labs']             = $this->input->post('labs');
                $data['erythrocytes']     = $this->input->post('erythrocytes');
                $data['hematocrit']       = $this->input->post('hematocrit');
                $data['hemoglobin']       = $this->input->post('hemoglobin');
                $data['blood_cells']      = $this->input->post('blood_cells');
                $data['platelets']        = $this->input->post('platelets');
                $data['reticulocytes']    = $this->input->post('reticulocytes');
                $data['nitrogen']         = $this->input->post('nitrogen');
                $data['co2']              = $this->input->post('co2');
                $data['chloride']         = $this->input->post('chloride');
                $data['potassium']        = $this->input->post('potassium');
                $data['sodium']           = $this->input->post('sodium');
                $data['glucose']          = $this->input->post('glucose');
                $data['creatinine']       = $this->input->post('creatinine');
                $data['calcium']          = $this->input->post('calcium');
                $data['cholesterol']      = $this->input->post('cholesterol');
                $data['vldl']             = $this->input->post('vldl');
                $data['ldl']              = $this->input->post('ldl');
                $data['hdl']              = $this->input->post('hdl');
                $data['triglycerides']    = $this->input->post('triglycerides');}}
            if($this->input->post('labs') == 0){
                $data['labs']             = $this->input->post('labs');
                $data['erythrocytes']     = 0;
                $data['hematocrit']       = 0;
                $data['hemoglobin']       = 0;
                $data['blood_cells']      = 0;
                $data['platelets']        = 0;
                $data['reticulocytes']    = 0;
                $data['nitrogen']         = 0;
                $data['co2']              = 0;
                $data['chloride']         = 0;
                $data['potassium']        = 0;
                $data['sodium']           = 0;
                $data['glucose']          = 0;
                $data['creatinine']       = 0;
                $data['calcium']          = 0;
                $data['cholesterol']      = 0;
                $data['vldl']             = 0;
                $data['ldl']              = 0;
                $data['hdl']              = 0;
                $data['triglycerides']    = 0;}

        if($this->input->post('nutri') == 1){
            if($this->input->post('lost_weight') == 0 && $this->input->post('water') == 0 && $this->input->post('grease') == 0 && $this->input->post('nutri_muscle') == 0 && $this->input->post('waist') == 0 && $this->input->post('abdomen') == 0){
                $data['nutri']            = 0;    
                $data['lost_weight']      = $this->input->post('lost_weight');    
                $data['water']            = $this->input->post('water');    
                $data['grease']           = $this->input->post('grease');    
                $data['nutri_muscle']     = $this->input->post('nutri_muscle');    
                $data['waist']            = $this->input->post('waist');    
                $data['abdomen']          = $this->input->post('abdomen');}
             else{
                $data['nutri']            = $this->input->post('nutri');    
                $data['lost_weight']      = $this->input->post('lost_weight');    
                $data['water']            = $this->input->post('water');    
                $data['grease']           = $this->input->post('grease');    
                $data['nutri_muscle']     = $this->input->post('nutri_muscle');    
                $data['waist']            = $this->input->post('waist');    
                $data['abdomen']          = $this->input->post('abdomen');}}
            if($this->input->post('nutri') == 0){
                $data['nutri']            = $this->input->post('nutri');
                $data['lost_weight']      = 0;    
                $data['water']            = 0;    
                $data['grease']           = 0;    
                $data['nutri_muscle']     = 0;    
                $data['waist']            = 0;    
                $data['abdomen']          = 0;}
        
        if($this->input->post('cetosis') == 1){
            if($this->input->post('satiety') == 0 && $this->input->post('halitosis') == 0 && $this->input->post('cramps') == 0 && $this->input->post('hungry') == 0 && $this->input->post('diarrhea') == 0 && $this->input->post('sleeping') == 0 && $this->input->post('depressed') == 0 && $this->input->post('impatient') == 0 && $this->input->post('tolerance') == 0 && $this->input->post('estimulantes') == 0 && $this->input->post('constipation') == 0 && $this->input->post('migraine') == 0 && $this->input->post('vertigo') == 0 && $this->input->post('fatigue') == 0 && $this->input->post('anxiety') == 0 && $this->input->post('concentration') == 0 && $this->input->post('irritability') == 0 && $this->input->post('aggressiveness') == 0 && $this->input->post('impulse') == 0){
            $data['cetosis']          = 0;    
            $data['satiety']          = $this->input->post('satiety');    
            $data['halitosis']        = $this->input->post('halitosis');    
            $data['cramps']           = $this->input->post('cramps');    
            $data['hungry']           = $this->input->post('hungry');    
            $data['diarrhea']         = $this->input->post('diarrhea');    
            $data['sleeping']         = $this->input->post('sleeping');    
            $data['depressed']        = $this->input->post('depressed');    
            $data['impatient']        = $this->input->post('impatient');    
            $data['tolerance']        = $this->input->post('tolerance');    
            $data['estimulantes']     = $this->input->post('estimulantes');    
            $data['constipation']     = $this->input->post('constipation');    
            $data['migraine']         = $this->input->post('migraine');    
            $data['vertigo']          = $this->input->post('vertigo');    
            $data['fatigue']          = $this->input->post('fatigue');    
            $data['anxiety']          = $this->input->post('anxiety');    
            $data['concentration']    = $this->input->post('concentration');    
            $data['irritability']     = $this->input->post('irritability');    
            $data['aggressiveness']   = $this->input->post('aggressiveness');    
            $data['impulse']          = $this->input->post('impulse');}    
        else{
            $data['cetosis']          = $this->input->post('cetosis');    
            $data['satiety']          = $this->input->post('satiety');    
            $data['halitosis']        = $this->input->post('halitosis');    
            $data['cramps']           = $this->input->post('cramps');    
            $data['hungry']           = $this->input->post('hungry');    
            $data['diarrhea']         = $this->input->post('diarrhea');    
            $data['sleeping']         = $this->input->post('sleeping');    
            $data['depressed']        = $this->input->post('depressed');    
            $data['impatient']        = $this->input->post('impatient');    
            $data['tolerance']        = $this->input->post('tolerance');    
            $data['estimulantes']     = $this->input->post('estimulantes');    
            $data['constipation']     = $this->input->post('constipation');    
            $data['migraine']         = $this->input->post('migraine');    
            $data['vertigo']          = $this->input->post('vertigo');    
            $data['fatigue']          = $this->input->post('fatigue');    
            $data['anxiety']          = $this->input->post('anxiety');    
            $data['concentration']    = $this->input->post('concentration');    
            $data['irritability']     = $this->input->post('irritability');    
            $data['aggressiveness']   = $this->input->post('aggressiveness');    
            $data['impulse']          = $this->input->post('impulse');}}
        if($this->input->post('cetosis') == 0){
            $data['cetosis']          = 0;
            $data['satiety']          = 0;    
            $data['halitosis']        = 0;    
            $data['cramps']           = 0;    
            $data['hungry']           = 0;    
            $data['diarrhea']         = 0;    
            $data['sleeping']         = 0;    
            $data['depressed']        = 0;    
            $data['impatient']        = 0;    
            $data['tolerance']        = 0;    
            $data['estimulantes']     = 0;    
            $data['constipation']     = 0;    
            $data['migraine']         = 0;    
            $data['vertigo']          = 0;    
            $data['fatigue']          = 0;    
            $data['anxiety']          = 0;    
            $data['concentration']    = 0;    
            $data['irritability']     = 0;
            $data['aggressiveness']   = 0;
            $data['impulse']          = 0;}
        
        $data['odonto']           = $this->input->post('odonto');    
        $data['trata']            = $this->input->post('trata'); 
        $data['teleconsulta']     = $this->input->post('teleconsulta');    
        
        $this->db->where('clinic_id', $this->session->userdata('current_clinic'));
        $this->db->update('clinic', $data);
    }
    
    function getMin()
    {
        $time = explode(':',$this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->morning);
        $ex_time = $time[0];
        if($ex_time < 10){
            $return = str_replace('0','', $ex_time);
        }else{
            $return = $ex_time;
        }
        echo $return;
    }
    
    function getMax()
    {
        $time = explode(':',$this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->b_afternoon);
        $ex_time = $time[0];
        if($ex_time < 10){
            $return = str_replace('0','', $ex_time);
        }else{
            $return = $ex_time;
        }
        echo $return;
    }
    
    function get_service($service_id)
    {
        return $this->db->get_where('service', array('service_id' => $service_id))->row()->name;
    }
    
    function check_online_status($user_type, $user_id)
    {
        $this->db->group_by('gp');
        $this->db->where('gp', $user_id."-".$user_type);
        return $usuarios = $this->db->get('online_users')->num_rows();
    }
    
    function create_clinic()
    {
        $morning            = $this->set_24hrs($this->input->post('morning'));
        $b_morning          = $this->set_24hrs($this->input->post('b_morning'));
        $afternoon          = $this->set_24hrs($this->input->post('afternoon'));
        $b_afternoon        = $this->set_24hrs($this->input->post('b_afternoon'));
        $code               = $this->crud_model->getCode();
        $first_name         = $this->db->get_where('admin',array('admin_id'=>$this->session->userdata('login_user_id')))->row()->first_name;
        $second_name        = $this->db->get_where('admin',array('admin_id'=>$this->session->userdata('login_user_id')))->row()->second_name;
        $third_name         = $this->db->get_where('admin',array('admin_id'=>$this->session->userdata('login_user_id')))->row()->third_name;
        $last_name          = $this->db->get_where('admin',array('admin_id'=>$this->session->userdata('login_user_id')))->row()->last_name;
        $second_last_name   = $this->db->get_where('admin',array('admin_id'=>$this->session->userdata('login_user_id')))->row()->second_last_name;
        $married_last_name  = $this->db->get_where('admin',array('admin_id'=>$this->session->userdata('login_user_id')))->row()->married_last_name;
        $phone              = $this->db->get_where('admin',array('admin_id'=>$this->session->userdata('login_user_id')))->row()->phone;
        $email              = $this->db->get_where('admin',array('admin_id'=>$this->session->userdata('login_user_id')))->row()->email;
        $address            = $this->db->get_where('admin',array('admin_id'=>$this->session->userdata('login_user_id')))->row()->address;



        $code= $this->db->get_where('clinic',array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->code;


        $dataUpdate['name']              = $this->input->post('name');
        $dataUpdate['address']           = $this->input->post('address');
        $dataUpdate['email']             = $this->input->post('email');
        $dataUpdate['phone']             = $this->input->post('phone');
        $dataUpdate['morning']           = $morning;
        $dataUpdate['b_morning']         = $b_morning;
        $dataUpdate['afternoon']         = $afternoon;
        $dataUpdate['b_afternoon']       = $b_afternoon;
        $dataUpdate['time_interval']     = $this->input->post('interval');
        $dataUpdate['theme']             = '#0044E9';
        $dataUpdate['currency']          = 'Q';
        $dataUpdate['first_name']        = $first_name;
        $dataUpdate['second_name']       = $second_name;
        $dataUpdate['third_name']        = $third_name;
        $dataUpdate['last_name']         = $last_name;
        $dataUpdate['second_last_name']  = $second_last_name;
        $dataUpdate['married_last_name'] = $married_last_name;
        $dataUpdate['phonex']            = $phone;
        $dataUpdate['emailx']            = $email;
        $dataUpdate['addressx']          = $address;
        $dataUpdate['code']              = $code;

        $result = $this->send_api_create($dataUpdate);
        
        $data['name']          = $this->input->post('name');
        $data['address']       = $this->input->post('address');
        $data['email']         = $this->input->post('email');
        $data['phone']         = $this->input->post('phone');
        $data['morning']       = $morning;
        $data['b_morning']     = $b_morning;
        $data['afternoon']     = $afternoon;
        $data['b_afternoon']   = $b_afternoon;
        $data['time_interval'] = $this->input->post('interval');
        $data['theme']         = '#0044E9';
        $data['logo']         = "default_clinc.png";
        $data['status']        = 1;
        $data['code']          = $code;
        $this->db->insert('clinic', $data);
        $clinic_id = $this->db->insert_id();
        $this->log_model->create_clinic($clinic_id); 
    }
    
    function send_api_create($data_array){
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
        CURLOPT_URL =>"https://medicaby.com/api/createClinic",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data_array,
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    return $response; 
    }
    
    function delete_clinic($clinic_id)
    {
        $this->log_model->delete_clinic($clinic_id);
        
        //Agregar que se elimen todas las cosas relacionadas a esta clinica.
        $data['status'] = 0;
        $this->db->where('clinic_id',$clinic_id);
        $this->db->update('clinic', $data);
    }
    
    function update_clinic($clinic_id)
    {
        $morning        = $this->set_24hrs($this->input->post('morning'));
        $b_morning      = $this->set_24hrs($this->input->post('b_morning'));
        $afternoon      = $this->set_24hrs($this->input->post('afternoon'));
        $b_afternoon    = $this->set_24hrs($this->input->post('b_afternoon'));
        $code= $this->db->get_where('clinic',array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->code;

        $dataUpdate['name']          = $this->input->post('name');
        $dataUpdate['address']       = $this->input->post('address');
        $dataUpdate['email']         = $this->input->post('email');
        $dataUpdate['phone']         = $this->input->post('phone');
        $dataUpdate['morning']       = $morning;
        $dataUpdate['b_morning']     = $b_morning;
        $dataUpdate['afternoon']     = $afternoon;
        $dataUpdate['b_afternoon']   = $b_afternoon;
        $dataUpdate['time_interval'] = $this->input->post('interval');
        $dataUpdate['code']=$code;
        $result = $this->send_api_hrs($dataUpdate);

        $data['name']          = $this->input->post('name');
        $data['address']       = $this->input->post('address');
        $data['email']         = $this->input->post('email');
        $data['phone']         = $this->input->post('phone');
        $data['morning']       = $morning;
        $data['b_morning']     = $b_morning;
        $data['afternoon']     = $afternoon;
        $data['b_afternoon']   = $b_afternoon;
        $data['time_interval'] = $this->input->post('interval');
        $this->db->where('clinic_id',$clinic_id);
        $this->db->update('clinic', $data);
    }
    function send_api_hrs($data_array){
        /* $domain= $this->db->get_where('clinic',array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->domain;
        log_message('error', $domain); */

        $curl = curl_init();
    
        curl_setopt_array($curl, array(
        CURLOPT_URL =>"https://medicaby.com/api/updateHrsContract",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data_array,
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    return $response; 
    }

    function set_24hrs($hour)
    {
        $New_hr    = date('H:i', strtotime($hour));
        return $New_hr;
    }

    function interval($start, $end, $interval) 
    {
        $start  = new DateTime($start);
        $end    = new DateTime($end);
        $end->modify('+1 second'); // Añadimos 1 segundo para que nos muestre hora fin.
        // Si la hora de inicio es superior a la hora fin
        // añadimos un día más a la hora fin
        if ($start > $end) 
        {        
            $end->modify('+1 day');
        }
        // Establecemos el intervalo en minutos        
        $interval = new DateInterval('PT'.$interval.'M');
        // Sacamos los periodos entre las horas
        $periodo   = new DatePeriod($start, $interval, $end);        
        foreach( $periodo as $hora ) 
        {
            // Guardamos las horas intervalos 
            $hours[] =  $hora->format('H:i');
        }
        return $hours;
    }
    
    function formatear($fecha)
    {
        $date = explode("/", $fecha);
        $dia  = $date[0];
        $mes  = $date[1];
        $anio = $date[2];
        $string_month = "";
        
        if($mes == '01'){
            $string_month = "Enero";
        }elseif($mes == '02'){
            $string_month = "Febrero";
        }
        elseif($mes == '03'){
            $string_month = "Marzo";
        }
        elseif($mes == '04'){
            $string_month = "Abril";
        }
        elseif($mes == '05'){
            $string_month = "Mayo";
        }
        elseif($mes == '06'){
            $string_month = "Junio";
        }
        elseif($mes == '07'){
            $string_month = "Julio";
        }
        elseif($mes == '08'){
            $string_month = "Agosto";
        }
        elseif($mes == '09'){
            $string_month = "Septiembre";
        }
        elseif($mes == '10'){
            $string_month = "Octubre";
        }
        elseif($mes == '11'){
            $string_month = "Noviembre";
        }
        elseif($mes == '12'){
            $string_month = "Diciembre";
        }
        
        return $dia. " ".$string_month;
    }
    
    function formatear2($fecha)
    {
        if($fecha != '')
            {
                    $date = explode("/", $fecha);

                    $dia  = $date[0];
                    $mes  = $date[1];
                    $anio = $date[2];
                    $string_month = "";
                    
                    if($mes == '01'){
                        $string_month = "Enero";
                    }elseif($mes == '02'){
                        $string_month = "Febrero";
                    }
                    elseif($mes == '03'){
                        $string_month = "Marzo";
                    }
                    elseif($mes == '04'){
                        $string_month = "Abril";
                    }
                    elseif($mes == '05'){
                        $string_month = "Mayo";
                    }
                    elseif($mes == '06'){
                        $string_month = "Junio";
                    }
                    elseif($mes == '07'){
                        $string_month = "Julio";
                    }
                    elseif($mes == '08'){
                        $string_month = "Agosto";
                    }
                    elseif($mes == '09'){
                        $string_month = "Septiembre";
                    }
                    elseif($mes == '10'){
                        $string_month = "Octubre";
                    }
                    elseif($mes == '11'){
                        $string_month = "Noviembre";
                    }
                    elseif($mes == '12'){
                        $string_month = "Diciembre";
                    }
                    
                    if($dia > 0 && $string_month != '' && $anio > 0)
                    {
                        return $dia. " de ".$string_month." del ".$anio;
                    }
            
                    else
                    {
                        return 'Sin registros';    
                    }
    }else
    {

        return 'Sin registros';    

    }
        
    }
    
    
    
    
    function setFormat($fecha)
    {
        $date = explode("/", $fecha);
        $dia  = $date[0];
        $mes  = $date[1];
        $anio = $date[2];
        $string_month = "";
        $string_day   = "";
        $string_month = $mes;
        $string_day = $dia;
        return $string_month."/".$string_day.'/'.$anio;
    }


    
    function panelDate()
    {
        $dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
        return $dias;
    }
    
    function formatDate()
    {
        $dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        return date('d')." de ".$meses[date('n')-1]." ".date('H:iA');
    }
    
    function formatDates()
    {
        $dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        return date('d')." de ".$meses[date('n')-1];
    }
    
    function create_service()
    {
        $data['clinic_id']   = $this->session->userdata('current_clinic');
        $data['name']        = $this->input->post('name');
        $data['cost']        = $this->input->post('cost');
        $data['description'] = $this->input->post('description');
        $this->db->insert('service',$data);
        $service_id = $this->db->insert_id();
        $this->log_model->new_service($service_id);
    }
    
    function update_service($service_id)
    {
        $data['name']            = $this->input->post('name');
        $data['cost']            = $this->input->post('cost');
        $data['description']     = $this->input->post('description');
        $this->db->where('service_id',$service_id);
        $this->db->update('service', $data);
    }
    
    function delete_service($service_id)
    {
        $this->db->where('service_id', $service_id);
        $this->db->delete('service');
    }

    function create_process()
    {
        $data['clinic_id']   = $this->session->userdata('current_clinic');
        $data['name']        = $this->input->post('name');
        $data['cost']        = $this->input->post('cost');
        $data['price']        = $this->input->post('price');
        $this->db->insert('process',$data);
      
    }
    
    function update_process($process_id)
    {
        $data['name']            = $this->input->post('name');
        $data['cost']            = $this->input->post('cost');
        $data['price']           = $this->input->post('price');
        $this->db->where('process_id',$process_id);
        $this->db->update('process', $data);
    }
    
    function delete_process($process_id)
    {
        $data['status'] = 0;
        $this->db->where('process_id',$process_id);
        $this->db->update('process', $data);
    }
 
    function create_specialtie()
    {
        $data['clinic_id']   = $this->session->userdata('current_clinic');
        $data['name']        = $this->input->post('name');
        $this->db->insert('specialtie', $data);
        $special_id = $this->db->insert_id();
        $this->log_model->create_special($special_id);
    }
    
    function update_specialtie($specialtie_id)
    {
        $data['name']  = $this->input->post('name');
        $this->db->where('specialtie_id',$specialtie_id);
        $this->db->update('specialtie', $data);
    }
    
       
    function delete_specialtie($specialtie_id)
    {
        $this->log_model->delete_special($specialtie_id);
        
        $this->db->where('specialtie_id', $specialtie_id);
        $this->db->delete('specialtie');
    }
    
    function create_laboratory()
    {
        $data['clinic_id']   = $this->session->userdata('current_clinic');
        $data['name']        = $this->input->post('name');
        $data['phone']       = $this->input->post('phone');
        $data['address']     = $this->input->post('address');
        $this->db->insert('laboratory', $data);
        $lab_id = $this->db->insert_id();
        $this->log_model->create_laboratory($lab_id);
    }
    
    function update_laboratory($laboratory_id)
    {
        $data['clinic_id']      = $this->session->userdata('current_clinic');
        $data['name']           = $this->input->post('name');
        $data['phone']          = $this->input->post('phone');
        $data['address']        = $this->input->post('address');
        $this->db->where('laboratory_id',$laboratory_id);
        $this->db->update('laboratory', $data);
    }
    
    function delete_laboratory($laboratory_id)
    {
        $this->log_model->delete_lab($laboratory_id);
        $this->db->where('laboratory_id', $laboratory_id);
        $this->db->delete('laboratory');
    }
    
    function create_third()
    {
        $data['clinic_id']   = $this->session->userdata('current_clinic');
        $data['name']        = $this->input->post('name');
        $data['phone']       = $this->input->post('phone');
        $data['address']     = $this->input->post('address');
        $data['type']     = $this->input->post('type');
        $data['email']     = $this->input->post('email');
        $this->db->insert('third', $data);
        $lab_id = $this->db->insert_id();
        $this->log_model->create_laboratory($lab_id);
    }
    
    function update_third($laboratory_id)
    {
        $data['clinic_id']      = $this->session->userdata('current_clinic');
        $data['name']           = $this->input->post('name');
        $data['phone']          = $this->input->post('phone');
        $data['address']     = $this->input->post('address');
        $data['type']     = $this->input->post('type');
        $data['email']     = $this->input->post('email');
        $this->db->where('terceros_id',$laboratory_id);
        $this->db->update('third', $data);
    }
    
    function delete_third($laboratory_id)
    {
        $this->log_model->delete_lab($laboratory_id);
        $this->db->where('terceros_id', $laboratory_id);
        $this->db->delete('terceros');
    }
    
    function getProductImage($productId){
        $image = $this->db->get_where('product', array('product_id' => $productId))->row()->image;
        if($image != ''){
            return base_url().'public/uploads/inventory/'.$image;
        }else{
            return base_url().'public/uploads/img.png';
        }
    }
    
    
    function create_inventory()
    {
        
        $md5 = md5(date('d-m-Y H:i:s'));
        $name = $md5.str_replace(' ', '', $_FILES['image']['name']);
        $data['name']               = $this->input->post('name');
        $data['code']               = $this->input->post('code');
        $data['category_id']        = $this->input->post('category_id');
        $data['cost']               = $this->input->post('cost');
        $data['price']              = $this->input->post('price');
        $data['expiration_date']    = $this->input->post('expiration_date');
        $data['stock']              = $this->input->post('stock');
        $data['amount_alert']       = $this->input->post('amount_alert');
        $data['image']              = $name;
        $data['description']        = $this->input->post('description');
        $data['clinic_id']          = $this->session->userdata('current_clinic');
        $this->db->insert('product', $data);
        $product_id = $this->db->insert_id();
        move_uploaded_file($_FILES['image']['tmp_name'], 'public/uploads/inventory/' . $name);
        $this->log_model->new_product($product_id);
    }
    
    function update_inventory($product_id)
    {
        $md5 = md5(date('d-m-Y H:i:s'));
        $name = $md5.str_replace(' ', '', $_FILES['image']['name']);
        if($_FILES['image']['name'] != ''){
            $data['image']              = $name;
        }
        $data['name']               = $this->input->post('name');
        $data['code']               = $this->input->post('code');
        $data['category_id']        = $this->input->post('category_id');
        $data['cost']               = $this->input->post('cost');
        $data['price']              = $this->input->post('price');
        $data['expiration_date']    = $this->input->post('expiration_date');
        $data['stock']              = $this->input->post('stock');
        $data['amount_alert']       = $this->input->post('amount_alert');
        $data['description']        = $this->input->post('description');
        move_uploaded_file($_FILES['image']['tmp_name'], 'public/uploads/inventory/' . $name);
        $this->db->where('product_id',$product_id);
        $this->db->update('product', $data);
        $this->log_model->update_product($product_id);
    }
    
    function delete_inventory($product_id)
    {
        $this->log_model->delete_product($product_id);
        $this->db->where('product_id', $product_id);
        $this->db->delete('product');
    }
    
    function create_category()
    {
        $data['name']        = $this->input->post('name');
        $data['description'] = $this->input->post('description');
        $data['clinic_id']          = $this->session->userdata('current_clinic');
        return $this->db->insert('category',$data);
    }
    
    function update_category($category_id)
    {
        $data['clinic_id']          = $this->session->userdata('current_clinic');
        $data['name']               = $this->input->post('name');
        $data['description']        = $this->input->post('description');
        $this->db->where('category_id',$category_id);
        $this->db->update('category', $data);
    }
    
    function delete_category($category_id)
    {
        $this->db->where('category_id', $category_id);
        $this->db->delete('category');
    }
    
    function create_survey()
    {
        $data['clinic_id']   = $this->session->userdata('current_clinic');
        $data['title']       = $this->input->post('title');
        $data['admin_id']    = $doctor_id;
        $data['status']      = 1;
        $data['date']        = date('d/m/Y'); 
        $data['description'] = $this->input->post('description');
        $this->db->insert('survey',$data);
        $survey_id = $this->db->insert_id();
        $this->log_model->new_survey($survey_id);
        return $survey_id;
    }
    
    function update_survey($survey_id)
    {
        $data['title']            = $this->input->post('title');
        $data['description']      = $this->input->post('survey');
        $this->db->where('survey_id',$survey_id);
        $this->db->update('survey', $data);
    }
    
    function delete_survey($survey_id)
    {
        $this->db->where('survey_id', $survey_id);
        $this->db->delete('survey');
        $this->db->where('survey_id', $survey_id);
        $this->db->delete('question');
        $this->db->where('survey_id', $survey_id);
        $this->db->delete('survery_result');
    }
    
    
    function create_multiple_choice($survey_id)
    {
        $data['question']             = $this->input->post('question');
        $data['number_of_options']    = count($this->input->post('options'));
        $data['options']              = json_encode($this->input->post('options'));
        $data['type']                 = 'multiple_choice'; 
        $data['survey_id']            = $survey_id;
        $this->db->insert('question',$data);
        
    }
    
    
    function delete_question($question_id)
    {
        $this->db->where('question_id', $question_id);
        $this->db->delete('question');
    }
    
    function delete_questions($survey_id)
    {
        $this->db->where('survey_id', $survey_id);
        $this->db->delete('question');
    }
    
    function update_multiple_choice($question_id)
    {
        $data['question']             = $this->input->post('question');
        $data['number_of_options']    = count($this->input->post('options'));
        $data['options']              = json_encode($this->input->post('options'));
        $this->db->where('question_id',$question_id);
        $this->db->update('question', $data);
    }
    
     function create_text($survey_id)
    {
        $data['question']             = $this->input->post('question');
        $data['type']                 = 'text'; 
        $data['survey_id']            = $survey_id;
        $this->db->insert('question',$data);
        
    }
     function create_satisfaction($survey_id)
    {
        $data['question']             = $this->input->post('question');
        $data['type']                 = 'satisfaction'; 
        $data['survey_id']            = $survey_id;
        $this->db->insert('question',$data);
        
    }
    function update_question($question_id)
    {
        $data['question']    = $this->input->post('question');
        $this->db->where('question_id',$question_id);
        $this->db->update('question', $data);
    }
    
    
    function create_income()
    {






         include('public/apis/class.fileuploader.php');
        
        $FileUploader_reference_file = new FileUploader('reference_file', array('uploadDir' => 'public/uploads/income_image/'));
    	$upload_reference_file = $FileUploader_reference_file->upload();
    	if($upload_reference_file['isSuccess']) {
        	$files = $upload_reference_file['files'];
    	} else {
        	$warningss = $upload_reference_file['warnings'];
    	}
    	
    	$FileUploader_invoice_file = new FileUploader('invoice_file', array('uploadDir' => 'public/uploads/income_image/'));
    	$upload_invoice_file = $FileUploader_invoice_file->upload();
    	if($upload_invoice_file['isSuccess']) {
        	$files = $upload_invoice_file['files'];
    	} else {
        	$warningss = $upload_invoice_file['warnings'];
    	}
        
        if($_FILES['reference_file']['name'] != "")
        {$data['reference_file']    = $upload_reference_file['files'][0]['name'];}
        if($_FILES['invoice_file']['name'] != "")
        {$data['invoice_file']      = $upload_invoice_file['files'][0]['name'];}
        $data['clinic_id']          = $this->session->userdata('current_clinic');
        $data['user_id']            = $doctor_id;
        $data['user_type']          = $this->session->userdata('login_type');
        $data['description']        = $this->input->post('description');
        $data['amount']             = $this->input->post('amount');
        $data['method']             = $this->input->post('method');
        $data['reference']          = $this->input->post('reference');
        $data['invoice']            = $this->input->post('invoice');
        $data['invoice_code']       = $this->input->post('invoice_code');
        $data['patient_id']         = $this->input->post('patient_id');
        $data['appointment_id']     = $this->input->post('appointment_id');
        $data['date']               = date('d/m/Y');
        $data['time']               = date('H:m');
        
        
        $this->db->insert('financial',$data);



        move_uploaded_file($_FILES['reference_file']['tmp_name'], 'public/uploads/income_image/' . $md5.str_replace(' ', '', $_FILES['reference_file']['name']));
        move_uploaded_file($_FILES['invoice_file']['tmp_name'], 'public/uploads/income_image/' . $md5.str_replace(' ', '', $_FILES['invoice_file']['name']));
        $this->log_model->create_income($this->input->post('amount'));
        $this->notify_model->new_income();






    }


    function create_financial()
    {
        if($this->input->post('type') == 1)
        {

            $md5 = md5(date('d-m-Y H:i:s'));
            include('public/apis/class.fileuploader.php');
            
            $FileUploader_reference_file = new FileUploader('reference_file', array('uploadDir' => 'public/uploads/income_image/'));
            $upload_reference_file = $FileUploader_reference_file->upload();
            if($upload_reference_file['isSuccess']) {
                $files = $upload_reference_file['files'];
            } else {
                $warningss = $upload_reference_file['warnings'];
            }
            
            $FileUploader_invoice_file = new FileUploader('invoice_file', array('uploadDir' => 'public/uploads/income_image/'));
            $upload_invoice_file = $FileUploader_invoice_file->upload();
            if($upload_invoice_file['isSuccess']) {
                $files = $upload_invoice_file['files'];
            } else {
                $warningss = $upload_invoice_file['warnings'];
            }
            
            if(!empty($upload_reference_file['files']))
            {
                $data['reference_file']    = $upload_reference_file['files'][0]['name'];
                move_uploaded_file($_FILES['reference_file']['tmp_name'], 'public/uploads/income_image/' . $md5.str_replace(' ', '', $_FILES['reference_file']['name']));
            }
            if(!empty($upload_invoice_file['files']))
            {
                $data['invoice_file']      = $upload_invoice_file['files'][0]['name'];
                move_uploaded_file($_FILES['invoice_file']['tmp_name'], 'public/uploads/income_image/' . $md5.str_replace(' ', '', $_FILES['invoice_file']['name']));
            }
            $data['clinic_id']          = $this->session->userdata('current_clinic');
            $data['user_id']            = $this->session->userdata('login_user_id');
            $data['user_type']          = $this->session->userdata('login_type');
            $data['description']        = $this->input->post('description');
            $data['amount']             = $this->input->post('amount');
            $data['method']             = $this->input->post('method');
            $data['reference']          = $this->input->post('reference');
            $data['invoice']            = $this->input->post('invoice');
            $data['type']            = $this->input->post('type');
            $data['invoice_code']       = $this->input->post('invoice_code');
            $data['date']               = date('d/m/Y');
            $data['time']               = date('H:m');
            
            
            $this->db->insert('financial',$data);
            $this->log_model->create_income($this->input->post('amount'));
            $this->notify_model->new_income();


        }

        if($this->input->post('type') == 0)
        {
            $md5 = md5(date('d-m-Y H:i:s'));
            include('public/apis/class.fileuploader.php');
            
            $FileUploader_reference_file = new FileUploader('reference_file', array('uploadDir' => 'public/uploads/income_image/'));
            $upload_reference_file = $FileUploader_reference_file->upload();
            if($upload_reference_file['isSuccess']) {
                $files = $upload_reference_file['files'];
            } else {
                $warningss = $upload_reference_file['warnings'];
            }
            
            $FileUploader_invoice_file = new FileUploader('invoice_file', array('uploadDir' => 'public/uploads/income_image/'));
            $upload_invoice_file = $FileUploader_invoice_file->upload();
            if($upload_invoice_file['isSuccess']) {
                $files = $upload_invoice_file['files'];
            } else {
                $warningss = $upload_invoice_file['warnings'];
            }
            
            if(!empty($upload_reference_file['files']))
            {
                $data['reference_file']    = $upload_reference_file['files'][0]['name'];
                move_uploaded_file($_FILES['reference_file']['tmp_name'], 'public/uploads/income_image/' . $md5.str_replace(' ', '', $_FILES['reference_file']['name']));
            }
            if(!empty($upload_invoice_file['files']))
            {
                $data['invoice_file']      = $upload_invoice_file['files'][0]['name'];
                move_uploaded_file($_FILES['invoice_file']['tmp_name'], 'public/uploads/income_image/' . $md5.str_replace(' ', '', $_FILES['invoice_file']['name']));
            }
            $data['clinic_id']          = $this->session->userdata('current_clinic');
            $data['user_id']            = $this->session->userdata('login_user_id');
            $data['user_type']          = $this->session->userdata('login_type');
            $data['description']        = $this->input->post('description');
            $data['amount']             = $this->input->post('amount');
            $data['method']             = $this->input->post('method');
            $data['reference']          = $this->input->post('reference');
            $data['invoice']            = $this->input->post('invoice');
            $data['invoice_code']       = $this->input->post('invoice_code');
            $data['date']               = date('d/m/Y');
            $data['time']               = date('H:m');
            $data['type']               = 0;
            
            
            
            $this->db->insert('financial',$data);
            $this->log_model->create_income($this->input->post('amount'));
            $this->notify_model->new_income();


        }
      


    }

    
    
    
    function delete_income($income_id)
    {
        $this->log_model->delete_income($income_id);
        $this->db->where('financial_id', $income_id);
        $this->db->delete('financial');
    }
    
    function update_income($income_id)
    {
        $md5 = md5(date('d-m-Y H:i:s'));
         include('public/apis/class.fileuploader.php');
        $this->log_model->update_income($income_id);
        $FileUploader_invoice_file = new FileUploader('invoice_file', array(
        	'uploadDir' => 'public/uploads/income_image/'));
        $upload_invoice_file = $FileUploader_invoice_file->upload();
        if($upload_invoice_file['isSuccess']) {
            $files = $upload_invoice_file['files'];
        } else {
            $warningss = $upload_invoice_file['warnings'];
        }
        
        $FileUploader_reference_file = new FileUploader('reference_file', array(
        	'uploadDir' => 'public/uploads/income_image/'));
        $upload_reference_file = $FileUploader_reference_file->upload();
        if($upload_reference_file['isSuccess']) {
            $files = $upload_reference_file['files'];
        } else {
            $warningss = $upload_reference_file['warnings'];
        }
        
        
        if($upload_reference_file['files'][0]['name'] != "")
        {
            $data['reference_file']         = $upload_reference_file['files'][0]['name'];
        }
        
        if($upload_invoice_file['files'][0]['name'] != "")
        {
            $data['invoice_file']         = $upload_invoice_file['files'][0]['name'];
        }
        $data['clinic_id']          = $this->session->userdata('current_clinic');
        $data['user_id']            = $doctor_id;
        $data['user_type']          = $this->session->userdata('login_type');
        $data['description']        = $this->input->post('description');
        $data['amount']             = $this->input->post('amount');
        $data['type']             = $this->input->post('type');
        $data['method']             = $this->input->post('method');
        $data['reference']          = $this->input->post('reference');
        $data['invoice']            = $this->input->post('invoice2');
        $data['invoice_code']       = $this->input->post('invoice_code');
        $this->db->where('financial_id',$income_id);
        $this->db->update('financial',$data);
        
        move_uploaded_file($_FILES['reference_file']['tmp_name'], 'public/uploads/income_image/' . $md5.str_replace(' ', '', $_FILES['reference_file']['name']));
        move_uploaded_file($_FILES['invoice_file']['tmp_name'], 'public/uploads/income_image/' . $md5.str_replace(' ', '', $_FILES['invoice_file']['name']));
    }
    
    
     function create_expense()
    {
        $md5 = md5(date('d-m-Y H:i:s'));
         include('public/apis/class.fileuploader.php');
        
        $FileUploader_reference_file = new FileUploader('reference_file', array('uploadDir' => 'uploads/expense_image/'));
    	$upload_reference_file = $FileUploader_reference_file->upload();
    	if($upload_reference_file['isSuccess']) {
        	$files = $upload_reference_file['files'];
    	} else {
        	$warningss = $upload_reference_file['warnings'];
    	}
    	 if($_FILES['reference_file']['name'] != "")
        {$data['reference_file']    = $upload_reference_file['files'][0]['name'];}
        $data['clinic_id']          = $this->session->userdata('current_clinic');
        $data['user_id']            = $doctor_id;
        $data['user_type']          = $this->session->userdata('login_type');
        $data['description']        = $this->input->post('description');
        $data['amount']             = $this->input->post('amount');
        $data['provider']           = $this->input->post('provider');
        $data['reference']          = $this->input->post('reference');
        $data['date']               = date('d/m/Y');
        $data['time']               = date('H:m');
        $data['expense_category_id']= $this->input->post('expense_category_id');
        $this->db->insert('expense',$data);
        $this->log_model->create_expense($this->input->post('amount'));
        move_uploaded_file($_FILES['reference_file']['tmp_name'], 'public/uploads/expense_image/' . $md5.str_replace(' ', '', $_FILES['reference_file']['name']));

    }
    
    
    
    function delete_expense($expense_id)
    {
        $this->log_model->delete_expense($expense_id);
        $this->db->where('expense_id', $expense_id);
        $this->db->delete('expense');
    }
    
    function update_expense($expense_id)
    {
         include('public/apis/class.fileuploader.php');
        $this->log_model->update_expense($expense_id);
        $FileUploader_reference_file = new FileUploader('reference_file', array(
        	'uploadDir' => 'public/uploads/expense_image/'));
        $upload_reference_file = $FileUploader_reference_file->upload();
        if($upload_reference_file['isSuccess']) {
            $files = $upload_reference_file['files'];
        } else {
            $warningss = $upload_reference_file['warnings'];
        }
        
        if($upload_reference_file['files'][0]['name'] != "")
        {
            $data['reference_file'] = $upload_reference_file['files'][0]['name'];
        }
        $data['clinic_id']          = $this->session->userdata('current_clinic');
        $data['user_id']            = $doctor_id;
        $data['user_type']          = $this->session->userdata('login_type');
        $data['description']        = $this->input->post('description');
        $data['amount']             = $this->input->post('amount');
        $data['provider']           = $this->input->post('provider');
        $data['reference']          = $this->input->post('reference');
        $data['expense_category_id']= $this->input->post('expense_category_id');
        $this->db->where('expense_id',$expense_id);
        $this->db->update('expense',$data);
        move_uploaded_file($_FILES['reference_file']['tmp_name'], 'uploads/expense_image/' . $md5.str_replace(' ', '', $_FILES['reference_file']['name']));
    }
    
     function create_expense_category()
    {
        $data['clinic_id']          = $this->session->userdata('current_clinic');
        $data['name']               = $this->input->post('name');
        $data['description']        = $this->input->post('description');
        $this->db->insert('expense_category',$data);
        $expense_id = $this->db->insert_id();
        $this->log_model->new_expense_category($expense_id);
    }
   
    
    function delete_expense_category($expense_category_id)
    {
        $this->db->where('expense_category_id', $expense_category_id);
        $this->db->delete('expense_category');
    }
    
    function update_expense_category($expense_category_id)
    {
        $data['clinic_id']          = $this->session->userdata('current_clinic');
        $data['name']               = $this->input->post('name');
        $data['description']        = $this->input->post('description');
        $this->db->where('expense_category_id',$expense_category_id);
        $this->db->update('expense_category',$data);
    }
    
    
    function delete_allergie($allergie_id)
    {
        $this->db->where('allergie_id', $allergie_id);
        $this->db->delete('allergie');
    }
    
    function create_pathological()
    {
        $data['hospitalization']                = $this->input->post('hospitalization');
        $data['hospitalization_comment']        = $this->input->post('hospitalization_comment');
        $data['surgeries']                      = $this->input->post('surgeries');
        $data['surgeries_comment']              = $this->input->post('surgeries_comment');
        $data['diabetes']                       = $this->input->post('diabetes');
        $data['diabetes_comment']               = $this->input->post('diabetes_comment');
        $data['thyroid']                        = $this->input->post('thyroid');
        $data['thyroid_comment']                = $this->input->post('thyroid_comment');
        $data['hypertension']                   = $this->input->post('hypertension');
        $data['hypertension_comment']           = $this->input->post('hypertension_comment');
        $data['heart_disease']                  = $this->input->post('heart_disease');
        $data['heart_disease_comment']          = $this->input->post('heart_disease_comment');
        $data['trauma']                         = $this->input->post('trauma');
        $data['trauma_comment']                 = $this->input->post('trauma_comment');
        $data['cancer']                         = $this->input->post('cancer');
        $data['cancer_comment']                 = $this->input->post('cancer_comment');
        $data['tuberculosis']                   = $this->input->post('tuberculosis');
        $data['tuberculosis_comment']           = $this->input->post('tuberculosis_comment');
        $data['transfusions']                   = $this->input->post('transfusions');
        $data['transfusions_comment']            = $this->input->post('transfusions_comment');
        $data['pathologies']                    = $this->input->post('pathologies');
        $data['pathologies_comment']            = $this->input->post('pathologies_comment');
        $data['gastrointestinal']               = $this->input->post('gastrointestinal');
        $data['gastrointestinal_comment']       = $this->input->post('gastrointestinal_comment');
        $data['sexual']                         = $this->input->post('sexual');
        $data['sexual_comment']                 = $this->input->post('sexual_comment');
        $data['others']                         = $this->input->post('others');
        $data['others_comment']                 = $this->input->post('others_comment');
        $data['patient_id']                     = $this->input->post('patient_id');
        $data['date']                           = $this->crud_model->formatDate();
        $this->db->insert('pathological',$data);
    }
    
    
    function update_pathological($patient_id)
    {
        $data['hospitalization']                = $this->input->post('hospitalization');
        $data['hospitalization_comment']        = $this->input->post('hospitalization_comment');
        $data['surgeries']                      = $this->input->post('surgeries');
        $data['surgeries_comment']              = $this->input->post('surgeries_comment');
        $data['diabetes']                       = $this->input->post('diabetes');
        $data['diabetes_comment']               = $this->input->post('diabetes_comment');
        $data['thyroid']                        = $this->input->post('thyroid');
        $data['thyroid_comment']                = $this->input->post('thyroid_comment');
        $data['hypertension']                   = $this->input->post('hypertension');
        $data['hypertension_comment']           = $this->input->post('hypertension_comment');
        $data['heart_disease']                  = $this->input->post('heart_disease');
        $data['heart_disease_comment']          = $this->input->post('heart_disease_comment');
        $data['trauma']                         = $this->input->post('trauma');
        $data['trauma_comment']                 = $this->input->post('trauma_comment');
        $data['cancer']                         = $this->input->post('cancer');
        $data['cancer_comment']                 = $this->input->post('cancer_comment');
        $data['tuberculosis']                   = $this->input->post('tuberculosis');
        $data['tuberculosis_comment']           = $this->input->post('tuberculosis_comment');
        $data['transfusions']                   = $this->input->post('transfusions');
        $data['transfusions_comment']           = $this->input->post('transfusions_comment');
        $data['pathologies']                    = $this->input->post('pathologies');
        $data['pathologies_comment']            = $this->input->post('pathologies_comment');
        $data['gastrointestinal']               = $this->input->post('gastrointestinal');
        $data['gastrointestinal_comment']       = $this->input->post('gastrointestinal_comment');
        $data['sexual']                         = $this->input->post('sexual');
        $data['sexual_comment']                 = $this->input->post('sexual_comment');
        $data['others']                         = $this->input->post('others');
        $data['others_comment']                 = $this->input->post('others_comment');
        $this->db->where('patient_id',$patient_id);
        $this->db->update('pathological',$data);
    }
    
    
    
    function delete_pathological($pathological_id)
    {
        $this->db->where('pathological_id', $pathological_id);
        $this->db->delete('pathological');
    }
    
    function create_no_pathological()
    {
        $data['activity']                = $this->input->post('activity');
        $data['activity_comment']        = $this->input->post('activity_comment');
        $data['smoking	']               = $this->input->post('smoking');
        $data['smoking_comment']         = $this->input->post('smoking_comment');
        $data['alcoholism']              = $this->input->post('alcoholism');
        $data['alcoholism_comment']      = $this->input->post('alcoholism_comment');
        $data['drugs']                   = $this->input->post('drugs');
        $data['drugs_comment']           = $this->input->post('drugs_comment');
        $data['vaccine']                 = $this->input->post('vaccine');
        $data['vaccine_comment']         = $this->input->post('vaccine_comment');
        $data['others']                  = $this->input->post('others');
        $data['others_comment']          = $this->input->post('others_comment');
        $data['patient_id']              = $this->input->post('patient_id');
        $data['date']                    = $this->crud_model->formatDate();
        $this->db->insert('no_pathological',$data);
    }
    
    function update_no_pathological($patient_id)
    {
        $data['activity']                = $this->input->post('activity');
        $data['activity_comment']        = $this->input->post('activity_comment');
        $data['smoking	']               = $this->input->post('smoking');
        $data['smoking_comment']         = $this->input->post('smoking_comment');
        $data['alcoholism']              = $this->input->post('alcoholism');
        $data['alcoholism_comment']      = $this->input->post('alcoholism_comment');
        $data['drugs']                   = $this->input->post('drugs');
        $data['drugs_comment']           = $this->input->post('drugs_comment');
        $data['vaccine']                 = $this->input->post('vaccine');
        $data['vaccine_comment']         = $this->input->post('vaccine_comment');
        $data['others']                  = $this->input->post('others');
        $data['others_comment']          = $this->input->post('others_comment');
        $data['patient_id']              = $this->input->post('patient_id');
        $this->db->where('patient_id',$patient_id);
        $this->db->update('no_pathological',$data);
    }
    
    function delete_no_pathological($no_pathological_id)
    {
        $this->db->where('no_pathological_id', $no_pathological_id);
        $this->db->delete('no_pathological');
    }
    
    
    function create_recordfamily()
    {
        $data['diabetes']                       = $this->input->post('diabetes');
        $data['diabetes_comment']               = $this->input->post('diabetes_comment');
        $data['heart_disease']                  = $this->input->post('heart_disease');
        $data['heart_disease_comment']          = $this->input->post('heart_disease_comment');
        $data['hypertension']                   = $this->input->post('hypertension');
        $data['hypertension_comment']           = $this->input->post('hypertension_comment');
        $data['thyroid']                        = $this->input->post('thyroid');
        $data['thyroid_comment']                = $this->input->post('thyroid_comment');
        $data['others_comment']                 = $this->input->post('others_comment');
        $data['others']                         = $this->input->post('others');
        $data['patient_id']                     = $this->input->post('patient_id');
        $data['date']                           = $this->crud_model->formatDate();
        $this->db->insert('record_family',$data);
    }
    
    
    function update_recordfamily($patient_id)
    {
        $data['diabetes']                       = $this->input->post('diabetes');
        $data['diabetes_comment']               = $this->input->post('diabetes_comment');
        $data['heart_disease']                  = $this->input->post('heart_disease');
        $data['heart_disease_comment']          = $this->input->post('heart_disease_comment');
        $data['hypertension']                   = $this->input->post('hypertension');
        $data['hypertension_comment']           = $this->input->post('hypertension_comment');
        $data['thyroid']                        = $this->input->post('thyroid');
        $data['thyroid_comment']                = $this->input->post('thyroid_comment');
        $data['others_comment']                 = $this->input->post('others_comment');
        $data['others']                         = $this->input->post('others');
        $this->db->where('patient_id',$patient_id);
        $this->db->update('record_family',$data);
    }
   
    function create_psychiatric()
    {
        $data['family_record']                 = $this->input->post('family_record');
        $data['disease_awareness']             = $this->input->post('disease_awareness');
        $data['disease_awareness_comment']     = $this->input->post('disease_awareness_comment');
        $data['affected_areas']                = $this->input->post('affected_areas');
        $data['past_treatments']               = $this->input->post('past_treatments');
        $data['family_group_social']           = $this->input->post('family_group_social');
        $data['family_group_social_comment']          = $this->input->post('family_group_social_comment');
        $data['family_group']                  = $this->input->post('family_group');
        $data['aspects_social']                = $this->input->post('aspects_social');
        $data['aspects_work']                  = $this->input->post('aspects_work');
        $data['authority']                     = $this->input->post('authority');
        $data['impulse_control']               = $this->input->post('impulse_control');
        $data['frustration']                   = $this->input->post('frustration');
        $data['patient_id']                    = $this->input->post('patient_id');
        $data['date']                          = $this->crud_model->formatDate();
        $this->db->insert('psychiatric',$data);
    }
    
    function update_psychiatric($patient_id)
    {
        $data['family_record']                 = $this->input->post('family_record');
        $data['disease_awareness']             = $this->input->post('disease_awareness');
        $data['disease_awareness_comment']     = $this->input->post('disease_awareness_comment');
        $data['affected_areas']                = $this->input->post('affected_areas');
        $data['past_treatments']               = $this->input->post('past_treatments');
        $data['family_group_social']           = $this->input->post('family_group_social');
        $data['family_group_social_comment']   = $this->input->post('family_group_social_comment');
        $data['family_group']                  = $this->input->post('family_group');
        $data['aspects_social']                = $this->input->post('aspects_social');
        $data['aspects_work']                  = $this->input->post('aspects_work');
        $data['authority']                     = $this->input->post('authority');
        $data['impulse_control']               = $this->input->post('impulse_control');
        $data['frustration']                   = $this->input->post('frustration');
        $this->db->where('patient_id',$patient_id);
        $this->db->update('psychiatric',$data);
    }
    
    function create_vaccination()
    {
        $data['bcg']                            = $this->vaccination($this->input->post('bcg'));
        $data['hepatitis_b_1']                  = $this->vaccination($this->input->post('hepatitis_b_1'));
        $data['pentavalente_acelular_1']        = $this->vaccination($this->input->post('pentavalente_acelular_1'));
        $data['hepatitis_b_2']                  = $this->vaccination($this->input->post('hepatitis_b_2'));
        $data['rotavirus_1']                    = $this->vaccination($this->input->post('rotavirus_1'));
        $data['neumococo_1']                    = $this->vaccination($this->input->post('neumococo_1'));
        $data['pentavalente_acelular_2']        = $this->vaccination($this->input->post('pentavalente_acelular_2'));
        $data['rotavirus_2']                    = $this->vaccination($this->input->post('rotavirus_2'));
        $data['neumococo_2']                    = $this->vaccination($this->input->post('neumococo_2'));
        $data['pentavalente_acelular_3']        = $this->vaccination($this->input->post('pentavalente_acelular_3'));
        $data['hepatitis_b_3']                  = $this->vaccination($this->input->post('hepatitis_b_3'));
        $data['rotavirus_3']                    = $this->vaccination($this->input->post('rotavirus_3'));
        $data['anti_influenza_1']               = $this->vaccination($this->input->post('anti_influenza_1'));
        $data['anti_influenza_2']               = $this->vaccination($this->input->post('anti_influenza_2'));
        $data['srp_1']                          = $this->vaccination($this->input->post('srp_1'));
        $data['neumococo_3']                    = $this->vaccination($this->input->post('neumococo_3'));
        $data['pentavalente_acelular_4']        = $this->vaccination($this->input->post('pentavalente_acelular_4'));
        $data['influenza_refuerzo_anual_2a']    = $this->vaccination($this->input->post('influenza_refuerzo_anual_2a'));
        $data['influenza_refuerzo_anual_3a']    = $this->vaccination($this->input->post('influenza_refuerzo_anual_3a'));
        $data['dpt']                            = $this->vaccination($this->input->post('dpt'));
        $data['influenza_refuerzo_anual_4a']    = $this->vaccination($this->input->post('influenza_refuerzo_anual_4a'));
        $data['influenza_refuerzo_anual_5a']    = $this->vaccination($this->input->post('influenza_refuerzo_anual_5a'));
        $data['vop']                            = $this->vaccination($this->input->post('vop'));
        $data['srp_2']                          = $this->vaccination($this->input->post('srp_2'));
        $data['vph']                            = $this->vaccination($this->input->post('vph'));
        $data['others']                         = $this->input->post('others');
        $data['others_comment']                 = $this->input->post('others_comment');
        $data['patient_id']                     = $this->input->post('patient_id');
        $data['date']                           = $this->crud_model->formatDate();
        $this->db->insert('vaccination',$data);
    }
    
    function update_vaccination($patient_id)
    {
        $data['bcg']                            = $this->input->post('bcg');
        $data['hepatitis_b_1']                  = $this->input->post('hepatitis_b_1');
        $data['pentavalente_acelular_1']        = $this->input->post('pentavalente_acelular_1');
        $data['hepatitis_b_2']                  = $this->input->post('hepatitis_b_2');
        $data['rotavirus_1']                    = $this->input->post('rotavirus_1');
        $data['neumococo_1']                    = $this->input->post('neumococo_1');
        $data['pentavalente_acelular_2']        = $this->input->post('pentavalente_acelular_2');
        $data['rotavirus_2']                    = $this->input->post('rotavirus_2');
        $data['neumococo_2']                    = $this->input->post('neumococo_2');
        $data['pentavalente_acelular_3']        = $this->input->post('pentavalente_acelular_3');
        $data['hepatitis_b_3']                  = $this->input->post('hepatitis_b_3');
        $data['rotavirus_3']                    = $this->input->post('rotavirus_3');
        $data['anti_influenza_1']               = $this->input->post('anti_influenza_1');
        $data['anti_influenza_2']               = $this->input->post('anti_influenza_2');
        $data['srp_1']                          = $this->input->post('srp_1');
        $data['neumococo_3']                    = $this->input->post('neumococo_3');
        $data['pentavalente_acelular_4']        = $this->input->post('pentavalente_acelular_4');
        $data['influenza_refuerzo_anual_2a']    = $this->input->post('influenza_refuerzo_anual_2a');
        $data['influenza_refuerzo_anual_3a']    = $this->input->post('influenza_refuerzo_anual_3a');
        $data['dpt']                            = $this->input->post('dpt');
        $data['influenza_refuerzo_anual_4a']    = $this->input->post('influenza_refuerzo_anual_4a');
        $data['influenza_refuerzo_anual_5a']    = $this->input->post('influenza_refuerzo_anual_5a');
        $data['vop']                            = $this->input->post('vop');
        $data['srp_2']                          = $this->input->post('srp_2');
        $data['vph']                            = $this->input->post('vph');
        $data['others']                         = $this->input->post('others');
        $data['others_comment']                 = $this->input->post('others_comment');
        $this->db->where('patient_id',$patient_id);
        $this->db->update('vaccination',$data);
    }
    
    function create_nutriological()
    {
        $data['breakfast']                      = $this->input->post('breakfast');
        $data['breakfast_comment']              = $this->input->post('breakfast_comment');
        $data['snack']                          = $this->input->post('snack');
        $data['snack_comment']                  = $this->input->post('snack_comment');
        $data['food']                           = $this->input->post('food');
        $data['food_comment']                   = $this->input->post('food_comment');
        $data['snack_afternoon']                = $this->input->post('snack_afternoon');
        $data['snack_afternoon_comment']        = $this->input->post('snack_afternoon_comment');
        $data['dinner']                         = $this->input->post('dinner');
        $data['dinner_comment']                 = $this->input->post('dinner_comment');
        $data['food_home']                      = $this->input->post('food_home');
        $data['food_home_comment']              = $this->input->post('food_home_comment');
        $data['appetite']                       = $this->input->post('appetite');
        $data['hunger_satiety']                 = $this->input->post('hunger_satiety');
        $data['hunger_satiety_comment']         = $this->input->post('hunger_satiety_comment');
        $data['glasses']                        = $this->input->post('glasses');
        $data['food_preferences']               = $this->input->post('food_preferences');
        $data['food_unrest']                    = $this->input->post('food_unrest');
        $data['food_unrest_comment']            = $this->input->post('food_unrest_comment');
        $data['supplements']                    = $this->input->post('supplements');
        $data['supplements_comment']            = $this->input->post('supplements_comment');
        $data['carried_out']                    = $this->input->post('carried_out');
        $data['carried_out_comment']            = $this->input->post('carried_out_comment');
        $data['ideal_weight']                   = $this->input->post('ideal_weight');
        $data['current_condition']              = $this->input->post('current_condition');
        $data['current_condition_comment']      = $this->input->post('current_condition_comment');
        $data['personal_history']               = $this->input->post('personal_history');
        $data['personal_history_comment']       = $this->input->post('personal_history_comment');
        $data['consumption']                    = $this->input->post('consumption');
        $data['consumption_comment']            = $this->input->post('consumption_comment');
        $data['nutrition_education']            = $this->input->post('nutrition_education');
        $data['nutrition_education_comment']    = $this->input->post('nutrition_education_comment');
        $data['others']                         = $this->input->post('others');
        $data['others_comment']                 = $this->input->post('others_comment');
        $data['patient_id']                     = $this->input->post('patient_id');
        $data['date']                           = $this->crud_model->formatDate();
        $this->db->insert('nutriological',$data);
    }
    
    
    function update_nutriological($patient_id)
    {
        $data['breakfast']                      = $this->input->post('breakfast');
        $data['breakfast_comment']              = $this->input->post('breakfast_comment');
        $data['snack']                          = $this->input->post('snack');
        $data['snack_comment']                  = $this->input->post('snack_comment');
        $data['food']                           = $this->input->post('food');
        $data['food_comment']                   = $this->input->post('food_comment');
        $data['snack_afternoon']                = $this->input->post('snack_afternoon');
        $data['snack_afternoon_comment']        = $this->input->post('snack_afternoon_comment');
        $data['dinner']                         = $this->input->post('dinner');
        $data['dinner_comment']                 = $this->input->post('dinner_comment');
        $data['food_home']                      = $this->input->post('food_home');
        $data['food_home_comment']              = $this->input->post('food_home_comment');
        $data['appetite']                       = $this->input->post('appetite');
        $data['hunger_satiety']                 = $this->input->post('hunger_satiety');
        $data['hunger_satiety_comment']         = $this->input->post('hunger_satiety_comment');
        $data['glasses']                        = $this->input->post('glasses');
        $data['food_preferences']               = $this->input->post('food_preferences');
        $data['food_unrest']                    = $this->input->post('food_unrest');
        $data['food_unrest_comment']            = $this->input->post('food_unrest_comment');
        $data['supplements']                    = $this->input->post('supplements');
        $data['supplements_comment']            = $this->input->post('supplements_comment');
        $data['carried_out']                    = $this->input->post('carried_out');
        $data['carried_out_comment']            = $this->input->post('carried_out_comment');
        $data['ideal_weight']                   = $this->input->post('ideal_weight');
        $data['current_condition']              = $this->input->post('current_condition');
        $data['current_condition_comment']      = $this->input->post('current_condition_comment');
        $data['personal_history']               = $this->input->post('personal_history');
        $data['personal_history_comment']       = $this->input->post('personal_history_comment');
        $data['consumption']                    = $this->input->post('consumption');
        $data['consumption_comment']            = $this->input->post('consumption_comment');
        $data['nutrition_education']            = $this->input->post('nutrition_education');
        $data['nutrition_education_comment']    = $this->input->post('nutrition_education_comment');
        $data['others']                         = $this->input->post('others');
        $data['others_comment']                 = $this->input->post('others_comment');
        $this->db->where('patient_id',$patient_id);
        $this->db->update('nutriological',$data);
    }
    
    function create_obstetric()
    {
        $data['first_menstruation']           = $this->input->post('first_menstruation');
        $data['last_menstruation']            = $this->input->post('last_menstruation');
        $data['menstruation_features']        = $this->input->post('menstruation_features');
        $data['pregnancies']                  = $this->input->post('pregnancies');
        $data['pregnancies_comment']          = $this->input->post('pregnancies_comment');
        $data['cervical_cancer']              = $this->input->post('cervical_cancer');
        $data['cervical_cancer_comment']      = $this->input->post('cervical_cancer_comment');
        $data['uterine_cancer']               = $this->input->post('uterine_cancer');
        $data['uterine_cancer_comment']       = $this->input->post('uterine_cancer_comment');
        $data['breast_cancer']                = $this->input->post('breast_cancer');
        $data['breast_cancer_comment']        = $this->input->post('breast_cancer_comment');
        $data['sexual_activity']              = $this->input->post('sexual_activity');
        $data['sexual_activity_comment']      = $this->input->post('sexual_activity_comment');
        $data['family_planning']              = $this->input->post('family_planning');
        $data['replacement_therapy']          = $this->input->post('replacement_therapy');
        $data['replacement_therapy_comment']  = $this->input->post('replacement_therapy_comment');
        $data['last_pap']                     = $this->input->post('last_pap');
        $data['mammography']                  = $this->input->post('mammography');
        $data['others']                       = $this->input->post('others');
        $data['others_comment']               = $this->input->post('others_comment');
        $data['patient_id']                   = $this->input->post('patient_id');
        $data['date']                         = $this->crud_model->formatDate();
        $this->db->insert('gyneco_obstetrics',$data);
    }
    
    function update_obstetric($patient_id)
    {
        $data['first_menstruation']           = $this->input->post('first_menstruation');
        $data['last_menstruation']            = $this->input->post('last_menstruation');
        $data['menstruation_features']        = $this->input->post('menstruation_features');
        $data['pregnancies']                  = $this->input->post('pregnancies');
        $data['pregnancies_comment']          = $this->input->post('pregnancies_comment');
        $data['cervical_cancer']              = $this->input->post('cervical_cancer');
        $data['cervical_cancer_comment']      = $this->input->post('cervical_cancer_comment');
        $data['uterine_cancer']               = $this->input->post('uterine_cancer');
        $data['uterine_cancer_comment']       = $this->input->post('uterine_cancer_comment');
        $data['breast_cancer']                = $this->input->post('breast_cancer');
        $data['breast_cancer_comment']        = $this->input->post('breast_cancer_comment');
        $data['sexual_activity']              = $this->input->post('sexual_activity');
        $data['sexual_activity_comment']      = $this->input->post('sexual_activity_comment');
        $data['family_planning']              = $this->input->post('family_planning');
        $data['replacement_therapy']          = $this->input->post('replacement_therapy');
        $data['replacement_therapy_comment']  = $this->input->post('replacement_therapy_comment');
        $data['last_pap']                     = $this->input->post('last_pap');
        $data['mammography']                  = $this->input->post('mammography');
        $data['others']                       = $this->input->post('others');
        $data['others_comment']               = $this->input->post('others_comment');
        $this->db->where('patient_id',$patient_id);
        $this->db->update('gyneco_obstetrics',$data);    
        
    }
    
    function create_perinatal()
    {
        $data['last_menstrual']              = $this->input->post('last_menstrual');
        $data['cycle_duration']              = $this->input->post('cycle_duration');
        $data['last_method']                 = $this->input->post('last_method');
        $data['assisted_conception']         = $this->input->post('assisted_conception');
        $data['assisted_conception_comment'] = $this->input->post('assisted_conception_comment');
        $data['ucm_date']                    = $this->input->post('ucm_date');
        $data['fpp_final']                   = $this->input->post('fpp_final');
        $data['notes']                       = $this->input->post('notes');
        $data['patient_id']                  = $this->input->post('patient_id');
        $data['date']                        = $this->crud_model->formatDate();
        $this->db->insert('perinatal',$data);
    }
    
    function update_perinatal($patient_id)
    {
        $data['last_menstrual']              = $this->input->post('last_menstrual');
        $data['cycle_duration']              = $this->input->post('cycle_duration');
        $data['last_method']                 = $this->input->post('last_method');
        $data['assisted_conception']         = $this->input->post('assisted_conception');
        $data['assisted_conception_comment'] = $this->input->post('assisted_conception_comment');
        $data['ucm_date']                    = $this->input->post('ucm_date');
        $data['fpp_final']                   = $this->input->post('fpp_final');
        $data['notes']                       = $this->input->post('notes');
        $this->db->where('patient_id',$patient_id);
        $this->db->update('perinatal',$data);    
    }
    
    function create_postnatal()
    {
        $data['baby_name']              = $this->input->post('baby_name');
        $data['birth_details']          = $this->input->post('birth_details');
        $data['birth_weight']           = $this->input->post('birth_weight');
        $data['baby_health']            = $this->input->post('baby_health');
        $data['baby_feeding']           = $this->input->post('baby_feeding');
        $data['emotional_state']        = $this->input->post('emotional_state');
        $data['patient_id']             = $this->input->post('patient_id');
        $data['date']                   = $this->crud_model->formatDate();
        $this->db->insert('postnatal',$data);
    }
    
    function update_postnatal($patient_id)
    {
        $data['baby_name']              = $this->input->post('baby_name');
        $data['birth_details']          = $this->input->post('birth_details');
        $data['birth_weight']           = $this->input->post('birth_weight');
        $data['baby_health']            = $this->input->post('baby_health');
        $data['baby_feeding']           = $this->input->post('baby_feeding');
        $data['emotional_state']        = $this->input->post('emotional_state');
        $this->db->where('patient_id',$patient_id);
        $this->db->update('postnatal',$data);    
    }
    
   
    
    function vaccination($var1)//función para mandar un 0 para insertar en la tabla vaccination
    {
        if($var1 == 1)
        {
            return 1;    
        }
                    
        else
        {
           return 0;    
        }
    }
    
    function check_medical_history($var1, $var2,$var3)
    {
      if($this->db->get_where($var3, array('patient_id' => $var1))->row()->$var2 == 1)
      {
         return 1;
      }
      
      else
      {
          return 0;
      }
    }
    
    function check_comment_medical_history($var1,$var2,$var3)
    {
        $col = $var2.'_comment';
        $vv = $this->db->get_where($var3, array('patient_id' => $var1,$var2 => 1))->row()->$col;
        
        if($vv!="")
        {
            return $vv;
        }
    }
    
    function check_medical_value($var1,$var2,$var3)
    {
      $vv = $this->db->get_where($var3, array('patient_id'=> $var1))->row()->$var2;
  
      if($vv!="")
      {
         return $vv;
      }
     
    }
    
    function prox_appointments($clinic_id,$hoy,$fecha)
    {
        $sql = "SELECT * FROM appointment WHERE status<>4 AND status<>2 AND status<>5  AND clinic_id = ? AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y') ORDER BY DATE(str_to_date(date, '%d/%m/%Y')) ASC limit 5";
        
        $res = $this->db->query($sql, array($clinic_id,$hoy,$fecha))->result_array();
        
        return $res;
    }
    
        function prox_appointments_doc($clinic_id,$hoy,$fecha)
    {   
        
        $doctor_id=$doctor_id;
        $sql = "SELECT * FROM appointment WHERE status IN (0, 1, 3) and past_status=0  AND doctor_id = '".$doctor_id."'  AND clinic_id = ? AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y') ORDER BY DATE(str_to_date(date, '%d/%m/%Y')) ASC limit 5";
        
        
        $res = $this->db->query($sql, array($clinic_id,$hoy,$fecha))->result_array();
        
        return $res;
    }
    
    
    function prev_appointments($clinic_id,$user,$hoy,$fecha)
    {
        if($user > 0){ //status = 4 AND
            
            $sql = "SELECT * FROM appointment WHERE clinic_id = ? AND patient_id = ? AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y') ORDER BY DATE(str_to_date(date, '%d/%m/%Y')) ASC";
            
            $res = $this->db->query($sql, array($clinic_id,$user,$hoy,$fecha))->result_array();
            
            return $res;
        }
        
        else 
        {//status = 4 AND
            $sql = "SELECT * FROM appointment WHERE clinic_id = ? AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y') ORDER BY DATE(str_to_date(date, '%d/%m/%Y')) ASC";
            
            $res = $this->db->query($sql, array($clinic_id,$hoy,$fecha))->result_array();
            
            return $res;
        }
    }
    
    function appoints($clinic_id,$user,$hoy,$fecha)
    {
        if($user > 0)
        {
            $sql = "SELECT * FROM appointment WHERE clinic_id = ? AND  status = 4 AND doctor_id = ? AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y') ORDER BY DATE(str_to_date(date, '%d/%m/%Y')) ASC";
                
            $res = $this->db->query($sql, array($clinic_id,$user,$hoy,$fecha))->result_array();
                
            return $res;
        }
        
        else 
        {
            $sql = "SELECT * FROM appointment WHERE clinic_id = ? AND status = 4 AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y') ORDER BY DATE(str_to_date(date, '%d/%m/%Y')) ASC";
                
            $res = $this->db->query($sql, array($clinic_id,$hoy,$fecha))->result_array();
                
            return $res;
        }
    }
    
        function appoints_doct($clinic_id,$hoy,$fecha)
    {
        $user = $doctor_id;
        if($user > 0)
        {
            $sql = "SELECT * FROM appointment WHERE clinic_id = ? AND  status = 4 AND doctor_id = ? AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y') ORDER BY DATE(str_to_date(date, '%d/%m/%Y')) ASC";
                
            $res = $this->db->query($sql, array($clinic_id,$user,$hoy,$fecha))->result_array();
                
            return $res;
        }
        
        else 
        {
            $sql = "SELECT * FROM appointment WHERE clinic_id = ? AND status = 4 AND doctor_id = ? AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y') ORDER BY DATE(str_to_date(date, '%d/%m/%Y')) ASC";
                
            $res = $this->db->query($sql, array($clinic_id,$user,$hoy,$fecha))->result_array();
                
            return $res;
        }
    }
    
    
    
    function count_appointments($doctor_id, $date1,$date2, $status)
    {
        if($status == "total")
        {
            $sql = "SELECT * FROM `appointment` where clinic_id = ? And doctor_id = ? AND status != 5 AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y')";
            $res = $this->db->query($sql, array($this->session->userdata('current_clinic'), $doctor_id, $date1,$date2));
        }else
        {
            $sql = "SELECT * FROM `appointment` where clinic_id = ? And status = ? AND doctor_id = ? AND status != 5 AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y')";
            $res = $this->db->query($sql, array($this->session->userdata('current_clinic'), $status, $doctor_id, $date1,$date2));

        }
        
            return  $res;
       
    }
    
    
    function practiceCount()
    {
       $res = $this->db->query("SELECT practice, COUNT(practice) total FROM appointment WHERE clinic_id = ".$this->session->userdata('current_clinic')."  and  status = 4 GROUP BY practice ORDER BY total DESC LIMIT 6")->result_array();
            
       return $res;
       
    }
    
    function range_financial_date($clinic_id,$hoy,$fecha)
    {
        $sql = "SELECT description, date, time, amount, income_id, patient_id, appointment_id FROM financial WHERE clinic_id = ? AND str_to_date(income.date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y') ";
            
        $res = $this->db->query($sql, array($clinic_id,$hoy,$fecha))->result_array();
            
        return $res;
    }
    
    function count_cost()
    {
        $sql = "SELECT * FROM product WHERE clinic_id = ?";
        $res = $this->db->query($sql, array($this->session->userdata('current_clinic')));   
        return $res;
    }
    
    function product_expiration($clinic_id,$hoy,$fecha)
    {
        $sql = "SELECT * FROM product WHERE clinic_id = ? AND str_to_date(expiration_date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y')";
                
        $res = $this->db->query($sql, array($clinic_id,$hoy,$fecha))->result_array();
                
        return $res;
    }
    
    function product_expiration22($clinic_id,$hoy)
    {
        $sql = "SELECT * FROM product WHERE clinic_id = ? AND str_to_date(expiration_date, '%d/%m/%Y') <= str_to_date(?, '%d/%m/%Y')";
                
        $res = $this->db->query($sql, array($clinic_id,$hoy))->result_array();
                
        return $res;
    }
    
       
    function leading_product()
    {
       /*$reg = '.*variant_id;s:[0-9]+:2.*';
        $this->db->where('products count(REGEXP ', "'".'.*"variant_id";s:[0-9]+:"'.$var.'".*)'."'", false); 
        $sql = $this->db->get('cart');
        
        return $sql->num_rows();*/
       $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
       $this->db->limit(6);
       $this->db->order_by('cart_id','desc');
       $sql = $this->db->get('cart')->result_array();
       $ar = array();
   
       foreach($sql as $row)
       { 
            foreach (unserialize ($row['products']) as $row2)
            {
               array_push($ar,['qty'=>$row2['variant_id']*$row2['ordered_quantity'],'product_id'=>$row2['variant_id']]);
            }
       }
       rsort($ar);
       return $ar;
    }
    
    function incomes_today($clinic_id,$hoy){
        $sql = "SELECT * FROM income WHERE clinic_id = ? AND  str_to_date(?, '%d/%m/%Y') = str_to_date(date, '%d/%m/%Y') ORDER BY DATE(str_to_date(date, '%d/%m/%Y')) DESC";
            
        $res = $this->db->query($sql, array($clinic_id,$hoy))->result_array();
                
        return $res;
    }
    
    function incomes_week($clinic_id,$Last7days,$hoy){
        $sql = "SELECT * FROM income WHERE clinic_id = ? AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y') ORDER BY DATE(str_to_date(date, '%d/%m/%Y')) DESC";
        $res = $this->db->query($sql, array($clinic_id,$Last7days,$hoy))->result_array();
        return $res;
    }
    
    function incomes_last_days($clinic_id,$Last30days,$hoy){
        $sql = "SELECT * FROM income WHERE clinic_id = ? AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y') ORDER BY DATE(str_to_date(date, '%d/%m/%Y')) DESC";
        $res = $this->db->query($sql, array($clinic_id,$Last30days,$hoy))->result_array();
        return $res;
    }
    
    function expenses_today($clinic_id,$hoy){
        $sql = "SELECT * FROM expense WHERE clinic_id = ? AND  str_to_date(?, '%d/%m/%Y') = str_to_date(date, '%d/%m/%Y') ORDER BY DATE(str_to_date(date, '%d/%m/%Y')) DESC";
            
        $res = $this->db->query($sql, array($clinic_id,$hoy))->result_array();
                
        return $res;
    }
    
    function expenses_week($clinic_id,$Last7days,$hoy){
        $sql = "SELECT * FROM expense WHERE clinic_id = ? AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y') ORDER BY DATE(str_to_date(date, '%d/%m/%Y')) DESC";
        $res = $this->db->query($sql, array($clinic_id,$Last7days,$hoy))->result_array();
        return $res;
    }
    
    function expenses_last_days($clinic_id,$Last30days,$hoy){
        $sql = "SELECT * FROM expense WHERE clinic_id = ? AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y') ORDER BY DATE(str_to_date(date, '%d/%m/%Y')) DESC";
        $res = $this->db->query($sql, array($clinic_id,$Last30days,$hoy))->result_array();
        return $res;
    }
    
    function users_activity($clinic_id){
        
        $res = $this->db->query("SELECT admin.type, admin.admin_id as _id, admin.status FROM admin WHERE admin.clinic_id = '".$clinic_id."' UNION SELECT staff.type, staff.staff_id, staff.status FROM staff WHERE staff.clinic_id = '".$clinic_id."' AND status != 0")->result_array();
        return $res;
    }
    
    function medical_history($patient_id)
    {
        $this->db->limit(1);
        $this->db->where('patient_id', $patient_id);
        $this->db->where('status', 4);
        $this->db->order_by('appointment_id','desc');
        $signs = $this->db->get('appointment')->result_array();
        return $signs;
    }
    
    
    
    function patient_busy($patient_id){
        
        $res = $this->db->query("SELECT * FROM `appointment` WHERE status IN (0, 1, 3) and patient_id = ".$patient_id);
        return $res;
    }
    
    function count_patient_archived($patient_id){
        
	    $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status IN (0, 1) and patient_id = '".$patient_id."'")->num_rows();
        
        
        return $appointments;
    }

    function appointment_today($date, $clinic_id){
        
        $res = $this->db->query("SELECT * FROM `appointment` WHERE status IN (0, 1, 3) and clinic_id = ".$clinic_id." and date ='".$date."'");
        return $res;
    }
    
    function appointment_today_doc($doctor_id, $date, $clinic_id, $time){
        
	    $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status IN (0, 1) and clinic_id = ".$clinic_id." and time like '".$time."%' and date ='".$date."' and doctor_id = '".$doctor_id."'");
        return $appointments;
    }

    function appointment_reshedule_doc($doctor_id, $date, $clinic_id, $time){
        
	    $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status = 3 and clinic_id = ".$clinic_id." and time like '".$time."%' and date ='".$date."' and doctor_id = '".$doctor_id."'");
        return $appointments;
    }


    function list_today_doc($doctor_id, $date, $clinic_id, $time){
        
  
	    $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status IN (0, 1, 5) and clinic_id = ".$clinic_id." and time like '".$time."%' and date ='".$date."' and doctor_id = '".$doctor_id."'");
        return $appointments;
    }

    
    function appointment_pendding_doc($doctor_id, $date, $clinic_id, $time){
        
	    $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status=10 and clinic_id = ".$clinic_id." and time like '".$time."%' and date ='".$date."' and doctor_id = '".$doctor_id."'");
        return $appointments;
    }

    function appointment_canceled_doc($doctor_id, $date, $clinic_id, $time){
        
	    $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status=2 and clinic_id = ".$clinic_id." and time like '".$time."%' and date ='".$date."' and doctor_id = '".$doctor_id."'");
        return $appointments;
    }


    function appointment_archived_doc($doctor_id, $date, $clinic_id, $time){
        
	    $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status= 4 and clinic_id = ".$clinic_id." and time like '".$time."%' and date ='".$date."' and doctor_id = '".$doctor_id."'");
        return $appointments;
    }


    function count_appointment_today($doctor_id, $date, $clinic_id){
	    $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status IN (0, 1) and clinic_id = ".$clinic_id." and date ='".$date."' and doctor_id = '".$doctor_id."'")->num_rows();
        return $appointments;
    }
    
    function count_appointment_payment_pending($doctor_id, $date){
        $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status = 10 and clinic_id = ".$this->session->userdata('current_clinic')." and date ='".$date."' and doctor_id = '".$doctor_id."'")->num_rows();
        return $appointments;
    }
    
    function count_soon($doctor_id, $date)
    {
	    $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status IN (0, 1) and clinic_id = ".$this->session->userdata('current_clinic')." and date ='".$date."' and doctor_id = '".$doctor_id."'")->num_rows();
        return $appointments;
    }
    
    function count_rescheduled($doctor_id, $date){
        $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status = 3 and clinic_id = ".$this->session->userdata('current_clinic')." and date ='".$date."' and doctor_id = '".$doctor_id."'")->num_rows();
        return $appointments;
    }
    
    function count_cancelled($doctor_id, $date){
        $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status = 2 and clinic_id = ".$this->session->userdata('current_clinic')." and date ='".$date."' and doctor_id = '".$doctor_id."'")->num_rows();
        return $appointments;
    }
    
    function count_archived($doctor_id, $date)
    {
        $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status = 4 and clinic_id = ".$this->session->userdata('current_clinic')." and date ='".$date."' and doctor_id = '".$doctor_id."'")->num_rows();
        return $appointments;
    }

    function count_archived_dashboard()
    {
        $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status = 4 and clinic_id = ".$this->session->userdata('current_clinic')." and doctor_id = '".$this->session->userdata('doctor_id')."'")->num_rows();
        $appointments_today = $this->db->query("SELECT * FROM `appointment` WHERE status = 4 and clinic_id = ".$this->session->userdata('current_clinic')." and date ='".date('d/m/Y')."' and doctor_id = '".$this->session->userdata('doctor_id')."'")->num_rows();
        
        if($appointments > 1)
            $total = (100 * $appointments_today)/$appointments;
        else
            $total = (100 * $appointments_today)/1;
        
        
        return round($total);
    }

    function count_pendientes_dashboard()
    {
        $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status = 0 and clinic_id = ".$this->session->userdata('current_clinic')." and doctor_id = '".$this->session->userdata('doctor_id')."'")->num_rows();
        $appointments_today = $this->db->query("SELECT * FROM `appointment` WHERE status = 0 and clinic_id = ".$this->session->userdata('current_clinic')." and date ='".date('d/m/Y')."' and doctor_id = '".$this->session->userdata('doctor_id')."'")->num_rows();
        
        if($appointments > 1)
            $total = (100 * $appointments_today)/$appointments;
        else
            $total = (100 * $appointments_today)/1;
        
        
        return round($total);
    }

    function count_cancelled_dashboard()
    {
        $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status = 2 and clinic_id = ".$this->session->userdata('current_clinic')." and doctor_id = '".$this->session->userdata('doctor_id')."'")->num_rows();
        $appointments_today = $this->db->query("SELECT * FROM `appointment` WHERE status = 2 and clinic_id = ".$this->session->userdata('current_clinic')." and date ='".date('d/m/Y')."' and doctor_id = '".$this->session->userdata('doctor_id')."'")->num_rows();
        
        if($appointments > 1)
            $total = (100 * $appointments_today)/$appointments;
        else
            $total = (100 * $appointments_today)/1;
        
        
        return round($total);
    }

    function count_rescheduled_dashboard()
    {

        $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status = 3 and clinic_id = ".$this->session->userdata('current_clinic')." and doctor_id = '".$this->session->userdata('doctor_id')."'")->num_rows();
        $appointments_today = $this->db->query("SELECT * FROM `appointment` WHERE status = 3 and clinic_id = ".$this->session->userdata('current_clinic')." and date ='".date('d/m/Y')."' and doctor_id = '".$this->session->userdata('doctor_id')."'")->num_rows();
        if($appointments > 1)
            $total = (100 * $appointments_today)/$appointments;
        else
            $total = (100 * $appointments_today)/1;
        
        
        return round($total);
    }
    
    function new_patients()
    {   
        $this->db->limit('5');
        $this->db->order_by('patient_id', 'DESC');
        $this->db->where('status !=', 0);
        $patients = $this->db->get('patient')->result_array();
        $news = array();
         foreach($patients as $pt)
         {
                
                $this->db->where('patient_id', $pt['patient_id']);
                $appointments = $this->db->get('appointment')->num_rows();
                
                if($appointments < 2)
                {
                    array_push($news, $pt);
                }
             
             
         }
  
        return $news;

    }
    
    function account_owner()
    {
      $owner = $this->db->get_where('admin', array('admin_id' => $this->session->userdata('doctor_id')))->row()->owner;
      
      if($owner > 0)
      {
          return $owner;
      }
      else
      {
          return 0;
      }
    }
    
    
    
    function total_pay_credits($patient_id, $treatment_id)
    {
        $query = $this->db->query('select sum(amount) as total from payment_credit where patient_id = "'.$patient_id.'"AND tooth_treatment_id = "'.$treatment_id.'";')->row()->total;
        if($query > 0)
        {
            return $query;    
        }
        else
        {
            return 0;
        }
        
    }
    
    
    function insert_pay_credit()
    {
        //-----------------  Ingreso en tabla payment_credit
        $data['date']               = date('Y-m-d');
        $data['time']               = date('H:i:s');
        $data['datetime']           = date('Y-m-d H:i:s');
        $data['user_id']            = $this->session->userdata('login_user_id');  
        $data['user_type']          = $this->session->userdata('login_type');    
        $data['amount']             = $this->input->post('amount');    
        $data['method']             = $this->input->post('method');
        $data['patient_id']         = $this->input->post('patient_id');
        $data['tooth_treatment_id'] = $this->input->post('treatment_id');
        $data['previous_total']     = $this->input->post('previous_total');
        if($this->input->post('method') == 2)
        {
            $data['details']        = 'Titular de la tarjeta: '.$this->input->post('cardholder').' con el boucher: '.$this->input->post('vaucher');
        }
        elseif($this->input->post('method') == 3)
        {
            $data['details']        = 'Cheque no: '.$this->input->post('checkk').' nombre de la cuenta: '.$this->input->post('titular_checkk');
        }
        elseif($this->input->post('method') == 4)
        {
            $data['details']        = 'Número de depósito: '.$this->input->post('no_dep');
        }
        
        elseif($this->input->post('method') == 5)
        {
            $data['details']        = 'Transferencia número: '.$this->input->post('transf');
        }
        else{
            $data['details']        = 'Efectivo';
        }
        
        $this->db->insert('payment_credit', $data);
        $pay_id = $this->db->insert_id();

        //----------------Insertando en tabla financial el ingreso     
        
        $dats['clinic_id']          = $this->session->userdata('current_clinic');
        $dats['user_id']            = $this->session->userdata('login_user_id');
        $dats['user_type']          = $this->session->userdata('login_type');
        $dats['description']        = 'Se abonó el tratamiento con ID: '.$this->input->post('treatment_id').' del paciente: '.$this->accounts_model->get_name('patient',$this->input->post('patient_id'));
        $dats['amount']             = $this->input->post('amount');
        $dats['method']             = $this->input->post('method');
        $dats['patient_id']         = $this->input->post('patient_id');
        $dats['treatment_id']       = $this->input->post('treatment_id');
        if($this->input->post('method') == 2)
        {
            $dats['reference']          = $this->input->post('vaucher');//si es el pago con tarjeta
        }
        elseif($this->input->post('method') == 3)
        {
            $dats['reference']          = $this->input->post('checkk');//si es el pago con cheque
        }
        elseif($this->input->post('method') == 4)
        {
            $dats['reference']          = $this->input->post('no_dep');//si es el pago con depósito
        }
        elseif($this->input->post('method') == 5)
        {
            $dats['reference']          = $this->input->post('transf');//si es el pago con transferencia
        }
        $dats['date']               = date('d/m/Y');
        $dats['time']               = date('H:m');
        $dats['pay_id']               = $pay_id;
        $this->db->insert('financial',$dats);
        $this->log_model->add_payment_credit($pay_id, $this->input->post('amount'));

    }
    
    function delete_pay_credit($pay_id)
    {
        $cant = $this->db->get_where('payment_credit', array('payment_credit_id' =>$pay_id))->row()->amount;
        $this->db->where('payment_credit_id',$pay_id);
        $this->db->delete('payment_credit');    
        
        $this->db->where('pay_id',$pay_id);
        $this->db->delete('financial');   
        
        $this->log_model->delete_payment_credit($pay_id,$cant);
        
    }    
    
    function treatments_status($treatment_id)
    {
        $this->db->where('odonto_treatment_id', $treatment_id);
        $this->db->where('status', 0);
        $treat = $this->db->get('tooth_treatment')->num_rows();
        return $treat;
    }
    
    function treatmentss($treatment_id)
    {
        $this->db->where('odonto_treatment_id', $treatment_id);
        $detalles = $this->db->get('tooth_treatment')->num_rows();
        return $detalles;
    }
    
    function appointment_status_treatment($treatment_id)
    {
        $this->db->limit(1);
        $this->db->order_by('appointment_id', 'DESC');
        $this->db->where('treatment_id', $treatment_id);
        $status = $this->db->get('appointment')->row();
        if( $status->status > 0)
        {
            return $status->status.'-'.$status->appointment_id;    
        }
        else
        {
            return '0-'.$status->appointment_id;    
        }
        
    }
    
    function treatments_count($patient_id)
    {
        $status = $this->db->get_where('appointment', array('patient_id' => $patient_id, 'practice' => '23', 'status' => 0))->num_rows();
        return $status;
    }
    
    function date_appointment($patient_id)
    {
        $this->db->limit('1');
        $this->db->order_by('appointment_id', 'desc');
        $this->db->where('patient_id', $patient_id);
        $app_pt = $this->db->get('appointment');
        if($app_pt->num_rows() > 0)
        {
            return $app_pt->row()->date;
        }
        else
        {
            return '';
        }
    }
    
    function num_appointments($patient_id)
    {
        return $this->db->get_where('appointment',array('patient_id'=>$patient_id))->num_rows();
    }
    
    function num_prescriptions($patient_id, $treatment_id)
    {
        $appoints = $this->db->get_where('appointment', array('treatment_id' => $treatment_id))->result_array();
        
        $data = array();  
        if(count($appoints)> 1)
        {
            foreach($appoints as $sd)
            {
                $data[] = $this->db->get_where('prescription', array('appointment_id' => $sd['appointment_id'], 'patient_id' => $patient_id))->row()->prescription_id;
            }
        }
        return $data;
    }
    
    function sum_treats($treatment_id)
    {
        $this->db->group_by('tooth_id');
        $this->db->where('odonto_treatment_id', $treatment_id);
        $refresh_query = $this->db->get('tooth_treatment');
        $final = 0;
        
        if(count($refresh_query) > 0)
        {
            foreach($refresh_query->result_array() as $tr)
            {
                $total = 0;
                $this->db->where('tooth_id', $tr['tooth_id']);
                $this->db->where('odonto_treatment_id', $treatment_id);
                $treat = $this->db->get('tooth_treatment');
                
                foreach($treat->result_array() as $row){
                    $total += $this->db->get_where('process', array('process_id' => $row['process']))->row()->price; 
                }
                  $final += $total;
            }
        }
        return $final;
    }

    function contacts()
    {
        $sql = "SELECT admin_id as id, username, phone, type FROM admin where status = 1 
        UNION SELECT staff_id as id, username, phone, type FROM staff  where status = 1 
        UNION SELECT patient_id as id, username, phone, type FROM patient  where status = 1 LIMIT 10";
        
        $res = $this->db->query($sql)->result_array();
        
        return $res;
    }

    function checkClick($mime,$id, $name,$type){
        $html = '';
        if($mime == 'application/vnd.google-apps.folder'){
            $html = 'onclick="showFiles('."'".$id."'".",'".$name."'".",'".$type."'".')"';
        }else{
            $html = '';
        }   
        return $html;
    }

    function getMimeType($mime, $icon, $thum){
        if($icon != ''){
            $return = $icon;
        }else{
            if($mime == 'application/vnd.google-apps.folder'){
                $return = base_url().'public/uploads/folder.svg';
            }else{
                $return = $thum;
            }   
        }
        return $return;
    }

    public function isFolder($mimeType,$id,$name)
    {
        if($mimeType != 'application/vnd.google-apps.folder'){
            $html = '<div class="pi-controls">
                <div class="pi-controls">
                    '.$this->validateDownload($mimeType,$id,$name).'
                </div>
            </div>';
        }
        else{
           
                $html = '<div class="pi-controls">
                    <div class="pi-controls">
                    <div class="pi-settings os-dropdown-trigger" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-h"></i>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="javascript:void(0)" onclick="confirm_delete_folder('."'".$id."'"."".')">Eliminar carpeta</a>
                    </div>
                    
                    </div>
                </div>';
           
        }
        return $html;
    }


    function validateDownload($mimeType,$id,$name)
    {
            $html = '<div class="pi-settings os-dropdown-trigger" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-h"></i>
                    </div>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" target="_blank" href="'.base_url().'drive/download/'.base64_encode($mimeType).'/'.base64_encode($id).'/'.base64_encode($name).'">Previsualizar</a>
                '.$this->downloadOptions($mimeType,$id).'
            </div>';      
       
        return $html;
    }


    function downloadOptions($mimeType,$id){
     /*   switch ($mimeType) {
            case 'application/msword':
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
            case 'application/vnd.google-apps.document':
                $options = '<a class="dropdown-item" href="'.base_url().'drive/downloadFile/'.base64_encode($id).'/'.base64_encode('application/vnd.openxmlformats-officedocument.wordprocessingml.document').'">'.get_phrase('download_as_word').'</a>';
                $options .= '<a class="dropdown-item" href="'.base_url().'drive/downloadFile/'.base64_encode($id).'/'.base64_encode('text/html').'">Descargar como HTML</a>';
                $options .= '<a class="dropdown-item" href="'.base_url().'drive/downloadFile/'.base64_encode($id).'/'.base64_encode('text/plain').'">Descargar como Texto</a>';
                $options .= '<a class="dropdown-item" href="'.base_url().'drive/downloadFile/'.base64_encode($id).'/'.base64_encode('application/pdf').'">Descargar como PDF</a>';
                $options .= '<a class="dropdown-item" href="'.base_url().'drive/downloadFile/'.base64_encode($id).'/'.base64_encode('application/zip').'">Descargar como ZIP</a>';
                break;

            case 'application/vnd.ms-excel':
            case 'application/vnd.ms-excel.sheet.macroenabled.12':
            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
            case 'application/vnd.google-apps.spreadsheet':
                $options = '<a class="dropdown-item" href="'.base_url().'drive/downloadFile/'.base64_encode($id).'/'.base64_encode('application/pdf').'">Descargar como PDF</a>';
                $options .= '<a class="dropdown-item" href="'.base_url().'drive/downloadFile/'.base64_encode($id).'/'.base64_encode('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet').'">'.get_phrase('download_as_excel').'</a>';
                $options .= '<a class="dropdown-item" href="'.base_url().'drive/downloadFile/'.base64_encode($id).'/'.base64_encode('text/csv').'">Descargar como CSV</a>';
                $options .= '<a class="dropdown-item" href="'.base_url().'drive/downloadFile/'.base64_encode($id).'/'.base64_encode('application/zip').'">Descargar como ZIP</a>';
                break;

            case 'application/vnd.ms-powerpoint':
            case 'application/vnd.openxmlformats-officedocument.presentationml.slideshow':
            case 'application/vnd.google-apps.presentation':
                $options = '<a class="dropdown-item" href="'.base_url().'drive/downloadFile/'.base64_encode($id).'/'.base64_encode('application/vnd.openxmlformats-officedocument.presentationml.presentation').'">'.get_phrase('download_as_power_point').'</a>';
                $options .= '<a class="dropdown-item" href="'.base_url().'drive/downloadFile/'.base64_encode($id).'/'.base64_encode('application/pdf').'">Descargar como PDF</a>';
                $options .= '<a class="dropdown-item" href="'.base_url().'drive/downloadFile/'.base64_encode($id).'/'.base64_encode('text/plain').'">Descargar como Texto</a>';
                break;

            case 'application/vnd.google-apps.drawing':
                $options = '<a class="dropdown-item" href="'.base_url().'drive/downloadFile/'.base64_encode($id).'/'.base64_encode('image/jpeg').'">Descargar como JPEG</a>';
                $options .= '<a class="dropdown-item" href="'.base_url().'drive/downloadFile/'.base64_encode($id).'/'.base64_encode('image/png').'">Descargar como PNG</a>';
                $options .= '<a class="dropdown-item" href="'.base_url().'drive/downloadFile/'.base64_encode($id).'/'.base64_encode('image/svg+xml').'">Descargar como SVG</a>';
                $options .= '<a class="dropdown-item" href="'.base_url().'drive/downloadFile/'.base64_encode($id).'/'.base64_encode('application/pdf').'">Descargar como PDF</a>';
                break;

            case 'application/vnd.google-apps.form':
                $options = '';
                break;
 
            default:
                $options = '<a class="dropdown-item" href="'.base_url().'drive/downloadFile/'.base64_encode($id).'/0'.'">Descargar</a>';
                break;
        }*/

        $options = '<a class="dropdown-item" href="'.base_url().'drive/downloadFile/'.base64_encode($id).'/0'.'">Descargar</a>';
       
       if($this->session->userdata('login_type') == 'doctor')
        $options .= '<a class="dropdown-item" href="javascript:void(0)" onclick="confirm_delete('."'".$id."'"."".')">Eliminar</a>';
       
       
        return $options;
    }


    function getDoctors_sop(){
        return $this->db->query('SELECT * FROM admin where status != 0 ')->result_array();
    }

    function getStaffList_sop(){
        $query = $this->db->query('SELECT * FROM staff where status != 0 ')->result_array();
        return $query;
    }

    function fill_week_sop($date){
        $explode_date = explode('-', $date);
        $this->db->where('day',$explode_date[2]);
        $this->db->where('month',$explode_date[1]);
        $this->db->where('year',$explode_date[0]);
        
        $this->db->where('status !=', 4);
        $this->db->where('status !=', 5);
        $this->db->where('status !=', 6);
        $nums = $this->db->get('appointment')->num_rows();
        return $nums;
        
    }
    
}