<div class="modal-content animated fadeInDown" style="border-radius:20px;">
			    <form action="<?php echo base_url();?>doctor/staff/create" method="POST" enctype="multipart/form-data">
				    <div class="modal-header" style="background-color:#fff;  box-shadow: 0 4px 2px -2px 000;" >
					    <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="batch-icon-user-2-add"></i> Agregar nuevo colaborador.</span></h4>
    					<button type="button" class="close" data-dismiss="modal">&times;</button>
				    </div>
				    <div class="modal-body">
					    <div class="form-group">
		                    <div class="container">
		                        <div class="row">
		                            <div class="col-sm-4">
		                                <div class="form-group m-b-15">
        		                            <label for="simpleinput">Primer Nombre<span style="color:red">*</span></label>
		                                    <input type="text" name="first_name" required="" class="form-control">
		                                </div>
		                            </div>
		                            <div class="col-sm-4">
		                                <div class="form-group m-b-15">
        		                            <label for="simpleinput">Segundo Nombre</label>
		                                    <input type="text" name="second_name" class="form-control">
		                                </div>
		                            </div>
		                            <div class="col-sm-4">
		                                <div class="form-group m-b-15">
        		                            <label for="simpleinput">Tercer Nombre</label>
		                                    <input type="text" name="third_name"  class="form-control">
		                                </div>
		                            </div>
		                            <div class="col-sm-4">
		                                <div class="form-group m-b-15">
        		                            <label for="simpleinput">Primer Apellido<span style="color:red">*</span></label>
		                                    <input type="text" name="last_name" required="" class="form-control">
		                                </div>
		                            </div>
		                            <div class="col-sm-4">
		                                <div class="form-group m-b-15">
        		                            <label for="simpleinput">Segundo Apellido</label>
		                                    <input type="text" name="second_last_name"  class="form-control">
		                                </div>
		                            </div>
		                            <div class="col-sm-4">
		                                <div class="form-group m-b-15">
        		                            <label for="simpleinput">Apellido de casada</label>
		                                    <input type="text" name="married_last_name"  class="form-control">
		                                </div>
		                            </div>
									<div class="col-sm-4">
										<div class="form-group date-time-picker m-b-15">
											<label for="simpleinvput">Nacimiento</label>
											<div class="input-group date datepicker" id="DoctorPicker1">
											<input style="border: 1px solid #198cff8f;" type="text" id="applyDate" name="date_of_birth" autocomplete="off" style="border: 1px solid #198cff8f;" value="<?php echo date('d/m/Y');?>" class="form-control">
											<span style="display: none;" class="input-group-addon"><i data-feather="calendar"></i></span>
										</div>
										</div>
									</div>
									<div class="col-sm-4">
		                                <div class="form-group m-b-15">
        		                            <label for="simpleinput">Correo<span style="color:red">*</span></label>  <span class="" id="errorm"></span>
		                                    <input type="email" name="email" id="email" required="" onkeyup="validateEmail();" class="form-control">
		                                  	
		                                </div>
		                            </div>
		                            <div class="col-sm-4">
		                                <div class="form-group m-b-15">
        		                            <label for="simpleinput">Identificación<span style="color:red">*</span></label>  <span class="" id="errordpi"></span>
		                                    <input type="number" name="dpi" id="dpi" required="" onkeyup="validateDPI(this.value);" class="form-control">
		                                </div>
		                            </div>
		                            <div class="col-sm-4">
		                                <div class="form-group m-b-15">
        		                            <label for="simpleinput">Celular<span style="color:red">*</span></label>
		                                    <input type="text" name="phone" required="" class="form-control">
											<small>* Ingresar código de área p.j: 502xxxx-xxxx</small>
		                                </div>
		                            </div>
		                           
		                            <div class="col-sm-4">
		                                <div class="form-group m-b-15">
		                                     <label for="simpleinput">Tipo de cuenta<span style="color:red">*</span></label>
		                                     <select class="form-control" name="charge" required>
		                                         <option value="">Seleccionar</option>
		                                         <option value="Secretaria">Secretaria</option>
		                                         <option value="Asistente">Asistente</option>
		                                     </select>
        		                           </div>
		                               
		                            </div>
		                           
		                            <div class="col-sm-4">
		                                <div class="form-group m-b-15">
		                                     <label for="simpleinput">Salario<span style="color:red">*</span></label>
        		                             
		                                    
		                                    
		                                       <input type="number" name="salary" class="form-control">  
		                               </div> 
		                            </div>
		                            
		                            <div class="col-sm-6">
		                                 <div class="form-group">
                                        <label>Género:</label>
                                        <div class="input-group">
                                            <div class="form-check" style="padding-left: 0px;padding-right:2px">
                                              <input checked class="radiobutton" type="radio" name="gender" id="radio3" value="M">
                                              <label class="radiobutton-label" for="radio3">Masculino</label>
                                            </div>
                                            <div class="form-check"  style="padding-left: 0px;">
                                              <input  class="radiobutton" type="radio" name="gender" id="radio4" value="F">
                                              <label class="radiobutton-label" for="radio4">Femenino</label>
                                            </div>
                                        </div>
                                    </div>
		                             </div>
		                             <div class="col-sm-6">
		                                <div class="form-group m-b-15">
        		                            <label for="simpleinput">Fotografía</label>
		                                    <label class="labelx" for="apply"><input type="file" name="photo" class="inputx" id="apply" accept="image/*">Seleccionar</label>
    		                                <small id="fileResponse"></small>
		                                </div>
		                            </div>
		                              <div class="col-sm-12">
	                            <label>Redes sociales</label>
	                                <div class="row">
	                                  
	  	                              <div class="col-sm-5">
		                                  <div class="col-sm-12">
        		                            <div class="form-group m-b-15">
                		                        <div class="form-group">
         		                                    <div class="custom-control custom-checkbox mr-sm-2">
        		                                        <input type="checkbox" id="invc" name="Facebook" value="1" class="custom-control-input check">
            		                                    <label class="custom-control-label" for="invc">Facebook</label>
        		                                    </div>
        								        </div>
        		                            </div>
        		                          </div>
        		                           
        		                           <div class="col-sm-12"  id="fb">
        		                                <div class="form-group m-b-15">
                		                           <label for="simpleinput">Ingrese link de Facebook</label></label>
        		                                    <div class="form-group">
         		                                        <input style="border: 1px solid #198cff8f;" type="text" name="link_facebook" class="form-control">
        		                                    </div>
        		                                </div>
        		                            </div>
		                              </div>
	                              
	                              <div class="col-sm-5">
	                                  <div class="col-sm-12">
    		                            <div class="form-group m-b-15">
            		                        <div class="form-group">
     		                                    <div class="custom-control custom-checkbox mr-sm-2">
    		                                        <input style="border: 1px solid #198cff8f;" type="checkbox" id="invc3" name="Instagram" value="1" class="custom-control-input check">
        		                                    <label class="custom-control-label" for="invc3">Instagram</label>
    		                                    </div>
    								        </div>
    		                            </div>
    		                          </div>
        		                           
    		                           <div class="col-sm-12"  id="Ig">
    		                                <div class="form-group m-b-15">
            		                           <label for="simpleinput">Ingrese link de Instagram</label></label>
    		                                    <div class="form-group">
     		                                        <input style="border: 1px solid #198cff8f;" type="text" name="link_instagram" class="form-control">
    		                                    </div>
    		                                </div>
    		                            </div>
	                              </div>
	                              
	                              <div class="col-sm-2">
	                                  <div class="col-sm-12">
    		                            <div class="form-group m-b-15">
            		                        <div class="form-group">
     		                                    <div class="custom-control custom-checkbox mr-sm-2">
    		                                        <input type="checkbox" id="invc2" name="Whatsapp" value="1" class="custom-control-input check">
        		                                    <label class="custom-control-label" for="invc2">WhatsApp</label>
    		                                    </div>
    								        </div>
    		                            </div>
    		                          </div>
        		                  </div>
        		              </div>
            		      </div>
		                             <div class="col-sm-12">
		                                <div class="form-group m-b-15">
        		                            <label for="simpleinput">Dirección</label>
		                                    <textarea type="text" name="address" class="form-control"></textarea>
		                                </div>
		                            </div>
		                             
		                            
		                            <div class="col-sm-12">
		                                <label>¿Modulos a los que tendra acceso?</label>
		                                <div class="row">
		                                
		                                
		                                <div class="col-sm-2 col-xl-4">
		                                     <div class="form-group">
                                                <label>¿Podra dar permisos?</label>
                                                <div class="input-group">
                                                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                                                      <input class="radiobutton" type="radio" name="moduls" id="modulos" value="1">
                                                      <label class="radiobutton-label" for="modulos">Sí</label>
                                                    </div>
                                                    <div class="form-check"  style="padding-left: 0px;">
                                                      <input  class="radiobutton" type="radio" name="moduls" checked id="modulosno" value="0">
                                                      <label class="radiobutton-label" for="modulosno">No</label>
                                                    </div>
                                                </div>
                                            </div>
		                                </div>
	                                
		                                <div class="col-sm-2 col-xl-4">
		                                    <div class="form-group">
                                                <label>Chat</label>
                                                <div class="input-group">
                                                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                                                      <input class="radiobutton" type="radio" name="chat" id="chat" value="1">
                                                      <label class="radiobutton-label" for="chat">Sí</label>
                                                    </div>
                                                    <div class="form-check"  style="padding-left: 0px;">
                                                      <input  class="radiobutton" type="radio" name="chat" checked id="chatno" value="0">
                                                      <label class="radiobutton-label" for="chatno">No</label>
                                                    </div>
                                                </div>
                                            </div>
		                                </div>
		                                
		                                <div class="col-sm-2 col-xl-4">
		                                    <div class="form-group">
                                                <label>Citas</label>
                                                <div class="input-group">
                                                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                                                      <input class="radiobutton" type="radio" name="appointments" id="appointments" value="1">
                                                      <label class="radiobutton-label" for="appointments">Sí</label>
                                                    </div>
                                                    <div class="form-check"  style="padding-left: 0px;">
                                                      <input  class="radiobutton" type="radio" name="appointments" checked id="appointmentsno" value="0">
                                                      <label class="radiobutton-label" for="appointmentsno">No</label>
                                                    </div>
                                                </div>
                                            </div>
		                                </div>
		                                
		                                <div class="col-sm-2 col-xl-4">
		                                    <div class="form-group">
                                                <label>Pacientes</label>
                                                <div class="input-group">
                                                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                                                      <input class="radiobutton" type="radio" name="patients" id="patients" value="1">
                                                      <label class="radiobutton-label" for="patients">Sí</label>
                                                    </div>
                                                    <div class="form-check"  style="padding-left: 0px;">
                                                      <input  class="radiobutton" type="radio" name="patients" checked id="patientsno" value="0">
                                                      <label class="radiobutton-label" for="patientsno">No</label>
                                                    </div>
                                                </div>
                                            </div>
		                                </div>
		                                
		                                <div class="col-sm-2 col-xl-4">
		                                    <div class="form-group">
                                                <label>Doctores</label>
                                                <div class="input-group">
                                                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                                                      <input class="radiobutton" type="radio" name="doctors" id="doctors" value="1">
                                                      <label class="radiobutton-label" for="doctors">Sí</label>
                                                    </div>
                                                    <div class="form-check"  style="padding-left: 0px;">
                                                      <input  class="radiobutton" type="radio" name="doctors"  checked id="doctorsno" value="0">
                                                      <label class="radiobutton-label" for="doctorsno">No</label>
                                                    </div>
                                                </div>
                                            </div>
		                                </div>
		                                
		                                <div class="col-sm-2 col-xl-4">
		                                    <div class="form-group">
                                                <label>Equipo</label>
                                                <div class="input-group">
                                                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                                                      <input class="radiobutton" type="radio" name="staff" id="staff" value="1">
                                                      <label class="radiobutton-label" for="staff">Sí</label>
                                                    </div>
                                                    <div class="form-check"  style="padding-left: 0px;">
                                                      <input  class="radiobutton" type="radio" name="staff" checked id="staffno" value="0">
                                                      <label class="radiobutton-label" for="staffno">No</label>
                                                    </div>
                                                </div>
                                            </div>
		                                </div>
		                                
		                                <div class="col-sm-2 col-xl-4">
		                                    <div class="form-group">
                                                <label>Inventario</label>
                                                <div class="input-group">
                                                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                                                      <input class="radiobutton" type="radio" name="inventory" id="inventory" value="1">
                                                      <label class="radiobutton-label" for="inventory">Sí</label>
                                                    </div>
                                                    <div class="form-check"  style="padding-left: 0px;">
                                                      <input  class="radiobutton" type="radio" name="inventory" checked id="inventoryno" value="0">
                                                      <label class="radiobutton-label" for="inventoryno">No</label>
                                                    </div>
                                                </div>
                                            </div>
		                                </div>
		                                
		                                <div class="col-sm-2 col-xl-4">
		                                    <div class="form-group">
                                                <label>Finanzas</label>
                                                <div class="input-group">
                                                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                                                      <input class="radiobutton" type="radio" name="financial" id="financial" value="1">
                                                      <label class="radiobutton-label" for="financial">Sí</label>
                                                    </div>
                                                    <div class="form-check"  style="padding-left: 0px;">
                                                      <input  class="radiobutton" type="radio" name="financial" checked id="financialno" value="0">
                                                      <label class="radiobutton-label" for="financialno">No</label>
                                                    </div>
                                                </div>
                                            </div>
		                                </div>
		                                
		                                <div class="col-sm-2 col-xl-4">
		                                    <div class="form-group">
                                                <label>Reportes</label>
                                                <div class="input-group">
                                                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                                                      <input class="radiobutton" type="radio" name="reports" id="reports" value="1">
                                                      <label class="radiobutton-label" for="reports">Sí</label>
                                                    </div>
                                                    <div class="form-check"  style="padding-left: 0px;">
                                                      <input  class="radiobutton" type="radio" name="reports" checked id="reportsno" value="0">
                                                      <label class="radiobutton-label" for="reportsno">No</label>
                                                    </div>
                                                </div>
                                            </div>
		                                </div>
		                                
		                                <div class="col-sm-2 col-xl-4">
		                                    <div class="form-group">
                                                <label>Configuración</label>
                                                <div class="input-group">
                                                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                                                      <input class="radiobutton" type="radio" name="settings" id="settings" value="1">
                                                      <label class="radiobutton-label" for="settings">Sí</label>
                                                    </div>
                                                    <div class="form-check"  style="padding-left: 0px;">
                                                      <input  class="radiobutton" type="radio" name="settings" checked id="settingsno" value="0">
                                                      <label class="radiobutton-label" for="settingsno">No</label>
                                                    </div>
                                                </div>
                                            </div>
		                                </div>
		                               </div> 
		                            </div>
		                        </div>
		                    </div>
    		            </div> 
		            </div>
				    <div class="modal-footer">
					    <button type="submit" class="button-confirm">Enviar</button>
				    </div>
				</form>
			</div>
			
			<script type="text/javascript">

