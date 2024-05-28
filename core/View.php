<?php

namespace core;
class View
{
    private function getHTML(string $filepath, array $data): false|string
    {
        if (!file_exists($filepath)) {
            return false;
        }
        ob_start();
        extract($data);
        include($filepath);
        $str = ob_get_contents();
        ob_end_clean();
        return $str;
    }
    public function renderTemplate(string $path, string $title,  array $data=[]): void
    {
        $content = $this->getHTML($path, $data);
        if ($content === false) {
            echo "Template not found: $path";
            return;
        }
        echo $this->getHTML("views/layouts/index.php", ['Title' => $title, 'Content' => $content]);
    }

}