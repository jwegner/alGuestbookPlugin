<?php
/**
 * Displays a gravatar image from a given email
 *
 * @param string $email             Email of the gravatar
 * @param string $gravatarRating    Maximal rating of the gravatar
 * @param integer $gravatarSize     size of the gravatar
 * @param string $altText           Alternative text
 * @return string
 */
function gravatar_image_tag($email, $gravatarRating = null, $gravatarSize = null, $altText = 'Gravatar photo')
{
    /* get instance of GravatarAPI */
    $gravatar = new GravatarAPI($gravatarRating, $gravatarSize);
    
    /* return the gravatar image */
    return image_tag($gravatar->getGravatar($email),
                     array('alt'    => $altText,
                           'width'  => sfConfig::get('app_al_guestbook_gravatar_default_size', 80),
                           'height' => sfConfig::get('app_al_guestbook_gravatar_default_size', 80),
                           'class'  => 'gravatar_photo'
                          )
                     );
}