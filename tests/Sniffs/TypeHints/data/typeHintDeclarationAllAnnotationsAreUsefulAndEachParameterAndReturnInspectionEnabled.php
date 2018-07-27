<?php declare(strict_types = 1);

class Whatever
{

	/**
	 * @return void
	 */
	public function uselessDoccomment()
	{

	}

	/**
	 * @param int $a
	 * @param int $b
	 * @return void
	 */
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
