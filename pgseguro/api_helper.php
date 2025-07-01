<?php

include('../includes/conexao.php');
/**
 * Envia uma requisição para a API do PagSeguro.
 *
 * @param array $data O corpo da requisição.
 * @return array A resposta da API decodificada.
 */
function callPagSeguroAPI(array $data) {
    $url = PAGSEGURO_URL . '/orders';
    
    $headers = [
        'Content-Type: application/json',
        'Authorization: ' . PAGSEGURO_TOKEN,
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);


    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_errno($ch)) {
        // Se houver um erro no cURL
        $error_msg = curl_error($ch);
        curl_close($ch);
        return ['error' => true, 'message' => "Erro na chamada cURL: " . $error_msg, 'http_code' => $http_code];
    }
    
    curl_close($ch);
    
    $responseData = json_decode($response, true);
    
    // Inclui o código HTTP na resposta para facilitar a depuração
    if (is_array($responseData)) {
        $responseData['http_code'] = $http_code;
    }

    return $responseData;
}



?>