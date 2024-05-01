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
    private $translator;

    /**
     * @throws DeepLException
     */
    public function __construct()
    {
        $this->translator = new Translator(config('deepl.key'));
    }


    /**
     * @throws DeepLException
     */
    public function index() {
        return Inertia::render('Translate/Index', [
            'languages' => $this->getLanguages()
        ]);
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

        $translatedText = $this->translator->translateText($data['text'], $data['source_lang'], $data['target_lang']);
        return response()->json([
            "status" => true,
            "data" => $translatedText
        ]);
    }

    /**
     * @throws DeepLException
     */
    public function getLanguages() {
        $sourceLanguages = $this->translator->getSourceLanguages();
        $targetLanguages = $this->translator->getTargetLanguages();

        sort($sourceLanguages);
        sort($targetLanguages);

        return [
            'source' => $sourceLanguages,
            'target' => $targetLanguages
        ];
;
    }
}
