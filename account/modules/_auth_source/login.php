<div class="col-md-8 col-lg-6 col-xl-5" id="loginSection" style="display: none;">
    <div class="card overflow-hidden">
        <div class="bg-primary bg-soft">
            <div class="row">
                <div class="col-8">
                    <div class="text-primary p-4">
                        <h5 class="text-primary">Account Login</h5>
                        <p>Easily access your verified trading account on our platform today.</p>
                    </div>
                </div>
                <div class="col-4 align-self-end">
                    <img src="./_vendors/images/profile-img.png" alt="" class="img-fluid">
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div>
                <a href="../">
                    <div class="avatar-md profile-user-wid mb-4">
                        <span class="avatar-title rounded-circle bg-light">
                            <img src="./_vendors/images/logo.svg" alt="" class="rounded-circle" height="34">
                        </span>
                    </div>
                </a>
            </div>

            <?php
            if (isset($_SESSION['feedback'])) {
                $feedback = $_SESSION['feedback'];
                unset($_SESSION['feedback']);
            ?>
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-bullseye-arrow me-2"></i>
                    <?php echo $feedback ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
            }
            ?>

            <div class="p-2">
                <form class="needs-validation" method="post" novalidate action="./auth0">
                    <div class="mb-3">
                        <label for="login_email_address" class="form-label">Email Address<sup class="text-danger fw-bold">*</sup></label>
                        <input type="email" class="form-control" id="login_email_address" placeholder="e.g. johndoe@gmail.com" name="email_address" required>
                        <div class="invalid-feedback">
                            Please Enter Email Address
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex">
                            <label for="login_password" class="form-label">Password<sup class="text-danger fw-bold">*</sup></label>
                            <a href="javascript:void(0);" onclick="toggleVisibility('recoverySection');" class="ms-auto">Forgot Password ?</a>
                        </div>
                        <input type="password" class="form-control" id="login_password" placeholder="8+ characteres required" minlength="8" name="password" required>
                        <div class="invalid-feedback">
                            Please Enter Password
                        </div>
                    </div>

                    <div class="mt-4 d-grid">
                        <button class="btn btn-primary waves-effect waves-light" name="initialize_login" type="submit">Authenticate Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="mt-4 text-center">
        <div>
            <p>Don't have an account ? <a href="javascript:void(0);" class="fw-medium text-primary" onclick="toggleVisibility('registrationSection');"> Register</a> </p>
            <p>© <script>
                    document.write(new Date().getFullYear())
                </script> <a href="../">Bitpips</a> - All rights reserved</p>
        </div>
    </div>
</div>