<?php

class BasealGuestbookComponents extends myFrontModuleComponents
{
    public function executeList()
    {
        /* add default css */
        $this->getResponse()->addStylesheet('/alGuestbookPlugin/css/' . sfConfig::get('app_al_guestbook_use_stylesheet') . '.css');
        
        $query = $this->getListQuery();
        
        $this->alGuestbookPager = $this->getPager($query);
        
        /* ajax pager */
        $this->alGuestbookPager->setOption('ajax', true);
    }

    public function executeForm()
    {
        $this->form = $this->forms['AlGuestbook'];
    }
}