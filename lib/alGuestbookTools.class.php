<?php

class alGuestbookTools
{
    /**
     * Check is Gravatar enabled or not
     */
    public static function isGravatarEnabled()
    {
        return sfConfig::get('app_gravatar_enabled');
    }
}