<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['dsn']      The full DSN string describe a connection to the database.
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database driver. e.g.: mysqli.
|			Currently supported:
|				 cubrid, ibase, mssql, mysql, mysqli, oci8,
|				 odbc, pdo, postgre, sqlite, sqlite3, sqlsrv
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Query Builder class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['encrypt']  Whether or not to use an encrypted connection.
|
|			'mysql' (deprecated), 'sqlsrv' and 'pdo/sqlsrv' drivers accept TRUE/FALSE
|			'mysqli' and 'pdo/mysql' drivers accept an array with the following options:
|
|				'ssl_key'    - Path to the private key file
|				'ssl_cert'   - Path to the public key certificate file
|				'ssl_ca'     - Path to the certificate authority file
|				'ssl_capath' - Path to a directory containing trusted CA certificates in PEM format
|				'ssl_cipher' - List of *allowed* ciphers to be used for the encryption, separated by colons (':')
|				'ssl_verify' - TRUE/FALSE; Whether verify the server certificate or not ('mysqli' only)
|
|	['compress'] Whether or not to use client compression (MySQL only)
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|	['ssl_options']	Used to set various SSL options that can be used when making SSL connections.
|	['failover'] array - A array with 0 or more data for connections if the main should fail.
|	['save_queries'] TRUE/FALSE - Whether to "save" all executed queries.
| 				NOTE: Disabling this will also effectively disable both
| 				$this->db->last_query() and profiling of DB queries.
| 				When you run a query, with this setting set to TRUE (default),
| 				CodeIgniter will store the SQL statement for debugging purposes.
| 				However, this may cause high memory usage, especially if you run
| 				a lot of SQL queries ... disable this to avoid that problem.
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $query_builder variables lets you determine whether or not to load
| the query builder class.
*/
$active_group = 'default';
// $active_record = TRUE;
$query_builder = TRUE;

// $db['default']['hostname'] = 'localhost';
// $db['default']['username'] = 'root';
// $db['default']['password'] = '123456789';
// $db['default']['database'] = 'service_issue_solution';
// $db['default']['dbdriver'] = 'mysql';
// $db['default']['dbprefix'] = '';
// $db['default']['pconnect'] = FALSE;
// $db['default']['db_debug'] = TRUE;
// $db['default']['cache_on'] = FALSE;
// $db['default']['cachedir'] = '';
// $db['default']['char_set'] = 'utf8';
// $db['default']['dbcollat'] = 'utf8_general_ci';
// $db['default']['swap_pre'] = '';
// $db['default']['autoinit'] = TRUE;
// $db['default']['stricton'] = FALSE;

// $db['default'] = array(
// 	'dsn'	=> '',
// 	'hostname' => '192.168.82.31',
// 	'username' => 'monty',
// 	'password' => 'some_pass',
// 	'database' => 'qcd_report',
// 	'dbdriver' => 'mysqli',
// 	'dbprefix' => '',
// 	'pconnect' => FALSE,
// 	'db_debug' => (ENVIRONMENT !== 'production'),
// 	'cache_on' => FALSE,
// 	'cachedir' => '',
// 	'char_set' => 'utf8',
// 	'dbcollat' => 'utf8_general_ci',
// 	'swap_pre' => '',
// 	'encrypt' => FALSE,
// 	'compress' => FALSE,
// 	'stricton' => FALSE,
// 	'failover' => array(),
// 	'save_queries' => TRUE
// );

$db['db_sys_desk_online_dev'] = array(
 'dsn' => '',
 'hostname' => '192.168.161.97',
 'username' => 'monty',
 'password' => 'some_pass',
 'database' => 'sys_desk_online_db_dev',
 'dbdriver' => 'mysqli',
 'dbprefix' => '',
 'pconnect' => FALSE,
 'db_debug' => (ENVIRONMENT !== 'production'),
 'cache_on' => FALSE,
 'cachedir' => '',
 'char_set' => 'utf8',
 'dbcollat' => 'utf8_general_ci',
 'swap_pre' => '',
 'encrypt' => FALSE,
 'compress' => FALSE,
 'stricton' => FALSE,
 'failover' => array(),
 'save_queries' => TRUE
);
$db['db_sys_desk_online'] = array(
 'dsn' => '',
 'hostname' => '192.168.161.97',
 'username' => 'monty',
 'password' => 'some_pass',
 'database' => 'sys_desk_online_db',
 'dbdriver' => 'mysqli',
 'dbprefix' => '',
 'pconnect' => FALSE,
 'db_debug' => (ENVIRONMENT !== 'production'),
 'cache_on' => FALSE,
 'cachedir' => '',
 'char_set' => 'utf8',
 'dbcollat' => 'utf8_general_ci',
 'swap_pre' => '',
 'encrypt' => FALSE,
 'compress' => FALSE,
 'stricton' => FALSE,
 'failover' => array(),
 'save_queries' => TRUE
);
$db['default'] = array(
	'dsn'	=> '',
	'port' => '1433',
	'hostname' => 'Driver={SQL Server};Server=192.168.161.101\PCSDBSV;Database=report_service;',
	'username' => 'pcs_admin',
	'password' => 'P@ss!fa',
	'database' => 'report_service',
	'dbdriver' => 'odbc',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

$db['rec_db'] = array(
	'dsn'	=> '',
	'port' => '1433',
	'hostname' => 'Driver={SQL Server};Server=192.168.161.101\PCSDBSV;Database=evaluation_report;',
	'username' => 'pcs_admin',
	'password' => 'P@ss!fa',
	'database' => 'Received_dashboard',
	'dbdriver' => 'odbc',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);


//Another database configuration
$tnsname = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 172.17.131.18)(PORT = 1524))
        (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = EXPK)))';
