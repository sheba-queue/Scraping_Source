<?php

//http://stackoverflow.com/questions/15398757/simplest-way-to-implement-an-email-parser-to-scrape-info-from-attachment

/* IMAP FUNCTIONS TO USE
imap_open
imap_num_msg
imap_fetchbody
imap_search
imap_setflag_full
imap_qprint
*/

/* Credential for mail */
$hostname = '{imp_of_host:993/imap/ssl}INBOX';
$username = 'your_mail';
$password = 'password';

/* try to connect */
$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Email: ' . imap_last_error());

/* grab UNSEEN emails */
$emails = imap_search($inbox,'UNSEEN');

if(sizeof($emails) > 1){
    // DEBUG PURPOSE
    // $body = imap_qprint(imap_fetchbody($inbox, $emails[0], 1));
    // echo $body;
    // exit;

  //  foreach($emails as $email){
        // FT_PEEK helps to msg remain UNSEEN
        $body = imap_qprint(imap_fetchbody($inbox, $emails[0], 1, FT_PEEK)); // GETTING MSG BODY
     
        $patt_name = "@Hi (.*?),@";
        $patt_username = "@NAME: (\d+)?@";
        $patt_access= "@CESS: (\d+)?@";
        $patt_date = "@ate: (.+?)<@";
        $patt_order = "@ber: (\d+?)<@";
        $patt_total = "@tal: (.+?)<@";
        $patt_payment = "@via (.+?)<@";
        $patt_email = "@ail: (.+?)<@";

        echo get_words($patt_name, $body)."\n";
        echo get_words($patt_username, $body)."\n";
        echo get_words($patt_access, $body)."\n";
        echo get_words($patt_date, $body)."\n";
        echo get_words($patt_order, $body)."\n";
        echo get_words($patt_total, $body)."\n";
        echo get_words($patt_payment, $body)."\n";
        echo get_words($patt_email, $body)."\n";

        echo "\n";
 
 //   }
}else{
    echo "No UNSEEN Message";
}
exit;


/* close the connection */
imap_close($inbox);


function get_words($pattern, $string){

    preg_match($pattern, $string, $match);
    $data = $match[1];

    return $data;
}
