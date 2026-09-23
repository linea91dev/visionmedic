    <?php 
        $info = $this->db->get_where('appointment', array('appointment_id' => $param2))->result_array();
        foreach($info as $row):
            
        if($row['status']==5){
    ?>
    <div class="modal-content animated fadeInDown">
		<div class="modal-body" style="background-color:#6badff; margin-top: -20px; border-top-right-radius:15px;border-top-left-radius:20px;">
		    <button type="button" class="close" data-dismiss="modal" style="color:#fff">&times;</button>
			<div class="form-group">
				<center><img src="<?php echo $this->accounts_model->get_photo('admin', $row['doctor_id']);?>" style="object-fit: scale-down; max-width:15%; margin-bottom: 12px;margin-top:17px; border:4px solid #fff;border-radius:50%;
				-webkit-box-shadow: 0px 2px 14px rgba(0, 0, 0, 0.30); box-shadow: 0px 2px 14px rgba(0, 0, 0, 0.30);"></center>
				<center><span style="font-size:20px;color:#fff;margin-top:47px"><?php echo $this->accounts_model->short_name('admin', $row['doctor_id']);?></span></center>
			</div>
		</div>
		<div class="modal-footer" style="text-align:justify;padding:25px;">
		    <p style="margin-left:0px;"><i style="background-color: rgba(244, 164, 37, 0.25);padding:6px;border-radius:4px;color:#f4a72d;" class="batch-icon-heart-full"></i> <a> <?php echo $row['Title']; ?>.</a></p>
		    <p style="margin-left:0px;"><i style="background-color: rgba(244, 164, 37, 0.25);padding:6px;border-radius:4px;color:#f4a72d;" class="batch-icon-quill"></i> <?php echo $row['comment'];?></p>
		    <p style="margin-left:0px;"><i style="background-color: rgba(244, 164, 37, 0.25);padding:6px;border-radius:4px;color:#f4a72d;" class="batch-icon-alarm-clock"></i> <?php echo date("g:i A", strtotime($row['time']));?>.</p>
		    <p style="margin-left:0px;"><i style="background-color: rgba(244, 164, 37, 0.25);padding:6px;border-radius:4px;color:#f4a72d;" class="batch-icon-alarm-clock"></i> <?php echo $row['date'];?>.</p>
		    <p style="margin-left:0px;"><i style="background-color: rgba(244, 164, 37, 0.25);padding:6px;border-radius:4px;color:#f4a72d; " class="batch-icon-alarm-clock"></i><a style="cursor: pointer;" onclick="deleteEvent()" > Eliminar</a></p>
            <input type="hidden" value="<?php echo $param2;?>" id="appointment_id">
            <input type="hidden" value="<?php echo $row['doctor_id']; ?>" id="doctor_id">
		</div>
	</div>
	<?php 
        }else
	{  ?>
	    
	    <div class="modal-content animated fadeInDown">
		<div class="modal-body" style="background-color:#6badff; margin-top: -20px; border-top-right-radius:15px;border-top-left-radius:20px;">
		    <button type="button" class="close" data-dismiss="modal" style="color:#fff">&times;</button>
			<div class="form-group">
				<center><img src="<?php echo $this->accounts_model->get_photo('patient', $row['patient_id']);?>" style=" object-fit: scale-down; max-width:15%; margin-bottom: 12px;margin-top:17px; border:4px solid #fff;border-radius:50%;
				-webkit-box-shadow: 0px 2px 14px rgba(0, 0, 0, 0.30); box-shadow: 0px 2px 14px rgba(0, 0, 0, 0.30);"></center>
				<center><span style="font-size:20px;color:#fff;margin-top:47px"><?php echo $this->accounts_model->short_name('patient', $row['patient_id']);?></span></center>
			</div>
		</div>
		<div class="modal-footer" style="text-align:justify;padding:25px;">
		    <p style="margin-left:0px;"><i style="background-color: rgba(244, 164, 37, 0.25);padding:6px;border-radius:4px;color:#f4a72d;" class="batch-icon-heart-full"></i> <a href="<?php echo base_url();?>staff/appointment_details/<?php echo base64_encode($row['appointment_id']);?>"> <?php echo $this->db->get_where('service', array('service_id' => $row['practice']))->row()->name;?>.</a></p>
		    <p style="margin-left:0px;"><i style="background-color: rgba(244, 164, 37, 0.25);padding:6px;border-radius:4px;color:#f4a72d;" class="batch-icon-alarm-clock"></i> <?php echo date("g:i A", strtotime($row['time']));?>.</p>
		    <p style="margin-left:0px;"><i style="background-color: rgba(244, 164, 37, 0.25);padding:6px;border-radius:4px;color:#f4a72d;" class="batch-icon-alarm-clock"></i> <?php echo $row['date'];?>.</p>
			<p style="margin-left:0px;"><i style="background-color: rgba(244, 164, 37, 0.25);padding:6px;border-radius:4px;color:#f4a72d;" class="batch-icon-quill"></i> <?php echo $row['comment'];?></p>
			<br>
			<a class="btn btn-success" href="<?php echo base_url();?>staff/appointment_details/<?php echo base64_encode($row['appointment_id']);?>">Continuar a la cita</a>
		</div>
	</div>
	   <?php } endforeach;?>
	   
<script>
function deleteEvent (){
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Se eliminara el evento de la agenda.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) 
        {
            location.href =  "<?php echo base_url();?>staff/appointments/delete_calendar/"+<?php echo $param2?>;
        }
    })
}


		
		 
		 
		 
 </script>