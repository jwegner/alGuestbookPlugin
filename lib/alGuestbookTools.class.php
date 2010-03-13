<?php

class alGuestbookTools
{
    /**
     * Check is Gravatar enabled or not
     */
    public static function isGravatarEnabled()
    {
        return sfConfig::get('app_al_guetbook_gravatar_enabled');
    }
}