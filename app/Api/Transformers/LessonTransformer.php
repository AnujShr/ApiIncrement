<?php
/**
 * Created by PhpStorm.
 * User: anuj
 * Date: 5/16/19
 * Time: 1:28 PM
 */

namespace App\Api\Transformers;


class LessonTransformer extends Transformer
{

    /**
     * @param array $lesson
     * @return array
     */
    public function transform(array $lesson)
    {
        return [
            'title'  => $lesson['title'],
            'body'   => $lesson['body'],
            'active' => (boolean)$lesson['some_bool']
        ];
    }

}