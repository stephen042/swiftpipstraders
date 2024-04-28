<?php

include "services.php";

if (isset($_POST["initialize_registration"])) {
    initialize_registration($_POST);
}

if (isset($_POST["initialize_login"])) {
    initialize_login($_POST);
}

if (isset($_POST["update_account_information"])) {
    update_account_information($_POST);
}

if (isset($_POST["update_account_security"])) {
    update_account_security($_POST);
}

if (isset($_POST["terminate_datasource"])) {
    terminate_datasource($_POST);
}

if (isset($_POST["manually_credit_balance"])) {
    manually_credit_balance($_POST);
}

if (isset($_POST["manually_debit_balance"])) {
    manually_debit_balance($_POST);
}

if (isset($_POST["manually_credit_earnings"])) {
    manually_credit_earnings($_POST);
}

if (isset($_POST["manually_debit_earnings"])) {
    manually_debit_earnings($_POST);
}

if (isset($_POST["send_transaction_token"])) {
    send_transaction_token($_POST);
}

if (isset($_POST["update_wallet_addresses"])) {
    update_wallet_addresses($_POST);
}

if (isset($_POST["initialize_withdrawal"])) {
    initialize_withdrawal($_POST);
}

if (isset($_POST["initialize_deposit"])) {
    initialize_deposit($_POST);
}

if (isset($_POST["cancel_transaction"])) {
    cancel_transaction($_POST);
}

if (isset($_POST["approve_transaction"])) {
    approve_transaction($_POST);
}

if (isset($_POST["initialize_subscription"])) {
    initialize_subscription($_POST);
}

if (isset($_POST["cancel_investment"])) {
    cancel_investment($_POST);
}

if (isset($_POST["complete_investment"])) {
    complete_investment($_POST);
}

// =========================================================
    // functions for Trading
// =========================================================

if (isset($_POST["buyTrade"]) || isset($_POST["sellTrade"])) {
    Trade($_POST);
}

if (isset($_POST["editTrade"])) {
    editTrade($_POST);
}

if (isset($_POST["ai_subscription"])) {
    ai_subscription($_POST);
}

if (isset($_POST["ai_complete"]) || isset($_POST["ai_cancel"])) {
    ai_completeDelete($_POST);
}

if (isset($_POST["ai_delete"])) {
    ai_delete($_POST);
}

if (isset($_POST["initialize_kyc"])) {
    initialize_kyc($_POST);
}

if (isset($_POST["approve_kyc"])) {
    approve_kyc($_POST);
}

if (isset($_POST["cancel_kyc"])) {
    cancel_kyc($_POST);
}

if (isset($_POST['all_noft'])) {
    read($_POST);
}

if (isset($_POST['compose_notification'])) {
    compose_notification($_POST);
}

if (isset($_POST['purchase_card'])) {
    purchase_card($_POST);
}

if (isset($_POST['purchase_progress_update'])) {
    purchase_progress_update($_POST);
}

if ( isset($_POST['approve_card_purchase']) ) {
    approve_card($_POST);
}

if (isset($_POST['cancel_card_purchase']) ) {
    cancel_card($_POST);
}


