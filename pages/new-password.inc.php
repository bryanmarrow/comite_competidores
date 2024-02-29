<?php


    $user_recovery=base64_decode($_GET['user_id']);
    $query_email="SELECT * FROM tbl_comite_competidores where user_id='".$user_recovery."'";
    $check_recovery_user=$basededatos->connect()->prepare($query_email);
    $check_recovery_user->execute();    
    $fetch_recovery=$check_recovery_user->fetch();
    $id_user_recovery=$fetch_recovery['id_registro'];

    if($check_recovery_user->rowCount()>0){

?>
<section class="p-0 d-flex align-items-center position-relative overflow-hidden">
	<div class="container-fluid">
		<div class="row">
			<!-- left -->
			<div class="col-12 col-lg-6 d-md-flex align-items-center justify-content-center bg-primary bg-opacity-10 vh-lg-100">
				<div class="p-3 p-lg-5">					
					<!-- SVG Image -->
					<img src="assets/images/element/create-account.svg" class="mt-5" alt="">
					
				</div>
			</div>

			<!-- Right -->
			<div class="col-12 col-lg-6 m-auto">
				<div class="row my-5">
					<div class="col-sm-10 col-xl-8 m-auto">
						<!-- Title -->
						<span class="mb-0 fs-1">👋</span>
						<h1 class="fs-2">Introduce una nueva contraseña</h1>						

						<!-- Form START -->
						<form id="form_new_password">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <label class="form-label">Nueva contraseña</label>
                                    <input class="form-control" type="password" name="new_password_comitee" id="new_password_comitee" placeholder="Ingrese su nueva contraseña" required>
                                </div>  					
                                <div class="col-12 mb-2">
                                    <label class="form-label">Confirmar contraseña</label>
                                    <input class="form-control" type="password" name="confirm_new_password_comitee" id="confirm_new_password_comite" placeholder="Confirmar su contraseña" required>
                                </div>  		
                                <small id="CheckPasswordMatch"></small>			
                                <input type="text" name="user_recovery" value="<?= $id_user_recovery ?>" class="d-none" >
                            </div>
							<!-- Button -->
							<div class="align-items-center mt-0">
								<div class="d-grid">
									<button class="btn btn-primary mb-0" type="submit">Restablecer contraseña</button>
								</div>
							</div>
						</form>
						<!-- Form END -->
					</div>
				</div> <!-- Row END -->
			</div>
		</div> <!-- Row END -->
	</div>
</section>
<?php 
    }
?>