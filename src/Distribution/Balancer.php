<?php

namespace SF\Distribution;

class Balancer
{

    /**
     *
     * $nodes = [
     *     //node => weight
     *     //weight == virtualNodeNumber
     *     '192.168.0.10' => 10,
     *     '192.168.0.11' => 90,
     * ];
     * @var array
     */
    public $nodes;

    /**
     *
     * @var array
     */
    private $list = [];

    public function init()
    {
        if ($this->nodes === null) {
            $this->nodes = [];
        }

        foreach ($this->nodes as $node => $weight) {
            $this->addNode($node, $weight);
        }
    }

    /**
     * 增加节点
     * @param string $node
     * @param int $virtualNodeNum
     */
    public function addNode(string $node, int $virtualNodeNum)
    {
        for (; $virtualNodeNum; $virtualNodeNum--) {
            $this->list[$this->hash($node . $virtualNodeNum)] = $node;
        }
        ksort($this->list, SORT_NUMERIC);
    }

    /**
     * 计算hash值
     * @param string $object
     * @return int
     */
    public function hash(string $object): int
    {
        $hash = 0;
        $str  = md5($object);
        $len  = 32; //=strlen($str);
        for ($i = 0; $i < $len; $i++) {
            $hash = ($hash << 5) + $hash + ord($str[$i]);
        }

        return $hash & 0x7FFFFFFF;
    }

    /**
     * 查找结点
     * @param string $object
     * @return string|null
     */
    public function find(string $object)
    {
        if (empty($this->list)) {
            return null;
        }

        $hash = $this->hash($object);

        foreach ($this->list as $virtualNode => $node) {
            if ($hash <= $virtualNode) {
                return $node;
            }
        }

        return reset($this->list);
    }

    /**
     * 删除节点
     * @param string $node
     * @return boolean
     */
    public function delete(string $node)
    {
        $weight = $this->nodes[$node] ?? null;

        if ($weight === null) {
            return true;
        }

        for (; $weight; $weight--) {
            $this->delVirtualNode($node, $weight);
        }
    }

    /**
     * 删除虚拟节点
     * @param string $node
     * @param int $virtualNodeNum
     * @return boolean
     */
    public function delVirtualNode(string $node, int $virtualNodeNum)
    {
        $hash = $this->hash($node . $virtualNodeNum);

        if (isset($this->list[$hash])) {
            unset($this->list[$hash]);
        }

        return true;
    }

}