document.getElementById('apply').onchange = function () {
   var filename = this.value.replace(/C:\\fakepath\\/i, '')
   $( "#fileResponse" ).html('<b>Archivo seleccionado:</b> '+filename);
};
$(function() {
            'use strict';
            if($('#DoctorPicker1').length) {
                var date = new Date();
                var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
                $('#DoctorPicker1').datepicker({
                    format: "dd/mm/yyyy",
                    todayHighlight: true,
                    autoclose: true
                });
            }
        });

    $('#fb').hide();
    $('#Ig').hide();
    
    $(function()
    {
      $('[name="Facebook"]').change(function()
      {
        if ($(this).is(':checked')) {
            $('#fb').show(500);
        }
        else{
            $('#fb').hide(500);
        };
      });
    });
    
    $(function()
    {
      $('[name="Instagram"]').change(function()
      {
        if ($(this).is(':checked')) {
            $('#Ig').show(500);
        }
        else{
            $('#Ig').hide(500);
        };
      });
    });
</script>
<script>
    
      function cuiIsValid(cui) {
                            var console = window.console;
                            
                            if (!cui) {
                                console.log("CUI vacío");
                                return true;
                            }
                        
                            var cuiRegExp = /^[0-9]{4}\s?[0-9]{5}\s?[0-9]{4}$/;
                        
                            if (!cuiRegExp.test(cui)) {
                                console.log("CUI con formato inválido");
                                return false;
                            }
                        
                            cui = cui.replace(/\s/, '');
                            var depto = parseInt(cui.substring(9, 11), 10);
                            var muni = parseInt(cui.substring(11, 13));
                            var numero = cui.substring(0, 8);
                            var verificador = parseInt(cui.substring(8, 9));
                            
                            // Se asume que la codificación de Municipios y 
                            // departamentos es la misma que esta publicada en 
                            // http://goo.gl/EsxN1a
                        
                            // Listado de municipios actualizado segun:
                            // http://goo.gl/QLNglm
                        
                            // Este listado contiene la cantidad de municipios
                            // existentes en cada departamento para poder 
                            // determinar el código máximo aceptado por cada 
                            // uno de los departamentos.
                            var munisPorDepto = [ 
                                /* 01 - Guatemala tiene:      */ 17 /* municipios. */, 
                                /* 02 - El Progreso tiene:    */  8 /* municipios. */, 
                                /* 03 - Sacatepéquez tiene:   */ 16 /* municipios. */, 
                                /* 04 - Chimaltenango tiene:  */ 16 /* municipios. */, 
                                /* 05 - Escuintla tiene:      */ 13 /* municipios. */, 
                                /* 06 - Santa Rosa tiene:     */ 14 /* municipios. */, 
                                /* 07 - Sololá tiene:         */ 19 /* municipios. */, 
                                /* 08 - Totonicapán tiene:    */  8 /* municipios. */, 
                                /* 09 - Quetzaltenango tiene: */ 24 /* municipios. */, 
                                /* 10 - Suchitepéquez tiene:  */ 21 /* municipios. */, 
                                /* 11 - Retalhuleu tiene:     */  9 /* municipios. */, 
                                /* 12 - San Marcos tiene:     */ 30 /* municipios. */, 
                                /* 13 - Huehuetenango tiene:  */ 32 /* municipios. */, 
                                /* 14 - Quiché tiene:         */ 21 /* municipios. */, 
                                /* 15 - Baja Verapaz tiene:   */  8 /* municipios. */, 
                                /* 16 - Alta Verapaz tiene:   */ 17 /* municipios. */, 
                                /* 17 - Petén tiene:          */ 14 /* municipios. */, 
                                /* 18 - Izabal tiene:         */  5 /* municipios. */, 
                                /* 19 - Zacapa tiene:         */ 11 /* municipios. */, 
                                /* 20 - Chiquimula tiene:     */ 11 /* municipios. */, 
                                /* 21 - Jalapa tiene:         */  7 /* municipios. */, 
                                /* 22 - Jutiapa tiene:        */ 17 /* municipios. */ 
                            ];
                            
                            if (depto === 0 || muni === 0)
                            {
                                console.log("CUI con código de municipio o departamento inválido.");
                                return false;
                            }
                            
                            if (depto > munisPorDepto.length)
                            {
                                console.log("CUI con código de departamento inválido.");
                                return false;
                            }
                            
                            if (muni > munisPorDepto[depto -1])
                            {
                                console.log("CUI con código de municipio inválido.");
                                return false;
                            }
                            
                            // Se verifica el correlativo con base 
                            // en el algoritmo del complemento 11.
                            var total = 0;
                            
                            for (var i = 0; i < numero.length; i++)
                            {
                                total += numero[i] * (i + 2);
                            }
                            
                            var modulo = (total % 11);
                            
                            console.log("CUI con módulo: " + modulo);
                            return modulo === verificador;
                        };
                        
        function validateDPI(ddd) {
            var $this = $(this);
            var $parent = $this.parent();
            var $next = $this.next();
            var cui = ddd;
            
            
            
            if (cui && cuiIsValid(cui)) {
                
               
                        
                        $('#errordpi').removeClass('error');
                        $('#errordpi').removeClass('error_show');
                        $('#errordpi').removeClass('success');
    			
    				   $('#errordpi').text('DPI valido').addClass('success').animate({ }, 300);
                         $('input[name ="dpi"]')[0].setCustomValidity('');
                
            } else if (cui) {
                
                
               
                        $('#errordpi').removeClass('error');
                        $('#errordpi').removeClass('error_show');
                        $('#errordpi').removeClass('success');
    			
    				   $('#errordpi').text('Debe ingresar un DPI').addClass('error').animate({ }, 300);
    				     $('input[name ="dpi"]')[0].setCustomValidity('DPI no valido');
    				   
            } else {
                
             
                        $('#errordpi').removeClass('error');
                        $('#errordpi').removeClass('error_show');
                        $('#errordpi').removeClass('success');
    			
    				   $('#errordpi').text('DPI no valido').addClass('error').animate({ }, 300);
    				   $('input[name ="dpi"]')[0].setCustomValidity('DPI no puede quedar vacio');
    				  
    				   
    				   
            }
        };
                        
        
       //Validar correo electronico  
        function validateEmail() {

            var email = $('input[name ="email"]').val();
            
            console.log(email);
            

                    //validar correo electronico
                	var validacion_email = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
                    
            				if (!validacion_email.test(email))
            				{   
                     				    
                    				   
                    				    $('#errorm').removeClass('error');
                                        $('#errorm').removeClass('error_show');
                                        $('#errorm').removeClass('success');
                    			
                    				   $('#errorm').text('correo electronico no valido').addClass('error').animate({ }, 300);
                    				   $('input[name ="email"]')[0].setCustomValidity('correo no valido');
            				    
            				}   else
            				{
            				    
            				      $.ajax({
                                        type:"POST",
                                        url:"<?php echo base_url();?>doctor/check_m",
                                        data: {
                                                'mail':email
                                            },
                                            success:function (data) {
                                               
                                               console.log(data.available);
                                               if(data.available >0) 
                                               {
                                                   
                                                    $('#errorm').removeClass('error');
                                                    $('#errorm').removeClass('error_show');
                                                    $('#errorm').removeClass('success');
                                    			    $('#errorm').text('correo electronico no disponible').addClass('error').animate({ }, 300);
                                    			    $('input[name ="email"]')[0].setCustomValidity('correo electronico no disponible');
                                    			    
                                               }else
                                               {    
                                                    $('#errorm').removeClass('error');
                                                    $('#errorm').removeClass('error_show');
                                                    $('#errorm').removeClass('success_show');
                                                        
                                    				$('#errorm').text('Este correo esta disponible').addClass('success').animate({ }, 300);
                                                   $('input[name ="email"]')[0].setCustomValidity('');
                                               }
                                                
                                      	 	},error:function(jqXHR, textStatus, errorThrown){
                                                 console.log('error: '+ errorThrown);
                                    }
                                   
                                   	});
            					                                 


                                
		                    }
        };
</script>