<?php namespace Illuminate\Database\Query\Grammars;

use Illuminate\Database\Query\Builder;

class PostgresGrammar extends Grammar {

	/**
	 * Compile an insert and get ID statement into SQL.
	 *
	 * @param  \Illuminate\Database\Query\Builder  $query
	 * @param  array   $values
	 * @param  string  $sequence
	 * @return string
	 */
	public function compileInsertGetId(Builder $query, $values, $sequence)
	{
		if (is_null($sequence)) $sequence = 'id';

		return $this->compileInsert($query, $values).' returning '.$this->wrap($sequence);
	}

	/**
	 * Compile a truncate table statement into SQL.
	 *
	 * @param  \Illuminate\Database\Query\Builder  $query
	 * @return array
	 */
	public function compileTruncate(Builder $query)
	{
		return array('truncate '.$this->wrapTable($query->from).' restart identity' => array());
	}

}