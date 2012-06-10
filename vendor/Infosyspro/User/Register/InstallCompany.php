<?php

/**
 * This can be used to generate a PHP code that returns an array 
 * representation of an Zend\Config\Config object. 
 * 
 * The companies that are auto configured need this 
 * A config in the form of company.config.php stored to in the
 * Core/configs/autoload
 * 
 * The new client will have a database created.
 * 
 * The public files will be copied to the client's root directory
 * 
 */

namespace Infosyspro\User\Register;

use Zend\Config\Writer\PhpArray,
    Zend\Di\Locator as ZendLocator;

class InstallCompany
{

    //string that holds the new client.. aka username
    protected $company;
    protected $files = array(
        'source' => 'public',
        'cpFiles' => array(
            'index.config.php' => 'index.php',
            'htaccess.txt' => '.htaccess',
        ),
        'dirFiles' => array(
            'media/site'
        ),
    );

    public function __construct(Array $options)
    {
        //we need the company username in order to go any further
        if(sizeof($options) < 0  || empty($options['domain'])) {
            throw new \Exception('Company details are required'); 
        } 
      
        $this->company = $options;
        $this->_setUp();  //Start the processing
    }

    /**
     * Setup company's as outlined above
     */
    protected function _setUp()
    {
        $this->_generateConfig();
        $this->_copyHtmlFiles();
        $this->_copyDb();
    }

    /**
     * Generate the configuration for this company
     * @uses Zend\Config\Writer\PhpArray
     */
    protected function _generateConfig()
    {
        //Core server info
        $coreConfig = include APPLICATION_PATH . '/config/autoload/local.config.php';
        $cCfg=  $coreConfig['di']['instance']['Db']['parameters']['driver'];
        $db = 'admin_' . $this->company['domain'];
        // Create the config object
        $config = new \Zend\Config\Config(array(), true);
        $config->di = array();
        $config->di->instance = array();
        $config->di->instance->alias = array();
        $config->di->instance->alias->Db = 'Zend\Db\Adapter\Adapter';
        $config->di->instance->Db = array();
        $config->di->instance->Db->parameters = array();
        $config->di->instance->Db->parameters->driver = array();
        $config->di->instance->Db->parameters->driver->driver = 'Pdo';
        $config->di->instance->Db->parameters->driver->dsn = 'mysql:host=' . $cCfg['hostname'] .';dbname=' . $db;
        $config->di->instance->Db->parameters->driver->dbname = $db;
        $config->di->instance->Db->parameters->driver->hostname = $cCfg['hostname'];
        $config->di->instance->Db->parameters->driver->username = 'cli_' . $this->company['domain'];        
        $config->di->instance->Db->parameters->driver->password = $this->company['password'];
        $config->di->instance->Db->parameters->driver->driver_options = array(1002 => 'SET NAMES \'UTF8\'');
        $companyFile = APPLICATION_PATH . '/config/autoload/' . $this->company['domain'] . '.config.php';
        umask(0);
        $f = fopen($companyFile, 'w+') or die("can't open file");
        fclose($f);

        $writer = new PhpArray();
        $writer->toFile($companyFile, $config, $exclusiveLock = true);        
    }

    /**
     * Copy all the necessary CSS, index.php and images from the core
     * to the client's folder
     * The cfolder should start with an "_"
     */
    protected function _copyHtmlFiles()
    {
        //Store the source directory and remove it from memory
        $sourceDir = APPLICATION_PATH . '/' . $this->files['source'];
        unset($this->files['source']);
      
        if (!is_dir($sourceDir . '/_' . $this->company['domain'])) {
            $oldumask = umask(0);
            mkdir($sourceDir . '/_' . $this->company['domain'], 01777); // so you get the sticky bit set 
            umask($oldumask);
        }

        //copy files first
        foreach ($this->files['cpFiles'] as $oldFile => $newFile) {
            $source = $sourceDir . '/' . $oldFile;
            $destination = $sourceDir . '/_' . $this->company['domain'] . '/' . $newFile;
            $this->_copyFilesAndFolders($source, $destination, true);
        }
       
        //Copy folders and their files across
        foreach ($this->files['dirFiles'] as $dir) {
            $source = $sourceDir . '/' . $dir;
            $destination = $sourceDir . '/_' . $this->company['domain'] . '/' . $dir;

            $this->_copyFilesAndFolders($source, $destination);
        }
    }

    protected function _copyFilesAndFolders($source, $destination, $filesOnly = false)
    {

        if ($filesOnly) {
            $f = array_pop(explode('/',$source));
            umask(0);
            copy("$source", "$destination");
            if($f == 'htaccess.txt') {                
               exec('echo  "\nSetEnv COMPANY ' . $this->company['domain'] . ' " >> ' . $destination);
            }
            
        } else {
            if (!is_dir($destination)) {
                $oldumask = umask(0);
                mkdir($destination, 01777, true); // so you get the sticky bit set 
                umask($oldumask);
            }
            if ($dir_handle = @opendir($source)) {
                while ($file = readdir($dir_handle)) {
                    if ($file != '.' && $file != '..' && !is_dir("$source/$file")) { //if it is file
                        copy("$source/$file", "$destination/$file");
                    } elseif ($file != '.' && $file != '..' && is_dir("$source/$file")) { //if it is folder
                        $this->_copyFilesAndFolders("$source/$file", "$destination/$file");
                    }
                }
                closedir($dir_handle);
            }
        }
    }

    /**
     * Copy the database accross
     */
    protected function _copyDb()
    {
       // $db = $this->locator->get('Db');
       // var_dump($db); exit;
        $coreConfig = include APPLICATION_PATH . '/config/autoload/local.config.php';
        $cCfg=  $coreConfig['di']['instance']['Db']['parameters']['driver'];
        //'dsn' => 'mysql:dbname=infosyspro;hostname=localhost',
        //config file
        $companyFile = APPLICATION_PATH . '/config/autoload/' . $this->company['domain'] . '.config.php';        
        //Db file to backup to
        $backupFile = APPLICATION_PATH . '/public/_' .  
                       $this->company['domain'] . '/' . $this->company['domain'] . '.sql'; 
        //get the company's configuration
        $config = include $companyFile;
        $conf = $config['di']['instance']['Db']['parameters']['driver'];
        
        $cmd = 'mysqldump --compact --user=' . $cCfg['username'] . 
                      ' --password=' . $cCfg['password'] . ' --add-drop-table ' 
                      . $cCfg['dbname'] . ' --host ' . $cCfg['hostname'] . ' > ' . $backupFile;
        // Create the database
        $cmd .= ";mysql -u{$cCfg['username']} -p{$cCfg['password']} -h {$cCfg['hostname']} -e 'CREATE database admin_{$this->company['domain']};'";
        // Get core database
        $cmd .= ";mysql -u{$cCfg['username']} -p{$cCfg['password']} -h {$cCfg['hostname']}  admin_{$this->company['domain']} < {$backupFile}";
       // Grant all privileges to the client to their database
        $cmd .= ";mysql -u{$cCfg['username']} -p{$cCfg['password']} -h {$cCfg['hostname']}  -e \"GRANT ALL PRIVILEGES ON admin_{$this->company['domain']}.* TO " 
                . $conf['username'] . " @'{$conf['hostname']}' IDENTIFIED BY '" . $conf['password']. "'\"";    
        //execute the shell command
        exec($cmd);
        unlink($backupFile);
    }

   
    /**
     * Set permissions for the customer's subscription
     */
    protected function _setPackagePermissions()
    {
        
    }

}