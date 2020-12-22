<?php
$ftp_server = "ftphost";
$ftp_user = "ftpuser";
$ftp_password = "ftppassword";
$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
$login = ftp_login($ftp_conn, $ftp_user, $ftp_password);


$result_string = '';
//$ftpdir = date('mdY');
$ftpdir = 'temp_upload';
// try to create directory $dir
if (ftp_mkdir($ftp_conn, $ftpdir)){
    echo "Successfully created $dir";
    $locdir = 'upload';
    $dh  = opendir($locdir);
    while (false !== ($filename = readdir($dh))) {
        $files[] = $filename;
    }
    sort($files);

    //dd($files);
    foreach($files as $file){
      if($file === '.' || $file === '..') {continue;}
      //dd($file);
      //$source = $dir.'/'.$file;
      $source = $locdir.'/'.$file;
      $dest = $ftpdir.'/'.$file;
      //$upload = ftp_put($ftp_conn, $dest, $source, $mode);
      $upload = ftp_put($ftp_conn, $dest, $source, FTP_BINARY);
      echo '<pre>'; var_dump($upload);
      //dd('done 1');
      $result_string .= "$file \n";
      //dd($file);
    }
}else{
  $result_string = "Error while creating $ftpdir \n";
}

// close connection
ftp_close($ftp_conn);
