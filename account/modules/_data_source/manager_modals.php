<!-- Static Backdrop Modal -->
<div class="modal fade" id="accountInformation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="accountInformationLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h5 class="mb-n1 initialism fw-light" style="font-size: 15px;" id="accountInformationLabel">Update Account Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" method="post" novalidate action="./">
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label for="username" class="form-label">Username<sup class="text-danger fw-bold">*</sup></label>
                            <input type="text" class="form-control" readonly id="username" placeholder="e.g. John_Doe" name="username" value="<?php echo $account_data["username"] ?>" required>
                            <div class="invalid-feedback">
                                Please Enter Username
                            </div>
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="full_names" class="form-label">Full Names<sup class="text-danger fw-bold">*</sup></label>
                            <input type="text" class="form-control" id="full_names" value="<?php echo $account_data["full_names"] ?>" placeholder="e.g. John Doe" name="full_names" required>
                            <div class="invalid-feedback">
                                Please Enter Full Names
                            </div>
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="reg_email_address" class="form-label">Email Address<sup class="text-danger fw-bold">*</sup></label>
                            <input type="email" class="form-control" id="reg_email_address" readonly value="<?php echo $account_data["email_address"] ?>" placeholder="e.g. johndoe@gmail.com" name="email_address" required>
                            <div class="invalid-feedback">
                                Please Enter Email Address
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="phone_number" class="form-label">Phone Number<sup class="text-danger fw-bold">*</sup></label>
                            <input type="tel" class="form-control" id="phone_number" value="<?php echo $account_data["phone_number"] ?>" placeholder="e.g. +44 012 345 6789" name="phone_number" required>
                            <div class="invalid-feedback">
                                Please Enter Phone Number
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <div class="d-flex">
                                <label for="country" class="form-label">Country<sup class="text-danger fw-bold">*</sup></label>
                                <span class="ms-auto fw-bold"><?php echo $account_data["country"] ?></span>
                            </div>
                            <select name="country" id="country" class="form-control" name="country" required>
                                <option value="<?php echo $account_data["country"] ?>" selected>-- Select Option --</option>
                                <option value="Afghanistan">Afghanistan</option>
                                <option value="Åland Islands">Åland Islands</option>
                                <option value="Albania">Albania</option>
                                <option value="Algeria">Algeria</option>
                                <option value="American Samoa">American Samoa</option>
                                <option value="Andorra">Andorra</option>
                                <option value="Angola">Angola</option>
                                <option value="Anguilla">Anguilla</option>
                                <option value="Antarctica">Antarctica</option>
                                <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                <option value="Argentina">Argentina</option>
                                <option value="Armenia">Armenia</option>
                                <option value="Aruba">Aruba</option>
                                <option value="Australia">Australia</option>
                                <option value="Austria">Austria</option>
                                <option value="Azerbaijan">Azerbaijan</option>
                                <option value="Bahamas">Bahamas</option>
                                <option value="Bahrain">Bahrain</option>
                                <option value="Bangladesh">Bangladesh</option>
                                <option value="Barbados">Barbados</option>
                                <option value="Belarus">Belarus</option>
                                <option value="Belgium">Belgium</option>
                                <option value="Belize">Belize</option>
                                <option value="Benin">Benin</option>
                                <option value="Bermuda">Bermuda</option>
                                <option value="Bhutan">Bhutan</option>
                                <option value="Bolivia">Bolivia</option>
                                <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                <option value="Botswana">Botswana</option>
                                <option value="Bouvet Island">Bouvet Island</option>
                                <option value="Brazil">Brazil</option>
                                <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                                <option value="Brunei Darussalam">Brunei Darussalam</option>
                                <option value="Bulgaria">Bulgaria</option>
                                <option value="Burkina Faso">Burkina Faso</option>
                                <option value="Burundi">Burundi</option>
                                <option value="Cambodia">Cambodia</option>
                                <option value="Cameroon">Cameroon</option>
                                <option value="Canada">Canada</option>
                                <option value="Cape Verde">Cape Verde</option>
                                <option value="Cayman Islands">Cayman Islands</option>
                                <option value="Central African Republic">Central African Republic</option>
                                <option value="Chad">Chad</option>
                                <option value="Chile">Chile</option>
                                <option value="China">China</option>
                                <option value="Christmas Island">Christmas Island</option>
                                <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                                <option value="Colombia">Colombia</option>
                                <option value="Comoros">Comoros</option>
                                <option value="Congo">Congo</option>
                                <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
                                <option value="Cook Islands">Cook Islands</option>
                                <option value="Costa Rica">Costa Rica</option>
                                <option value="Cote D'ivoire">Cote D'ivoire</option>
                                <option value="Croatia">Croatia</option>
                                <option value="Cuba">Cuba</option>
                                <option value="Cyprus">Cyprus</option>
                                <option value="Czech Republic">Czech Republic</option>
                                <option value="Denmark">Denmark</option>
                                <option value="Djibouti">Djibouti</option>
                                <option value="Dominica">Dominica</option>
                                <option value="Dominican Republic">Dominican Republic</option>
                                <option value="Ecuador">Ecuador</option>
                                <option value="Egypt">Egypt</option>
                                <option value="El Salvador">El Salvador</option>
                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                <option value="Eritrea">Eritrea</option>
                                <option value="Estonia">Estonia</option>
                                <option value="Ethiopia">Ethiopia</option>
                                <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                                <option value="Faroe Islands">Faroe Islands</option>
                                <option value="Fiji">Fiji</option>
                                <option value="Finland">Finland</option>
                                <option value="France">France</option>
                                <option value="French Guiana">French Guiana</option>
                                <option value="French Polynesia">French Polynesia</option>
                                <option value="French Southern Territories">French Southern Territories</option>
                                <option value="Gabon">Gabon</option>
                                <option value="Gambia">Gambia</option>
                                <option value="Georgia">Georgia</option>
                                <option value="Germany">Germany</option>
                                <option value="Ghana">Ghana</option>
                                <option value="Gibraltar">Gibraltar</option>
                                <option value="Greece">Greece</option>
                                <option value="Greenland">Greenland</option>
                                <option value="Grenada">Grenada</option>
                                <option value="Guadeloupe">Guadeloupe</option>
                                <option value="Guam">Guam</option>
                                <option value="Guatemala">Guatemala</option>
                                <option value="Guernsey">Guernsey</option>
                                <option value="Guinea">Guinea</option>
                                <option value="Guinea-bissau">Guinea-bissau</option>
                                <option value="Guyana">Guyana</option>
                                <option value="Haiti">Haiti</option>
                                <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                                <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                                <option value="Honduras">Honduras</option>
                                <option value="Hong Kong">Hong Kong</option>
                                <option value="Hungary">Hungary</option>
                                <option value="Iceland">Iceland</option>
                                <option value="India">India</option>
                                <option value="Indonesia">Indonesia</option>
                                <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                                <option value="Iraq">Iraq</option>
                                <option value="Ireland">Ireland</option>
                                <option value="Isle of Man">Isle of Man</option>
                                <option value="Israel">Israel</option>
                                <option value="Italy">Italy</option>
                                <option value="Jamaica">Jamaica</option>
                                <option value="Japan">Japan</option>
                                <option value="Jersey">Jersey</option>
                                <option value="Jordan">Jordan</option>
                                <option value="Kazakhstan">Kazakhstan</option>
                                <option value="Kenya">Kenya</option>
                                <option value="Kiribati">Kiribati</option>
                                <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                                <option value="Korea, Republic of">Korea, Republic of</option>
                                <option value="Kuwait">Kuwait</option>
                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                                <option value="Latvia">Latvia</option>
                                <option value="Lebanon">Lebanon</option>
                                <option value="Lesotho">Lesotho</option>
                                <option value="Liberia">Liberia</option>
                                <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                                <option value="Liechtenstein">Liechtenstein</option>
                                <option value="Lithuania">Lithuania</option>
                                <option value="Luxembourg">Luxembourg</option>
                                <option value="Macao">Macao</option>
                                <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
                                <option value="Madagascar">Madagascar</option>
                                <option value="Malawi">Malawi</option>
                                <option value="Malaysia">Malaysia</option>
                                <option value="Maldives">Maldives</option>
                                <option value="Mali">Mali</option>
                                <option value="Malta">Malta</option>
                                <option value="Marshall Islands">Marshall Islands</option>
                                <option value="Martinique">Martinique</option>
                                <option value="Mauritania">Mauritania</option>
                                <option value="Mauritius">Mauritius</option>
                                <option value="Mayotte">Mayotte</option>
                                <option value="Mexico">Mexico</option>
                                <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                                <option value="Moldova, Republic of">Moldova, Republic of</option>
                                <option value="Monaco">Monaco</option>
                                <option value="Mongolia">Mongolia</option>
                                <option value="Montenegro">Montenegro</option>
                                <option value="Montserrat">Montserrat</option>
                                <option value="Morocco">Morocco</option>
                                <option value="Mozambique">Mozambique</option>
                                <option value="Myanmar">Myanmar</option>
                                <option value="Namibia">Namibia</option>
                                <option value="Nauru">Nauru</option>
                                <option value="Nepal">Nepal</option>
                                <option value="Netherlands">Netherlands</option>
                                <option value="Netherlands Antilles">Netherlands Antilles</option>
                                <option value="New Caledonia">New Caledonia</option>
                                <option value="New Zealand">New Zealand</option>
                                <option value="Nicaragua">Nicaragua</option>
                                <option value="Niger">Niger</option>
                                <option value="Nigeria">Nigeria</option>
                                <option value="Niue">Niue</option>
                                <option value="Norfolk Island">Norfolk Island</option>
                                <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                <option value="Norway">Norway</option>
                                <option value="Oman">Oman</option>
                                <option value="Pakistan">Pakistan</option>
                                <option value="Palau">Palau</option>
                                <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                                <option value="Panama">Panama</option>
                                <option value="Papua New Guinea">Papua New Guinea</option>
                                <option value="Paraguay">Paraguay</option>
                                <option value="Peru">Peru</option>
                                <option value="Philippines">Philippines</option>
                                <option value="Pitcairn">Pitcairn</option>
                                <option value="Poland">Poland</option>
                                <option value="Portugal">Portugal</option>
                                <option value="Puerto Rico">Puerto Rico</option>
                                <option value="Qatar">Qatar</option>
                                <option value="Reunion">Reunion</option>
                                <option value="Romania">Romania</option>
                                <option value="Russian Federation">Russian Federation</option>
                                <option value="Rwanda">Rwanda</option>
                                <option value="Saint Helena">Saint Helena</option>
                                <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                <option value="Saint Lucia">Saint Lucia</option>
                                <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                                <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                                <option value="Samoa">Samoa</option>
                                <option value="San Marino">San Marino</option>
                                <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                <option value="Saudi Arabia">Saudi Arabia</option>
                                <option value="Senegal">Senegal</option>
                                <option value="Serbia">Serbia</option>
                                <option value="Seychelles">Seychelles</option>
                                <option value="Sierra Leone">Sierra Leone</option>
                                <option value="Singapore">Singapore</option>
                                <option value="Slovakia">Slovakia</option>
                                <option value="Slovenia">Slovenia</option>
                                <option value="Solomon Islands">Solomon Islands</option>
                                <option value="Somalia">Somalia</option>
                                <option value="South Africa">South Africa</option>
                                <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                                <option value="Spain">Spain</option>
                                <option value="Sri Lanka">Sri Lanka</option>
                                <option value="Sudan">Sudan</option>
                                <option value="Suriname">Suriname</option>
                                <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                                <option value="Swaziland">Swaziland</option>
                                <option value="Sweden">Sweden</option>
                                <option value="Switzerland">Switzerland</option>
                                <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                                <option value="Taiwan">Taiwan</option>
                                <option value="Tajikistan">Tajikistan</option>
                                <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                                <option value="Thailand">Thailand</option>
                                <option value="Timor-leste">Timor-leste</option>
                                <option value="Togo">Togo</option>
                                <option value="Tokelau">Tokelau</option>
                                <option value="Tonga">Tonga</option>
                                <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                <option value="Tunisia">Tunisia</option>
                                <option value="Turkey">Turkey</option>
                                <option value="Turkmenistan">Turkmenistan</option>
                                <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                                <option value="Tuvalu">Tuvalu</option>
                                <option value="Uganda">Uganda</option>
                                <option value="Ukraine">Ukraine</option>
                                <option value="United Arab Emirates">United Arab Emirates</option>
                                <option value="United Kingdom">United Kingdom</option>
                                <option value="United States">United States</option>
                                <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                                <option value="Uruguay">Uruguay</option>
                                <option value="Uzbekistan">Uzbekistan</option>
                                <option value="Vanuatu">Vanuatu</option>
                                <option value="Venezuela">Venezuela</option>
                                <option value="Viet Nam">Viet Nam</option>
                                <option value="Virgin Islands, British">Virgin Islands, British</option>
                                <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                                <option value="Wallis and Futuna">Wallis and Futuna</option>
                                <option value="Western Sahara">Western Sahara</option>
                                <option value="Yemen">Yemen</option>
                                <option value="Zambia">Zambia</option>
                                <option value="Zimbabwe">Zimbabwe</option>
                            </select>
                            <div class="invalid-feedback">
                                Please Select Country
                            </div>
                        </div>

                        <span class="text-muted small">Kindly contact our technical support team if you wish to update either your email address or username.</span>
                    </div>

                </div>
                <div class="modal-footer py-2 d-flex">
                    <input type="hidden" name="account_id" value="<?php echo $account_data["account_id"] ?>">
                    <button type="reset" class="btn" data-bs-dismiss="modal" style="border: 1px dashed #343a40;">Cancel <i class='bx bx-reset'></i></button>
                    <button type="submit" class="ms-auto btn btn-primary" name="update_account_information">Save Changes <i class='bx bx-save'></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Static Backdrop Modal -->
