<?php 
/**
 * Get date in RFC3339
 * For example used in XML/Atom
 * 
 * @link http://stackoverflow.com/questions/5671433/php-time-to-google-calendar-dates-time-format
 * 
 * @param integer $timestamp
 * @return string date in RFC3339
 * @author Boris Korobkov
 */
function date3339($timestamp=0) {

    if (!$timestamp) {
        $timestamp = time();
    }
    $date = date('Y-m-d\TH:i:s', $timestamp);

    $matches = array();
    if (preg_match('/^([\-+])(\d{2})(\d{2})$/', date('O', $timestamp), $matches)) {
        $date .= $matches[1].$matches[2].':'.$matches[3];
    } else {
        $date .= 'Z';
    }
    return $date;
}

/**
 * Generate a hash of password string.
 * 
 * For user security, all system passwords are stored in hash string into the database. Use
 * this method to produce the hashed password. 
 * 
 * @param string $salt Salt value for current user. This value is stored on the database and 
 * is used when generating the password hash.
 * @param string $password Given string password.
 * @return string Returns the hash string of the given password.
 */
function hash_password($salt, $password) {
    $half = (int)(strlen($salt) / 2);
    $hash = hash('sha256', substr($salt, 0, $half ) . $password . substr($salt, $half));
    
    for ($i = 0; $i < 100000; $i++) {
        $hash = hash('sha256', $hash);
    } 
    
    return $hash; // @task include salt and hash more times.
}

/**
 * Generate a new password salt.
 * 
 * This method will not check if the salt is unique in database. This must be done 
 * from the calling procedure.
 * 
 * @return string Returns a salt string.
 */
function generate_salt() {
    $max_length = 100;
    $salt = hash('sha256', (uniqid(rand(), true)));
    return substr($salt, 0, $max_length);
}

/* End of file general_helper.php */
/* Location: ./application/helpers/general_helper.php */