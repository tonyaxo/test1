<?php

namespace app\validators;

class DateValidator extends \yii\validators\DateValidator
{
    public function clientValidateAttribute($model, $attribute, $view)
    {
        $message = json_encode($this->message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return <<<JS
            var bits = value.split('.', 3);
            var d = Date.parse(bits[2] + '-' + bits[1] + '-' + bits[0] + 'T00:00:00');
            console.log(d);
            if (isNaN(d) == true) {
                messages.push($message);
            }
JS;
    }
}
