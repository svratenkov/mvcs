# MVCS (Model-View-Controller-Scenario)

## MVCS concepts

### Modern frameworks shortcomings

Let's look at typical modern frameworks *"fat controller"* implementation:
```php
class UserController extends Controller
{
	// Display user greeting for given user ID
	public function actionUserHello($userId)
	{
		// Retrieve first and last user names from User model (DB)
		$user = User::find($userId);

		// View template needs full user name - compile it
		$name = $user->firstName.' '.$user->lastName;

		// Create view with hard-coded template and compiled data
		$view = new View('hello', ['name' => $name]);

		// Render view and return a response
		return $view->render();
	}
}
```
What we see here is an easy to cook, but hard to eat MVC salad. We see *Model presence in the Controller*. We see template name which is *hard-coded in the Controller*, we need to recode to change it. We can't change the *rendering method*, for example from html to pdf, we need to develop special view class for pdf rendering.

> Modern frameworks have some common shortcomings in their MVC implementation:
> 1. Narrow treating of View component as a *"PHP file template renderer"* ***only*** instead of something like *"any renderer"*.
> 2. Narrow treating of Model component as a Database component ***only*** instead of something like *"any data gatherer"*.
> 3. Provoking to use so called *"fat controllers"* when controller contains altogether business, presentation and interaction logics. This totally violates the main MVC goal to separate concerns between it's components triad.

To resolve this gaps we should define Model, View and Controller components responsibilities more carefully.

### View is a renderer

Let's look at the first gap:
> 1. Narrow treating of View component as a *"PHP file template renderer"* ***only*** instead of something like *"any renderer"*.

To resolve this gap we only need to say that any view may use any renderer. To implement this we need to add `renderer` property to a View class: 
```php
class View {
	public $template, $data, $renderer;

	public function __costruct($template, $data, $renderer = NULL) {}
}
```
We have stated that renderer is an important component of the view. A renderer is a callable that renders given data using given template.

We can also say that the view itself is a renderer, moreover it is a specific renderer which holds it's own template, data and even renderer.

Most applications use only one renderer, and even if they use multiple then they have some default renderer. That's why we defined renderer arg in the View constructor as optional, assuming an existence of some application's default renderer.

### ViewModel vs DomainModel

Let's look at the second gap:
> 2. Narrow treating of Model component as a Database component ***only*** instead of something like *"any data gatherer"*.

It is obvious that data saved in the database nearly never corresponds to data needs for a concrete template. Database data is really a base for a lot of different templates. This is called as DomainModel data and a ViewModel data, where DomainModel is a database level data, while ViewModel is a data for the concrete view. And we always need to convert domain data to view data.

As modern frameworks does not have ViewModel components, the simplest way is to convert domain data in the controller. And to violate basic MVC principles.

So to implement MVC we have to define ViewModel. The direct way is to implement ViewModel as a callable that converts input domain data to an output model data.

### Scenario vs fat controller

Let's look at the third gap:
> 3. Provoking to use so called *"fat controllers"* when controller contains altogether business, presentation and interaction logics. This violates the main MVC goal to separate concerns between it's components triad.

As we already delegated business logics to a Model, presentation to a View (i.e. renderer), then the only responsibility remains  is the interaction logics  and it should be assigned to the Controller. This task looks extremely diverse, but it only looks so.

If we examine any request flow we will find a simple chain of some consecutive steps. Most of them are common for different requests, others could be unique for some requests only. Nevertheless all of them are steps.

Each step is simply a data converter. Client-Server application could be considered as a single high level converter of app request data to app response data. This high level converter may consist of some lower level   chained converters, such as:
 - DomainModel converts application request to raw domain data,
 - ViewModel converts domain data to view data,
 - View converts view data to an application response (by rendering view data according to view template).

There could be specific "converters" like redirects, data validators, ajax exits, so on.

We will call such converters chain as `scenario` and each step in the chain as a `scenario action`.

### MVCS scenario implementation example

Lets see how the above *"fat controller"* example could be implemented in MVCS.

The first step is to create MVCS controller:
```php
// Create MVCS controller
$mvcs = new Controller();
```
Lets assume the application router maps URI's like 'user/info/XXX' to:
```php
$requestAction = 'user/hello';
$requestParams = ['XXX'];
```
MVCS controller handles `scenarios` only rather then URI's. So we need some mapping of MVCS scenarios to request URI's. The best place for this is the MVCS container:
```php
// Map MVCS scenarios to request actions
$mvcs->set('scenarios', [
	'user/hello' => 'UserModel > UserViewModel > view, hello',
	...,
]);
```
Please look at the scenario defined. It is a chain of three `scenario actions` delimited by '>' sign: 
 - 'UserModel' is a name of raw user data getter with request parameters as input,
 - 'UserViewModel' is a name of a converter of raw user data to the view template data,
 - 'view, hello' is a MVCS system viewer with 'hello' template as an argument, delimited with comma sign.

