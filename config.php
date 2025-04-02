<?php

define('APP_NAME',              'MerceariaOnline');
define('APP_VERSION',           '1.0.0');

//URLS Base

define('BASE_URL_CLIENTE',      'http://localhost/projetos/merceariafinal/public/');
define('BASE_URL_ADMIN',        'http://localhost/projetos/merceariafinal/public/admin/');

//MySQL

define('MYSQL_SERVER',          'localhost'); //alterar antes de enviar trabalho para 'localhost'
define('MYSQL_DATABASE',        'mercearia');
define('MYSQL_USER',            'root');
define('MYSQL_PASS',            '');
define('MYSQL_CHARSET',         'utf8');

//Encriptação

define('AES_KEY',               'qASmD3OXP3vVg4NInmF8Ej5PdJKwrR7L');
define('AES_IV',                '05wdVqKI16aGcTRu');


//Email

define('EMAIL_HOST',            'smtp.gmail.com');
define('EMAIL_FROM',            'grocery_email');
define('EMAIL_PASS',            'Your_app_password');
define('EMAIL_PORT',            587);

// Estados encomendas

define('STATUS',                ['PENDENTE', 'EM PROCESSAMENTO', 'ENVIADA', 'CANCELADA', 'ENTREGUE']);


// pasta pdfs

define('PDF_PATH',              '/Applications/XAMPP/xamppfiles/htdocs/projetos/merceariafinal/pdfs/');
