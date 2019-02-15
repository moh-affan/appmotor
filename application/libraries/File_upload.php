<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * File upload library used to upload image and video 
 * This library supports image thumbnail and resize.
 *  
 * @author 		Amit
 * @version		1.0.0
 */
class file_upload
{
	function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->config('file_upload', TRUE);
		$this->ci->load->helper(array('form', 'url'));
		
		//Loading upload library without any configuration as we have to initialize $config according to type of upload 
		$this->ci->load->library('upload');
	}
	
	/**
	 * Image upload
	 *  
	 * We return result as array with one key file_name in both 
	 * condition. On success it holds file name on failure it
	 * holds FALSE.
	 * 
	 * On success it return array upload->data() with all the information of file uploaded.
	 * On failure it return array with error message as one element.
	 * 
	 * @param string $folder_name		Folder Name
	 * @param string $file_name			File Name
	 * @return array|multitype:boolean array
	 */
	function do_image_upload($file_name, $folder_name = '')
	{  
        $config['upload_path'] = $this->ci->config->item('upload_folder', 'file_upload').'/'.$folder_name;
        $config['allowed_types'] = $this->ci->config->item('image_upload_support', 'file_upload');  
        $config['max_size'] = $this->ci->config->item('image_upload_size', 'file_upload');
        $config['quality'] = $this->ci->config->item('quality', 'file_upload');
        $config['encrypt_name'] = TRUE;
        
        if($this->ci->config->item('set_max', 'file_upload'))
        {
	        $config['max_width'] = $this->ci->config->item('max_width', 'file_upload');
	        $config['max_height'] = $this->ci->config->item('max_height', 'file_upload');
        }                       
		
        //create dirctory if not exist
        if(!is_dir($config['upload_path']))
        {
        	 if(!mkdir($config['upload_path'],0777))
        	 	return $config['upload_path'];
        }
        
        //Re-initializing upload with image file configuration
        $this->ci->upload->initialize($config);
        if(!$this->ci->upload->do_upload($file_name))
        {	
        	$fInfo = array('file_name' => FALSE, 'error' => $this->ci->upload->display_errors());
        	return $fInfo;
        }  
        else 
        {  
        	$fInfo = $this->ci->upload->data(); 		
    		return $fInfo;
        }  
      
    }  
	
    /**
     * This functions resize original image file to new size according to size set in config file.
     *  
     * @param string $file_full_path		File path
     * @return boolean
     */
    function create_other_size($file_full_path)
    {
    	$config['image_library'] = 'gd2';
    	$config['source_image'] = $file_full_path;
    	$config['maintain_ratio'] = $this->ci->config->item('maintain_ratio', 'file_upload');;
    	$config['width'] = $this->ci->config->item('other_width', 'file_upload');
    	$config['height'] = $this->ci->config->item('other_height', 'file_upload');
    	
    	$this->ci->load->library('image_lib', $config);
    	if(!$this->ci->image_lib->resize())
    		return $this->ci->image_lib->display_errors();
    
    	return TRUE;
    }
    
    /**
     * This function creates thumbnail according to size set in config file..
     * 
     * @param string $file_full_path		File path
     * @return boolean
     */
    function create_thumbnail($file_full_path) 
    {  
        $config['image_library'] = 'gd2';  
        $config['source_image'] = $file_full_path;     
        $config['create_thumb'] = TRUE; 
        $config['thumb_marker'] = $this->ci->config->item('thumb_marker', 'file_upload');
        $config['maintain_ratio'] = $this->ci->config->item('maintain_ratio', 'file_upload');  
        $config['width'] = $this->ci->config->item('thumbnail_image_width', 'file_upload');  
        $config['height'] = $this->ci->config->item('thumbnail_image_height', 'file_upload');
        
        $this->ci->load->library('image_lib', $config);  
        if(!$this->ci->image_lib->resize()) 
        	return $this->ci->image_lib->display_errors();
        
       return TRUE;  
    } 
    
    /**
     * Video upload
     * 
     * We return result as array with one key file_name in both 
	 * condition. On success it holds file name on failure it
	 * holds FALSE.
     *
     * On success it return array upload->data() with all the information of file in it.
     * On failure it return array with error message as one element.
     *
     * @param string $folder_name		Folder Name
     * @param string $file_name			File Name
     * @return array|multitype:boolean array
     */
    function do_video_upload($file_name, $folder_name = '')
    {
    	$video_config['upload_path'] = $this->ci->config->item('upload_folder', 'file_upload').'/'.$folder_name;
    	$video_config['allowed_types'] = $this->ci->config->item('video_upload_support', 'file_upload');
    	$video_config['max_size'] = $this->ci->config->item('video_upload_size', 'file_upload');
    	
    	//Re-initializing upload with video file configuration
    	$this->ci->upload->initialize($video_config);
    	
    	if(!is_dir($video_config['upload_path']))
    	{
    		if(!mkdir($video_config['upload_path'],0777))
    			return $video_config['upload_path'];
    	}
    	
    	if(!$this->ci->upload->do_upload($file_name))
    	{
    		$fInfo = array('file_name' => FALSE, 'error' => $this->ci->upload->display_errors());
        	return $fInfo;
    	}
    	else
    	{
    		$fInfo = $this->ci->upload->data(); 		
    		return $fInfo;
    	}
    }
}

/* End of file File_upload.php */
/* Location: ./application/libraries/File_upload.php */