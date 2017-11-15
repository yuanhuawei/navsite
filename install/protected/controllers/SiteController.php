<?php

class SiteController extends CController
{
    public $dbcharset='gbk';

    /**
     * This is the default action that displays the phonebook Flex client.
     */
    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionInstall()
    {
//        ppr($_REQUEST);
        
        
        $opt = null;
//        $show = new show();

        $step = reqReq('step', 0);

        if (empty($step))
        {
            $this->render('step0');
//            $show->showLowVersion();
        } elseif ($step == 1)//选择安装模式
        {

            $this->render('step1');
//            $show->showStep1();
        } elseif ($step == 2)//输入库配置文件可写检测
        {
            $w_check = array(
                YLMF_ROOT.'ajax/',
                YLMF_ROOT.'html/',
                YLMF_BACKEND.'assets/',
                YLMF_BACKEND.'uploads/',
                YLMF_APP.'runtime/',
                YLMF_APP.'data/crond/',
                YLMF_APP.'data/cachefile/',
                APP_DB,
            );
            $check = 1;
            foreach ($w_check as $key => $value)
            {
                if (!file_exists($value) && !@touch($value))
                {
                    $w_check[$key] .= $this->_getLang('no_file');
                    $check = 0;
                } elseif (!is_writable($value))
                {
                    $w_check[$key] .= $this->_getLang('777_test');
                    $check = 0;
                } else
                {
                    $w_check[$key] .= $this->_getLang('test_ok');
                }
            }
            
//YII环境配置
            $requirements = lang::viewCheck();
            

            $result = 1;  // 1: all pass, 0: fail, -1: pass with warnings

            foreach ($requirements as $i => $requirement)
            {
                if ($requirement[1] && !$requirement[2])
                    $result = 0;
                else if ($result > 0 && !$requirement[1] && !$requirement[2])
                    $result = -1;
                if ($requirement[4] === '')
                    $requirements[$i][4] = '&nbsp;';
            }

            $viewFile = array(
                'requirements' => $requirements,
                'result' => $result,
            );
            
//            ppr($viewFile,1);
            if ($result == 0 || !$check)
            {
                $btn_disabled = 'disabled="disabled"';
            } else
            {
                $btn_disabled = '';
            }


            $this->render('step2',array('view_file'=>$viewFile,'w_check'=>$w_check,'btn_disabled'=>$btn_disabled));
        } elseif ($step == 3)
        {
            $this->render('step3',array('opt'=>$opt, 'error_password'=>0));

        } elseif ($step == 4) //输入处理和目录权限检测
        {
            
            $type = reqGet('t');
                
            $GLOBALS ['database'] ['db_host'] = reqReq('dbhost');
            $GLOBALS ['database'] ['db_name'] = reqReq('dbname');
            $GLOBALS ['database'] ['db_user'] = reqReq('dbuser');
            $GLOBALS ['database'] ['db_pass'] = reqReq('dbpw');
            $GLOBALS ['database'] ['db_charset'] = reqReq('charset');
            $GLOBALS ['database'] ['theme'] = 'default';
            $GLOBALS ['database'] ['table_prefix'] = reqReq('dbpre');
            if(!empty($GLOBALS ['database'] ['table_prefix']))
            {
                if(substr($GLOBALS ['database'] ['table_prefix'], -1) != '_')
                {
                    $GLOBALS ['database'] ['table_prefix'] .= '_';
                }
            }
            
            $GLOBALS ['database'] ['manager'] = reqReq('manager');
            $GLOBALS ['database'] ['password'] = reqReq('password');
            $password_check = reqReq('password_check');

            
            if($GLOBALS ['database'] ['password'] !== $password_check)
            {
                $error = 1;
                $error_txt = $this->_getLang('no_same_adminpw');
                        
            }  else
            {
                $dbname = $GLOBALS ['database'] ['db_name'];
                $yl_manager = $GLOBALS ['database'] ['manager'];
                $yl_managerpw = md5($GLOBALS ['database'] ['password']);
                $tblpre = $GLOBALS ['database'] ['table_prefix'];
                
                if(!empty($type) && $type == 'rpw')
                {
                    $adir = reqReq('admindir');
                    app_db::select_db($dbname);
                    $sql = "UPDATE `{$tblpre}admin` SET `username`='$yl_manager',`password`='$yl_managerpw' WHERE `id` ='1'";

                    if (app_db::query($sql))
                    {
                        //跳转到成功页面
                        $this->render('step7',array('t'=>1,'adir'=>$adir));exit;
                    }  else
                    {
                            $error = 1;
                            $error_txt = $this->_getLang('no_do_database');
                    }

                }  else
                {
                    app_db::query("SET character_set_connection=gbk, character_set_results=gbk");
                    app_db::query("SET NAMES gbk");

                    /*
                    ppr($GLOBALS,1);
                    $opt['dbhost'] = reqReq('dbhost');
                    $opt['dbname'] = reqReq('dbname');
                    $opt['dbuser'] = reqReq('dbuser');
                    $opt['dbpw'] = reqReq('dbpw');
                    $opt['dbpre'] = reqReq('dbpre');
                    $opt['manager'] = reqReq('manager');
                    $opt['password'] = reqReq('password');
                    $opt['password_check'] = reqReq('password_check');
                    */

                    $error = 0;
                    $error_txt = '';

                    if ($GLOBALS ['database'] ['password'] != $password_check)
                    {
                        //管理员密码错误,显示
                        $this->render('step3',array('opt'=>$GLOBALS ['database'], 'error_password'=>1));
                    }

                    if (!app_db::select_db($dbname))
                    {
                        $error = 1;
                        $error_txt = $this->_getLang('no_database');
                    }  else
                    {
                        $tb1 = $GLOBALS ['database'] ['table_prefix'].'admin';
                        $tb2 = $GLOBALS ['database'] ['table_prefix'].'admin_group';
                        $tb3 = $GLOBALS ['database'] ['table_prefix'].'admin_logger';
                        $tb4 = $GLOBALS ['database'] ['table_prefix'].'catalog';
                        $tb5 = $GLOBALS ['database'] ['table_prefix'].'config';
                        $tb6 = $GLOBALS ['database'] ['table_prefix'].'links';

                        $sql = "SELECT count( TABLE_NAME ) c FROM `INFORMATION_SCHEMA`.`TABLES` where `TABLE_SCHEMA`='$dbname' AND (
                            `TABLE_NAME`='$tb1' OR 
                            `TABLE_NAME`='$tb2' OR 
                            `TABLE_NAME`='$tb3' OR 
                            `TABLE_NAME`='$tb4' OR 
                            `TABLE_NAME`='$tb5' OR 
                            `TABLE_NAME`='$tb6'
                            )";
//                        $sql = "SELECT count( TABLE_NAME ) c FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$dbname'";
                        app_db::query($sql);
                        $ar = app_db::fetch_one();
                        if(!empty($ar) && $ar['c']>0)
                        {
                            $error = 1;
                            $error_txt = $this->_getLang('no_empty_database');
                        }
                    }

                    $result = $check = $this->_showCopy($GLOBALS ['database']);

                    if ($result && is_array($result))
                    {
                        $check = 1;
                    }  else
                    {
                        $check = 0;
                    }

                    $installinfo = FALSE;
                    if (!$error)
                    {
                        $installsqlfile = YLMF_INSTALL . 'data/install.sql';

                        $sql = file_get_contents($installsqlfile);

                        $installinfo = $this->_creatTable($sql,$dbname,$yl_manager,$yl_managerpw,$tblpre);
                        if ($installinfo)
                        {
                            //写入超级管理员信息
                            $sql = "INSERT INTO `{$tblpre}admin` SET `id`='1',`username`='$yl_manager',`password`='$yl_managerpw',`realname`='administrator',`group_id`='1',`last_login_ip`='127.0.0.1'";
                            app_db::query($sql);
                        }  else
                        {
                            $error = 1;
                            $error_txt = $this->_getLang('donot_insert');
                        }

                    }
                }
            }
            
            $this->render('step5',array('error'=>$error,'error_txt'=>$error_txt,'installinfo'=>$installinfo,'check'=>$check));

        } elseif ($step == 6)
        {
            $this->render('step6');

        } elseif ($step == 7) //安装目录自删
        {
            @$this->_delDir(YLMF_INSTALL);
            //若成功删除,则跳转
            if (!file_exists(__FILE__))
            {
                header('Location: ../admin/index.php');
                echo "<script type='text/javascript'>window.location.href='../admin/index.php';</script>";
                exit;
            }
            //若未,则显示手动删除页面
            $this->render('step7');
        }
    }

    protected function _getLang($k=null)
    {

        $arr = lang::getLang($k);

        if (empty($k))
        {
            return $arr;
        }

        return $arr[$k];
    }
    
    protected function _showCopy($opt)
    {
        $dbhost = empty($opt['db_host']) ? null : $opt['db_host'];
        $dbname = empty($opt['db_name']) ? null : $opt['db_name'];
        $dbuser = empty($opt['db_user']) ? null : $opt['db_user'];
        $dbpw = empty($opt['db_pass']) ? null : $opt['db_pass'];
        $dbpre = empty($opt['table_prefix']) ? null : $opt['table_prefix'];
        $dbcharset = $this->dbcharset;

        $writetofile = <<<EOT
<?php
!defined('SITE_URL') && exit('Forbidden');
\$GLOBALS ['database'] ['db_host'] = '$dbhost';
\$GLOBALS ['database'] ['db_name'] = '$dbname';
\$GLOBALS ['database'] ['db_user'] = '$dbuser';
\$GLOBALS ['database'] ['db_pass'] = '$dbpw';
\$GLOBALS ['database'] ['db_charset'] = '$dbcharset';
\$GLOBALS ['database'] ['theme'] = 'default';
\$GLOBALS ['database'] ['table_prefix'] = '$dbpre';
?>
EOT;
        
        if (file_put_contents(APP_DB, $writetofile))
        {
            //保留
            $manager = empty($opt['manager']) ? null : $opt['manager'];
            $manager_pwd = empty($opt['password']) ? null : $opt['password'];;
            $manager_pwd = md5($manager_pwd);
            return array($manager,$manager_pwd,$dbname,$dbpre);
        }  else
        {
            return FALSE;
        }
    }
    

