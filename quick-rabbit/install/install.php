<?php
//getting base url for actual path
$root=(isset($_SERVER["HTTPS"]) ? "https://" : "http://").$_SERVER["HTTP_HOST"];
$root.= str_replace(basename($_SERVER["SCRIPT_NAME"]), "", $_SERVER["SCRIPT_NAME"]);
$base_url = $root;

$install_path = $_SERVER['DOCUMENT_ROOT']; //
$install_path.= str_replace(basename($_SERVER["SCRIPT_NAME"]), "", $_SERVER["SCRIPT_NAME"]);
$root_path_project = str_replace("install/", "", $install_path);

$indexFile = $root_path_project."index.php";
$configFolder = $root_path_project."config";
$dbFile = $root_path_project."config/database.php";

session_start();

$step = isset($_GET['step']) ? $_GET['step'] : '';
switch ($step) {
    default: ?>
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ul class="list">
                        <li class="active"> <i class="fa fa-check"></i>Env. Check</li>
                        <li>DB Config</li>
                        <li>Site Config</li>
                        <li class="last">Complete!</li>
                    </ul>
                </div>
                <div class="panel-body">
                    <h3 class="text-center padding_70">Server Environment Checklist</h3>
                    <?php
                    $error = FALSE;
                    if (!is_writeable($indexFile)) {
                        $error = TRUE;
                        echo "<div class='alert alert-danger'><i class='icon-remove'></i> Index File (index.php) is not write able!</div>";
                    }
                    if (!function_exists('file_get_contents')) {
                        $error = TRUE;
                        echo "<div class='alert alert-danger'><i class='icon-remove'></i> file_get_contents() function is not enabled in your server !</div>";
                    }
                    if (!is_writeable($dbFile)) {
                        $error = TRUE;
                        echo "<div class='alert alert-danger'><i class='icon-remove'></i> Database File (config/database.php) is not writable!</div>";
                    }
                    if (phpversion() < "7.0") {
                        $error = TRUE;
                        echo "<div class='alert alert-danger'><i class='icon-remove'></i> Your PHP version is ".phpversion()."! PHP 7.0 or higher required!</div>";
                    } else {
                        echo "<div class='alert alert-success'><i class='icon-ok'></i> You are running PHP ".phpversion()."</div>";
                    }
                    if (!extension_loaded('mysqli')) {
                        $error = TRUE;
                        echo "<div class='alert alert-danger'><i class='icon-remove'></i> Mysqli PHP extension missing!</div>";
                    } else {
                        echo "<div class='alert alert-success'><i class='icon-ok'></i> Mysqli PHP extension loaded!</div>";
                    }
                    if (!extension_loaded('curl')) {
                        $error = TRUE;
                        echo "<div class='alert alert-danger'><i class='icon-remove'></i> CURL PHP extension missing!</div>";
                    } else {
                        echo "<div class='alert alert-success'><i class='icon-ok'></i> CURL PHP extension loaded!</div>";
                    }
                    if (!function_exists('exec')) {
                        $error = TRUE;
                        echo "<div class='alert alert-danger'><i class='icon-remove'></i> Remove exec from php.ini file in variable: disable_functions</div>";
                    } else {
                        echo "<div class='alert alert-success'><i class='icon-ok'></i> exec PHP function is enabled!</div>";
                    }
                    if (!extension_loaded('openssl')) {
                        $error = TRUE;
                        echo "<div class='alert alert-danger'><i class='icon-remove'></i> SSL not installed!</div>";
                    } else {
                        echo "<div class='alert alert-success'><i class='icon-ok'></i> SSL enabled!</div>";
                    }
                    ?>

                    <p class='pl-4 pr-4 text-danger'>NB: We prefer to install this script on your subdomain or main domain. Otherwise, some functionalities like Firebase Notification, Push Notification, Live Chat will not work.</p>
                    
                    
                    <div class="bottom">
                        <?php if ($error) { ?>
                            <a href="#" class="btn btn-primary button_1">Next <i class="fa fa-angle-double-right right_arrow"></i></a>
                        <?php } else { ?>
                            <a href="<?php echo $base_url?>index.php?step=1" class="btn btn-primary button_1">Next <i class="fa fa-angle-double-right right_arrow"></i></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <?php
        break;
    case "0":

        break;
    case "1": ?>

    <div class="panel-group">
        <div class="panel panel-default">
            <div class="panel-heading">
                    <ul class="list">
                        <li>Env. Check</li>
                        <li class="active"> <i class="fa fa-check"></i>DB Config</li>
                        <li>Site Config</li>
                        <li class="last">Complete!</li>
                    </ul>
            </div>
            <div class="panel-body">
            <h3 class="ins_h3">Database Configuration</h3 cl>
                <p class="ins_2">Please create a database in your server. And enter the db information here.</p>
                <form action="<?php echo $base_url?>index.php?step=2" method="POST" class="form-horizontal">
                    <div class="control-group ins_3">
                        <label class="control-label" for="db_hostname">Database Host</label>
                        <div class="controls">
                            <input id="db_hostname"  type="text" onfocus="select();" name="db_hostname" class="input-large ins_4 form-control" required data-error="DB Host is required" placeholder="DB Host" value="localhost" />
                            <i class="color_red">Host name could be 127.0.0.1 or localhost or your server hostname</i>
                        </div>
                    </div>
                    <div class="control-group ins_3">
                        <label class="control-label" for="db_username">Database Username</label>
                        <div class="controls">
                            <input  id="db_username"  type="text" onfocus="select();" name="db_username" class="input-large ins_4 form-control" autocomplete="off" required data-error="DB Username is required" placeholder="DB Username" />
                        </div>
                    </div>
                    <div class="control-group ins_3">
                        <label class="control-label" for="db_password">Database Password</a></label>
                        <div class="controls">
                            <input  id="db_password" type="password" onfocus="select();"  name="db_password" class="input-large ins_4 form-control" autocomplete="off" data-error="DB Password is required" placeholder="DB Password" />
                        </div>
                    </div>
                    <div class="control-group ins_3">
                        <label class="control-label" for="db_name">Database Name</label>
                        <div class="controls">
                            <input  id="db_name"  type="text" onfocus="select();" name="db_name" class="input-large ins_4 form-control" autocomplete="off" required data-error="DB Name is required" placeholder="DB Name" />
                        </div>
                    </div>
                    <input id="purchase_code" type="hidden" name="purchase_code" value="" />
                    <input type="hidden" name="username" value="" />
                    <div class="bottom">
                        <button type="submit" class="btn btn-primary button_1">Next <i class="fa fa-angle-double-right right_arrow"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    break;
    case "2":
        ?>
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                <ul class="list">
                        <li>Env. Check</li>
                        <li>DB Config</li>
                        <li class="active"> <i class="fa fa-check"></i>Site Config</li>
                        <li class="last">Complete!</li>
                 </ul>
                </div>
                <div class="panel-body">
                    <h3 class="ins_6">Saving database config</h3>
                    <?php
                    if ($_POST) {
                        $db_hostname = $_POST["db_hostname"];
                        if(isset($db_hostname) && $db_hostname){
                        }else{
                            header("Location: $base_url");
                        }
                        $db_username = $_POST["db_username"];
                        $db_password = $_POST["db_password"];
                        $db_name = $_POST["db_name"];
                
                        $status = false;
                        try{
                            $link = mysqli_connect($db_hostname, $db_username, $db_password);  
                            $status = true;
                            $db_selected = mysqli_select_db($link, $db_name);
                            if (!$db_selected) {
                                if (!mysqli_query($link, "CREATE DATABASE IF NOT EXISTS `$db_name`")) {
                                    echo "<div class='alert alert-danger'><i class='icon-remove'></i> Database " . $db_name . " does not exist and could not be created. Please create the Database manually and retry this step.</div>";
                                    return FALSE;
                                } else {
                                    echo "<div class='alert alert-success'><i class='icon-ok'></i> Database " . $db_name . " created</div>";
                                }
                            }
                            mysqli_select_db($link, $db_name);

                            require_once($install_path.'includes/core_class.php');
                            $core = new Core();
                            $dbdata = array(
                                'db_hostname' => $db_hostname,
                                'db_username' => $db_username,
                                'db_password' => $db_password,
                                'db_name' => $db_name
                            );

                            if ($core->write_database($dbdata) == false) {
                                echo "<div class='alert alert-danger'><i class='icon-remove'></i> Failed to write database details to ".$dbFile."</div>";
                            } else {
                                echo "<div class='alert alert-success'><i class='icon-ok'></i> Database config written to the database file.</div>";
                            }
                        }
                        catch(Exception $e){
                            echo "<div class='alert alert-danger'><i class='icon-remove'></i> Could not connect to MYSQL!</div>";
                            $status = false;
                        }
                        if($status==true){
                            echo '<div class="alert alert-success"><i class="icon-ok"></i> Connection to MYSQL successful!</div>';
                        }

                    } else { echo "<div class='alert alert-success'><i class='icon-question-sign'></i> Nothing to do...</div>"; }
                    ?>
                    <div class="bottom bottom_config">
                        <form action="<?php echo $base_url?>index.php?step=1" method="POST" class="form-horizontal config_form">
                            <input id="purchase_code" type="hidden" name="purchase_code" value="<?php echo isset($_POST['purchase_code']) && $_POST['purchase_code']?$_POST['purchase_code']:''; ?>" />
                            <input id="username" type="hidden" name="username" value="<?php echo isset($_POST['username'])?$_POST['username']:''; ?>" />
                            <div class="bottom bottom_btn_config">
                                <button type="submit" class="btn btn-primary button_1"><i class="fa fa-angle-double-left left_arrow"></i> Previous</button>
                            </div>
                        </form>
                        <form action="<?php echo $base_url?>index.php?step=3" method="POST" class="form-horizontal config_form">
                            <input id="purchase_code" type="hidden" name="purchase_code" value="<?php echo isset($_POST['purchase_code']) && $_POST['purchase_code']?$_POST['purchase_code']:''; ?>" />
                            <input id="username" type="hidden" name="username" value="<?php echo isset($_POST['username'])?$_POST['username']:''; ?>" />

                            <div class="bottom bottom_btn_config">
                                <button type="submit" <?php echo isset($status) && $status==false?'disabled':''?> class="btn btn-primary button_1">Next<i class="fa fa-angle-double-right right_arrow"></i></button>
                            </div>
                        </form>
                        <br clear="all">
                    </div>
                </div>
            </div>
        </div>
        <?php
        break;
    case "3":
        ?>
        <div class="panel-group">
        <div class="panel panel-default">
        <div class="panel-heading">
                <ul class="list">
                        <li>Env. Check</li>
                        <li>DB Config</li>
                        <li class="active"> <i class="fa fa-check"></i>Site Config</li>
                        <li class="last">Complete!</li>
                 </ul>
        </div>
        <div class="panel-body">
        <h3 class="ins_7">Site Config</h3>
        <?php
        if ($_POST) {
            ?>
            <form action="<?php echo $base_url?>index.php?step=5" method="POST" class="form-horizontal">
                <div class="control-group ins_13">
                    <label class="control-label" for="installation_url">Installation URL</label>
                    <div class="controls">
                        <input   type="text" onfocus="select();" id="installation_url" name="installation_url" class="xlarge ins_4 form-control" required data-error="Installation URL is required" value="<?php echo (isset($_SERVER["HTTPS"]) ? "https://" : "http://").$_SERVER["SERVER_NAME"].substr($_SERVER["REQUEST_URI"], 0, -24); ?>" />
                    </div>
                </div>
                <div class="control-group ins_13">
                    <label class="control-label" for="Encryption Key">Encryption Key</label>
                    <div class="controls">
                        <input  type="text" onfocus="select();" id="enckey" name="enckey" class="xlarge ins_4 form-control" required data-error="Encryption Key is required"
                               value="<?php

                               $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                               $charactersLength = strlen($characters);
                               $randomString = '';
                               for ($i = 0; $i < 6; $i++) {
                                   $randomString .= $characters[rand(0, $charactersLength - 1)];
                               }

                               echo $randomString;

                               ?>"
                               readonly />
                    </div>
                </div>
                <input type="hidden" name="purchase_code" value="<?php echo $_POST['purchase_code']; ?>" />
                <input type="hidden" name="username" value="<?php echo $_POST['username']; ?>" />
                <div class="bottom bottom_config">
                    <div class="bottom width_50">
                    <a href="<?php echo $base_url?>index.php?step=2" class="btn btn-primary button_1"> <i class="fa fa-angle-double-left left_arrow"></i> Previous</a>
                    </div>
                    
                    <div class="bottom width_50">
                        <button type="submit" class="btn btn-primary button_1">Next<i class="fa fa-angle-double-right right_arrow"></i></button>
                    </div>
                </div>
            </form>
            </div>
            </div>
            </div>

            <?php
        }else{
            header("Location: $base_url");
        }
        break;
    case "4":
         
        break;
    case "5": ?>
        <div class="panel-group">
        <div class="panel panel-default">
        <div class="panel-heading">
            <ul class="list">
                        <li>Env. Check</li>
                        <li>DB Config</li>
                        <li>Site Config</li>
                        <li class="active"> <i class="fa fa-check"></i>Complete!</li>
                 </ul>
        </div>
        <div class="panel-body">

        <?php
        $finished = FALSE;
        if ($_POST) {
            $owner = '';
            $username = $_POST["username"];
            $purchase_code = $_POST["purchase_code"];

            define("BASEPATH", "install/");
            include($root_path_project."config/database.php");
            
            require_once($install_path.'includes/core_class.php');
            $core = new Core();

            $pc_hostname = $core->macorhost();
            
            $installation_url = (isset($_SERVER["HTTPS"]) ? "https://" : "http://").$_SERVER["SERVER_NAME"].substr($_SERVER["REQUEST_URI"], 0, -24);
            $installation_date_and_time = date('Y-m-d h:i:s');
            //need to change
            $dbtables = file_get_contents(str_rot13("../nffrgf/wdhrel-hv/qo_fbhepr.fdy"));
            $dbdata = array(
                'hostname' => $db['default']['hostname'],
                'username' => $db['default']['username'],
                'password' => $db['default']['password'],
                'database' => $db['default']['database'],
                'dbtables' => $dbtables
            );
            require_once($install_path.'includes/database_class.php');
            $database = new Database();
            if ($database->create_tables($dbdata) == false) {
                echo "<div class='alert alert-warning'><i class='icon-warning'></i> The database tables could not be created, please try again.</div>";
            } else {
                $finished = TRUE;
            }
            if ($core->write_index($installation_url) == false) {
                echo "<div class='alert alert-danger'><i class='icon-remove'></i> Failed to write index details!</div>";
                $finished = FALSE;
            }
        }
        if ($finished) {
            sleep(15);
            ?>

            <h3 class="ins_7 ins_8"><i class='icon-ok'></i> Installation completed!</h3>
            <div class="ins_10">Please login now using the following credential:<br /><br />
                <b>-Admin</b><br>
                Email Address: <span class="ins_9">admin@doorsoft.co</span><br />Password: <span class="ins_9">123456</span><br /><br />
                <b>-Agent</b><br>
                Email Address: <span class="ins_9">agent@doorsoft.co</span><br />Password: <span class="ins_9">123456</span><br /><br />
                <b>-Customer</b><br>
                Email Address: <span class="ins_9">customer@doorsoft.co</span><br />Password: <span class="ins_9">123456</span><br /><br />
            </div>
            <div class="ins_11">Please change your credentials after login.
            </div>
            <div class="bottom bottom_complete">
                <div class="bottom ins_12">
                    <a href="<?php echo (isset($_SERVER["HTTPS"]) ? "https://" : "http://").$_SERVER["SERVER_NAME"].substr($_SERVER["REQUEST_URI"], 0, -24); ?>admin/login" class="btn btn-primary button_1">Go to Login Page</a>
                </div>
            </div>
            </div>
            </div>
            </div>

            <?php
        }
}
?>