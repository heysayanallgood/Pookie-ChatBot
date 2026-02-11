<?php
/**
 * Encryption Helper for Chat Messages
 * Uses AES-256-CBC encryption
 */

// Define your encryption key - IMPORTANT: Store this securely!
// For production, store in environment variables or secure config file
define('ENCRYPTION_KEY', '569997664da5e07597a0b3ddcd1c0857'); // Must be 32 characters
define('ENCRYPTION_METHOD', 'AES-256-CBC');

/**
 * Encrypt a message
 * @param string $message The plain text message to encrypt
 * @return string The encrypted message (base64 encoded)
 */
function encryptMessage($message) {
    $key = substr(hash('sha256', ENCRYPTION_KEY), 0, 32);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(ENCRYPTION_METHOD));
    
    $encrypted = openssl_encrypt($message, ENCRYPTION_METHOD, $key, 0, $iv);
    
    // Combine IV and encrypted data
    return base64_encode($iv . $encrypted);
}

/**
 * Decrypt a message
 * @param string $encryptedMessage The encrypted message (base64 encoded)
 * @return string The decrypted plain text message
 */
function decryptMessage($encryptedMessage) {
    $key = substr(hash('sha256', ENCRYPTION_KEY), 0, 32);
    $data = base64_decode($encryptedMessage);
    
    $ivLength = openssl_cipher_iv_length(ENCRYPTION_METHOD);
    $iv = substr($data, 0, $ivLength);
    $encrypted = substr($data, $ivLength);
    
    $decrypted = openssl_decrypt($encrypted, ENCRYPTION_METHOD, $key, 0, $iv);
    
    return $decrypted ? $decrypted : '';
}
?>
