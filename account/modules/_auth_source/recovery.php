<div class="col-md-8 col-lg-6 col-xl-5" id="recoverySection" style="display: none;">
    <div class="card overflow-hidden">
        <div class="bg-primary bg-soft">
            <div class="row">
                <div class="col-8">
                    <div class="text-primary p-4">
                        <h5 class="text-primary">Account Recovery</h5>
                        <p>Swiftly recover the password to your account on our platform today.</p>
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
            <div class="p-2">
                <form class="needs-validation" novalidate action="./auth0">
                    <div class="mb-3">
                        <label for="rec_email_address" class="form-label">Email Address<sup class="text-danger fw-bold">*</sup></label>
                        <input type="email" class="form-control" id="rec_email_address" placeholder="e.g. johndoe@gmail.com" required>
                        <div class="invalid-feedback">
                            Please Enter Email Address
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="rec_password" class="form-label">Password<sup class="text-danger fw-bold">*</sup></label>
                        <input type="password" class="form-control" id="rec_password" minlength="8" placeholder="8+ characteres required" required>
                        <div class="invalid-feedback">
                            Please Enter Password
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="rec_confirm_password" class="form-label">Confirm Password<sup class="text-danger fw-bold">*</sup></label>
                        <input type="password" class="form-control" id="rec_confirm_password" minlength="8" placeholder="8+ characteres required" required>
                        <div class="invalid-feedback">
                            Please Confirm Password
                        </div>
                    </div>

                    <div class="mt-4 d-grid">
                        <button class="btn btn-primary waves-effect waves-light" name="initialize_registration" type="submit">Initialize Account Recovery</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="mt-4 text-center">
        <div>
            <p>Remember your password ? <a href="javascript:void(0);" class="fw-medium text-primary" onclick="toggleVisibility('loginSection');"> Login</a> </p>
            <p>© <script>
                    document.write(new Date().getFullYear())
                </script> <a href="../">Rulerstradingfx</a> - All rights reserved</p>
        </div>
    </div>
</div>