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

echo _open('ul#guestbook');

    echo _open('li');

        echo $form->open();
        
            echo _tag('ul',
            
                /* author field */
                _tag('li.author', $form['author']->label()->field()->error()).
            
                /* email field */
                _tag('li.email', $form['email']->label()->field()->error()).
            
                /* website field */
                _tag('li.webite', $form['website']->label()->field()->error()).
            
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
            echo $form->submit(__('Add'));
        
        echo $form->close();
    
    echo _close('li');
    
echo _close('ul');