<div class="modal fade" id="accountSecurity" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="accountSecurityLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h5 class="mb-n1 initialism fw-light" style="font-size: 15px;" id="accountSecurityLabel">Update Account Security</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" method="post" novalidate action="./">
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label for="up_current_password" class="form-label">Current Password<sup class="text-danger fw-bold">*</sup></label>
                            <input type="password" class="form-control" id="up_current_password" name="current_password" minlength="8" placeholder="8+ characteres required" required>
                            <div class="invalid-feedback">
                                Please Enter Current Password
                            </div>
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="up_new_password" class="form-label">New Password<sup class="text-danger fw-bold">*</sup></label>
                            <input type="password" class="form-control" id="up_new_password" name="new_password" minlength="8" placeholder="8+ characteres required" required>
                            <div class="invalid-feedback">
                                Please Enter New Password
                            </div>
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="up_confirm_new_password" class="form-label">Confirm New Password<sup class="text-danger fw-bold">*</sup></label>
                            <input type="password" class="form-control" id="up_confirm_new_password" name="confirm_password" minlength="8" placeholder="8+ characteres required" required>
                            <div class="invalid-feedback">
                                Please Confirm New Password
                            </div>
                        </div>

                        <span class="text-muted small">Kindly contact our technical support team if you're experiencing any technical difficulties.</span>
                    </div>

                </div>
                <div class="modal-footer py-2 d-flex">
                    <input type="hidden" name="account_id" value="<?php echo $account_data["account_id"] ?>">
                    <button type="reset" class="btn" data-bs-dismiss="modal" style="border: 1px dashed #343a40;">Cancel <i class='bx bx-reset'></i></button>
                    <button type="submit" class="ms-auto btn btn-primary" name="update_account_security">Save Changes <i class='bx bx-save'></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Static Backdrop Modal -->
