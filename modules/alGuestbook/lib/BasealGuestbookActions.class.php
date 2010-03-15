<?php

class BasealGuestbookActions extends myFrontModuleActions
{
    /**
     * executes the Guestbook form
     *
     * @param dmWebRequest $request
     */
    public function executeFormWidget(dmWebRequest $request)
    {
        $form = new AlGuestbookForm();
      
        if ($request->hasParameter($form->getName()))
        {
          $data = $request->getParameter($form->getName());
          
          /* recaptcha field */
          if ($form->isCaptchaEnabled())
          {
            $data = array_merge($data, array('captcha' => array(
              'recaptcha_challenge_field' => $request->getParameter('recaptcha_challenge_field'),
              'tecaptcha_response_field'  => $request->getParameter('recaptcha_response_field'),
            )));
          }
          
          $form->bind($data, $request->getFiles($form->getName()));
          
          /* if the form is Valid -> save */
          if ($form->isValid())
          {
            $form->save();
            
            /* confirmations message */
            $this->getUser()->setFlash('guestbook_form_valid', true);
            
            /* set new al_guestbook.saved Event */
            $this->getService('dispatcher')->notify(new sfEvent($this, 'al_guestbook.saved', array(
              'guestbook' => $form->getObject()
            )));
            
            $this->redirectBack();
          }
        }
        
        $this->forms['AlGuestbook'] = $form;
    }
}