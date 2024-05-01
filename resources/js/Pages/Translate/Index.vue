<template>
    <header>
        <span class="header-text">Translate</span>
    </header>
    <div class="container-sm d-flex bg-indigo-300">
        <div id="source-container">
            <div>
                <select name="source-lang" @change="setSourceLanguage($event)">
                    <option value="null">Auto Detect</option>
                    <option v-for="lang in this.languages.source" :value="lang.code">{{lang.name}}</option>
                </select>
            </div>
            <textarea id="translate-from" placeholder="Enter Text..." @keyup="translateTrigger.invoke($event.target.value)" @keyup.delete="translateTrigger.invoke($event.target.value)"></textarea>
        </div>
        <div id="target-container">
            <div>
                <select name="target-lang"  @change="setTargetLanguage($event)" v-model="targetLang">
                    <option v-for="lang in this.languages.target" :value="lang.code">{{lang.name}}</option>
                </select>
            </div>
            <textarea id="translate-result" placeholder="Translation" readonly>{{translatedText}}</textarea>
        </div>
    </div>
</template>

<script>
import utils from "@jsAssets/utils";
import route from "ziggy-js";

export default {
    name: "Translate",
    props: {
        languages: Object
    },
    data() {
        return {
            translateTrigger: null,
            sourceLanguages: [],
            targetLanguages: [],
            sourceLang: null,
            targetLang: 'EN-US',
            translatedText: ''
        }
    },
    methods: {
        translateText: async function(translateText) {
            if(translateText == null || '')
            {
                return;
            }

            let res = await axios.post(route('translate-text'),
            {
                text: translateText,
                source_lang: this.sourceLang,
                target_lang: this.targetLang,
                formality: 'prefer_less'
            });

            this.translatedText = res.data.data.text
        },
        setSourceLanguage: function(event) {
            if(typeof event === 'string') {
                this.sourceLang = event;
            }
            else
            {
                this.sourceLang = event.target.value;
            }
        },
        setTargetLanguage: function(event)  {
            this.targetLang = event.target.value;
        }
    },
    mounted() {
        this.translateTrigger = new utils.rollingTrigger(this.translateText, 750);
    }
}
</script>


<style scoped>
    #source-container {
        margin-right: 10px;
    }

    #translate-from,
    #translate-result {
        width: 100%;
        margin-top: 10px;
        height: 200px;
        resize: none;
    }

    #target-container,
    #source-container {
        width: 50%;
        margin-top: 20px;
    }

    select {
        width:250px;
    }
</style>
