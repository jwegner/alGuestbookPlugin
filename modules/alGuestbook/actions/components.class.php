<?php
/**
 * Guestbook components
 * 
 * No redirection nor database manipulation ( insert, update, delete ) here
 */
class alGuestbookComponents extends myFrontModuleComponents
{

  public function executeList()
  {
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