Now we only need to define two `scenario actions`  as callbacks in the container:
```php
// Define UserModel
$mvcs->set('UserModel', function($id) {
	$users = [
		1 => ['first' => 'John', 'last' => 'Smith'],
		2 => ['first' => 'Ivan', 'last' => 'Petrov'],
	];
	return isset($users[$id]) ? $users[$id] : NULL;
});
// Define UserViewModel
$mvcs->set('UserViewModel', function($user) {
	// Prepare data for php template like: 'echo "Hello, $name!"';
	return ['name' => $user['first'].' '.$user['last']];
});
```
That's all! For any application request we should define `scenario` and all it's `scenario actions` (except system actions like 'view'). Nothing more.

And now we are ready to test application for some URI's:
```php
// Get MVCS scenario for current request action
$scenarios = $mvcs->get('scenarios');
$scenario = $scenarios[$requestAction];

// Play scenario with some request params...

// For request 'user/hello/1' will return 'John Smith' rendered with 'hello' template
$requestParams = ['1'];
$response = $mvcs->play($scenario, $requestParams);

// For request 'user/hello/2' will return 'Ivan Petrov' rendered with 'hello' template
$requestParams = ['2'];
$response = $mvcs->play($scenario, $requestParams);
```

> *This example could be found in the `example` directory of MVCS module.*

As we can see both 'fat controller' and MVCS implementations are quite similar. Their difference lies in the separation of three main concerns  discussed earlier. Due to such separation MVCS has more flexibility and clarity.

## MVCS components

### Scenario

Scenario is a base MVCS component. It is an analog of an MVC's `fat controller` action. Due to scenarios MVCS does not need any customizable controller actions, so MVCS Controller is an immutable internal class.

Scenario is a chain of primitive actions. Each action is simply a data converter. It converts its input data to an output data. Those output data became an input to the next chained action. 

And the scenario itself acts as a single converter which converts application request to an application response.

### Scenario examples

String format (suitable for RegEx routers):
```php
// 2 actions: UserModel::list getter & render with 'user/list' template
'user:list > render,user/list'

// 2 actions: UserModel::login getter & redirect to 'success' page
'user:login > redirect,success'

// 2 actions: UserModel::role getter & (ajax) exit
'user:role > exit'
```

The same in an array format:
```php
// 2 actions: UserModel::list getter & render with 'user/list' template
['user:list', 'render,user/list']
...
```

The same in a base format:
```php
// Any string or array definition of actions chain
$definition = 'user:list > render,user/list';
$scenario = new Scenario($definition);
...
```

### Scenario actions

Scenario action is any callable which converts its input data array to an output data array. Scenario action accepts one required argument for input data and optional variadic parameters list:
```php
$scenarioAction = function($input, ...$params) {}
```
Scenario action should return an output data array.

There are some specifics in scenario actions.

 - The *first* action in the chain is a data `compiler`. It is an analog of the MVC `Model` component. It retrieves domain model (database) data according to model state given by request parameters. Compiler accepts application request parameters which are not an associative data array, but are a consecutive list of request parameters.
 - The *last* action in the chain is a data `decorator` returning string application response rather then associative data array. It is an analog of the MVC `View` component. 
 - Any *intermediate* action is called `filter` and they accept and return an associative data array. Any `filter` usually converts input data to an output and acts as `ViewModel` which prepares data for any concrete view. But `filters` can also perform data validation, redirects, ajax exits, json encoding or anything else.

### MVCS controller

As noted above MVCS `controller` doesn't have model-view interactions responsibilities, which are delegated to an MVCS `scenario`. MVCS `controller`'s main and highly important responsibility is to deal with application and isolate MVCS module from any application specifics.

Most significant responsibilities of MVCS `controller` are:
 - Retrieve `scenario` and `scenario parameters` from the application, usually from the router.
 - Create `scenario` instance and play it with given `scenario parameters`.
 - Return `scenario` response back to application.
 - Maintain MVCS container.

### MVCS container and resolver

MVCS module uses container to hold all the scenarios items and their unique names (aliases). These items are application specific models, renderers and actions.

Scenario container uses any external PSR Container which implements two methods: get() and  has(). It uses it's internal container if an external is not given.

MVCS has container items resolver to support resolving of various kinds of callable definitions. MVCS resolver can resolve some special keys:
 - "keyalias" is a key of another container entry.
 - "key:method" is a special key pattern for some method of some class or object.


## MVC / MVCS comparison

MVCS is a variation of MVC pattern. The main difference lies in further separation of concerns and correspondent refinement of all MVC components roles.

 - MVC `Model`-`View` interactions refinement. MVCS defines special component `Scenario` for handling such interactions. `Scenario` can define any set of actions to transform app request to app response. For example: popular `ViewModel` component is a natural action in a common `model > viewmodel > view` scenario chain.
 - MVC `View` component is actually a kind of MVCS renderer.
 - MVCS `Controller` controls `scenarios` rather than `Model-View` interactions (which are controlled by `scenarios`). For example: we can implement so called Layout View with some special LayoutController which will send the response of main scenario to a special app layout scenario.
 - Any MVCS component (`scenarios`, `scenario actions`, `renderers`) could be stored in the scenario container and automatically resolved by their container name (key).

