<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Announcement extends CI_Controller
{
	function _construct()
	{
		parent::construct();
	}
	function index()
	{
		$this->listing();	
	}
	function new_announcement()
	{
		if($this->session->userdata('cmsgovt'))
		{
			$this->load->model('admin/announcement_model');	
			$js=array("announcement","library");	
			$data=array(
				
				'inner_data'	=>	array('heading'=>'Add Announcement'),
				'body'			=>	'admin/add-announcement',
				'seo'			=>	array(
									'page_title'=>'',
									'meta_description'=>'',
									'meta_keywords'=>''
						),
				'js'			=>	$js,
				'istenderempty'=>$this->announcement_model->isannouncementempty('tender','2'),
				'isbidempty'=>$this->announcement_model->isannouncementempty('bid','2'),
				'isempanelmentempty'=>$this->announcement_model->isannouncementempty('empanelment','2'),
				'iscarrerempty'=>$this->announcement_model->isannouncementempty('carrer','2'),
				'gettenders'=>$this->announcement_model->getannouncement('tender','2'),
				'getbid'=>$this->announcement_model->getannouncement('bid','2'),
				'getempanelment'=>$this->announcement_model->getannouncement('empanelment','2'),
				'getcarrer'=>$this->announcement_model->getannouncement('carrer','2'),
				'getannouncementtype'=>$this->announcement_model->getannouncementtype('1'),		
				);
				$this->load->view('admin/full_template',$data);
		}
		else
			redirect(admin_base_path().'login','refresh');
	}
	function listing()
	{
		if($this->session->userdata('cmsgovt'))
		{
			$this->load->model('admin/announcement_model');		
			$announcementcount=$this->announcement_model->announcement_count(2);
			$listtendercount=$this->announcement_model->getlistannouncement('tender','2');
			$listcarrercount=$this->announcement_model->getlistannouncement('carrer','2');
			$listempanelmentcount=$this->announcement_model->getlistannouncement('empanelment','2');
			$listbidcount=$this->announcement_model->getlistannouncement('bid','2');
			$listbiddetails=$this->announcement_model->listannouncementdetails('bid','2');
			$listtenderdetails=$this->announcement_model->listannouncementdetails('tender','2');
			$listempanelmentdetails=$this->announcement_model->listannouncementdetails('empanelment','2');
			$listcarrerdetails=$this->announcement_model->listannouncementdetails('carrer','2');
			$js=array("announcement","library");
			$total_rows=$this->announcement_model->get_allannouncement_cnt('2');
			if($total_rows>0)
			{
					$per_page=10;
					$pages= ceil($total_rows/$per_page);
					if($this->input->post('page')) $page=$this->input->post('page'); else $page=1;
					if($page>$pages) $page=$pages; elseif($page<1) $page=1;
					$lower=($page-1)*$per_page;
					if(($lower+$per_page)>$total_rows) $limit=$total_rows-$lower; else $limit=$per_page;
					$listallannouncementdetails=$this->announcement_model->listallannouncementdetails('2',$lower,$limit);
					
			}
			else
			{
				$listallannouncementdetails=0;
				$pages=$page=$lower="";
			}
			$data=array(
		
				'inner_data'	=>	array('heading'=>'Announcements'),
				'body'			=>	'admin/announcement_list',
				'seo'			=>	array(
									'page_title'=>'',
									'meta_description'=>'',
									'meta_keywords'=>''
									),
				'listallannouncementdetails'=>$listallannouncementdetails,
				'total_rows'		=>	$total_rows,
				'pages'				=>	$pages,
				'page'				=>	$page,
				'lower'				=>	$lower,
				'url'				=>	admin_base_path().'announcement/listing/',
				'announcementcount'=>$announcementcount,
				'listtendercount'=>$listtendercount,
				'listcarrercount'=>$listcarrercount,
				'listempanelmentcount'=>$listempanelmentcount,
				'listbidcount'=>$listbidcount,
				'listbiddetails'=>$listbiddetails,
				'listcarrerdetails'=>$listcarrerdetails,
				'listempanelmentdetails'=>$listempanelmentdetails,
				'listtenderdetails'=>$listtenderdetails,
				
				'js'			=>	$js,
				
				);
				$this->load->view('admin/full_template',$data);
		}
		else
			redirect(admin_base_path().'login','refresh');
	}
	function detail_view($id)
	{
		if($this->session->userdata('cmsgovt'))
		{
			if($id=='' )
      		{
     			 show_404();
      		}
		else{
				$js=array("announcement","library");
				$this->load->model('admin/announcement_model');	
				$data=array(
				'inner_data'	=>	array('heading'=>'Announcement Details'),
				'body'			=>	'admin/announcement_detail_view',
				'seo'			=>	array(
				'page_title'=>'',
				'meta_description'=>'',
				'meta_keywords'=>'',
				),
				'announcements_details'=>$this->announcement_model->getoneannouncement($id,'2'),
				'getannouncementfile'=>$this->announcement_model->getannouncementfile($id,'1'),
				'js'			=>	$js,
				);
				if (empty($data['announcements_details']))
       			 {
                show_404();
       			 }
				$this->load->view('admin/full_template',$data);
			}
		}
		else
			redirect(admin_base_path().'login','refresh');
		
	}
	function detail_edit($id)
	{
		if($this->session->userdata('cmsgovt'))
		{
		if($id=='' )
      	{
      		show_404();
      	}
		else{
				
				$this->load->model('admin/announcement_model');		
				$js=array("announcement","library");
				$data=array(
					'inner_data'	=>	array('heading'=>'Announcement Edit'),
					'body'			=>	'admin/announcement_edit',
					'seo'			=>	array(
					'page_title'	=>'',
					'meta_description'=>'',
					'meta_keywords'	=>''
										),
					'js'			=>	$js,
					'announcements_details'=>$this->announcement_model->getoneannouncement($id,'2'),
					'istenderempty'=>$this->announcement_model->isannouncementempty('tender','2'),
					'isbidempty'=>$this->announcement_model->isannouncementempty('bid','2'),
					'isempanelmentempty'=>$this->announcement_model->isannouncementempty('empanelment','2'),
					'iscarrerempty'=>$this->announcement_model->isannouncementempty('carrer','2'),
					'gettenders'=>$this->announcement_model->getannouncement('tender','2'),
					'getbid'=>$this->announcement_model->getannouncement('bid','2'),
					'getempanelment'=>$this->announcement_model->getannouncement('empanelment','2'),
					'getcarrer'=>$this->announcement_model->getannouncement('carrer','2'),
					'getannouncementfile'=>$this->announcement_model->getannouncementfile($id,'1'),
					'getannouncementfilecount'=>$this->announcement_model->getannouncementfilecount($id,'1'),
					'getannouncementtype'=>$this->announcement_model->getannouncementtype('1'),		
				);
			if (empty($data['announcements_details']))
       		{
       			show_404();
       		}
			$this->load->view('admin/full_template',$data);
		}
	}
	else
		redirect(admin_base_path().'login','refresh');
	}

	function save()
		{
			if($this->session->userdata('cmsgovt'))
			{
				$this->add("add");
			}
			else
				redirect(admin_base_path().'login','refresh');
		}
	function update()
		{
			if($this->session->userdata('cmsgovt'))
			{
				$this->add("update");
			}	
			else
				redirect(admin_base_path().'login','refresh');
		}
	
	function add($action)
		{
			if($this->session->userdata('cmsgovt'))
			{
			
			$this->load->model('admin/announcement_model');	
		    $this->form_validation->set_rules('acaption','Announcement caption','trim|xss_clean|required');
		    $this->form_validation->set_rules('acaption','Announcement caption','trim|xss_clean|required');
			//$this->form_validation->set_rules('address','Address','trim|xss_clean|required|max_length[2000]');
			//$this->form_validation->set_rules('email','email','trim|xss_clean|required|max_length[200]');
			if($this->form_validation->run()==FALSE)
			{	
				$this->new_announcement();
				
			} 
			else
			{
				$baseurl=base_url();
				if($this->input->post('sublink')==0)
				{
					if(!empty($_FILES['captionfile']['name']))
						{
								$filetemp=$_FILES["captionfile"]["tmp_name"];
								$captionfilename=$_FILES["captionfile"]["name"];
								$file_ext=explode('.',$captionfilename);
								$file_ext=strtolower(end($file_ext));
								$allowed=array('PDF','DOC','DOCX','docx','doc','pdf');
								
								$ext = strrchr($captionfilename, '.');
								$prefix = substr($captionfilename, 0, -strlen($ext));	
								$i = 0;
								while(file_exists("documents/".$captionfilename)) 
								{ 
									$captionfilename = $prefix . ++$i . $ext;
								}
								if(in_array($file_ext,$allowed))
								{
									$filepath="documents/".$captionfilename;
									move_uploaded_file($filetemp,$filepath);
								}
						 }
					else{
							if($this->input->post('captionurl')!="")
							{
								$captionfilename=='';
							}
							else{
								$captionfilename=$this->input->post('olddocument');
							}
						}
						
						}	
						if($action=='add')
						{
							$this->announcement_model->addannouncement($action,$captionfilename);
						}
						if($action=='update')
						{
							$this->announcement_model->addannouncement($action,$captionfilename);
							
						}
						$go_to=admin_base_path()."announcement/listing";
						if($action=='add')
						{
							$msg="Succesfully Added ";
															
						}
						if($action=='update')
						{
							$msg="Succesfully Updated ";
															
						}
						$sess_array=array(
											'message' =>$msg,
											'go_to_page' => $go_to,
										);
						$this->session->set_userdata($sess_array);
						redirect(admin_base_path().'message','refresh');
			}
		}
		else
			redirect(admin_base_path().'login','refresh');
	}

	function remove_attachment() 
	{
		if($this->session->userdata('cmsgovt'))
		{
			$id=$this->input->post('attachment_id');
			$data=array(
						'status'	=> '2',
						);
			$this->db->where('id',$id);
			$this->db->update('tb_announcements_file',$data);
			exit;									
		}			      
		else
			redirect(admin_base_path().'login','refresh');						      				    
	}

	function changestatus_announcement() 
	{
		
		$status= $this->input->post('status');
		$id=$this->input->post('announcement_id');
		if($status=='2')
		{
			$data_added='deleted_on';
			$data_ip='deleted_by_ip';
			$data_added_by='deleted_by';
			$data=array(
					$data_added => date('Y-m-d H:i:s'),
					$data_ip 	=> $this->input->ip_address(),
					'status'	=> $status,
					
					);
		}
		else{
		$data=array(
					'status'	=> $status,
					);
			}
		$this->db->where('id',$id);
		$this->db->update('tb_announcements',$data);
		echo $status;
							    
	}
	function display_order_announcement() 
	{
		$this->load->model('admin/announcement_model');	
		$selected= $this->input->post('selected');
		$display_order=$this->input->post('announcement_order');
					$data1=array(
								'announcements'=>$this->announcement_model->getannouncement($selected,'2'),
								'selectedone'=>$this->announcement_model-> getmaxdisplay($selected,$display_order),
								'announcement_caption'=>$this->input->post('announcement_caption'),
								);
					$filter_view=$this->load->view('admin/displayorder', $data1);
					echo json_encode($filter_view);
							    
	}
}
?>
