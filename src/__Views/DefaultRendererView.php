<?php
/*
	DefaultRendererView - BaseView with default renderer

	Most applications use some prefered view renderer.
	We use static property for such common value.
*/
namespace Vsd\Mvcs\Views;
use Vsd\Mvcs\Views\Traits\BaseViewTrait;
use Vsd\Mvcs\Views\Traits\DefaultRendererViewTrait;

class DefaultRendererView
{
	use BaseViewTrait, DefaultRendererViewTrait {
		DefaultRendererViewTrait::getRenderer insteadof BaseViewTrait;
	}
}
