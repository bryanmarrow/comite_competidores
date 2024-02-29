$(document).ready(function(){
    
    
    // $('#form_register_comite #email_register_comite').val('bryanmzrom@gmail.com');
    // $('#form_register_comite #password_register_comite').val('trzone-b1554');
    // $('#form_register_comite #name_register_comite').val('Bryan');
    // $('#form_register_comite #last_name_register_comite').val('Martínez Romero');
    // $('#form_register_comite #dob_register_comite').val('1992-05-13');
    // $('#form_register_comite #phonenumber_register_comite').val('2223637840');
    // $('#form_register_comite #city_register_comite').val('Puebla');
    // $('#form_register_comite #country_register_comite').find('Puebla');
    // $('#form_register_comite #country_register_comite option:eq(150)').prop('selected', true);
    // $('#form_register_comite #academia_register_comite').val('Euritmia y Son Latino');


    // $('#form_login_comite #email_login').val('bryanmzrom@gmail.com');
    // $('#form_login_comite #pass_login').val('trzone-b1554');


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


$('#form_register_comite #email_register_comite').keyup(function(){
    email_register=$('#form_register_comite #email_register_comite').val();
    
    if(email_register.length>5){
        $.ajax({
            type: 'POST',
            url: './ajax/ajax_user.php',
            data: {email_register, action:'check_email'},
            dataType: "json",            
            beforeSend: function () {
                // preloader.classList.add('active');
                // document.querySelector('#textoload').textContent = 'Enviando registro...';
            },
            success: function (data) {                
                if(data.resultados>0){
                    $('#form_register_comite #email_register_comite').val('');

                    Swal.fire({
                        title: "<strong>Su email ya fue registrado anteriormente</strong>",
                        icon: "error",                        
                        showCloseButton: true,
                        showCancelButton: false,
                        focusConfirm: false,
                        confirmButtonText: `
                          <a href="recovery-password" style="color:white"><i class="fa fa-thumbs-up"></i> Recuperar contraseña</a>
                        `                        
                    })
                }                
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
                    data.status_registro==2
                    switch (data.status_registro) {
                        case 2:
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: "Acceso exitoso",
                                showConfirmButton: false,
                                timer: 1500
                            }).then((result) => {
                                window.location.href = "./home";
                            });
                            break;
                        case 1:
                            Swal.fire({
                                position: "center",
                                icon: "error",
                                title: "Su registro aún no ha sido aprobado",
                                showConfirmButton: false,
                                timer: 1500                              
                            })
                            break;                    
                    }
                }else{
                    Swal.fire({
                        title: "<strong>Acceso incorrecto</strong>",
                        icon: "error",                        
                        showCloseButton: true,
                        showCancelButton: false,
                        focusConfirm: false,
                        confirmButtonText: `
                          <a href="recovery-password" style="color:white"><i class="fa fa-thumbs-up"></i> Recuperar contraseña</a>
                        `                        
                    });
                }
               
            }
        })
    }
})

$('#form_recovery_comitee').submit(function(e){
    e.preventDefault();
    
    register_formdata = new FormData(this);
    register_formdata.append('action', 'recovery');

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
                if(data.respuesta=='success'){

                    Swal.fire({                        
                        icon: "success",                        
                        showCloseButton: false,
                        showCancelButton: false,
                        showConfirmButton: false,
                        focusConfirm: false,  
                        html: `
                            <p>En breve recibirá un correo electrónico registrado con el cual podrá recuperar su contraseña</p>
                            <small>No olvide revisar su bandeja de spam y de correos no deseados.</small>
                        `, 
                        timer: 3000                 
                    }).then((result) => {
                        window.location.href = "./index";
                    });

                }else{
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Error, intentar mas tarde",
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

$('#form_new_password').submit(function(e){
    e.preventDefault();
    register_formdata = new FormData(this);
    register_formdata.append('action', 'new-password');

    if (this.checkValidity() === false) {
        this.classList.add('was-validated');
        
        Swal.fire({
            icon: "error",
            title: "Ocurrió un error...",
            text: "Favor de completar el formulario",                           
        });
    } else{
        var password = $("#form_new_password #new_password_comitee").val();
        var confirmPassword = $("#form_new_password #confirm_new_password_comite").val();
        if (password == confirmPassword){
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
    
                        if(data.respuesta=='success'){
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: "Contraseña actualizada",
                                showConfirmButton: false,
                                timer: 3000
                            }).then((result) => {
                                window.location.href = "./index";
                            });
                        }
                    }else{
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            title: "Error, intentar mas tarde",
                            showConfirmButton: false,
                            timer: 1500
                        }).then((result) => {
                            // window.location.href = "./register-complete";
                        });
                    }
                   
                }
            })
        }else{
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Favor de completar el formulario, las contraseñas no coinciden",
                showConfirmButton: false,
                timer: 1500
            }).then((result) => {
                // window.location.href = "./register-complete";
            });
        }
        
    }
    
})


$('#form_new_password #new_password_comitee, #form_new_password #confirm_new_password_comite').on('keyup',function(e){
    console.log('entro')

    var password = $("#form_new_password #new_password_comitee").val();
    var confirmPassword = $("#form_new_password #confirm_new_password_comite").val();
    if (password != confirmPassword)
        $("#CheckPasswordMatch").html("Los password no coinciden!").css("color","red");
    else
        $("#CheckPasswordMatch").html("Los password coinciden!").css("color","green");
})

$(document).on('click', '.logout', function(){
    
    $.ajax({
        type: 'POST',
        url: './ajax/ajax_user.php',
        data: { action: 'logout' },
        dataType: "json",        
        beforeSend: function () {
            // preloader.classList.add('active');
            // document.querySelector('#textoload').textContent = 'Enviando registro...';
        },
        success: function (data) {                
            if(data.respuesta=='success'){

                window.location.href = "./index";
            }
           
        }
    })
})