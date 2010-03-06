<?php // Vars: $form

if ($sf_user->getFlash('guestbook_form_valid'))
{
    echo _tag('p.confirm', __('Thank you for your entry'));
}

echo $form;