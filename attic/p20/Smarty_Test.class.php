<?php

class Smarty_Test extends Smarty {

    function Smarty_Test() {
        $this->Smarty();
    }
   
    function test() {
        echo "testing start:<br />\n";
        echo "template_dir is '" . $this->template_dir . "'<br />\n";
        echo "real system path: " . realpath($this->template_dir) . "<br />\n";
        echo "file perms: " . substr(sprintf('%o', fileperms($this->template_dir)), -4) . "<br />\n";
        if(!file_exists($this->template_dir)) {
            echo "error: template_dir '" . $this->template_dir . "' does not exist.<br />\n";
        } elseif (!is_dir($this->template_dir)) {
            echo "error: template dir '" . $this->template_dir . "' is not a directory.<br />\n";           
        } elseif (!is_readable($this->template_dir)) {
            echo "error: template dir '" . $this->template_dir . "' is not readable.<br />\n";           
        } else {
            echo "OK.<br />\n";
        }
        echo "config_dir is '" . $this->config_dir . "'<br />\n";
        echo "real system path: " . realpath($this->config_dir) . "<br />\n";
        echo "file perms: " . substr(sprintf('%o', fileperms($this->config_dir)), -4) . "<br />\n";
        if(!file_exists($this->config_dir)) {
            echo "error: config_dir '" . $this->config_dir . "' does not exist.<br />\n";
        } elseif (!is_dir($this->config_dir)) {
            echo "error: config_dir '" . $this->config_dir . "' is not a directory.<br />\n";           
        } elseif (!is_readable($this->config_dir)) {
            echo "error: config_dir '" . $this->config_dir . "' is not readable.<br />\n";           
        } else {
            echo "OK.<br />\n";
        }
        foreach($this->plugins_dir as $_key => $_plugin_dir) {
            echo "plugins_dir ($_key) is '" . $_plugin_dir . "'<br />\n";
            echo "real system path: " . realpath($_plugin_dir) . "<br />\n";
           echo "file perms: " . substr(sprintf('%o', fileperms($_plugin_dir)), -4) . "<br />\n";
            if(!file_exists($_plugin_dir)) {
                echo "error: plugins_dir '" . $_plugin_dir . "' does not exist.<br />\n";
            } elseif (!is_dir($_plugin_dir)) {
                echo "error: plugins_dir '" . $_plugin_dir . "' is not a directory.<br />\n";           
            } elseif (!is_readable($_plugin_dir)) {
                echo "error: plugins_dir '" . $_plugin_dir . "' is not readable.<br />\n"; 
            } else {
                echo "OK.<br />\n";
            }
        }
        echo "compile_dir is '" . $this->compile_dir . "'<br />\n";
        echo "real system path: " . realpath($this->compile_dir) . "<br />\n";
        echo "file perms: " . substr(sprintf('%o', fileperms($this->compile_dir)), -4) . "<br />\n";
        if(!file_exists($this->compile_dir)) {
            echo "error: compile_dir '" . $this->compile_dir . "' does not exist.<br />\n";
        } elseif (!is_dir($this->compile_dir)) {
            echo "error: compile_dir '" . $this->compile_dir . "' is not a directory.<br />\n";           
        } elseif (!is_readable($this->compile_dir)) {
            echo "error: compile_dir '" . $this->compile_dir . "' is not readable.<br />\n";           
        } elseif (!is_writable($this->compile_dir)) {
            echo "error: compile_dir '" . $this->compile_dir . "' is not writable.<br />\n";           
        } else {
            $_test_file = $this->compile_dir . '/test_file';
            if(($_fp = fopen($_test_file, 'w')) !== false) {
                if(!fwrite($_fp,'test')) {
                    echo "error: unable to write to $_test_file<br />\n";
                } else {
                    unlink($_test_file);
                    fclose($_fp);
                    echo "OK.<br />\n";
                }
            } else {
                echo "error: unable to open $_test_file<br />\n";   
            }
        }
        echo "cache_dir is '" . $this->cache_dir . "'<br />\n";
        echo "real system path: " . realpath($this->cache_dir) . "<br />\n";
        echo "file perms: " . substr(sprintf('%o', fileperms($this->cache_dir)), -4) . "<br />\n";
        if(!file_exists($this->cache_dir)) {
            echo "error: cache_dir '" . $this->cache_dir . "' does not exist.<br />\n";
        } elseif (!is_dir($this->cache_dir)) {
            echo "error: cache_dir '" . $this->cache_dir . "' is not a directory.<br />\n";           
        } elseif (!is_readable($this->cache_dir)) {
            echo "error: cache_dir '" . $this->cache_dir . "' is not readable.<br />\n";           
        } elseif (!is_writable($this->cache_dir)) {
            echo "error: cache_dir '" . $this->cache_dir . "' is not writable.<br />\n";           
        } else {
            $_test_file = $this->cache_dir . '/test_file';
            if(($_fp = fopen($_test_file, 'w')) !== false) {
                if(!fwrite($_fp,'test')) {
                    echo "error: unable to write to $_test_file<br />\n";
                } else {
                    fclose($_fp);
                    unlink($_test_file);
                    echo "OK.<br />\n";
                }
            } else {
                echo "error: unable to open $_test_file<br />\n";   
            }
        }
        echo "testing complete.<br />\n";
    }
}
