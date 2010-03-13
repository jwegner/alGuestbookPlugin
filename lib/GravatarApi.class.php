<?php
/**
 * This API Enable auto caching gravatar image
 *
 * @todo
 *  - automatically remove cached gravatar through a cron or with phptask
 *  - add unit tests
 */
class GravatarAPI
{
    /* default cached gravatar image */
    protected $defaultImage;
    
    /* possible to put : 3 days, 1 week, and whatever you want according to php strtotime function */
    protected $expireAgo;
    
    protected $imageSize, $rating, $cacheDir;
    protected $cacheDirName;
    
    protected $baseURL = 'http://www.gravatar.com';
    /* gravatar ratings are only : G | PG | R | X */
    protected $baseRatings = array('G', 'PG', 'R', 'X');
    
    /**
     * Constuct
     */
    public function __construct($imageSize = null, $rating = null)
    {
        if (SYMFONY_VERSION >= 1.1)
        {
            $this->cacheDir = sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR.sfConfig::get('app_gravatar_cache_dir_name', 'g_cache').DIRECTORY_SEPARATOR;
            $this->cacheDirName = str_replace(sfConfig::get('sf_web_dir'), '', $this->cacheDir);
        }
        else
        {
            $this->cacheDirName = DIRECTORY_SEPARATOR.sfConfig::get('sf_upload_dir_name').DIRECTORY_SEPARATOR.sfConfig::get('app_gravatar_cache_dir_name', 'g_cache').DIRECTORY_SEPARATOR;
            $this->cacheDir = sfConfig::get('sf_web_dir').$this->cacheDirName;
        }
        
        /* default image */
        $this->defaultImage = sfConfig::get('app_gravatar_default_image', 'gravatar_default.png');
        /* cache expires */
        $this->expireAgo = sfConfig::get('app_gravatar_cache_expiration', '3 days');
        
        if (is_null($imageSize) || $imageSize > 80 || $imageSize < 1)
        {
            $this->imageSize = sfConfig::get('app_gravatar_default_size', 80);
        }
        else
        {
            $this->imageSize = $imageSize;
        }
        
        if (is_null($rating) || !in_array($rating, $this->baseRatings))
        {
            $this->rating = sfConfig::get('app_gravatar_default_rating', 'G');
        }
        else
        {
            $this->rating = $rating;
        }
    }
    
    /**
     * constructs path to gravatar (with size, rating, md5 email and a default image to redirect to (if not found))
     *
     * @return string
     */
    protected function buildGravatarPath($md5_email)
    {
        return $this->baseURL.'/avatar.php?gravatar_id='.$md5_email.
                              '&size='.$this->imageSize.
                              '&rating='.$this->rating.
                              '&default=http://www.default.com';
    }
    
    /**
     * Check if a gravatar is available on gravatar.com
     *
     * @return boolean
     */
    public function hasGravatar($md5_email)
    {
        /* TODO try cache ! */
        $ch = curl_init($this->buildGravatarPath($md5_email));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        //--- Start buffering : HIDE CURL EXEC RETURN ...
        ob_start();
        curl_exec($ch);
        ob_end_clean();
        //--- End buffering and clean output
        
        $session_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        // 200 == page with no error, else 301 == redirect (no gravatar) or 404... or whatever
        if ($session_code == 200)
        {
            return true;
        }
        
        return false;
    }
    
    /**
     * Check for a cache hit - if found check if file is within expiry time
     *
     * @return void
     */
    protected function isCacheValid($file_path)
    {
        if (file_exists($file_path))
        {
            if (filectime($file_path) < strtotime("+".$this->expireAgo))
            {
                /* file exist and cache is valid */
                return true;
            }
            else
            {
                /* file exist but cache is expired */
                unlink($file_path);
            }
        }
        
        /* no file */
        return false;
    }
    
    /**
     * Get the gravatar to the cache, if email has a gravatar and it does not
     * already exist (or has expired)
     *
     * @return string
     */
    public function getGravatar($email)
    {
        $md5_email = md5($email);
        $file = $this->cacheDir.$md5_email.'.png';
        
        /* the cache is valid, return the cached image */
        $to_return = $md5_email;
        
        /* check the cache */
        if (!$this->isCacheValid($file))
        {
            /* no image in cache */
            if ($this->hasGravatar($md5_email))
            {
                $path = $this->buildGravatarPath($md5_email);
            }
            else
            {
                /* no gravatar --> get the default one */
                $path = realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.$this->defaultImage);
            }
            
            $new_file = fopen($file, 'w+b');
            $gravatar_img = file_get_contents($path, 'rb');
            /* image on gravatar.com --> save it in cache */
            fwrite($new_file, $gravatar_img);
        }
        
        return str_replace(DIRECTORY_SEPARATOR, '/', $this->cacheDirName).$to_return;
    }
}