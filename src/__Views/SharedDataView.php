<?php
/*
	DataView ::= BaseView + DataView + SharedData

!!! TODO: DataViewTrait::get() ignores shared data. Method should be overriden here !!!
*/
namespace Vsd\Mvcs\Views;
use Vsd\Mvcs\Views\Traits\BaseViewTrait;
use Vsd\Mvcs\Views\Traits\DataViewTrait;
use Vsd\Mvcs\Views\Traits\SharedDataViewTrait;

class SharedDataView implements ViewInterface
{
	use BaseViewTrait, DataViewTrait, SharedDataViewTrait;
}
