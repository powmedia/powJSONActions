powJSONActions plugin     
================

Overview
--------

A simple plugin to make responding to JSON requests and debugging easier:

- return a JSON-encoded string to the browser
- set the response content-type to application/json
- move the overview data from the web debug toolbar to the response header so that it does not break the JSON response
- respond with a readable version of the response when in the dev environment and if requested with a 'debug' GET query param

When the debug toolbar was turned on, the following data will be moved to the X-sf-web-debug header, so that JSON responses aren't broken by the web debug toolbar HTML:
- symfony_version
- memory (used in KB)
- time (in ms)
- db (number of calls to the database)
- created_at (useful for telling when a response has been cached)


Installation
------------

    php symfony plugin:install powJSONActionsPlugin

Upgrade plugins
---------------

    php symfony plugin:upgrade -r=1.1.11 powJSONActionsPlugin

Uninstallation
--------------

    php symfony plugin:uninstall powJSONActionsPlugin
	
Usage
-----

1. Install the plugin and make sure it's enabled in ProjectConfiguration.

2. Make your controller extend powJSONActions instead of sfActions.

3. Copy the templates to your module and customise them if required.  Note that this plugin outputs JSON via a template (rather than responseText()) in order to enable caching.

    cp plugins/powJSONActionsPlugin/modules/powJSONActions/templates/* apps/frontend/modules/ajax/templates
    
    (Change your folder paths as required)

4. Build an array of data to respond with, and pass that to $this->returnJSON().


To view debug mode, you must be in the dev environment.
Add the 'debug' GET query param to the request, e.g.:
/ajax/doSomething?debug


To customise the response when viewed in debug mode:
1. Use $this->debugTemplate = 'debug', where 'debug' is the name of the template (e.g. debugSuccess.php). 
2. The template (e.g. 'debugSuccess.php') will be passed the following variables:
    $data : PHP array of data
    $json : JSON encoded data

Example:

In modules/ajax/actions/actions.class.php :

    <?php
    //Extend powJSONActions instead of sfActions
    class ajaxActions extends powJSONActions
    {
        //Set the template to be used when viewed from browser
        protected $debugTemplate = 'debug';
    
        public function executeSomeAction($request)
        {
            //Set up the response in an array
            $data = array(
                'items' => array(1, 2, 3);
            );
        
            //Respond
            $this->returnJSON($data);
        }
    }


In modules/ajax/templates/debugSuccess.php :

    JSON: <br />
    <?php echo $json ?>

    Array: <br />
    <pre><?php print_r($data) ?></pre>


License
-------

For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