$name = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 172.17.131.18)(PORT = 1524)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = EXPK)))';
$db['explanner_db'] = array(
	'dsn'	=> '',
	'hostname' => $name,
	'username' => 'EXPK',
	'password' => 'EXPK',
	'database' => 'EXPK',
	'dbdriver' => 'oci8',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

$db['cat_look'] = array(
	'dsn'	=> '',
	'port' => '1433',
	'hostname' => 'Driver={SQL Server};Server=192.168.161.101\PCSDBSV;Database=report_service;',
	'username' => 'pcs_admin',
	'password' => 'P@ss!fa',
	'database' => 'report_service',
	'dbdriver' => 'odbc',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
$db['fa10'] = array(
 'dsn' => '',
 'hostname' => 'Driver={IBM DB2 ODBC DRIVER - DB2COPY3};Database=tbkfa03;hostname=192.168.161.1;port=50000;protocol=TCPIP;',
 'username' => 'tbk',
 'password' => 'kbt',
 'database' => 'TBKFA03',
 'dbdriver' => 'odbc',
 'dbprefix' => '',
 'pconnect' => FALSE,
 'db_debug' => (ENVIRONMENT !== 'production'),
 'cache_on' => FALSE,
 'cachedir' => '',
 'char_set' => 'utf8',
 'dbcollat' => 'utf8_general_ci',
 'swap_pre' => '',
 'encrypt' => FALSE,
 'compress' => FALSE,
 'stricton' => FALSE,
 'failover' => array(),
 'save_queries' => TRUE
);
$db['box_solution'] = array(
	'dsn'	=> '',
	'port' => '1433',
	'hostname' => 'Driver={SQL Server};Server=192.168.161.101\PCSDBSV;Database=box_solution;',
	'username' => 'pcs_admin',
	'password' => 'P@ss!fa',
	'database' => 'box_solution',
	'dbdriver' => 'odbc',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

$db['fa10'] = array(
 'dsn' => '',
 'hostname' => 'Driver={IBM DB2 ODBC DRIVER - DB2COPY3};Database=tbkfa03;hostname=192.168.161.1;port=50000;protocol=TCPIP;',
 'username' => 'tbk',
 'password' => 'kbt',
 'database' => 'TBKFA03',
 'dbdriver' => 'odbc',
 'dbprefix' => '',
 'pconnect' => FALSE,
 'db_debug' => (ENVIRONMENT !== 'production'),
 'cache_on' => FALSE,
 'cachedir' => '',
 'char_set' => 'utf8',
 'dbcollat' => 'utf8_general_ci',
 'swap_pre' => '',
 'encrypt' => FALSE,
 'compress' => FALSE,
 'stricton' => FALSE,
 'failover' => array(),
 'save_queries' => TRUE
);

$db['fa08'] = array(
 'dsn' => '',
 'hostname' => 'Driver={IBM DB2 ODBC DRIVER - DB2COPY3};Database=tbkfa04;hostname=192.168.176.1;port=50000;protocol=TCPIP;',
 'username' => 'tbk',
 'password' => 'kkbt',
 'database' => 'TBKFA04',
 'dbdriver' => 'odbc',
 'dbprefix' => '',
 'pconnect' => FALSE,
 'db_debug' => (ENVIRONMENT !== 'production'),
 'cache_on' => FALSE,
 'cachedir' => '',
 'char_set' => 'utf8',
 'dbcollat' => 'utf8_general_ci',
 'swap_pre' => '',
 'encrypt' => FALSE,
 'compress' => FALSE,
 'stricton' => FALSE,
 'failover' => array(),
 'save_queries' => TRUE
);

$db['QGATE_SOLUTION'] = array(
	'dsn'	=> '',
	'port' => '1433',
	'hostname' => 'Driver={SQL Server};Server=192.168.161.101\PCSDBSV;Database=QGATE_SOLUTION_PH10;AutoTranslate=yes;',
	'username' => 'pcs_admin',
	'password' => 'P@ss!fa',
	'database' => 'QGATE_SOLUTION_PH10',
	'dbdriver' => 'odbc',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);


$db['tbkkfa01_db'] = array(
	'dsn'	=> '',
	'port' => '1433',
	'hostname' => 'Driver={SQL Server};Server=192.168.161.101\PCSDBSV;Database=test_new_fa02;',
	'username' => 'pcs_admin',
	'password' => 'P@ss!fa',
	'database' => 'test_new_fa02',
	'dbdriver' => 'odbc',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

$db['test_new_fa01'] = array(
	'dsn'	=> '',
	'port' => '1433',
	'hostname' => 'Driver={SQL Server};Server=192.168.161.101\PCSDBSV;Database=test_new_fa01;',
	'username' => 'pcs_admin',
	'password' => 'P@ss!fa',
	'database' => 'test_new_fa01',
	'dbdriver' => 'odbc',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

$db['test_new_fa02'] = array(
	'dsn'	=> '',
	'port' => '1433',
	'hostname' => 'Driver={SQL Server};Server=192.168.161.101\PCSDBSV;Database=test_new_fa02;',
	'username' => 'pcs_admin',
	'password' => 'P@ss!fa',
	'database' => 'test_new_fa02',
	'dbdriver' => 'odbc',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);


$db['FASYSTEM_db'] = array(
	'dsn'	=> '',
	'port' => '1433',
	'hostname' => 'Driver={SQL Server};Server=192.168.161.101\PCSDBSV;Database=FASYSTEM;',
	'username' => 'pcs_admin',
	'password' => 'P@ss!fa',
	'database' => 'tbkkfa01_dev',
	'dbdriver' => 'odbc',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

$db['FA_PH8'] = array(
	'dsn'	=> '',
	'port' => '1433',
	'hostname' => 'Driver={SQL Server};Server=192.168.161.101\PCSDBSV;Database=FASYSTEMPH8;',
	'username' => 'pcs_admin',
	'password' => 'P@ss!fa',
	'database' => 'FASYSTEMPH8',
	'dbdriver' => 'odbc',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
$db['FA_PH10'] = array(
	'dsn'	=> '',
	'port' => '1433',
	'hostname' => 'Driver={SQL Server};Server=192.168.161.101\PCSDBSV;Database=FASYSTEMPH10;',
	'username' => 'pcs_admin',
	'password' => 'P@ss!fa',
	'database' => 'FASYSTEMPH10',
	'dbdriver' => 'odbc',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
$db['PICKING'] = array(
	'dsn'	=> '',
	'port' => '1433',
	'hostname' => 'Driver={SQL Server};Server=192.168.161.101\PCSDBSV;Database=PICKING;',
	'username' => 'pcs_admin',
	'password' => 'P@ss!fa',
	'database' => 'PICKING',
	'dbdriver' => 'odbc',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);


$db['jeaw_db'] = array(
	'dsn'	=> '',
	'hostname' => '192.168.82.31',
	'username' => 'monty',
	'password' => 'some_pass',
	'database' => 'report_service',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);


$db['ship_db'] = array(
	'dsn'	=> '',
	'hostname' => '192.168.161.6',
	'username' => 'develop',
	'password' => 'tbk',
	'database' => 'ship',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
$db['etax_db'] = array(
	'dsn'	=> '',
	'port' => '1433',
	'hostname' => 'Driver={SQL Server};Server=192.168.161.101\PCSDBSV;Database=etax_invoice_db;',
	'username' => 'sa',
	'password' => 'Te@m1nw',
	'database' => 'etax_invoice_db',
	'dbdriver' => 'odbc',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

$db['fa_db'] = array(
	'dsn'	=> '',
	'port' => '1433',
	'hostname' => 'Driver={SQL Server};Server=192.168.161.101\PCSDBSV;Database=tbkkfa01_dev;',
	'username' => 'pcs_admin',
	'password' => 'P@ss!fa',
	'database' => 'tbkkfa01_dev',
	'dbdriver' => 'odbc',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

// $name = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 172.17.134.18)(PORT = 1524)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = EXPK)))';

// $db['another_db'] = array(
// 	'dsn'	=> '',
// 	'hostname' => $name,
// 	'username' => 'EXPK',
// 	'password' => 'EXPK',
// 	'database' => 'EXPK',
// 	'dbdriver' => 'oci8',
// 	'dbprefix' => '',
// 	'pconnect' => FALSE,
// 	'db_debug' => (ENVIRONMENT !== 'production'),
// 	'cache_on' => FALSE,
// 	'cachedir' => '',
// 	'char_set' => 'utf8',
// 	'dbcollat' => 'utf8_general_ci',
// 	'swap_pre' => '',
// 	'encrypt' => FALSE,
// 	'compress' => FALSE,
// 	'stricton' => FALSE,
// 	'failover' => array(),
// 	'save_queries' => TRUE
// );


