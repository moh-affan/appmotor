<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * A Controller base that provides lots of flexible basics for CodeIgniter applications,
 * including:
 *     - A basic template engine
 *     - More readily available 'flash messages'
 *     - autoloading of language and model files
 *     - flexible rendering methods making JSON simple.
 *     - Automatcially migrating.
 *
 * NOTE: This class assumes that a couple of other libraries are in use in your
 * application:
 *     - eldarion-ajax (https://github.com/eldarion/eldarion-ajax) for simple AJAX.
 *         Only used by the render_json method to return profiler info and
 *
 */
class MY_Controller extends CI_Controller
{

	/**
	 * The type of caching to use. The default values are
	 * set here so they can be used everywhere, but
	 */
	protected $cache_type = 'dummy';
	protected $backup_cache = 'file';

	// If TRUE, will send back the notices view
	// through the 'render_json' method in the
	// 'fragments' array.
	protected $ajax_notices = true;

	// If set, this language file will automatically be loaded.
	protected $language_file = NULL;

	// If set, this model file will automatically be loaded.
	protected $model_file = NULL;
	protected $use_title = '';
	protected $external_scripts = array();
	protected $stylesheets = array();
	protected $inline_style = '';
	protected $inline_script = '';
	protected $vars = array();
	protected $message;

	protected $menu_active = '';

	// Stores data variables to be sent to the view.
	protected $auto_migrate = false;

	// For status messages
	private $use_view = '';

	// Should we try to migrate to the latest version
	// on every page load?
	private $use_layout = '';

	//--------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();

		//--------------------------------------------------------------------
		// Cache Setup
		//--------------------------------------------------------------------

		// Make sure that caching is ALWAYS available throughout the app
		// though it defaults to 'dummy' which won't actually cache.
		$this->load->driver('cache', array('adapter' => $this->cache_type, 'backup' => $this->backup_cache));

		//--------------------------------------------------------------------
		// Language & Model Files
		//--------------------------------------------------------------------

		if (!is_null($this->language_file)) $this->lang->load($this->language_file);

		if (!is_null($this->model_file)) {
			/*
                This does not automatically load the database.
                If you're using my MY_Model, it will load it for you.
                otherwise, you should load it in your autoload config
                or within your model itself.
             */
			$this->load->model($this->model_file);
		}

		//--------------------------------------------------------------------
		// Migrations
		//--------------------------------------------------------------------

		// Try to auto-migrate any files stored in APPPATH ./migrations
		if ($this->auto_migrate === TRUE) {
			$this->load->library('migration');

			// We can specify a version to migrate to by appending ?migrate_to=X
			// in the URL.
			if ($mig_version = $this->input->get('migrate_to')) {
				$this->migration->version($mig_version);
			} else {
				$this->migration->latest();
			}
		}

		//--------------------------------------------------------------------
		// Profiler
		//--------------------------------------------------------------------

		// The profiler is dealt with twice so that we can set
		// things up to work correctly in AJAX methods using $this->render_json
		// and it's cousins.
		if ($this->config->item('show_profiler') == true) {
			$this->output->enable_profiler(true);
		}

		//--------------------------------------------------------------------
		// Development Environment Setup
		//--------------------------------------------------------------------
		//
		if (ENVIRONMENT == 'development') {

		}
	}

	//--------------------------------------------------------------------

	//--------------------------------------------------------------------
	// "Template" Functions
	//--------------------------------------------------------------------

	/**
	 * Sets a data variable to be sent to the view during the render() method.
	 *
	 * @param string $name
	 * @param mixed $value
	 */
	public function set_var($name, $value = null)
	{
		if (is_array($name)) {
			foreach ($name as $k => $v) {
				$this->vars[$k] = $v;
			}
		} else {
			$this->vars[$name] = $value;
		}
	}

	//--------------------------------------------------------------------

	/**
	 * Specifies a custom view file to be used during the render() method.
	 * Intended to be used as a chainable 'scope' method prioer to calling
	 * the render method.
	 *
	 * Examples:
	 *      $this->view('my_view')->render();
	 *      $this->view('users/login')->render();
	 *
	 * @param  string $view The relative path/name of the view file to use.
	 * @return MY_Controller instance
	 */
	public function view($view)
	{
		$this->use_view = $view;

		return $this;
	}

	//--------------------------------------------------------------------

	/**
	 * Specifies a custom layout file to be used during the render() method.
	 * Intended to be used as a chainable 'scope' method prioer to calling
	 * the render method.
	 *
	 * Examples:
	 *      $this->layout('two_left')->render();
	 *
	 * @param  string $view The relative path/name of the view file to use.
	 * @return MY_Controller instance
	 */
	public function layout($view)
	{
		$this->use_layout = $view;

		return $this;
	}

	//--------------------------------------------------------------------

	/**
	 * Specifies a title to show of the current page.
	 *
	 * Examples:
	 *      $this->title('Hello')->render();
	 *
	 * @param  string $title The title of the showing page.
	 * @return MY_Controller instance
	 */
	public function title($title)
	{
		$this->use_title = $title;

		return $this;
	}

	//--------------------------------------------------------------------

	/**
	 * Specifies selected active class menu to show in the current page.
	 *
	 * Examples:
	 *      $this->menu_active('hello')->render();
	 *
	 * @param  string $menu The menu class name to show.
	 * @return MY_Controller instance
	 */
	public function menu_active($menu)
	{
		$this->menu_active = $menu;

		return $this;
	}

	//--------------------------------------------------------------------

	/**
	 * Sets a status message (for displaying small success/error messages).
	 * This is used in place of the session->flashdata functions since you
	 * don't always want to have to refresh the page to show the message.
	 *
	 * @param string $message The message to save.
	 * @param string $type The string to be included as the CSS class of the containing div.
	 */
	public function set_message($message = '', $type = 'info')
	{
		if (!empty($message)) {
			if (isset($this->session)) {
				$this->session->set_flashdata('message', $type . '::' . $message);
			}

			$this->message = array(
				'type' => $type,
				'message' => $message
			);
		}
	}

	//--------------------------------------------------------------------

	//--------------------------------------------------------------------
	// Status Messages
	//--------------------------------------------------------------------

	/**
	 * Renders a string of aribritrary text. This is best used during an AJAX
	 * call or web service request that are expecting something other then
	 * proper HTML.
	 *
	 * @param  string $text The text to render.
	 * @param  bool $typography If TRUE, will run the text through 'Auto_typography'
	 *                          before outputting to the browser.
	 *
	 */
	public function render_text($text, $typography = false)
	{
		// Note that, for now anyway, we don't do any cleaning of the text
		// and leave that up to the client to take care of.

		// However, we can auto_typogrify the text if we're asked nicely.
		if ($typography === true) {
			$this->load->helper('typography');
			$text = auto_typography($text);
		}

		$this->output->enable_profiler(false)
			->set_content_type('text/plain')
			->set_output($text);
	}

	//--------------------------------------------------------------------

	/**
	 * Sends the supplied string to the browser with a MIME type of text/javascript.
	 *
	 * Do NOT do any further processing after this command or you may receive a
	 * Headers already sent error.
	 *
	 * @param  mixed $js The javascript to output.
	 */
	public function render_js($js = null)
	{
		if (!is_string($js)) {
			throw new RenderException('No javascript passed to the render_js() method.');
		}

		$this->output->enable_profiler(false)
			->set_content_type('application/x-javascript')
			->set_output($js);
	}

	//--------------------------------------------------------------------


	//--------------------------------------------------------------------
	// Other Rendering Methods
	//--------------------------------------------------------------------

	/**
	 * Breaks us out of any output buffering so that any content echo'd out
	 * will echo out as it happens, instead of waiting for the end of all
	 * content to echo out. This is especially handy for long running
	 * scripts like might be involved in cron scripts.
	 *
	 * @return void
	 */
	public function render_realtime()
	{
		if (ob_get_level() > 0) {
			ob_end_flush();
		}
		ob_implicit_flush(true);
	}

	//--------------------------------------------------------------------

	/**
	 * Integrates with the bootstrap-ajax javascript file to
	 * redirect the user to a new url.
	 *
	 * If the URL is a relative URL, it will be converted to a full URL for this site
	 * using site_url().
	 *
	 * @param  string $location [description]
	 */
	public function ajax_redirect($location = '')
	{
		$location = empty($location) ? '/' : $location;

		if (strpos($location, '/') !== 0 || strpos($location, '://') !== false) {
			if (!function_exists('site_url')) {
				$this->load->helper('url');
			}

			$location = site_url($location);
		}

		$this->render_json(array('location' => $location));
	}

	//--------------------------------------------------------------------

	/**
	 * Converts the provided array or object to JSON, sets the proper MIME type,
	 * and outputs the data.
	 *
	 * Do NOT do any further actions after calling this action.
	 *
	 * @param  mixed $json The data to be converted to JSON.
	 */
	public function render_json($json)
	{
		if (is_resource($json)) {
			throw new RenderException('Resources can not be converted to JSON data.');
		}

		// If there is a fragments array and we've enabled profiling,
		// then we need to add the profile results to the fragments
		// array so it will be updated on the site, since we disable
		// all profiling below to keep the results clean.
		// remove false
		if (false && is_array($json)) {
			if (!isset($json['fragments'])) {
				$json['fragments'] = array();
			}

			if ($this->config->item('show_profile')) {
				$this->load->library('profiler');
				$json['fragments']['#profiler'] = $this->profiler->run();
			}

			// Also, include our notices in the fragments array.
			if ($this->ajax_notices === true) {
				$json['fragments']['#notices'] = $this->load->view('theme/notice', array('notice' => $this->message()), true);
			}
		}
		header('Content-Type: application/json');
		echo json_encode($json);
		exit(0);
//		$this->output->enable_profiler(false)
//			->set_content_type('application/json')
//			->set_output(json_encode($json));
	}

	//--------------------------------------------------------------------

	/**
	 * Retrieves the status message to display (if any).
	 *
	 * @param  string $message [description]
	 * @param  string $type [description]
	 * @return array|string
	 */
	public function message($message = '', $type = 'info')
	{
		$return = array(
			'message' => $message,
			'type' => $type
		);

		// Does session data exist?
		if (empty($message) && class_exists('CI_Session')) {
			$message = $this->session->flashdata('message');

			if (!empty($message)) {
				// Split out our message parts
				$temp_message = explode('::', $message);
				$return['type'] = isset($temp_message[0]) ? $temp_message[0] : '';
				$return['message'] = isset($temp_message[1]) ? $temp_message[1] : '';

				unset($temp_message);
			}
		}

		// If message is empty, we need to check our own storage.
		if (empty($message)) {
			if (empty($this->message['message'])) {
				return '';
			}

			$return = $this->message;
		}

		// Clear our session data so we don't get extra messages on rare occassions.
		if (class_exists('CI_Session')) {
			$this->session->set_flashdata('message', '');
		}

		return $return;
	}

	//--------------------------------------------------------------------

	/**
	 * Attempts to get any information from php://input and return it
	 * as JSON data. This is useful when your javascript is sending JSON data
	 * to the application.
	 *
	 * @param  string $format The type of element to return, either 'object' or 'array'
	 * @param  int $depth The number of levels deep to decode
	 *
	 * @return mixed    The formatted JSON data, or NULL.
	 */
	public function get_json($format = 'object', $depth = 512)
	{
		$as_array = $format == 'array' ? true : false;

		return json_decode(file_get_contents('php://input'), $as_array, $depth);
	}

	//--------------------------------------------------------------------

	/**
	 * Adds an external javascript file to the 'external_scripts' array.
	 *
	 * @param string $filename File name to add
	 */
	public function add_script($filename)
	{
		if (strpos($filename, 'http') === FALSE) {
			$filename = base_url() . 'assets/js/' . $filename;
		}

		$this->external_scripts[] = $filename;
	}

	//--------------------------------------------------------------------

	//--------------------------------------------------------------------
	// 'Asset' functions
	//--------------------------------------------------------------------

	/**
	 * Adds an inline javascript to the 'inline_script' string.
	 *
	 * @param string $script the code of script
	 */
	public function add_inline_script($script)
	{
		$this->inline_script .= $script;
	}


	//--------------------------------------------------------------------

	/**
	 * Adds an external stylesheet file to the 'stylesheets' array.
	 *
	 * @param string $filename File name of stylesheet to add
	 */
	public function add_style($filename)
	{
		if (strpos($filename, 'http') === FALSE) {
			$filename = base_url() . 'assets/css/' . $filename;
		}

		$this->stylesheets[] = $filename;
	}

	//--------------------------------------------------------------------

	//--------------------------------------------------------------------
	// 'Asset' functions
	//--------------------------------------------------------------------

	/**
	 * Adds an inline stylesheet to the 'inline_style' string.
	 *
	 * @param string $style the code of style
	 */
	public function add_inline_style($style)
	{
		$this->inline_style .= $style;
	}

	//--------------------------------------------------------------------

	public function dmyToYmd($dmy)
	{
		$tgl = explode('-', $dmy);
		return $tgl[2] . '-' . $tgl[1] . '-' . $tgl[0];
	}

	//--------------------------------------------------------------------

	/**
	 * A Very simple templating system designed not for power or flexibility
	 * but to use the built in features of CodeIgniter's view system to easily
	 * create fast templating capabilities.
	 *
	 * The view is assumed to be under the views folder, under a folder with the
	 * name of the controller and a view matching the name of the method.
	 *
	 * The theme is simply a set of files located under the views/ui folder. By default
	 * a view named index.php will be used. You can specify different layouts
	 * with the scope method, 'layout()'.
	 *
	 *      $this->layout('two_left')->render();
	 *
	 * You can specify a non-default view name with the scope method 'view'.
	 *
	 *      $this->view('another_view')->render();
	 *
	 * Within the template the string '{view_content}' will be replaced with the
	 * contents of the view file that we're rendering.
	 *
	 * @param  [type]  $layout      [description]
	 * @param  boolean $return_data [description]
	 */
	protected function render($data = array())
	{
		// Calc our view name based on current method/controller
		$view = !empty($this->use_view) ? $this->use_view : $this->router->fetch_class() . '/' . $this->router->fetch_method();

		// Merge any saved vars into the data
		$data = array_merge($data, $this->vars);

		// Make sure any scripts/stylesheets are available to the view
		$data['external_scripts'] = $this->external_scripts;
		$data['inline_script'] = $this->inline_script;
		$data['stylesheets'] = $this->stylesheets;
		$data['inline_style'] = $this->inline_style;
		if (isset($this->use_title)) $data['title'] = $this->use_title;
		if (isset($this->menu_active)) $data['menu_active'] = $this->menu_active;

		// We'll make the view content available to the template.
		$data['view_content'] = $this->load->view($view, $data, true);

		// Build our notices from the theme's view file.
		$data['notice'] = $this->load->view('theme/notice', array('notice' => $this->message()), true);

		// Render our layout and we're done!
		$layout = !empty($this->use_layout) ? $this->use_layout : 'index';

		$this->load->view('theme/' . $layout, $data, false, true);

		// Reset our custom view attributes.
		$this->use_view = $this->use_layout = '';
	}

	public function ymdToDmy($ymd)
	{
		$tgl = explode('-', $ymd);
		return $tgl[2] . '-' . $tgl[1] . '-' . $tgl[0];
	}

}

//--------------------------------------------------------------------

/*
    AUTHENTICATED CONTROLLER

    Simply makes sure that someone is logged in and ready to roll.
 */

class Authenticated_Controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!$this->load->is_loaded('ion_auth'))
			$this->load->library('ion_auth');
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
			redirect('auth/login?redirect_to=' . current_url(), 'refresh');
		}
	}
}

class Member_Controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!$this->load->is_loaded('ion_auth'))
			$this->load->library('ion_auth');
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login?redirect_to=' . current_url(), 'refresh');
		}
	}
}