//目录权限检测,参照bage
    protected function _checkAttr($staticfolder)
    {
        $staticfolder = substr($staticfolder, 1);
        $error = 0;
        $result = array();
        if (file_exists('check_list.php'))
        {
            include('check_list.php');
            foreach ($check_list['dir_list'] as $name => $dir)
            {
                if (file_exists($dir))
                {
                    if (is_dir($dir) && is_writable($dir))
                    {
                        $result[] = array($name . ": " . $dir, 1);
                    } else
                    {
                        $error = 1;
                        $result[] = array($name . ": " . $dir, 2);
                    }
                } else
                {
                    if (@mkdir($dir, 0777, true))
                    {
                        $result[] = array($name . ": " . $dir, 1);
                    } else
                    {
                        $error = 1;
                        $result[] = array($name . ": " . $dir, 3);
                    }
                }
            }

            foreach ($check_list['file_list'] as $name => $file)
            {
                if (file_exists($file))
                {
                    if (is_writable($file))
                    {
                        $result[] = array($name . ": " . $file, 1);
                    } else
                    {
                        $error = 1;
                        $result[] = array($name . ": " . $file, 2);
                    }
                } else
                {
                    if (@touch($file))
                    {
                        $result[] = array($name . ": " . $file, 1);
                    } else
                    {
                        $error = 1;
                        $result[] = array($name . ": " . $file, 3);
                    }
                }
            }
        } else
        {
            
        }
        return array($error, $result);
    }

