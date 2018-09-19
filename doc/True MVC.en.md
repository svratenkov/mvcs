<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>True MVC.en.md</title>
  <link rel="stylesheet" href="https://stackedit.io/style.css" />
</head>

<body class="stackedit">
  <div class="stackedit__left">
    <div class="stackedit__toc">
      
<ul>
<li>
<ul>
<li><a href="#mvvm-model---view--viewmodel">#MVVM (Model - View -ViewModel)</a></li>
</ul>
</li>
<li><a href="#concepts">Concepts</a>
<ul>
<li><a href="#modern-frameworks-shortcomings">Modern frameworks shortcomings</a></li>
<li><a href="#mvc-components-who-should-do-what">MVC Components: who should do what?</a></li>
<li><a href="#routing">Routing</a></li>
<li><a href="#model">Model</a></li>
<li><a href="#viewmodel">ViewModel</a></li>
</ul>
</li>
</ul>

    </div>
  </div>
  <div class="stackedit__right">
    <div class="stackedit__html">
      <h2 id="mvvm-model---view--viewmodel">#MVVM (Model - View -ViewModel)</h2>
<p>[TOC]</p>
<h1 id="concepts">Concepts</h1>
<h2 id="modern-frameworks-shortcomings">Modern frameworks shortcomings</h2>
<p>Let’s look at modern frameworks <em>“fat controller”</em> implementation:</p>
<pre class=" language-php"><code class="prism  language-php"><span class="token keyword">class</span> <span class="token class-name">UserController</span> <span class="token keyword">extends</span> <span class="token class-name">Controller</span>
<span class="token punctuation">{</span>
	<span class="token comment">// Displays user info for given user ID</span>
	<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">actionUserInfo</span><span class="token punctuation">(</span><span class="token variable">$user_id</span><span class="token punctuation">)</span>
	<span class="token punctuation">{</span>
		<span class="token comment">// Retrieve raw user data from user model</span>
		<span class="token variable">$user</span> <span class="token operator">=</span> User<span class="token punctuation">:</span><span class="token punctuation">:</span><span class="token function">find</span><span class="token punctuation">(</span><span class="token variable">$user_id</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

		<span class="token comment">// Compile view data from raw domain data</span>
		<span class="token variable">$name</span> <span class="token operator">=</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">firstName</span><span class="token punctuation">.</span><span class="token string">' '</span><span class="token punctuation">.</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">lastName</span><span class="token punctuation">;</span>

		<span class="token comment">// Create view with hard-coded template and retrieved data</span>
		<span class="token variable">$view</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">View</span><span class="token punctuation">(</span><span class="token string">'user_info'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$name</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

		<span class="token comment">// Render and return</span>
		<span class="token keyword">return</span> <span class="token variable">$view</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">render</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
	<span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</code></pre>
<p>What we see here is an easy to cook, but hard to eat MVC salad. We can see <em><strong>Model presence in the Controller</strong></em>. We can see <em><strong>hard-coded template name</strong></em>, we need to recode to change it. We can’t change the <em><strong>rendering method</strong></em>, for example from html to pdf, we need to recode.</p>
<blockquote>
<p>Modern frameworks have some common shortcomings in their MVC implementation:</p>
<ol>
<li>Narrow treating of Model component as a Database component <em><strong>only</strong></em> instead of something like <em>“any data gatherer”</em>.</li>
<li>Narrow treating of View component as a <em>“PHP file template rendered with data array”</em> <em><strong>only</strong></em> instead of something like <em>“any renderer of any data”</em>.</li>
<li>Using so called <em>“fat controllers”</em> when controller action method contains both business logic and a view creation. This violates MVC separation of concerns between Controller and Model, because business logic should belong to a Model rather then to Controller.</li>
</ol>
</blockquote>
<p>To resolve this gaps we need to redefine Model, View, Controller components more clearly.</p>
<h2 id="mvc-components-who-should-do-what">MVC Components: who should do what?</h2>
<p>Desired MVC components responsibilities:</p>
<ul>
<li><code>Model</code>:
<ul>
<li>generates view data,</li>
<li>sets view data state according to request parameters,</li>
<li>validates user input.</li>
</ul>
</li>
<li><code>View</code>:
<ul>
<li>handles template, data and renderer as properties to support lazy rendering,</li>
<li>calls view renderer with view’s template and data.</li>
</ul>
</li>
<li><code>Controller</code>:
<ul>
<li>controls request flow, various request methods (GET, POST, …), redirects, special request types (Ajax, …),</li>
<li>receives requested set of template, model, renderer from the Router,</li>
<li>creates view for given set of template, model, renderer,</li>
<li>calls view renderer and returns it’s response back to user.</li>
</ul>
</li>
</ul>
<h2 id="routing">Routing</h2>
<pre class=" language-php"><code class="prism  language-php">    <span class="token comment">// User home (main) page</span>
    <span class="token variable">$route</span> <span class="token operator">=</span> <span class="token string">'/user'</span><span class="token punctuation">;</span>
	<span class="token variable">$controller</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">UserController</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
	<span class="token variable">$controllerAction</span> <span class="token operator">=</span> <span class="token string">'home'</span><span class="token punctuation">;</span>
	<span class="token variable">$template</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">Template</span><span class="token punctuation">(</span><span class="token string">'user.home'</span><span class="token punctuation">,</span> <span class="token string">'php'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
	<span class="token variable">$model</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">UserModel</span><span class="token punctuation">(</span><span class="token variable">$requestParameters</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
	<span class="token variable">$view</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">View</span><span class="token punctuation">(</span><span class="token variable">$template</span><span class="token punctuation">,</span> <span class="token variable">$model</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

    <span class="token comment">// User list page</span>
    <span class="token variable">$route</span> <span class="token operator">=</span> <span class="token string">'/user/list'</span><span class="token punctuation">;</span>
	<span class="token variable">$model</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">UserListModel</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
	<span class="token variable">$view</span>  <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">UserListView</span><span class="token punctuation">(</span>UserListModel <span class="token variable">$model</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment">//	$controller = new UserListController();</span>

    <span class="token comment">// User list ordered by name page</span>
    <span class="token variable">$route</span> <span class="token operator">=</span> <span class="token string">'/user/list/byname'</span><span class="token punctuation">;</span>
	<span class="token variable">$model</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">UserListModel</span><span class="token punctuation">(</span><span class="token string">'byname'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
	<span class="token variable">$view</span>  <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">UserListView</span><span class="token punctuation">(</span><span class="token variable">$model</span><span class="token punctuation">,</span> <span class="token string">'byname'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment">//	$controller = new UserListBynameController();</span>



</code></pre>
<h2 id="model">Model</h2>
<p>MVVM <code>Model</code> component relates so-called <code>DomainData</code> which means the base level system or common data. Examples of system data: DB, session, config, constants and variables, … Examples of common data: User, Product, Cart, …</p>
<h3 id="model-responsibilities"><code>Model</code> responsibilities</h3>
<p><code>Model</code> is responsible for:</p>
<ul>
<li><code>DomainData</code> state setting / changing</li>
<li><code>DomainData</code> generation or gathering</li>
<li>user input validation</li>
</ul>
<h3 id="model-hierarchy"><code>Model</code> hierarchy</h3>
<p><code>Model</code>'s  may depends on another <code>models</code> and may organize some hierarchy.</p>
<h3 id="models-implementation"><code>Model</code>'s implementation</h3>
<p>Implemented as class. <code>Model</code>s class has important methods:</p>
<ul>
<li>array getData(…$args) - one or more data getters returning associative array [‘var’ =&gt; ‘value’] which corresponds to given state args</li>
<li>setState(…$args) - set model state according to given args, optional for simple models</li>
<li>validate(array $vars) - validate user input, optional for simple models</li>
</ul>
<h2 id="viewmodel"><code>ViewModel</code></h2>
<p>ViewModel is a model designed for using with concrete View Template. Each template should have it’s own personal ViewModel. There are no any special features compared to Model. The only difference is their purpose - while Model contains more general data so called <code>DomainData</code>, ViewModel contains concrete data for the concrete view, such data is called <code>AppData</code> or <code>ViewData</code>.</p>
<p>Basic example of domain and app data:</p>
<pre><code>// Domain data retrieved from database
$user = User::find(123);
$firstName = $user-&gt;firstName();
$lastName = $user-&gt;lastName();

// App or view data compiled from raw domain data
$name = $firstName.' '.$lastName
</code></pre>
<blockquote>
<p>Written with <a href="https://stackedit.io/">StackEdit</a>.</p>
</blockquote>

    </div>
  </div>
</body>

</html>
