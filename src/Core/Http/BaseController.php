<?php

namespace Atheo\Indoframe\Core\Http;

use Exception;

class BaseController
{
    /**
     * Render View 
     * @param string $viewname 
     * @param array $data
     */
    protected function view(string $viewname, array $data = [])
    {
        $viewPath = '../app/Views/' . $viewname . 'View.php';
        if(!file_exists($viewPath)){
            throw new Exception('View file not found : ' . $viewname);
        }

        // extract data to became separate variable
        extract($data);

        //start buffering output
        ob_start();

        // load file view
        include $viewPath;

        $renderedView = ob_get_clean();

        echo $renderedView;
    }

    /**
     * Redirect to a specified URL
     *
     * @param string $url
     * @param int $statusCode
     * @return void
     */
    protected function redirect(string $url, int $statusCode = 302)
    {
        header('Location: ' . $url, true, $statusCode);
        exit;
    }
}
