<?php
/**
 * Guestbook list/index
 * 
 * @param array $alGuestbookPager
 *
 */

use_helper('Date');

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
      echo _tag('div.email') .
        _tag('span.title', __('E-mail:')) .
        _tag('span.value', _link('mailto:' . $alGuestbook->email)->text($alGuestbook->email));
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