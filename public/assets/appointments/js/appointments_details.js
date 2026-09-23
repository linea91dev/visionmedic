function multi() {
    var height = $('#height').val();
    var weight = $('#weight').val();
    Meters = height;
    Kilos = weight;
    Square = Meters * Meters;
    var results = Math.round(Kilos * 10 / Square) / 10;
    $('#results').val(results.toFixed(2));
    $('#mass').val(results.toFixed(2));
}

function imcIngles() {
    var feet = $("input[name=feet]").val();
    var inches = $("input[name=inches]").val() || 0;
    var totalInches = eval(feet*12) + eval(inches);
    var totalWeight = $("input[name=pounds]").val();
    var m = totalInches/39.370;
    var kg = totalWeight/2.2046;
    $('#height').val(m);
    $('#weight').val(kg);
    if(totalWeight == "")
    {
        $('#results').val(0);
        $('#mass').val(0); 
    }else
    {
        var weight = parseFloat(totalWeight, 10);
        var height = parseFloat(totalInches, 10);
        var bmi = Math.round(weight * 703 * 10 / height / height) / 10;
        $('#results').val(bmi.toFixed(2));
        $('#mass').val(bmi.toFixed(2));  
    }
}

var patient_id = $("#patient_id").val(); 
var appointment_id = $("#appointment_id").val(); 
 
function submit_recet(app_id) 
{
    var medicine = $("#medicine").val();
    var quantity = $("#drink").val();
    var frequency = $("#frequency").val();
    var duration = $("#duration").val();
    var treatment_id = $("#duration").val();
    if (app_id != '' && medicine != '' && quantity != '' && frequency != '' && duration != '') {
        $.ajax({
            url: base_url+"doctor/prescriptions/create/",
            type: 'POST',
            data: {
                medicine: medicine,
                quantity: quantity,
                frequency: frequency,
                duration: duration,
                appointment_id: app_id,
                patient_id: patient_id
            },
            success: function(result) {
                $("#medicine").val('');
                $("#drink").val('');
                $("#frequency").val('');
                $("#duration").val('');
                $("#patient_id").val('');
                update_table(app_id);
            }
        });
    } else {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            showConfirmButton: false,
            timer: 5000
        });
        Toast.fire({
            type: 'error',
            title: 'Todos los campos son necesarios'
        })
    }
};

function delete_element(element_id, app_id) 
{
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Se eliminará la información a este medicamento.",
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#9fd13b',
            cancelButtonColor: '#fd4f57',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) 
            {
        $.ajax({
            url: base_url+'doctor/prescriptions/delete/' + element_id,
            success: function(response) {
                update_table(app_id);
            }
        });
        }
    })
}

function update_table(appointment_id) {
    $.ajax({
        url: base_url+'doctor/update_prescription_table/' + appointment_id,
        success: function(response) {
            jQuery('#table_results_'+appointment_id).html(response);
        }
    });
}

function drink() {
    $('#drink').typeahead({
        source: ['1/2 tableta', '1 tableta', '2 tabletas', '1 ampolleta', '1 cápsula', '2 cápsulas', '1 pastilla', '2 pastillas', '1 cucharada', '1 gota', '2 gotas', '2.5 ML', '5 ML', '10 ML'],
        autoSelect: false,
        items: 1000,
        minLength: 0
    });
    $('#drink').trigger('keyup');
    $('#drink').focus();
}

function frequency() {
    $('#frequency').typeahead({
        source: ['cada 4 horas', 'cada 6 horas', 'cada 8 horas', 'cada 12 horas', 'cada 24 horas'],
        autoSelect: false,
        items: 1000,
        minLength: 0
    });
    $('#frequency').trigger('keyup');
    $('#frequency').focus();
}

function duration() {
    $('#duration').typeahead({
        source: ['3 días', '5 días', '7 días', '10 días', '15 días', '30 dias'],
        autoSelect: false,
        items: 1000,
        minLength: 0
    });
    $('#duration').trigger('keyup');
    $('#duration').focus();
}

$(document).on("keyup", function(e) {
    if ($('#drink').is(":focus")) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 9) {
            drink();
        }
    }
});


$( document ).ready(function() {
    console.log( app );
    $( "#d-"+app ).click();
});

$(document).on("keyup", function(e) {
    if ($('#frequency').is(":focus")) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 9) {
            frequency();
        }
    }
});
$(document).on("keyup", function(e) {
    if ($('#duration').is(":focus")) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 9) {
            duration();
        }
    }
    });
    $('#drink').click(
    function() {
        drink();
    });
    $('#frequency').click(
    function() {
        frequency();
    });
    $('#duration').click(
    function() {
        duration();
    });
    $('#patient_id').click(
    function() {
        patient_id();
    });

