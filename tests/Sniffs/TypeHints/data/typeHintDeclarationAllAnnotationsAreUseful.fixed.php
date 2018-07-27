<?php declare(strict_types = 1);

class Whatever
{

	public function uselessDoccomment()
	{

	}

	public function uselessDoccommentWithParameters(int $a, int $b)
	{

	}

	/**
	 * @whatever
	 * @return void
	 */
	public function usefulDoccomment()
	{

	}

	/**
	 * @param int $a
	 * @param int $b
	 * @return void
	 * @whatever
	 */
	public function usefulDoccommentWithParameters(int $a, int $b)
	{

	}

}
