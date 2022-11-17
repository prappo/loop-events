<?php

namespace Loop;

abstract class Base {

	private $post_type = 'loop-event';

	public function get_post_type() {
		return $this->post_type;
	}
	abstract public function init();
}
