<?php

namespace core;
class View
{
    protected string $filepathtocss = "";
    protected string $filepathtoscript = "";
    public function setFilePathToCss($path): void
    {
        $this->filepathtocss = $path;
    }
    public function setFilePathToScript($path): void
    {
        $this->filepathtoscript = $path;
    }
    public function getHTML(string $filepath, array $data = []): false|string
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
    public function renderTemplate(string $path, string $title, array $data=[]): void
    {
        $content = $this->getHTML($path, $data);
        if ($content === false) {
            echo "Template not found: $path";
            return;
        }
        echo $this->getHTML("views/layouts/index.php", ['Title' => $title,
            'Content' => $content,
            "Style"=> $this->filepathtocss,
            "Script" => $this->filepathtoscript]);
    }
    public function renderJson(array $data=[]): void
    {
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    public function renderTemplateWithout(string $path, string $title, array $data=[]): void
    {
        $content = $this->getHTML($path, $data);
        if ($content === false) {
            echo "Template not found: $path";
            return;
        }
        echo $content;
    }
}