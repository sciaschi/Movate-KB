<?php

namespace App\Http\Controllers\Translate;

use App\Http\Controllers\Controller;
use DeepL\DeepLException;
use DeepL\Translator;
use Http;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Validator;

class TranslateController extends Controller
{
    public function index() {
        return Inertia::render('Translate/Index');
    }

    /**
     * @throws DeepLException
     */
    public function translate(Request $request) {
        $data      = (array) json_decode($request->getContent());
        $validated = Validator::make($data, [
            'text' => 'required|string',
        ]);

        if($validated->fails())
        {
            return response()->json([
                "status" => false,
                "message" => $validated->errors()->all()
            ], 500);
        }

        $translator = new Translator(env('DEEPL_API_KEY'));
        $translatedText = $translator->translateText($data['text'], $data['source_lang'], $data['target_lang']);
        return response()->json([
            "status" => true,
            "data" => $translatedText
        ]);
    }

    /**
     * @throws DeepLException
     */
    public function getLanguages() {
        $translator      = new Translator(env('DEEPL_API_KEY'));
        $sourceLanguages = $translator->getSourceLanguages();
        $targetLanguages = $translator->getTargetLanguages();

        sort($sourceLanguages);
        sort($targetLanguages);

        $languages = [
            'source' => $sourceLanguages,
            'target' => $targetLanguages
        ];

        return response()->json([
            "status" => true,
            "data" => $languages
        ]);
    }
}
