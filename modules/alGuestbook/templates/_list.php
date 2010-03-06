<?php // Vars: $alGuestbookPager

echo $alGuestbookPager->renderNavigationTop();

echo _open('ul.elements');

foreach ($alGuestbookPager as $alGuestbook)
{
  echo _open('li.element');

    echo $alGuestbook;

  echo _close('li');
}

echo _close('ul');

echo $alGuestbookPager->renderNavigationBottom();