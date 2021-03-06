<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Public_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('admin/setting_model');
    $this->load->model('prefs_model');
    $this->lang->load('auth');
    $this->lang->load('admin/users');
    if($this->ion_auth->logged_in()){
      $this->data['user_login']=$this->prefs_model->user_info_login($this->ion_auth->user()->row()->id);
    }
    $this->data['title']               = $this->config->item('title');
            $this->data['title_lg']            = $this->config->item('title_lg');
            $this->data['auth_social_network'] = $this->config->item('auth_social_network');
            $this->data['forgot_password']     = $this->config->item('forgot_password');
            $this->data['new_membership']      = $this->config->item('new_membership');
    $this->data['setting']=$this->setting_model->all();
    $this->data['vuecomp']='home.js';
    $this->load->model('exchanges_model');
  }

	public function index()
	{ 
    $this->__randerview('index', $this->data);
	}

  public function exchange()
  { 
    $this->load->view('exchange', $this->data);
  }

  public function contact($value='')
  {
    $this->__randerview('contact', $this->data);
  }

  public function recerve($value='',$adasd)
  { 
    $this->db->where('id', $adasd);
    $ddddddd=$this->db->get('gateways')->row();
    echo json_encode($ddddddd);
  }

  public function paymentproff($value='')
  {
    $this->load->library("pagination");
    $this->load->helper("url");
    $config['base_url']    = base_url().'home/paymentproff/index';
    $config['uri_segment'] = 4;
    $config['total_rows']  = $this->exchanges_model->record_count();
    $config['per_page']    = 10;
      //styling
    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>'; 
    $config['num_tag_open'] = '<li class="page-item">';
    $config['num_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['next_tag_open'] = '<li class="page-item">';
    $config['next_tagl_close'] = '</a></li>';
    $config['prev_tag_open'] = '<li class="page-item">';
    $config['prev_tagl_close'] = '</li>';
    $config['first_tag_open'] = '<li class="page-item disabled">';
    $config['first_tagl_close'] = '</li>';
    $config['last_tag_open'] = '<li class="page-item">';
    $config['last_tagl_close'] = '</a></li>';
    $config['attributes'] = array('class' => 'page-link');
    $this->pagination->initialize($config);
    $page = $this->uri->segment(4);
    $offset = !$page?0:$page;
    $start = $offset;
    $limit = 8;
    $this->data['results'] = $this->exchanges_model->fetch_exchanges($limit,$start);
    $this->data['start'] = $start;
    $this->__randerview('paymentproff', $this->data);
  }

  public function affiliate($value='')
  {
    $this->__randerview('affiliate', $this->data);
  }

  public function tutorial($value='')
  {
    $this->db->where('status',2);
    $this->data['info']=$this->db->get('faqandtutorial')->result();
    $this->__randerview('tutorial', $this->data);
  }

  public function faq($value='')
  {
    $this->db->where('status',1);
    $this->data['info']=$this->db->get('faqandtutorial')->result();
    $this->__randerview('faq', $this->data);
  }

  public function about($value='')
  {
    $this->__randerview('about', $this->data);
  }

  public function testimonials($value='')
  {
    $this->__randerview('testimonials', $this->data);
  }

  public function termsofservices($value='')
  {
    $this->__randerview('termsofservices', $this->data);
  }

  public function privacypolicy($value='')
  {
    $this->__randerview('privacypolicy', $this->data);
  }

  public function regirter($value='')
  {
    if(!$this->ion_auth->logged_in()){
     $this->__randerview('registation', $this->data);
    }else{
      redirect('home','refresh');
    }
  }

  public function login($value='')
  {
    if(!$this->ion_auth->logged_in()){
     $this->__randerview('login', $this->data);
    }else{
      redirect('home','refresh');
    }
  }

  public function allfeedback()
  {
    $this->load->library("pagination");
    $this->load->helper("url");
    $config['base_url']    = base_url().'home/allfeedback';
    $config['uri_segment'] = 3;
    $config['total_rows']  = $this->db->count_all("testimonials");
    $config['per_page']    = 10;
      //styling
    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>'; 
    $config['num_tag_open'] = '<li class="page-item">';
    $config['num_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['next_tag_open'] = '<li class="page-item">';
    $config['next_tagl_close'] = '</a></li>';
    $config['prev_tag_open'] = '<li class="page-item">';
    $config['prev_tagl_close'] = '</li>';
    $config['first_tag_open'] = '<li class="page-item disabled">';
    $config['first_tagl_close'] = '</li>';
    $config['last_tag_open'] = '<li class="page-item">';
    $config['last_tagl_close'] = '</a></li>';
    $config['attributes'] = array('class' => 'page-link');
    $this->pagination->initialize($config);
    $page = $this->uri->segment(4);
    $offset = !$page?0:$page;
    $start = $offset;
    $limit = 8;

    $this->db->join('users', 'users.id = testimonials.user_id');
    $this->db->order_by("testimonials.id", "desc");
    $this->db->where('testimonials.status', 1);
    $this->db->limit($limit, $start);
    $this->data['results'] = $this->db->get("testimonials")->result();
    $this->data['start'] = $start;
    $this->__randerview('allfeedback', $this->data);
  }

  // forgot password
  public function forgerpassword()
  {
    // setting validation rules by checking wheather identity is username or email
    if($this->config->item('identity', 'ion_auth') != 'email' )
    {
       $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
    }
    else
    {
       $this->form_validation->set_rules('email', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
    }


    if ($this->form_validation->run() == false)
    {
      // setup the input
      $this->data['email'] = array('name' => 'email',
        'id' => 'email',
      );

      if ( $this->config->item('identity', 'ion_auth') != 'email' ){
        $this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
      }
      else
      {
        $this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
      }

      // set any errors and display the form
      $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
     $this->__randerview('profile/forgerpassword', $this->data);
    }
    else
    {
      $identity_column = $this->config->item('identity','ion_auth');
      $identity = $this->ion_auth->where($identity_column, $this->input->post('email'))->users()->row();

      if(empty($identity)) {

                  if($this->config->item('identity', 'ion_auth') != 'email')
                  {
                    $this->ion_auth->set_error('forgot_password_identity_not_found');
                  }
                  else
                  {
                     $this->ion_auth->set_error('forgot_password_email_not_found');
                  }

                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                    redirect("home/forgerpassword", 'refresh');
                }

      // run the forgotten password method to email an activation code to the user
      $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});
      if ($forgotten)
      {
        // if there were no errors
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        var_dump($this->ion_auth->messages());
        redirect("home", 'refresh'); //we should display a confirmation page here instead of the login page
      }
      else
      {
        $this->session->set_flashdata('message', "A verification code send to your email please check your email");
        var_dump($this->ion_auth->errors());
        redirect("home/forgerpassword", 'refresh');
      }
    }
  }

    // reset password - final step for forgotten password
  public function reset_password($code = NULL)
  {
    if (!$code)
    {
      show_404();
    }

    $user = $this->ion_auth->forgotten_password_check($code);

    if ($user)
    {
      // if the code is valid then display the password reset form

      $this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
      $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

      if ($this->form_validation->run() == false)
      {
        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

        $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
        $this->data['new_password'] = array(
          'name' => 'new',
          'id'   => 'new',
          'type' => 'password',
          'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
        );
        $this->data['new_password_confirm'] = array(
          'name'    => 'new_confirm',
          'id'      => 'new_confirm',
          'type'    => 'password',
          'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
        );
        $this->data['user_id'] = array(
          'name'  => 'user_id',
          'id'    => 'user_id',
          'type'  => 'hidden',
          'value' => $user->id,
        );
        $this->data['csrf'] = $this->_get_csrf_nonce();
        $this->data['code'] = $code;

        // render
        $this->__randerview('auth/reset_password', $this->data);
      }
      else
      {
        if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id'))
        {
          $this->ion_auth->clear_forgotten_password_code($code);
          show_error($this->lang->line('error_csrf'));
        }
        else
        {
          $identity = $user->{$this->config->item('identity', 'ion_auth')};
          $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));
          if ($change)
          {
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("home", 'refresh');
          }
          else
          {
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect('home/reset_password/' . $code, 'refresh');
          }
        }
      }
    }
    else
    {
      $this->session->set_flashdata('message', $this->ion_auth->errors());
      redirect("home/forgerpassword", 'refresh');
    }
  }

  function _get_csrf_nonce()
  {
    $this->load->helper('string');
    $key   = random_string('alnum', 8);
    $value = random_string('alnum', 20);
    $this->session->set_flashdata('csrfkey', $key);
    $this->session->set_flashdata('csrfvalue', $value);

    return array($key => $value);
  }

  function _valid_csrf_nonce()
  {
    if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
      $this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
    {
      return TRUE;
    }
    else
    {
      return TRUE;
    }
  }

  public function getsend($value='')
  {
    $this->db->where('allow_send', 1);
    $this->db->join('currency', 'currency.currency_id = gateways.currency');
    $data=$this->db->get('gateways')->result();
    echo json_encode($data);
  }

  public function getrecive($value='')
  {
    $this->db->where('allow_receive', 1);
    $this->db->join('currency', 'currency.currency_id = gateways.currency');
    $data=$this->db->get('gateways')->result();
    echo json_encode($data);
  }
}
