<?php

namespace App\Helpers;

use Storage;
use App;
use Log;

use App\Models\Document;

class ProcessDocument
{
    protected $document;
    protected $pdfPath, $svgPath, $pngPath, $jpgPath, $sPngPath, $sJpgPath, $htmlPath;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    public function makeProcess()
    {

        $this->html();
        $this->pdf();


        $this->document->update();

        return [
            'code' => $this->document->code,
        ];
    }

    public function html()
    {

        $temp = uniqid() . ".html";
        //put html to local to convert pdf
        Storage::put('updf/'.$temp, $this->document->content);
        $this->htmlPath = Storage::path('updf/'.$temp);
        $this->pdfPath = str_replace('.html', '.pdf', $this->htmlPath);

        //put html to s3
        $this->document->html = Storage::disk("document")->putFile('updf/html', $this->htmlPath);
        Log::info("Html done");

    }

    public function pdf()
    {
        $chrome = exec("which google-chrome");

        if (App::isLocal()){
            //$chrome = '/Applications/Google\ Chrome.app/Contents/MacOS/Google\ Chrome'; // for macos
            $chrome = '/usr/bin/google-chrome'; // for ubuntu
        }

        if (!$chrome)
            throw new \Exception ('Library missing (1)');

        //convert html to a3 pdf (a3 is in css)
        $cmd = $chrome . " --no-sandbox --headless --print-to-pdf=" . $this->pdfPath . " " .($this->document->url ?? $this->htmlPath);
        Log::info($cmd);
        $result = exec($cmd);

        //crop whitespaces
        //https://pypi.org/project/pdfCropMargins/
        $pdfcropmargins = exec("which pdf-crop-margins");
        if ($pdfcropmargins) {
            $croppedPath = str_replace('.pdf', '_cropped.pdf', $this->pdfPath);
            $cmd = $pdfcropmargins . " -p 2 " . $this->pdfPath . " -o " . $croppedPath;
            Log::info($cmd);
            $result = exec($cmd);
            $this->pdfPath = $croppedPath;
        }

        $this->document->pdf = Storage::disk("document")->putFile('updf/pdf', $this->pdfPath);
        Log::info("Pdf done");
    }

    public function png()
    {
        //convert pdf to png //brew install poppler
        $pdftoppm = exec("which pdftoppm");
        if (!$pdftoppm)
            throw new \Exception ('Library missing (2)');

        $cmd = $pdftoppm . " " . $this->pdfPath . "  -scale-to " . config('site.hq_png') . " -png > " . $this->pngPath;
        Log::info($cmd);
        $result = exec($cmd);
        $this->document->png = Storage::disk("document")->putFile('updf/png', $this->pngPath);

        //low resolution
        $cmd = $pdftoppm . " " . $this->pdfPath . " -scale-to " . config('site.standard_png') . " -png > " . $this->sPngPath;
        Log::info($cmd);
        $result = exec($cmd);
        $this->document->spng = Storage::disk("document")->putFile('updf/spng', $this->sPngPath, 'public');
        Log::info("Png done");
    }

    public function jpg()
    {
        //convert pdf to jpg
        $pdftoppm = exec("which pdftoppm");
        if (!$pdftoppm)
            throw new \Exception ('Library missing (3)');

        $cmd = $pdftoppm . " " . $this->pdfPath . " -scale-to " . config('site.hq_jpg') . " -jpeg -jpegopt quality=100 > " . $this->jpgPath;
        Log::info($cmd);
        $result = exec($cmd);
        $this->document->jpg = Storage::disk("document")->putFile('updf/jpg', $this->jpgPath);

        //low resolution
        $cmd = $pdftoppm . " " . $this->pdfPath . " -scale-to " . config('site.standard_jpg') . "  -jpeg -jpegopt quality=90 > " . $this->sJpgPath;
        Log::info($cmd);
        $result = exec($cmd);
        $this->document->sjpg = Storage::disk("document")->putFile('updf/sjpg', $this->sJpgPath, 'public');
        Log::info("Jpg done");
    }


}