<div class="modal fade" id="eWallets" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="eWalletsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h5 class="mb-n1 initialism fw-light" style="font-size: 15px;" id="eWalletsLabel">Update Wallet Addresses</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="./">
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="bitcoin_wallet_address" class="form-label">Bitcoin Wallet Address</label>
                            <input type="text" class="form-control" value="<?php echo $account_data["bitcoin_wallet_address"] ?>" id="bitcoin_wallet_address" placeholder="Enter BTC wallet address here..." name="bitcoin_wallet_address">
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="ethereum_wallet_address" class="form-label">Ethereum Wallet Address</label>
                            <input type="text" class="form-control" value="<?php echo $account_data["ethereum_wallet_address"] ?>" id="ethereum_wallet_address" placeholder="Enter ETH wallet address here..." name="ethereum_wallet_address">
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="tether_wallet_address" class="form-label">Tether Wallet Address</label>
                            <input type="text" class="form-control" value="<?php echo $account_data["tether_wallet_address"] ?>" id="tether_wallet_address" placeholder="Enter USDT wallet address here..." name="tether_wallet_address">
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="dogecoin_wallet_address" class="form-label">Dogecoin Wallet Address</label>
                            <input type="text" class="form-control" value="<?php echo $account_data["dogecoin_wallet_address"] ?>" id="dogecoin_wallet_address" placeholder="Enter DOGE wallet address here..." name="dogecoin_wallet_address">
                        </div>

                        <span class="text-muted small">Kindly contact our technical support team if you're experiencing any technical difficulties.</span>
                    </div>

                </div>
                <div class="modal-footer py-2 d-flex">
                    <input type="hidden" name="account_id" value="<?php echo $account_data["account_id"] ?>">
                    <button type="reset" class="btn" data-bs-dismiss="modal" style="border: 1px dashed #343a40;">Cancel <i class='bx bx-reset'></i></button>
                    <button type="submit" class="ms-auto btn btn-primary" name="update_wallet_addresses">Save Changes <i class='bx bx-save'></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Static Backdrop Modal -->
