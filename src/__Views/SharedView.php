<?php
/*
	SharedView ::= BaseView + SharedData
*/
namespace Vsd\Mvcs\Views;
use Vsd\Mvcs\Views\Traits\BaseViewTrait;
use Vsd\Mvcs\Views\Traits\SharedDataViewTrait;

class SharedView implements ViewInterface
{
	use BaseViewTrait, SharedDataViewTrait;
}
