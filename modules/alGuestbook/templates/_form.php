<?php
/**
 * Guestbook form
 *
 * @param object $form the guestbook form
 *
 */

if ($sf_user->getFlash('guestbook_form_valid'))
{
    echo _tag('p.confirm', __('Thank you for your entry'));
}

echo _open('div#guestbook');

    echo $form->open();
        
            echo _tag('ul',
            
                /* author field */
                _tag('li.author', $form['author']->label()->field()->error()).
            
                /* email field */
                _tag('li.email', $form['email']->label()->field()->error()).
            
                /* website field */
                _tag('li.website', $form['website']->label()->field()->error()).
            
                /* text field */
                _tag('li.text', $form['text']->label()->field()->error())
            
            );
            
            /* captcha field */
            if ($form->isCaptchaEnabled())
            {
                echo _tag('span.captcha', $form['captcha']->label('Captcha', 'for=false')->field()->error());
            }
            
            /* render hidden fields */
            echo $form->renderHiddenFields();
            
            /* and submit button */
            echo $form->submit(__('Add'), '.submit_wrap');
        
        echo $form->close();
    
echo _close('div');