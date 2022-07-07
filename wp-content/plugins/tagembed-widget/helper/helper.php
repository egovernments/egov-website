<?php
function __tagembed__wpApiCall($apiUrl, $body, $header = NULL, $breakResponse = false) {
    $header = (($header != NULL) ? $header : []);
    $args = ['body' => $body, 'timeout' => '5', 'redirection' => '5', 'httpversion' => '1.0', 'blocking' => true, 'headers' => $header, 'cookies' => []];
    $response = wp_remote_post($apiUrl, $args);
    if ($breakResponse)
        __tagembed__dd($response);
    if (!empty($response['body']))
        return json_decode($response['body']);
    return;
}
function __tagembed__manageApiResponse($response) {
    if (empty($response->head))
        return __tagembed__exitWithDanger();
    $responseCode = $response->head->code;
    switch ($responseCode) {
        case 200:
            if ($response->head->status):
                if (!empty($response->body))
                    return $response->body;
                if (!empty($response->head->message))
                    return __tagembed__exitWithSuccess($response->head->message);
                return __tagembed__exitWithSuccess();
            else :
                if (!empty($response->head->message))
                    return __tagembed__exitWithDanger($response->head->message);
                return __tagembed__exitWithDanger();
            endif;
            break;
        case 412:
            /* --Start-- Manage Validation Error */
            if (empty($response->body))
                return __tagembed__exitWithDanger();
            return __tagembed__exitWithDanger("Validation Error", $response->body);
            /* --End-- Manage Validation Error */
            break;
        default:
            if (!empty($response->head->message)):
                return __tagembed__exitWithDanger($response->head->message);
            else:
                return __tagembed__exitWithDanger();
        endif;
    }
}
function __tagembed__IsBase64($data) {
    $decoded_data = base64_decode($data, true);
    $encoded_data = base64_encode($decoded_data);
    if ($encoded_data != $data)
        return false;
    else if (!ctype_print($decoded_data))
        return false;
    return true;
}
function __tagembed__exitWithSuccess($data = null) {
    echo json_encode(['status' => (bool) true, 'data' => (array) $data, 'message' => (string) 'OK']);
    exit;
}
function __tagembed__exitWithDanger($error = null, $data = []) {
    echo json_encode(['status' => (bool) false, 'data' => (array) $data, 'message' => (string) (($error != '') ? $error : 'Oh snap! Something went wrong.')]);
    exit;
}
function __tagembed__d($data = 'NONE') {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}
function __tagembed__dd($data = 'NONE') {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    die;
}
function __tagembed__convertObjectToArray($data) {
    $data = json_encode($data);
    return json_decode($data, true);
}
/* --Start__ Sanetize All Input */
function inputSanetize($data) {
    $data = (string) $data;
    /* if (preg_match("/[\[^£$^*()}{@~><>;@\\\\`\]]/", $data)) */
    if (preg_match("/<>/", $data))
        __tagembed__exitWithDanger("Special characters  are not allowed. Please remove them and try again.");
}
/* --End Sanetize All Input */
