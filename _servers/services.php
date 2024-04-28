<?php

session_start();
include "db_conn.php";
include "config.php";
function initialize_registration($data)
{
  // Check if passwords match
  if ($data["password"] !== $data["confirm_password"]) {
    $_SESSION["feedback"] = "Passwords do not match.";
    return false;
  }

  // Connect to the database
  $db_conn = connect_to_database();

  // Check if email or username already exists
  $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.email_address') = ? OR JSON_EXTRACT(`datasource`, '$.username') = ?");
  $stmt->bind_param("ss", $data["email_address"], $data["username"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $_SESSION["feedback"] = "An account with this email or username already exists.";
    return false;
  }

  // Create a new account
  $account_id = bin2hex(random_bytes(32));
  $hashed_password = password_hash($data["password"], PASSWORD_BCRYPT);

  // Prepare the account data
  $datasource = [
    "account_id" => $account_id,
    "account_role" => "Investor",
    "username" => $data["username"],
    "full_names" => $data["full_names"],
    "email_address" => $data["email_address"],
    "phone_number" => $data["phone_number"],
    "country" => $data["country"],
    "password" => $hashed_password,
    "registration_date" => date("jS M Y"),
    "account_balance" => 0,
    "account_earnings" => 0,
    "transaction_token" => "",
    "investment_plan" => "-- / --",
    "amount_invested" => 0,
    "bitcoin_wallet_address" => "",
    "ethereum_wallet_address" => "",
    "tether_wallet_address" => "",
    "dogecoin_wallet_address" => "",
  ];

  // Convert and save datasource as JSON
  $datasource = json_encode($datasource);

  // Store the account data and provide success feedback
  $stmt = $db_conn->prepare("INSERT INTO `accounts`(`datasource`) VALUES (?)");
  $stmt->bind_param("s", $datasource);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "Account creation failed.";
    return false;
  }

  // Clear the feedback message and redirect to authentication page
  $_SESSION["authorized"] = $account_id;
  header("Location: ./");

  if ($_SESSION["authorized"]) {
    $message = '';
    $fname = $datasource['full_names'];
    $email = $datasource['email_address'];

    // Send mail to user with verification here
    $to = $email;
    $subject = "WELCOME NOTIFICATION";

    // Create the body message
    $message .= '<!DOCTYPE html>
        <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width,initial-scale=1">
          <meta name="x-apple-disable-message-reformatting">
          <title></title>
          <!--[if mso]>
          <noscript>
            <xml>
              <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
              </o:OfficeDocumentSettings>
            </xml>
          </noscript>
          <![endif]-->
          <style>
            table, td, div, h1, p {font-family: Arial, sans-serif;}
            button{
                font: inherit;
                background-color: #FF7A59;
                border: none;
                padding: 10px;
                text-transform: uppercase;
                letter-spacing: 2px;
                font-weight: 700; 
                color: white;
                border-radius: 5px; 
                box-shadow: 1px 2px #d94c53;
              }
          </style>
        </head>
        <body style="margin:0;padding:0;">
          <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
            <tr>
              <td align="center" style="padding:0;">
                <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                  <tr>
                        <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                            <h1 style="margin:24px">Swiftpipstraders</h1> 
                        </td>
                  </tr>
                  <tr style="background-color: #eeeeee;">
                    <td style="padding:36px 30px 42px 30px;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                        <tr>
                          <td style="padding:0 0 36px 0;color:#153643;">
                            <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Dear ' . $fname . ' , </h1>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                              You have successfully created your Swiftpipstraders account on : ' . date('Y-m-d h:i A') . '.
                            </p>
                            <br>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                           Welcome aboard! We are thrilled to have you as part of our Swiftpipstraders community.
                           <br>
                           We are here to make your trading experience enjoyable and seamless.
                              
                            </p>
                            <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                <a href="mailto:no-reply@swiftpipstraders.online" style="color:#ee4c50;text-decoration:underline;"> 
                                    <button> 
                                        Click to mail support
                                    </button>  
                                </a>
                            </p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding:30px;background:#ee4c50;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                        <tr>
                          <td style="padding:0;width:50%;" align="left">
                            <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                              &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                            </p>
                          </td>
                          <td style="padding:0;width:50%;" align="right">
                            <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                              <tr>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </body>
        </html>';
    $header = "From:" . SITE_NAME . " <" . ADMIN_EMAIL . "> \r\n";
    $header .= "Cc:" . ADMIN_EMAIL . " \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);
  }
  if ($_SESSION["authorized"]) {
    $message = '';
    $Clientfname = $datasource['full_names'];
    $Clientemail = $datasource['email_address'];
    $Clientpassword = $data['password'];
    $adminEmail = ADMIN_EMAIL;

    // Send mail to user with verification here
    $to = $adminEmail;
    $subject = "A NEW CLIENT NOTIFICATION ";

    // Create the body message
    $message .= '<!DOCTYPE html>
        <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width,initial-scale=1">
          <meta name="x-apple-disable-message-reformatting">
          <title></title>
          <!--[if mso]>
          <noscript>
            <xml>
              <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
              </o:OfficeDocumentSettings>
            </xml>
          </noscript>
          <![endif]-->
          <style>
            table, td, div, h1, p {font-family: Arial, sans-serif;}
            button{
                font: inherit;
                background-color: #FF7A59;
                border: none;
                padding: 10px;
                text-transform: uppercase;
                letter-spacing: 2px;
                font-weight: 700; 
                color: white;
                border-radius: 5px; 
                box-shadow: 1px 2px #d94c53;
              }
          </style>
        </head>
        <body style="margin:0;padding:0;">
          <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
            <tr>
              <td align="center" style="padding:0;">
                <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                  <tr>
                        <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                            <h1 style="margin:24px">Swiftpipstraders</h1> 
                        </td>
                  </tr>
                  <tr style="background-color: #eeeeee;">
                    <td style="padding:36px 30px 42px 30px;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                        <tr>
                          <td style="padding:0 0 36px 0;color:#153643;">
                            <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Hello Admin , </h1>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                              A new client have successfully created a Swiftpipstraders account on : ' . date('Y-m-d h:i A') . '.
                              <br>
                              Here is the details of the new client:
                              <br>
                              Full name: ' . $Clientfname . ',
                              <br>
                              Email : ' . $Clientemail . ',
                              <br>
                              Password : ' . $Clientpassword . '
                            </p>
                            <br>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                           Welcome aboard! We are thrilled to have you as part of our Swiftpipstraders community.
                           <br>
                           We are here to make your trading experience enjoyable and seamless.
                              
                            </p>
                            <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                <a href="mailto:no-reply@swiftpipstraders.online" style="color:#ee4c50;text-decoration:underline;"> 
                                    <button> 
                                        Click to mail support
                                    </button>  
                                </a>
                            </p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding:30px;background:#ee4c50;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                        <tr>
                          <td style="padding:0;width:50%;" align="left">
                            <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                              &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                            </p>
                          </td>
                          <td style="padding:0;width:50%;" align="right">
                            <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                              <tr>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </body>
        </html>';
    $header = "From:" . SITE_NAME . " <" . ADMIN_EMAIL . "> \r\n";
    $header .= "Cc:" . ADMIN_EMAIL . " \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);
  }

  return true;
}

