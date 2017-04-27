<?php

interface ParserInterface {

	/**
	 * 广度优先查询
	 * @param string $selector
	 * @param number $idx 找第几个,从0开始计算，null 表示都返回, 负数表示倒数第几个
	 * @return ParserInterface|ParserInterface[]
	 */
	public function find($selector, $idx = null);

	/**
	 * 返回文本信息
	 * @return string
	 */
	public function getPlainText();
	
	/**
	 * 获取html的元属值
	 * @param string $name
	 * @return string|null
	 */
	public function getAttr($name);

}

?>
