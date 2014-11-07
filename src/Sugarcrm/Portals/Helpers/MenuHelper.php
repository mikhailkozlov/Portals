<?php namespace Sugarcrm\Portals\Helpers;

use Illuminate\Database\Eloquent\Collection;

class MenuHelper
{

    protected $items;
    protected $url_base;

    public function __construct(Collection $items, $base = '/')
    {
        $this->items = $items;
        $this->url_base = $base;

        return $this;
    }

    public function htmlList()
    {
        return $this->htmlFromArray($this->itemArray());
    }

    public function makeFlatArray($items = array(), $level = 0)
    {
        if (empty($items)) {
            $items = $this->itemArray();
        }
        $newArray = array();
        foreach ($items as $k => $v) {
            $newArray[$k] = str_repeat('- ', $level) . $v['title'];
            if (array_key_exists('children', $v) && count($v['children']) > 0) {
                $sub_tree = $this->makeFlatArray($v['children'], $level + 1);
                foreach ($sub_tree as $sk => $sv) {
                    $newArray[$sk] = $sv;
                }
            }
        }

        return $newArray;
    }

    public function itemArray()
    {
        $result = array();
        foreach ($this->items as $item) {
            if ($item->parent_id == 0) {
                $result[$item->id]['title'] = $item->title;
                $result[$item->id]['link'] = $this->url_base . $item->slug;
                $result[$item->id]['children'] = $this->itemWithChildren($item);
            }
        }

        return $result;
    }

    private function childrenOf($item)
    {
        $result = array();
        foreach ($this->items as $i) {
            if ($i->parent_id == $item->id) {
                $result[] = $i;
            }
        }

        return $result;
    }

    private function itemWithChildren($item)
    {
        $result = array();
        $children = $this->childrenOf($item);
        foreach ($children as $child) {
            $result[$child->id]['title'] = $child->title;
            $result[$child->id]['link'] = $child->link;
            $result[$child->id]['children'] = $this->itemWithChildren($child);
        }

        return $result;
    }

    private function htmlFromArray($array)
    {
        $html = '';
        foreach ($array as $k => $v) {
            $html .= '<li><a href="' . $v['link'] . '">' . $v['title'] . '</a>';
            if (array_key_exists('children', $v) && count($v['children']) > 0) {
                $html .= '<ul>';
                $html .= $this->htmlFromArray($v['children']);
                $html .= '</ul>';
            }
            $html .= '</li>';
        }

        return $html;
    }
}
