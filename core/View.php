<?php

namespace app\core;

class View {

    public function render($viewName, $layoutName) {
        $layout = $this->renderLayout($layoutName);
        $view = $this->renderPartialView($viewName);

        $fullView = str_replace('{{ RENDER_SECTION }}', $view, $layout);
        echo $fullView;
        
        ob_start();
        require_once __DIR__ . '/../views/' . $viewName . '.php';
        return ob_get_clean();
    }

    public function renderLayout($viewName) {
        ob_start();
        require_once __DIR__ . '/../views/layouts/' . $viewName . '.php';
        return ob_get_clean();
    }

    public function renderPartialView($viewName) {
        ob_start();
        require_once __DIR__ . '/../views/' . $viewName . '.php';
        return ob_get_clean();
    }

}