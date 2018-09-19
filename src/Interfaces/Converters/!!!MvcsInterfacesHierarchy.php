<?php
/**
 * Specific nature of MVCS design pattern requires some special MVCS components
 * 
 * MVCS is a variation of an MVC (model-view-controller) components interactions.
 * The main difference lies in MVCS controller - it does not responsible
 * for making the decision of which model and view to select.
 * Such decision are imposed on any external router.
 * So MVCS controller is only responcible for model-view interactions.
 * 
 * Major MVCS components are:
 * 	- responder		Analog of an MVC controller.
 * 					Calls compiler and decorator to produce a response.
 * 	- compiler		Analog of an MVC model.
 * 					Retrieves model data appropriate for the request.
 * 	- decorator		Analog of an MVC view.
 * 					Decorates compilers data according to the request
 * 
 * Decorators could be of two types: callable (core, base, general) | renderable (templated)
 * Renderable decorators could be of two sub-types: renderer and view.
 */

namespace Vsd\Mvcs\Interfaces;

// Any component `instanceof` marker only (without methods)
interface ComponentInterface {};

// MVCS component helpers
interface InvokerInterface {};
interface ContainerInterface extends PsrContainerInterface {};
interface ResolverInterface extends InvokerInterface, ContainerInterface {};

// MVCS component :== Component + Resolver + Container + Invoker
interface MvcsComponentInterface extends ComponentInterface, ResolverInterface {};

// Major MVCS components: responder, compiler, decorator
interface ResponderInterface extends MvcsComponentInterface {};
interface CompilerInterface extends MvcsComponentInterface {};
interface DecoratorInterface extends MvcsComponentInterface {};

// Decorators
interface MvcsDecoratorInterface extends DecoratorInterface, ResolverInterface {};
interface TemplatedDecoratorInterface extends DecoratorInterface {};
interface RendererInterface extends TemplatedDecoratorInterface {};
interface ViewerInterface extends TemplatedDecoratorInterface {};
