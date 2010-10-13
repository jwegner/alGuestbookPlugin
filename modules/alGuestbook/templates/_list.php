<?php
/**
 * Guestbook list/index
 * 
 * @param array $alGuestbookPager
 *
 * @todo implement gravatar image to the view.
 */

use_helper('Date');
use_helper('Url');

/* if GravatarEnabled --> use_helper('Gravatar); */
if (alGuestbookTools::isGravatarEnabled())
{
  use_helper('Gravatar');
}

echo $alGuestbookPager->renderNavigationTop();

echo _open('div#guestbook.element');

foreach ($alGuestbookPager as $alGuestbook)
{
  echo _open('div.guestbook-element');

    /* author and email or just author if set */
    if ($alGuestbook->email)
    {
      echo _open('div.email');
      
        if (alGuestbookTools::isGravatarEnabled())
        {
          echo gravatar_image_tag($alGuestbook->email);
        }
        else
        {
          echo mail_to($alGuestbook->email, $alGuestbook->author, array('encode' => true));
        }
      
      echo _close('div');
    } elseif ($alGuestbook->author)
            echo _tag('div.author', $alGuestbook->author);
    
    /* website if set */
    if ($alGuestbook->website)
    {
      echo _tag('div.website') .
        _tag('span.title', __('Website') . ':') .
        _tag('span.value', _link($alGuestbook->website)->text($alGuestbook->website)->target('blank'));
    }
    
    /* guestbook text */
    echo _tag('div.text', markdown($alGuestbook->text));
    
    /* created_at */
    echo _tag('div.created_at', format_date($alGuestbook->createdAt, 'D'));

  echo _close('div');
}

echo _close('div');

echo $alGuestbookPager->renderNavigationBottom();