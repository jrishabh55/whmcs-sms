<?php

namespace JNEX\SMS\Admin;

/**
 * Sample Admin Area Dispatch Handler
 */
class AdminDispatcher {

    /**
     * Dispatch request.
     *
     * @param string $action
     * @param array $parameters
     *
     * @return string
     */
    public function dispatch($action, $parameters)
    {
        if (!$action) {
            // Default to index if no action specified
            $action = 'index';
            if($_SERVER["REQUEST_METHOD"] == "POST"){
              if($_POST["submit"] == "Save Providers"){
              $action = 'handlePost';
            }
              else if($_POST["submit"] == "Save Hooks"){
                $action = 'handleHooks';
              }
          }
        }

        $controller = new Controller();

        // Verify requested action is valid and callable
        if (is_callable(array($controller, $action))) {
            $return = $this->css();
            $return .= $controller->$action($parameters);
            return $return;
        }

        return '<p>Invalid action requested. Please go back and try again.</p>';
    }

    public function css () {
      return <<<HTML
      <style>
        .input-wrapper{
          float: left;
          width: 33%;
        }
        input[type=submit]{
          display: block;
          margin: 0 auto;
          clear: both;
        }
      </style>
HTML;
    }
}
