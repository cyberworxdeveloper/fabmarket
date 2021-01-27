<?php
namespace Vgroup65\Testimonial\Model\Config\Source;
use Magento\Framework\Option\ArrayInterface;
class DisplayType implements ArrayInterface {

    public function toOptionArray() {
        $arr = $this->toArray();
        $ret = [];
        foreach ($arr as $key => $value) {
            $ret[] = [
                'value' => $key,
                'label' => $value
            ];
        }
        return $ret;
    }

    public function toArray() {
        $choose = [
            'list' => 'List',
            'grid' => 'Grid'
        ];
        return $choose;
    }
}
