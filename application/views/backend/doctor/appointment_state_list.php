<ul class="tasks-list">
    <li>
        <div class="custom-control custom-radio">
            <input  <?php if ($page_name=="appointments"){ echo 'checked'; } ?> name="type"  type="radio" class="custom-control-input"  id="today" onclick="window.location.href='<?php echo base_url();?>doctor/appointments/';"> 
            <span class="badge badge-today pull-right">
                <?php 
                    if($filter){
                        echo $this->crud_model->count_appointment_today($doctor_id, $apply,$clinic_id);
                    }else{
                        echo $this->crud_model->count_appointment_today($doctor_id, date('d/m/Y'),$clinic_id);
                    }
                ?>
            </span>
            <label class="custom-control-label" for="today">Citas de hoy </label>
        </div>
    </li>
    <li>
        <div class="custom-control custom-radio">
            <input <?php if ($page_name=="pending_payment"){ echo 'checked'; } ?>  name="type"  type="radio" class="custom-control-input" id="customCheck2" onclick="window.location.href='<?php echo base_url();?>doctor/pending_payment/';">
            <span class="badge badge-pending pull-right"><?php 
            if($filter){
                echo $this->crud_model->count_appointment_payment_pending($doctor_id,$apply);
               
            }else{
                echo $this->crud_model->count_appointment_payment_pending($doctor_id,date('d/m/Y'));
            }
            ?></span>
            <label class="custom-control-label" for="customCheck2">Pendientes de pago</label>
        </div>
    </li>
    <li>
        <div class="custom-control custom-radio">
            <input <?php if ($page_name=="soon"){ echo 'checked'; } ?> name="type"  type="radio" class="custom-control-input" id="customCheck3" onclick="window.location.href='<?php echo base_url();?>doctor/soon/';">
            <span class="badge badge-soon pull-right"><?php
            
            if($filter){
                echo $this->crud_model->count_soon($doctor_id,$apply);
               
            }else{
                echo $this->crud_model->count_soon($doctor_id,date('d/m/Y', strtotime("+1 day")));
            }
            ?></span>
            <label class="custom-control-label" for="customCheck3">Próximas</label>
        </div>
    </li>
    <li>
        <div class="custom-control custom-radio">
            <input <?php if ($page_name=="rescheduled"){ echo 'checked'; } ?> name="type"  type="radio" class="custom-control-input" id="customCheck4" onclick="window.location.href='<?php echo base_url();?>doctor/rescheduled/';">
            <span class="badge badge-rep pull-right"><?php 
            
            if($filter){
                echo $this->crud_model->count_rescheduled($doctor_id,$apply);
               
            }else{
                echo $this->crud_model->count_rescheduled($doctor_id,date('d/m/Y'));
            }
        ?></span>
            <label class="custom-control-label" for="customCheck4">Reprogramadas</label>
        </div>
    </li>
    <li>
        <div class="custom-control custom-radio">
            <input <?php if ($page_name=="cancelled"){ echo 'checked'; } ?> name="type"  type="radio" class="custom-control-input" id="customCheck5" onclick="window.location.href='<?php echo base_url();?>doctor/cancelled/';">
            <span class="badge badge-cancelled pull-right"><?php 
            
            if($filter){
                echo $this->crud_model->count_cancelled($doctor_id,$apply);
               
            }else{
                echo $this->crud_model->count_cancelled($doctor_id,date('d/m/Y'));
            }
           ?></span>
            <label class="custom-control-label" for="customCheck5">Canceladas</label>
        </div>
    </li>
    <li>
        <div class="custom-control custom-radio">
            <input <?php if ($page_name=="archived"){ echo 'checked'; } ?>  name="type"  type="radio" class="custom-control-input" id="customCheck6" onclick="window.location.href='<?php echo base_url();?>doctor/archived/';">
            <span class="badge badge-archived pull-right"><?php 
            
            if($filter){
                echo $this->crud_model->count_archived($doctor_id,$apply);
               
            }else{
                echo $this->crud_model->count_archived($doctor_id,date('d/m/Y'));
            }
           ?></span>
            <label class="custom-control-label" for="customCheck6">Archivadas</label>
        </div>
    </li>
</ul>