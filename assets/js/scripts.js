$(document).ready(function(){
    
    
    $('#form_register_comite #email_register_comite').val('bryanmzrom@gmail.com');
    $('#form_register_comite #password_register_comite').val('trzone-b1554');
    $('#form_register_comite #name_register_comite').val('Bryan');
    $('#form_register_comite #last_name_register_comite').val('Martínez Romero');
    $('#form_register_comite #dob_register_comite').val('1992-05-13');
    $('#form_register_comite #phonenumber_register_comite').val('2223637840');
    $('#form_register_comite #city_register_comite').val('Puebla');
    $('#form_register_comite #country_register_comite').find('Puebla');
    $('#form_register_comite #country_register_comite option:eq(150)').prop('selected', true);
    $('#form_register_comite #academia_register_comite').val('Euritmia y Son Latino');


    $('#form_login_comite #email_login').val('bryanmzrom@gmail.com');
    $('#form_login_comite #pass_login').val('trzone-b1554');


})


$('#image_profilepic').change(function(){
    size_profilepic=$('#image_profilepic')[0].files[0].size;
    console.log(size_profilepic)
    
    if(size_profilepic>2000000){
        Swal.fire({
            icon: "error",
            title: "Ocurrió un error...",
            text: "Su foto de perfil debe pesar menos 2MB",                           
        });
        $('#image_profilepic').val('');
    }

})

$('#form_register_comite').submit(function(e){
    e.preventDefault();

    register_formdata = new FormData(this);
    register_formdata.append('action', 'register');
    
    for(let [name, value] of register_formdata) {
        console.log(`${name} = ${value}`);
    }

    
    if (this.checkValidity() === false) {
        this.classList.add('was-validated');
        
        Swal.fire({
            icon: "error",
            title: "Ocurrió un error...",
            text: "Favor de completar el formulario",                           
        });
    } else{
        $.ajax({
            type: 'POST',
            url: './ajax/ajax_user.php',
            data: register_formdata,
            dataType: "json",
            processData: false, 
            contentType: false,
            beforeSend: function () {
                // preloader.classList.add('active');
                // document.querySelector('#textoload').textContent = 'Enviando registro...';
            },
            success: function (data) {
                console.log(data)
                
                if(data.respuesta=='success'){
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Su registro ha sido recibido",
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        window.location.href = "./register-complete";
                    });
                }
                // preloader.classList.remove('active');
                // if (datos.respuesta == 1) {
                //     $('.envioimageexitoso').modal('show')
                //     setTimeout(redirect, 10000)

                // } else {
                //     $('.codinscnovalido').modal('show')
                // }
            }
        })
    }
    

})  


$('#form_login_comite').submit(function(e){
    e.preventDefault();
    
    register_formdata = new FormData(this);
    register_formdata.append('action', 'login');


    for(let [name, value] of register_formdata) {
        console.log(`${name} = ${value}`);
    }

    if (this.checkValidity() === false) {
        this.classList.add('was-validated');
        
        Swal.fire({
            icon: "error",
            title: "Ocurrió un error...",
            text: "Favor de completar el formulario",                           
        });
    } else{

        $.ajax({
            type: 'POST',
            url: './ajax/ajax_user.php',
            data: register_formdata,
            dataType: "json",
            processData: false, 
            contentType: false,
            beforeSend: function () {
                // preloader.classList.add('active');
                // document.querySelector('#textoload').textContent = 'Enviando registro...';
            },
            success: function (data) {
                console.log(data)
                
                if(data.respuesta=='login'){
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Acceso exitoso",
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        // window.location.href = "./register-complete";
                    });
                }else{
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Acceso incorrecto",
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        // window.location.href = "./register-complete";
                    });
                }
               
            }
        })
    }
})