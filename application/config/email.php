<?php 

$config = array(
    'protocol'  => 'smtp',
    'smtp_host' => 'smtp.example.com',
    'smtp_user' => 'your_email@example.com',
    'smtp_pass' => 'your_password',
    'smtp_port' => 587,  // You can use 465 for SSL, or 587 for TLS
    'mailtype'  => 'html', 
    'charset'   => 'utf-8',
    'newline'   => "\r\n"
);

$this->email->initialize($config);
