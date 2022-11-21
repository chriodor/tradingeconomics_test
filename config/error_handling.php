<?php

//error_reporting(E_ALL & ~E_NOTICE);
set_error_handler("customError");
register_shutdown_function("fatal_handler");

function fatal_handler() {

    global $alapMainDir;
    $errfile = "unknown file";
    $errstr = "shutdown";
    $errno = E_CORE_ERROR;
    $errline = 0;

    $error = error_get_last();

    /* if ($error !== NULL) {
      $errno = $error["type"];
      $errfile = $error["file"];
      $errline = $error["line"];
      $errstr = $error["message"];

      $writeToLog = "!FATAL ERROR!";

      echo $writeToLog;
      if (function_exists("print_pr")) {
      print_pr($errstr);
      print_pr($error);
      } else {
      print_r($errstr);
      print_r($error);
      }

      if (!is_dir($alapMainDir . "logs/")) {
      mkdir($alapMainDir . "logs/");
      chmod($alapMainDir . "logs/", 0777);
      }


      $allContentsOfErrorThrown = file_get_contents($errfile);
      $contentLines = explode("\n", $allContentsOfErrorThrown);

      $lineConcrete = $contentLines[$errline - 1];

      $writeToLog = "--------------------\n";
      $writeToLog .= "---- " . today() . " ----\n";
      $writeToLog .= "--------------------\n";
      $writeToLog .= "\ntime = " . now();
      $writeToLog .= "\nerrno = $errno";
      $writeToLog .= "\nerrfile = $errfile";
      $writeToLog .= "\nerrline = $errline";
      $writeToLog .= "\nerrstr = $errstr";
      $writeToLog .= "\nline = $lineConcrete";
      $writeToLog .= "\n--------------------\n";
      $writeToLog .= "\n";


      $fileToWrite = str_replace("-", "_", $alapMainDir . "logs/" . today() . ".log");

      if (file_exists($fileToWrite)) {
      file_put_contents($fileToWrite, $writeToLog, FILE_APPEND);
      } else {
      file_put_contents($fileToWrite, $writeToLog);
      chmod($fileToWrite, 0777);
      }
      } */
}

function customError($errno, $errstr) {
    global $rootMainDir;

    $errorArr = array(
        E_ERROR => "Error",
        E_WARNING => "Warning",
        E_PARSE => "Parse",
        //E_NOTICE => "Notice",
        E_CORE_ERROR => "Core Error",
        E_CORE_WARNING => "Core Warning",
        E_COMPILE_ERROR => "Compile Error",
        E_COMPILE_WARNING => "Compile Warning",
        E_USER_ERROR => "User error",
        E_USER_WARNING => "User warning",
        E_USER_NOTICE => "User notice",
        E_STRICT => "Strict",
        E_DEPRECATED => "Deprecated",
        E_USER_DEPRECATED => "User deprecated",
        E_RECOVERABLE_ERROR => "Recoverable error",
        E_ALL => "All"
    );

    $bcktrc = debug_backtrace();

    //print_pr($bcktrc);
    //var_dump(isset($bcktrc["line"]));

    if (!empty($bcktrc)) {
        foreach ($bcktrc as $key => $value) {
            if (isset($value["line"])) {
                $file = str_replace($rootMainDir, "", $value["file"]) . "@" . $value["line"];

                //print_pr($value);
                /* if (is_array($value[0])) {
                  $file = "";
                  foreach (array_reverse($value) as $tra) {
                  $file .= str_replace($rootMainDir, "", $tra["file"]) . "@" . $tra["line"] . " -> "; //."<br>\n";
                  }
                  }
                 */
                if (isset($errorArr[$errno])) {


                    $errToShow = "<b>ERROR:</b> [{$errorArr[$errno]}] $errstr {$file}<br>";
                    if (function_exists("print_pr")) {
                        //print_pr($value);
                        //print_pr($errToShow);
                    } else {
                        //print_r($value);
                        //print_r($errToShow);
                    }
                }
            }
        }
    }
}

?>