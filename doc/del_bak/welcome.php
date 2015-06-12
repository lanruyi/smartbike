
class Welcome_controller extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
    function __construct(){
        parent::__construct();
		$this->load->helper('url');
    }


	public function index()
	{
        redirect('/frontend','local');
	}

	public function new_index()
	{

        $data['title'] = "welcome";
        $this->load->view('new_welcome',$data);

	}


	public function backend_home()
	{

        $data['title'] = "backend welcome";
        $this->load->view('templates/backend_header',$data);
        $this->load->view('welcome',$data);
        $this->load->view('templates/backend_footer',$data);
	}
	public function frontend_home()
	{

        $data['title'] = "frontend welcome";
        $this->load->view('templates/frontend_header',$data);
        $this->load->view('welcome',$data);
        $this->load->view('templates/frontend_footer',$data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
