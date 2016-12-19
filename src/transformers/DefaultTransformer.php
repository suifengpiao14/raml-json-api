<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 19.12.16
 * Time: 20:14
 */

namespace rjapi\transformers;


use League\Fractal\TransformerAbstract;
use rjapi\exception\ModelException;
use rjapi\extension\BaseFormRequest;
use rjapi\extension\BaseModel;

class DefaultTransformer extends TransformerAbstract
{
    private $middleWare = null;

    public function __construct(BaseFormRequest $middleWare)
    {
        $this->middleWare = $middleWare;
    }

    public function transform(BaseModel $object)
    {
        $rules = $this->middleWare->rules();
        $arr = [];
        try {
            foreach ($rules as $prop => $rule) {
                $arr[$prop] = $object->$prop;
            }
        } catch (ModelException $e) {
            $e->getTraceAsString();
        }
        return $arr;
    }
}