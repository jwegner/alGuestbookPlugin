<?php
/**
 * Guestbook list/index
 * 
 * @param array $alGuestbookPager
 *
 * @todo implement gravatar image to the view.
 */

use_helper('Date');

/* if GravatarEnabled --> use_helper('Gravatar); */
if (alGuestbookTools::isGravatarEnabled())
{
  use_helper('Gravatar');
}

echo $alGuestbookPager->renderNavigationTop();

echo _open('ul#guestbook.element');

foreach ($alGuestbookPager as $alGuestbook)
{
  echo _open('li.element');

    /* author */
    echo _tag('div.author') .
      _tag('span.value', $alGuestbook->author);
    
    /* email if set */
    if ($alGuestbook->email)
    {
      echo _open('div.email');
      
        if (alGuestbookTools::isGravatarEnabled())
        {
          echo gravatar_image_tag($alGuestbook->email);
        }
        else
        {
          echo _tag('span.title', __('E-mail:'));
          echo _tag('span.value', _link('mailto:' . $alGuestbook->email)->text($alGuestbook->email));
        }
      
      echo _close('div');
    }
    
    /* website if set */
    if ($alGuestbook->website)
    {
      echo _tag('div.website') .
        _tag('span.title', __('Website:')) .
        _tag('span.value', _link($alGuestbook->website)->text($alGuestbook->website)->target('blank'));
    }
    
    /* guestbook text */
    echo _tag('div.text') .
      _tag('span.value', markdown($alGuestbook->text));
    
    /* created_at */
    echo _tag('div.created_at') .
      _tag('span.value', format_date($alGuestbook->createdAt, 'D'));

  echo _close('li');
}

echo _close('ul');

echo $alGuestbookPager->renderNavigationBottom();