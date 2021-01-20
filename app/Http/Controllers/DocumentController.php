<?php

namespace App\Http\Controllers;

use App\Http\Requests\PdfStoreRequest;
use App\Models\Document;
use Illuminate\Http\Request;
use Storage;

class DocumentController extends Controller
{
    public function pdfs(Request $request)
    {
        $pdfs = $request->user()->Storage::disk("document")->get(['pdf','code']);

        $resp = array();

        foreach ($pdfs as $pdf) {
            if ($pdf->pdf)
                $resp[] = [$pdf->code ,Storage::disk("document")->temporaryUrl($pdf->pdf, now()->addMinutes(5))];
        }

        return response()->json([
            'data' => $resp,
            'message' => __('Success')
        ], 200);
    }

    public function code($code)
    {
        $document = Document::where('code', $code)->first();

        $resp = [
            'pdf' => Storage::disk("document")->temporaryUrl($document->pdf, now()->addMinutes(5)),
            'svg' => Storage::disk("document")->temporaryUrl($document->svg, now()->addMinutes(5)),
            //'jpg' => Storage::disk('minio')->temporaryUrl($document->jpg, now()->addMinutes(5)),
            //'png' => Storage::disk('minio')->temporaryUrl($document->png, now()->addMinutes(5)),
            //'spng' => Storage::disk('minio')->temporaryUrl($document->spng, now()->addMinutes(5)),
            //'sjpg' => Storage::disk('minio')->temporaryUrl($document->sjpg, now()->addMinutes(5))
        ];

        return response()->json([
            'data' => $resp,
            'message' => __('Success')
        ], 200);
    }

    public function store(PdfStoreRequest $request)
    {
//        dd(Storage::disk('document'));


        $entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
        $replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");


        $document = Document::startProcess($request);



        return response()->json([
            'data' => [
                "code" => str_replace($entities, $replacements, urlencode($document['code'],))
            ],
            "message" => __('Document is saved.')
        ]);
    }
}