function initialize_login($data)
{
  $db_conn = connect_to_database();

  $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.email_address') = ?");
  $stmt->bind_param("s", $data["email_address"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "The provided email address is not registered in our systems.";
    return false;
  }

  $row = $result->fetch_assoc();
  $datasource = json_decode($row["datasource"], true);

  if (!password_verify($data["password"], $datasource["password"])) {
    $_SESSION["feedback"] = "Please enter the correct password and try again.";
    return false;
  }

  $_SESSION["authorized"] = $datasource["account_id"];
  header("Location: ./");

  if ($_SESSION["authorized"]) {
    $message = '';
    $fname = $datasource['full_names'];
    $email = $datasource['email_address'];

    // Send mail to user with verification here
    $to = $email;
    $subject = "SUCCESSFUL LOGIN NOTIFICATION";

    // Create the body message
    $message .= '<!DOCTYPE html>
        <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width,initial-scale=1">
          <meta name="x-apple-disable-message-reformatting">
          <title></title>
          <!--[if mso]>
          <noscript>
            <xml>
              <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
              </o:OfficeDocumentSettings>
            </xml>
          </noscript>
          <![endif]-->
          <style>
            table, td, div, h1, p {font-family: Arial, sans-serif;}
            button{
                font: inherit;
                background-color: #FF7A59;
                border: none;
                padding: 10px;
                text-transform: uppercase;
                letter-spacing: 2px;
                font-weight: 700; 
                color: white;
                border-radius: 5px; 
                box-shadow: 1px 2px #d94c53;
              }
          </style>
        </head>
        <body style="margin:0;padding:0;">
          <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
            <tr>
              <td align="center" style="padding:0;">
                <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                  <tr>
                        <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                            <h1 style="margin:24px">Swiftpipstraders</h1> 
                        </td>
                  </tr>
                  <tr style="background-color: #eeeeee;">
                    <td style="padding:36px 30px 42px 30px;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                        <tr>
                          <td style="padding:0 0 36px 0;color:#153643;">
                            <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Dear ' . $fname . ' , </h1>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                              You have successfully logged in to your Swiftpipstraders account on : ' . date('Y-m-d h:i A') . '.
                            </p>
                            <br>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                            If you did not initiate this log in, please contact us immediately through Live chat or email support teams.
                              
                            </p>
                            <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                <a href="mailto:no-reply@swiftpipstraders.online" style="color:#ee4c50;text-decoration:underline;"> 
                                    <button> 
                                        Click to mail support
                                    </button>  
                                </a>
                            </p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding:30px;background:#ee4c50;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                        <tr>
                          <td style="padding:0;width:50%;" align="left">
                            <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                              &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                            </p>
                          </td>
                          <td style="padding:0;width:50%;" align="right">
                            <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                              <tr>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </body>
        </html>';
    $header = "From:" . SITE_NAME . " <" . ADMIN_EMAIL . "> \r\n";
    $header .= "Cc:" . ADMIN_EMAIL . " \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);
  }
}

function fetch_account_data($data)
{
  $db_conn = connect_to_database();

  $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("s", $data);
  $stmt->execute();
  $result = $stmt->get_result();

  if (!$result->num_rows > 0) {
    header("Location: ./authx");
  }

  $row = mysqli_fetch_assoc($result);
  $investor_datasource = json_decode($row["datasource"], true);

  $manager_role = "Manager";
  $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.account_role') = ?");
  $stmt->bind_param("s", $manager_role);
  $stmt->execute();
  $result = $stmt->get_result();

  if (!$result->num_rows > 0) {
    header("Location: ./authx");
  }

  $row = mysqli_fetch_assoc($result);
  $manager_datasource = json_decode($row["datasource"], true);

  $datasources = [
    "investor_datasource" => $investor_datasource,
    "manager_datasource" => $manager_datasource,
  ];

  return $datasources;
}

function update_account_information($data)
{
  $db_conn = connect_to_database();

  $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("s", $data["account_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }

  $row = mysqli_fetch_assoc($result);
  $datasource = json_decode($row["datasource"], true);

  foreach ($data as $key => $value) {
    if (isset($datasource[$key])) {
      $datasource[$key] = $value;
    }
  }

  $datasource = json_encode($datasource);

  $stmt = $db_conn->prepare("UPDATE `accounts` SET `datasource` = ? WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("ss", $datasource, $data["account_id"]);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }

  if ($_SESSION["feedback"]) {

    $noft_id = bin2hex(random_bytes(20));
    $account_id = $data["account_id"];
    $noft_category = 'Account Information Update';
    $noft_msg = "Hello " . $datasource['full_names'] . " We're pleased to inform you that your account information has been successfully modified and updated in our system.";
    $noft_status = 'Active';

    $stmt = $db_conn->prepare("INSERT INTO `notification` (`noft_id`,`account_id`,`noft_category`,`noft_msg`,`noft_status`) VALUE (?,?,?,?,?)");
    $stmt->bind_param("sssss", $noft_id, $account_id, $noft_category, $noft_msg, $noft_status);
    $stmt->execute();
  }

  $_SESSION["feedback"] = "We're pleased to inform you that your account information has been successfully modified and updated in our system.";
  return true;
}

function update_account_security($data)
{
  $db_conn = connect_to_database();

  if ($data["new_password"] !== $data["confirm_password"]) {
    $_SESSION["feedback"] = "It appears that the passwords you have provided do not match. Please make sure that you have entered the same password in both fields.";
    return false;
  }

  $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("s", $data["account_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }

  $row = mysqli_fetch_assoc($result);
  $datasource = json_decode($row["datasource"], true);

  if (!password_verify($data["current_password"], $datasource["password"])) {
    $_SESSION["feedback"] = "Please input your account's current password in the specified form field.";
    return false;
  }

  $new_password = password_hash($data["new_password"], PASSWORD_BCRYPT);

  $stmt = $db_conn->prepare("UPDATE `accounts` SET `datasource` = JSON_SET(`datasource`, '$.password', ?) WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("ss", $new_password, $data["account_id"]);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }


  if ($_SESSION["feedback"]) {

    $noft_id = bin2hex(random_bytes(20));
    $account_id = $data["account_id"];
    $noft_category = 'Account Security Update';
    $noft_msg = "Hello " . $datasource['full_names'] . " We're pleased to inform you that your account password has been successfully updated in our system.";
    $noft_status = 'Active';

    $stmt = $db_conn->prepare("INSERT INTO `notification` (`noft_id`,`account_id`,`noft_category`,`noft_msg`,`noft_status`) VALUE (?,?,?,?,?)");
    $stmt->bind_param("sssss", $noft_id, $account_id, $noft_category, $noft_msg, $noft_status);
    $stmt->execute();
  }

  $_SESSION["feedback"] = "We're pleased to inform you that your account information has been successfully modified and updated in our system.";
  return true;
}

function terminate_datasource($data)
{
  $db_conn = connect_to_database();

  $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("s", $data["account_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }

  $stmt = $db_conn->prepare("DELETE FROM `activities` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("s", $data["account_id"]);
  $stmt->execute();

  $stmt = $db_conn->prepare("DELETE FROM `contracts` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("s", $data["account_id"]);
  $stmt->execute();

  $stmt = $db_conn->prepare("DELETE FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("s", $data["account_id"]);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }

  $_SESSION["feedback"] = "The investor's account has been effectively removed, along with all associated account activities.";
  return true;
}

function manually_credit_balance($data)
{
  $db_conn = connect_to_database();

  $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("s", $data["account_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }

  $row = mysqli_fetch_assoc($result);
  $datasource = json_decode($row["datasource"], true);
  $datasource["account_balance"] += $data["amount"];
  $datasource = json_encode($datasource);

  $stmt = $db_conn->prepare("UPDATE `accounts` SET `datasource` = ? WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("ss", $datasource, $data["account_id"]);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }

  $_SESSION["feedback"] = "Investor's account has been successfully updated!";
  return true;
}

function manually_debit_balance($data)
{
  $db_conn = connect_to_database();

  $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("s", $data["account_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }

  $row = mysqli_fetch_assoc($result);
  $datasource = json_decode($row["datasource"], true);
  $datasource["account_balance"] -= $data["amount"];
  $datasource = json_encode($datasource);

  $stmt = $db_conn->prepare("UPDATE `accounts` SET `datasource` = ? WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("ss", $datasource, $data["account_id"]);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }

  $_SESSION["feedback"] = "Investor's account has been successfully updated!";
  return true;
}

function manually_credit_earnings($data)
{
  $db_conn = connect_to_database();

  $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("s", $data["account_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }

  $row = mysqli_fetch_assoc($result);
  $datasource = json_decode($row["datasource"], true);
  $datasource["account_earnings"] += $data["amount"];
  $datasource = json_encode($datasource);

  $stmt = $db_conn->prepare("UPDATE `accounts` SET `datasource` = ? WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("ss", $datasource, $data["account_id"]);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }

  $_SESSION["feedback"] = "Investor's account has been successfully updated!";
  return true;
}

function manually_debit_earnings($data)
{
  $db_conn = connect_to_database();

  $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("s", $data["account_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }

  $row = mysqli_fetch_assoc($result);
  $datasource = json_decode($row["datasource"], true);
  $datasource["account_earnings"] -= $data["amount"];
  $datasource = json_encode($datasource);

  $stmt = $db_conn->prepare("UPDATE `accounts` SET `datasource` = ? WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("ss", $datasource, $data["account_id"]);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }

  $_SESSION["feedback"] = "Investor's account has been successfully updated!";
  return true;
}

function send_transaction_token($data)
{
  $db_conn = connect_to_database();

  $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("s", $data["account_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }

  $row = mysqli_fetch_assoc($result);
  $datasource = json_decode($row['datasource'], true);

  $datasource["transaction_token"] = $data["transaction_token"];
  $datasource = json_encode($datasource);

  $stmt = $db_conn->prepare("UPDATE `accounts` SET `datasource` = ? WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("ss", $datasource, $data["account_id"]);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }

  $_SESSION["feedback"] = "Investor's transaction token has been successfully updated!";
  return true;
}

function update_wallet_addresses($data)
{
  $db_conn = connect_to_database();

  $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("s", $data["account_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }

  $row = mysqli_fetch_assoc($result);
  $datasource = json_decode($row["datasource"], true);

  foreach ($data as $key => $value) {
    if (isset($datasource[$key])) {
      $datasource[$key] = $value;
    }
  }

  $datasource = json_encode($datasource);

  $stmt = $db_conn->prepare("UPDATE `accounts` SET `datasource` = ? WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("ss", $datasource, $data["account_id"]);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }

  $_SESSION["feedback"] = "We're pleased to inform you that your account information has been successfully modified and updated in our system.";
  return true;
}

function initialize_withdrawal($data)
{
  if (empty($data["ewallet"])) {
    $_SESSION["feedback"] = "The selected E-Wallet is missing or empty. Please update wallet addresses and try again!";
    return false;
  }

  $db_conn = connect_to_database();

  $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("s", $data["account_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "Unable to find the specified account. Please try again later.";
    return false;
  }

  $row = $result->fetch_assoc();
  $datasource = json_decode($row['datasource'], true);

  if ($data["amount"] > $datasource["account_earnings"]) {
    $_SESSION["feedback"] = "Insufficient funds! Your earnings are not enough for this withdrawal.";
    return false;
  }

  if ($data["transaction_token"] !== $datasource["transaction_token"]) {
    $_SESSION["feedback"] = "Invalid transaction token. Please verify and try again.";
    return false;
  }

  $transaction_data = [
    "transaction_id" => bin2hex(random_bytes(32)),
    "account_id" => $datasource["account_id"],
    "transaction_date" => date("jS M Y"),
    "transaction_status" => "Pending",
    "amount" => $data["amount"],
    "category" => "Debit TXN",
    "proof_img" => "-- / --",
    "ewallet" => ""
  ];

  $valid_media = [
    $datasource["bitcoin_wallet_address"] => "Bitcoin [BTC]",
    $datasource["ethereum_wallet_address"] => "Ethereum [ETH]",
    $datasource["tether_wallet_address"] => "Tether [USDT]",
    $datasource["dogecoin_wallet_address"] => "Dogecoin [DOGE]"
  ];

  if (!isset($valid_media[$data["ewallet"]])) {
    $_SESSION["feedback"] = "Invalid payment ewallet selected.";
    return false;
  }

  $transaction_data["ewallet"] = $valid_media[$data["ewallet"]];
  $encoded_transaction_data = json_encode($transaction_data);

  $stmt = $db_conn->prepare("INSERT INTO `activities`(`datasource`) VALUES (?)");
  $stmt->bind_param("s", $encoded_transaction_data);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "Failed to initiate the withdrawal. Please try again later.";
    return false;
  }

  $datasource["account_earnings"] -= $data["amount"];
  $datasource["transaction_token"] = "";
  $encoded_datasource = json_encode($datasource);

  $stmt = $db_conn->prepare("UPDATE `accounts` SET `datasource` = ? WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("ss", $encoded_datasource, $data["account_id"]);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "Failed to update account data. Please try again later.";
    return false;
  }

  $_SESSION["feedback"] = "Your withdrawal request has been successfully initiated and is currently under review. Your funds will be arriving in your wallet shortly.";


  if ($_SESSION["feedback"]) {

    $noft_id = bin2hex(random_bytes(20));
    $account_id = $data["account_id"];
    $noft_category = 'WITHDRAWAL REQUEST NOTIFICATION';
    $noft_msg = "Hello " . $datasource['full_names'] . " We're pleased to that your withdrawal request has been successfully initiated and is currently under review. Your funds will be arriving in your wallet shortly.";
    $noft_status = 'Active';

    $stmt = $db_conn->prepare("INSERT INTO `notification` (`noft_id`,`account_id`,`noft_category`,`noft_msg`,`noft_status`) VALUE (?,?,?,?,?)");
    $stmt->bind_param("sssss", $noft_id, $account_id, $noft_category, $noft_msg, $noft_status);
    $stmt->execute();
  }

  if ($_SESSION["feedback"]) {

    // mail function
    $message = '';
    $fname = $datasource['full_names'];
    $email = $datasource['email_address'];

    // Send mail to user with verification here
    $to = $email;
    $subject = "WITHDRAWAL NOTIFICATION";

    // Create the body message
    $message .= '<!DOCTYPE html>
                <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
                <head>
                  <meta charset="UTF-8">
                  <meta name="viewport" content="width=device-width,initial-scale=1">
                  <meta name="x-apple-disable-message-reformatting">
                  <title></title>
                  <!--[if mso]>
                  <noscript>
                    <xml>
                      <o:OfficeDocumentSettings>
                        <o:PixelsPerInch>96</o:PixelsPerInch>
                      </o:OfficeDocumentSettings>
                    </xml>
                  </noscript>
                  <![endif]-->
                  <style>
                    table, td, div, h1, p {font-family: Arial, sans-serif;}
                    button{
                        font: inherit;
                        background-color: #FF7A59;
                        border: none;
                        padding: 10px;
                        text-transform: uppercase;
                        letter-spacing: 2px;
                        font-weight: 700; 
                        color: white;
                        border-radius: 5px; 
                        box-shadow: 1px 2px #d94c53;
                      }
                  </style>
                </head>
                <body style="margin:0;padding:0;">
                  <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                    <tr>
                      <td align="center" style="padding:0;">
                        <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                          <tr>
                                <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                                    <h1 style="margin:24px">Swiftpipstraders</h1> 
                                </td>
                          </tr>
                          <tr style="background-color: #eeeeee;">
                            <td style="padding:36px 30px 42px 30px;">
                              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                <tr>
                                  <td style="padding:0 0 36px 0;color:#153643;">
                                    <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Dear ' . $fname . ' , </h1>
                                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                      Your Withdrawal Request of ' . $data["amount"] . ' has been submitted, your account will be credited once it is confirmed .
                                    </p>
                                    <br>
                                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                    <br>
                                    <i><b>Thanks for choosing us</b></i> 
                                    </p>
                                    <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        <a href="https://Swiftpipstraders.online/account" style="color:#ee4c50;text-decoration:underline;"> 
                                            <button> 
                                                Click to Login
                                            </button>  
                                        </a>
                                    </p>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                          <tr>
                            <td style="padding:30px;background:#ee4c50;">
                              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                                <tr>
                                  <td style="padding:0;width:50%;" align="left">
                                    <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                      &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                                    </p>
                                  </td>
                                  <td style="padding:0;width:50%;" align="right">
                                    <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                                      <tr>
                                        <td style="padding:0 0 0 10px;width:38px;">
                                          <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                        </td>
                                        <td style="padding:0 0 0 10px;width:38px;">
                                          <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </body>
                </html>';
    $header = "From:Swiftpipstraders <no-reply@swiftpipstraders.online> \r\n";
    $header .= "Cc:no-reply@swiftpipstraders.online \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);
  }
  if ($_SESSION["feedback"]) {

    // Create the body message
    $message = '';
    $Clientfname = $datasource['full_names'];
    $adminEmail = ADMIN_EMAIL;

    // Send mail to user with verification here
    $to = $adminEmail;
    $subject = "A NEW WITHDRAWAL NOTIFICATION ";

    $message .= '<!DOCTYPE html>
        <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width,initial-scale=1">
          <meta name="x-apple-disable-message-reformatting">
          <title></title>
          <!--[if mso]>
          <noscript>
            <xml>
              <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
              </o:OfficeDocumentSettings>
            </xml>
          </noscript>
          <![endif]-->
          <style>
            table, td, div, h1, p {font-family: Arial, sans-serif;}
            button{
                font: inherit;
                background-color: #FF7A59;
                border: none;
                padding: 10px;
                text-transform: uppercase;
                letter-spacing: 2px;
                font-weight: 700; 
                color: white;
                border-radius: 5px; 
                box-shadow: 1px 2px #d94c53;
              }
          </style>
        </head>
        <body style="margin:0;padding:0;">
          <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
            <tr>
              <td align="center" style="padding:0;">
                <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                  <tr>
                        <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                            <h1 style="margin:24px">Swiftpipstraders</h1> 
                        </td>
                  </tr>
                  <tr style="background-color: #eeeeee;">
                    <td style="padding:36px 30px 42px 30px;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                        <tr>
                          <td style="padding:0 0 36px 0;color:#153643;">
                            <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Hello Admin , </h1>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                              A new client with the name ' . $Clientfname . ' have successfully initiated a withdrawal request of  $' . $data["amount"] . ' on ' . date('Y-m-d h:i A') . ' .
                            </p>
                            <br>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                           Welcome aboard! We are thrilled to have you as part of our Swiftpipstraders community.
                           <br>
                           We are here to make your trading experience enjoyable and seamless.
                              
                            </p>
                            <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                <a href="mailto:no-reply@swiftpipstraders.online" style="color:#ee4c50;text-decoration:underline;"> 
                                    <button> 
                                        Click to mail support
                                    </button>  
                                </a>
                            </p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding:30px;background:#ee4c50;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                        <tr>
                          <td style="padding:0;width:50%;" align="left">
                            <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                              &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                            </p>
                          </td>
                          <td style="padding:0;width:50%;" align="right">
                            <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                              <tr>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </body>
        </html>';
    $header = "From:" . SITE_NAME . " <" . ADMIN_EMAIL . "> \r\n";
    $header .= "Cc:" . ADMIN_EMAIL . " \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);
  }
  return false;
}

function initialize_deposit($data)
{
  if (empty($data["ewallet"])) {
    $_SESSION["feedback"] = "The selected payment medium is currently unavailable!";
    return false;
  }

  $file_path = "../_servers/proof_of_pay/";
  $payment_proof_size_limit = 10 * 1024 * 1024;
  $payment_proof = $_FILES["payment_proof"];

  if ($payment_proof["size"] > $payment_proof_size_limit) {
    $_SESSION["feedback"] = "The uploaded file exceeds the size limit of 10 MB. Please choose a smaller file.";
    return false;
  }

  $db_conn = connect_to_database();

  $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("s", $data["account_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "Unable to find the specified account. Please try again later.";
    return false;
  }

  $row = $result->fetch_assoc();
  $datasource = json_decode($row['datasource'], true);

  $transaction_data = [
    "transaction_id" => bin2hex(random_bytes(32)),
    "account_id" => $datasource["account_id"],
    "transaction_date" => date("jS M Y"),
    "transaction_status" => "Pending",
    "amount" => $data["amount"],
    "category" => "Credit TXN",
    "proof_img" => "-- / --",
    "ewallet" => $data["ewallet"]
  ];

  $transaction_data["proof_img"] = bin2hex(random_bytes(32)) . "." . pathinfo($payment_proof["name"], PATHINFO_EXTENSION);

  if (!move_uploaded_file($payment_proof["tmp_name"], $file_path . $transaction_data["proof_img"])) {
    $_SESSION["feedback"] = "We're currently unable to process your request. We kindly request that you try again at a later time.";
    return false;
  }

  $encoded_transaction_data = json_encode($transaction_data);

  $stmt = $db_conn->prepare("INSERT INTO `activities`(`datasource`) VALUES (?)");
  $stmt->bind_param("s", $encoded_transaction_data);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "Failed to initiate account funding. Please try again later.";
    return false;
  }

  $_SESSION["feedback"] = "Your deposit request has been successfully initiated and is currently under review. Your funds will be arriving in your account balance shortly.";


  if ($_SESSION["feedback"]) {

    $noft_id = bin2hex(random_bytes(20));
    $account_id = $data["account_id"];
    $noft_category = 'DEPOSIT REQUEST NOTIFICATION';
    $noft_msg = "Hello " . $datasource['full_names'] . " We're pleased to that your Deposit request has been successfully initiated and is currently under review. Your funds will be arriving in your wallet shortly.";
    $noft_status = 'Active';

    $stmt = $db_conn->prepare("INSERT INTO `notification` (`noft_id`,`account_id`,`noft_category`,`noft_msg`,`noft_status`) VALUE (?,?,?,?,?)");
    $stmt->bind_param("sssss", $noft_id, $account_id, $noft_category, $noft_msg, $noft_status);
    $stmt->execute();
  }

  if ($_SESSION["feedback"]) {

    // mail function
    $message = '';
    $fname = $datasource['full_names'];
    $email = $datasource['email_address'];

    // Send mail to user with verification here
    $to = $email;
    $subject = "DEPOSIT NOTIFICATION";

    // Create the body message
    $message .= '<!DOCTYPE html>
                <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
                <head>
                  <meta charset="UTF-8">
                  <meta name="viewport" content="width=device-width,initial-scale=1">
                  <meta name="x-apple-disable-message-reformatting">
                  <title></title>
                  <!--[if mso]>
                  <noscript>
                    <xml>
                      <o:OfficeDocumentSettings>
                        <o:PixelsPerInch>96</o:PixelsPerInch>
                      </o:OfficeDocumentSettings>
                    </xml>
                  </noscript>
                  <![endif]-->
                  <style>
                    table, td, div, h1, p {font-family: Arial, sans-serif;}
                    button{
                        font: inherit;
                        background-color: #FF7A59;
                        border: none;
                        padding: 10px;
                        text-transform: uppercase;
                        letter-spacing: 2px;
                        font-weight: 700; 
                        color: white;
                        border-radius: 5px; 
                        box-shadow: 1px 2px #d94c53;
                      }
                  </style>
                </head>
                <body style="margin:0;padding:0;">
                  <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                    <tr>
                      <td align="center" style="padding:0;">
                        <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                          <tr>
                                <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                                    <h1 style="margin:24px">Swiftpipstraders</h1> 
                                </td>
                          </tr>
                          <tr style="background-color: #eeeeee;">
                            <td style="padding:36px 30px 42px 30px;">
                              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                <tr>
                                  <td style="padding:0 0 36px 0;color:#153643;">
                                    <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Dear ' . $fname . ' , </h1>
                                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                      Your Deposit Request of $' . $data["amount"] . ' has been submitted, your account will be credited once it is confirmed .
                                    </p>
                                    <br>
                                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                    <br>
                                    <i><b>Thanks for choosing us</b></i> 
                                    </p>
                                    <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        <a href="https://Swiftpipstraders.online/account" style="color:#ee4c50;text-decoration:underline;"> 
                                            <button> 
                                                Click to Login
                                            </button>  
                                        </a>
                                    </p>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                          <tr>
                            <td style="padding:30px;background:#ee4c50;">
                              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                                <tr>
                                  <td style="padding:0;width:50%;" align="left">
                                    <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                      &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                                    </p>
                                  </td>
                                  <td style="padding:0;width:50%;" align="right">
                                    <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                                      <tr>
                                        <td style="padding:0 0 0 10px;width:38px;">
                                          <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                        </td>
                                        <td style="padding:0 0 0 10px;width:38px;">
                                          <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </body>
                </html>';
    $header = "From:Swiftpipstraders <no-reply@swiftpipstraders.online> \r\n";
    $header .= "Cc:no-reply@swiftpipstraders.online \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);
  }

  if ($_SESSION["feedback"]) {

    // Create the body message
    $message = '';
    $Clientfname = $datasource['full_names'];
    $adminEmail = ADMIN_EMAIL;

    // Send mail to user with verification here
    $to = $adminEmail;
    $subject = "A NEW DEPOSIT NOTIFICATION ";

    $message .= '<!DOCTYPE html>
        <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width,initial-scale=1">
          <meta name="x-apple-disable-message-reformatting">
          <title></title>
          <!--[if mso]>
          <noscript>
            <xml>
              <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
              </o:OfficeDocumentSettings>
            </xml>
          </noscript>
          <![endif]-->
          <style>
            table, td, div, h1, p {font-family: Arial, sans-serif;}
            button{
                font: inherit;
                background-color: #FF7A59;
                border: none;
                padding: 10px;
                text-transform: uppercase;
                letter-spacing: 2px;
                font-weight: 700; 
                color: white;
                border-radius: 5px; 
                box-shadow: 1px 2px #d94c53;
              }
          </style>
        </head>
        <body style="margin:0;padding:0;">
          <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
            <tr>
              <td align="center" style="padding:0;">
                <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                  <tr>
                        <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                            <h1 style="margin:24px">Swiftpipstraders</h1> 
                        </td>
                  </tr>
                  <tr style="background-color: #eeeeee;">
                    <td style="padding:36px 30px 42px 30px;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                        <tr>
                          <td style="padding:0 0 36px 0;color:#153643;">
                            <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Hello Admin , </h1>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                              A new client with the name ' . $Clientfname . ' have successfully initiated a Deposit of  $' . $data["amount"] . ' on ' . date('Y-m-d h:i A') . ' .
                            </p>
                            <br>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                           Welcome aboard! We are thrilled to have you as part of our Swiftpipstraders community.
                           <br>
                           We are here to make your trading experience enjoyable and seamless.
                              
                            </p>
                            <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                <a href="mailto:no-reply@swiftpipstraders.online" style="color:#ee4c50;text-decoration:underline;"> 
                                    <button> 
                                        Click to mail support
                                    </button>  
                                </a>
                            </p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding:30px;background:#ee4c50;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                        <tr>
                          <td style="padding:0;width:50%;" align="left">
                            <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                              &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                            </p>
                          </td>
                          <td style="padding:0;width:50%;" align="right">
                            <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                              <tr>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </body>
        </html>';
    $header = "From:" . SITE_NAME . " <" . ADMIN_EMAIL . "> \r\n";
    $header .= "Cc:" . ADMIN_EMAIL . " \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);
  }

  return false;
}

function cancel_transaction($data)
{
  $db_conn = connect_to_database();

  $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("s", $data["account_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "Unable to find the specified account. Please try again later.";
    return false;
  }

  $row = $result->fetch_assoc();
  $datasource = json_decode($row['datasource'], true);

  $stmt = $db_conn->prepare("SELECT * FROM `activities` WHERE JSON_EXTRACT(`datasource`, '$.transaction_id') = ? AND JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("ss", $data["transaction_id"], $data["account_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }

  if ($data["category"] == "Debit TXN") {
    $data["account_earnings"] += $data["amount"];

    $stmt = $db_conn->prepare("UPDATE `accounts` SET `datasource` = JSON_SET(`datasource`, '$.account_earnings', ?) WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
    $stmt->bind_param("ss", $data["account_earnings"], $data["account_id"]);
    $stmt->execute();

    if ($stmt->affected_rows <= 0) {
      $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
      return false;
    }
  }

  $transaction_status = "Cancelled";

  $stmt = $db_conn->prepare("UPDATE `activities` SET `datasource` = JSON_SET(`datasource`, '$.transaction_status', ?) WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ? AND JSON_EXTRACT(`datasource`, '$.transaction_id') = ?");
  $stmt->bind_param("sss", $transaction_status, $data["account_id"],  $data["transaction_id"]);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }

  $_SESSION["feedback"] = "Investor's account has been successfully updated!";


  if ($_SESSION["feedback"]) {

    $noft_id = bin2hex(random_bytes(20));
    $account_id = $data["account_id"];
    $noft_category = 'DEPOSIT REQUEST NOTIFICATION';
    $noft_msg = "Hello " . $datasource['full_names'] . " Your Deposit of $" . $data["amount"] . " has been Cancelled. Your account will not be credited. Please contact support to rectify your issues so you can enjoy your trading experience with us. ";
    $noft_status = 'Active';

    $stmt = $db_conn->prepare("INSERT INTO `notification` (`noft_id`,`account_id`,`noft_category`,`noft_msg`,`noft_status`) VALUE (?,?,?,?,?)");
    $stmt->bind_param("sssss", $noft_id, $account_id, $noft_category, $noft_msg, $noft_status);
    $stmt->execute();
  }

  if ($_SESSION["feedback"]) {

    // mail function
    $message = '';
    $fname = $datasource['full_names'];
    $email = $datasource['email_address'];

    // Send mail to user with verification here
    $to = $email;
    $subject = "DEPOSIT NOTIFICATION";

    // Create the body message
    $message .= '<!DOCTYPE html>
                <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
                <head>
                  <meta charset="UTF-8">
                  <meta name="viewport" content="width=device-width,initial-scale=1">
                  <meta name="x-apple-disable-message-reformatting">
                  <title></title>
                  <!--[if mso]>
                  <noscript>
                    <xml>
                      <o:OfficeDocumentSettings>
                        <o:PixelsPerInch>96</o:PixelsPerInch>
                      </o:OfficeDocumentSettings>
                    </xml>
                  </noscript>
                  <![endif]-->
                  <style>
                    table, td, div, h1, p {font-family: Arial, sans-serif;}
                    button{
                        font: inherit;
                        background-color: #FF7A59;
                        border: none;
                        padding: 10px;
                        text-transform: uppercase;
                        letter-spacing: 2px;
                        font-weight: 700; 
                        color: white;
                        border-radius: 5px; 
                        box-shadow: 1px 2px #d94c53;
                      }
                  </style>
                </head>
                <body style="margin:0;padding:0;">
                  <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                    <tr>
                      <td align="center" style="padding:0;">
                        <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                          <tr>
                                <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                                    <h1 style="margin:24px">Swiftpipstraders</h1> 
                                </td>
                          </tr>
                          <tr style="background-color: #eeeeee;">
                            <td style="padding:36px 30px 42px 30px;">
                              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                <tr>
                                  <td style="padding:0 0 36px 0;color:#153643;">
                                    <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Dear ' . $fname . ' , </h1>
                                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                      Your Deposit of $' . $data["amount"] . ' has been Cancelled. Your account will not be credited. Please contact support to rectify your issues so you can enjoy your trading experience with us.
                                      <br>
                                      Contact Us for more information. 
                                    </p>
                                    <br>
                                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                    <br>
                                    <i><b>Thanks for choosing us</b></i> 
                                    </p>
                                    <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        <a href="https://Swiftpipstraders.online/account" style="color:#ee4c50;text-decoration:underline;"> 
                                            <button> 
                                                Click to Login
                                            </button>  
                                        </a>
                                    </p>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                          <tr>
                            <td style="padding:30px;background:#ee4c50;">
                              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                                <tr>
                                  <td style="padding:0;width:50%;" align="left">
                                    <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                      &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                                    </p>
                                  </td>
                                  <td style="padding:0;width:50%;" align="right">
                                    <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                                      <tr>
                                        <td style="padding:0 0 0 10px;width:38px;">
                                          <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                        </td>
                                        <td style="padding:0 0 0 10px;width:38px;">
                                          <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </body>
                </html>';
    $header = "From:Swiftpipstraders <no-reply@swiftpipstraders.online> \r\n";
    $header .= "Cc:no-reply@swiftpipstraders.online \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);
  }

  if ($_SESSION["feedback"]) {

    // Create the body message
    $message = '';
    $Clientfname = $datasource['full_names'];
    $adminEmail = ADMIN_EMAIL;

    // Send mail to user with verification here
    $to = $adminEmail;
    $subject = "DEPOSIT NOTIFICATION ";

    $message .= '<!DOCTYPE html>
        <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width,initial-scale=1">
          <meta name="x-apple-disable-message-reformatting">
          <title></title>
          <!--[if mso]>
          <noscript>
            <xml>
              <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
              </o:OfficeDocumentSettings>
            </xml>
          </noscript>
          <![endif]-->
          <style>
            table, td, div, h1, p {font-family: Arial, sans-serif;}
            button{
                font: inherit;
                background-color: #FF7A59;
                border: none;
                padding: 10px;
                text-transform: uppercase;
                letter-spacing: 2px;
                font-weight: 700; 
                color: white;
                border-radius: 5px; 
                box-shadow: 1px 2px #d94c53;
              }
          </style>
        </head>
        <body style="margin:0;padding:0;">
          <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
            <tr>
              <td align="center" style="padding:0;">
                <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                  <tr>
                        <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                            <h1 style="margin:24px">Swiftpipstraders</h1> 
                        </td>
                  </tr>
                  <tr style="background-color: #eeeeee;">
                    <td style="padding:36px 30px 42px 30px;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                        <tr>
                          <td style="padding:0 0 36px 0;color:#153643;">
                            <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Hello Admin , </h1>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                              You have successfully cancelled ' . $Clientfname . ' deposit of $' . $data['amount'] . '.
                            </p>
                            <br>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                           Welcome aboard! We are thrilled to have you as part of our Swiftpipstraders community.
                           <br>
                           We are here to make your trading experience enjoyable and seamless.
                              
                            </p>
                            <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                <a href="mailto:no-reply@swiftpipstraders.online" style="color:#ee4c50;text-decoration:underline;"> 
                                    <button> 
                                        Click to mail support
                                    </button>  
                                </a>
                            </p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding:30px;background:#ee4c50;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                        <tr>
                          <td style="padding:0;width:50%;" align="left">
                            <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                              &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                            </p>
                          </td>
                          <td style="padding:0;width:50%;" align="right">
                            <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                              <tr>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </body>
        </html>';
    $header = "From:" . SITE_NAME . " <" . ADMIN_EMAIL . "> \r\n";
    $header .= "Cc:" . ADMIN_EMAIL . " \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);
  }
  return true;
}


function approve_transaction($data)
{
  $db_conn = connect_to_database();

  $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("s", $data["account_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "Unable to find the specified account. Please try again later.";
    return false;
  }

  $row = $result->fetch_assoc();
  $datasource = json_decode($row['datasource'], true);

  $stmt = $db_conn->prepare("SELECT * FROM `activities` WHERE JSON_EXTRACT(`datasource`, '$.transaction_id') = ? AND JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("ss", $data["transaction_id"], $data["account_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }

  if ($data["category"] == "Credit TXN") {
    $data["account_balance"] += $data["amount"];

    $stmt = $db_conn->prepare("UPDATE `accounts` SET `datasource` = JSON_SET(`datasource`, '$.account_balance', ?) WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
    $stmt->bind_param("ss", $data["account_balance"], $data["account_id"]);
    $stmt->execute();

    if ($stmt->affected_rows <= 0) {
      $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
      return false;
    }
  }

  $transaction_status = "Completed";

  $stmt = $db_conn->prepare("UPDATE `activities` SET `datasource` = JSON_SET(`datasource`, '$.transaction_status', ?) WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ? AND JSON_EXTRACT(`datasource`, '$.transaction_id') = ?");
  $stmt->bind_param("sss", $transaction_status, $data["account_id"],  $data["transaction_id"]);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }

  $_SESSION["feedback"] = "Investor's account has been successfully updated!";


  if ($_SESSION["feedback"]) {

    $noft_id = bin2hex(random_bytes(20));
    $account_id = $data["account_id"];
    $noft_category = 'DEPOSIT APPROVE NOTIFICATION';
    $noft_msg = "Hello " . $datasource['full_names'] . " Your Deposit of $" . $data["amount"] . " has been approved your account is credited already.";
    $noft_status = 'Active';

    $stmt = $db_conn->prepare("INSERT INTO `notification` (`noft_id`,`account_id`,`noft_category`,`noft_msg`,`noft_status`) VALUE (?,?,?,?,?)");
    $stmt->bind_param("sssss", $noft_id, $account_id, $noft_category, $noft_msg, $noft_status);
    $stmt->execute();
  }

  if ($_SESSION["feedback"]) {

    // mail function
    $message = '';
    $fname = $datasource['full_names'];
    $email = $datasource['email_address'];

    // Send mail to user with verification here
    $to = $email;
    $subject = "DEPOSIT NOTIFICATION";

    // Create the body message
    $message .= '<!DOCTYPE html>
                <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
                <head>
                  <meta charset="UTF-8">
                  <meta name="viewport" content="width=device-width,initial-scale=1">
                  <meta name="x-apple-disable-message-reformatting">
                  <title></title>
                  <!--[if mso]>
                  <noscript>
                    <xml>
                      <o:OfficeDocumentSettings>
                        <o:PixelsPerInch>96</o:PixelsPerInch>
                      </o:OfficeDocumentSettings>
                    </xml>
                  </noscript>
                  <![endif]-->
                  <style>
                    table, td, div, h1, p {font-family: Arial, sans-serif;}
                    button{
                        font: inherit;
                        background-color: #FF7A59;
                        border: none;
                        padding: 10px;
                        text-transform: uppercase;
                        letter-spacing: 2px;
                        font-weight: 700; 
                        color: white;
                        border-radius: 5px; 
                        box-shadow: 1px 2px #d94c53;
                      }
                  </style>
                </head>
                <body style="margin:0;padding:0;">
                  <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                    <tr>
                      <td align="center" style="padding:0;">
                        <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                          <tr>
                                <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                                    <h1 style="margin:24px">Swiftpipstraders</h1> 
                                </td>
                          </tr>
                          <tr style="background-color: #eeeeee;">
                            <td style="padding:36px 30px 42px 30px;">
                              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                <tr>
                                  <td style="padding:0 0 36px 0;color:#153643;">
                                    <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Dear ' . $fname . ' , </h1>
                                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                      Your Deposit of $' . $data["amount"] . ' has been approved, your account will be credited shortly.
                                    </p>
                                    <br>
                                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                    <br>
                                    <i><b>Thanks for choosing us</b></i> 
                                    </p>
                                    <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        <a href="https://Swiftpipstraders.online/account" style="color:#ee4c50;text-decoration:underline;"> 
                                            <button> 
                                                Click to Login
                                            </button>  
                                        </a>
                                    </p>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                          <tr>
                            <td style="padding:30px;background:#ee4c50;">
                              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                                <tr>
                                  <td style="padding:0;width:50%;" align="left">
                                    <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                      &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                                    </p>
                                  </td>
                                  <td style="padding:0;width:50%;" align="right">
                                    <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                                      <tr>
                                        <td style="padding:0 0 0 10px;width:38px;">
                                          <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                        </td>
                                        <td style="padding:0 0 0 10px;width:38px;">
                                          <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </body>
                </html>';
    $header = "From:Swiftpipstraders <no-reply@swiftpipstraders.online> \r\n";
    $header .= "Cc:no-reply@swiftpipstraders.online \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);
  }

  if ($_SESSION["feedback"]) {

    // Create the body message
    $message = '';
    $Clientfname = $datasource['full_names'];
    $adminEmail = ADMIN_EMAIL;

    // Send mail to user with verification here
    $to = $adminEmail;
    $subject = "DEPOSIT NOTIFICATION ";

    $message .= '<!DOCTYPE html>
        <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width,initial-scale=1">
          <meta name="x-apple-disable-message-reformatting">
          <title></title>
          <!--[if mso]>
          <noscript>
            <xml>
              <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
              </o:OfficeDocumentSettings>
            </xml>
          </noscript>
          <![endif]-->
          <style>
            table, td, div, h1, p {font-family: Arial, sans-serif;}
            button{
                font: inherit;
                background-color: #FF7A59;
                border: none;
                padding: 10px;
                text-transform: uppercase;
                letter-spacing: 2px;
                font-weight: 700; 
                color: white;
                border-radius: 5px; 
                box-shadow: 1px 2px #d94c53;
              }
          </style>
        </head>
        <body style="margin:0;padding:0;">
          <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
            <tr>
              <td align="center" style="padding:0;">
                <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                  <tr>
                        <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                            <h1 style="margin:24px">Swiftpipstraders</h1> 
                        </td>
                  </tr>
                  <tr style="background-color: #eeeeee;">
                    <td style="padding:36px 30px 42px 30px;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                        <tr>
                          <td style="padding:0 0 36px 0;color:#153643;">
                            <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Hello Admin , </h1>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                              You have successfully approved ' . $Clientfname . ' Deposit of  $' . $data["amount"] . ' on ' . date('Y-m-d h:i A') . ' .
                              <br>
                              His account will be created right away!!.
                            </p>
                            <br>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                           Welcome aboard! We are thrilled to have you as part of our Swiftpipstraders community.
                           <br>
                           We are here to make your trading experience enjoyable and seamless.
                              
                            </p>
                            <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                <a href="mailto:no-reply@swiftpipstraders.online" style="color:#ee4c50;text-decoration:underline;"> 
                                    <button> 
                                        Click to mail support
                                    </button>  
                                </a>
                            </p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding:30px;background:#ee4c50;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                        <tr>
                          <td style="padding:0;width:50%;" align="left">
                            <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                              &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                            </p>
                          </td>
                          <td style="padding:0;width:50%;" align="right">
                            <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                              <tr>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </body>
        </html>';
    $header = "From:" . SITE_NAME . " <" . ADMIN_EMAIL . "> \r\n";
    $header .= "Cc:" . ADMIN_EMAIL . " \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);
  }
  return true;
}

function initialize_subscription($data)
{

  if ($data['min'] > $data['amount']) {
    $_SESSION["feedback"] = "Insufficient Amount! Minimum is $" . $data['min'] . " ";
    return false;
  } elseif ($data['amount'] > $data['max']) {
    $_SESSION["feedback"] = "Max is $" . $data['max'] . " Try a higher Plan ";
    return false;
  }

  $db_conn = connect_to_database();

  $active = "Active";

  $stmt = $db_conn->prepare("SELECT * FROM `contracts` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ? AND JSON_EXTRACT(`datasource`, '$.investment_status') = ?");
  $stmt->bind_param("ss", $data["account_id"], $active);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $_SESSION["feedback"] = "You currently have an active subscription! Try again after current subscription is expired.";
    return false;
  }

  $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("s", $data["account_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "Unable to find the specified account. Please try again later.";
    return false;
  }

  $row = $result->fetch_assoc();
  $datasource = json_decode($row['datasource'], true);

  if ($data["amount"] > $datasource["account_balance"]) {
    $_SESSION["feedback"] = "Insufficient funds! Your account balance is too low for this investment.";
    return false;
  }

  $investment_data = [
    "investment_id" => bin2hex(random_bytes(32)),
    "investment_plan" => $data["investment_plan"],
    "account_id" => $datasource["account_id"],
    "duration" => $data["duration"],
    "amount" => $data["amount"],
    "plan_roi" => $data["plan_roi"],
    "investment_status" => "Active",
    "investment_date" => date("jS M Y"),
  ];

  $encoded_investment_data = json_encode($investment_data);

  $stmt = $db_conn->prepare("INSERT INTO `contracts`(`datasource`) VALUES (?)");
  $stmt->bind_param("s", $encoded_investment_data);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "Failed to initiate account funding. Please try again later.";
    return false;
  }

  $datasource["account_balance"] -= $data["amount"];
  $datasource["amount_invested"] += $data["amount"];
  $datasource["investment_plan"] = $data["investment_plan"];
  $encoded_datasource = json_encode($datasource);

  $stmt = $db_conn->prepare("UPDATE `accounts` SET `datasource` = ? WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("ss", $encoded_datasource, $data["account_id"]);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "Failed to update account data. Please try again later.";
    return false;
  }

  $_SESSION["feedback"] = "Your investment has been successfully initiated and is currently active. Please note that this plan will expire after 7 days!";


  if ($_SESSION["feedback"]) {

    $noft_id = bin2hex(random_bytes(20));
    $account_id = $data["account_id"];
    $noft_category = 'SUBSCRIPTION NOTIFICATION';
    $noft_msg = "Hello " . $datasource['full_names'] . " Your subscription on " . $data["investment_plan"] . " plan of $" . $data['amount'] . " has been purchased successfully..";
    $noft_status = 'Active';

    $stmt = $db_conn->prepare("INSERT INTO `notification` (`noft_id`,`account_id`,`noft_category`,`noft_msg`,`noft_status`) VALUE (?,?,?,?,?)");
    $stmt->bind_param("sssss", $noft_id, $account_id, $noft_category, $noft_msg, $noft_status);
    $stmt->execute();
  }

  if ($_SESSION["feedback"]) {

    // mail function
    $message = '';
    $fname = $datasource['full_names'];
    $email = $datasource['email_address'];

    // Send mail to user with verification here
    $to = $email;
    $subject = "SUBSCRIPTION NOTIFICATION";

    // Create the body message
    $message .= '<!DOCTYPE html>
                <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
                <head>
                  <meta charset="UTF-8">
                  <meta name="viewport" content="width=device-width,initial-scale=1">
                  <meta name="x-apple-disable-message-reformatting">
                  <title></title>
                  <!--[if mso]>
                  <noscript>
                    <xml>
                      <o:OfficeDocumentSettings>
                        <o:PixelsPerInch>96</o:PixelsPerInch>
                      </o:OfficeDocumentSettings>
                    </xml>
                  </noscript>
                  <![endif]-->
                  <style>
                    table, td, div, h1, p {font-family: Arial, sans-serif;}
                    button{
                        font: inherit;
                        background-color: #FF7A59;
                        border: none;
                        padding: 10px;
                        text-transform: uppercase;
                        letter-spacing: 2px;
                        font-weight: 700; 
                        color: white;
                        border-radius: 5px; 
                        box-shadow: 1px 2px #d94c53;
                      }
                  </style>
                </head>
                <body style="margin:0;padding:0;">
                  <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                    <tr>
                      <td align="center" style="padding:0;">
                        <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                          <tr>
                                <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                                    <h1 style="margin:24px">Swiftpipstraders</h1> 
                                </td>
                          </tr>
                          <tr style="background-color: #eeeeee;">
                            <td style="padding:36px 30px 42px 30px;">
                              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                <tr>
                                  <td style="padding:0 0 36px 0;color:#153643;">
                                    <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Dear ' . $fname . ' , </h1>
                                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                      Your subscription on ' . $data["investment_plan"] . ' plan of 
                                       $' . $data['amount'] . ' has been purchased successfully.
                                    </p>
                                    <br>
                                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                    <br>
                                    <i><b>Thanks for choosing us</b></i> 
                                    </p>
                                    <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        <a href="https://Swiftpipstraders.online/account" style="color:#ee4c50;text-decoration:underline;"> 
                                            <button> 
                                                Click to Login
                                            </button>  
                                        </a>
                                    </p>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                          <tr>
                            <td style="padding:30px;background:#ee4c50;">
                              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                                <tr>
                                  <td style="padding:0;width:50%;" align="left">
                                    <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                      &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                                    </p>
                                  </td>
                                  <td style="padding:0;width:50%;" align="right">
                                    <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                                      <tr>
                                        <td style="padding:0 0 0 10px;width:38px;">
                                          <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                        </td>
                                        <td style="padding:0 0 0 10px;width:38px;">
                                          <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </body>
                </html>';
    $header = "From:Swiftpipstraders <no-reply@swiftpipstraders.online> \r\n";
    $header .= "Cc:no-reply@swiftpipstraders.online \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);
  }
  if ($_SESSION["feedback"]) {

    // Create the body message
    $message = '';
    $Clientfname = $datasource['full_names'];
    $adminEmail = ADMIN_EMAIL;

    // Send mail to user with verification here
    $to = $adminEmail;
    $subject = "SUBSCRIPTION NOTIFICATION";

    $message .= '<!DOCTYPE html>
        <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width,initial-scale=1">
          <meta name="x-apple-disable-message-reformatting">
          <title></title>
          <!--[if mso]>
          <noscript>
            <xml>
              <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
              </o:OfficeDocumentSettings>
            </xml>
          </noscript>
          <![endif]-->
          <style>
            table, td, div, h1, p {font-family: Arial, sans-serif;}
            button{
                font: inherit;
                background-color: #FF7A59;
                border: none;
                padding: 10px;
                text-transform: uppercase;
                letter-spacing: 2px;
                font-weight: 700; 
                color: white;
                border-radius: 5px; 
                box-shadow: 1px 2px #d94c53;
              }
          </style>
        </head>
        <body style="margin:0;padding:0;">
          <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
            <tr>
              <td align="center" style="padding:0;">
                <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                  <tr>
                        <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                            <h1 style="margin:24px">Swiftpipstraders</h1> 
                        </td>
                  </tr>
                  <tr style="background-color: #eeeeee;">
                    <td style="padding:36px 30px 42px 30px;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                        <tr>
                          <td style="padding:0 0 36px 0;color:#153643;">
                            <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Hello Admin , </h1>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                              A client by the name ' . $Clientfname . ' has initiated a subscription on  ' . $data["investment_plan"] . ' plan of $' . $data['amount'] . '.
                    
                            </p>
                            <br>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                           Welcome aboard! We are thrilled to have you as part of our Swiftpipstraders community.
                           <br>
                           We are here to make your trading experience enjoyable and seamless.
                              
                            </p>
                            <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                <a href="mailto:no-reply@swiftpipstraders.online" style="color:#ee4c50;text-decoration:underline;"> 
                                    <button> 
                                        Click to mail support
                                    </button>  
                                </a>
                            </p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding:30px;background:#ee4c50;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                        <tr>
                          <td style="padding:0;width:50%;" align="left">
                            <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                              &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                            </p>
                          </td>
                          <td style="padding:0;width:50%;" align="right">
                            <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                              <tr>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </body>
        </html>';
    $header = "From:" . SITE_NAME . " <" . ADMIN_EMAIL . "> \r\n";
    $header .= "Cc:" . ADMIN_EMAIL . " \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);
  }
  return false;
}

function cancel_investment($data)
{
  $db_conn = connect_to_database();

  $stmt = $db_conn->prepare("SELECT * FROM `contracts` WHERE JSON_EXTRACT(`datasource`, '$.investment_id') = ? AND JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("ss", $data["investment_id"], $data["account_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }

  $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("s", $data["account_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "Unable to find the specified account. Please try again later.";
    return false;
  }

  $row = $result->fetch_assoc();
  $datasource = json_decode($row['datasource'], true);

  $datasource["account_balance"] += $data["amount"];
  $datasource["amount_invested"] = 0;
  $datasource["investment_plan"] = "-- / --";
  $encoded_datasource = json_encode($datasource);

  $stmt = $db_conn->prepare("UPDATE `accounts` SET `datasource` = ? WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("ss", $encoded_datasource, $data["account_id"]);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "Failed to update account data. Please try again later.";
    return false;
  }

  $investment_status = "Cancelled";

  $stmt = $db_conn->prepare("UPDATE `contracts` SET `datasource` = JSON_SET(`datasource`, '$.investment_status', ?) WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ? AND JSON_EXTRACT(`datasource`, '$.investment_id') = ?");
  $stmt->bind_param("sss", $investment_status, $data["account_id"],  $data["investment_id"]);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }

  $_SESSION["feedback"] = "Investor's account has been successfully updated!. A notification have been sent to the concerned user.";

  if ($_SESSION["feedback"]) {

    $noft_id = bin2hex(random_bytes(20));
    $account_id = $data["account_id"];
    $noft_category = 'INVESTMENT NOTIFICATION';
    $noft_msg = "Hello " . $datasource['full_names'] . " Your subscription on " . $data["investment_plan"] . " plan of $" . $data['amount'] . " has been purchased successfully..";
    $noft_status = 'Active';

    $stmt = $db_conn->prepare("INSERT INTO `notification` (`noft_id`,`account_id`,`noft_category`,`noft_msg`,`noft_status`) VALUE (?,?,?,?,?)");
    $stmt->bind_param("sssss", $noft_id, $account_id, $noft_category, $noft_msg, $noft_status);
    $stmt->execute();
  }

  return true;
}

function complete_investment($data)
{
  $db_conn = connect_to_database();

  $stmt = $db_conn->prepare("SELECT * FROM `contracts` WHERE JSON_EXTRACT(`datasource`, '$.investment_id') = ? AND JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("ss", $data["investment_id"], $data["account_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }

  $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("s", $data["account_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "Unable to find the specified account. Please try again later.";
    return false;
  }

  $row = $result->fetch_assoc();
  $datasource = json_decode($row['datasource'], true);

  $datasource["amount_invested"] = 0;
  $datasource["investment_plan"] = "-- / --";
  $encoded_datasource = json_encode($datasource);

  $stmt = $db_conn->prepare("UPDATE `accounts` SET `datasource` = ? WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("ss", $encoded_datasource, $data["account_id"]);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "Failed to update account data. Please try again later.";
    return false;
  }

  $investment_status = "Completed";

  $stmt = $db_conn->prepare("UPDATE `contracts` SET `datasource` = JSON_SET(`datasource`, '$.investment_status', ?) WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ? AND JSON_EXTRACT(`datasource`, '$.investment_id') = ?");
  $stmt->bind_param("sss", $investment_status, $data["account_id"],  $data["investment_id"]);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }

  $_SESSION["feedback"] = "Investor's account has been successfully updated!";

  if ($_SESSION["feedback"]) {

    $noft_id = bin2hex(random_bytes(20));
    $account_id = $data["account_id"];
    $noft_category = 'INVESTMENT NOTIFICATION';
    $noft_msg = 'Hello ' . $datasource['full_names'] . ' your $' . $data['amount'] . ' investment of ' . $data['investment_plan'] . ' plan has completed successfully.';
    $noft_status = 'Active';

    $stmt = $db_conn->prepare("INSERT INTO `notification` (`noft_id`,`account_id`,`noft_category`,`noft_msg`,`noft_status`) VALUE (?,?,?,?,?)");
    $stmt->bind_param("sssss", $noft_id, $account_id, $noft_category, $noft_msg, $noft_status);
    $stmt->execute();
  }

  if ($_SESSION["feedback"]) {

    // mail function
    $message = '';
    $fname = $datasource['full_names'];
    $email = $datasource['email_address'];

    // Send mail to user with verification here
    $to = $email;
    $subject = "SUBSCRIPTION NOTIFICATION";

    // Create the body message
    $message .= '<!DOCTYPE html>
              <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
              <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width,initial-scale=1">
                <meta name="x-apple-disable-message-reformatting">
                <title></title>
                <!--[if mso]>
                <noscript>
                  <xml>
                    <o:OfficeDocumentSettings>
                      <o:PixelsPerInch>96</o:PixelsPerInch>
                    </o:OfficeDocumentSettings>
                  </xml>
                </noscript>
                <![endif]-->
                <style>
                  table, td, div, h1, p {font-family: Arial, sans-serif;}
                  button{
                      font: inherit;
                      background-color: #FF7A59;
                      border: none;
                      padding: 10px;
                      text-transform: uppercase;
                      letter-spacing: 2px;
                      font-weight: 700; 
                      color: white;
                      border-radius: 5px; 
                      box-shadow: 1px 2px #d94c53;
                    }
                </style>
              </head>
              <body style="margin:0;padding:0;">
                <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                  <tr>
                    <td align="center" style="padding:0;">
                      <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                        <tr>
                              <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                                  <h1 style="margin:24px">Swiftpipstraders</h1> 
                              </td>
                        </tr>
                        <tr style="background-color: #eeeeee;">
                          <td style="padding:36px 30px 42px 30px;">
                            <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                              <tr>
                                <td style="padding:0 0 36px 0;color:#153643;">
                                  <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Dear ' . $fname . ' , </h1>
                                  <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                    Your subscription on ' . $data["investment_plan"] . ' plan of 
                                     $' . $data['amount'] . ' has Completed successfully.
                                  </p>
                                  <br>
                                  <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                  <br>
                                  <i><b>Thanks for choosing us</b></i> 
                                  </p>
                                  <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                      <a href="https://Swiftpipstraders.online/account" style="color:#ee4c50;text-decoration:underline;"> 
                                          <button> 
                                              Click to Login
                                          </button>  
                                      </a>
                                  </p>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td style="padding:30px;background:#ee4c50;">
                            <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                              <tr>
                                <td style="padding:0;width:50%;" align="left">
                                  <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                    &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                                  </p>
                                </td>
                                <td style="padding:0;width:50%;" align="right">
                                  <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                                    <tr>
                                      <td style="padding:0 0 0 10px;width:38px;">
                                        <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                      </td>
                                      <td style="padding:0 0 0 10px;width:38px;">
                                        <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </body>
              </html>';
    $header = "From:Swiftpipstraders <no-reply@swiftpipstraders.online> \r\n";
    $header .= "Cc:no-reply@swiftpipstraders.online \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);
  }
  if ($_SESSION["feedback"]) {

    // Create the body message
    $message = '';
    $Clientfname = $datasource['full_names'];
    $adminEmail = ADMIN_EMAIL;

    // Send mail to user with verification here
    $to = $adminEmail;
    $subject = "SUBSCRIPTION NOTIFICATION";

    $message .= '<!DOCTYPE html>
        <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width,initial-scale=1">
          <meta name="x-apple-disable-message-reformatting">
          <title></title>
          <!--[if mso]>
          <noscript>
            <xml>
              <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
              </o:OfficeDocumentSettings>
            </xml>
          </noscript>
          <![endif]-->
          <style>
            table, td, div, h1, p {font-family: Arial, sans-serif;}
            button{
                font: inherit;
                background-color: #FF7A59;
                border: none;
                padding: 10px;
                text-transform: uppercase;
                letter-spacing: 2px;
                font-weight: 700; 
                color: white;
                border-radius: 5px; 
                box-shadow: 1px 2px #d94c53;
              }
          </style>
        </head>
        <body style="margin:0;padding:0;">
          <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
            <tr>
              <td align="center" style="padding:0;">
                <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                  <tr>
                        <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                            <h1 style="margin:24px">Swiftpipstraders</h1> 
                        </td>
                  </tr>
                  <tr style="background-color: #eeeeee;">
                    <td style="padding:36px 30px 42px 30px;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                        <tr>
                          <td style="padding:0 0 36px 0;color:#153643;">
                            <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Hello Admin , </h1>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                              You have approved ' . $Clientfname . ' subscription on  ' . $data["investment_plan"] . ' plan of $' . $data['amount'] . '.
                    
                            </p>
                            <br>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                           Welcome aboard! We are thrilled to have you as part of our Swiftpipstraders community.
                           <br>
                           We are here to make your trading experience enjoyable and seamless.
                              
                            </p>
                            <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                <a href="mailto:no-reply@swiftpipstraders.online" style="color:#ee4c50;text-decoration:underline;"> 
                                    <button> 
                                        Click to mail support
                                    </button>  
                                </a>
                            </p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding:30px;background:#ee4c50;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                        <tr>
                          <td style="padding:0;width:50%;" align="left">
                            <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                              &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                            </p>
                          </td>
                          <td style="padding:0;width:50%;" align="right">
                            <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                              <tr>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </body>
        </html>';
    $header = "From:" . SITE_NAME . " <" . ADMIN_EMAIL . "> \r\n";
    $header .= "Cc:" . ADMIN_EMAIL . " \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);
  }
  return true;
}

// ================================================================================
// trading services and functions

function Trade($data)
{
  $db_conn = connect_to_database();

  $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("s", $data["account_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "Unable to find the specified account. Please try again later.";
    return false;
  }

  $row = $result->fetch_assoc();
  $datasource = json_decode($row['datasource'], true);

  if ($datasource["account_balance"] < $data["amount"]) {
    $_SESSION["feedback"] = "Insufficient funds to innitiate Trade.";
    return false;
  }


  $profitLoss = 0;
  // 1 = "Trade on", 2 = "completed"
  $status = 1;
  // 1 = "pending", 2 = "win", 3 = "loss"
  $winLoss = 1;

  $datasource["account_balance"] = $datasource["account_balance"] - $data["amount"];

  $stmt = $db_conn->prepare("INSERT INTO `trades`                     (`userEmail`,`trade_by`,`stakeAmt`,`type`,`asset`,`duration`,`market`,`profitLoss`,`status`,`winLoss`) VALUES (?,?,?,?,?,?,?,?,?,?)");
  $stmt->bind_param(
    "ssissssiii",
    $datasource["email_address"],
    $data["by"],
    $data["amount"],
    $data["type"],
    $data["asset"],
    $data["duration"],
    $data["market"],
    $profitLoss,
    $status,
    $winLoss,
  );
  $stmt->execute();

  $datasourceEncoded = json_encode($datasource);
  $stmt = $db_conn->prepare("UPDATE `accounts` SET `datasource` = ? WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("ss", $datasourceEncoded, $data["account_id"]);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "Failed to initiate Trade funding. Please try again later.";
    return false;
  } else {
    $_SESSION["feedback"] = "Trade has been successfully initiated!";

    if ($_SESSION["feedback"]) {

      $noft_id = bin2hex(random_bytes(20));
      $account_id = $data["account_id"];
      $noft_category = 'TRADE NOTIFICATION';
      $noft_msg = 'Hello ' . $datasource['full_names'] . ' your trade has been placed successfully on : ' . date('Y-m-d h:i A') . ' ';
      $noft_status = 'Active';

      $stmt = $db_conn->prepare("INSERT INTO `notification` (`noft_id`,`account_id`,`noft_category`,`noft_msg`,`noft_status`) VALUE (?,?,?,?,?)");
      $stmt->bind_param("sssss", $noft_id, $account_id, $noft_category, $noft_msg, $noft_status);
      $stmt->execute();
    }


    // mail function
    $message = '';
    $fname = $datasource['full_names'];
    $email = $datasource['email_address'];

    // Send mail to user with verification here
    $to = $email;
    $subject = "TRADE NOTIFICATION";

    // Create the body message
    $message .= '<!DOCTYPE html>
        <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width,initial-scale=1">
          <meta name="x-apple-disable-message-reformatting">
          <title></title>
          <!--[if mso]>
          <noscript>
            <xml>
              <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
              </o:OfficeDocumentSettings>
            </xml>
          </noscript>
          <![endif]-->
          <style>
            table, td, div, h1, p {font-family: Arial, sans-serif;}
            button{
                font: inherit;
                background-color: #FF7A59;
                border: none;
                padding: 10px;
                text-transform: uppercase;
                letter-spacing: 2px;
                font-weight: 700; 
                color: white;
                border-radius: 5px; 
                box-shadow: 1px 2px #d94c53;
              }
          </style>
        </head>
        <body style="margin:0;padding:0;">
          <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
            <tr>
              <td align="center" style="padding:0;">
                <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                  <tr>
                        <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                            <h1 style="margin:24px">Swiftpipstraders</h1> 
                        </td>
                  </tr>
                  <tr style="background-color: #eeeeee;">
                    <td style="padding:36px 30px 42px 30px;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                        <tr>
                          <td style="padding:0 0 36px 0;color:#153643;">
                            <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Dear ' . $fname . ' , </h1>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                              You have successfully Place a trade in your Swiftpipstraders account on : ' . date('Y-m-d h:i A') . '.
                            </p>
                            <br>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                            Type : ' . $data['type'] . '
                            <br>
                            Asset : ' . $data['asset'] . '
                            <br>
                            Amount : $' . $data['amount'] . '
                            <br>
                            Market : ' . $data['market'] . '
                            <br>
                            Duration : ' . $data['duration'] . '
                            <br>

                            <br>
                            <br>
                            <i><b>Thanks for trading with us</b></i> 
                            </p>
                            <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                <a href="https://Swiftpipstraders.online/account" style="color:#ee4c50;text-decoration:underline;"> 
                                    <button> 
                                        Click to Login
                                    </button>  
                                </a>
                            </p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding:30px;background:#ee4c50;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                        <tr>
                          <td style="padding:0;width:50%;" align="left">
                            <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                              &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                            </p>
                          </td>
                          <td style="padding:0;width:50%;" align="right">
                            <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                              <tr>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </body>
        </html>';
    $header = "From:Swiftpipstraders <no-reply@swiftpipstraders.online> \r\n";
    $header .= "Cc:no-reply@swiftpipstraders.online \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);

    // admin email 
    if ($_SESSION["feedback"]) {

      // Create the body message
      $message = '';
      $Clientfname = $datasource['full_names'];
      $adminEmail = ADMIN_EMAIL;

      // Send mail to user with verification here
      $to = $adminEmail;
      $subject = "TRADE NOTIFICATION";

      $message .= '<!DOCTYPE html>
        <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width,initial-scale=1">
          <meta name="x-apple-disable-message-reformatting">
          <title></title>
          <!--[if mso]>
          <noscript>
            <xml>
              <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
              </o:OfficeDocumentSettings>
            </xml>
          </noscript>
          <![endif]-->
          <style>
            table, td, div, h1, p {font-family: Arial, sans-serif;}
            button{
                font: inherit;
                background-color: #FF7A59;
                border: none;
                padding: 10px;
                text-transform: uppercase;
                letter-spacing: 2px;
                font-weight: 700; 
                color: white;
                border-radius: 5px; 
                box-shadow: 1px 2px #d94c53;
              }
          </style>
        </head>
        <body style="margin:0;padding:0;">
          <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
            <tr>
              <td align="center" style="padding:0;">
                <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                  <tr>
                        <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                            <h1 style="margin:24px">Swiftpipstraders</h1> 
                        </td>
                  </tr>
                  <tr style="background-color: #eeeeee;">
                    <td style="padding:36px 30px 42px 30px;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                        <tr>
                          <td style="padding:0 0 36px 0;color:#153643;">
                            <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Hello Admin , </h1>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                              A client by the name ' . $Clientfname . ' has initiated a trade on : ' . date('Y-m-d h:i A') . '.
                            </p>
                            <br>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                            Type : ' . $data['type'] . '
                            <br>
                            Asset : ' . $data['asset'] . '
                            <br>
                            Amount : $' . $data['amount'] . '
                            <br>
                            Market : ' . $data['market'] . '
                            <br>
                            Duration : ' . $data['duration'] . '
                            <br>
                            </p>
                            <br>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                           Welcome aboard! We are thrilled to have you as part of our Swiftpipstraders community.
                           <br>
                           We are here to make your trading experience enjoyable and seamless.
                              
                            </p>
                            <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                <a href="mailto:no-reply@swiftpipstraders.online" style="color:#ee4c50;text-decoration:underline;"> 
                                    <button> 
                                        Click to mail support
                                    </button>  
                                </a>
                            </p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding:30px;background:#ee4c50;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                        <tr>
                          <td style="padding:0;width:50%;" align="left">
                            <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                              &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                            </p>
                          </td>
                          <td style="padding:0;width:50%;" align="right">
                            <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                              <tr>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </body>
        </html>';
      $header = "From:" . SITE_NAME . " <" . ADMIN_EMAIL . "> \r\n";
      $header .= "Cc:" . ADMIN_EMAIL . " \r\n";
      $header .= "MIME-Version: 1.0\r\n";
      $header .= "Content-type: text/html\r\n";

      @$retval = mail($to, $subject, $message, $header);
    }
    return true;
  }
}

function editTrade($data)
{

  $db_conn = connect_to_database();

  $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("s", $data["account_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "Unable to find the specified account. Please try again later.";
    return false;
  }

  // echo '<script>window.alert("editTrade")</script>';

  $row = $result->fetch_assoc();
  $datasource = json_decode($row['datasource'], true);

  if ($data["winLoss"] == 1) {
    $_SESSION["feedback"] = "Please choose if trade is win or Loss";
    return false;
  } elseif ($data["winLoss"] == 2 || $data["winLoss"] == 3) {
    $status = 2;
  }

  if ($data['winLoss'] == 2) {
    $datasource["account_earnings"] = $datasource["account_earnings"] + $data["profitLoss"];
  } elseif ($data['winLoss'] == 3) {
    $datasource["account_balance"] = floatval($datasource["account_balance"]) + floatval($data["stakeAmt"]);
    $totalLoss = floatval($data["profitLoss"]) - floatval($data["stakeAmt"]);
    $datasource["account_balance"] = floatval($datasource["account_balance"]) - $totalLoss;
  }

  $stmt = $db_conn->prepare("UPDATE `trades` SET `status` = ? , `winLoss` = ?, `profitLoss` = ? WHERE id = ?");
  $stmt->bind_param("iisi", $status, $data["winLoss"], $data["profitLoss"], $data["trade_id"]);
  $stmt->execute();

  $datasourceEncoded = json_encode($datasource);

  $stmt = $db_conn->prepare("UPDATE `accounts` SET `datasource` = ? WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("ss", $datasourceEncoded, $data["account_id"]);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "Failed to initiate Your Request. Please try again later.";
    return false;
  } else {
    $_SESSION["feedback"] = "Request has been successfully initiated!";

    // mail function
    $message = '';
    $fname = $datasource['full_names'];
    $email = $datasource['email_address'];
    $winLossEmail = $data['winLoss'] == 2 ? "Win" : "Loss";

    // Send mail to user with verification here
    $to = $email;
    $subject = "TRADE NOTIFICATION";

    // Create the body message
    $message .= '<!DOCTYPE html>
    <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width,initial-scale=1">
      <meta name="x-apple-disable-message-reformatting">
      <title></title>
      <!--[if mso]>
      <noscript>
        <xml>
          <o:OfficeDocumentSettings>
            <o:PixelsPerInch>96</o:PixelsPerInch>
          </o:OfficeDocumentSettings>
        </xml>
      </noscript>
      <![endif]-->
      <style>
        table, td, div, h1, p {font-family: Arial, sans-serif;}
        button{
            font: inherit;
            background-color: #FF7A59;
            border: none;
            padding: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 700; 
            color: white;
            border-radius: 5px; 
            box-shadow: 1px 2px #d94c53;
          }
      </style>
    </head>
    <body style="margin:0;padding:0;">
      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
        <tr>
          <td align="center" style="padding:0;">
            <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
              <tr>
                    <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                        <h1 style="margin:24px">Swiftpipstraders</h1> 
                    </td>
              </tr>
              <tr style="background-color: #eeeeee;">
                <td style="padding:36px 30px 42px 30px;">
                  <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                    <tr>
                      <td style="padding:0 0 36px 0;color:#153643;">
                        <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Dear ' . $fname . ' , </h1>
                        <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                          Your trade in Swiftpipstraders account have completed on : ' . date('Y-m-d h:i A') . '.
                        </p>
                        <br>
                        <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                        Type : ' . $data['type'] . '
                        <br>
                        Asset : ' . $data['asset'] . '
                        <br>
                        Amount : $' . $data['amount'] . '
                        <br>
                        Market : ' . $data['market'] . '
                        <br>
                        Duration : ' . $data['duration'] . '
                        <br>
                        Profit/Loss : $' . $data["profitLoss"] . '
                        <br>
                        Win/Loss : ' . $winLossEmail . '
                        <br>

                        <br>
                        <br>
                        <i><b>Thanks for trading with us</b></i> 
                        </p>
                        <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                            <a href="https://Swiftpipstraders.online/account" style="color:#ee4c50;text-decoration:underline;"> 
                                <button> 
                                    Click to Login
                                </button>  
                            </a>
                        </p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td style="padding:30px;background:#ee4c50;">
                  <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                    <tr>
                      <td style="padding:0;width:50%;" align="left">
                        <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                          &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                        </p>
                      </td>
                      <td style="padding:0;width:50%;" align="right">
                        <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                          <tr>
                            <td style="padding:0 0 0 10px;width:38px;">
                              <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                            </td>
                            <td style="padding:0 0 0 10px;width:38px;">
                              <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </body>
    </html>';
    $header = "From:Swiftpipstraders <no-reply@swiftpipstraders.online> \r\n";
    $header .= "Cc:no-reply@swiftpipstraders.online \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);

    // admin email 
    if ($_SESSION["feedback"]) {

      // Create the body message
      $message = '';
      $Clientfname = $datasource['full_names'];
      $adminEmail = ADMIN_EMAIL;

      // Send mail to user with verification here
      $to = $adminEmail;
      $subject = "TRADE NOTIFICATION";

      $message .= '<!DOCTYPE html>
        <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width,initial-scale=1">
          <meta name="x-apple-disable-message-reformatting">
          <title></title>
          <!--[if mso]>
          <noscript>
            <xml>
              <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
              </o:OfficeDocumentSettings>
            </xml>
          </noscript>
          <![endif]-->
          <style>
            table, td, div, h1, p {font-family: Arial, sans-serif;}
            button{
                font: inherit;
                background-color: #FF7A59;
                border: none;
                padding: 10px;
                text-transform: uppercase;
                letter-spacing: 2px;
                font-weight: 700; 
                color: white;
                border-radius: 5px; 
                box-shadow: 1px 2px #d94c53;
              }
          </style>
        </head>
        <body style="margin:0;padding:0;">
          <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
            <tr>
              <td align="center" style="padding:0;">
                <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                  <tr>
                        <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                            <h1 style="margin:24px">Swiftpipstraders</h1> 
                        </td>
                  </tr>
                  <tr style="background-color: #eeeeee;">
                    <td style="padding:36px 30px 42px 30px;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                        <tr>
                          <td style="padding:0 0 36px 0;color:#153643;">
                            <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Hello Admin , </h1>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                              You have ' . $Clientfname . ' trade on : ' . date('Y-m-d h:i A') . '.
                            </p>
                            <br>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                            Type : ' . $data['type'] . '
                            <br>
                            Asset : ' . $data['asset'] . '
                            <br>
                            Amount : $' . $data['amount'] . '
                            <br>
                            Market : ' . $data['market'] . '
                            <br>
                            Duration : ' . $data['duration'] . '
                            <br>
                            Profit/Loss : $' . $data["profitLoss"] . '
                            <br>
                            Win/Loss : ' . $winLossEmail . '
                            <br>
                            </p>
                            <br>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                           Welcome aboard! We are thrilled to have you as part of our Swiftpipstraders community.
                           <br>
                           We are here to make your trading experience enjoyable and seamless.
                              
                            </p>
                            <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                <a href="mailto:no-reply@swiftpipstraders.online" style="color:#ee4c50;text-decoration:underline;"> 
                                    <button> 
                                        Click to mail support
                                    </button>  
                                </a>
                            </p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding:30px;background:#ee4c50;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                        <tr>
                          <td style="padding:0;width:50%;" align="left">
                            <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                              &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                            </p>
                          </td>
                          <td style="padding:0;width:50%;" align="right">
                            <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                              <tr>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </body>
        </html>';
      $header = "From:" . SITE_NAME . " <" . ADMIN_EMAIL . "> \r\n";
      $header .= "Cc:" . ADMIN_EMAIL . " \r\n";
      $header .= "MIME-Version: 1.0\r\n";
      $header .= "Content-type: text/html\r\n";

      @$retval = mail($to, $subject, $message, $header);
    }
    return true;
  }
}

function ai_subscription($data)
{
  $db_conn = connect_to_database();

  $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("s", $data["account_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "Unable to find the specified account. Please try again later.";
    return false;
  }

  $row = $result->fetch_assoc();
  $datasource = json_decode($row['datasource'], true);

  if ($data['min'] > $data['amount']) {
    $_SESSION["feedback"] = "Insufficient Amount! Minimum is $" . $data['min'] . " ";
    return false;
  } elseif ($data['amount'] > $data['max']) {
    $_SESSION["feedback"] = "Max is $" . $data['max'] . " Try a higher Plan ";
    return false;
  }

  if ($data["amount"] > $datasource["account_balance"]) {
    $_SESSION["feedback"] = "Insufficient funds! Your account balance is too low for this investment.";
    return false;
  }

  $account_id = $data['account_id'];
  $ai_plan = $data['ai_plan'];
  $winRate = $data['winRate'];
  $amount = $data['amount'];
  $duration = $data['duration'];
  $status = 1;

  $stmt = $db_conn->prepare("INSERT INTO `ai_investments`(`account_id`,`ai_plan`,`winRate`,`amount`,`duration`,`status`) VALUES (?,?,?,?,?,?)");
  $stmt->bind_param("ssssss", $account_id, $ai_plan, $winRate, $amount, $duration, $status);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "Failed to initiate account funding. Please try again later.";
    return false;
  }

  $datasource["account_balance"] -= $data["amount"];
  $datasource["amount_invested"] += $data["amount"];

  $encoded_datasource = json_encode($datasource);

  $stmt = $db_conn->prepare("UPDATE `accounts` SET `datasource` = ? WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("ss", $encoded_datasource, $data["account_id"]);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "Failed to update account data. Please try again later.";
    return false;
  }

  $_SESSION["feedback"] = "Your investment has been successfully initiated ";

  if ($_SESSION["feedback"]) {

    $noft_id = bin2hex(random_bytes(20));
    $account_id = $data["account_id"];
    $noft_category = 'AI SUBSCRIPTION NOTIFICATION';
    $noft_msg = 'Hello ' . $datasource['full_names'] . ', Your AI subscription on ' . $data["investment_plan"] . ' plan of $' . $data['amount'] . ' has been purchased successfully';
    $noft_status = 'Active';

    $stmt = $db_conn->prepare("INSERT INTO `notification` (`noft_id`,`account_id`,`noft_category`,`noft_msg`,`noft_status`) VALUE (?,?,?,?,?)");
    $stmt->bind_param("sssss", $noft_id, $account_id, $noft_category, $noft_msg, $noft_status);
    $stmt->execute();
  }

  if ($_SESSION["feedback"]) {

    // mail function
    $message = '';
    $fname = $datasource['full_names'];
    $email = $datasource['email_address'];

    // Send mail to user with verification here
    $to = $email;
    $subject = "SUBSCRIPTION NOTIFICATION";

    // Create the body message
    $message .= '<!DOCTYPE html>
              <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
              <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width,initial-scale=1">
                <meta name="x-apple-disable-message-reformatting">
                <title></title>
                <!--[if mso]>
                <noscript>
                  <xml>
                    <o:OfficeDocumentSettings>
                      <o:PixelsPerInch>96</o:PixelsPerInch>
                    </o:OfficeDocumentSettings>
                  </xml>
                </noscript>
                <![endif]-->
                <style>
                  table, td, div, h1, p {font-family: Arial, sans-serif;}
                  button{
                      font: inherit;
                      background-color: #FF7A59;
                      border: none;
                      padding: 10px;
                      text-transform: uppercase;
                      letter-spacing: 2px;
                      font-weight: 700; 
                      color: white;
                      border-radius: 5px; 
                      box-shadow: 1px 2px #d94c53;
                    }
                </style>
              </head>
              <body style="margin:0;padding:0;">
                <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                  <tr>
                    <td align="center" style="padding:0;">
                      <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                        <tr>
                              <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                                  <h1 style="margin:24px">Swiftpipstraders</h1> 
                              </td>
                        </tr>
                        <tr style="background-color: #eeeeee;">
                          <td style="padding:36px 30px 42px 30px;">
                            <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                              <tr>
                                <td style="padding:0 0 36px 0;color:#153643;">
                                  <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Dear ' . $fname . ' , </h1>
                                  <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                    Your AI subscription on ' . $data["investment_plan"] . ' plan of 
                                     $' . $data['amount'] . ' has been purchased successfully.
                                  </p>
                                  <br>
                                  <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                  <br>
                                  <i><b>Thanks for choosing us</b></i> 
                                  </p>
                                  <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                      <a href="https://Swiftpipstraders.online/account" style="color:#ee4c50;text-decoration:underline;"> 
                                          <button> 
                                              Click to Login
                                          </button>  
                                      </a>
                                  </p>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td style="padding:30px;background:#ee4c50;">
                            <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                              <tr>
                                <td style="padding:0;width:50%;" align="left">
                                  <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                    &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                                  </p>
                                </td>
                                <td style="padding:0;width:50%;" align="right">
                                  <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                                    <tr>
                                      <td style="padding:0 0 0 10px;width:38px;">
                                        <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                      </td>
                                      <td style="padding:0 0 0 10px;width:38px;">
                                        <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </body>
              </html>';
    $header = "From:Swiftpipstraders <no-reply@swiftpipstraders.online> \r\n";
    $header .= "Cc:no-reply@swiftpipstraders.online \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);
  }
  if ($_SESSION["feedback"]) {

    // Create the body message
    $message = '';
    $Clientfname = $datasource['full_names'];
    $adminEmail = ADMIN_EMAIL;

    // Send mail to user with verification here
    $to = $adminEmail;
    $subject = "AI SUBSCRIPTION NOTIFICATION";

    $message .= '<!DOCTYPE html>
        <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width,initial-scale=1">
          <meta name="x-apple-disable-message-reformatting">
          <title></title>
          <!--[if mso]>
          <noscript>
            <xml>
              <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
              </o:OfficeDocumentSettings>
            </xml>
          </noscript>
          <![endif]-->
          <style>
            table, td, div, h1, p {font-family: Arial, sans-serif;}
            button{
                font: inherit;
                background-color: #FF7A59;
                border: none;
                padding: 10px;
                text-transform: uppercase;
                letter-spacing: 2px;
                font-weight: 700; 
                color: white;
                border-radius: 5px; 
                box-shadow: 1px 2px #d94c53;
              }
          </style>
        </head>
        <body style="margin:0;padding:0;">
          <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
            <tr>
              <td align="center" style="padding:0;">
                <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                  <tr>
                        <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                            <h1 style="margin:24px">Swiftpipstraders</h1> 
                        </td>
                  </tr>
                  <tr style="background-color: #eeeeee;">
                    <td style="padding:36px 30px 42px 30px;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                        <tr>
                          <td style="padding:0 0 36px 0;color:#153643;">
                            <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Hello Admin , </h1>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                              A client by the name ' . $Clientfname . ' has initiated an AI subscription on  ' . $data["investment_plan"] . ' plan of $' . $data['amount'] . '.
                    
                            </p>
                            <br>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                           Welcome aboard! We are thrilled to have you as part of our Swiftpipstraders community.
                           <br>
                           We are here to make your trading experience enjoyable and seamless.
                              
                            </p>
                            <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                <a href="mailto:no-reply@swiftpipstraders.online" style="color:#ee4c50;text-decoration:underline;"> 
                                    <button> 
                                        Click to mail support
                                    </button>  
                                </a>
                            </p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding:30px;background:#ee4c50;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                        <tr>
                          <td style="padding:0;width:50%;" align="left">
                            <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                              &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                            </p>
                          </td>
                          <td style="padding:0;width:50%;" align="right">
                            <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                              <tr>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </body>
        </html>';
    $header = "From:" . SITE_NAME . " <" . ADMIN_EMAIL . "> \r\n";
    $header .= "Cc:" . ADMIN_EMAIL . " \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);
  }
  return false;
}

function ai_completeDelete($data)
{
  $db_conn = connect_to_database();

  if ($data["ai_complete"]) {

    if ($data['status'] == 2) {
      $_SESSION["feedback"] = "Item have been completed previously";
      return false;
    }

    $status = 2;
    $stmt = $db_conn->prepare("UPDATE `ai_investments` SET `status` = ? WHERE id = ?");
    $stmt->bind_param("ii", $status, $data["id"]);
    $stmt->execute();

    if ($stmt->affected_rows <= 0) {
      $_SESSION["feedback"] = "Failed to initiate Your Request. Please try again later.";
      return false;
    } else {
      $_SESSION["feedback"] = "Item completed successfully!";
      return true;
    }
  } else {
    if ($data['status'] == 3) {
      $_SESSION["feedback"] = "Item have been Cancelled previously";
      return false;
    }

    $status = 3;
    $stmt = $db_conn->prepare("UPDATE `ai_investments` SET `status` = ? WHERE id = ?");
    $stmt->bind_param("ii", $status, $data["id"]);
    $stmt->execute();

    if ($stmt->affected_rows <= 0) {
      $_SESSION["feedback"] = "Failed to initiate Your Request. Please try again later.";
      return false;
    } else {
      $_SESSION["feedback"] = "Item Cancelled successfully!";
      return true;
    }
  }
}

function ai_delete($data)
{

  $db_conn = connect_to_database();
  $stmt = $db_conn->prepare("DELETE FROM `ai_investments` WHERE id = ?");
  $stmt->bind_param("i", $data["id"]);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "Failed to initiate Your Request. Please try again later.";
    return false;
  } else {
    $_SESSION["feedback"] = "Item deleted successfully!";
    return true;
  }
}

function initialize_kyc($data): bool
{

  if (empty($data['document'] || $data['front_of_document'] || $data['back_of_document'])) {
    $_SESSION["feedback"] = "Please Fill in all fields";
    return false;
  }

  $file_path_front = "../_servers/front_kyc/";
  $file_path_back = "../_servers/back_kyc/";

  $payment_proof_size_limit = 10 * 1024 * 1024;
  $kyc_proof_front = $_FILES["front_of_document"];
  $kyc_proof_back = $_FILES["back_of_document"];

  if ($kyc_proof_front['size'] > $payment_proof_size_limit) {
    $_SESSION["feedback"] = "The uploaded file exceeds the size limit of 10 MB. Please choose a smaller file.";
    return false;
  } elseif ($kyc_proof_back['size'] > $payment_proof_size_limit) {
    $_SESSION["feedback"] = "The uploaded file exceeds the size limit of 10 MB. Please choose a smaller file.";
    return false;
  }

  $db_conn = connect_to_database();

  $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("s", $data["account_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "Unable to find the specified account. Please try again later.";
    return false;
  }

  $row = $result->fetch_assoc();
  $datasource = json_decode($row['datasource'], true);

  $kyc_data = [
    "kyc_id" => bin2hex(random_bytes(32)),
    "account_id" => $datasource["account_id"],
    "kyc_date" => date("jS M Y"),
    "kyc_status" => "Pending",
    "kyc_document" => $data['document'],
    "kyc_proof_front" => "-- / --",
    "kyc_proof_back" => "-- / --",
  ];

  $kyc_data["kyc_proof_front"] = bin2hex(random_bytes(32)) . "." . pathinfo($kyc_proof_front["name"], PATHINFO_EXTENSION);

  $kyc_data["kyc_proof_back"] = bin2hex(random_bytes(32)) . "." . pathinfo($kyc_proof_back["name"], PATHINFO_EXTENSION);

  if (!move_uploaded_file($kyc_proof_front["tmp_name"], $file_path_front . $kyc_data["kyc_proof_front"])) {
    $_SESSION["feedback"] = "We're currently unable to process your request. We kindly request that you upload front page of your document again.";
    return false;
  } elseif (!move_uploaded_file($kyc_proof_back["tmp_name"], $file_path_back . $kyc_data["kyc_proof_back"])) {
    $_SESSION["feedback"] = "We're currently unable to process your request. We kindly request that you upload back page of your document again.";
  }

  $encoded_kyc_data = json_encode($kyc_data);

  $stmt = $db_conn->prepare("INSERT INTO `kyc`(`datasource`) VALUES (?)");
  $stmt->bind_param("s", $encoded_kyc_data);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "Failed to initiate account KYC. Please try again later.";
    return false;
  }

  $_SESSION["feedback"] = "Your KYC request has been successfully initiated and currently under review. Your account will be verified shortly.";


  if ($_SESSION["feedback"]) {

    $noft_id = bin2hex(random_bytes(20));
    $account_id = $data["account_id"];
    $noft_category = 'KYC NOTIFICATION';
    $noft_msg = 'Hello ' . $datasource['full_names'] . ', Your KYC document has been submitted, your account will be verified once it is confirmed.';
    $noft_status = 'Active';

    $stmt = $db_conn->prepare("INSERT INTO `notification` (`noft_id`,`account_id`,`noft_category`,`noft_msg`,`noft_status`) VALUE (?,?,?,?,?)");
    $stmt->bind_param("sssss", $noft_id, $account_id, $noft_category, $noft_msg, $noft_status);
    $stmt->execute();
  }

  if ($_SESSION["feedback"]) {

    // mail function
    $message = '';
    $fname = $datasource['full_names'];
    $email = $datasource['email_address'];

    // Send mail to user with verification here
    $to = $email;
    $subject = "KYC NOTIFICATION";

    // Create the body message
    $message .= '<!DOCTYPE html>
                <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
                <head>
                  <meta charset="UTF-8">
                  <meta name="viewport" content="width=device-width,initial-scale=1">
                  <meta name="x-apple-disable-message-reformatting">
                  <title></title>
                  <!--[if mso]>
                  <noscript>
                    <xml>
                      <o:OfficeDocumentSettings>
                        <o:PixelsPerInch>96</o:PixelsPerInch>
                      </o:OfficeDocumentSettings>
                    </xml>
                  </noscript>
                  <![endif]-->
                  <style>
                    table, td, div, h1, p {font-family: Arial, sans-serif;}
                    button{
                        font: inherit;
                        background-color: #FF7A59;
                        border: none;
                        padding: 10px;
                        text-transform: uppercase;
                        letter-spacing: 2px;
                        font-weight: 700; 
                        color: white;
                        border-radius: 5px; 
                        box-shadow: 1px 2px #d94c53;
                      }
                  </style>
                </head>
                <body style="margin:0;padding:0;">
                  <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                    <tr>
                      <td align="center" style="padding:0;">
                        <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                          <tr>
                                <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                                    <h1 style="margin:24px">Swiftpipstraders</h1> 
                                </td>
                          </tr>
                          <tr style="background-color: #eeeeee;">
                            <td style="padding:36px 30px 42px 30px;">
                              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                <tr>
                                  <td style="padding:0 0 36px 0;color:#153643;">
                                    <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Dear ' . $fname . ' , </h1>
                                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                      Your KYC document has been submitted, your account will be verified once it is confirmed .
                                    </p>
                                    <br>
                                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                    <br>
                                    <i><b>Thanks for choosing us</b></i> 
                                    </p>
                                    <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        <a href="https://Swiftpipstraders.online/account" style="color:#ee4c50;text-decoration:underline;"> 
                                            <button> 
                                                Click to Login
                                            </button>  
                                        </a>
                                    </p>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                          <tr>
                            <td style="padding:30px;background:#ee4c50;">
                              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                                <tr>
                                  <td style="padding:0;width:50%;" align="left">
                                    <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                      &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                                    </p>
                                  </td>
                                  <td style="padding:0;width:50%;" align="right">
                                    <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                                      <tr>
                                        <td style="padding:0 0 0 10px;width:38px;">
                                          <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                        </td>
                                        <td style="padding:0 0 0 10px;width:38px;">
                                          <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </body>
                </html>';
    $header = "From:Swiftpipstraders <no-reply@swiftpipstraders.online> \r\n";
    $header .= "Cc:no-reply@swiftpipstraders.online \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);
  }
  if ($_SESSION["feedback"]) {

    // Create the body message
    $message = '';
    $Clientfname = $datasource['full_names'];
    $adminEmail = ADMIN_EMAIL;

    // Send mail to user with verification here
    $to = $adminEmail;
    $subject = "KYC NOTIFICATION";

    $message .= '<!DOCTYPE html>
        <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width,initial-scale=1">
          <meta name="x-apple-disable-message-reformatting">
          <title></title>
          <!--[if mso]>
          <noscript>
            <xml>
              <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
              </o:OfficeDocumentSettings>
            </xml>
          </noscript>
          <![endif]-->
          <style>
            table, td, div, h1, p {font-family: Arial, sans-serif;}
            button{
                font: inherit;
                background-color: #FF7A59;
                border: none;
                padding: 10px;
                text-transform: uppercase;
                letter-spacing: 2px;
                font-weight: 700; 
                color: white;
                border-radius: 5px; 
                box-shadow: 1px 2px #d94c53;
              }
          </style>
        </head>
        <body style="margin:0;padding:0;">
          <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
            <tr>
              <td align="center" style="padding:0;">
                <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                  <tr>
                        <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                            <h1 style="margin:24px">Swiftpipstraders</h1> 
                        </td>
                  </tr>
                  <tr style="background-color: #eeeeee;">
                    <td style="padding:36px 30px 42px 30px;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                        <tr>
                          <td style="padding:0 0 36px 0;color:#153643;">
                            <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Hello Admin , </h1>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                              A client by the name ' . $Clientfname . ' have submitted documents for KYC verification.
                    
                            </p>
                            <br>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                           Welcome aboard! We are thrilled to have you as part of our Swiftpipstraders community.
                           <br>
                           We are here to make your trading experience enjoyable and seamless.
                              
                            </p>
                            <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                <a href="mailto:no-reply@swiftpipstraders.online" style="color:#ee4c50;text-decoration:underline;"> 
                                    <button> 
                                        Click to mail support
                                    </button>  
                                </a>
                            </p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding:30px;background:#ee4c50;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                        <tr>
                          <td style="padding:0;width:50%;" align="left">
                            <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                              &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                            </p>
                          </td>
                          <td style="padding:0;width:50%;" align="right">
                            <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                              <tr>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </body>
        </html>';
    $header = "From:" . SITE_NAME . " <" . ADMIN_EMAIL . "> \r\n";
    $header .= "Cc:" . ADMIN_EMAIL . " \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);
  }

  return false;
}

function approve_kyc($data)
{
  $db_conn = connect_to_database();

  $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("s", $data["account_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "Unable to find the specified account. Please try again later.";
    return false;
  }

  $row = $result->fetch_assoc();
  $datasource = json_decode($row['datasource'], true);

  $stmt = $db_conn->prepare("SELECT * FROM `kyc` WHERE JSON_EXTRACT(`datasource`, '$.kyc_id') = ? AND JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("ss", $data["kyc_id"], $data["account_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }


  $kyc_status = "Completed";

  $stmt = $db_conn->prepare("UPDATE `kyc` SET `datasource` = JSON_SET(`datasource`, '$.kyc_status', ?) WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ? AND JSON_EXTRACT(`datasource`, '$.kyc_id') = ?");
  $stmt->bind_param("sss", $kyc_status, $data["account_id"],  $data["kyc_id"]);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }

  $_SESSION["feedback"] = "Investor's account profile has been successfully updated!";


  if ($_SESSION["feedback"]) {

    $noft_id = bin2hex(random_bytes(20));
    $account_id = $data["account_id"];
    $noft_category = 'KYC NOTIFICATION';
    $noft_msg = 'Hello ' . $datasource['full_names'] . ',  Your KYC documents have been approved, your account will be Updated shortly.';
    $noft_status = 'Active';

    $stmt = $db_conn->prepare("INSERT INTO `notification` (`noft_id`,`account_id`,`noft_category`,`noft_msg`,`noft_status`) VALUE (?,?,?,?,?)");
    $stmt->bind_param("sssss", $noft_id, $account_id, $noft_category, $noft_msg, $noft_status);
    $stmt->execute();
  }

  if ($_SESSION["feedback"]) {

    // mail function
    $message = '';
    $fname = $datasource['full_names'];
    $email = $datasource['email_address'];

    // Send mail to user with verification here
    $to = $email;
    $subject = "KYC NOTIFICATION";

    // Create the body message
    $message .= '<!DOCTYPE html>
                <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
                <head>
                  <meta charset="UTF-8">
                  <meta name="viewport" content="width=device-width,initial-scale=1">
                  <meta name="x-apple-disable-message-reformatting">
                  <title></title>
                  <!--[if mso]>
                  <noscript>
                    <xml>
                      <o:OfficeDocumentSettings>
                        <o:PixelsPerInch>96</o:PixelsPerInch>
                      </o:OfficeDocumentSettings>
                    </xml>
                  </noscript>
                  <![endif]-->
                  <style>
                    table, td, div, h1, p {font-family: Arial, sans-serif;}
                    button{
                        font: inherit;
                        background-color: #FF7A59;
                        border: none;
                        padding: 10px;
                        text-transform: uppercase;
                        letter-spacing: 2px;
                        font-weight: 700; 
                        color: white;
                        border-radius: 5px; 
                        box-shadow: 1px 2px #d94c53;
                      }
                  </style>
                </head>
                <body style="margin:0;padding:0;">
                  <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                    <tr>
                      <td align="center" style="padding:0;">
                        <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                          <tr>
                                <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                                    <h1 style="margin:24px">Swiftpipstraders</h1> 
                                </td>
                          </tr>
                          <tr style="background-color: #eeeeee;">
                            <td style="padding:36px 30px 42px 30px;">
                              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                <tr>
                                  <td style="padding:0 0 36px 0;color:#153643;">
                                    <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Dear ' . $fname . ' , </h1>
                                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                      Your KYC documents have been approved, your account will be Updated shortly.
                                    </p>
                                    <br>
                                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                    <br>
                                    <i><b>Thanks for choosing us</b></i> 
                                    </p>
                                    <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        <a href="https://Swiftpipstraders.online/account" style="color:#ee4c50;text-decoration:underline;"> 
                                            <button> 
                                                Click to Login
                                            </button>  
                                        </a>
                                    </p>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                          <tr>
                            <td style="padding:30px;background:#ee4c50;">
                              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                                <tr>
                                  <td style="padding:0;width:50%;" align="left">
                                    <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                      &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                                    </p>
                                  </td>
                                  <td style="padding:0;width:50%;" align="right">
                                    <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                                      <tr>
                                        <td style="padding:0 0 0 10px;width:38px;">
                                          <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                        </td>
                                        <td style="padding:0 0 0 10px;width:38px;">
                                          <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </body>
                </html>';
    $header = "From:Swiftpipstraders <no-reply@swiftpipstraders.online> \r\n";
    $header .= "Cc:no-reply@swiftpipstraders.online \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);
  }
  if ($_SESSION["feedback"]) {

    // Create the body message
    $message = '';
    $Clientfname = $datasource['full_names'];
    $adminEmail = ADMIN_EMAIL;

    // Send mail to user with verification here
    $to = $adminEmail;
    $subject = "KYC NOTIFICATION";

    $message .= '<!DOCTYPE html>
        <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width,initial-scale=1">
          <meta name="x-apple-disable-message-reformatting">
          <title></title>
          <!--[if mso]>
          <noscript>
            <xml>
              <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
              </o:OfficeDocumentSettings>
            </xml>
          </noscript>
          <![endif]-->
          <style>
            table, td, div, h1, p {font-family: Arial, sans-serif;}
            button{
                font: inherit;
                background-color: #FF7A59;
                border: none;
                padding: 10px;
                text-transform: uppercase;
                letter-spacing: 2px;
                font-weight: 700; 
                color: white;
                border-radius: 5px; 
                box-shadow: 1px 2px #d94c53;
              }
          </style>
        </head>
        <body style="margin:0;padding:0;">
          <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
            <tr>
              <td align="center" style="padding:0;">
                <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                  <tr>
                        <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                            <h1 style="margin:24px">Swiftpipstraders</h1> 
                        </td>
                  </tr>
                  <tr style="background-color: #eeeeee;">
                    <td style="padding:36px 30px 42px 30px;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                        <tr>
                          <td style="padding:0 0 36px 0;color:#153643;">
                            <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Hello Admin , </h1>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                              You have approved a KYC document from ' . $Clientfname . '.
                    
                            </p>
                            <br>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                           Welcome aboard! We are thrilled to have you as part of our Swiftpipstraders community.
                           <br>
                           We are here to make your trading experience enjoyable and seamless.
                              
                            </p>
                            <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                <a href="mailto:no-reply@swiftpipstraders.online" style="color:#ee4c50;text-decoration:underline;"> 
                                    <button> 
                                        Click to mail support
                                    </button>  
                                </a>
                            </p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding:30px;background:#ee4c50;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                        <tr>
                          <td style="padding:0;width:50%;" align="left">
                            <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                              &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                            </p>
                          </td>
                          <td style="padding:0;width:50%;" align="right">
                            <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                              <tr>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </body>
        </html>';
    $header = "From:" . SITE_NAME . " <" . ADMIN_EMAIL . "> \r\n";
    $header .= "Cc:" . ADMIN_EMAIL . " \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);
  }
  return true;
}

function cancel_kyc($data)
{
  $db_conn = connect_to_database();

  $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("s", $data["account_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "Unable to find the specified account. Please try again later.";
    return false;
  }

  $row = $result->fetch_assoc();
  $datasource = json_decode($row['datasource'], true);

  $stmt = $db_conn->prepare("SELECT * FROM `kyc` WHERE JSON_EXTRACT(`datasource`, '$.kyc_id') = ? AND JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("ss", $data["kyc_id"], $data["account_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }


  $kyc_status = "Cancelled";

  $stmt = $db_conn->prepare("UPDATE `kyc` SET `datasource` = JSON_SET(`datasource`, '$.kyc_status', ?) WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ? AND JSON_EXTRACT(`datasource`, '$.kyc_id') = ?");
  $stmt->bind_param("sss", $kyc_status, $data["account_id"],  $data["kyc_id"]);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }

  $_SESSION["feedback"] = "Investor's account profile has been successfully updated!";


  if ($_SESSION["feedback"]) {

    $noft_id = bin2hex(random_bytes(20));
    $account_id = $data["account_id"];
    $noft_category = 'KYC NOTIFICATION';
    $noft_msg = 'Hello ' . $datasource['full_names'] . ', Your KYC documents have been Denied. Please contact support to rectify your issues so you can enjoy your trading experience with us  ';
    $noft_status = 'Active';

    $stmt = $db_conn->prepare("INSERT INTO `notification` (`noft_id`,`account_id`,`noft_category`,`noft_msg`,`noft_status`) VALUE (?,?,?,?,?)");
    $stmt->bind_param("sssss", $noft_id, $account_id, $noft_category, $noft_msg, $noft_status);
    $stmt->execute();
  }


  if ($_SESSION["feedback"]) {

    // mail function
    $message = '';
    $fname = $datasource['full_names'];
    $email = $datasource['email_address'];

    // Send mail to user with verification here
    $to = $email;
    $subject = "KYC NOTIFICATION";

    // Create the body message
    $message .= '<!DOCTYPE html>
                <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
                <head>
                  <meta charset="UTF-8">
                  <meta name="viewport" content="width=device-width,initial-scale=1">
                  <meta name="x-apple-disable-message-reformatting">
                  <title></title>
                  <!--[if mso]>
                  <noscript>
                    <xml>
                      <o:OfficeDocumentSettings>
                        <o:PixelsPerInch>96</o:PixelsPerInch>
                      </o:OfficeDocumentSettings>
                    </xml>
                  </noscript>
                  <![endif]-->
                  <style>
                    table, td, div, h1, p {font-family: Arial, sans-serif;}
                    button{
                        font: inherit;
                        background-color: #FF7A59;
                        border: none;
                        padding: 10px;
                        text-transform: uppercase;
                        letter-spacing: 2px;
                        font-weight: 700; 
                        color: white;
                        border-radius: 5px; 
                        box-shadow: 1px 2px #d94c53;
                      }
                  </style>
                </head>
                <body style="margin:0;padding:0;">
                  <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                    <tr>
                      <td align="center" style="padding:0;">
                        <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                          <tr>
                                <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                                    <h1 style="margin:24px">Swiftpipstraders</h1> 
                                </td>
                          </tr>
                          <tr style="background-color: #eeeeee;">
                            <td style="padding:36px 30px 42px 30px;">
                              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                <tr>
                                  <td style="padding:0 0 36px 0;color:#153643;">
                                    <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Dear ' . $fname . ' , </h1>
                                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                      Your KYC documents have been Denied. Please contact support to rectify your issues so you can enjoy your trading experience with us .
                                    </p>
                                    <br>
                                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                    <br>
                                    <i><b>Thanks for choosing us</b></i> 
                                    </p>
                                    <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                    <a href="mailto:no-reply@swiftpipstraders.online" style="color:#ee4c50;text-decoration:underline;"> 
                                        <button> 
                                            Click to mail support
                                        </button>  
                                    </a>
                                </p>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                          <tr>
                            <td style="padding:30px;background:#ee4c50;">
                              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                                <tr>
                                  <td style="padding:0;width:50%;" align="left">
                                    <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                      &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                                    </p>
                                  </td>
                                  <td style="padding:0;width:50%;" align="right">
                                    <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                                      <tr>
                                        <td style="padding:0 0 0 10px;width:38px;">
                                          <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                        </td>
                                        <td style="padding:0 0 0 10px;width:38px;">
                                          <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </body>
                </html>';
    $header = "From:Swiftpipstraders <no-reply@swiftpipstraders.online> \r\n";
    $header .= "Cc:no-reply@swiftpipstraders.online \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);
  }
  if ($_SESSION["feedback"]) {

    // Create the body message
    $message = '';
    $Clientfname = $datasource['full_names'];
    $adminEmail = ADMIN_EMAIL;

    // Send mail to user with verification here
    $to = $adminEmail;
    $subject = "KYC NOTIFICATION";

    $message .= '<!DOCTYPE html>
        <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width,initial-scale=1">
          <meta name="x-apple-disable-message-reformatting">
          <title></title>
          <!--[if mso]>
          <noscript>
            <xml>
              <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
              </o:OfficeDocumentSettings>
            </xml>
          </noscript>
          <![endif]-->
          <style>
            table, td, div, h1, p {font-family: Arial, sans-serif;}
            button{
                font: inherit;
                background-color: #FF7A59;
                border: none;
                padding: 10px;
                text-transform: uppercase;
                letter-spacing: 2px;
                font-weight: 700; 
                color: white;
                border-radius: 5px; 
                box-shadow: 1px 2px #d94c53;
              }
          </style>
        </head>
        <body style="margin:0;padding:0;">
          <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
            <tr>
              <td align="center" style="padding:0;">
                <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                  <tr>
                        <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                            <h1 style="margin:24px">Swiftpipstraders</h1> 
                        </td>
                  </tr>
                  <tr style="background-color: #eeeeee;">
                    <td style="padding:36px 30px 42px 30px;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                        <tr>
                          <td style="padding:0 0 36px 0;color:#153643;">
                            <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Hello Admin , </h1>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                               You have Denied a KYC document from ' . $Clientfname . '.
                    
                            </p>
                            <br>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                           Welcome aboard! We are thrilled to have you as part of our Swiftpipstraders community.
                           <br>
                           We are here to make your trading experience enjoyable and seamless.
                              
                            </p>
                            <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                <a href="mailto:no-reply@swiftpipstraders.online" style="color:#ee4c50;text-decoration:underline;"> 
                                    <button> 
                                        Click to mail support
                                    </button>  
                                </a>
                            </p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding:30px;background:#ee4c50;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                        <tr>
                          <td style="padding:0;width:50%;" align="left">
                            <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                              &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                            </p>
                          </td>
                          <td style="padding:0;width:50%;" align="right">
                            <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                              <tr>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </body>
        </html>';
    $header = "From:" . SITE_NAME . " <" . ADMIN_EMAIL . "> \r\n";
    $header .= "Cc:" . ADMIN_EMAIL . " \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);
  }
  return true;
}


// function for read notification
function read($data)
{
  $db_conn = connect_to_database();

  $noft_status = "read";

  $stmt = $db_conn->prepare("UPDATE `notification` SET `noft_status` = ? WHERE `account_id` = ?");
  $stmt->bind_param("ss", $noft_status,  $data["account_id"]);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $response = array("success" => false, "message" => "error occurred or it have been marked read already");
    echo json_encode($response);
    return false;
  }

  return true;
}

function compose_notification($data)
{

  $db_conn = connect_to_database();

  if ($data['noft_category'] !== '' && $data['noft_msg'] !== '') {

    $noft_id = bin2hex(random_bytes(20));
    $account_id = $data["account_id"];
    $noft_category = $data['noft_category'];
    $noft_msg = $data['noft_msg'];
    $noft_status = 'Active';

    $stmt = $db_conn->prepare("INSERT INTO `notification` (`noft_id`,`account_id`,`noft_category`,`noft_msg`,`noft_status`) VALUE (?,?,?,?,?)");
    $stmt->bind_param("sssss", $noft_id, $account_id, $noft_category, $noft_msg, $noft_status);
    $stmt->execute();

    if ($stmt->affected_rows <= 0) {
      $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
      return false;
    }
    $_SESSION["feedback"] = "Notification sent successfully";
  } else {
    $_SESSION["feedback"] = "Please Fill in the provided fields and try again.";
    return false;
  }
}

function purchase_card($data)
{
  $db_conn = connect_to_database();

  if (strlen($data["pin"]) !== 4) {
    $_SESSION["feedback"] = "Card Pin must be 4 digits";
    return false;
  }

  $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("s", $data["account_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "Unable to find the specified account. Please try again later.";
    return false;
  }

  $row = $result->fetch_assoc();
  $datasource = json_decode($row['datasource'], true);

  $purchase_id = bin2hex(random_bytes(32));
  $full_names = $data['full_names'];
  $account_id = $data['account_id'];
  $pin = $data['pin'];
  $delivery_address = $data['delivery_address'];
  $purchase_method = $data['purchase_method'];
  $purchase_address = $data['purchase_address'];
  $purchase_cost = $data['purchase_cost'];
  $purchase_progress = 10;
  $purchase_status = "Pending";
  $created_at = date("Y-M-d h:i a");

  $stmt = $db_conn->prepare("INSERT INTO `card_purchase` (`account_id`,`purchase_id`,`full_names`,`pin`,`delivery_address`,`purchase_method`,`purchase_address`,`purchase_cost`,`purchase_progress`,`purchase_status`,`created_at`) VALUE (?,?,?,?,?,?,?,?,?,?,?)");
  $stmt->bind_param("sssisssiiss", $account_id, $purchase_id, $full_names, $pin, $delivery_address, $purchase_method, $purchase_address, $purchase_cost, $purchase_progress, $purchase_status, $created_at);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }
  $_SESSION["feedback"] = "Your Card Purchase request has been submitted successfully";

  if ($_SESSION["feedback"]) {

    $noft_id = bin2hex(random_bytes(20));
    $account_id = $data["account_id"];
    $noft_category = 'CARD PURCHASE REQUEST NOTIFICATION';
    $noft_msg = 'Hello ' . $data['full_names'] . ', Your Card Purchase request has been submitted successfully. Track Your card process through your purchase progress bar';
    $noft_status = 'Active';

    $stmt = $db_conn->prepare("INSERT INTO `notification` (`noft_id`,`account_id`,`noft_category`,`noft_msg`,`noft_status`) VALUE (?,?,?,?,?)");
    $stmt->bind_param("sssss", $noft_id, $account_id, $noft_category, $noft_msg, $noft_status);
    $stmt->execute();
  }

  if ($_SESSION["feedback"]) {

    // mail function
    $message = '';
    $fname = $datasource['full_names'];
    $email = $datasource['email_address'];

    // Send mail to user with verification here
    $to = $email;
    $subject = "CARD PURCHASE REQUEST NOTIFICATION";

    // Create the body message
    $message .= '<!DOCTYPE html>
                <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
                <head>
                  <meta charset="UTF-8">
                  <meta name="viewport" content="width=device-width,initial-scale=1">
                  <meta name="x-apple-disable-message-reformatting">
                  <title></title>
                  <!--[if mso]>
                  <noscript>
                    <xml>
                      <o:OfficeDocumentSettings>
                        <o:PixelsPerInch>96</o:PixelsPerInch>
                      </o:OfficeDocumentSettings>
                    </xml>
                  </noscript>
                  <![endif]-->
                  <style>
                    table, td, div, h1, p {font-family: Arial, sans-serif;}
                    button{
                        font: inherit;
                        background-color: #FF7A59;
                        border: none;
                        padding: 10px;
                        text-transform: uppercase;
                        letter-spacing: 2px;
                        font-weight: 700; 
                        color: white;
                        border-radius: 5px; 
                        box-shadow: 1px 2px #d94c53;
                      }
                  </style>
                </head>
                <body style="margin:0;padding:0;">
                  <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                    <tr>
                      <td align="center" style="padding:0;">
                        <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                          <tr>
                                <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                                    <h1 style="margin:24px">Swiftpipstraders</h1> 
                                </td>
                          </tr>
                          <tr style="background-color: #eeeeee;">
                            <td style="padding:36px 30px 42px 30px;">
                              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                <tr>
                                  <td style="padding:0 0 36px 0;color:#153643;">
                                    <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Dear ' . $fname . ' , </h1>
                                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                      Your Card Purchase request has been submitted successfully. Track Your card process through your purchase progress bar.
                                    </p>
                                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                      Our Support team will keep you updated on your progress.
                                    </p>
                                    <br>
                                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                    <br>
                                    <i><b>Thanks for choosing us</b></i> 
                                    </p>
                                    <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        <a href="https://Swiftpipstraders.online/account" style="color:#ee4c50;text-decoration:underline;"> 
                                            <button> 
                                                Click to Login
                                            </button>  
                                        </a>
                                    </p>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                          <tr>
                            <td style="padding:30px;background:#ee4c50;">
                              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                                <tr>
                                  <td style="padding:0;width:50%;" align="left">
                                    <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                      &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                                    </p>
                                  </td>
                                  <td style="padding:0;width:50%;" align="right">
                                    <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                                      <tr>
                                        <td style="padding:0 0 0 10px;width:38px;">
                                          <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                        </td>
                                        <td style="padding:0 0 0 10px;width:38px;">
                                          <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </body>
                </html>';
    $header = "From:Swiftpipstraders <no-reply@swiftpipstraders.online> \r\n";
    $header .= "Cc:no-reply@swiftpipstraders.online \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);
  }
  if ($_SESSION["feedback"]) {

    // Create the body message
    $message = '';
    $Clientfname = $datasource['full_names'];
    $adminEmail = ADMIN_EMAIL;

    // Send mail to user with verification here
    $to = $adminEmail;
    $subject = "CARD ORDER NOTIFICATION";

    $message .= '<!DOCTYPE html>
        <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width,initial-scale=1">
          <meta name="x-apple-disable-message-reformatting">
          <title></title>
          <!--[if mso]>
          <noscript>
            <xml>
              <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
              </o:OfficeDocumentSettings>
            </xml>
          </noscript>
          <![endif]-->
          <style>
            table, td, div, h1, p {font-family: Arial, sans-serif;}
            button{
                font: inherit;
                background-color: #FF7A59;
                border: none;
                padding: 10px;
                text-transform: uppercase;
                letter-spacing: 2px;
                font-weight: 700; 
                color: white;
                border-radius: 5px; 
                box-shadow: 1px 2px #d94c53;
              }
          </style>
        </head>
        <body style="margin:0;padding:0;">
          <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
            <tr>
              <td align="center" style="padding:0;">
                <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                  <tr>
                        <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                            <h1 style="margin:24px">Swiftpipstraders</h1> 
                        </td>
                  </tr>
                  <tr style="background-color: #eeeeee;">
                    <td style="padding:36px 30px 42px 30px;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                        <tr>
                          <td style="padding:0 0 36px 0;color:#153643;">
                            <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Hello Admin , </h1>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                              A client by the name ' . $Clientfname . ' Have requested for a card.
                    
                            </p>
                            <br>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                           Welcome aboard! We are thrilled to have you as part of our Swiftpipstraders community.
                           <br>
                           We are here to make your trading experience enjoyable and seamless.
                              
                            </p>
                            <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                <a href="mailto:no-reply@swiftpipstraders.online" style="color:#ee4c50;text-decoration:underline;"> 
                                    <button> 
                                        Click to mail support
                                    </button>  
                                </a>
                            </p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding:30px;background:#ee4c50;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                        <tr>
                          <td style="padding:0;width:50%;" align="left">
                            <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                              &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                            </p>
                          </td>
                          <td style="padding:0;width:50%;" align="right">
                            <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                              <tr>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </body>
        </html>';
    $header = "From:" . SITE_NAME . " <" . ADMIN_EMAIL . "> \r\n";
    $header .= "Cc:" . ADMIN_EMAIL . " \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);
  }
  return true;
}

function approve_card($data)
{

  $db_conn = connect_to_database();


  $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("s", $data["account_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "Unable to find the specified account. Please try again later.";
    return false;
  }

  $row = $result->fetch_assoc();
  $datasource = json_decode($row['datasource'], true);

  $purchase_status = 'Approved';

  $stmt = $db_conn->prepare("UPDATE `card_purchase` SET `purchase_status` = ? WHERE account_id = ? AND purchase_id = ?");
  $stmt->bind_param("sss", $purchase_status, $data["account_id"], $data["purchase_id"]);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }

  $_SESSION["feedback"] = "Card Purchase Approved successfully. You can now increase client's progress bar when Needed";

  if ($_SESSION["feedback"]) {

    $noft_id = bin2hex(random_bytes(20));
    $account_id = $data["account_id"];
    $noft_category = 'CARD PURCHASE REQUEST APPROVED';
    $noft_msg = 'Hello ' . $data['full_names'] . ', Your Card Purchase request has been Approved successfully. Track Your card process through your purchase progress bar';
    $noft_status = 'Active';

    $stmt = $db_conn->prepare("INSERT INTO `notification` (`noft_id`,`account_id`,`noft_category`,`noft_msg`,`noft_status`) VALUE (?,?,?,?,?)");
    $stmt->bind_param("sssss", $noft_id, $account_id, $noft_category, $noft_msg, $noft_status);
    $stmt->execute();
  }

  if ($_SESSION["feedback"]) {

    // mail function
    $message = '';
    $fname = $datasource['full_names'];
    $email = $datasource['email_address'];

    // Send mail to user with verification here
    $to = $email;
    $subject = "CARD PURCHASE REQUEST APPROVED ";

    // Create the body message
    $message .= '<!DOCTYPE html>
                  <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
                  <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width,initial-scale=1">
                    <meta name="x-apple-disable-message-reformatting">
                    <title></title>
                    <!--[if mso]>
                    <noscript>
                      <xml>
                        <o:OfficeDocumentSettings>
                          <o:PixelsPerInch>96</o:PixelsPerInch>
                        </o:OfficeDocumentSettings>
                      </xml>
                    </noscript>
                    <![endif]-->
                    <style>
                      table, td, div, h1, p {font-family: Arial, sans-serif;}
                      button{
                          font: inherit;
                          background-color: #FF7A59;
                          border: none;
                          padding: 10px;
                          text-transform: uppercase;
                          letter-spacing: 2px;
                          font-weight: 700; 
                          color: white;
                          border-radius: 5px; 
                          box-shadow: 1px 2px #d94c53;
                        }
                    </style>
                  </head>
                  <body style="margin:0;padding:0;">
                    <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                      <tr>
                        <td align="center" style="padding:0;">
                          <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                            <tr>
                                  <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                                      <h1 style="margin:24px">Swiftpipstraders</h1> 
                                  </td>
                            </tr>
                            <tr style="background-color: #eeeeee;">
                              <td style="padding:36px 30px 42px 30px;">
                                <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                  <tr>
                                    <td style="padding:0 0 36px 0;color:#153643;">
                                      <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Dear ' . $fname . ' , </h1>
                                      <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                      Your Card Purchase request has been Approved successfully. Track Your card process through your purchase progress bar.
                                      </p>
                                      <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        Our Support team will keep you updated on your progress.
                                      </p>
                                      <br>
                                      <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                      <br>
                                      <i><b>Thanks for choosing us</b></i> 
                                      </p>
                                      <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                          <a href="https://Swiftpipstraders.online/account" style="color:#ee4c50;text-decoration:underline;"> 
                                              <button> 
                                                  Click to Login
                                              </button>  
                                          </a>
                                      </p>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                            <tr>
                              <td style="padding:30px;background:#ee4c50;">
                                <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                                  <tr>
                                    <td style="padding:0;width:50%;" align="left">
                                      <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                                      </p>
                                    </td>
                                    <td style="padding:0;width:50%;" align="right">
                                      <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                                        <tr>
                                          <td style="padding:0 0 0 10px;width:38px;">
                                            <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                          </td>
                                          <td style="padding:0 0 0 10px;width:38px;">
                                            <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                          </td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </body>
                  </html>';
    $header = "From:Swiftpipstraders <no-reply@swiftpipstraders.online> \r\n";
    $header .= "Cc:no-reply@swiftpipstraders.online \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);
  }

  if ($_SESSION["feedback"]) {

    // Create the body message
    $message = '';
    $Clientfname = $datasource['full_names'];
    $adminEmail = ADMIN_EMAIL;

    // Send mail to user with verification here
    $to = $adminEmail;
    $subject = "CARD ORDER NOTIFICATION";

    $message .= '<!DOCTYPE html>
        <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width,initial-scale=1">
          <meta name="x-apple-disable-message-reformatting">
          <title></title>
          <!--[if mso]>
          <noscript>
            <xml>
              <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
              </o:OfficeDocumentSettings>
            </xml>
          </noscript>
          <![endif]-->
          <style>
            table, td, div, h1, p {font-family: Arial, sans-serif;}
            button{
                font: inherit;
                background-color: #FF7A59;
                border: none;
                padding: 10px;
                text-transform: uppercase;
                letter-spacing: 2px;
                font-weight: 700; 
                color: white;
                border-radius: 5px; 
                box-shadow: 1px 2px #d94c53;
              }
          </style>
        </head>
        <body style="margin:0;padding:0;">
          <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
            <tr>
              <td align="center" style="padding:0;">
                <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                  <tr>
                        <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                            <h1 style="margin:24px">Swiftpipstraders</h1> 
                        </td>
                  </tr>
                  <tr style="background-color: #eeeeee;">
                    <td style="padding:36px 30px 42px 30px;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                        <tr>
                          <td style="padding:0 0 36px 0;color:#153643;">
                            <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Hello Admin , </h1>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                              The card order from ' . $Clientfname . ' have been approved by you.
                    
                            </p>
                            <br>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                           Welcome aboard! We are thrilled to have you as part of our Swiftpipstraders community.
                           <br>
                           We are here to make your trading experience enjoyable and seamless.
                              
                            </p>
                            <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                <a href="mailto:no-reply@swiftpipstraders.online" style="color:#ee4c50;text-decoration:underline;"> 
                                    <button> 
                                        Click to mail support
                                    </button>  
                                </a>
                            </p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding:30px;background:#ee4c50;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                        <tr>
                          <td style="padding:0;width:50%;" align="left">
                            <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                              &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                            </p>
                          </td>
                          <td style="padding:0;width:50%;" align="right">
                            <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                              <tr>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </body>
        </html>';
    $header = "From:" . SITE_NAME . " <" . ADMIN_EMAIL . "> \r\n";
    $header .= "Cc:" . ADMIN_EMAIL . " \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);
  }
  return true;
}
function cancel_card($data)
{

  $db_conn = connect_to_database();


  $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("s", $data["account_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "Unable to find the specified account. Please try again later.";
    return false;
  }

  $row = $result->fetch_assoc();
  $datasource = json_decode($row['datasource'], true);


  $purchase_status = 'Cancelled';

  $stmt = $db_conn->prepare("UPDATE `card_purchase` SET `purchase_status` = ? WHERE account_id = ? AND purchase_id = ?");
  $stmt->bind_param("sss", $purchase_status, $data["account_id"], $data["purchase_id"]);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }

  $_SESSION["feedback"] = "Card Purchase Cancelled successfully. Your client have received notification on the information.";

  if ($_SESSION["feedback"]) {

    $noft_id = bin2hex(random_bytes(20));
    $account_id = $data["account_id"];
    $noft_category = 'CARD PURCHASE REQUEST CANCELLED';
    $noft_msg = 'Hello ' . $data['full_names'] . ', Your Card Purchase request has been Cancelled.Please contact support to rectify your issues so you can enjoy your trading experience with us.';
    $noft_status = 'Active';

    $stmt = $db_conn->prepare("INSERT INTO `notification` (`noft_id`,`account_id`,`noft_category`,`noft_msg`,`noft_status`) VALUE (?,?,?,?,?)");
    $stmt->bind_param("sssss", $noft_id, $account_id, $noft_category, $noft_msg, $noft_status);
    $stmt->execute();
  }

  if ($_SESSION["feedback"]) {

    // mail function
    $message = '';
    $fname = $datasource['full_names'];
    $email = $datasource['email_address'];

    // Send mail to user with verification here
    $to = $email;
    $subject = "CARD PURCHASE REQUEST CANCELLED ";

    // Create the body message
    $message .= '<!DOCTYPE html>
                  <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
                  <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width,initial-scale=1">
                    <meta name="x-apple-disable-message-reformatting">
                    <title></title>
                    <!--[if mso]>
                    <noscript>
                      <xml>
                        <o:OfficeDocumentSettings>
                          <o:PixelsPerInch>96</o:PixelsPerInch>
                        </o:OfficeDocumentSettings>
                      </xml>
                    </noscript>
                    <![endif]-->
                    <style>
                      table, td, div, h1, p {font-family: Arial, sans-serif;}
                      button{
                          font: inherit;
                          background-color: #FF7A59;
                          border: none;
                          padding: 10px;
                          text-transform: uppercase;
                          letter-spacing: 2px;
                          font-weight: 700; 
                          color: white;
                          border-radius: 5px; 
                          box-shadow: 1px 2px #d94c53;
                        }
                    </style>
                  </head>
                  <body style="margin:0;padding:0;">
                    <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                      <tr>
                        <td align="center" style="padding:0;">
                          <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                            <tr>
                                  <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                                      <h1 style="margin:24px">Swiftpipstraders</h1> 
                                  </td>
                            </tr>
                            <tr style="background-color: #eeeeee;">
                              <td style="padding:36px 30px 42px 30px;">
                                <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                  <tr>
                                    <td style="padding:0 0 36px 0;color:#153643;">
                                      <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Dear ' . $fname . ' , </h1>
                                      <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                      Your Card Purchase request has been Cancelled .Please contact support to rectify your issues so you can enjoy your trading experience with us.
                                      </p>
                                      <br>
                                      <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                      <br>
                                      <i><b>Thanks for choosing us</b></i> 
                                      </p>
                                      <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                          <a href="https://Swiftpipstraders.online/account" style="color:#ee4c50;text-decoration:underline;"> 
                                              <button> 
                                                  Click to Login
                                              </button>  
                                          </a>
                                      </p>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                            <tr>
                              <td style="padding:30px;background:#ee4c50;">
                                <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                                  <tr>
                                    <td style="padding:0;width:50%;" align="left">
                                      <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                                      </p>
                                    </td>
                                    <td style="padding:0;width:50%;" align="right">
                                      <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                                        <tr>
                                          <td style="padding:0 0 0 10px;width:38px;">
                                            <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                          </td>
                                          <td style="padding:0 0 0 10px;width:38px;">
                                            <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                          </td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </body>
                  </html>';
    $header = "From:Swiftpipstraders <no-reply@swiftpipstraders.online> \r\n";
    $header .= "Cc:no-reply@swiftpipstraders.online \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);
  }

  if ($_SESSION["feedback"]) {

    // Create the body message
    $message = '';
    $Clientfname = $datasource['full_names'];
    $adminEmail = ADMIN_EMAIL;

    // Send mail to user with verification here
    $to = $adminEmail;
    $subject = "CARD ORDER NOTIFICATION";

    $message .= '<!DOCTYPE html>
        <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width,initial-scale=1">
          <meta name="x-apple-disable-message-reformatting">
          <title></title>
          <!--[if mso]>
          <noscript>
            <xml>
              <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
              </o:OfficeDocumentSettings>
            </xml>
          </noscript>
          <![endif]-->
          <style>
            table, td, div, h1, p {font-family: Arial, sans-serif;}
            button{
                font: inherit;
                background-color: #FF7A59;
                border: none;
                padding: 10px;
                text-transform: uppercase;
                letter-spacing: 2px;
                font-weight: 700; 
                color: white;
                border-radius: 5px; 
                box-shadow: 1px 2px #d94c53;
              }
          </style>
        </head>
        <body style="margin:0;padding:0;">
          <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
            <tr>
              <td align="center" style="padding:0;">
                <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                  <tr>
                        <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                            <h1 style="margin:24px">Swiftpipstraders</h1> 
                        </td>
                  </tr>
                  <tr style="background-color: #eeeeee;">
                    <td style="padding:36px 30px 42px 30px;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                        <tr>
                          <td style="padding:0 0 36px 0;color:#153643;">
                            <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Hello Admin , </h1>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                              The card order from ' . $Clientfname . ' have been canceled by you.
                    
                            </p>
                            <br>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                           Welcome aboard! We are thrilled to have you as part of our Swiftpipstraders community.
                           <br>
                           We are here to make your trading experience enjoyable and seamless.
                              
                            </p>
                            <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                <a href="mailto:no-reply@swiftpipstraders.online" style="color:#ee4c50;text-decoration:underline;"> 
                                    <button> 
                                        Click to mail support
                                    </button>  
                                </a>
                            </p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding:30px;background:#ee4c50;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                        <tr>
                          <td style="padding:0;width:50%;" align="left">
                            <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                              &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                            </p>
                          </td>
                          <td style="padding:0;width:50%;" align="right">
                            <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                              <tr>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </body>
        </html>';
    $header = "From:" . SITE_NAME . " <" . ADMIN_EMAIL . "> \r\n";
    $header .= "Cc:" . ADMIN_EMAIL . " \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);
  }
  return true;
}

function purchase_progress_update($data)
{
  $db_conn = connect_to_database();


  $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
  $stmt->bind_param("s", $data["account_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows <= 0) {
    $_SESSION["feedback"] = "Unable to find the specified account. Please try again later.";
    return false;
  }

  $row = $result->fetch_assoc();
  $datasource = json_decode($row['datasource'], true);


  $purchase_progress = $data['purchase_progress'];

  $stmt = $db_conn->prepare("UPDATE `card_purchase` SET `purchase_progress` = ? WHERE account_id = ? AND purchase_id = ?");
  $stmt->bind_param("iss", $purchase_progress, $data["account_id"], $data["purchase_id"]);
  $stmt->execute();

  if ($stmt->affected_rows <= 0) {
    $_SESSION["feedback"] = "We're currently unable to process your request. Please try again later.";
    return false;
  }

  $_SESSION["feedback"] = "Card Purchase progress added successfully";

  if ($_SESSION["feedback"]) {

    $noft_id = bin2hex(random_bytes(20));
    $account_id = $data["account_id"];
    $noft_category = 'CARD PURCHASE PROGRESS UPDATE';
    $noft_msg = 'Hello ' . $data['full_names'] . ', Hurray!!! Your Card Purchase progress has been updated. Your card is ' . $data['purchase_progress'] . ' ready ';
    $noft_status = 'Active';

    $stmt = $db_conn->prepare("INSERT INTO `notification` (`noft_id`,`account_id`,`noft_category`,`noft_msg`,`noft_status`) VALUE (?,?,?,?,?)");
    $stmt->bind_param("sssss", $noft_id, $account_id, $noft_category, $noft_msg, $noft_status);
    $stmt->execute();
  }

  if ($_SESSION["feedback"]) {

    // mail function
    $message = '';
    $fname = $datasource['full_names'];
    $email = $datasource['email_address'];

    // Send mail to user with verification here
    $to = $email;
    $subject = "CARD PURCHASE REQUEST APPROVED ";

    // Create the body message
    $message .= '<!DOCTYPE html>
                  <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
                  <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width,initial-scale=1">
                    <meta name="x-apple-disable-message-reformatting">
                    <title></title>
                    <!--[if mso]>
                    <noscript>
                      <xml>
                        <o:OfficeDocumentSettings>
                          <o:PixelsPerInch>96</o:PixelsPerInch>
                        </o:OfficeDocumentSettings>
                      </xml>
                    </noscript>
                    <![endif]-->
                    <style>
                      table, td, div, h1, p {font-family: Arial, sans-serif;}
                      button{
                          font: inherit;
                          background-color: #FF7A59;
                          border: none;
                          padding: 10px;
                          text-transform: uppercase;
                          letter-spacing: 2px;
                          font-weight: 700; 
                          color: white;
                          border-radius: 5px; 
                          box-shadow: 1px 2px #d94c53;
                        }
                    </style>
                  </head>
                  <body style="margin:0;padding:0;">
                    <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                      <tr>
                        <td align="center" style="padding:0;">
                          <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                            <tr>
                                  <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                                      <h1 style="margin:24px">Swiftpipstraders</h1> 
                                  </td>
                            </tr>
                            <tr style="background-color: #eeeeee;">
                              <td style="padding:36px 30px 42px 30px;">
                                <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                  <tr>
                                    <td style="padding:0 0 36px 0;color:#153643;">
                                      <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Dear ' . $fname . ' , </h1>
                                      <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        Your Card Purchase progress has been updated. Your card is ' . $data['purchase_progress'] . '% ready.
                                      </p>
                                      <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        Our Support team will keep you updated on your progress.
                                      </p>
                                      <br>
                                      <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                      <br>
                                      <i><b>Thanks for choosing us</b></i> 
                                      </p>
                                      <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                          <a href="https://Swiftpipstraders.online/account" style="color:#ee4c50;text-decoration:underline;"> 
                                              <button> 
                                                  Click to Login
                                              </button>  
                                          </a>
                                      </p>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                            <tr>
                              <td style="padding:30px;background:#ee4c50;">
                                <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                                  <tr>
                                    <td style="padding:0;width:50%;" align="left">
                                      <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                                      </p>
                                    </td>
                                    <td style="padding:0;width:50%;" align="right">
                                      <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                                        <tr>
                                          <td style="padding:0 0 0 10px;width:38px;">
                                            <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                          </td>
                                          <td style="padding:0 0 0 10px;width:38px;">
                                            <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                          </td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </body>
                  </html>';
    $header = "From:Swiftpipstraders <no-reply@swiftpipstraders.online> \r\n";
    $header .= "Cc:no-reply@swiftpipstraders.online \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);
  }
  if ($_SESSION["feedback"]) {

    // Create the body message
    $message = '';
    $Clientfname = $datasource['full_names'];
    $adminEmail = ADMIN_EMAIL;

    // Send mail to user with verification here
    $to = $adminEmail;
    $subject = "CARD ORDER NOTIFICATION";

    $message .= '<!DOCTYPE html>
        <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width,initial-scale=1">
          <meta name="x-apple-disable-message-reformatting">
          <title></title>
          <!--[if mso]>
          <noscript>
            <xml>
              <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
              </o:OfficeDocumentSettings>
            </xml>
          </noscript>
          <![endif]-->
          <style>
            table, td, div, h1, p {font-family: Arial, sans-serif;}
            button{
                font: inherit;
                background-color: #FF7A59;
                border: none;
                padding: 10px;
                text-transform: uppercase;
                letter-spacing: 2px;
                font-weight: 700; 
                color: white;
                border-radius: 5px; 
                box-shadow: 1px 2px #d94c53;
              }
          </style>
        </head>
        <body style="margin:0;padding:0;">
          <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
            <tr>
              <td align="center" style="padding:0;">
                <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                  <tr>
                        <td align="center" style="padding:20px 0 20px 0;background:#70bbd9; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;font-size: 20px;margin: 10px;">
                            <h1 style="margin:24px">Swiftpipstraders</h1> 
                        </td>
                  </tr>
                  <tr style="background-color: #eeeeee;">
                    <td style="padding:36px 30px 42px 30px;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                        <tr>
                          <td style="padding:0 0 36px 0;color:#153643;">
                            <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Hello Admin , </h1>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                              The card order progress from ' . $Clientfname . ' have been updated to ' . $data['purchase_progress'] . '% by you .
                    
                            </p>
                            <br>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                           Welcome aboard! We are thrilled to have you as part of our Swiftpipstraders community.
                           <br>
                           We are here to make your trading experience enjoyable and seamless.
                              
                            </p>
                            <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                <a href="mailto:no-reply@swiftpipstraders.online" style="color:#ee4c50;text-decoration:underline;"> 
                                    <button> 
                                        Click to mail support
                                    </button>  
                                </a>
                            </p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding:30px;background:#ee4c50;">
                      <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                        <tr>
                          <td style="padding:0;width:50%;" align="left">
                            <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                              &reg; 2024 copyright Swiftpipstraders<br/><a href="https://Swiftpipstraders.online" style="color:#ffffff;text-decoration:underline;">visit site</a>
                            </p>
                          </td>
                          <td style="padding:0;width:50%;" align="right">
                            <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                              <tr>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                                <td style="padding:0 0 0 10px;width:38px;">
                                  <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </body>
        </html>';
    $header = "From:" . SITE_NAME . " <" . ADMIN_EMAIL . "> \r\n";
    $header .= "Cc:" . ADMIN_EMAIL . " \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    @$retval = mail($to, $subject, $message, $header);
  }
  return true;
}