//导入表结果和数据
    protected function _creatTable($sql,$dbname,$yl_manager,$yl_managerpw,$tblpre)
    {

        $installinfo = '';
        $sql = str_replace("\r", '', $sql);
        $sql = $tblpre == 'ylmf_'?$sql:str_replace('ylmf_', $tblpre, $sql);
        $sqlarray = array();
        $sqlarray = explode(";\n", $sql);
//        ppr($sqlarray);
        app_db::select_db($dbname);
        foreach ($sqlarray as $key => $query)
        {
            if(empty($query)) {continue;}
            $query = trim(str_replace("\n", '', $query));

            if ($query && strpos($query, 'CREATE TABLE') !== false)
            {
                $c_name = trim(substr($query, 27, strpos($query, '(') - 27));
                $installinfo .= $this->_getLang('creat_table') . $c_name . ' ...' . $this->_getLang('success') . "\n";
                $extra1 = trim(substr(strrchr($query, ')'), 1));

                if (app_db::server_info() >= '4.1')
                {
                    $extra2 = "ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_chinese_ci;";
                } else
                {
                    $extra2 = 'TYPE=MyISAM;';
                }
                $query = str_replace($extra1, $extra2, $query);
            }

            app_db::query($query);

        }

        return $installinfo;
    }

//目录删除
    protected function _delDir($path)
    {
        if (file_exists($path))
        {
            if (is_file($path))
            {
                $this->_unLinkFile($path);
            } else
            {
                $handle = opendir($path);
                while ($file = readdir($handle))
                {
                    if (($file != ".") && ($file != "..") && ($file != ""))
                    {
                        if (is_dir("$path/$file"))
                        {
                            $this->_delDir("$path/$file");
                        } else
                        {
                            $this->_unLinkFile("$path/$file");
                        }
                    }
                }
                closedir($handle);
                rmdir($path);
            }
        }
    }

//文件删除
    protected function _unLinkFile($filename)
    {
        strpos($filename, '..') !== false && exit('Forbidden');
        return @unlink($filename);
    }
    
    public function actionResetpw()
    {
        $this->render('resetpw');
    }
}