if (typeof CKEDITOR !== 'undefined') {
    CKEDITOR.disableAutoInline = true;
    if ($('#ckeditorEmail').length) {
        CKEDITOR.config.uiColor = '#ffffff';
        CKEDITOR.config.toolbar = [
            ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'About']
        ];
        CKEDITOR.config.height = 110;
        CKEDITOR.replace('reason');
    }
    if ($('#ckeditorEmail1').length) {
        CKEDITOR.config.uiColor = '#ffffff';
        CKEDITOR.config.toolbar = [
            ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'About']
        ];
        CKEDITOR.config.height = 110;
        CKEDITOR.replace('exploration');
    }
    if ($('#ckeditorEmail12').length) {
        CKEDITOR.config.uiColor = '#ffffff';
        CKEDITOR.config.toolbar = [
            ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'About']
        ];
        CKEDITOR.config.height = 110;
        CKEDITOR.replace('instructions');
    }
    if ($('#ckplan').length) {
        CKEDITOR.config.uiColor = '#ffffff';
        CKEDITOR.config.toolbar = [
            ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'About']
        ];
        CKEDITOR.config.height = 110;
        CKEDITOR.replace('ckplan');
    }
    if ($('#ckeditor25').length) {
        CKEDITOR.config.uiColor = '#ffffff';
        CKEDITOR.config.toolbar = [
            ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'About']
        ];
        CKEDITOR.config.height = 110;
        CKEDITOR.replace('ckeditor25');
    }
}

function confirm_appointment(appointment_id) {
    Swal.fire({
        title: 'Confirmar esta acción',
        text: "Esta acción no puede deshacerse, la cita comentará inmediatamente después de la confirmación.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Continuar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = base_url+"doctor/appointments/start/" + appointment_id;
        }
    })
}

function showAjaxModal(url)
{
    jQuery('#exampleModal .modal-dialog').html('<center><img style="background-color:#fff;border-radius:50%; width:85px" src="https://mayansource.dev/medesk/uploads/loader.gif" /></center>');
    jQuery('#exampleModal').modal('show', {backdrop: 'true'});
    $.ajax({
        url: url,
        success: function(response)
        {
            jQuery('#exampleModal .modal-dialog').html(response);
        }
    });
}

function change_amout(amount,id) 
{
    var total = amount;
   
  tt = document.getElementById("total_text_"+id);
  tt.innerText= total;
  n = document.getElementById("totalGeneral_"+id);
  n.value = total;
}

function set_amout() {
    var amount = $('#amount').val();
    var text = $('#total').html('Q' + amount);
}
items = document.getElementsByClassName("itemTotalNeto")
for (var i = 0; i < items.length; i++) {
 items[i].addEventListener('change', function() {
  n = document.getElementById("totalGeneral");
  n.value = parseInt("0"+n.value) + parseInt("0"+this.value) - parseInt("0"+this.defaultValue);
 this.defaultValue = this.value;
 });
};


function updateVital(cl,_id,text)
{
    console.log(cl);
    console.log(_id);
    console.log(text);
    $.ajax({
        url: base_url+"/doctor/patient_vitals",
        type: "post",
        data: {
            'cl':cl,
            'id':_id,
            'value':text,
        } ,
        success: function (response) {

            const Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            showConfirmButton: false,
            timer: 5000
            }); 
            Toast.fire({
                type: 'success',
                title: 'Actualizado'
            })
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });
}


function updateConsulta(cl,_id,text)
{
    console.log(cl);
    console.log(_id);
    console.log(text);
    $.ajax({
        url: base_url+"/doctor/patient_app",
        type: "post",
        data: {
            'cl':cl,
            'id':_id,
            'value':text,
        } ,
        success: function (response) {

            const Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            showConfirmButton: false,
            timer: 5000
            }); 
            Toast.fire({
                type: 'success',
                title: 'Actualizado'
            })
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });
}


function updateDataPatient(cl,_id,text)
{
  
    $.ajax({
        url: base_url+"/doctor/updateDataPatient",
        type: "post",
        data: {
            'cl':cl,
            'id':_id,
            'value':text,
        },
        success: function (response) {

            const Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            showConfirmButton: false,
            timer: 5000
            }); 
            Toast.fire({
                type: 'success',
                title: 'Actualizado'
            })
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });

    
}