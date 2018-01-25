<?php

namespace app\widgets;

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\InputWidget;

/**
 * Class YandexSuggestWidget
 */
class YandexSuggestWidget extends InputWidget
{
    const YANDEX_MAPS_JS_URL = 'https://api-maps.yandex.ru/2.1/';

    protected $_language;

    public function init()
    {
        parent::init();
        Html::addCssClass($this->options, 'form-control');
    }

    public function run()
    {
        $this->registerScripts();
        echo $this->renderInputHtml('text');
    }

    public function registerScripts()
    {
        $scriptUrl = self::YANDEX_MAPS_JS_URL . '?lang=' . $this->getLanguage();
        $this->view->registerJsFile($scriptUrl, ['position' => View::POS_HEAD], 'ya-maps');

        $id = $this->getId();
        $inputId = $this->options['id'];

        $this->view->registerJs(<<<JS
            ymaps.ready(initSuggest);

            function initSuggest() {
                var suggestView{$id} = new ymaps.SuggestView('$inputId');
                suggestView{$id}.events.add('select', function (e) {
                    console.log(e.get('item').value);
                });
            }            
JS
, View::POS_END);
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        if ($this->_language === null) {
            $this->_language = \Yii::$app->language;
        }
        return $this->_language;
    }

    /**
     * @param mixed $language
     */
    public function setLanguage($language): void
    {
        $this->_language = $language;
    }
}
