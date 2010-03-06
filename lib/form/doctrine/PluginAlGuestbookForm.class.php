<?php

/**
 * PluginAlGuestbook form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id$
 */
abstract class PluginAlGuestbookForm extends BaseAlGuestbookForm
{
  public function setup()
  {
    parent::setup();
    
    /* unset not needed fields */
    unset($this['is_active']);
    
    /* validate email adress */
    $this->changeToEmail('email');
    $this->validatorSchema['email']->setOption('required', false);
    
    /* set label for text field */
    $this->widgetSchema['text']->setLabel('Your message');
    
    /* text is required */
    $this->validatorSchema['text']
      ->setOption('required', true)
      ->setMessage('required', 'Please enter a message');
    
    /* add captcha if enabled */
    if ($this->isCaptchaEnabled())
    {
      $this->addCaptcha();
    }
  }
  
  /**
   * addCaptcha adds a recaptcha field if enabled
   *
   */
  public function addCaptcha()
  {
    /* generate the captcha field */
    $this->widgetSchema['captcha'] = new sfWidgetFormReCaptcha(array(
      'public_key' => sfConfig::get('app_recaptcha_public_key')
    ));
    
    /* validate the captcha field */
    $this->validatorSchema['captcha'] = new sfValidatorReCaptcha(array(
      'private_key' => sfConfig::get('app_recaptcha_private_key')
    ));
  }
  
  /**
   * check if the guestbook capctcha enabled or not
   *
   */
  public function isCaptchaEnabled()
  {
    return sfConfig::get('app_recaptcha_guestbook_enabled');
  }
}