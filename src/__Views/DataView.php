<?php
/*
	DataView ::= BaseView + view data itmes access
*/
namespace Vsd\Mvcs\Views;
use Vsd\Mvcs\Views\Traits\BaseViewTrait;
use Vsd\Mvcs\Views\Traits\DataViewTrait;

class DataView implements ViewInterface
{
	use BaseViewTrait, DataViewTrait;
}
