<?php
/*
	BaseView ::= Renderer + Template + Data

	BaseView properties:
		- Renderer is any callable, default renderer is not supported (see SharedDataView)
		- Template is of any type acceptable by renderer
		- Data is an associative array ONLY, not a callable,
			access to individual data items is not supported (see DataView)

	BaseView methods:
		- properties getters/setters
		- data & renderer resolvers for overloading in descendants
		- rendering methods: render(), renderNested(), __toString()

	Any view is an autonomous self-sufficient and self-renderable piece of page content of any kind (html, pdf,...).
	Terms 'self-renderable', 'self-sufficient' mean that any VIEW IS A RENDERER with it's own template and data.

	View renderer is a main view component and is always a callable which renders given template with given data.
	View template could be of any type wich is compatible to the view renderer.
	View data could be an associative data array or a callable returning an associative data array.
*/
namespace Vsd\Mvcs\Views;
use Vsd\Mvcs\Views\Traits\BaseViewTrait;

class BaseView implements ViewInterface
{
	use BaseViewTrait;
}
