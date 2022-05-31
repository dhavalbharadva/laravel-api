<?php

namespace App\Helpers;

use Image;

class Common {

    /**
     * truncate a string provided by the maximum limit without breaking a word
     * @author Dhaval Bharadva
     * @param string $str
     * @param integer $maxlen
     * @return string
     */
    public static function shorteningString($str, $maxlen) {
        if (strlen($str) <= $maxlen)
            return $str;
        $newstr = substr($str, 0, $maxlen);
        if (substr($newstr, -1, 1) != ' ')
            $newstr = substr($newstr, 0, strrpos($newstr, " "));
        return $newstr . ' ...';
    }

    /**
     * apply base64 first and then reverse the string
     * @author Dhaval Bharadva
     * @param string $str
     * @return endcoded string
     */
    public static function encode5t($str) {
        for ($i = 0; $i < 6; $i++) {
            $str = strrev(base64_encode($str));
        }
        return $str;
    }

    /**
     * reverse the string first and then apply base64
     * @author Dhaval Bharadva
     * @param string $str
     * @return decoded string
     */
    public static function decode5t($str) {
        for ($i = 0; $i < 6; $i++) {
            $str = base64_decode(strrev($str));
        }
        return $str;
    }

    /**
     * generate random string by given length
     * @author Dhaval Bharadva
     * @param string $length
     * @return string
     */
    public static function generateRandomString($length = 10) {

        return strtoupper(substr(str_shuffle(MD5(microtime())), 0, $length));

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    /* author: Dhaval Bharadva
     * description: upload image to folder
     * return: filename if uploaded false otherwise
     */

    public static function upload_image($field_name, $uploadTo, $filename = '') {
        if (isset($_FILES[$field_name]) && $_FILES[$field_name]['name'] != "") {
            $filenameOrg = $_FILES[$field_name]['name'];
            $extArray = explode('.', $filenameOrg);
            $ext = end($extArray);
            //$filename = date('YmdHis') . uniqid() . '.' . $ext;
            if ($filename == "") {
                $filename = self::generateRandomString() . '.' . $ext;
            } else {
                $filename = $filename . '.' . $ext;
            }
            $target_image = $uploadTo . $filename;
            chmod($uploadTo, 0777);
            $uploadimage = move_uploaded_file($_FILES[$field_name]['tmp_name'], $target_image);
            if ($uploadimage) {
                return $filename;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function priceFormatDecimal($price) {
        return number_format($price, 2, '.', ',');
    }

    public static function priceFormatNoDecimal($price) {
        return number_format($price, 0, '.', ',');
    }

    /**
     * check credit card expire month year
     * @author Dhaval Bharadva
     * @param string $month $year
     * @return boolean
     */
    public static function check_exp_date($month, $year) {
        /* Get timestamp of midnight on day after expiration month. */
        $exp_ts = mktime(0, 0, 0, $month + 1, 1, $year);
        $cur_ts = time();
        /* Don't validate for dates more than 10 years in future. */
        $max_ts = $cur_ts + (10 * 365 * 24 * 60 * 60);

        if ($exp_ts > $cur_ts && $exp_ts < $max_ts) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Format phone number to us format
     * @author Dhaval Bharadva
     * @param string $phone
     * @return $phone with format
     */
    public static function format_phone_us($phone) {
        // note: making sure we have something
        if (!isset($phone{3})) {
            return '';
        }
        // note: strip out everything but numbers 
        $phone = preg_replace("/[^0-9]/", "", $phone);
        $length = strlen($phone);
        switch ($length) {
            case 7:
                return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
                break;
            case 10:
                return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "$1-$2-$3", $phone);
                break;
            case 11:
                return preg_replace("/([0-9]{1})([0-9]{3})([0-9]{3})([0-9]{4})/", "$1($2) $3-$4", $phone);
                break;
            default:
                return $phone;
                break;
        }
    }

    /**
     * Add http to url if not found
     * @author Dhaval Bharadva
     * @param string $url
     * @return url with http or https
     */
    public static function addScheme($url, $scheme = 'http://') {
        return parse_url($url, PHP_URL_SCHEME) === null ? $scheme . $url : $url;
    }

    /**
     * Add www to url if not found
     * @author Dhaval Bharadva
     * @param string $url
     * @return url with www
     */
    public static function addWWW($url, $search = '://', $insert = 'www.') {
        $index = strpos($url, $search);
        if ($index === false) {
            return $url;
        }
        if (strpos($url, $insert) == false) {
            return substr_replace($url, $search . $insert, $index, strlen($search));
        } else {
            return $url;
        }
    }

    /**
     * Add slash at end of url
     * @author Dhaval Bharadva
     * @param string $url
     * @return url with slash at end of url
     */
    public static function addTrailSlash($url) {
        if (SUBSTR($url, -1) != '/') {
            return $url.= '/';
        } else {
            return $url;
        }
    }

    /**
     * To make a directory
     * @path as string, @permission as string 
     * @access public
     */
    public static function makeDirectory($path, $permission = 0777) {
        if (!is_dir($path)){
            mkdir($path);
            chmod($path, $permission);
        }
    }

    //to remove the directory
    public static function rmdirectory($path) {
        $dir = opendir($path);
        while ($entry = readdir($dir)) {
            if (is_file("$path/$entry")) {
                unlink($path . '/' . $entry);
            } elseif (is_dir("$path/$entry") && $entry != '.' && $entry != '..') {
                self::rmdirectory("$path/$entry");
            }
        }
        closedir($dir);
        return rmdir($path);
    }

    /**
     * remove particular file
     */
    public static function rmFile($path) {
        if (file_exists($path))
            unlink($path);
    }

    /**
     * Get slug of string
     * 
     * @access public
     * @author HARDEEP PANDYA (Dhaval Bharadva)
     * @param $text (string)
     * @param $append (string) string to append
     * @return string
     * 
     */
    public static function getSlug($text, $append = '') {
        // replace all non letters by _
        $text = preg_replace('/\W+/', '-', $text);

        // trim and lowercase
        $text = strtolower(trim($text, '-'));

        $text = $text . $append;

        return $text;
    }

    /**
     * Create thumbnail of image and upload to specified folder.
     * 
     * @author Dhaval
     * @param  string $sourceFile, string $destinationFile, int $width, int $height
     * @return Boolean true
     */
    public static function createThumb($sourceFile, $destinationFile, $width, $height) {
        // create new image with transparent background color
        $background = Image::canvas($width, $height);
        // read image file and resize it
        // but keep aspect-ratio and do not size up,
        // so smaller sizes don't stretch
        $image = Image::make($sourceFile)->resize($width, $height, function ($c) {
            $c->aspectRatio();
            $c->upsize();
        });
        // insert resized image centered into background
        $background->insert($image, 'center');
        // save
        $background->save($destinationFile);
        return true;
    }

    /**
     * Add watermark to image
     * @param $source_img & $dest_img
     * @return image with watermark
     * @access public
     * @author Dhaval Bharadva
     */
    public static function image_watermark($source_img, $dest_img) {
        // Load the stamp and the photo to apply the watermark to
        $logo = PROPERTY_IMAGE_PATH . '/logo.png';
        $stamp = imagecreatefrompng($logo);
        list($source_width, $source_height, $source_type) = getimagesize($source_img);
        switch ($source_type) {
            case IMAGETYPE_GIF:
                $im = imagecreatefromgif($source_img);
                break;
            case IMAGETYPE_JPEG:
                $im = imagecreatefromjpeg($source_img);
                break;
            case IMAGETYPE_PNG:
                $im = imagecreatefrompng($source_img);
                break;
        }

        // Set the margins for the stamp and get the height/width of the stamp image
        $marge_right = 10;
        $marge_bottom = 10;
        $sx = imagesx($stamp);
        $sy = imagesy($stamp);

        $imgx = imagesx($im);
        $imgy = imagesy($im);

        $centerX = ($imgx / 2) - ($sx / 2); // For centering the watermark on any image
        $centerY = ($imgy / 2) - ($sy / 2); // For centering the watermark on any image
        // Copy the stamp image onto our photo using the margin offsets and the photo 
        // width to calculate positioning of the stamp.
        imagecopy($im, $stamp, $centerX, $centerY, 0, 0, imagesx($stamp), imagesy($stamp));

        // Output and free memory
        //header('Content-type: image/png');
        switch ($source_type) {
            case IMAGETYPE_GIF:
                imagegif($im, $dest_img);
                break;
            case IMAGETYPE_JPEG:
                imagejpeg($im, $dest_img);
                break;
            case IMAGETYPE_PNG:
                imagepng($im, $dest_img);
                break;
        }
        imagedestroy($im);
        return true;
    }

    /**
     * Roate image clockwise
     * 
     * @param string $file
     * @param string $fileThumb
     * @param string $$fileOrg
     * @return boolean
     * @access public
     * @author Dhaval Bharadva
     */
    public static function image_rotate($file, $fileThumb, $fileOrg) {

        $degrees = -90;

        //main image
        list($width, $height, $type, $attr) = getimagesize($file);
        if ($type == IMAGETYPE_JPEG) {
            $source = imagecreatefromjpeg($file);
        } elseif ($type == IMAGETYPE_PNG) {
            $source = imagecreatefrompng($file);
        }
        $rotate = imagerotate($source, $degrees, 0);
        if ($type == IMAGETYPE_JPEG) {
            imagejpeg($rotate, $file);
        } elseif ($type == IMAGETYPE_PNG) {
            imagepng($rotate, $file);
        }
        imagedestroy($source);
        imagedestroy($rotate);

        //thumbnail
        if($fileThumb){
            list($width, $height, $type, $attr) = getimagesize($fileThumb);
            if ($type == IMAGETYPE_JPEG) {
                $sourceThumb = imagecreatefromjpeg($fileThumb);
            } elseif ($type == IMAGETYPE_PNG) {
                $sourceThumb = imagecreatefrompng($fileThumb);
            }
            $rotateThumb = imagerotate($sourceThumb, $degrees, 0);
            if ($type == IMAGETYPE_JPEG) {
                imagejpeg($rotateThumb, $fileThumb);
            } elseif ($type == IMAGETYPE_PNG) {
                imagepng($rotateThumb, $fileThumb);
            }
            imagedestroy($sourceThumb);
            imagedestroy($rotateThumb);
        }

        //original
        list($width, $height, $type, $attr) = getimagesize($file);
        if ($type == IMAGETYPE_JPEG) {
            $sourceOrg = imagecreatefromjpeg($fileOrg);
        } elseif ($type == IMAGETYPE_PNG) {
            $sourceOrg = imagecreatefrompng($fileOrg);
        }
        $rotateOrg = imagerotate($sourceOrg, $degrees, 0);
        if ($type == IMAGETYPE_JPEG) {
            imagejpeg($rotateOrg, $fileOrg);
        } elseif ($type == IMAGETYPE_PNG) {
            imagepng($rotateOrg, $fileOrg);
        }
        imagedestroy($sourceOrg);
        imagedestroy($rotateOrg);

        return true;
    }

    /**
     * remove all whitespace from string
     * @param $string
     * @return $string without whitespace
     * @access public
     * @author Dhaval Bharadva
     */
    public static function removeSpace($string) {
        return preg_replace('/\s+/', '', $string);
    }

    /**
     * Price format like 250k,275k,300k,352k,400k,500k,600k,800k,1Mil,2Mil,4Mil+
     * @param $price
     * @return $price with specified format
     * @access public
     * @author Dhaval Bharadva
     */
    public static function thousandsCurrencyFormat($num) {
        if ($num < 1000) {
            return $num;
        }
        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array('k', 'Mil', 'b', 't');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];
        return $x_display;
    }

    /**
     * copy all directories recursively from source to destination
     * @param $source folder path
     * @param $destination folder path
     * @return true
     * @access public
     * @author Dhaval Bharadva
     */
    public static function copyRecursive($src, $dst) {
        if (!file_exists($src)) {
            return true;
        }
        $dir = opendir($src);
        @mkdir($dst);
        chmod($dst, 0777);
        while (false !== ( $file = readdir($dir))) {
            if ($file != '.' && $file != '..') {
                if (is_dir($src . '/' . $file)) {
                    self::copyRecursive($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
        return true;
    }
    
    /**
     * Send sms from click a tell
     * @param $url (string)
     * @return boolean
     * @access public
     * @author Dhaval Bharadva
     */
    public static function sendSms($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    /**
     * get list of all the modules and its operation in array.
     * 
     * @author Dhaval
     * @param  
     * @return array
     */
    public static function getModules() {
        $moduleList = array();
        $moduleArray = array();

        $moduleArray['label'] = 'Area';
        $moduleArray['name'] = 'area';
        $moduleArray['area'][] = 'status';
        $moduleArray['area'][] = 'add';
        $moduleArray['area'][] = 'edit';
        $moduleArray['area'][] = 'delete';
        $moduleList[] = $moduleArray;

        $moduleArray['label'] = 'Location';
        $moduleArray['name'] = 'location';
        $moduleArray['location'][] = 'status';
        $moduleArray['location'][] = 'add';
        $moduleArray['location'][] = 'edit';
        $moduleArray['location'][] = 'delete';
        unset($moduleArray['area']);
        $moduleList[] = $moduleArray;

        $moduleArray['label'] = 'Metadata';
        $moduleArray['name'] = 'metadata';
        $moduleArray['metadata'][] = 'add';
        $moduleArray['metadata'][] = 'edit';
        $moduleArray['metadata'][] = 'delete';
        unset($moduleArray['location']);
        $moduleList[] = $moduleArray;

        $moduleArray['label'] = 'Export';
        $moduleArray['name'] = 'export';
        unset($moduleArray['metadata']);
        $moduleList[] = $moduleArray;

        $moduleArray['label'] = 'Blog';
        $moduleArray['name'] = 'blog';
        $moduleArray['blog'][] = 'status';
        $moduleArray['blog'][] = 'add';
        $moduleArray['blog'][] = 'edit';
        $moduleArray['blog'][] = 'delete';
        $moduleList[] = $moduleArray;

        $moduleArray['label'] = 'Ip Whitelist';
        $moduleArray['name'] = 'ipwhitelist';
        $moduleArray['ipwhitelist'][] = 'status';
        $moduleArray['ipwhitelist'][] = 'add';
        $moduleArray['ipwhitelist'][] = 'edit';
        $moduleArray['ipwhitelist'][] = 'delete';
        unset($moduleArray['blog']);
        $moduleList[] = $moduleArray;

        $moduleArray['label'] = 'Competitor';
        $moduleArray['name'] = 'competitor';
        $moduleArray['competitor'][] = 'status';
        $moduleArray['competitor'][] = 'add';
        $moduleArray['competitor'][] = 'edit';
        $moduleArray['competitor'][] = 'delete';
        unset($moduleArray['ipwhitelist']);
        $moduleList[] = $moduleArray;

        $moduleArray['label'] = 'Audit Trail';
        $moduleArray['name'] = 'audittrail';
        unset($moduleArray['competitor']);
        $moduleList[] = $moduleArray;
        
        $moduleArray['label'] = 'Subscriber';
        $moduleArray['name'] = 'subscriber';
        $moduleList[] = $moduleArray;
        
        $moduleArray['label'] = 'Report';
        $moduleArray['name'] = 'report';
        $moduleArray['report'][] = 'competitor_report';
        $moduleArray['report'][] = 'transaction_report';
        $moduleArray['report'][] = 'hot_client_report';
        $moduleArray['report'][] = 'performance_report';
        $moduleList[] = $moduleArray;

        $moduleArray['label'] = 'Property';
        $moduleArray['name'] = 'property';
        $moduleArray['property'][] = 'status';
        $moduleArray['property'][] = 'add';
        $moduleArray['property'][] = 'edit';
        $moduleArray['property'][] = 'delete';
        $moduleArray['property'][] = 'match';
        $moduleArray['property'][] = 'do_not_call';
        $moduleArray['property'][] = 'print';
        //$moduleArray['property'][] = 'market';
        $moduleArray['property'][] = 'sold_available';
        $moduleArray['property'][] = 'off_the_market';
        $moduleArray['property'][] = 'clone';
        $moduleArray['property'][] = 'log';
        $moduleArray['property'][] = 'avail_date_confirm';
        $moduleArray['property'][] = 'exclusive';
        $moduleArray['property'][] = 'approve';
        $moduleArray['property'][] = 'decline';
        unset($moduleArray['report']);
        $moduleList[] = $moduleArray;

        $moduleArray['label'] = 'Property Owner';
        $moduleArray['name'] = 'propertyowner';
        $moduleArray['propertyowner'][] = 'status';
        $moduleArray['propertyowner'][] = 'add';
        $moduleArray['propertyowner'][] = 'edit';
        $moduleArray['propertyowner'][] = 'delete';
        $moduleArray['propertyowner'][] = 'change_password';
        $moduleArray['propertyowner'][] = 'vatable';
        $moduleArray['propertyowner'][] = 'block_unblock';
        unset($moduleArray['property']);
        $moduleList[] = $moduleArray;

        $moduleArray['label'] = 'Features';
        $moduleArray['name'] = 'features';
        $moduleArray['features'][] = 'status';
        $moduleArray['features'][] = 'add';
        $moduleArray['features'][] = 'edit';
        $moduleArray['features'][] = 'delete';
        unset($moduleArray['propertyowner']);
        $moduleList[] = $moduleArray;

        $moduleArray['label'] = 'Property Type';
        $moduleArray['name'] = 'propertytype';
        $moduleArray['propertytype'][] = 'status';
        $moduleArray['propertytype'][] = 'add';
        $moduleArray['propertytype'][] = 'edit';
        $moduleArray['propertytype'][] = 'delete';
        unset($moduleArray['features']);
        $moduleList[] = $moduleArray;

        $moduleArray['label'] = 'Price Range';
        $moduleArray['name'] = 'pricerange';
        $moduleArray['pricerange'][] = 'add';
        $moduleArray['pricerange'][] = 'edit';
        $moduleArray['pricerange'][] = 'delete';
        unset($moduleArray['propertytype']);
        $moduleList[] = $moduleArray;

        $moduleArray['label'] = 'Enquiries With Coupons';
        $moduleArray['name'] = 'client';
        $moduleArray['client'][] = 'add';
        $moduleArray['client'][] = 'edit';
        unset($moduleArray['pricerange']);
        $moduleList[] = $moduleArray;

        $moduleArray['label'] = 'Enquiries Without Coupons';
        $moduleArray['name'] = 'inquiry';
        unset($moduleArray['client']);
        $moduleList[] = $moduleArray;

        $moduleArray['label'] = 'Search';
        $moduleArray['name'] = 'search';
        $moduleList[] = $moduleArray;

        $moduleArray['label'] = 'Virtual Agent';
        $moduleArray['name'] = 'couponholder';
        $moduleArray['couponholder'][] = 'status';
        $moduleArray['couponholder'][] = 'add';
        $moduleArray['couponholder'][] = 'edit';
        $moduleArray['couponholder'][] = 'delete';
        $moduleArray['couponholder'][] = 'login';
        $moduleArray['couponholder'][] = 'reset';
        $moduleList[] = $moduleArray;

        $moduleArray['label'] = 'VA Enquiries';
        $moduleArray['name'] = 'vaenquiry';
        $moduleArray['vaenquiry'][] = 'pending';
        $moduleArray['vaenquiry'][] = 'listed';
        $moduleArray['vaenquiry'][] = 'declined';
        $moduleArray['vaenquiry'][] = 'callback';
        $moduleArray['vaenquiry'][] = 'commercial';
        $moduleArray['vaenquiry'][] = 'free';
        unset($moduleArray['couponholder']);
        $moduleList[] = $moduleArray;

        $moduleArray['label'] = 'Client VA Enquiries';
        $moduleArray['name'] = 'clientvaenquiry';
        $moduleArray['clientvaenquiry'][] = 'pending';
        $moduleArray['clientvaenquiry'][] = 'listed';
        $moduleArray['clientvaenquiry'][] = 'declined';
        $moduleArray['clientvaenquiry'][] = 'callback';
        $moduleArray['clientvaenquiry'][] = 'commercial';
        $moduleArray['clientvaenquiry'][] = 'free';
        unset($moduleArray['vaenquiry']);
        $moduleList[] = $moduleArray;

        $moduleArray['label'] = 'Transaction';
        $moduleArray['name'] = 'transaction';
        $moduleArray['transaction'][] = 'add';
        $moduleArray['transaction'][] = 'edit';
        $moduleArray['transaction'][] = 'delete';
        $moduleArray['transaction'][] = 'reset';
        unset($moduleArray['clientvaenquiry']);
        $moduleList[] = $moduleArray;

        $moduleArray['label'] = 'Commission';
        $moduleArray['name'] = 'commission';
        $moduleArray['commission'][] = 'paid';
        $moduleArray['commission'][] = 'nt_nc';
        $moduleArray['commission'][] = 'cancel';
        unset($moduleArray['transaction']);
        $moduleList[] = $moduleArray;

        $moduleArray['label'] = 'Staff';
        $moduleArray['name'] = 'staff';
        $moduleArray['staff'][] = 'status';
        $moduleArray['staff'][] = 'add';
        $moduleArray['staff'][] = 'edit';
        $moduleArray['staff'][] = 'delete';
        $moduleArray['staff'][] = 'ip_restriction';
        $moduleArray['staff'][] = 'auto_suspend';
        $moduleArray['staff'][] = 'reset_password';
        $moduleArray['staff'][] = 'client_max_limit';
        $moduleArray['staff'][] = 'client_block_limit';
        $moduleArray['staff'][] = 'resign';
        $moduleArray['staff'][] = 'approve';
        unset($moduleArray['commission']);
        $moduleList[] = $moduleArray;

        $moduleArray['label'] = 'Branch';
        $moduleArray['name'] = 'branch';
        $moduleArray['branch'][] = 'status';
        $moduleArray['branch'][] = 'add';
        $moduleArray['branch'][] = 'edit';
        $moduleArray['branch'][] = 'delete';
        $moduleArray['branch'][] = 'resign';
        unset($moduleArray['staff']);
        $moduleList[] = $moduleArray;

        $moduleArray['label'] = 'Performance';
        $moduleArray['name'] = 'performance';
        unset($moduleArray['branch']);
        $moduleList[] = $moduleArray;

        $moduleArray['label'] = 'Clients List';
        $moduleArray['name'] = 'clients';
        $moduleArray['clients'][] = 'add';
        $moduleArray['clients'][] = 'edit';
        $moduleArray['clients'][] = 'delete';
        $moduleArray['clients'][] = 'declined';
        $moduleArray['clients'][] = 'rented';
        $moduleArray['clients'][] = 'free';
        $moduleArray['clients'][] = 'match';
        $moduleArray['clients'][] = 'block_unblock';
        $moduleArray['clients'][] = 'commercial';
        $moduleList[] = $moduleArray;

        $moduleArray['label'] = 'Pagemanagement';
        $moduleArray['name'] = 'pagemanagement';
        unset($moduleArray['clients']);
        $moduleList[] = $moduleArray;
        
        $moduleArray['label'] = 'Quick Price';
        $moduleArray['name'] = 'quickprice';
        $moduleArray['quickprice'][] = 'status';
        $moduleArray['quickprice'][] = 'add';
        $moduleArray['quickprice'][] = 'edit';
        $moduleArray['quickprice'][] = 'delete';
        $moduleList[] = $moduleArray;

        $moduleArray['label'] = 'Bugs And Updates';
        $moduleArray['name'] = 'updates';
        $moduleArray['updates'][] = 'add';
        $moduleArray['updates'][] = 'edit';
        $moduleArray['updates'][] = 'delete';
        unset($moduleArray['quickprice']);
        $moduleList[] = $moduleArray;

        $moduleArray['label'] = 'Academy';
        $moduleArray['name'] = 'academy';
        $moduleArray['academy'][] = 'view';
        $moduleArray['academy'][] = 'add';
        $moduleArray['academy'][] = 'edit';
        $moduleArray['academy'][] = 'delete';
        unset($moduleArray['updates']);
        $moduleList[] = $moduleArray;
        
        $moduleArray['label'] = 'Quality Control';
        $moduleArray['name'] = 'qualitycontrol';
        $moduleArray['qualitycontrol'][] = 'status';
        $moduleArray['qualitycontrol'][] = 'add';
        $moduleArray['qualitycontrol'][] = 'edit';
        $moduleArray['qualitycontrol'][] = 'delete';
        unset($moduleArray['academy']);
        $moduleList[] = $moduleArray;
        
        $moduleArray['label'] = 'Policy & Procedure';
        $moduleArray['name'] = 'policy';
        $moduleArray['policy'][] = 'status';
        $moduleArray['policy'][] = 'add';
        $moduleArray['policy'][] = 'edit';
        $moduleArray['policy'][] = 'delete';
        unset($moduleArray['qualitycontrol']);
        $moduleList[] = $moduleArray;
        
        $moduleArray['label'] = 'PxGuide';
        $moduleArray['name'] = 'pxguide';
        $moduleArray['pxguide'][] = 'status';
        $moduleArray['pxguide'][] = 'add';
        $moduleArray['pxguide'][] = 'edit';
        $moduleArray['pxguide'][] = 'delete';
        unset($moduleArray['policy']);
        $moduleList[] = $moduleArray;
        
        $moduleArray['label'] = 'KYC';
        $moduleArray['name'] = 'kyc';
        $moduleArray['kyc'][] = 'view';
        $moduleArray['kyc'][] = 'add';
        $moduleArray['kyc'][] = 'edit';
        $moduleArray['kyc'][] = 'delete';
        unset($moduleArray['pxguide']);
        $moduleList[] = $moduleArray;
        
        $moduleArray['label'] = 'Franchise Owner';
        $moduleArray['name'] = 'franchiseowner';
        $moduleArray['franchiseowner'][] = 'view';
        $moduleArray['franchiseowner'][] = 'add';
        $moduleArray['franchiseowner'][] = 'edit';
        $moduleArray['franchiseowner'][] = 'delete';
        unset($moduleArray['kyc']);
        $moduleList[] = $moduleArray;

        $moduleArray['label'] = 'Complaint';
        $moduleArray['name'] = 'complaint';
        
        unset($moduleArray['franchiseowner']);
        $moduleList[] = $moduleArray;
        
        $moduleArray['label'] = 'Dashboard';
        $moduleArray['name'] = 'dashboard';
        $moduleList[] = $moduleArray;

        return $moduleList;
    }

    public static function permission($moduleName) {
        $permission = array();
        $statusPms = '';
        $editPms = '';
        $deletePms = '';
        if (session('ROLE') != "admin") {
            $modPms = \App\Http\Controllers\Admin\PermissionController::getModulePermissionByName(session('ADMIN_USER_ID'), $moduleName);
            if ($modPms) {
                $pmsObj = \App\Http\Controllers\Admin\PermissionController::getOperationPermissionByStaff($modPms->id);

                $optArray = array();
                if ($pmsObj) {
                    foreach ($pmsObj as $key => $value) {
                        $optArray[] = $value->name;
                    }
                }

                $permission['statusPms'] = in_array('status', $optArray) ? 1 : 0;
                $permission['addPms'] = in_array('add', $optArray) ? 1 : 0;
                $permission['editPms'] = in_array('edit', $optArray) ? 1 : 0;
                $permission['deletePms'] = in_array('delete', $optArray) ? 1 : 0;
                
            } 
        } else {
            $permission['statusPms'] = 1;
            $permission['addPms'] = 1;
            $permission['editPms'] = 1;
            $permission['deletePms'] = 1;
            $permission['viewPms'] = 1 ;
        }

        return $permission;
    }
    
    /**
     * generate vimeo embed url from video URL
     * @author Dhaval Bharadva
     * @param string $url
     * @return string $embedUrl
     */
    public static function getVimeoEmbedUrl($url) {
        $urlArr = explode('/', $url);
        $vimeoId = end($urlArr);
        $embedUrl = 'https://player.vimeo.com/video/' . $vimeoId;
        return $embedUrl;
    }
    
    /**
     * generate youtube embed url from video URL
     * @author Dhaval Bharadva
     * @param string $url
     * @return string $embedUrl
     */
    public static function getYoutubeEmbedUrl($url) {
        if (strpos($url, 'embed') !== false) {
            return $url;
        }

        $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_]+)\??/i';
        $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))(\w+)/i';
        $otherRegex = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';

        if (preg_match($otherRegex, $url, $matches)) {
            $youtube_id = $matches[1];
        }elseif (preg_match($longUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }elseif (preg_match($shortUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }
        $embedUrl = 'https://www.youtube.com/embed/' . $youtube_id;
        /* preg_match(
          '/[\\?\\&]v=([^\\?\\&]+)/',
          $url,
          $matches
          );
          $id = $matches[1];
          $embedUrl = 'http://www.youtube.com/v/' . $id; */
        return $embedUrl;
    }

    /**
     * check spam keywords in description
     * @author Dhaval Bharadva
     * @param string $description
     * @return boolean true or false
     */
    public static function checkSpamKeywords($description) {
        $keyWords = array('why?','porn','sex','xxx','Viagra','seo','ppc','advertise','advertising','dick','traffic','http://','pharmacy','software','bonus');

        foreach ($keyWords as $key => $val){
            if (strpos($description, $val) !== false) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * check spam email in inquiry
     * @author Dhaval Bharadva
     * @param string $email
     * @return boolean true or false
     */
    public static function checkSpamEmail($email) {
        $keyWords = array('edwardozobia@hotmail.com');

        foreach ($keyWords as $key => $val){
            if (strpos($email, $val) !== false) {
                return true;
            }
        }
        return false;
    }

    public static function getLettingTypes() {
        $lettingTypes = array('Select Letting Type', 'Short Lets', 'Long Lets', 'Commercial Let', 'For Sale Residential', 'For Sale Commercial');
        return $lettingTypes;
    }
    
    public static function ratingTypes() {
        
        $arr = array(
            '' => 'Select Rating',
            'legend' => 'Legend',
            'star' => 'Star',
            'comfort_zone' => 'Comfort Zone',
            'pull_up' => 'Pull Up Your Socks',
            'alert_zone' => 'Alert Zone',
        );

        return $arr;
    }
    
    public static function journeyTypes() {

        $arr = array(
            '' => 'Select Career Journey',
            'specialist' => 'Letting Specialist',
            'hero' => 'Letting Hero',
            'star' => 'Letting Rock Star',
        );

        return $arr;
    }

    public static function propertyDeclineReason() {

        $arr = array(
            '1' => 'Incomplete address',
            '2' => 'Less than 4 horizontal photos',
            '3' => 'Improve description',
            '4' => 'Select more features',
            '5' => 'Double listing',
        );

        return $arr;
    }

    public static function getEnquirySource() {
        $array = array(
            'fb' => 'FB', 
            'referral' => 'Referral', 
            'ql' => 'QL Website', 
            'other_social' => 'Other Social', 
            'gaming_referral' => 'Gaming Referral', 
            'other' => 'Other'
        );
        return $array;
    }

    /**
     * Captcha validation using google captcha v3     
     * @param string $token    
     * @return object
     * @author Dhaval Bharadva
     */
    public static function captchaValidation($token) {
        
        if(!isset($token) || empty($token)){
            return null;
        }
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        //$secret = sfConfig::get('app_google_captcha_secret');
        $secret = 'google_captcha_secret';
        $data = array('secret' => $secret, 'response' => $token);
        
        $requestHeaders = array(           
            'Accept' => 'application/json',
           // 'Content-Type' => 'application/x-www-form-urlencoded'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
       // curl_setopt($ch, CURLOPT_HEADER, $requestHeaders);
        $response = curl_exec($ch);
        if(curl_errno($ch)){
            $response = null;
        } else {
            $response = json_decode($response, true);
        }       
        curl_close($ch);        
        //$recaptcha = file_get_contents($url . '?secret=' . $secret . '&response=' . $token);
        return $response;
    }

    /**
     * get no of days between start & end date excluding weekend
     * @author Dhaval Bharadva
     * @param date $start
     * @param date $end
     * @param array $holidays
     * @param array $weekends
     * @return integer no of days
     */
    public static function get_total_days($start, $end, $holidays = [], $weekends = ['Sat', 'Sun']){

        $start = new \DateTime($start);
        $end   = new \DateTime($end);
        // otherwise the  end date is excluded (bug?)
        //$end->modify('+1 day');

        $total_days = $end->diff($start)->days;
        $period = new \DatePeriod($start, new \DateInterval('P1D'), $end);

        foreach($period as $dt) {
            if (in_array($dt->format('D'),  $weekends) || in_array($dt->format('Y-m-d'), $holidays)){
                $total_days--;
            }
        }
        return $total_days;
    }
    
    /**
     * Replace mobile number with X and display only last given $length digits
     * @author Dhaval Bharadva
     * @param integer $mobile
     * @param integer $length
     * @return integer secret mobile number
     */
    public static function secretMobile($mobile, $length = 2){
        return str_repeat('X', MAX($length, strlen($mobile)) - $length) . substr($mobile, -$length);
    }
    
}

?>
