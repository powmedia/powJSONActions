<?php

/**
 * powJSONActions
 * 
 * Provides methods for responding to a request with JSON
 * 
 * @author     Charles Davison
 * @version    1.0
 */
class powJSONActions extends sfActions
{
    /**
     * Respond in JSON when requested via Ajax or as plain text when requested directly.
     * 
     * If the web debug toolbar is turned on, this method will remove it from the response 
     * body to prevent breaking the JSON response, and will put the overview data into the 
     * response header.
     *
     * @param array $data       The response to send as an array
     *
     * @return string
     */
    protected function returnJSON(array $data)
    {
        $json = json_encode($data);
        
        $isDebugMode = $this->getRequest()->hasParameter('debug')
            && sfConfig::get('sf_environment') == 'dev';
        
        if (!$isDebugMode)
        {            
            //Move data from web debug toolbar into response header
            if (sfConfig::get('sf_web_debug'))
            {
                //Get web debug panels
                $loggers = $this->getLogger()->getLoggers();
                $debugger = new sfWebDebug(sfContext::getInstance()->getEventDispatcher(), $loggers[0]);
                $panels = $debugger->getPanels();
                
                //Add debug info to custom header
                $debug = array();
                foreach (array('symfony_version', 'memory', 'time', 'db') as $name)
                {
                    if (isset($panels[$name]))
                        $debug[$name] = trim(strip_tags($panels[$name]->getTitle()));
                }
                //Add created_at to identify when items are cached
                $debug['created_at'] = date('r', time());
                $this->getResponse()->setHttpHeader('X-sf-web-debug', json_encode($debug));

                //Turn off the HTML debug toolbar
                sfConfig::set('sf_web_debug', false);
            }
            
            //Send JSON response; this is done via a template to enable caching
            $this->json = json_encode($data);
            $this->setTemplate('json');
            $this->setLayout(false);
            $this->getResponse()->setHttpHeader('Content-type', 'application/json');
        }
        else //Debug mode
        {
            $this->data = $data;
            $this->json = json_encode($data);
            $this->setLayout(false);
            $this->setTemplate('debug');
        }    
            
        return sfView::SUCCESS;
    }

    protected function returnXML($response) {

      $this->xml = Doctrine_Parser_Xml::arrayToXml($response);
      $this->setTemplate('xml');
      $this->setLayout(false);
      $this->getResponse()->setHttpHeader('Content-type', 'text/xml');
      return sfView::SUCCESS;
    }
}
