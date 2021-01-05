<?php

namespace App\Http\Controllers;

use App\Http\Requests\PdfStoreRequest;
use App\Models\Cloud;
use Illuminate\Http\Request;
use Storage;

class CloudController extends Controller
{
    public function pdfs(Request $request)
    {
        $pdfs = $request->user()->clouds()->get(['pdf','code']);

        $resp = array();

        foreach ($pdfs as $pdf) {
            if ($pdf->pdf)
                $resp[] = [$pdf->code ,Storage::disk("cloud")->temporaryUrl($pdf->pdf, now()->addMinutes(5))];
        }

        return response()->json([
            'data' => $resp,
            'message' => __('Success')
        ], 200);
    }

    public function code($code)
    {
        $cloud = Cloud::where('code', $code)->first();

        $resp = [
            'pdf' => Storage::disk("cloud")->temporaryUrl($cloud->pdf, now()->addMinutes(5)),
            'svg' => Storage::disk("cloud")->temporaryUrl($cloud->svg, now()->addMinutes(5)),
            //'jpg' => Storage::disk('minio')->temporaryUrl($cloud->jpg, now()->addMinutes(5)),
            //'png' => Storage::disk('minio')->temporaryUrl($cloud->png, now()->addMinutes(5)),
            //'spng' => Storage::disk('minio')->temporaryUrl($cloud->spng, now()->addMinutes(5)),
            //'sjpg' => Storage::disk('minio')->temporaryUrl($cloud->sjpg, now()->addMinutes(5))
        ];

        return response()->json([
            'data' => $resp,
            'message' => __('Success')
        ], 200);
    }

    public function store(PdfStoreRequest $request)
    {
        $cloud = Cloud::startProcess($request);

        return response()->json([
            'data' => [
                "code" => $cloud['code'],
            ],
            "message" => __('The word cloud is saved.')
        ]);
    }
}
