<section class="p-0 d-flex align-items-center position-relative overflow-hidden">
	
    <div class="container-fluid">
        <div class="row">
            <!-- left -->
            <div class="col-12 col-lg-6 d-md-flex align-items-center justify-content-center bg-primary bg-opacity-10 vh-lg-100">
                <div class="p-3 p-lg-5">
                    <!-- Title -->
                    <div class="text-center">
                        <h2 class="fw-bold">Solicitud de registro</h2>
                        
                    </div>
                    <!-- SVG Image -->
                    <img src="assets/images/element/create-account.svg" class="mt-5" alt="">
                   
                </div>
            </div>

            <!-- Right -->
            <div class="col-12 col-lg-6 m-auto">
                    <form id="form_register_comite">
                        <div class="row">
                            <div class="col-6 mb-2">
                                <label class="form-label">Email</label>
                                <input class="form-control" type="text" name="email_register_comite" id="email_register_comite" placeholder="Ingrese su correo electrónico" required>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label">Contraseña</label>
                                <input class="form-control" type="password" name="password_register_comite" id="password_register_comite" placeholder="Ingrese su contraseña" required>
                            </div>                        
                            <div class="col-6 mb-2">
                                <label class="form-label">Nombre</label>
                                <input class="form-control" type="text" name="name_register_comite" id="name_register_comite" placeholder="Ingrese su nombre" required>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label">Apellidos</label>
                                <input class="form-control" type="text" name="last_name_register_comite" id="last_name_register_comite" placeholder="Ingrese su apellidos" required>
                            </div>                        
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Fecha de nacimiento</label>
                                <input class="form-control" name="dob_register_comite" id="dob_register_comite" type="date" required>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label">Número telefónico</label>
                                <input class="form-control" type="tel" name="phonenumber_register_comite" id="phonenumber_register_comite" placeholder="Ingrese su número telefónico" required>
                            </div>
                        
                            <div class="col-6 mb-2">
                                <label class="form-label">Ciudad</label>
                                <input class="form-control" id="city_register_comite" name="city_register_comite" type="text" placeholder="Ingrese su ciudad" required>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label">País</label>
                                <select class="form-select" id="country_register_comite" name="country_register_comite" id="" required>
                                    <option value="">Seleccionar una opción</option>
                                    <?php 
                                        $query_paises="SELECT * FROM tbl_paises";
                                        $paises=$basededatos->connect()->prepare($query_paises);
                                        $paises->execute();
                                        $fetch_paises=$paises->fetchAll();

                                        foreach($fetch_paises as $row){
                                    ?>  
                                        
                                        <option value="<?= $row['id'] ?>"><?= $row['pais'] ?></option>                                
                                    <?php 
                                        }
                                    ?>
                                    
                                </select>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label">Nombre de la academia (Opcional)</label>
                                <input class="form-control" id="academia_register_comite" name="academia_register_comite" type="text" placeholder="Ingrese su academia">
                            </div>
                            
                            
                            
                            <div class="col-12 mb-2">
                                <label class="form-label">Foto de perfil</label>
                                <div class="text-center justify-content-center align-items-center p-4 p-sm-5 border border-2 border-dashed position-relative rounded-3">
                                    <!-- Image -->
                                    <img src="assets/images/element/gallery.svg" class="h-50px" alt="">
                                    <div>
                                        <h6 class="my-2">Carga una imagen, or<a href="instructor-create-course.html#!" class="text-primary"> Browse</a></h6>
                                        <label style="cursor:pointer;">
                                            <span> 
                                                <input class="form-control stretched-link" type="file" name="profilepic_user" id="image_profilepic" accept="image/gif, image/jpeg, image/png" required />
                                            </span>
                                        </label>
                                            <p class="small mb-0 mt-2"><b><span class="text-danger">Nota importante:</span></b> 
                                            La imagen que cargue tiene que ser personal y en la cual se muestra en su mayoría su rostro ya que de eso depende que su registro sea autorizado.
                                            </p>
                                    </div>	
                                </div>
                            </div>                                    
                        </div>
                        <!-- Button -->
                        <div class="align-items-center mt-4">
                            <div class="d-grid">
                                <button class="btn btn-primary mb-0" type="submit">Enviar solicitud de registro</button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</section>