<div class="modal fade" id="composeNotification" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="eWalletsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h5 class="mb-n1 initialism fw-light" style="font-size: 15px;" id="eWalletsLabel">Compose Notification For User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="./authu?investor_id=<?php echo $investor_id ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="Notification" class="form-label">Notification Category</label>
                            <input type="text" class="form-control" value="" id="Notification" placeholder="Eg INVESTMENT NOTIFICATION" name="noft_category" required >
                        </div>
                        <div class="mb-3 col-12">
                            <label for="Notification" class="form-label">Notification Message</label>
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Notification Message" id="floatingTextarea" style="height: 100px;" name="noft_msg" required></textarea>
                                <label for="floatingTextarea">Compose Here</label>
                            </div>
                        </div>
                        <hr>
                        <span class="text-danger">Kindly review your write up before sending.</span>
                    </div>
                    <div class="modal-footer py-2 d-flex">
                        <input type="hidden" name="account_id" value="<?php echo $investor_id ?>">
                        <button type="reset" class="btn" data-bs-dismiss="modal" style="border: 1px dashed #343a40;">Cancel <i class='bx bx-reset'></i></button>
                        <button type="submit" class="ms-auto btn btn-primary" name="compose_notification">Send <i class='bx bx-save'></i></button>
                    </div>
            </form>
        </div>
    </div>
</div>