<?php

namespace App\Core;

class View
{
    private array $data = [];

    public function assign(array $data): static
    {
        $this->data = array_merge($this->data, $data);
        return $this;
    }

    public function render(string $view, array $data = []): void
    {
        extract(array_merge($this->data, $data));
        $viewFile = ROOT_PATH . '/' . ltrim($view, '/');

        if (!file_exists($viewFile)) {
            throw new \RuntimeException("View not found: {$viewFile}");
        }

        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        // Inject into base layout
        require ROOT_PATH . '/templates/base.php';
    }

    public function component(string $name, array $data = []): void
    {
        extract($data);
        $file = ROOT_PATH . '/components/' . $name . '.php';
        if (file_exists($file)) require $file;
    }
}
