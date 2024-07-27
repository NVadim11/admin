<?php
namespace Modules\Core\Services;

class ConstructorServices
{
    public function makeBlocks($data) {

        $blocks = '';
        $obj = json_decode($data);
        if($obj) {
            $constructor = $obj[0]->constructor;
        }

        if(!empty($constructor) && sizeof($constructor)) {
            foreach ($constructor as $k => $block) {
                if(!is_object($block)) {
                    $block = json_decode($block);
                }
                $params = json_decode($block->params[0]);
                $blocks .= '<div class="ctm-block" data-type="' . $block->module . '">';
                $blocks .= (string)view()->make('constructor::' . $block->module . '.' . $block->template, ['params' => $params]);
                $blocks .= '<textarea class="hidden json" name="json[]">' . json_encode($block) . '</textarea>';
                $blocks .= '</div>';
            }
        }

        return $blocks;
    }

    public function renderHtml($data) {
        $blocks = '';
        $obj = json_decode($data);
        if($obj) {
            $constructor = $obj[0]->constructor;
        }

        if(!empty($constructor) && sizeof($constructor)) {
            foreach ($constructor as $k => $block) {
                if(!is_object($block)) {
                    $block = json_decode($block);
                }
                $params = json_decode($block->params[0]);
                $blocks .= (string)view()->make('constructor::' . $block->module . '.' . $block->template, ['params' => $params]);
            }
        }

        return $blocks;
    }
}